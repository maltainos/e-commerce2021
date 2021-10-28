<?php 
    session_start();
    unset($_SESSION['login']);
    unset($_SESSION['typeuser']);
    unset($_SESSION['email']);
    unset($_SESSION['first_name']);
    unset($_SESSION['last_name']);
    unset($_SESSION['user_id']);
    header("Location:../shop?logout=Sessao terminada...");
?>