<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;
use Illuminate\Http\Request;
use \App\Http\Controllers\Validations\PostValidation;
use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Routing\Controller as BaseController;
use App\Exceptions\InvalidHourException;
use App\Exceptions\PageNotFoundException;
use App\Exceptions\NotAllowedException;
use App\Exceptions\PostNotFoundException;

class PostsController extends BaseController
{
  use PostValidation;

  public function create(Request $request)
  {
    $this->CreateValidation($request);


    $internalID = $request->only('internalPageId');
    $message = ($request->only('message'))['message'];
    $sendTime = ($request->only('sendTime'))['sendTime'];

    $time = time();
    $sendTime = $sendTime - ($sendTime % 60);
    $currentTime = $time - ($time % 60);

    if ($sendTime <= $currentTime) {
      throw new InvalidHourException();
    }

    $page = Page::find($internalID['internalPageId']);

    if ($page == NULL) {
      throw new PageNotFoundException();
    }

    if ($page->userID !== Auth::id()) {
      throw new NotAllowedException();
    }

    $PageAccessToken = $page->FbAccessToken;

    $postData = [
      "PageID" => $page->id,
      "PageAccessToken" => $PageAccessToken,
      "send_time" => $sendTime,
      'message' => $message,
      'userID' => Auth::id()
    ];

    $postData = Post::create($postData);
    $postData->save();

    return response()->json(['message' => 'Post scheduled successfully!'], 201);
  }


  public function destroy($id)
  {
    Post::find($id)->delete();
    return response()->json(['message' => 'Ok'], 200);
  }

  public function update($id, Request $request)
  {
    $this->UpdateValidation($request);

    $post = Post::find($id);

    if (!isset($post)) {
      throw new PostNotFoundException();
    }

    if (isset($request->all()['sendTime'])) {
      $post->update(['send_time' => $request->all()['sendTime']]);
    }

    if (isset($request->all()['message'])) {
      $post->update(['message' => $request->all()['message']]);
    }

    return response()->json(['message' => "Post updated successfully!"], 200);
  }

  public function ListUserPosts()
  {
    return response()->json(Post::where('userID', Auth::id())->paginate(15), 200, [], JSON_UNESCAPED_SLASHES);
  }
}
