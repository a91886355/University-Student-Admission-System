<?php

namespace App\Http\Controllers;

use App\Models\Programme;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth; //auth
use DB; // use database


class ProgrammeController extends Controller
{   
    public function programmeManage(){

        $programmeList = DB::select('select * from programmes order by category, name');

        return view('programme.programmeManage')->with('programmeList', $programmeList);
    }

    public function programmeEdit(){

        $programme = DB::select('select * from programmes where id = ' . request('id'));

        return view('programme.programmeEdit')->with('programme', $programme[0]);
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
        return view('programme.create');
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
        $programme = new Programme;
        $programme->category = request('category');
        $programme->name = request('name');
        $programme->year1RequiredCgpa = request('year1RequiredCgpa');
        $programme->year3RequiredCgpa = request('year3RequiredCgpa');
        $programme->save();

        return redirect()->to('/programmeManage')->with('success', true);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Programme  $programme
     * @return \Illuminate\Http\Response
     */
    public function show(Programme $programme)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Programme  $programme
     * @return \Illuminate\Http\Response
     */
    public function edit(Programme $programme)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Programme  $programme
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Programme $programme)
    {
        //
        $programme->category = request('category');
        $programme->name = request('name');
        $programme->year1RequiredCgpa = request('year1RequiredCgpa');
        $programme->year3RequiredCgpa = request('year3RequiredCgpa');

        $programme->save();

        return redirect()->to('/programmeManage')->with('editSuccess', true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Programme  $programme
     * @return \Illuminate\Http\Response
     */
    public function destroy(Programme $programme)
    {
        //
        $programme->delete();

        return redirect()->to('/programmeManage')->with('deleteSuccess', true);
    }
}
