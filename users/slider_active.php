<?php
    session_start();
    require "require/connection.php";
    if(isset($_GET['id']) && isset($_SESSION['user_id'])){
        $status = "inactive";
        $slider_query = "UPDATE slider SET status =:status";
        $statement = $conn->prepare($slider_query);
        $statement->bindParam(':status',$status);
        $statement->execute();
        $status = "active";
        $slider_query = "UPDATE slider SET status =:status WHERE id=:id";
        $statement = $conn->prepare($slider_query);
        $statement->bindParam(':id',$_GET['id']);
        $statement->bindParam(':status',$status);
        $statement->execute(); 
        header("Location:slider.php");
    }else{
        header("Location:../login.php");
    }
?>