<?php
//投稿

//共通処理読み込み
require_once ('./include.php');

//hybridauth 認証の実行（未認証の場合はここでリダイレクト、認証済みの場合はスルー）
$hTwitter = $hAuth->authenticate("Twitter");

$hToken = $hTwitter->getAccessToken();


//tmhOAuth用設定
$tmhConfig = array(
	'consumer_key' => 'M5veDliPN8ehqRZR4VfPXQ',
	'consumer_secret' => 'AlycxH61BFIlgMZU3D8Y2yRG6JsokHfrMkAubzjzimM',
	'token' => $hToken['access_token'],
	'secret' => $hToken['access_token_secret'],
);


// tmhOAuth初期化
$tmhOAuth = new tmhOAuth( $tmhConfig ); 


//if (!empty($_POST["text"]) && !empty($_FILES["file"])) {
if (!empty($_FILES["file"])) {
  
    //$image =   $_FILES["file"]["tmp_name"];
    $image =   file_get_contents($_FILES["file"]["tmp_name"]);

    //var_dump($image);
  
    try {
      //投稿
      $url = $tmhOAuth->url("1.1/statuses/update_with_media");
      
      $parameters = array(
          'status' => $_POST["text"],
          'media[]' => $image,
      );
      
      $postResponse  = $tmhOAuth->request("POST", $url , $parameters, true, true);
      $response = $tmhOAuth->response;
      
    } catch (Exception $e) {
      $postResponse = $e;
    }
    
  
}





?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>TwitterPHPLibraryTest 「tmhOAuth」</title>
</head>
<body>
<h1>画像付き</h1>
<a href="./index.php">TOP</a><br />
<br />
投稿フォーム<br />
<form action="./postImage.php" method="POST" enctype="multipart/form-data">
<textarea rows="10" cols="80" name="text"></textarea><br />
<input type="file" name="file"><br />
　※3MBまで<br />
<br />
<input type="submit" value="投稿">
</form>
<br />
<br />

投稿結果<br />
<textarea rows="40" cols="100">
<?php
if (!empty($postResponse)) {
  var_dump($postResponse);

  var_dump($response['response']);
  
}
?>
</textarea>

</body>
</html>