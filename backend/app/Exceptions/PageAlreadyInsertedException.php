<?php

namespace App\Exceptions;


use Throwable;
use Exception;
use Illuminate\Support\Facades\Log;

class PageAlreadyInsertedException extends Exception
{

  public function __construct()
  {
    $this->message = 'Page already inserted!';
    $this->code = 422;
  }

  /**
   * Report or log an exception.
   *
   * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
   *
   * @param  \Throwable  $exception
   * @return void
   *
   * @throws \Exception
   */
  public function report()
  {
    Log::error($this->__toString());
  }

  /**
   * Render an exception into an HTTP response.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Throwable  $exception
   * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
   *
   * @throws \Throwable
   */
  public function render()
  {
    return response()->json([
      'message' => $this->message
    ], $this->code);
  }
}
