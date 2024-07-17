<?php include("cabecalho.php");?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['sair'])) {
    $_SESSION = array();

    session_destroy();

    header("Location: login.php");
    exit();
}
?>

<div class="container">
    <h2>Você deseja sair?</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="col-12">
            <input class="btn btn-primary" type="submit" value="Sair" name="sair"/>
        </div>
    </form>
</div>

<?php include("Rodape.php");?>
