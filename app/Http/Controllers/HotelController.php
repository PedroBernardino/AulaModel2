<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hotel;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Hotel::all();
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
        $hotel = new Hotel;
        $hotel->name = $request->name;
        $hotel->email = $request->email;
        $hotel->description = $request->description;
        $hotel->telephone = $request->telephone;
        $hotel->address = $request->address;
        $hotel->save();
        return response()->json([$hotel]);
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
        $hotel = Hotel::findOrFail($id);
        return response()->json([$hotel]);
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
        //
        $hotel = Hotel::findOrFail($id);
        if($request->name)
            $hotel->name = $request->name;
        if($request->email)
            $hotel->email = $request->email;
        if($request->description)
            $hotel->description = $request->description;
        if($request->telephone)
            $hotel->telephone = $request->telephone;
        if($request->address)
            $hotel->address = $request->address;
        $hotel->save();
        return response()->json([$hotel]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Hotel::destroy($id);
        return response()->json(['DELETADO']);
    }

}
