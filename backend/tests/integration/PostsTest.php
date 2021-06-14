<?php

use App\Models\Page;
use App\Models\Post;

class PostTest extends TestCase
{
  /**
   * @depends UserTest::testLogin
   */
  public function testCreatePost(array $response): void
  {
    $token = $response['token'];

    $data = [
      "internalPageId" => 1,
      "message" => "novo metodo de encriptaçao",
      "sendTime" =>   1741633568,
    ];

    $this->post('/private/posts', $data, [
      'Authorization' => "Bearer $token"
    ]);
    $response2 = json_decode($this->response->content(), true);

    $this->assertArrayHasKey('message', $response2);
    $this->assertResponseStatus(201);
  }

  /**
   * @depends UserTest::testLogin
   * @depends testCreatePost
   */
  public function testUpdatePost(array $response): void
  {
    $token = $response['token'];

    $data = [
      "message" => "123",
      'sendTime' => 1915400832
    ];

    $post = Post::first();
    $this->put("/private/posts/$post->_id", $data, [
      'Authorization' => "Bearer $token"
    ]);
    $response2 = json_decode($this->response->content(), true);

    $this->assertArrayHasKey('message', $response2);
    $this->assertResponseStatus(200);
  }

  /**
   * @depends UserTest::testLogin
   * @depends testCreatePost
   */
  public function testDeletePost(array $response): void
  {
    $token = $response['token'];

    $post = Post::first();

    $this->delete("/private/posts/$post->_id", [], [
      'Authorization' => "Bearer $token"
    ]);
    $response2 = json_decode($this->response->content(), true);

    $this->assertArrayHasKey('message', $response2);
    $this->assertResponseStatus(200);
  }
}
