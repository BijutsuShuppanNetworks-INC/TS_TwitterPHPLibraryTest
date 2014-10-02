<?php
session_start ();

// tmhOAuth Class
require_once ('./tmhOAuth/tmhOAuth.php');

// consumer_key / consumer_secret
$config = array (
    'consumer_key' => 'M5veDliPN8ehqRZR4VfPXQ',
    'consumer_secret' => 'AlycxH61BFIlgMZU3D8Y2yRG6JsokHfrMkAubzjzimM' 
);

// tmhOAuth Instance
$tmhOAuth = new tmhOAuth ( $config );

// OAuth Start
if (empty ( $_REQUEST ['oauth_token'] )) {
  
  // Create Callback URL (self URL)
  $protocol = 'http';
  if (isset ( $_SERVER ['HTTPS'] ) && strtolower ( $_SERVER ['HTTPS'] ) == 'on') {
    $protocol = 'https';
  } elseif (isset ( $_SERVER ['SERVER_PORT'] ) && ($_SERVER ['SERVER_PORT'] == '443')) {
    $protocol = 'https';
  }
  
  $url = sprintf ( '%s://%s%s', $protocol, $_SERVER ['SERVER_NAME'], $_SERVER ['REQUEST_URI'] );
  
  $code = $tmhOAuth->apponly_request ( array (
      'without_bearer' => true,
      'method' => 'POST',
      'url' => $tmhOAuth->url ( 'oauth/request_token', '' ),
      'params' => array (
          'oauth_callback' => $url 
      ) 
  ) );
  
  if ($code != 200) {
    
    $errorResponse = $tmhOAuth->response ['response'];
    echo ("There was an error communicating with Twitter. {$errorResponse}");
    exit ();
  }
  
  $_SESSION ['oauth'] = $tmhOAuth->extract_params ( $tmhOAuth->response ['response'] );
  
  if ($_SESSION ['oauth'] ['oauth_callback_confirmed'] !== 'true') {
    
    echo ('The callback was not confirmed by Twitter so we cannot continue.');
    exit ();
  } else {
    
    $url = $tmhOAuth->url ( 'oauth/authorize', '' ) . "?oauth_token={$_SESSION['oauth']['oauth_token']}";
    header ( 'Location:' . $url );
    exit ();
  }
} else {
  // OAuth Callback
  if ($_REQUEST ['oauth_token'] !== $_SESSION ['oauth'] ['oauth_token']) {
    echo ('The oauth token you started with doesn\'t match the one you\'ve been redirected with. do you have multiple tabs open?');
    session_unset ();
    exit ();
  }
  
  if (! isset ( $_REQUEST ['oauth_verifier'] )) {
    echo ('The oauth verifier is missing so we cannot continue. did you deny the appliction access?');
    session_unset ();
    exit ();
  }
  
  // update with the temporary token and secret
  $tmhOAuth->reconfigure ( array_merge ( $tmhOAuth->config, array (
      'token' => $_SESSION ['oauth'] ['oauth_token'],
      'secret' => $_SESSION ['oauth'] ['oauth_token_secret'] 
  ) ) );
  
  $code = $tmhOAuth->user_request ( array (
      'method' => 'POST',
      'url' => $tmhOAuth->url ( 'oauth/access_token', '' ),
      'params' => array (
          'oauth_verifier' => trim ( $_REQUEST ['oauth_verifier'] ) 
      ) 
  ) );
  
  if ($code == 200) {
    $oauth_creds = $tmhOAuth->extract_params ( $tmhOAuth->response ['response'] );
    var_dump($oauth_creds);
    echo ("User Token: " . htmlspecialchars ( $oauth_creds ['oauth_token'] ));
    echo ("<br />");
    echo ("User Secret: " . htmlspecialchars ( $oauth_creds ['oauth_token_secret'] ));

  }
}
