<?php

namespace App\Http\Controllers;

use App\Institution;
use Illuminate\Support\Str;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InstitutionController extends Controller
{
    use ApiResponser;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Returns a list of institution$institution
     *
     * @return void
     */
    public function index()
    {
        $institutions = Institution::all();
        return $this->showAll($institutions);
    }
    /**
     * Creates an instance of institution$institution
     *
     * @return void
     */
    public function store(Request $request)
    {
        $rules =[
            'name' => 'required|max:50',
            'description' => 'required|max:1000',
            'address' => 'required|max:255',
            'acronym' => 'required|max:15',
            'file' => 'image|mimes:jpg,png,jpeg,bmp',
        ];
        $this->validate($request,$rules);

        if($request->hasFile('file')){
            $original_filename = $request->file('file')->getClientOriginalName();
            $original_filename_arr = explode('.', $original_filename);
            $file_ext = end($original_filename_arr);
            $filename_encrypted = Str::random(25);
            $destination_path = './instiphotos/';
            $photoItem = $filename_encrypted . "." . $file_ext;

            if ($request->file('file')->move($destination_path, $photoItem)) {
                $institution = Institution::create([
                    'name' => $request['name'],
                    'description' => $request['description'],
                    'logo' => url('/') . '/instiphotos/' . $photoItem,
                    'address' => $request['address'],
                    'acronym' => $request['acronym'],
                    'encryptedImgName' => $filename_encrypted,
                    'extensionImg' => $file_ext,
                ]);

                return $this->successResponse($institution, Response::HTTP_CREATED);
            } else {
                return $this->errorResponse('Cannot upload photo', Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }


        $institution = Institution::create($request->all());
        $institution->logo = url('/') . '/instiphotos/udg.png';
        $institution->save();

        return $this->successResponse($institution,Response::HTTP_CREATED);
    }
    /**
     * Returns an specific institution$institution
     *
     * @return void
     */
    public function show($institution)
    {
        $institution = Institution::findOrFail($institution);

        return $this->successResponse($institution);
    }
    /**
     * Updates an specific institution$institution
     *
     * @return void
     */
    public function update(Request $request,$institution)
    {
        $rules =[
            'name' => 'max:50',
            'description' => 'max:1000',
            'address' => 'max:1000',
            'acronym' => 'max:255',
            'file' => 'image|mimes:jpg,png,jpeg,bmp',
        ];
        $this->validate($request,$rules);

        $institution = Institution::findOrFail($institution);


        if($request->hasFile('file')){

            $original_filename = $request->file('file')->getClientOriginalName();
            $original_filename_arr = explode('.', $original_filename);
            $file_ext = end($original_filename_arr);
            $filename_encrypted = Str::random(25);
            $destination_path = './instiphotos/';
            $photoItem = $filename_encrypted . "." . $file_ext;

            if ($request->file('file')->move($destination_path, $photoItem)) {

                /** ELIMINAR ARCHIVO */
                if($institution->encryptedImgName != null && $institution->extensionImg != null){ // SI EXISTE EL REGISTRO DE QUE UNA VEZ SE GUARDO UN ARCHIVO
                    if(file_exists($this->public_path('instiphotos/' . $institution->encryptedImgName . "." . $institution->extensionImg))){ // COMPROBAMOS QUE EXISTA TAL ARCHIVO
                        unlink('./instiphotos/' . $institution->encryptedImgName . "." . $institution->extensionImg);
                    }
                }

                $institution->name = $request['name'];
                $institution->acronym = $request['acronym'];
                $institution->description = $request['description'];
                $institution->address = $request['address'];
                $institution->logo = url('/') . '/instiphotos/' . $photoItem;
                $institution->encryptedImgName = $filename_encrypted;
                $institution->extensionImg = $file_ext;

            } else {
                return $this->errorResponse('Cannot upload photo', Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }else{
            $institution->fill($request->all());
        }

        if($institution->isClean()){
            return $this->errorResponse('At least one value must change',Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $institution->save();

        return $this->successResponse($institution);
    }
    /**
     * Returns an specific institution$institution
     *
     * @return void
     */
    public function destroy($institution)
    {
        $institution = Institution::findOrFail($institution);

        /** ELIMINAR ARCHIVO */
        if($institution->encryptedImgName != null && $institution->extensionImg != null){ // SI EXISTE EL REGISTRO DE QUE UNA VEZ SE GUARDO UN ARCHIVO
            if(file_exists($this->public_path('instiphotos/' . $institution->encryptedImgName . "." . $institution->extensionImg))){ // COMPROBAMOS QUE EXISTA TAL ARCHIVO
                unlink('./instiphotos/' . $institution->encryptedImgName . "." . $institution->extensionImg);
            }
        }

        $institution->delete();

        return $this->successResponse($institution);
    }


    function public_path($path = '')
    {
        return env('PUBLIC_PATH', base_path('public')) . ($path ? '/' . $path : $path);
    }

}
