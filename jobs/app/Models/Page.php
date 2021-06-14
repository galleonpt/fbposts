<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Casts\EncryptCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Page extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $table = 'Pages';
  protected $connection = 'mysql';
  public $timestamps = false;
  protected $fillable = [
    'name', 'FbAccessToken', 'userID'
  ];

  protected $casts = [
    'FbID' => EncryptCast::class,
    'FbAccessToken' => EncryptCast::class,
  ];

  public function scopePageId($query, $page_id)
  {
    $app_cipher = env('APP_CIPHER');
    $app_key = env('APP_KEY');
    $iv = env('APP_IV');

    $value = openssl_encrypt($page_id, $app_cipher, $app_key, $options = 0, $iv); // Encrypt id of page to test

    return $query->where('FbID', $value);
  }

  //relationship with Post table
  // public function post()
  // {
  //   return $this->hasMany(Post::class, 'PageID', 'id');
  // }
}
