<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth; //auth
use DB; // use database
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{   
    public function fileView(){

        $userID = date('Y') . str_pad(Auth::user()->id, 4, '0', STR_PAD_LEFT);
        $query = DB::select('select * from files where user_id = ' . $userID . ' and fileName != "dseResult" and fileName != "postSecondaryTranscript"');
        $dseRusultQuery =  DB::select('select * from files where fileName="dseResult" and user_id = ' . $userID);
        $postSecondaryTranscriptQuery =  DB::select('select * from files where fileName="postSecondaryTranscript" and user_id = ' . $userID);
        //dd($query);
        //dd($dseRusultQuery);
        //dd($postSecondaryTranscriptQuery);
        if($query!=NULL OR $dseRusultQuery!=NULL OR $postSecondaryTranscriptQuery!=NULL){
            
            return view('file.fileView')->with('userFiles', $query)->with('dseResult', $dseRusultQuery)->with('postSecondaryTranscript', $postSecondaryTranscriptQuery);
        }else{
            return view('file.fileView');
        }

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
        //
        //dd($userFile->dseResultName);

        $validatedData = $request->validate([
            'file' => 'required|mimes:pdf|max:2048',
    
        ]);
    
        $name = $request->file('file')->getClientOriginalName();
    
        $path = $request->file('file')->store('public/files');
    
    
        $save = new File;
        
        $save->user_id = date('Y') . str_pad(Auth::user()->id, 4, '0', STR_PAD_LEFT);

        $save->fileName = request('fileName');
        $save->fileOriginalName = $name;
        $save->filePath = $path;

        $save->save();
     
        return redirect()->to('/fileView')->with('success',true);


    }

    public function getFile($filePath){
        $document = DB::select('select fileOriginalName from files where filePath = "public/files/'. $filePath . '"');
        return Storage::download('public/files/' . $filePath, $document[0]->fileOriginalName);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function show(File $file)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function edit(File $file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, File $file)
    {
        //
        $validatedData = $request->validate([
            'file' => 'required|mimes:pdf|max:2048',
    
        ]);
    
        $name = $request->file('file')->getClientOriginalName();
    
        $path = $request->file('file')->store('public/files');

        $file->fileName = request('fileName');
        $file->fileOriginalName = $name;
        $file->filePath = $path;

        $file->save();
     
        return redirect()->to('/fileView')->with('success',true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::delete('DELETE FROM files WHERE id = ?', [$id]);

        return redirect()->to('/fileView');
    }
}
