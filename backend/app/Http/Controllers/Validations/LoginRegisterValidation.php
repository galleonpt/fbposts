<?php

namespace App\Http\Controllers\Validations;

use Illuminate\Http\Request;

trait LoginRegisterValidation
{
  public function LoginAndRegister(Request $request)
  {
    return $this->validate($request, [
      'username' => 'string|required|max:255',
      'password' => 'string|required|min:4',
    ]);
  }
}
