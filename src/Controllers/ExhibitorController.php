<?php

namespace Fieroo\Exhibitors\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Fieroo\Bootstrapper\Models\Setting;
use Fieroo\Bootstrapper\Models\User;
use Fieroo\Exhibitors\Models\Exhibitor;
use Fieroo\Exhibitors\Models\ExhibitorDetail;
use Fieroo\Payment\Models\Payment;
use Spatie\SimpleExcel\SimpleExcelWriter;
use \Carbon\Carbon;
use Validator;
use Mail;
use Auth;
use DB;

class ExhibitorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function compileData()
    {
        $auth = Auth::user();
        $user = User::findOrFail($auth->id);
        App::setLocale($user->exhibitor->locale);
        return view('exhibitors::compile-data', ['locale' => $user->exhibitor->locale]);
    }

    public function pendingAdmission()
    {
        $auth = Auth::user();
        $user = User::findOrFail($auth->id);
        App::setLocale($user->exhibitor->locale);
        return view('exhibitors::pending-admission');
    }

    public function sendFormCompileData(Request $request)
    {
        $response = [
            'status' => false,
            'message' => trans('api.error_general'),
        ];

        try {
            $validation_data = [
                'company' => ['required', 'string', 'max:255'],
                'address' => ['required', 'string', 'max:255'],
                'civic_number' => ['required', 'string', 'max:255'],
                'city' => ['required', 'string', 'max:255'],
                'cap' => ['required', 'string', 'max:255'],
                'province' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'string', 'max:255'],
                'responsible' => ['required', 'string', 'max:255'],
                'phone_responsible' => ['required', 'string', 'max:255'],
                'vat_number' => ['required', 'string', 'max:255'],
                'diff_billing' => ['required', 'boolean'],
                'accept_stats' => ['required', 'boolean'],
                'accept_marketing' => ['required', 'boolean'],
                'locale' => ['required', 'string', 'max:2'],
            ];

            if($request->locale == 'it') {
                $validation_data['uni_code'] = ['required', 'string', 'max:255'];
            }
    
            $validator = Validator::make($request->all(), $validation_data);
    
            if ($validator->fails()) {
                $response['message'] = trans('api.error_validation_required_fields');
                return response()->json($response);
            }

            $auth = Auth::user();
            $user = User::findOrFail($auth->id);

            if(!is_null($user->exhibitor->detail)) {
                $response['message'] = trans('api.error_exhibitor_detail_already_exists');
                return response()->json($response);
            }

            // link exhibitor data
            $exhibitor_data = DB::table('exhibitors_data')->insert([
                'exhibitor_id' => $user->exhibitor->id,
                'company' => $request->company,
                'address' => $request->address,
                'civic_number' => $request->civic_number,
                'city' => $request->city,
                'cap' => $request->cap,
                'province' => $request->province,
                'phone' => $request->phone,
                'fax' => $request->fax,
                'web' => $request->web,
                'responsible' => $request->responsible,
                'phone_responsible' => $request->phone_responsible,
                'email_responsible' => $user->email,
                'fiscal_code' => $request->fiscal_code,
                'vat_number' => $request->vat_number,
                'uni_code' => $request->uni_code,
                'receiver' => $request->receiver,
                'receiver_address' => $request->receiver_address,
                'receiver_civic_number' => $request->receiver_civic_number,
                'receiver_city' => $request->receiver_city,
                'receiver_cap' => $request->receiver_cap,
                'receiver_province' => $request->receiver_province,
                'receiver_fiscal_code' => $request->receiver_fiscal_code,
                'receiver_vat_number' => $request->receiver_vat_number,
                'receiver_uni_code' => $request->receiver_uni_code,
                'diff_billing' => $request->diff_billing,
                'accept_stats' => $request->accept_stats,
                'accept_marketing' => $request->accept_marketing,
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()')
            ]);

            // $exhibitor = Exhibitor::findOrFail($user->exhibitor->id);
            // $data = [
            //     'responsible' => $request->responsible,
            //     'locale' => $exhibitor->locale,
            //     'company' => $request->company
            // ];

            $setting = Setting::take(1)->first();

            $body = formatDataForEmail([
                'responsible' => $request->responsible,
            ], $user->exhibitor->locale == 'it' ? $setting->email_pending_admit_exhibitor_it : $setting->email_pending_admit_exhibitor_en);

            $data = [
                'body' => $body
            ];
            
            $email_from = env('MAIL_FROM_ADDRESS');
            $email_to = $user->email;
            $subject = trans('emails.pending_exhibitor', [], $user->exhibitor->locale);
            // Mail::send('emails.pending-admit-exhibitor', ['data' => $data], function ($m) use ($email_from, $email_to, $subject) {
            //     $m->from($email_from, env('MAIL_FROM_NAME'));
            //     $m->to($email_to)->subject(env('APP_NAME').' '.$subject);
            // });
            Mail::send('emails.form-data', ['data' => $data], function ($m) use ($email_from, $email_to, $subject) {
                $m->from($email_from, env('MAIL_FROM_NAME'));
                $m->to($email_to)->subject(env('APP_NAME').' '.$subject);
            });

            // send notification to admin
            $body = formatDataForEmail([
                'responsible' => $request->responsible,
                'company' => $request->company
            ], $setting->email_to_admin_pending_notification_admit);

            $data = [
                'body' => $body
            ];
            // Mail::send('emails.pending-notification-admit', ['data' => $data], function ($m) use ($email_from) {
            //     $m->from($email_from, 'Espositore - Pending');
            //     $m->to(env('MAIL_CONTABILITA'))->subject('Notifica Invio fattura a Espositore');
            // });
            Mail::send('emails.form-data', ['data' => $data], function ($m) use ($email_from) {
                $m->from($email_from, 'Espositore - Pending');
                $m->to(env('MAIL_CONTABILITA'))->subject('Espositore in attesa di ammissione');
            });

            $response['status'] = true;
            $response['message'] = trans('forms.exhibitor_form.save_compile_data');
            
            return response()->json($response);

        } catch(\Exception $e) {
            $response['message'] = $e->getMessage();
            return response()->json($response);
        }
    }

    /**
     * Show the exhibitors without company data
     *
     * @return \Illuminate\Http\Response
     */
    public function incompleteData()
    {
        return view('exhibitors::incomplete');
    }

    public function getAjaxListIncompleted(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value
        
        $exhibitors = DB::table('exhibitors')->count();
        $exhibitors_data = DB::table('exhibitors_data')->count();
        $totalRecords = $exhibitors - $exhibitors_data;

        $_totalRecordswithFilter = DB::table('exhibitors')
            ->leftJoin('users', 'exhibitors.user_id', '=', 'users.id')
            ->where(function($query) use ($searchValue){
                $query->where('users.email', 'LIKE', '%'.$searchValue.'%');
            })
            ->count();

        $__totalRecordswithFilter = DB::table('exhibitors_data')
            ->leftJoin('exhibitors', 'exhibitors_data.exhibitor_id', '=', 'exhibitors.id')
            ->leftJoin('users', 'exhibitors.user_id', '=', 'users.id')
            ->where(function($query) use ($searchValue){
                $query->where('users.email', 'LIKE', '%'.$searchValue.'%');
            })
            ->count();

        $totalRecordswithFilter = $_totalRecordswithFilter - $__totalRecordswithFilter;
            
        $_records = DB::table('exhibitors')
            ->leftJoin('users', 'exhibitors.user_id', '=', 'users.id')
            ->where(function($query) use ($searchValue){
                $query->where('users.email', 'LIKE', '%'.$searchValue.'%');
            })
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->select('exhibitors.*', 'users.email as email')
            ->get()
            ->toArray();

        $__records = DB::table('exhibitors_data')
            ->leftJoin('exhibitors', 'exhibitors_data.exhibitor_id', '=', 'exhibitors.id')
            ->leftJoin('users', 'exhibitors.user_id', '=', 'users.id')
            ->where(function($query) use ($searchValue){
                $query->where('users.email', 'LIKE', '%'.$searchValue.'%');
            })
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->select('exhibitors.*', 'users.email as email')
            ->get()
            ->toArray();

        $diff = array_diff(array_map('json_encode', $_records), array_map('json_encode', $__records));
        $no_data = array_map('json_decode', $diff);


        $data_arr = array();
        $sno = $start+1;
        foreach($no_data as $record){
            $data_arr[] = array(
                'id' => $record->id,
                "email" => $record->email,
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        return response()->json($response);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('exhibitors::index');
    }

    public function getAjaxList(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value
        
        $totalRecords = ExhibitorDetail::count();

        $totalRecordswithFilter = ExhibitorDetail::where(function($query) use ($searchValue){
            $query->where('email_responsible', 'LIKE', '%'.$searchValue.'%')
                  ->orWhere('company', 'LIKE', '%'.$searchValue.'%');
        })->count();
            
        $records = DB::table('exhibitors_data')
            ->leftJoin('exhibitors', 'exhibitors_data.exhibitor_id', '=', 'exhibitors.id')
            ->leftJoin('users', 'exhibitors.user_id', '=', 'users.id')
            ->where(function($query) use ($searchValue){
                $query->where('users.email', 'LIKE', '%'.$searchValue.'%')
                      ->orWhere('exhibitors_data.company', 'LIKE', '%'.$searchValue.'%');
            })
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->select('exhibitors_data.*', 'users.email as email', 'users.id as user_id')
            ->get();

        $data_arr = array();
        $sno = $start+1;
        foreach($records as $record){

            $data_arr[] = array(
                'id' => $record->id,
                'exhibitor_id' => $record->exhibitor_id,
                "company" => $record->company,
                "email" => $record->email,
                "is_admitted" => $record->is_admitted,
                "n_events" => Payment::where([
                    ['user_id','=',$record->user_id],
                    ['type_of_payment','=','subscription']
                ])->count(),
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        return response()->json($response);
    }

    public function indexEvents($id)
    {
        $exhibitor = Exhibitor::findOrFail($id);
        $list = DB::table('events')
            ->leftJoin('payments','events.id','=','payments.event_id')
            ->where([
                ['payments.user_id','=',$exhibitor->user_id],
                ['payments.type_of_payment','=','subscription']
            ])
            ->select('events.*')
            ->get();
        
        $exhibitor_data = DB::table('exhibitors_data')->where('exhibitor_id','=',$exhibitor->id)->first();
        
        return view('exhibitors::events', ['list' => $list, 'exhibitor_data' => $exhibitor_data, 'user_id' => $exhibitor->user_id]);
    }

    public function recapEvent($exhibitor_id, $event_id)
    {
        $orders = DB::table('orders')
            ->leftJoin('furnishings_translations','orders.furnishing_id','=','furnishings_translations.furnishing_id')
            ->where([
                ['orders.exhibitor_id','=',$exhibitor_id],
                ['orders.event_id','=',$event_id],
                ['furnishings_translations.locale','=',App::getLocale()]
            ])
            ->select('orders.furnishing_id', DB::raw('sum(qty) as qty'), DB::raw('sum(price) as price'), 'furnishings_translations.description')
            ->groupBy('orders.furnishing_id','furnishings_translations.description')
            ->get();

        $exhibitor = Exhibitor::findOrFail($exhibitor_id);

        $payment_data = DB::table('payments')->where([
            ['event_id','=',$event_id],
            ['user_id','=',$exhibitor->user_id],
            ['type_of_payment','=','subscription']
        ])->first();
        if(!is_object($payment_data)) {
            abort(404);
        }

        $extra_furnishings_payment = DB::table('payments')->where([
            ['event_id','=',$event_id],
            ['user_id','=',$exhibitor->user_id],
            ['type_of_payment','=','furnishing']
        ])->first();
        $extra = 0;
        if(is_object($extra_furnishings_payment)) {
            $extra = $extra_furnishings_payment->amount;
        }

        $n_modules = $payment_data->n_modules;
        $amount = $payment_data->amount;

        $stand_trans = DB::table('stands_types_translations')->where([
            ['locale','=',App::getLocale()],
            ['stand_type_id','=',$payment_data->stand_type_id],
        ])->first();
        if(!is_object($stand_trans)) {
            abort(404);
        }

        return view('events::recap', [
            'extra' => $extra,
            'orders' => $orders,
            'n_modules' => $n_modules,
            'amount' => $amount,
            'stand_name' => $stand_trans->name,
            'back_url' => 'admin/exhibitor/'.$exhibitor_id.'/events'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $settings = Setting::take(1)->first();
        $stands_types = DB::table('stands_types_translations')->where('locale', '=', App::getLocale())->get();
        return view('exhibitors::create', [
            'stands_types' => $stands_types,
            'form_radio_text_1' => App::getLocale() == 'it' ? $settings->expo_form_radio_text_1_it : $settings->expo_form_radio_text_1_en,
            'form_radio_text_2' => App::getLocale() == 'it' ? $settings->expo_form_radio_text_2_it : $settings->expo_form_radio_text_2_en,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { // valutare se tenerla o rimuoverla perchè prima di creare espositore bisognerebbe creare l'utente e poi il resto va in relazione
        $validation_data = [
            //'already_expo' => ['required'],
            //'select_brand' => ['required', 'exists:stands_types,id'],
            'company' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'civic_number' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'cap' => ['required', 'string', 'max:255'],
            'province' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'responsible' => ['required', 'string', 'max:255'],
            'phone_responsible' => ['required', 'string', 'max:255'],
            'email_responsible' => ['required', 'email', 'confirmed', 'unique:exhibitors_data,email_responsible'],
            'vat_number' => ['required', 'string', 'max:255'],
            'diff_billing' => ['required'],
            //'n_modules' => ['required'],
            'accept_stats' => ['required'],
            'accept_marketing' => ['required'],
            'locale' => ['required']
        ];

        if($request->locale == 'it') {
            $validation_data['uni_code'] = ['required', 'string', 'max:255'];
        }

        $validator = Validator::make($request->all(), $validation_data);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
            
        try {
            
            // create exhibitor
            $exhibitor = Exhibitor::create();

            // link exhibitor data
            $exhibitor_data = DB::table('exhibitors_data')->insert([
                'exhibitor_id' => $exhibitor->id,
                //'already_expo' => $request->already_expo == 'yes' ? 1 : 0,
                //'stand_type_id' => $request->select_brand,
                'company' => $request->company,
                'address' => $request->address,
                'civic_number' => $request->civic_number,
                'city' => $request->city,
                'cap' => $request->cap,
                'province' => $request->province,
                'phone' => $request->phone,
                'fax' => $request->fax,
                'web' => $request->web,
                'responsible' => $request->responsible,
                'phone_responsible' => $request->phone_responsible,
                'email_responsible' => $request->email_responsible,
                'fiscal_code' => $request->fiscal_code,
                'vat_number' => $request->vat_number,
                'uni_code' => $request->uni_code,
                'receiver' => $request->receiver,
                'receiver_address' => $request->receiver_address,
                'receiver_civic_number' => $request->receiver_civic_number,
                'receiver_city' => $request->receiver_city,
                'receiver_cap' => $request->receiver_cap,
                'receiver_province' => $request->receiver_province,
                'receiver_fiscal_code' => $request->receiver_fiscal_code,
                'receiver_vat_number' => $request->receiver_vat_number,
                'receiver_uni_code' => $request->receiver_uni_code,
                'diff_billing' => $request->diff_billing == 'yes' ? 1 : 0,
                //'n_modules' => $request->n_modules,
                'accept_stats' => $request->accept_stats == 'yes' ? 1 : 0,
                'accept_marketing' => $request->accept_marketing == 'yes' ? 1 : 0,
                //'locale' => $request->locale,
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()')
            ]);

            $entity_name = trans('entities.exhibitor');
            return redirect('admin/exhibitors')->with('success', trans('forms.updated_success',['obj' => $entity_name]));

        } catch(\Exception $e) {
            return redirect()
                ->back()
                ->withErrors($e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /*
        $exhibitor = DB::table('exhibitors_data')
            ->leftJoin('stands_types_translations', 'exhibitors_data.stand_type_id', '=', 'stands_types_translations.stand_type_id')
            ->where([
                ['exhibitors_data.id', '=', $id],
                ['stands_types_translations.locale', '=', App::getLocale()]
            ])
            ->select('exhibitors_data.*', 'stands_types_translations.name as stand_name', 'stands_types_translations.price as stand_price')
            ->first();
        */
        $exhibitor = DB::table('exhibitors_data')
            ->leftJoin('exhibitors', 'exhibitors_data.exhibitor_id', '=', 'exhibitors.id')
            ->where('exhibitors_data.id','=',$id)
            ->select('exhibitors_data.*', 'exhibitors.locale as locale')
            ->first();
        //$stands_types = DB::table('stands_types_translations')->where('locale', '=', App::getLocale())->get();
        //return view('exhibitors::show', ['exhibitor' => $exhibitor, 'stands_types' => $stands_types]);
        return view('exhibitors::show', ['exhibitor' => $exhibitor]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        /*
        $exhibitor = DB::table('exhibitors_data')
            ->leftJoin('stands_types_translations', 'exhibitors_data.stand_type_id', '=', 'stands_types_translations.stand_type_id')
            ->where([
                ['exhibitors_data.id', '=', $id],
                ['stands_types_translations.locale', '=', App::getLocale()]
            ])
            ->select('exhibitors_data.*', 'stands_types_translations.name as stand_name', 'stands_types_translations.price as stand_price')
            ->first();
        */
        $exhibitor = DB::table('exhibitors_data')
            ->leftJoin('exhibitors', 'exhibitors_data.exhibitor_id', '=', 'exhibitors.id')
            ->where('exhibitors_data.id','=',$id)
            ->select('exhibitors_data.*', 'exhibitors.locale as locale')
            ->first();
        //$stands_types = DB::table('stands_types_translations')->where('locale', '=', App::getLocale())->get();
        //return view('exhibitors::edit', ['exhibitor' => $exhibitor, 'stands_types' => $stands_types]);
        return view('exhibitors::edit', ['exhibitor' => $exhibitor]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validation_data = [
            //'already_expo' => ['required'],
            //'select_brand' => ['required', 'exists:stands_types,id'],
            'company' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'civic_number' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'cap' => ['required', 'string', 'max:255'],
            'province' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'responsible' => ['required', 'string', 'max:255'],
            'phone_responsible' => ['required', 'string', 'max:255'],
            //'email_responsible' => ['required', 'email', 'unique:exhibitors_data,email_responsible,'.$id],
            'vat_number' => ['required', 'string', 'max:255'],
            'diff_billing' => ['required'],
            //'n_modules' => ['required'],
        ];

        if($request->locale == 'it') {
            $validation_data['uni_code'] = ['required', 'string', 'max:255'];
        }

        $validator = Validator::make($request->all(), $validation_data);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $exhibitor_data = DB::table('exhibitors_data')->where('id', '=', $id);

            $record = $exhibitor_data->first();
            
            $upd_exhibitor = $exhibitor_data->update([
                //'already_expo' => $request->already_expo == 'yes' ? 1 : 0,
                //'stand_type_id' => $request->select_brand,
                'company' => $request->company,
                'address' => $request->address,
                'civic_number' => $request->civic_number,
                'city' => $request->city,
                'cap' => $request->cap,
                'province' => $request->province,
                'phone' => $request->phone,
                'fax' => $request->fax,
                'web' => $request->web,
                'responsible' => $request->responsible,
                'phone_responsible' => $request->phone_responsible,
                //'email_responsible' => $request->email_responsible,
                'fiscal_code' => $request->fiscal_code,
                'vat_number' => $request->vat_number,
                'uni_code' => $request->uni_code,
                'receiver' => $request->receiver,
                'receiver_address' => $request->receiver_address,
                'receiver_civic_number' => $request->receiver_civic_number,
                'receiver_city' => $request->receiver_city,
                'receiver_cap' => $request->receiver_cap,
                'receiver_province' => $request->receiver_province,
                'receiver_fiscal_code' => $request->receiver_fiscal_code,
                'receiver_vat_number' => $request->receiver_vat_number,
                'receiver_uni_code' => $request->receiver_uni_code,
                'diff_billing' => $request->diff_billing == 'yes' ? 1 : 0,
                //'n_modules' => $request->n_modules,
                'updated_at' => DB::raw('NOW()')
            ]);

            $entity_name = trans('entities.exhibitor');
            return redirect('admin/exhibitors/'.$id.'/edit')->with('success', trans('forms.updated_success',['obj' => $entity_name]));

        } catch(\Exception $e) {
            return redirect()
                ->back()
                ->withErrors($e->getMessage())
                ->withInput();
        }
    }

    public function getSelectList()
    {
        $response = [
            'status' => false
        ];

        try {
            $response['status'] = true;
            $response['data'] = DB::table('exhibitors_data')->select('exhibitor_id','company')->get();
            return response()->json($response);
        } catch(\Exception $e){
            $response['message'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function admit(Request $request, $id)
    {
        $response = [
            'status' => false,
            'message' => trans('api.error_general')
        ];

        try {

            if (!isset($id) || strlen($id) <= 0) {
                $response['message'] = trans('api.error_validation');
                return response()->json($response);
            }

            $exhibitor = Exhibitor::findOrFail($id);

            $user = User::findOrFail($exhibitor->user_id);
            
            $exhibitor_data_q = DB::table('exhibitors_data')->where('exhibitor_id', '=', $id);
            $exhibitor_data = $exhibitor_data_q->first();
            if(!is_object($exhibitor_data)) {
                $obj = trans('entities.exhibitor');
                $response['message'] = trans('api.obj_not_found', ['obj' => $obj]);
                return response()->json($response);
            }

            $upd_exhibitor = $exhibitor_data_q->update([
                'is_admitted' => 1
            ]);

            // $data = [
            //     'responsible' => $exhibitor_data->responsible,
            //     'locale' => $exhibitor->locale,
            //     'company' => $exhibitor_data->company,
            // ];
            
            $setting = Setting::take(1)->first();

            $body = formatDataForEmail([
                'responsible' => $exhibitor_data->responsible,
            ], $exhibitor->locale == 'it' ? $setting->email_admit_exhibitor_it : $setting->email_admit_exhibitor_en);

            $data = [
                'body' => $body
            ];

            $email_from = env('MAIL_FROM_ADDRESS');
            $email_to = $user->email;
            $subject = trans('emails.confirm_account', [], $exhibitor->locale);
            // Mail::send('emails.admit-exhibitor', ['data' => $data], function ($m) use ($email_from, $email_to, $subject) {
            //     $m->from($email_from, env('MAIL_FROM_NAME'));
            //     $m->to($email_to)->subject(env('APP_NAME').' '.$subject);
            // });
            Mail::send('emails.form-data', ['data' => $data], function ($m) use ($email_from, $email_to, $subject) {
                $m->from($email_from, env('MAIL_FROM_NAME'));
                $m->to($email_to)->subject(env('APP_NAME').' '.$subject);
            });

            // send notification to admin
            $body = formatDataForEmail([
                'responsible' => $exhibitor_data->responsible,
                'company' => $exhibitor_data->company,
            ], $setting->email_to_admin_notification_admit);

            $data = [
                'body' => $body
            ];
            // Mail::send('emails.notification-admit', ['data' => $data], function ($m) use ($email_from) {
            //     $m->from($email_from, 'Espositore - Ammissione');
            //     $m->to(env('MAIL_CONTABILITA'))->subject('Notifica Invio fattura a Espositore');
            // });
            Mail::send('emails.form-data', ['data' => $data], function ($m) use ($email_from) {
                $m->from($email_from, 'Espositore - Ammissione');
                $m->to(env('MAIL_CONTABILITA'))->subject('Notifica Ammissione Espositore');
            });

            $response['status'] = true;
            $response['message'] = trans('generals.admit_success');
            return response()->json($response);
        } catch(\Exception $e){
            $response['message'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function exportAll()
    {
        $list = DB::table('exhibitors_data')
            ->leftJoin('exhibitors', 'exhibitors_data.exhibitor_id', '=', 'exhibitors.id')
            ->leftJoin('users', 'exhibitors.user_id', '=', 'users.id')
            ->select('exhibitors_data.*', 'users.email as email', 'exhibitors.locale as locale')
            ->get();
            
        $to_export = [];
        foreach($list as $l) {
            $item = [
                'nome o ragione sociale' => $l->company,
                'indirizzo' => $l->address,
                'civico' => $l->civic_number,
                'città' => $l->city,
                'cap' => $l->cap,
                'provincia' => $l->province,
                'telefono' => $l->phone,
                'fax' => $l->fax,
                'sito web' => $l->web,
                'responsabile' => $l->responsible,
                'e-mail' => $l->email,
                'telefono responsabile' => $l->phone_responsible,
                'codice fiscale' => $l->fiscal_code,
                'partita iva' => $l->vat_number,
                'codice univoco' => $l->uni_code,
                'dati fatturazione diversi' => $l->diff_billing ? 'si' : 'no',
                'indirizzo fatturazione' => $l->receiver_address,
                'civico fatturazione' => $l->receiver_civic_number,
                'città fatturazione' => $l->receiver_city,
                'cap fatturazione' => $l->receiver_cap,
                'provincia fatturazione' => $l->receiver_province,
                'codice fiscale fatturazione' => $l->receiver_fiscal_code,
                'partita iva fatturazione' => $l->receiver_vat_number,
                'codice univoco fatturazione' => $l->receiver_uni_code,
                'privacy accettata' => 'si',
                'data accettazione' => Carbon::parse($l->created_at)->format('d/m/Y H:i:s'),
                'accetta statistiche' => $l->accept_stats ? 'si' : 'no',
                'accetta marketing' => $l->accept_marketing ? 'si' : 'no',
                'lingua espositore' => $l->locale,
            ];
            array_push($to_export, $item);
        }

        $stream = SimpleExcelWriter::streamDownload('Espositori.xlsx');
        $writer = $stream->getWriter();
        
        $sheet = $writer->getCurrentSheet();
        $sheet->setName('Espositori');
        $stream->addRows($to_export);

        return $stream->toBrowser();
    }

    public function exportIncompleted()
    {
        $all = DB::table('exhibitors')
            ->leftJoin('users', 'users.id', '=', 'exhibitors.user_id')
            ->select('exhibitors.*', 'users.email as email')
            ->get()
            ->toArray();

        $completed = DB::table('exhibitors_data')
            ->leftJoin('exhibitors', 'exhibitors_data.exhibitor_id', '=', 'exhibitors.id')
            ->leftJoin('users', 'users.id', '=', 'exhibitors.user_id')
            ->select('exhibitors.*', 'users.email as email')
            ->get()
            ->toArray();

        $diff = array_diff(array_map('json_encode', $all), array_map('json_encode', $completed));
        $incompleted = array_map('json_decode', $diff);
            
        $to_export = [];
        foreach($incompleted as $l) {
            $item = [
                'e-mail' => $l->email,
                'lingua espositore' => $l->locale,
                'data iscrizione' => Carbon::parse($l->created_at)->format('d/m/Y H:i:s'),
            ];
            array_push($to_export, $item);
        }

        $stream = SimpleExcelWriter::streamDownload('Espositori_incompleti.xlsx');
        $writer = $stream->getWriter();
        
        $sheet = $writer->getCurrentSheet();
        $sheet->setName('Espositori_incompleti');
        $stream->addRows($to_export);

        return $stream->toBrowser();
    }

    public function exportOrders($exhibitor_id)
    {
        $exhibitor_data = DB::table('exhibitors_data')->where('exhibitor_id', '=', $exhibitor_id)->first();
        if(!is_object($exhibitor_data)) {
            abort(404);
        }

        $list = DB::table('orders')
            ->leftJoin('furnishings', 'orders.furnishing_id', '=', 'furnishings.id')
            ->leftJoin('furnishings_translations', function($join) {
                $join->on('furnishings.id', '=', 'furnishings_translations.furnishing_id')
                    ->orOn('furnishings.variant_id', '=', 'furnishings_translations.furnishing_id');
            }) //'orders.furnishing_id', '=', 'furnishings_translations.furnishing_id')
            // ->leftJoin('code_modules', 'orders.code_module_id', '=', 'code_modules.id')
            ->leftJoin('stands_types_translations', 'code_modules.stand_type_id', '=', 'stands_types_translations.stand_type_id')
            ->leftJoin('furnishings_stands_types', function($join) {
                $join->on('furnishings_stands_types.stand_type_id', '=', 'code_modules.stand_type_id')
                    ->on('furnishings_stands_types.furnishing_id', '=', 'orders.furnishing_id');
            })
            ->where([
                ['orders.exhibitor_id', '=', $exhibitor_id],
                ['furnishings_translations.locale', '=', App::getLocale()],
                ['stands_types_translations.locale', '=', App::getLocale()],
            ])
            // ->select('furnishings.*', 'furnishings_translations.description', 'orders.qty', 'orders.is_supplied', 'furnishings_stands_types.min', 'furnishings_stands_types.max', 'stands_types_translations.name as stand_name', 'code_modules.code')
            ->select('furnishings.*', 'furnishings_translations.description', 'orders.qty', 'orders.is_supplied', 'furnishings_stands_types.min', 'furnishings_stands_types.max', 'stands_types_translations.name as stand_name')
            ->get();

        foreach($list as $l) {
            $price = 0;
            if($l->extra_price) {
                $price = $l->price * $l->qty;
            } else {
                if($l->is_supplied) {
                    if($l->qty > $l->max) {
                        $diff = $l->qty - $l->max;
                        $price = $l->price * $diff;
                    }
                } else {
                    $price = $l->price * $l->qty;
                }
            }
            $l->to_pay = $price;
        }
            
        $to_export = [];
        foreach($list as $l) {
            $item = [
                "nome azienda" => $exhibitor_data->company,
                "tiplogia stand" => $l->stand_name,
                "numero stand" => $l->code,
                "referente" => $exhibitor_data->responsible,
                "contatto referente" => $exhibitor_data->phone_responsible,
                "e-mail referente" => $exhibitor_data->email_responsible,
                "arredo" => $l->description,
                "colore" => $l->color,
                "dimensione" => $l->size,
                "dotazione" => $l->is_supplied ? ($l->extra_price ? 'no' : 'si') : 'no',
                "quantità scelta" => $l->qty,
                "quantità massima dotazione" => $l->is_supplied ? $l->max : 'N/A',
                "prezzo unità singola" => $l->price.' €',
                "prezzo finale" => $l->to_pay.' €',
            ];
            array_push($to_export, $item);
        }

        $stream = SimpleExcelWriter::streamDownload($exhibitor_data->company.'_orders.xlsx');
        $writer = $stream->getWriter();
        
        $sheet = $writer->getCurrentSheet();
        $sheet->setName('Ordini');
        $stream->addRows($to_export);

        return $stream->toBrowser();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        // $exhibitor_data = DB::table('exhibitors_data')->where('id','=',$id)->first();
        // if(!is_object($exhibitor_data)) {
        //     abort(404);
        // }
        $exhibitorDetail = ExhibitorDetail::findOrFail($id);
        if(!$exhibitorDetail->exhibitor->user->delete()) {
            abort(404);
        }
        // $email = $exhibitor_data->email_responsible;
        // if(!User::where('email','=',$email)->delete()){
        //     abort(404);
        // }

        // DB::table('exhibitors')->where('id','=',$exhibitor_data->exhibitor_id)->delete();

        // // check if exists user
        // $user = DB::table('users')->where('email','=',$email)->first();
        // if(is_object($user)) {
        //     DB::table('users')->where('id','=',$user->id)->delete();
        // }

        $entity_name = trans('entities.exhibitor');
        return redirect('admin/exhibitors')->with('success', trans('forms.deleted_success',['obj' => $entity_name]));
    }

    public function sendRemarketing(Request $request)
    {
        $response = [
            'status' => false,
            'message' => trans('api.error_general'),
        ];

        try {
            $validation_data = [
                'id' => ['required', 'exists:exhibitors,id'],
            ];
    
            $validator = Validator::make($request->all(), $validation_data);
    
            if ($validator->fails()) {
                $response['message'] = trans('api.error_validation_required_fields');
                return response()->json($response);
            }

            $exhibitor = Exhibitor::findOrFail($request->id);
            $user = User::findOrFail($exhibitor->user_id);

            $setting = Setting::take(1)->first();

            $body = formatDataForEmail([
                'email' => $user->email,
            ], $exhibitor->locale == 'it' ? $setting->email_remarketing_it : $setting->email_remarketing_en);

            $data = [
                'body' => $body
            ];
            
            $email_from = env('MAIL_FROM_ADDRESS');
            $email_to = $user->email;
            $subject = trans('emails.remarketing_exhibitor', [], $exhibitor->locale);
            Mail::send('emails.form-data', ['data' => $data], function ($m) use ($email_from, $email_to, $subject) {
                $m->from($email_from, env('MAIL_FROM_NAME'));
                $m->to($email_to)->subject(env('APP_NAME').' '.$subject);
            });

            $response['status'] = true;
            $response['message'] = trans('forms.remarketing_success');
            return response()->json($response);
        } catch(\Exception $e){
            $response['message'] = $e->getMessage();
            return response()->json($response);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyIncomplete($id)
    {
        $exhibitor = Exhibitor::findOrFail($id);
        $user = User::findOrFail($exhibitor->user_id);
        $user->delete();
        $entity_name = trans('entities.exhibitor_incomplete');
        return redirect('admin/exhibitors-incomplete')->with('success', trans('forms.deleted_success',['obj' => $entity_name]));
    }
}
