<?php
function getProprietarios($connection){
    $query = "SELECT * FROM proprietario";
    return mysqli_query($connection, $query);
}

function addProprietario($connection, $CPF, $nome, $telefone) {
    // Verificar se o CPF já existe
    $checkQuery = "SELECT * FROM proprietario WHERE CPF = '".$CPF."'";
    $checkResult = mysqli_query($connection, $checkQuery);
    
    if (mysqli_num_rows($checkResult) > 0) {
        // CPF já existe
        return "CPF já existe";
    } else {
        // CPF não existe, pode inserir
        $query = "INSERT INTO proprietario (CPF, nome, telefone) VALUES ('".$CPF."', '".$nome."', '".$telefone."')";
        return mysqli_query($connection, $query);
    }
}
?>
