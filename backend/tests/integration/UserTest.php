<?php

class UserTest extends TestCase
{
  public function testLogin(): array
  {
    $user = [
      'username' => 'admin',
      'password' => 'admin'
    ];

    $this->post('/authenticate/login', $user);
    $response = json_decode($this->response->content(), true);

    $this->assertArrayHasKey('token', $response);
    $this->assertArrayHasKey('token_type', $response);
    $this->assertArrayHasKey('expires_in', $response);
    return $response;
  }

  /**
   * @depends UserTest::testLogin
   */
  public function testUpdateUser(array $response): void
  {
    $token = $response['token'];

    $newInfo = [
      'username' => 'updated',
      'password' => 'updated'
    ];

    $this->put('/private/2', $newInfo, [
      'Authorization' => "Bearer $token"
    ]);

    $response = json_decode($this->response->content(), true);

    $this->assertArrayHasKey('message', $response);
  }

  /**
   * @depends UserTest::testLogin
   */
  public function testDeleteUser(array $response): void
  {
    $token = $response['token'];
    $this->delete('/private/7', [], [
      'Authorization' => "Bearer $token"

    ]);
    $response2 = json_decode($this->response->content(), true);

    $this->assertArrayHasKey('message', $response2);
  }
}
