<?php
//リクエスト残数/リセット時間確認

//共通処理読み込み
require_once ('./include.php');

// 認証の実行（未認証の場合はここでリダイレクト、認証済みの場合はスルー）
$twitter = $auth->authenticate("Twitter"); 

//リクエスト残数/リセット時間取得
$limitResponse = $twitter->api()->get("application/rate_limit_status.json");

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>TwitterPHPLibraryTest TestHybridAuth</title>
</head>
<body>
<h1>リクエスト残数/リセット時間確認</h1>
<a href="./index.php">TOP</a><br />

<textarea rows="40" cols="100">
<?php var_dump($limitResponse); ?>
</textarea>

</body>
</html>