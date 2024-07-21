<?php 
// Função para obter locadoras
function getLocadoras($connection) {
    $query = "SELECT * FROM locadora";
    return mysqli_query($connection, $query);
}

// Função para obter proprietários associados a uma locadora
function getProprietariosByLocadora($connection, $cnpj) {
    $query = "
        SELECT p.CPF, p.nome, p.telefone, po.propiedade
        FROM proprietario p
        JOIN possui po ON p.CPF = po.CPF_proprietario
        WHERE po.CPNJ_locadora = '$cnpj'
    ";
    return mysqli_query($connection, $query);
}

function getProprietariosNaoAssociados($cnpj) {
    $conexao = getConection();

    // Obter todos os proprietários
    $queryTodosProprietarios = "SELECT CPF, nome, telefone FROM proprietario";
    $resultadoTodosProprietarios = mysqli_query($conexao, $queryTodosProprietarios);

    // Obter proprietários já associados à locadora
    $queryProprietariosAssociados = "SELECT CPF_proprietario FROM possui WHERE CPNJ_locadora = '$cnpj'";
    $resultadoProprietariosAssociados = mysqli_query($conexao, $queryProprietariosAssociados);
    $proprietariosAssociados = [];
    while ($row = mysqli_fetch_assoc($resultadoProprietariosAssociados)) {
        $proprietariosAssociados[] = $row['CPF_proprietario'];
    }

    // Filtrar proprietários não associados
    $proprietariosNaoAssociados = [];
    while ($proprietario = mysqli_fetch_assoc($resultadoTodosProprietarios)) {
        if (!in_array($proprietario['CPF'], $proprietariosAssociados)) {
            $proprietariosNaoAssociados[] = $proprietario;
        }
    }

    return $proprietariosNaoAssociados;
}
?>

