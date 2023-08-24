<?php

namespace Fieroo\Exhibitors\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Fieroo\Exhibitors\Models\Exhibitor;
use Auth;
use Validator;
use DB;
use Hash;
use Mail;

class CollaboratorsController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $exhibitor_data = DB::table('exhibitors_data')->where('email_responsible', '=', $user->email)->first();

        // if is logged as admin
        $list = DB::table('exhibitors_collaborators')
            ->leftJoin('users', 'exhibitors_collaborators.user_id', '=', 'users.id')
            ->leftJoin('brands', 'exhibitors_collaborators.brand_id', '=', 'brands.id')
            ->select('users.name', 'users.email', 'users.id as user_id', 'exhibitors_collaborators.*', 'brands.name as brand')
            ->get();

        if(is_object($exhibitor_data)) { // if is logged as exhibitor
            $list = DB::table('exhibitors_collaborators')
                ->leftJoin('users', 'exhibitors_collaborators.user_id', '=', 'users.id')
                ->leftJoin('brands', 'exhibitors_collaborators.brand_id', '=', 'brands.id')
                ->where('exhibitors_collaborators.exhibitor_id', '=', $exhibitor_data->exhibitor_id)
                ->select('users.name', 'users.email', 'users.id as user_id', 'exhibitors_collaborators.*', 'brands.name as brand')
                ->get();
        }
        return view('collaborators::index', ['list' => $list]);
    }

    /*
    public function getCollabratorBrands($collaborator_id)
    {
        $list = DB::table('brands')
            ->leftJoin('exhibitors_collaborators', 'brands.brand_id', '=', 'exhibitors_collaborators.brand_id')
            ->where('exhibitors_collaborators.user_id', '=', $collaborator_id)
            ->get();
        
        return view('collaborators::brands', ['list' => $list]);
    }
    */

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $exhibitor_data = DB::table('exhibitors_data')->where('email_responsible', '=', $user->email)->first();

        $data = [
            'exhibitor_data' => $exhibitor_data,
        ];

        if(!is_object($exhibitor_data)) { // logged as admin show all exhibitors
            $data['exhibitors'] = DB::table('exhibitors_data')->get();
        }

        return view('collaborators::create', ['data' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation_data = [
            'brand_id' => ['required', 'exists:brands,id'],
            'exhibitor_id' => ['required', 'exists:exhibitors,id'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email:rfc,dns', 'unique:exhibitors_data,email_responsible'],
        ];

        $validator = Validator::make($request->all(), $validation_data);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $check_exists_user = DB::table('users')->where('email', '=', $request->email)->first();
            if(!is_object($check_exists_user)) {
                $password = uniqid();
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($password)
                ]);
                $user->assignRole('collaboratore-espositori');
                $user->givePermissionTo('collaborator-expo');
            } else {
                // questo $password non mi convince
                $password = trans('generals.your_current_password');
                $user = User::findOrFail($check_exists_user->id);
                if(!$user->hasRole('collaboratore-espositori')) {
                    $user->assignRole('collaboratore-espositori');
                }
                if(!$user->hasPermissionTo('collaborator-expo')) {
                    $user->givePermissionTo('collaborator-expo');
                }
            }
            /*
            $password = uniqid();
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($password)
            ]);
            $user->assignRole('collaboratore-espositori');
            $user->givePermissionTo('collaborator-expo');
            */

            $brand_exhibitor = DB::table('exhibitors_collaborators')->insert([
                'brand_id' => $request->brand_id,
                'exhibitor_id' => $request->exhibitor_id,
                'user_id' => $user->id
            ]);

            $exhibitor = Exhibitor::findOrFail($request->exhibitor_id);

            $exhibitor_data = DB::table('exhibitors_data')->where('exhibitor_id', '=', $request->exhibitor_id)->first();


            $data = [
                'name' => $user->name,
                'email' => $user->email,
                'company' => $exhibitor_data->company,
                'locale' => $exhibitor->locale,
                'password' => $password
            ];

            $email_from = env('MAIL_FROM_ADDRESS');
            $email_to = $user->email;
            $subject = trans('emails.add_collaborator_subject', [], $exhibitor->locale);
            Mail::send('emails.add-collaborator', ['data' => $data], function ($m) use ($email_from, $email_to, $subject) {
                $m->from($email_from, env('MAIL_FROM_NAME'));
                $m->to($email_to)->subject(env('APP_NAME').' '.$subject);
            });

            $entity_name = trans('entities.collaborator');
            return redirect('admin/collaborators')->with('success', trans('forms.created_success',['obj' => $entity_name]));
        } catch(\Exception $e) {
            return redirect()
                ->back()
                ->withErrors($e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $collaborator = DB::table('exhibitors_collaborators')
            ->leftJoin('users', 'exhibitors_collaborators.user_id', '=', 'users.id')
            ->select('exhibitors_collaborators.id', 'exhibitors_collaborators.brand_id', 'users.name', 'users.email')
            ->where('exhibitors_collaborators.id', '=', $id)
            ->first();

        $user = Auth::user();
        $exhibitor_data = DB::table('exhibitors_data')->where('email_responsible', '=', $user->email)->first();

        $data = [
            'exhibitor_data' => $exhibitor_data,
        ];

        if(!is_object($exhibitor_data)) { // logged as admin show all exhibitors
            $data['exhibitors'] = DB::table('exhibitors_data')->get();

        }

        return view('collaborators::edit', ['collaborator' => $collaborator, 'data' => $data]);
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
            'brand_id' => ['required', 'exists:brands,id'],
            'exhibitor_id' => ['required', 'exists:exhibitors,id'],
        ];

        $validator = Validator::make($request->all(), $validation_data);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {

            $upd_brand_exhibitor = DB::table('exhibitors_collaborators')
                ->where('id', '=', $id)
                ->update([
                    'brand_id' => $request->brand_id
                ]);

            $entity_name = trans('entities.collaborator');
            return redirect('admin/collaborators')->with('success', trans('forms.updated_success',['obj' => $entity_name]));
        } catch(\Exception $e) {
            return redirect()
                ->back()
                ->withErrors($e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        $entity_name = trans('entities.collaborator');
        return redirect('admin/collaborators')->with('success', trans('forms.deleted_success',['obj' => $entity_name]));
    }
}
