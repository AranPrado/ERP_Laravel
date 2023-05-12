<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class UserController extends Controller
{

    public function index()
    {
        $users = User::all();

        return response()->json([
            'users' => $users ,
            'code' => 200,
            'status' => 'success'
        ], 200);
    }

    public function create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email:dns',
            'password' => 'required|min:8|max:32',
            'password_confirm' => 'same:password',
        ]);

        if(!$validator->fails()) {

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->is_admin = $request->is_admin;

            if($user->save()) {
                return response()->json([
                    'message' => 'Usuário cadastrado com sucesso.',
                    'code' => 200,
                    'status' => 'success',
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Falha ao tentar salvar usuário.',
                    'code' => 400,
                    'status' => 'Bad Request',
                ], 400);
            }

        } else {
            $errors = $validator->errors()->all();
            return response()->json([
                'erros' => $errors,
                'code' => 400,
                'status' => 'Bad Request',
            ]);
        }

    }

}
