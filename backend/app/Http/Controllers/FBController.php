<?php

namespace App\Http\Controllers;

session_start();

use App\Exceptions\BadRequestException;
use Laravel\Lumen\Routing\Controller as BaseController;
use Facebook\Facebook as Facebook;
use App\Models\User;
use Symfony\Component\HttpClient\HttpClient;
use App\Models\Page;
use App\Exceptions\PageAlreadyInsertedException;

use Illuminate\Support\Facades\Auth;

class FBController extends BaseController
{
  private function FBObject()
  {
    return new Facebook([
      'app_id' => getenv('FB_APPID'),
      'app_secret' => getenv('FB_APPSECRET'),
      'default_graph_version' => getenv('FB_DEFAULT_GRAPH_VERSION'),
    ]);
  }

  public function FbLogin()
  {
    $fb = $this->FBObject();

    $helper = $fb->getRedirectLoginHelper();
    $permissions = ['pages_manage_posts'];
    $loginUrl = $helper->getLoginUrl('http://localhost/private/fb-callback', $permissions);

    return response()->json(['message' => $loginUrl], 200, [], JSON_UNESCAPED_SLASHES);
  }

  public function FbCallback()
  {
    $fb = $this->FBObject();

    $helper = $fb->getRedirectLoginHelper();

    $accessToken = $helper->getAccessToken();

    if (!isset($accessToken)) {
      throw new BadRequestException();
    }
    $oAuth2Client = $fb->getOAuth2Client();

    $tokenMetadata = $oAuth2Client->debugToken($accessToken);

    $tokenMetadata->validateAppId(getenv('FB_APPID'));

    $tokenMetadata->validateExpiration();

    if (!$accessToken->isLongLived())
      $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);

    $response = $fb->get('/me?fields=id', $accessToken);
    $userID = $response->getGraphUser()['id'];

    $user = User::find(Auth::id());

    $user->update([
      'FbUserID' => "$userID",
      'FbAccessToken' => "$accessToken"
    ]);

    $this->UserPages($user);

    return response()->json(['message' => 'Pages Inserted successfully'], 201);
  }


  /**
   * Function to add all the pages that user give access
   *
   * @param User $user
   * @return void
   */
  private function UserPages($user)
  {
    $client = HttpClient::create();

    $url = env('FB_BASEURL_GETUSERPAGES') . "/v10.0/$user->FbUserID/accounts";

    $pages = $client->request('GET', $url, [
      'query' => [
        'access_token' => "$user->FbAccessToken",
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
  }
}
