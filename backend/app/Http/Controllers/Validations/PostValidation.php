<?php

namespace App\Http\Controllers\Validations;

use Illuminate\Http\Request;

trait PostValidation
{
  public function CreateValidation(Request $request)
  {
    return $this->validate($request, [
      'internalPageId' => 'integer|required',
      'message' => 'string|required|min:1',
      'sendTime' => 'integer|required',
    ]);
  }

  public function UpdateValidation(Request $request)
  {
    return $this->validate($request, [
      'message' => 'string|required|min:1',
      'sendTime' => 'integer|required',
    ]);
  }
}
