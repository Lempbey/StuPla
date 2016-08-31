<?php
    session_start();
    $_SESSION["userid"]=1;
    if(!isset($_SESSION['userid'])) {
        die('Bitte zuerst <a href="login.php">einloggen</a>');
    }
    $userid = $_SESSION['userid'];
    echo '<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#hidden").load("data.php",{userid:1});
            window.location.replace("n_user_data.php");
        });
    </script>';
?>