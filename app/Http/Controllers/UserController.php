<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Auth;
use App\Lecture;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([User::all()]);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
        ]);
        //Caso a requisição venha fora do esperado retorna um erro Bad Request 400
        if ($validator -> fails()) {
            return response() -> json(['error' => $validator->errors()], 400);
        }

        //Cadastra o usuário no BD
        $newUser = new User;
        $newUser->name = $request->name;
        $newUser->email = $request->email;
        $newUser->is_admin = false;
        $newUser->password = bcrypt('123456');
        $newUser->save();

        return response() -> json(['success' => $newUser], 200);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return response()->json([$user]);
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
        $user = User::findOrFail($id);

        if($request->name)
            $user->name = $request->name;
        if($request->email)
            $user->email = $request->email;
        if($request->password){
            $user->password = Hash::make($request->email);
        }

        $user->save();

        return response()->json([$user]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
        return response()->json(['Deletado!']);
    }





    //Funções de usuário autenticado

    public function reserveRoom($room_id)
    {
        $user = Auth::user();

        $user->reserveRoom($room_id);

        return response()->json(['Reservado']);

    }

    public function removeRoom()
    {
        $user = Auth::user();

        $user->removeRoom();

        return response()->json(['Removido']);

    }

    public function getRoom()
    {
        $user = Auth::user();
        return response()->json([$user->room]);

    }

    public function subInLecture($lecture_id)
    {
        $user = Auth::user();

        $lecture = Lecture::findOrFail($lecture_id);

        $user->subInLecture($lecture);

        return response()->json(['Foi!']);
    }

    public function unsubInLecture($lecture_id)
    {
        $user = Auth::user();

        $lecture = Lecture::findOrFail($lecture_id);

        $user->unsubInLecture($lecture);

        return response()->json(['DELETADO!']);
    }

    public function getLectures()
    {
        $user = Auth::user();

        return response()->json([$user->lectures]);

    }

    public function getInfo()
    {
        $user = Auth::user();

        return response()->json(['success' => $user], 200); //retorna as informações do usuário logado

    }
}
