<?php
function getProprietarios($connection){
    $query = "SELECT * FROM proprietario";
    return mysqli_query($connection, $query);
}

function addProprietario($connection, $CPF, $nome, $telefone) {
    $checkQuery = "SELECT * FROM proprietario WHERE CPF = '".$CPF."'";
    $checkResult = mysqli_query($connection, $checkQuery);
    
    if (mysqli_num_rows($checkResult) > 0) {
        return "CPF já existe";
    } else {
        $query = "INSERT INTO proprietario (CPF, nome, telefone) VALUES ('".$CPF."', '".$nome."', '".$telefone."')";
        return mysqli_query($connection, $query);
    }
}

function deleteProprietario($connection, $CPF) {
    // Verificar se o proprietário está associado a alguma locadora
    $checkQuery = "SELECT * FROM possui WHERE CPF_proprietario = '".$CPF."'";
    $checkResult = mysqli_query($connection, $checkQuery);
    
    if (mysqli_num_rows($checkResult) > 0) {
        return "Proprietário está associado a uma locadora";
    } else {
        $query = "DELETE FROM proprietario WHERE CPF = '".$CPF."'";
        return mysqli_query($connection, $query) ? true : mysqli_error($connection);
    }
}
?>
