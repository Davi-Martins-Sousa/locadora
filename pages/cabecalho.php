<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de gerenciamento de locadoras</title>
    <link rel="stylesheet" href="../bootstrap-5.3.3/css/bootstrap.min.css">
    <style>
        body {
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-image: url('../img/gif.gif');
        }
        .container {
            width: 90%;
            height: 90%; 
            max-height: 90%; 
            overflow-y: auto; 
            background-color: rgba(153, 153, 153, 0.6);
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 10px; 
        }
        img {
            width: 100px;
            height: 100px;
            margin: 10px;
            cursor: pointer;
            border-radius: 5px;
            transition: border 0.3s;
            object-fit: cover;
            object-position: center;
        }
        img:hover {
            border: 2px solid #007bff;
        }
        .nav-item .nav-link {
            color: rgba(0, 0, 0);
        }
        .nav-item .nav-link:hover {
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="d-flex justify-content-center">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item"><a href="index.php" class="nav-link" aria-current="page">Index</a></li>
                <?php
                    session_start(); // Inicia a sessão ou resume a sessão existente
                    // Verifica se a sessão está ativa
                    if (session_status() === PHP_SESSION_ACTIVE) {
                        // Verifica se as variáveis da sessão específicas existem
                        if (isset($_SESSION['locadora_CNPJ']) && isset($_SESSION['privilegio'])) {
                            if($_SESSION['privilegio'] == 'admin'){
                                echo '<li class="nav-item"><a href="proprietarios.php" class="nav-link" aria-current="page">Proprietarios</a></li>';
                                echo '<li class="nav-item"><a href="locadoras.php" class="nav-link" aria-current="page">Locadoras</a></li>';          
                            }else{
                                echo '<li class="nav-item"><a href="filmes.php" class="nav-link" aria-current="page">Filmes</a></li>';
                                echo '<li class="nav-item"><a href="vhs.php" class="nav-link" aria-current="page">VHS</a></li>';         
                                echo '<li class="nav-item"><a href="clientes.php" class="nav-link" aria-current="page">Clientes</a></li>'; 
                            }
                            echo '<li class="nav-item"><a href="sair.php" class="nav-link" aria-current="page">Sair</a></li>';                                        
                        }else {
                            echo '<li class="nav-item"><a href="login.php" class="nav-link">Login</a></li>';
                        }
                    }
                ?>
            </ul>
        </div>
    

