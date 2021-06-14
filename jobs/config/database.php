<?php

use Illuminate\Support\Str;

return [

  'default' => env('DB_CONNECTION', 'mysql'),

  'connections' => [

    'mysql' => [
      'driver' => 'mysql',
      'host' => env('DB_HOST', '127.0.0.1'),
      'port' => env('DB_PORT', 3306),
      'database' => env('DB_DATABASE', 'forge'),
      'username' => env('DB_USERNAME', 'forge'),
      'password' => env('DB_PASSWORD', ''),
      'unix_socket' => env('DB_SOCKET', ''),
      'charset' => env('DB_CHARSET', 'utf8mb4'),
      'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
      'prefix' => env('DB_PREFIX', ''),
      'strict' => env('DB_STRICT_MODE', true),
      'engine' => env('DB_ENGINE', null),
      'timezone' => env('DB_TIMEZONE', '+00:00'),
    ],

    'mongodb' => [
      'name' => 'mongodb',
      'driver'   => 'mongodb',
      'host'     => env('MONGO_DB_HOST', 'localhost'),
      'port'     => env('MONGO_DB_PORT', 27017),
      'database' => env('MONGO_DB_DATABASE'),
      'username' => env('MONGO_DB_USERNAME'),
      'password' => env('MONGO_DB_PASSWORD'),
      'options'  => [
        'database' => env('DB_AUTHENTICATION_DATABASE', 'admin')
      ]
    ],
  ],

  'migrations' => 'migrations',

  'redis' => [

    'client' => env('REDIS_CLIENT', 'phpredis'),

    'options' => [
      'cluster' => env('REDIS_CLUSTER', 'redis'),
      'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'lumen'), '_') . '_database_'),
    ],

    'default' => [
      'url' => env('REDIS_URL'),
      'host' => env('REDIS_HOST', '127.0.0.1'),
      'password' => env('REDIS_PASSWORD', null),
      'port' => env('REDIS_PORT', '6379'),
      'database' => env('REDIS_DB', '0'),
    ],

    'cache' => [
      'url' => env('REDIS_URL'),
      'host' => env('REDIS_HOST', '127.0.0.1'),
      'password' => env('REDIS_PASSWORD', null),
      'port' => env('REDIS_PORT', '6379'),
      'database' => env('REDIS_CACHE_DB', '1'),
    ],

  ],


];
