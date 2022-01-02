<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends BaseController
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'     => 'required|unique:users|max:255',
            'password'  => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return $this->responseError("Registration is Failed!", 422, $validator->errors());
        }

        $params = [
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'birth'     => $request->birth,
            'gender'    => $request->gender
        ];

        $user = User::create($params);
        if ($user) {
            return $this->responseOk($params['name'], 200, "Registration Success!");
        } else {
            return $this->responseError("Registration is Failed!", 400);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'     => 'required',
            'password'  => 'required',
        ]);

        if ($validator->fails()) {
            return $this->responseError('Login Failed', 422, $validator->errors());
        }
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return $this->responseError('Wrong email!', 400);
        }
        $check = Hash::check($request->password, $user->password);
        if (!$check) {
            return $this->responseError('Wrong Password!', 400);
        }
        $user['token'] = $user->createToken('personal token')->plainTextToken;

        return $this->responseOk($user, 200, 'Login Succes!');
    }

    public function profil()
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        if ($user) {
            return $this->responseOk($user, 200);
        } else {
            return $this->responseError('Something Wrong,Please Contact admin!');
        }
    }

    public function update(Request $request)
    {
        $id = Auth::user()->id;
        $user = User::find($id);

        $user->name = $request->name;
        $user->birth = $request->bitrh;
        $user->gender = $request->gender;
        $update_user = $user->save();

        if ($update_user) {
            return $this->responseOk($user, 200);
        } else {
            return $this->responseError('Something Wrong,Please Contact admin!');
        }
    }
}
