<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Institution;
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
        return $this->successResponse($institutions);
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
            'description' => 'required|max:255',
            'address' => 'required|max:255',
            'acronym' => 'required|max:255',
        ];
        $this->validate($request,$rules);

        $institution = Institution::create($request->all());

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
        ];
        $this->validate($request,$rules);

        $institution = Institution::findOrFail($institution);

        $institution->fill($request->all());

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

        $institution->delete();

        return $this->successResponse($institution);
    }
    //
}
