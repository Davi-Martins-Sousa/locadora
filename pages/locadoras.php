<?php 
include("../BD/conecta.php");
include("../dao/locadorasDao.php");
include("cabecalho.php");

// Conexão com o banco de dados
$conexao = getConection();

// Processar o formulário de registro de locadora
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $cnpj = $_POST["cnpj"];
    $endereco = $_POST["endereco"];
    $senha = $_POST["senha"];
    $confirmar_senha = $_POST["confirmar_senha"];

    // Verificar se o CNPJ já existe
    $query = "SELECT * FROM locadora WHERE CNPJ = '$cnpj'";
    $resultado = mysqli_query($conexao, $query);

    if (mysqli_num_rows($resultado) > 0) {
        echo '<script>alert("CNPJ já existe no banco de dados!");</script>';
    } elseif ($senha !== $confirmar_senha) {
        echo '<script>alert("As senhas não coincidem!");</script>';
    } else {
        // Adicionar nova locadora ao banco de dados
        $query = "INSERT INTO locadora (CNPJ, endereco, senha) VALUES ('$cnpj', '$endereco', '$senha')";
        if (mysqli_query($conexao, $query)) {
            echo '<script>alert("Locadora adicionada com sucesso!");</script>';
            echo '<script>window.location.href="'.$_SERVER["PHP_SELF"].'";</script>';
        } else {
            echo '<script>alert("Erro ao adicionar locadora: ' . mysqli_error($conexao) . '");</script>';
        }
    }
}

// Processar a atualização de participação de proprietário
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_participacao"])) {
    $cnpj = $_POST["cnpj"];
    $proprietarios = $_POST["proprietarios"];

    $totalParticipacao = 0;
    foreach ($proprietarios as $cpf => $participacao) {
        $totalParticipacao += (float)$participacao;
    }

    if ($totalParticipacao != 1) {
        echo '<script>alert("A soma das participações deve ser igual a 1!");</script>';
    } else {
        foreach ($proprietarios as $cpf => $participacao) {
            $query = "UPDATE possui SET propiedade = '$participacao' WHERE CPF_proprietario = '$cpf' AND CPNJ_locadora = '$cnpj'";
            mysqli_query($conexao, $query);
        }
        echo '<script>alert("Participações atualizadas com sucesso!");</script>';
        echo '<script>window.location.href="'.$_SERVER["PHP_SELF"].'";</script>';
    }
}

// Processar a exclusão de proprietário
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_proprietario"])) {
    $cnpj = $_POST["cnpj"];
    $cpf = $_POST["cpf"];

    $query = "DELETE FROM possui WHERE CPF_proprietario = '$cpf' AND CPNJ_locadora = '$cnpj'";
    if (mysqli_query($conexao, $query)) {
        echo '<script>alert("Proprietário excluído com sucesso!");</script>';
        echo '<script>window.location.href="'.$_SERVER["PHP_SELF"].'";</script>';
    } else {
        echo '<script>alert("Erro ao excluir proprietário: ' . mysqli_error($conexao) . '");</script>';
    }
}

// Processar a adição de proprietário
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_proprietario"])) {
    $cnpj = $_POST["cnpj"];
    $cpf = $_POST["cpf"];
    $participacao = $_POST["participacao"];

    $query = "INSERT INTO possui (CPF_proprietario, CPNJ_locadora, propiedade) VALUES ('$cpf', '$cnpj', '$participacao')";
    if (mysqli_query($conexao, $query)) {
        echo '<script>alert("Proprietário adicionado com sucesso!");</script>';
        echo '<script>window.location.href="'.$_SERVER["PHP_SELF"].'";</script>';
    } else {
        echo '<script>alert("Erro ao adicionar proprietário: ' . mysqli_error($conexao) . '");</script>';
    }
}

// Obter locadoras do banco de dados
$locadoras = getLocadoras($conexao);

echo '
<div class="container my-3">
    <!-- Botão para adicionar nova locadora -->
    <div class="text-center mb-3">
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addLocadoraModal">
            Adicionar Locadora
        </button>
    </div>

    <!-- Accordion para as locadoras -->
    <div class="accordion accordion-flush" id="accordionLocadoras">
';

// Loop para criar cada item do Accordion para cada locadora
while ($locadora = mysqli_fetch_assoc($locadoras)) {
    $cnpj = $locadora['CNPJ'];
    $endereco = $locadora['endereco'];

    // Define IDs únicos para cada item do Accordion
    $accordionID = "flush-collapse" . $cnpj;
    $headingID = "heading" . $cnpj;

    // Obter os proprietários da locadora
    $proprietarios = getProprietariosByLocadora($conexao, $cnpj);

    // Verifica se há proprietários associados
    $temProprietarios = mysqli_num_rows($proprietarios) > 0;

    echo '
    <div class="accordion-item">
        <h2 class="accordion-header" id="' . $headingID . '">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#' . $accordionID . '" aria-expanded="false" aria-controls="' . $accordionID . '">
                Locadora: ' . $cnpj . ' - ' . $endereco . '
            </button>
        </h2>
        <div id="' . $accordionID . '" class="accordion-collapse collapse" data-bs-parent="#accordionLocadoras">
            <div class="accordion-body">
';

    if ($temProprietarios) {
        echo '
        <form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post">
            <input type="hidden" name="cnpj" value="' . $cnpj . '">
            <table class="table table-hover table-transparent">
                <thead>
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">Telefone</th>
                        <th scope="col">Participação</th>
                        <th scope="col">Ação</th>
                    </tr>
                </thead>
                <tbody>';

        while ($proprietario = mysqli_fetch_assoc($proprietarios)) {
            echo '<tr>
                    <td>' . $proprietario['nome'] . '</td>
                    <td>' . $proprietario['telefone'] . '</td>
                    <td><input type="number" step="0.01" min="0" max="1" class="form-control" name="proprietarios[' . $proprietario['CPF'] . ']" value="' . $proprietario['propiedade'] . '"></td>
                    <td>
                        <form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post" style="display:inline;">
                            <input type="hidden" name="cnpj" value="' . $cnpj . '">
                            <input type="hidden" name="cpf" value="' . $proprietario['CPF'] . '">
                            <button type="submit" class="btn btn-outline-danger" name="delete_proprietario">Excluir</button>
                        </form>
                    </td>
                  </tr>';
        }

        echo '      </tbody>
            </table>
            <div class="d-flex justify-content-center gap-2 mt-3">
                <button type="submit" class="btn btn-outline-success" name="update_participacao">Atualizar Participações</button>
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addProprietarioModal" data-cnpj="' . $cnpj . '">Adicionar Proprietário</button>
            </div>
        </form>';
    } else {
        echo '<p>Sem proprietários associados.</p>';
        echo '<div class="d-flex justify-content-center mt-3">
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addProprietarioModal" data-cnpj="' . $cnpj . '">Adicionar Proprietário</button>
              </div>';
    }

    echo '      </div>
        </div>
    </div>';
}

echo '
    </div>
</div>

<!-- Modal HTML para adicionar locadora -->
<div class="modal fade" id="addLocadoraModal" tabindex="-1" aria-labelledby="addLocadoraModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addLocadoraModalLabel">Adicionar Locadora</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post" novalidate>
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingCNPJ" name="cnpj" required>
            <label for="floatingCNPJ">CNPJ</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingEndereco" name="endereco" required>
            <label for="floatingEndereco">Endereço</label>
          </div>
          <div class="form-floating mb-3">
            <input type="password" class="form-control" id="floatingSenha" name="senha" required>
            <label for="floatingSenha">Senha</label>
          </div>
          <div class="form-floating mb-3">
            <input type="password" class="form-control" id="floatingConfirmarSenha" name="confirmar_senha" required>
            <label for="floatingConfirmarSenha">Confirmar Senha</label>
          </div>
          <div class="col-12">
            <input class="btn btn-outline-primary" type="submit" value="Salvar" name="submit" />
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal HTML para adicionar proprietário -->
<div class="modal fade" id="addProprietarioModal" tabindex="-1" aria-labelledby="addProprietarioModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addProprietarioModalLabel">Adicionar Proprietário</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post" novalidate>
          <input type="hidden" id="modalCNPJ" name="cnpj">
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingCPF" name="cpf" required>
            <label for="floatingCPF">CPF</label>
          </div>
          <div class="form-floating mb-3">
            <input type="number" step="0.01" min="0" max="1" class="form-control" id="floatingParticipacao" name="participacao" required>
            <label for="floatingParticipacao">Participação</label>
          </div>
          <div class="col-12">
            <input class="btn btn-outline-primary" type="submit" value="Adicionar" name="add_proprietario" />
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
';

include("rodape.php");
?>

<!-- Bootstrap JS (necessário para o funcionamento do modal e accordion) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
<script>
    // Passar CNPJ do botão para o modal de adicionar proprietário
    document.addEventListener('click', function (event) {
        if (event.target.matches('[data-bs-target="#addProprietarioModal"]')) {
            const cnpj = event.target.getAttribute('data-cnpj');
            document.getElementById('modalCNPJ').value = cnpj;
        }
    });
</script>
