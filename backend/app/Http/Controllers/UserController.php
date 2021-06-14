<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Validations\UserValidation;
use App\Models\User;
use App\Exceptions\UserNotFoundException;

class UserController extends Controller
{
    use UserValidation;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function show()
    {
        $users = User::all();

        return response($users, 200);
    }

    public function destroy($id)
    {
        User::where('id', $id)->delete();

        return response()->json(['message' => 'Ok'], 200);
    }

    public function update($id, Request $request)
    {
        $this->CreateAndUpdate($request);

        $user = User::where('id', $id)->first();

        if (!isset($user)) {
            throw new UserNotFoundException();
        }


        if (isset($request->all()['password'])) {
            $user->update(['password' => password_hash($request->all()['password'], PASSWORD_DEFAULT)]);
        }

        return response()->json(['message' => 'User updated sucessfully!'], 200);
    }
}
