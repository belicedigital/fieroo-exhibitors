<?php

namespace Fieroo\Exhibitors\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Fieroo\Exhibitors\Models\Brand;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Auth;
use Validator;
use DB;

class BrandsController extends Controller
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
        $list = DB::table('brands_exhibitors')
            ->leftJoin('brands', 'brands_exhibitors.brand_id', '=', 'brands.id')
            ->leftJoin('exhibitors_data', 'brands_exhibitors.exhibitor_id', '=', 'exhibitors_data.exhibitor_id')
            ->select('brands.*', 'exhibitors_data.exhibitor_id', 'exhibitors_data.company', 'brands_exhibitors.is_approved', 'brands_exhibitors.is_checked', 'brands_exhibitors.is_edited', 'brands_exhibitors.id as brand_exhibitor_id')
            ->get();

        $user = Auth::user();

        $editable = false;

        if($user->roles->pluck('name')->contains('espositore')) {
            $editable = true;
            $list = DB::table('brands_exhibitors')
                ->leftJoin('brands', 'brands_exhibitors.brand_id', '=', 'brands.id')
                ->leftJoin('exhibitors_data', 'brands_exhibitors.exhibitor_id', '=', 'exhibitors_data.exhibitor_id')
                ->where([
                    ['exhibitors_data.email_responsible', '=', $user->email],
                    ['brands_exhibitors.is_approved', '=', true]
                ])
                ->select('brands.*', 'exhibitors_data.exhibitor_id', 'exhibitors_data.company', 'brands_exhibitors.is_approved', 'brands_exhibitors.is_checked', 'brands_exhibitors.is_edited', 'brands_exhibitors.id as brand_exhibitor_id')
                ->get();
        }

        return view('brands::index', ['list' => $list, 'editable' => $editable]);
    }

    public function getCollabratorBrands($collaborator_id)
    {
        $editable = true;
        $list = DB::table('brands_exhibitors')
            ->leftJoin('brands', 'brands_exhibitors.brand_id', '=', 'brands.id')
            ->leftJoin('exhibitors_collaborators', 'brands_exhibitors.brand_id', '=', 'exhibitors_collaborators.brand_id')
            ->leftJoin('exhibitors_data', 'brands_exhibitors.exhibitor_id', '=', 'exhibitors_data.exhibitor_id')
            ->where([
                ['exhibitors_collaborators.user_id', '=', $collaborator_id],
                ['brands_exhibitors.is_approved', '=', true]
            ])
            ->select('brands.*', 'exhibitors_data.exhibitor_id', 'exhibitors_data.company', 'brands_exhibitors.is_approved', 'brands_exhibitors.is_checked', 'brands_exhibitors.is_edited', 'brands_exhibitors.id as brand_exhibitor_id')
            ->get();
        
        return view('brands::index', ['list' => $list, 'editable' => $editable]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('brands::create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->is_approved = boolval(is_null($request->is_approved) ? false : true);
        $validation_data = [
            'name' => ['required', 'string', 'max:255'],
            'exhibitor_id' => ['required', 'exists:exhibitors,id']
        ];

        $validator = Validator::make($request->all(), $validation_data);

        if ($validator->fails()) {
            return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        try {
            $brand = Brand::create([
                'name' => $request->name
            ]);
            $brand_exhibitor = DB::table('brands_exhibitors')->insert([
                'brand_id' => $brand->id,
                'exhibitor_id' => $request->exhibitor_id,
                'is_approved' => $request->is_approved ? 1 : 0
            ]);

            $entity_name = trans('entities.brand');
            return redirect('admin/brands')->with('success', trans('forms.created_success',['obj' => $entity_name]));
        } catch(\Exception $e) {
            return redirect()
                ->back()
                ->withErrors($e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $brand = DB::table('brands_exhibitors')
            ->leftJoin('brands', 'brands_exhibitors.brand_id', '=', 'brands.id')
            ->where('brands_exhibitors.id', '=', $id)
            ->select('brands.name', 'brands_exhibitors.*')
            ->first();
        return view('brands::edit', ['brand' => $brand]);
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
            'website' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'nation' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1000'],
            'logo' => ['required', 'mimetypes:application/pdf,application/ai,application/eps'],
            'photo' => ['required', 'mimetypes:application/pdf,application/ai,application/eps,image/jpeg'],
        ];

        $validator = Validator::make($request->all(), $validation_data);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $update_data = [
                'website' => $request->website,
                'email' => $request->email,
                'phone' => $request->phone,
                'phone_2' => $request->phone_2,
                'city' => $request->city,
                'nation' => $request->nation,
                'description' => $request->description,
                'is_edited' => true
            ];

            $db_query = DB::table('brands_exhibitors')->where('id','=',$id);

            if($request->hasFile('logo')) {
                $brand = $db_query->first();
                $path = public_path('upload/brands/'.$brand->logo);
                if(file_exists($path) && strlen($brand->logo) > 0 ) {
                    unlink($path);
                }
                $image = $request->file('logo');
                $rename_file = 'logo_'.time().'.'.$image->getClientOriginalExtension();
                $request->logo->storeAs('brands', $rename_file, ['disk' => 'upload']);
                $update_data['logo'] = $rename_file;
            }

            if($request->hasFile('photo')) {
                $brand = $db_query->first();
                $path = public_path('upload/brands/'.$brand->photo);
                if(file_exists($path) && strlen($brand->photo) > 0) {
                    unlink($path);
                }
                $image = $request->file('photo');
                $rename_file = 'photo_'.time().'.'.$image->getClientOriginalExtension();
                $request->photo->storeAs('brands', $rename_file, ['disk' => 'upload']);
                $update_data['photo'] = $rename_file;
            }
            
            $upd_breand = $db_query->update($update_data);

            $entity_name = trans('entities.brand');
            return redirect('admin/brands')->with('success', trans('forms.updated_success',['obj' => $entity_name]));
        } catch(\Exception $e) {
            return redirect()
                ->back()
                ->withErrors($e->getMessage())
                ->withInput();
        }
    }

    public function changeStatusBrand(Request $request, $id, $field)
    {
        $response = [
            'status' => false,
            'message' => trans('api.error_general')
        ];

        try {
            $validation_data = [
                'value' => ['required', 'boolean']
            ];
    
            $validator = Validator::make($request->all(), $validation_data);
    
            if ($validator->fails()) {
                $response['message'] = trans('api.error_validation');
                return response()->json($response);
            }

            if(strlen($id) <= 0 || !isset($id)) {
                $response['message'] = trans('api.error_validation');
                return response()->json($response);
            }

            $upd_brand_status = DB::table('brands_exhibitors')->where('id', '=', $id)->update([
                $field => $request->value
            ]);

            $response['status'] = true;
            $obj = trans('entities.brand');
            $response['message'] = trans('forms.updated_success', ['obj' => $obj]);
            return response()->json($response);
        } catch(\Exception $e){
            $response['message'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function exportAll()
    {
        $list = DB::table('brands_exhibitors')
            ->leftJoin('brands', 'brands_exhibitors.brand_id', '=', 'brands.id')
            ->leftJoin('exhibitors_data', 'brands_exhibitors.exhibitor_id', '=', 'exhibitors_data.exhibitor_id')
            ->select('brands.name', 'exhibitors_data.company', 'brands_exhibitors.*')
            ->get();
            
        $to_export = [];
        foreach($list as $l) {
            $item = [
                "nome" => $l->name,
                "espositore" => $l->company,
                "approvato" => $l->is_approved ? 'si' : 'no',
                "sito web" => $l->website,
                "e-mail" => $l->email,
                "telefono" => $l->phone,
                "telefono 2" => $l->phone_2,
                "città" => $l->city,
                "nazione" => $l->nation,
                "descrizione" => $l->description,
                "completato da espositore" => $l->is_edited ? 'si' : 'no',
                "revisione grafico" => $l->is_checked ? 'si' : 'no',
            ];
            array_push($to_export, $item);
        }

        $stream = SimpleExcelWriter::streamDownload('brands.xlsx');
        $writer = $stream->getWriter();
        
        $sheet = $writer->getCurrentSheet();
        $sheet->setName('Brands');
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
        Brand::findOrFail($id)->delete();
        $entity_name = trans('entities.brand');
        return redirect()->back()->with('success', trans('forms.deleted_success',['obj' => $entity_name]));
    }
}
