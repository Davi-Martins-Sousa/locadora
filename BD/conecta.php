<?php 
    function getConection(){
        $server = "localhost";
        $user = "root";
        $password = "";
        $database = "locadora";
        return mysqli_connect($server,$user,$password,$database);
    }
?>