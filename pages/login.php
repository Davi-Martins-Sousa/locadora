<?php
include("cabecalho.php");
include("../BD/conecta.php");
include("../dao/locadorasDao.php");
?>

<div class="container d-flex vh-100">
    <div class="row justify-content-center align-self-center w-100">
        <form class="row g-3 needs-validation col-md-6" id="loginForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate>
            <div>
                <div class="form-floating mx-auto">
                    <input type="email" class="form-control" id="floatingInput1" name="username" required>
                    <label for="floatingInput1">CNPJ</label>
                </div>
            </div>
            <div>
                <div class="form-floating mx-auto">
                    <input type="password" class="form-control" id="floatingInput2" name="password" required>
                    <label for="floatingInput2">Senha</label>
                </div>
            </div>

            <div class="col-12">
                <input class="btn btn-outline-primary" type="submit" value="Entrar" name="submit" />
            </div>

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
</div>

<?php include("Rodape.php"); ?>
