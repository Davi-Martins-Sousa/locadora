<?php 
include("../BD/conecta.php");
include("../dao/proprietariosDao.php");
include("cabecalho.php");

$resultadoSQL = getProprietarios(getConection());

echo '<div class="container">
      <table class="table table-hover table-transparent">
        <thead class="table-dark">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Nome</th>
            <th scope="col">Telefone</th>
            <th scope="col">Handle</th>
          </tr>
        </thead>
        <tbody>
';

while($registro = mysqli_fetch_assoc($resultadoSQL)){
    $cpf = $registro['CPF'];
    $nome = $registro['nome'];
    $telefone = $registro['telefone'];

    echo '
      <tr>
        <th scope="row">1</th>
        <td>'.$nome.'</td>
        <td>'.$telefone.'</td>
        <td>@mdo</td>
      </tr>
    ';
}
  echo '  
        </tbody>
      </table>
    </div>
  ';

include("rodape.php");
?>
