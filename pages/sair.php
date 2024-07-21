<?php include("cabecalho.php");?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['sair'])) {
    $_SESSION = array();

    session_destroy();

    header("Location: login.php");
    exit();
}
?>
<div class="container d-flex vh-100">
    <div class="row justify-content-center align-self-center w-100">
        <div class="col-md-6 text-center">
            <h2>Você deseja sair?</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="col-12">
                    <input class="btn btn-outline-danger" type="submit" value="Sair" name="sair"/>
                </div>
            </form>
        </div>
    </div>
</div>


<?php include("Rodape.php");?>
