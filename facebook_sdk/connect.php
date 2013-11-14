<?php




function get_facebook($appId,$secret)
{
    require 'facebook_sdk/facebook.php';
    
    // Create our Application instance (replace this with your appId and secret).
    $facebook = new Facebook(array(
      'appId'  => $appId,
      'secret' => $secret,
      'cookie' => true,
    ));

    // Get User ID
    $user = $facebook->getUser();


    // We may or may not have this data based on whether the user is logged in.
    //
    // If we have a $user id here, it means we know the user is logged into
    // Facebook, but we don't know if the access token is valid. An access
    // token is invalid if the user logged out of Facebook.

    if ($user) {
      try {
        // Proceed knowing you have a logged in user who's authenticated.
        $user_profile = $facebook->api('/me');
        //$user_friend = $facebook->api('/friend');
      } catch (FacebookApiException $e) {
        error_log($e);
        $user = null;
      }
    }
    
    
    
    // Login or logout url will be needed depending on current user state.
    if ($user) {
      $logoutUrl = $facebook->getLogoutUrl();
    } else {
      $loginUrl = $facebook->getLoginUrl(array('scope'=>'user_groups'));

    }

    if ( isset($loginUrl) )
    {
        $output['is_login'] = false;
        $output['login_url'] = $loginUrl;
    }
    else
    {
        $output['is_login'] = true;
        $output['logout_url'] = $logoutUrl;
        $user_profile['picture'] = 'https://graph.facebook.com/'.$user_profile['id'].'/picture';
        $output['me'] = $user_profile;
        unset($user_profile);
    }
    

    return $output;
}

?>
