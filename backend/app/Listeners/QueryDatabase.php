<?php

namespace App\Listeners;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Log;

class QueryDatabase
{
  private $transaction = null;
  /**
   * Create the event listener.
   *
   * @return void
   */
  public function __construct()
  {
  }

  /**
   * Handle the event.
   *
   * @param  QueryExecuted  $event
   * @return void
   */
  public function handle(QueryExecuted $event)
  {
    Log::info(json_encode($event));
  }
}
