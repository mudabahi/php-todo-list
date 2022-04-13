<?php


    try{
        $conn = new mysqli("localhost", "root", "", "todo-list");

        if($conn){
            // echo "Connection successfully";
        }else{
            throw new Exception("Error in connection");
        }
    }catch(Exception $error){
        echo $error->getMessage();
    }
?>