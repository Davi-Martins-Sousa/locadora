<?php 
include("../BD/conecta.php");
include("../dao/proprietariosDao.php");
include("cabecalho.php");

$resultadoSQL = getProprietarios(getConection());

while($registro = mysqli_fetch_assoc($resultadoSQL)){
    $cpf = $registro['CPF'];
    $nome = $registro['nome'];
    $telefone = $registro['telefone'];

    echo '<div class="container">
                <form class="row g-3 needs-validation" action="" method="post" novalidate>
                  <div class="col-md-2">
                    '.$data.'
                  </div>
                  <div class="col-md-8">
                    '.$nome.': '.$conteudo.'
                  </div>
                  <div class="col-md-2">
                    <a class="btn btn-primary" href=comentarios.php?id='.$id.' name="id">Comentários</a>
                  </div>
                </form>
              </div>';
}




include("rodape.php");
?>