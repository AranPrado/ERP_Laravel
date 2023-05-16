<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $admins = User::where('is_admin', true)->get();

        $clients = User::where('is_admin', null)
            ->orWhere('is_admin', false)
            ->get();

        return view('erp.users.index')
            ->with(compact('admins', 'clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('erp.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email:rfc,dns|unique:users',
            'password' => 'required|min:8|max:32',
            'password-confirm' => 'required|same:password',
            'access' => 'required',
        ]);

        if(!$validator->fails()) {

            $access = null;

            if($request->access === 'admin') {
                $access = true;                
            } else {
                $access = null;
            }

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->is_admin = $access;
            $user->password = Hash::make($request->password);

            try {
                if($user->save()) {
                    return redirect()
                        ->route('users.create')
                        ->with('status', 'Usuário cadastrado com sucesso.');
                } else {
                    return redirect()
                        ->route('users.create')
                        ->with('error', 'Falha ao tentas cadastrar usuário.');
                }
            } catch(\PDOException $err) {
                return redirect()
                    ->route('users.create')
                    ->with('error', $err);
            }
        } else {
            $errors = $validator->errors();
            return redirect()
                ->route('users.create')
                ->with('error', 'Verifique se todos os campos estão preenchidos.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::where('id', $id)
            ->first();

        return view('erp.users.edit')
            ->with(compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
        ]);

        if(!$validator->fails()) {
            
            $access = null;

            if($request->access === 'admin') {
                $access = true;
            } else {
                $access = null;
            }

            $user = User::where('id', $id)
                ->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    
                ]);
            
                try {
                    if($user) {
                        return redirect()
                            ->route('users.edit', ['id' => $id])
                            ->with('status', 'Dados do usuário atualizados com sucesso.');
                    } else {
                        return redirect()
                            ->route('users.edit', ['id' => $id])
                            ->with('error', 'Falha ao tentas atualizar os dados.');
                    }
                } catch(\PDOException $err) {
                    return redirect()
                        ->route('users.edit', ['id' => $id])
                        ->with('error', $err);
                }

        } else {
            $errors = $validator->errors();
            return redirect()
                ->route('users.edit', ['id' => $id])
                ->with('error', 'Verifique se todos os campos estão corretos.');
        }


    }

    public function updatePassword(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8',
            'password-confirm' => 'same:password',
        ]);

        if(!$validator->fails()) {
        
            $user = User::where('id', $id)
                ->update([
                    'password' => Hash::make($request->password),
                ]);
            
                try {
                    if($user) {
                        return redirect()
                            ->route('users.edit', ['id' => $id])
                            ->with('status', 'Senha atualizadas com sucesso.');
                    } else {
                        return redirect()
                            ->route('users.edit', ['id' => $id])
                            ->with('error', 'Falha ao tentas atualizar a senha.');
                    }
                } catch(\PDOException $err) {
                    return redirect()
                        ->route('users.edit', ['id' => $id])
                        ->with('error', $err);
                }

        } else {
            $errors = $validator->errors();
            return redirect()
                ->route('users.edit', ['id' => $id])
                ->with('error', 'Verifique se a senhas corresponde e possuem 8 caractes no mínimo.');
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::where('id', $id)
            ->delete();
        
        if($user) {
            return response()->json(['code' => 200, 'message' => 'Perfil deletado com sucesso.']);
        } else {
            return response()->json(['code' => 400, 'message' => 'Não foi possível deltar o perfil.']);
        }
    }
}
