<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = User::all();
        /*return response()->json(['data' => $usuarios], 200);*/
        return $this->showAll($usuarios);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $campos = $request->all();
        $campos['password'] = bcrypt($request->password);
        $campos['verified'] = User::USUARIO_NO_VERIFICADO;
        $campos['verification_token'] = User::generarVerificationToken();
        $campos['admin'] = User::USUARIO_REGULAR;

        $usuario = User::create($campos);

        /*return response()->json(['data' => $usuario], 201);*/
        return $this->showOne($usuario, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        /*$usuario = User::findOrFail($id);*/

        /*return response()->json(['data' => $usuario], 200);*/
        return $this->showOne($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'email' => 'email|unique:users,email,' . $user->id,
            'password' => 'min:6|confirmed',
            'admin' => 'in:' . User::USUARIO_ADMINISTRADOR . ',' . User::USUARIO_REGULAR,
        ]);

        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('email') && $user->email != $request->email) {
            $user->verified = User::USUARIO_NO_VERIFICADO;
            $user->verification_token = User::generarVerificationToken();
            $user->email = $request->email;
        }

        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($request->has('admin')) {
            if (!$user->esVerificado()) {
                /* return response()->json(['error' => 'Unicamente los usuarios verificados pueden
                               cambiar su valor de administrador', 'code' => 409], 409); */
                return $this->errorResponse('Unicamente los usuarios verificados pueden cambiar
                su valor de administrador', 409);
            }
            $user->admin = $request->admin;
        }

        if (!$user->isDirty()) {
            /* return response()->json(['error' => 'Se debe especificar al menos un valor diferente
            para actualizar', 'code' => 422], 422); */
            return $this->errorResponse('Se debe especificar al menos un valor diferente
            para actualizar', 422);
        }

        $user->save();

        return $this->showOne($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return $this->showOne($user);
    }
}
