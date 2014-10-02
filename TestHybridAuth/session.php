<?php

session_start();

$_SESSION["test"] = "success";



var_dump($_SESSION["test"]);

?>

<a href="./session2.php">go</a>