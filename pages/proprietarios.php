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
            <th scope="col">Ações</th>
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
        <td>
          <form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post" style="display:inline;">
            <input type="hidden" name="cpf_to_delete" value="'.$cpf.'">
            <button type="submit" name="delete" class="btn btn-outline-danger btn-sm">Deletar</button>
          </form>
        </td>
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
        <div id="debug-info" class="mt-3"></div> <!-- Div para mensagens de depuração -->
      </div>
    </div>
  </div>
</div>
';

include("rodape.php");

// Processar o formulário de registro
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["submit"])) {
        $cpf = $_POST["cpf"];
        $nome = $_POST["nome"];
        $telefone = $_POST["telefone"];
        
        $resultado = addProprietario($conexao, $cpf, $nome, $telefone);
        if ($resultado === true) {
            echo '<script>
                    alert("Proprietário adicionado com sucesso!");
                    window.location.href="'.$_SERVER["PHP_SELF"].'";
                  </script>';
        } elseif ($resultado === "CPF já existe") {
            echo '<script>alert("Erro: CPF já existe.");</script>';
        } else {
            $error_message = mysqli_error($conexao);
            echo '<script>alert("Erro ao adicionar proprietário: ' . $error_message . '");</script>';
        }
    } elseif (isset($_POST["delete"])) {
        $cpf_to_delete = $_POST["cpf_to_delete"];
        
        $deleteResult = deleteProprietario($conexao, $cpf_to_delete);
        if ($deleteResult === true) {
            echo '<script>
                    alert("Proprietário deletado com sucesso!");
                    window.location.href="'.$_SERVER["PHP_SELF"].'";
                  </script>';
        } else {
            echo '<script>alert("Erro ao deletar proprietário: ' . $deleteResult . '");</script>';
        }
    }
    mysqli_close($conexao);
}
?>

<!-- Bootstrap JS (necessário para o funcionamento do modal) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
