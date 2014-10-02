<?php


require_once ('./include.php');

//tmhOAuth用設定
$tmhConfig = array(
	'consumer_key' => 'M5veDliPN8ehqRZR4VfPXQ',
	'consumer_secret' => 'AlycxH61BFIlgMZU3D8Y2yRG6JsokHfrMkAubzjzimM',
);


// tmhOAuth初期化
//$tmhOAuth = new tmhOAuth( $tmhConfig ); 
$twitter = new tmhOAuth( $tmhConfig ); 


// Request Tokenの取得
$code = $twitter->request('POST', $twitter->url('oauth/request_token', ''));
if ($code != 200)
{
    throw new Exception('Invalid code.');
}
$params = $twitter->extract_params($twitter->response['response']);

// OAuth用のSessionをセット
//Session::set('oauth.params', $params);
var_dump($params);


// 認証画面にリダイレクト
$url = $twitter->url('oauth/authorize', '')."?oauth_token={$params['oauth_token']}";
//Response::redirect($url);
var_dump($url);
