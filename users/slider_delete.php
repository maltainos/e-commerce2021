<?php
    session_start();
    function redirect($user_role){
        if($user_role == 1){
            header('Location:../admin');
        }else if($user_role == 3){
            header('Location:../customer');
        }else if($user_role != 2){
            header('Location:../index.php');
        }        
    }
    if(isset($_SESSION['username']) && isset($_SESSION['user_role']) && isset($_SESSION['user_image'])){
        redirect($_SESSION['user_role']);
        require_once 'require/connection.php';
        $sql = "DELETE FROM slider WHERE id=:lid";
        $query =  $conn->prepare($sql);
        $query->bindParam(':lid',$_GET['id'], PDO::PARAM_INT);
        $query->execute();
        header("Location:slider.php");                      
    }else{
        header('Location:../index.php');
    }  
?>