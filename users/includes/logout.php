<?php
  session_start();
    if(isset($_SESSION['username']) && isset($_SESSION['user_role']) && isset($_SESSION['user_image'])){
      unset($_SESSION['username']); 
      unset($_SESSION['user_role']);
      unset($_SESSION['user_image']);
      header("Location:../index.php");                              
    }else{ 
      echo "<script>alert('INICIAR SESSAO');</script>";
      header("Location:../login.php");
    }
?>