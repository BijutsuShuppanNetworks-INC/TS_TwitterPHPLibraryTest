<?php
//共通読み込みファイル

//Hybridクラス読み込み
require_once ('./hybridauth/Hybrid/Auth.php');

// 設定ファイルを引数にして初期化する（配列でもOK）
$auth = new Hybrid_Auth( "./config.php" ); 
