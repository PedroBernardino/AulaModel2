<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

use Auth;
use App\User;
use DB;

class PassportController extends Controller
{
    public $successStatus = 200;

    /**
     * Registra um novo usuário e retorna seu token
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
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
        $newUser->password = bcrypt($request->password);
        $newUser->save();

        $success['email'] = $newUser->email;
        //Cria o token do usuário e salva no BD
        $success['token'] = $newUser->createToken('MyApp')->accessToken;

        //
        return response() -> json(['success' => $success], $this->successStatus);
    }

    /**
     * Loga o usuário e retorna o token
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(){
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])){

            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->accessToken;

            return response()->json(['success' => $success], $this->successStatus);
        }
        else {
            return response() -> json (['error' => 'Unauthorised'], 401);
        }
    }

    /**
     * Desloga o usuário e descarta o token do BD
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(){
        $accessToken = Auth::user()->token();

        DB::table('oauth_refresh_tokens')->where('access_token_id',
            $accessToken->id)->update([
            'revoked' => true
        ]);

        $accessToken->revoke();

        return response()->json( null, 204);
    }



}
