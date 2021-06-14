<?php

namespace App\Models;

use App\Models\Casts\EncryptCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Mongo;

class Post extends Mongo
{
  use HasFactory;
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $connection = 'mongodb';
  protected $collection = 'post';
  public $timestamps = false;
  protected $fillable = [
    'PageID', 'PageAccessToken', 'send_time', 'message', 'userID', 'fbPostID', 'sendStatus'
  ];

  const ERROR = 0;
  const SCHEDULED = 1;
  const PROCESSING = 2;
  const SENT = 3;

  protected $attributes = [
    'sendStatus' => Post::SCHEDULED
  ];

  protected $hidden = [
    'PageAccessToken'
  ];

  protected $casts = [
    'PageAccessToken' => EncryptCast::class,
  ];

  public function page()
  {
    return $this->belongsTo(Page::class, 'PageID', 'id');
  }

  public function user()
  {
    return $this->belongsTo(User::class, 'userID', 'id');
  }
}
