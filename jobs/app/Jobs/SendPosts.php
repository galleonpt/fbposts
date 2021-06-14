<?php

namespace App\Jobs;

use App\Models\Post;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Symfony\Component\HttpClient\HttpClient;
use App\Models\State;


class SendPosts extends Job implements ShouldQueue
{
  use InteractsWithQueue, Queueable, SerializesModels;

  private $post;
  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct($post)
  {
    $this->post = $post;
  }

  /**
   * Execute the job.
   *
   *  Job que vai ser executado no Redis
   * 
   * @return void
   */
  public function handle()
  {
    // funçao para fazer os posts no fb
    $client = HttpClient::create();

    $url = "https://graph.facebook.com/" . $this->post['PageID']  . "/feed";

    $response = $client->request(
      'POST',
      $url,
      [
        'body' => [
          'message' => $this->post['message'],
          'access_token' => $this->post['PageAccessToken']
        ],
        'timeout' => env('PROCESSING_TIME') + 60 //somar estes 60 pk se der erro no min 20 so vai ser alterado o estado no min 21 entao assim conseguir ter menos um request com erro
      ]
    );

    $fbID = (json_decode($response->getContent()))->id;

    $post = Post::find($this->post['id']);

    if (($response->getStatusCode()) == 200) {
      $post->fbPostID = $fbID;
      $post->sendStatus = Post::SENT;
    } else {
      $post->sendStatus = Post::ERROR;
    }
    $post->save();
  }
}
