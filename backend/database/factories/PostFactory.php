<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Post::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return  [
      'message' => Str::random(50),
      'send_time' => $this->faker->unixTime(time() + 473353890),
      'PageAccessToken' => Str::random(10),
      'sendStatus' => 1,
    ];
  }
}
