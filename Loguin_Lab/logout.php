<?php
if(!isset($_SESSION)){
    session_start();
    session_destroy();
    header("location: ../Loguin_Lab/index_login.php");
}
?>