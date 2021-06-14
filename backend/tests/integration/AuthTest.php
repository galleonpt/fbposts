<?php

use App\Models\Page;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Symfony\Component\VarDumper\VarDumper;

class AuthTest extends TestCase
{
  protected function mySetUp(): void
  {
    DB::statement('DELETE FROM Pages where id != -1');
    DB::statement('DELETE FROM Users where id != -1');
    DB::statement('ALTER TABLE Pages AUTO_INCREMENT = 1;');
    DB::statement('ALTER TABLE Users AUTO_INCREMENT = 1;');


    parent::setUp();
    Artisan::call('db:seed', ['--class' => 'DatabaseSeeder']);

    // User::factory()
    //   ->has(
    //     Page::factory()
    //       ->count(5)->has(
    //         Post::factory()
    //           ->count(5)
    //       )
    //   )
    //   ->count(5)
    //   ->create();

    // $user = User::factory();
    // $page = Page::factory(['userID' => $user->id]);
    // $post = Post::factory(['userID' => $user->id, 'PageID' => $page->id]);
  }

  public function testRegister(): void
  {
    $this->mySetUp();
    $user = [
      'username' => 'teste123',
      'password' => 'teste123'
    ];

    $response = $this->post('/authenticate/register', $user);
    $response = json_decode($this->response->content(), true);

    $this->assertArrayHasKey('message', $response);
  }

  public function testFailRegister(): void
  {
    $user = [
      'username' => 'admin',
      'password' => 'admin123'
    ];

    $this->post('/authenticate/register', $user);
    $response = json_decode($this->response->content(), true);

    $this->assertArrayHasKey('message', $response);
  }

  /**
   * @depends testRegister
   */
  public function testLogin(): void
  {
    $user = [
      'username' => 'teste123',
      'password' => 'teste123'
    ];

    $this->post('/authenticate/login', $user);
    $response = json_decode($this->response->content(), true);

    $this->assertArrayHasKey('token', $response);
    $this->assertArrayHasKey('token_type', $response);
    $this->assertArrayHasKey('expires_in', $response);
  }

  public function testLoginWithUnknownUser(): void
  {
    $user = [
      'username' => 'qwerty',
      'password' => 'qwerty'
    ];

    $this->post('/authenticate/login', $user);
    $response = json_decode($this->response->content(), true);

    $this->assertArrayHasKey('message', $response);
    $this->assertSame('User not found!', $response['message']);
  }
}
