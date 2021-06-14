<?php

namespace App\Models\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Facades\Crypt;

class EncryptCast implements CastsAttributes
{
  public function get($model, string $key, $value, array $attributes)
  {
    $app_cipher = env('APP_CIPHER');
    $app_key = env('APP_KEY');
    $iv = env('APP_IV');

    return openssl_decrypt($value, $app_cipher, $app_key, $options = 0, $iv);
  }

  public function set($model, string $key, $value, array $attributes)
  {
    $app_cipher = env('APP_CIPHER');
    $app_key = env('APP_KEY');
    $iv = env('APP_IV');

    return openssl_encrypt($value, $app_cipher, $app_key, $options = 0, $iv);
  }
}
