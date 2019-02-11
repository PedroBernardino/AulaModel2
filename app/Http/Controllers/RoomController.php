<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Room;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Room::all();
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
        $room = new Room;

        $room->type = $request->type;
        $room->description = $request->description;
        $room->vacancies = $request->vacancies;
        $room->vacancies_remaining = $request->vacancies;
        $room->hotel_id = $request->hotel_id;

        $room->save();

        return response()->json([$room]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $room = Room::findOrFail($id);

        return response()->json([$room]);
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
        $room = Room::findOrFail($id);

        if($request->type)
            $room->type = $request->type;
        if($request->description)
            $room->description = $request->description;
        if($request->address)
            $room->address = $request->address;

        $room->save();

        return response()->json([$room]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Room::destroy($id);

        return response()->json(['DELETADO']);
    }

    public function getUsers($id)
    {
        $room = Room::findOrFail($id);
        return response()->json([$room->users]);
    }

    //Request recebe users como string com ids separados por vírgula Ex:
    // 1,2,3
    public function putInRoom(Request $request, $room_id)
    {
        $room = Room::findOrFail($room_id);

        //pega user como string e separa pelas vírgulas os ids em um array
        $users = explode(',',$request->users);

        $room->newUsers($users);

        return response()->json([$room->users, $room]);
    }

    //Request recebe users como string com ids separados por vírgula Ex:
    // 1,2,3
    public function removeOfRoom(Request $request, $room_id)
    {
        $room = Room::findOrFail($room_id);

        //pega user como string e separa pelas vírgulas os ids em um array
        $users = explode(',',$request->users);

        $room->removeUsers($users);

        return response()->json([$room->users, $room]);
    }
}
