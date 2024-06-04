<?php 
    function getProprietarios($connection){
        $query = "SELECT * FROM proprietario";
        return mysqli_query($connection, $query);
    }
?>