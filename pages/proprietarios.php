<?php 
include("../BD/conecta.php");
include("../dao/proprietariosDao.php");
include("cabecalho.php");

$conexao = getConection();
$resultadoSQL = getProprietarios($conexao);

echo '<div class="container">
      <table class="table table-hover table-transparent">
        <thead>
          <tr>
            <th scope="col"><button type="button" class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#addProprietarioModal">+</button></th>
            <th scope="col">Proprietario</th>
            <th scope="col">Telefone</th>
          </tr>
        </thead>
        <tbody>
';

$id = 0;

while($registro = mysqli_fetch_assoc($resultadoSQL)){
    $id++;
    $cpf = $registro['CPF'];
    $nome = $registro['nome'];
    $telefone = $registro['telefone'];

    echo '
      <tr>
        <th scope="row">'.$id.'</th>
        <td>'.$nome.'</td>
        <td>'.$telefone.'</td>
      </tr>
    ';
}
echo '  
        </tbody>
      </table>
    </div>
  ';

// Modal HTML
echo '
<div class="modal fade" id="addProprietarioModal" tabindex="-1" aria-labelledby="addProprietarioModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addProprietarioModalLabel">Adicionar Proprietário</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="row g-3 needs-validation" id="addProprietarioForm" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post" novalidate>
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingCPF" name="cpf" required>
            <label for="floatingCPF">CPF</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingNome" name="nome" required>
            <label for="floatingNome">Nome</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingTelefone" name="telefone" required>
            <label for="floatingTelefone">Telefone</label>
          </div>
          <div class="col-12">
            <input class="btn btn-outline-primary" type="submit" value="Salvar" name="submit" />
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
';

include("rodape.php");

// Processar o formulário de registro
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $cpf = $_POST["cpf"];
    $nome = $_POST["nome"];
    $telefone = $_POST["telefone"];
    
    // Função para adicionar o novo proprietário ao banco de dados
    $resultado = addProprietario($conexao, $cpf, $nome, $telefone);
    if ($resultado) {
      echo '<script>
              alert("Proprietário adicionado com sucesso!");
              console.log("Proprietário adicionado com sucesso!");
            </script>';
    } else {
      // Exibe mensagem de erro do MySQL no console
      $error_message = mysqli_error($conexao);
      echo '<script>
              alert("Erro ao adicionar proprietário: ' . $error_message . '");
              console.log("Erro ao adicionar proprietário: ' . $error_message . '");
            </script>';
    }
    mysqli_close($conexao);
}
?>

<!-- Bootstrap JS (necessário para o funcionamento do modal) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
