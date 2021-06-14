<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpClient\HttpClient;
use App\Models\User;
use App\Models\Page;
use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Routing\Controller as BaseController;
use App\Exceptions\UserNotFoundException;
use App\Exceptions\PageAlreadyInsertedException;


class PagesController extends BaseController
{
  /**
   * Function to get all facebook pages from one user
   *
   * @param int $id
   * @return void
   */
  public function GetAllPagesFromUser()
  {
    $user = User::find(Auth::id());

    if (!$user) {
      throw new UserNotFoundException();
    }

    $FBUserID = $user->FbUserID;
    $accessToken = $user->FbAccessToken;

    $client = HttpClient::create();

    $url = env('FB_BASEURL_GETUSERPAGES') . "/v10.0/$FBUserID/accounts";

    $pages = $client->request('GET', $url, [
      'query' => [
        'access_token' => "$accessToken",
      ]
    ]);

    $pagesArray = json_decode($pages->getContent());

    foreach ($pagesArray->data as $data) {
      $pageInfo = [
        'FbID' => $data->id,
        'name' => $data->name,
        'FbAccessToken' => $data->access_token,
        'userID' => $user->id
      ];

      $alreadyInserted = Page::where('userID', $user->id)->pageId($pageInfo['FbID'])->first();

      if (isset($alreadyInserted)) {
        throw new PageAlreadyInsertedException();
      }

      $data = Page::create($pageInfo);
      $data->save();
    }
    return response()->json(['message' => 'Pages Inserted successfully'], 201);
  }
}
