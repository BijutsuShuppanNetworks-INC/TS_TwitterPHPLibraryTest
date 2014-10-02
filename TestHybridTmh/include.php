<?php
//共通読み込みファイル

//tmhOAuthクラス読み込み
require_once ('./tmhOAuth/tmhOAuth.php');


//tmhOAuthの認証は面倒なのでhybridauthを使う
require_once ('../TestHybridAuth/hybridauth/Hybrid/Auth.php');

// 設定ファイルを引数にして初期化する（配列でもOK）
$hAuth = new Hybrid_Auth( "../TestHybridAuth/config.php" ); 

