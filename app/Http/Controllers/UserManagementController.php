<?php

namespace App\Http\Controllers;

use App\Models\UserManagement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth; //auth
use DB; // use database

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserManagementController extends Controller
{   
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function activeAccount()
    {
        $email = DB::select('select email from users WHERE id = ' . Auth::user()->id);

        $user_id = date('Y') . str_pad(Auth::user()->id, 4, '0', STR_PAD_LEFT);

        return view('userManagement.activeAccount')->with('user_id', $user_id)->with('email', $email[0]->email);
    }
    
    public function userManage(Request $request)
    {
        if($request->query('userAccount')!="user"){
            $query = DB::select('select * from users WHERE role ="officer"');
            $userAccount = "officer";
            $nav = "officer";

        }else{
            $query = DB::select('select * from users WHERE role ="user"');
            $userAccount = "user";
            $nav = "user";

        }

        $officer = count(DB::select('select * from users WHERE role ="officer"'));
        $user = count(DB::select('select * from users WHERE role ="user"'));


        $count = [
            'officer' => $officer,
            'user' => $user,
            'nav' => $nav,
            'userAccount' => $userAccount,
        ];

        $userList = $query;

        return view('userManagement.userManage')->with('userList', $userList)->with('count', $count);
    }

    public function createOfficer()
    {
        $now = date('Y-m-d H:i:s');

        return view('userManagement.createOfficer')->with('now', $now);
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
        //dd($request);
        //
        $name = request('name');
        $email = request('email');
        $password = Hash::make(request('password'));
        $role = "officer";

        DB::insert('insert into users (name, email, password, role) values (?, ?, ?, ?)', [$name, $email, $password, $role ]);


        return redirect()->to('/userManage')->with('createSuccess',true);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserManagement  $userManagement
     * @return \Illuminate\Http\Response
     */
    public function show(UserManagement $userManagement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserManagement  $userManagement
     * @return \Illuminate\Http\Response
     */
    public function edit(UserManagement $userManagement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserManagement  $userManagement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserManagement $userManagement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserManagement  $userManagement
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        User::destroy($id);
        

        return redirect()->to('/userManage')->with('deleteSuccess',true);
    }


}
