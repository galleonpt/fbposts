<?php

namespace App\Exceptions;


use Throwable;
use Exception;
use Illuminate\Support\Facades\Log;

class InvalidHourException extends Exception
{

  public function __construct()
  {
    $this->message = 'Invalid Hour!';
    $this->code = 400;
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
