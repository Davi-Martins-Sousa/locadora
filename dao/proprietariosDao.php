<?php 
function getProprietarios($connection){
    $query = "SELECT * FROM proprietario";
    $result = mysqli_query($connection, $query);

    if (!$result) {
        die("Erro ao buscar proprietários: " . mysqli_error($connection));
    }

    return $result;
}

function addProprietario($connection, $CPF, $nome, $telefone) {
    $query = "INSERT INTO proprietario (CPF, nome, telefone) VALUES ('".$CPF."', '".$nome."', '".$telefone."')";
    $result = mysqli_query($connection, $query);

    if (!$result) {
        die("Erro ao adicionar proprietário: " . mysqli_error($connection));
    }

    return $result;
}
?>