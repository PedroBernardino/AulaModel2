<?php

namespace App\Http\Controllers;

use App\Lecture;
use Illuminate\Http\Request;
use App\Client;
use Symfony\Component\HttpKernel\Tests\DependencyInjection\ClassNotInContainer;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Client::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $client = new Client;
        $client->name = $request->name;
        $client->email = $request->email;
        
        $client->save();
        
        return response()->json([$client]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = Client::findOrFail($id);

        return response()->json([$client]);
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
        $client = Client::findOrFail($id);

        if($request->name)
            $client->name = $request->name;
        if($request->email)
            $client->email = $request->email;

        $client->save();

        return response()->json([$client]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Client::destroy($id);
        return response()->json(['Deletado!']);
    }

    public function insertRoom($id, $room_id)
    {
        $client = Client::findOrFail($id);

        if(!$client->insertRoom($room_id)){
            return response()->json(['Não Foi!']);
        } else {
            return response()->json(['Foi!']);
        }
    }

    public function insertLecture($id, $lecture_id)
    {
        $client = Client::findOrFail($id);

        $lecture = Lecture::findOrFail($lecture_id);

        $lecture->newClient($id);

        return response()->json(['Foi!']);
    }

    public function detachLecture($id, $lecture_id)
    {
        $client = Client::findOrFail($id);

        $lecture = Lecture::findOrFail($lecture_id);

        $lecture->removeClient($id);

        return response()->json(['DELETADO!']);
    }

    public function getLectures($id)
    {
        $client = Client::find($id);
        return response()->json([$client->lectures]);
    }
}
