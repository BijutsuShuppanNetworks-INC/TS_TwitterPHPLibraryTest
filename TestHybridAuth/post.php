<?php
//投稿

//共通処理読み込み
require_once ('./include.php');

// 認証の実行（未認証の場合はここでリダイレクト、認証済みの場合はスルー）
$twitter = $auth->authenticate("Twitter"); 

if (!empty($_POST["text"])) {

    try {
      //投稿
      //$postResponse = $twitter->setUserStatus($_POST["text"]);
      
      $parameters = array( 'status' => $_POST["text"] ); 
      $postResponse  = $twitter->api()->post( 'statuses/update.json', $parameters ); 
      
      
    } catch (Exception $e) {
      $postResponse = $e;
    }
    
  
}





?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>TwitterPHPLibraryTest TestHybridAuth</title>
</head>
<body>
<h1>投稿</h1>
<a href="./index.php">TOP</a><br />
<br />
投稿フォーム<br />
<form action="./post.php" method="POST">
<textarea rows="10" cols="80" name="text"></textarea><br />
<input type="submit" value="投稿">
</form>
<br />
<br />

投稿結果<br />
<textarea rows="40" cols="100">
<?php
if (!empty($postResponse)) {
  var_dump($postResponse);
}
?>
</textarea>

</body>
</html>