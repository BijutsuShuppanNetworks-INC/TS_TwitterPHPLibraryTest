<?php
//投稿

//共通処理読み込み
require_once ('./include.php');


//if (!empty($_POST["text"]) && !empty($_FILES["file"])) {
if (!empty($_FILES["file"]) && !empty($_POST["access_token"]) && !empty($_POST["access_token_secret"])) {

    //tmhOAuth用設定
    $tmhConfig = array(
    	'consumer_key' => 'M5veDliPN8ehqRZR4VfPXQ',
    	'consumer_secret' => 'AlycxH61BFIlgMZU3D8Y2yRG6JsokHfrMkAubzjzimM',
    	'token' => $_POST['access_token'],
    	'secret' => $_POST['access_token_secret'],
    );
    
    // tmhOAuth初期化
    $tmhOAuth = new tmhOAuth( $tmhConfig ); 


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
<h1>トークン入力画像付き投稿</h1>
<a href="./index.php">TOP</a><br />
<br />
投稿フォーム<br />
<form action="./postImageWithToken.php" method="POST" enctype="multipart/form-data">
access_token:<input type="text" name="access_token"><br />
access_token_secret:<input type="text" name="access_token_secret"><br />
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