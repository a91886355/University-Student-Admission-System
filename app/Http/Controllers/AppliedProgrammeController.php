<?php

namespace App\Http\Controllers;

use App\Models\appliedProgramme;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth; //auth
use DB; // use database
use Mail;

use App\Http\Controllers\User;

class AppliedProgrammeController extends Controller
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
    }

    public function apply()
    {
        //
        $user = date('Y') . str_pad(Auth::user()->id, 4, '0', STR_PAD_LEFT);

        $query2 = DB::select('select * from applications where user_id = ' . $user); 

        if($query2 != NULL){

            $applicationID = $query2[0]->id;
            $application = $query2[0];

            $query = DB::select('select * from applied_programmes where applicationID = ' . $applicationID); 
        }else{
            $application = new \stdClass();
            $application->personalFilled = false;
        }

        

        $query3 = DB::select('select * from files where fileName = "postSecondaryTranscript" and user_id = ' . $user); 
        if ($query3 == NULL){
            $document = false;
        }else{
            $document = true;
        }

        if($application->personalFilled == true && $application->acadeFilled == true && $document == true){
            
            //dd($appliedProgramme);
    
            if ($query != NULL){
                //$appliedProgramme = $query[0];
                return redirect()->to('home')->with('applied', true);
                //return view('appliedProgramme.apply', compact('application',$application));
                //return view('appliedProgramme.appliedEdit', compact('appliedProgramme', $appliedProgramme));
            }else{
                $programme = DB::select('select * from programmes ORDER BY name'); 

                return view('appliedProgramme.apply')->with('application',$application)->with('programme',$programme); //compact('application',$application))
            }
        }else{
            return redirect()->to('/applyRequirement');
        }


    }

    public function applyRequirement()
    {   
        $user = date('Y') . str_pad(Auth::user()->id, 4, '0', STR_PAD_LEFT);

        $query = DB::select('select * from applications where user_id = ' . $user); 
        if($query != NULL){
            $application = $query[0];
        }else{
            $application = new \stdClass();
            $application->personalFilled = false;
        }

        $query2 = DB::select('select * from files where fileName = "postSecondaryTranscript" and user_id = ' . $user); 
        if ($query2 == NULL){
            $document = false;
        }else{
            $document = true;
        }

        $notFilled = "";

        if($application->personalFilled != true){
            $notFilled = "all";
        }elseif($application->acadeFilled != true){
            $notFilled = "acade";
        }

        return view('appliedProgramme.applyRequirement')->with('notFilled', $notFilled)->with('requireDocument', $document)->with('user_id', $user);
    }

    public function status()
    {
        //
        $user = date('Y') . str_pad(Auth::user()->id, 4, '0', STR_PAD_LEFT);

        $query2 = DB::select('select * from applications where user_id = ' . $user); 

        if($query2 == null){
            return redirect()->to('home')->with('noApplication', true);
        }
        $applicationID = $query2[0]->id;
        
        $query3 = DB::select('select * from applications AS a 
        LEFT JOIN applied_programmes AS p 
        ON p.applicationID = a.id 
        WHERE applicationID = ' . $applicationID . ' ORDER BY FIELD(rank, "1","2","3")');
        
        foreach ($query3 as $q) {
            if($q->autoAssigned == true){
                $query = DB::select('select *, i.id AS interviewId from applications AS a 
                LEFT JOIN applied_programmes AS p 
                ON p.applicationID = a.id 
                LEFT JOIN interviews AS i 
                ON i.appliedProgrammeId = p.id 
                LEFT JOIN interview_period AS ip
                ON i.interviewTimePeriodId = ip.timePeriodId
                WHERE p.applicationID = ' . $applicationID . ' ORDER BY FIELD(rank, "1","2","3")'); 

                //dd($query);
                $appliedProgramme = $query;
                
                return view('appliedProgramme.status', compact('appliedProgramme', $appliedProgramme));
            }
        }

        $appliedProgramme = $query3;

        return view('appliedProgramme.status', compact('appliedProgramme', $appliedProgramme))->with('anyInterview', true);

    }

    public function viewFile($user_id){
        $query = DB::select('select * from files where user_id =' . $user_id ); 
        //dd($query);
        return view('appliedProgramme.viewFile')->with('files', $query)->with('user_id',$user_id);
    }

    public function manage(Request $request){

        if($request->query('filterStatus')!=NULL){
            $filterStatus = $request->query('filterStatus');
            $query = DB::select('select *,a.user_id , p.id from applications AS a 
            LEFT JOIN applied_programmes AS p 
            ON p.applicationID = a.id 
            LEFT JOIN programmes AS pro
            ON pro.name = p.appliedProgramme
            LEFT JOIN files AS f
            ON f.user_id = a.user_id
            WHERE p.status ="' . $filterStatus . '"and f.fileName = "postSecondaryTranscript" order by p.created_at'); 
            $nav = $filterStatus ;

        }else{
            $filterStatus = 'Processing';
            $query = DB::select('select *,a.user_id , p.id from applications AS a 
            LEFT JOIN applied_programmes AS p 
            ON p.applicationID = a.id 
            LEFT JOIN programmes AS pro
            ON pro.name = p.appliedProgramme
            LEFT JOIN files AS f
            ON f.user_id = a.user_id
            WHERE p.status ="' . $filterStatus . '"and f.fileName = "postSecondaryTranscript" order by p.created_at'); 
            $nav = $filterStatus ;
            //dd($query);

        }

        $processingQuery = DB::select('select * from applied_programmes WHERE status ="Processing"');
        $approvedQuery = DB::select('select * from applied_programmes WHERE status ="Approved"');
        $rejectedQuery = DB::select('select * from applied_programmes WHERE status ="Rejected"');

        $processing = count($processingQuery);
        $approved = count($approvedQuery);
        $rejected = count($rejectedQuery);

        $count = [
            'processing' => $processing,
            'approved' => $approved,
            'rejected' => $rejected,
            'nav' => $nav
        ];
        //dd($count);

        //dd($query);
        $appliedProgramme = $query;
        
        return view('appliedProgramme.manage')->with('appliedProgramme', $appliedProgramme)->with('count', $count);


    }

    public function assign(Request $request)
    {
        //

        if($request->query('autoAssigned')=="true"){
            $autoAssigned = $request->query('autoAssigned');
            $query = DB::select('select *, p.id AS PID from applications AS a 
            LEFT JOIN applied_programmes AS p 
            ON p.applicationID = a.id 
            LEFT JOIN interviews AS i 
            ON i.appliedProgrammeId = p.id 
            LEFT JOIN users AS u
            ON u.id = a.user_id 
            WHERE p.autoAssigned = "true" AND p.status="Approved"
            ORDER BY FIELD(userAccepted, "Processing","Accepted","Rejected")');
        }else{
            $query = DB::select('select *, p.id AS PID from applications AS a 
            LEFT JOIN applied_programmes AS p 
            ON p.applicationID = a.id 
            LEFT JOIN interviews AS i 
            ON i.appliedProgrammeId = p.id 
            LEFT JOIN users AS u
            ON u.id = a.user_id 
            WHERE p.autoAssigned = "false" AND p.status="Approved"');

            $autoAssigned = 'false';
        }
        
        //$all = count(DB::select('select * from applied_programmes where status="Approved"'));
        $assigned = count(DB::select('select * from applied_programmes where status="Approved" and autoAssigned="true"'));
        $unassigned = count(DB::select('select * from applied_programmes where status="Approved" and autoAssigned="false"'));

        $count = ['assigned' => $assigned,'unassigned' => $unassigned, 'nav' => $autoAssigned ];
        
        $appliedProgramme = $query;

        return view('appliedProgramme.assign')->with('appliedProgramme', $appliedProgramme)->with('count', $count);
    }


    /*
    public function decide(Request $request){

            $applcationId = $request->query('id');
            $decide = $request->query('decide');

            if($decide =="Approve"){
                update($request, $applcationId);
            }else{
                update($request, $applcationId);
            }
            
        
        return view('appliedProgramme.manage')->with('appliedProgramme', $appliedProgramme);


    }
    */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $appliedProgramme = new AppliedProgramme;
        $appliedProgramme->applicationID = request('applicationID');
        $appliedProgramme->rank = '1';
        $appliedProgramme->appliedProgramme = request('appliedProgramme1');
        $appliedProgramme->appliedYear = request('appliedYear1');
        $appliedProgramme->save();

        if (request('appliedProgramme2')!=""){
            $appliedProgramme = new AppliedProgramme;
            $appliedProgramme->applicationID = request('applicationID');
            $appliedProgramme->rank = '2';
            $appliedProgramme->appliedProgramme = request('appliedProgramme2');
            $appliedProgramme->appliedYear = request('appliedYear2');
            $appliedProgramme->save();
        }

        if (request('appliedProgramme3')!=""){
            $appliedProgramme = new AppliedProgramme;
            $appliedProgramme->applicationID = request('applicationID');
            $appliedProgramme->rank = '3';
            $appliedProgramme->appliedProgramme = request('appliedProgramme3');
            $appliedProgramme->appliedYear = request('appliedYear3');
            $appliedProgramme->save();
        }

        return redirect()->to('/status');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\appliedProgramme  $appliedProgramme
     * @return \Illuminate\Http\Response
     */
    public function show(appliedProgramme $appliedProgramme)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\appliedProgramme  $appliedProgramme
     * @return \Illuminate\Http\Response
     */
    public function edit(appliedProgramme $appliedProgramme)
    {
        //
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\appliedProgramme  $appliedProgramme
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, appliedProgramme $appliedProgramme)
    {   
        if(request('changingTimeConfirm') == true){
            $appliedProgramme->autoAssigned = 'false';
            $appliedProgramme->changingTime = request('changingTime');
            
            $appliedProgramme->save();

            return redirect()->to('/status')->with('change', true);
        }
        /*
        if(request('applyProgramme') != ""){
            $appliedProgramme->applyProgramme = request('appliedProgramme');
            $appliedProgramme->applyYear = request('appliedYear');
            
            $appliedProgramme->save();

            return redirect()->to('/apply')->with('success', true);
        }
        */
        $status = request('status');

        if($status == "Approved"){

            $programmeId = DB::select('select id from programmes WHERE name ="' . request('programme') . '"');

            $interviewEmptys = DB::select('select *, i.id from interview_period as ip
            LEFT JOIN interviews as i 
            ON i.interviewTimePeriodId = ip.timePeriodId
            WHERE programmeId =' . $programmeId[0]->id . ' AND i.appliedProgrammeId IS NULL');

            //dd($interviewEmptys);

            if($interviewEmptys != NULL){
                if ($interviewEmptys[0]->appliedProgrammeId == NULL){
                    DB::table('interviews')
                        ->where('id', $interviewEmptys[0]->id)
                        ->update(['appliedProgrammeId' => request('appliedProgrammeId'), 'userAccepted' => "Requesting"]);

                    $appliedProgramme->status = request('status');
                    $appliedProgramme->autoAssigned = true;
                    $appliedProgramme->save();

                    $findUserId = DB::select('select a.user_id from applications AS a 
                    LEFT JOIN applied_programmes AS ap 
                    ON ap.applicationID = a.id WHERE ap.id = '. request('appliedProgrammeId'));

                    $userId = intval(substr($findUserId[0]->user_id,4));

                    $userQuery = DB::select('select * from users where id = '. $userId);

                    $query = DB::select('select * from applications AS a 
                    LEFT JOIN applied_programmes AS ap 
                    ON ap.applicationID = a.id 
                    LEFT JOIN interviews as i
                    ON i.appliedProgrammeId = ap.id
                    LEFT JOIN interview_period as ip 
                    ON i.interviewTimePeriodId = ip.timePeriodId
                    WHERE ap.id = '. request('appliedProgrammeId'));

                    //dd($query);

                    $data = [
                        'subject' => "XXX University: {$query[0]->appliedProgramme}'s inteview is arranged",
                        'email' => $userQuery[0]->email,
                        'content' => "Dear {$query[0]->englishName},<br>
                        <br>
                        Your {$query[0]->appliedProgramme} Interview Request is waiting for accept or reject.<br>
                        <br>
                        Details of Interview:<br>
                        Name: {$query[0]->englishName}<br>
                        Apply Programme: {$query[0]->appliedProgramme}<br>
                        Apply Year: Year {$query[0]->appliedYear}<br>
                        Interview Date: {$query[0]->interviewDate}<br>
                        Interview Time: {$query[0]->interviewTime}<br>
                        Interview Venue: {$query[0]->interviewVenue}<br>
                        <br>
                        Please reply as soon as possible.<br>
                        <br>
                        University Officer
                        
                        <br><br>
                        <a href='http://localhost:8000/status'>>>>>Let's Answer the Interview Request<<<<<</a>"
                    ];
            
                    //dd($data);
            
                    Mail::send('noticeEmail-template', $data, function($message) use ($data) {
                        $message->to($data['email'])
                        ->subject($data['subject']);
                    });

                    return redirect()->to('/manage')->with('success', true)->with('status', $status);
                }
            }else{

                $appliedProgramme->status = request('status');
                $appliedProgramme->save();

                return redirect()->to('/manage')->with('success', true)->with('status', $status);

            }


        }elseif(($status == "Rejected")){
            $appliedProgramme->status = request('status');
            $appliedProgramme->save();

            return redirect()->to('/manage')->with('success', true)->with('status', $status);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\appliedProgramme  $appliedProgramme
     * @return \Illuminate\Http\Response
     */
    public function destroy(appliedProgramme $appliedProgramme)
    {
        //
    }
}
