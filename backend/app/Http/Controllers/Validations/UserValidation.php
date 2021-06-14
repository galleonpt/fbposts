<?php

namespace App\Http\Controllers\Validations;

use Illuminate\Http\Request;

trait UserValidation
{
  public function CreateAndUpdate(Request $request)
  {
    return $this->validate($request, [
      'password' => 'string|required|min:6',
    ]);
  }
}
