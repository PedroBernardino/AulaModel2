<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lecture;

class LectureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Lecture::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lecture = new Lecture;

        $lecture->title = $request->title;
        $lecture->description = $request->description;
        $lecture->speaker = $request->speaker;
        $lecture->local = $request->local;

        $lecture->save();

        return response()->json([$lecture]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lecture = Lecture::findOrFail($id);

        return response()->json([$lecture]);
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
        $lecture = Lecture::findOrFail($id);

        if($request->title)
            $lecture->title = $request->title;
        if($request->description)
            $lecture->description = $request->description;
        if($request->speaker)
            $lecture->speaker = $request->speaker;
        if($request->local)
            $lecture->local = $request->local;

        $lecture->save();

        return response()->json([$lecture]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Lecture::destroy($id);

        return response()->json(['DELETADO']);
    }

    public function getClients($id)
    {
        $lecture = Lecture::find($id);
        return response()->json([$lecture->clients]);
    }
}
