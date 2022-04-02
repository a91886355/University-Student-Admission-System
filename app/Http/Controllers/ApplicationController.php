<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth; //auth
use DB; // use database

class ApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        //$user = Auth::user()->id;
        $user = date('Y') . str_pad(Auth::user()->id, 4, '0', STR_PAD_LEFT);

        $query = DB::select('select * from applications where user_id = ' . $user); 

        

        if ($query != NULL){
            //print_r($application);
            $application = $query[0];
            return view('application.personal', compact('application', $application));
        }else{
            return view('application.create');
        }

    }
    
    public function personal()
    {
        //
    
        $user = date('Y') . str_pad(Auth::user()->id, 4, '0', STR_PAD_LEFT);

        $query = DB::select('select * from applications where user_id = ' . $user); 

        if($query!= NULL){
            $application = $query[0];
        }else{
            return view('application.create');
        }
        
        return view('application.personal', compact('application', $application));

    }

    public function acade()
    {
        //
        $user = date('Y') . str_pad(Auth::user()->id, 4, '0', STR_PAD_LEFT);

        $query = DB::select('select * from applications where user_id = ' . $user); 

        if($query!= NULL){
            $application = $query[0];
        }else{
            return view('application.create');
        }


        if($application->personalFilled == true){
            return view('application.acade', compact('application', $application));
        }else{
            return redirect()->to('/personal')->with('notFilledAcade', true);
        }

    }

    public function detail(Request $request)
    {
        //
        $applicationID = $request->query('id');

        $query = DB::select('select * from applications where id = ' . $applicationID); 
        //dd($query);
        $application = $query[0];

            return view('application.detail', compact('application', $application));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        //$application->studyYear = request('studyYear');
        //$application->studyProgramme = request('studyProgramme');
        //$application->personalParticular = request('personalParticular');

        $application = new Application;
        $userID = date('Y') . str_pad(Auth::user()->id, 4, '0', STR_PAD_LEFT);
        $application->user_id = $userID;
        $application->save();

        return redirect()->to('/personal');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function show(Application $application)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function edit(Application $application)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Application $application)
    {
        //Personal Information
        if(request('englishName') != ""){
        $application->personalFilled = request('personalFilled');
        $application->englishName = request('englishName');
        $application->chineseName = request('chineseName');
        $application->sex = request('sex');
        $application->dateOfBirth = request('dateOfBirth');
        $application->nationality = request('nationality');
        
        //Contact
        $application->homephoneNumber = request('homephoneNumber');
        $application->mobileNumber = request('mobileNumber');
        $application->mailingAddress = request('mailingAddress');

        $application->save();

        return redirect()->to('/acade')->with('success', true);

        }else if(request('secondaryCountry') != ""){
        //Academic Profile
        //Secondary Education
        $application->acadeFilled = request('acadeFilled');
        $application->secondaryCountry = request('secondaryCountry');
        $application->secondarySchool = request('secondarySchool');
        $application->secondaryAdmission = request('secondaryAdmission');
        $application->secondaryCompletion = request('secondaryCompletion');

        //Post-Secondary Education
        $application->postCountry = request('postCountry');
        $application->postSchool = request('postSchool');
        $application->postProgramme = request('postProgramme');
        $application->postQualification = request('postQualification');
        $application->postMode = request('postMode');
        $application->postCgpa = request('postCgpa');
        $application->postMaxCgpa = request('postMaxCgpa');
        $application->postAdmission = request('postAdmission');
        $application->postCompletion = request('postCompletion');//

        $application->save();

        return redirect()->to('/acade')->with('acadeSuccess', true);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function destroy(Application $application)
    {
        //
    }

}
