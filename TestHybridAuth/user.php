<?php
//ユーザ情報取得

//共通処理読み込み
require_once ('./include.php');

// 認証の実行（未認証の場合はここでリダイレクトされ、認証済みの場合はスルーされます）
$twitter = $auth->authenticate("Twitter"); 


try {
  //ユーザ情報取得
  $userResponse = $twitter->getUserProfile();
  
} catch (Exception $e) {
  var_dump('error catch');
  $userResponse = $e;
//  var_dump($e);
}


//リクエスト残数/リセット時間取得
$limitResponse = $twitter->api()->get("application/rate_limit_status.json");

//ユーザ情報取得のリクエスト残数を取得
$limitData = $limitResponse->resources->account->{'/account/verify_credentials'};

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>TwitterPHPLibraryTest TestHybridAuth</title>
</head>
<body>
<h1>ユーザ情報取得</h1>
<a href="./index.php">TOP</a><br />
<br />
リクエスト最大：<?php echo $limitData->limit ?> / リクエスト残数：<?php echo $limitData->remaining ?> / リセット時間：<?php echo date("Y-m-d H:i:s", $limitData->reset) ?><br />
<br />
<textarea rows="40" cols="100">
<?php var_dump($userResponse); ?>
</textarea>

</body>
</html>