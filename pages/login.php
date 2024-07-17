<?php
include("cabecalho.php");
include("../BD/conecta.php");
include("../dao/locadorasDao.php");
?>

<div class="container">
    <form class="row g-3 needs-validation" id="loginForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate>
        <div>
            <div class="col-md-4 mx-auto">
                <label for="validationCustom01" class="form-label">Nome de Usuário</label>
                <input type="text" class="form-control" id="validationCustom01" name="username" required>
                <div class="invalid-feedback">
                    Por favor, insira seu nome de usuário.
                </div>
            </div>
        </div>
        <div>
            <div class="col-md-4  mx-auto">
                <label for="validationCustom02" class="form-label">Senha</label>
                <input type="password" class="form-control" id="validationCustom02" name="password" required>
                <div class="invalid-feedback">
                    Por favor, insira sua senha.
                </div>
            </div>
        </div>
        <div class="col-12">
            <input class="btn btn-primary" type="submit" value="Entrar" name="submit" />
            <div class="col-12">

                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $username = $_POST["username"];
                    $password = $_POST["password"];

                    if ($username == 'admin' && $password == 'admin') {
                        $_SESSION['locadora_CNPJ'] = 'admin';
                        $_SESSION['privilegio'] = 'admin';
                        echo "Login realizado com sucesso!";
                        header("Location: index.php");
                        exit();
                    } else {
                        $conexao = getConection();
                        if (!$conexao) {
                            die("Erro ao conectar ao banco de dados.");
                        }

                        $usuario = getLocadoraByCNPJ($conexao, $username);
                        if ($usuario && mysqli_num_rows($usuario) > 0) {
                            $row = mysqli_fetch_assoc($usuario);
                            if ($row['senha'] == $password) {
                                $_SESSION['locadora_CNPJ'] = $row['CNPJ'];
                                $_SESSION['privilegio'] = 'comum';
                                echo "Login realizado com sucesso!";
                                header("Location: index.php");
                                exit();
                            }
                        }
                        echo "Usuário ou senha incorretos!";
                        mysqli_close($conexao);
                    }
                }
                ?>

            </div>
    </form>
</div>
<?php include("Rodape.php"); ?>
