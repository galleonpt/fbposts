<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Validations\LoginRegisterValidation;
use App\Exceptions\UserNotFoundException;
use App\Exceptions\UnauthorizedException;
use App\Exceptions\UserAlreadyExistsException;

class AuthController extends BaseController
{
  use LoginRegisterValidation;

  public function Login(Request $request)
  {
    $this->LoginAndRegister($request);

    $credentials = $request->only(['username', 'password']);

    $user = User::where('username', $credentials['username'])->first();

    if (!$user) throw new UserNotFoundException();

    if (password_verify($credentials['password'], $user['password']))
      if (password_needs_rehash($user['password'], PASSWORD_DEFAULT)) {
        $user->update(['password' => password_hash($credentials['password'], PASSWORD_DEFAULT)]);
      }

    if (!$token = Auth::attempt($credentials))
      throw new UnauthorizedException();

    return $this->respondWithToken($token); // Create token response
  }


  // Register
  public function Register(Request $request)
  {
    //validate inputs on request
    $this->LoginAndRegister($request);

    $body = $request->all();

    $alreadyexists = User::where('username', $body['username'])->first();

    if ($alreadyexists) throw new UserAlreadyExistsException();

    $register = array(
      'username' => $request->input('username'),
      'password' => password_hash($request->input('password'), PASSWORD_DEFAULT),
    );

    $user = User::Create($register);
    return response()->json(['message' => 'User created successfully'], 201);
  }

  /**
   * Function to return an object with JWT token information
   *
   * @param string $token
   * @return void
   */
  public function respondWithToken($token)
  {
    return response()->json([
      'token' => $token,
      'token_type' => 'bearer',
      'expires_in' => Auth::factory()->getTTL() * 60
    ], 200);
  }
}
