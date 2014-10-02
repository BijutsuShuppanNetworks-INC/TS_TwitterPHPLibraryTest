<?php
//リクエスト残数/リセット時間確認

//共通処理読み込み
require_once ('./include.php');

// 認証の実行（未認証の場合はここでリダイレクト、認証済みの場合はスルー）
$twitter = $auth->authenticate("Twitter"); 

//リクエスト残数/リセット時間取得
$response = $twitter->api()->get("help/configuration.json");

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>TwitterPHPLibraryTest TestHybridAuth</title>
</head>
<body>
<h1>help/configuration</h1>
<a href="./index.php">TOP</a><br />

<textarea rows="40" cols="100">
<?php var_dump($response); ?>
</textarea>

</body>
</html>