<?php

namespace App\Http\Controllers;

use App\Models\Interview;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth; //auth
use DB; // use database
use Mail;

class InterviewController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function timeSlotCreate()
    {
        $programme = DB::select('select * from programmes order by name');

        return view('interview.timeSlotCreate')->with('programme',$programme);
    }

    public function interviewManage()
    {   
        $interview = DB::select('select * from interview_period AS ip
        LEFT JOIN programmes AS p
        ON ip.programmeID = p.id');

        //dd($interview);

        return view('interview.interviewManage')->with('interview',$interview);
    }

    public function interviewPeriodDetails(Request $request)
    {  
        $interviewDetail = DB::select('select *, i.id AS interviewID from interviews AS i 
        LEFT JOIN interview_period AS ip
        ON i.interviewTimePeriodId = ip.timePeriodId 
        LEFT JOIN applied_programmes AS ap
        ON ap.id = i.appliedProgrammeId
        LEFT JOIN applications AS a
        ON a.id = ap.applicationID
        WHERE i.interviewTimePeriodId = '. request('interviewTimePeriodId') . ' ORDER BY interviewID');

        //dd($interviewDetail);

        return view('interview.interviewPeriodDetails')->with('interviewDetail',$interviewDetail);
    }

    public function waitingAssign()
    {   

        $waitingList = DB::select('select count(id) as number, appliedProgramme from applied_programmes AS ap where status = "Approved" and autoAssigned = "false" and changingTime = "false" GROUP BY appliedProgramme');

        //dd($waitingList);

        return view('interview.waitingAssign')->with('waitingList',$waitingList);
    }

    public function interviewChange()
    {   

        $interviews = DB::select('select *, i.id AS interviewId from applications AS a 
        LEFT JOIN applied_programmes AS p 
        ON p.applicationID = a.id 
        LEFT JOIN interviews AS i 
        ON i.appliedProgrammeId = p.id 
        LEFT JOIN interview_period AS ip
        ON i.interviewTimePeriodId = ip.timePeriodId
        WHERE p.autoAssigned = "false" and p.changingTime = "true"');

        //dd($interviews);

        return view('interview.interviewChange')->with('interviews',$interviews);
    }

    public function interviewChangeSelect($appliedProgrammeId)
    {   

        $interview = DB::select('select *, i.id AS interviewId from applications AS a 
        LEFT JOIN applied_programmes AS p 
        ON p.applicationID = a.id 
        LEFT JOIN interviews AS i 
        ON i.appliedProgrammeId = p.id 
        LEFT JOIN interview_period AS ip
        ON i.interviewTimePeriodId = ip.timePeriodId
        WHERE p.autoAssigned = "false" and changingTime = "true" and p.id = '. $appliedProgrammeId);

        $programmeId = DB::select('select id from programmes where name = "' . $interview[0]->appliedProgramme .'"');

        //dd($programmeId);

        $interviewEmptys = DB::select('select * from interview_period AS ip 
        LEFT JOIN interviews AS i 
        ON i.interviewTimePeriodId = ip.timePeriodId 
        WHERE i.appliedProgrammeId IS NULL AND i.id IS NOT NULL AND ip.programmeId = ' . $programmeId[0]->id);

        $interviewPeriodEmptys = DB::select('select * from interview_period where programmeId = ' . $programmeId[0]->id);

        //dd($interviewEmptys);

        return view('interview.interviewChangeSelect')->with('interview',$interview[0])->with('interviewEmptys',$interviewEmptys)->with('interviewPeriodEmptys',$interviewPeriodEmptys);
    }

    public function getEmptyTime($timePeriodId=0){

        $empData['data'] = DB::select('select i.id,interviewTime from interview_period AS ip LEFT JOIN interviews as i ON ip.timePeriodId = i.interviewTimePeriodId WHERE i.appliedProgrammeId IS NULL and ip.timePeriodId = ' . $timePeriodId);
        
        if($empData['data']==null){
            $empData['data'][0]['id'] = null;
        }

        return response()->json($empData);
     
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $startTime = strtotime(request('startTimeOfInterview'));
        $finishTime = strtotime(request('finishTimeOfInterview'));
        $timeSlot = request('timeSlotOfInterview') * 60;

        if($startTime>=$finishTime){
            $error = "Finish Time of Interview cannot be early than start time of interview";
            return redirect()->to('/timeSlotCreate')->with('error', $error);
        }elseif($finishTime-$startTime<$timeSlot){
            $error = "Time period of Interview cannot be smaller than the Time Slot ";
            return redirect()->to('/timeSlotCreate')->with('error', $error);
        }else{
            
            $endTime = $startTime;
            $returnArrays = array ();
            while ($startTime < $finishTime && $startTime + $timeSlot <= $finishTime){   
                $endTime += $timeSlot;
                $returnArrays[] = date("H:i", $startTime) . '-' . date("H:i", $endTime);
                $startTime += $timeSlot;
            }

            $interviews = \DB::table('interviews')->get();
            $countPeriodId = $interviews->count() +1;

            $timePeriod = request('startTimeOfInterview').'-'. request('finishTimeOfInterview');
            DB::insert('insert into interview_period (timePeriodId, timePeriod, timeSlot, programmeId, interviewDate, interviewVenue) values (?, ?, ?, ?, ?, ?)', [$countPeriodId, $timePeriod , request('timeSlotOfInterview'), request('programmeId'), request('dateOfInterview'), request('interviewVenue')]);
        
            foreach ($returnArrays as $returnArray){
                $interview = new Interview;
                $interview->interviewTimePeriodId = $countPeriodId;
                $interview->interviewTime = $returnArray;
                $interview->userAccepted = null;
                $interview->save();
            }

            $waitingChecks = DB::select('select ap.id AS id from applied_programmes as ap 
            LEFT JOIN programmes as p 
            ON ap.appliedProgramme = p.name 
            where status = "Approved" and autoAssigned = "false" and changingTime = "false" and p.id = ' . request('programmeId'));
            if($waitingChecks != NULL){
                foreach($waitingChecks as $waitingCheck){

                    $interviewEmptys = DB::select('select *, i.id from interview_period as ip
                    LEFT JOIN interviews as i 
                    ON i.interviewTimePeriodId = ip.timePeriodId
                    WHERE programmeId =' . request('programmeId') . ' AND i.appliedProgrammeId IS NULL');

                    if($interviewEmptys != NULL){
                        DB::table('interviews')
                            ->where('id', $interviewEmptys[0]->id)
                            ->update(['appliedProgrammeId' => $waitingCheck->id , 'userAccepted' => "Requesting"]);

                        DB::table('applied_programmes')
                            ->where('id', $waitingCheck->id)
                            ->update(['autoAssigned' => true]);

                            $findUserId = DB::select('select a.user_id from applications AS a 
                            LEFT JOIN applied_programmes AS ap 
                            ON ap.applicationID = a.id WHERE ap.id = '. $waitingCheck->id);

                            $userId = intval(substr($findUserId[0]->user_id,4));

                            $userQuery = DB::select('select * from users where id = '. $userId);

                            $query = DB::select('select * from applications AS a 
                            LEFT JOIN applied_programmes AS ap 
                            ON ap.applicationID = a.id 
                            LEFT JOIN interviews as i
                            ON i.appliedProgrammeId = ap.id
                            LEFT JOIN interview_period as ip 
                            ON i.interviewTimePeriodId = ip.timePeriodId
                            WHERE ap.id = '. $waitingCheck->id);
        
        
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
                                <a href='http://localhost:8000/status'>>>>>Let's Answer the Interview Request<<<<<</a>" //http://127.0.0.1:8000/status
                            ];
                    
                            Mail::send('noticeEmail-template', $data, function($message) use ($data) {
                                $message->to($data['email'])
                                ->subject($data['subject']);
                            });

                    }else{
                        redirect()->to('/interviewManage')->with('success', true);
                    }
                }
            }


            return redirect()->to('/interviewManage')->with('success', true);
        }
    }

    public function storeOld(Request $request)
    {
        //
    
        $interview = new Interview;
        $interview->appliedProgrammeId = request('appliedProgrammeId');
        $interview->interviewDate = request('dateOfInterview');
        $interview->interviewTime = request('timeOfInterview');
        $interview->interviewVenue = request('interviewVenue');
        $interview->userAccepted = "Requesting";
        $interview->save();

        $affected = DB::table('applied_programmes')
              ->where('id', request('appliedProgrammeId'))
              ->update(['officerAssigned' => 'true']);

              $query = DB::select('select * from applications AS a 
              LEFT JOIN applied_programmes AS p 
              ON p.applicationID = a.id 
              LEFT JOIN users AS u
              ON u.id = a.user_id 
              WHERE p.id = '. $request->appliedProgrammeId);

        //dd($query);

        $data = [
            'subject' => $request->subject,
            'email' => $request->email,
            'content' => "Dear {$query[0]->englishName},<br>
            <br>
            Your {$query[0]->appliedProgramme} Interview Request is waiting for accept or reject.<br>
            <br>
            Details of Interview:<br>
            Name: {$query[0]->englishName}<br>
            Apply Programme: {$query[0]->appliedProgramme}<br>
            Apply Year: Year {$query[0]->appliedYear}<br>
            Interview Date: {$request->dateOfInterview}<br>
            Interview Time: {$request->timeOfInterview}<br>
            Interview Venue: {$request->interviewVenue}<br>
            <br>
            Please reply as soon as possible.<br>
            <br>
            University Officer
            
            <br><br>
            <a href='http://127.0.0.1:8000/status'>>>>>Let's Answer the Interview Request<<<<<</a>"
        ];

        //dd($data);

        Mail::send('noticeEmail-template', $data, function($message) use ($data) {
            $message->to($data['email'])
            ->subject($data['subject']);
        });
    

        return redirect()->to('/assign')->with('success', true);
 


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Interview  $interview
     * @return \Illuminate\Http\Response
     */
    public function show(Interview $interview)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Interview  $interview
     * @return \Illuminate\Http\Response
     */
    public function edit(Interview $interview)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Interview  $interview
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Interview $interview)
    {
        //change Time Request
        if(request('changeTime')=="true"){
            $findUserId = DB::select('select a.user_id from applications AS a 
                    LEFT JOIN applied_programmes AS ap 
                    ON ap.applicationID = a.id WHERE ap.id = '. request('appliedProgrammeId'));

            $userId = intval(substr($findUserId[0]->user_id,4));

            $userQuery = DB::select('select * from users where id = '. $userId);

            if(request('noEmpty')=="true"){
                DB::table('applied_programmes')
                ->where('id', request('appliedProgrammeId'))
                ->update(['autoAssigned' => 'true']);

                $query = DB::select('select * from applications AS a 
                    LEFT JOIN applied_programmes AS ap 
                    ON ap.applicationID = a.id 
                    LEFT JOIN interviews as i
                    ON i.appliedProgrammeId = ap.id
                    LEFT JOIN interview_period as ip 
                    ON i.interviewTimePeriodId = ip.timePeriodId
                    WHERE ap.id = '. request('appliedProgrammeId'));

                $data = [
                    'subject' => "XXX University: Changing Time Request of {$query[0]->appliedProgramme}'s inteview is REJECTED",
                    'email' => $userQuery[0]->email,
                    'content' => "Dear {$query[0]->englishName},<br>
                    <br>
                    Unfortunately, there is no any empty interview time period for changing. <br>
                    Your Original {$query[0]->appliedProgramme} Interview Request is waiting for accept or reject.<br>
                    <br>
                    Please reply as soon as possible.<br>
                    <br>
                    University Officer
                        
                    <br><br>
                    <a href='http://localhost:8000/status'>>>>>Let's Answer the Interview Request<<<<<</a>"
                ];
            
                Mail::send('noticeEmail-template', $data, function($message) use ($data) {
                    $message->to($data['email'])
                    ->subject($data['subject']);
                });

                return redirect()->to('/interviewChange');
            }

            $interview->appliedProgrammeId = null;
            $interview->userAccepted = null;
            $interview->save();

            DB::table('interviews')
                ->where('id', request('newInterviewTime'))
                ->update(['appliedProgrammeId' => request('appliedProgrammeId'), 'userAccepted' => "Requesting"]);

            DB::table('applied_programmes')
            ->where('id', request('appliedProgrammeId'))
            ->update(['autoAssigned' => 'true']);

            $query = DB::select('select * from applications AS a 
                    LEFT JOIN applied_programmes AS ap 
                    ON ap.applicationID = a.id 
                    LEFT JOIN interviews as i
                    ON i.appliedProgrammeId = ap.id
                    LEFT JOIN interview_period as ip 
                    ON i.interviewTimePeriodId = ip.timePeriodId
                    WHERE ap.id = '. request('appliedProgrammeId'));

            $data = [
                'subject' => "XXX University: Changing Time Request of {$query[0]->appliedProgramme}'s inteview is APPROVED",
                'email' => $userQuery[0]->email,
                'content' => "Dear {$query[0]->englishName},<br>
                <br>
                Your New {$query[0]->appliedProgramme} Interview Request is waiting for accept or reject.<br>
                <br>
                Details of New Interview:<br>
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

            return redirect()->to('/interviewChange')->with('success', true);
        }

        //userAccepted
        if(request('userAccepted')=="Accepted"){
            $interview->userAccepted = request('userAccepted');
            $interview->save();

        }elseif(request('userAccepted')=="Rejected"){
            $interview->userAccepted = null;
            $interview->appliedProgrammeId = null;
            $interview->save();

        }

        $userAccepted = request('userAccepted');

        return redirect()->to('/status')->with('success', true)->with('userAccepted', $userAccepted);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Interview  $interview
     * @return \Illuminate\Http\Response
     */
    public function destroy(Interview $interview)
    {
        //
    }
}
