<?php 
    function getLocadora($connection){
        $query = "SELECT * FROM locadora";
        return mysqli_query($connection, $query);
    }

    function getLocadoraByCNPJ($conexao, $cnpj) {
        $query = "SELECT * FROM locadora WHERE CNPJ = '$cnpj'";
        $resultado = mysqli_query($conexao, $query);
        return $resultado;
    }
?>
