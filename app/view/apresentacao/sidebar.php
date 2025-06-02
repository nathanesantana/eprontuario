<?php
if (session_status() === PHP_SESSION_NONE) {
   var_dump($_SESSION['usuario']);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Menu Prontuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/prontuario_eletronico_mvc/app/view/assets/css/style_menu.css">
</head>
<body>
    
<div id="wrapper">
    <div id="menu">
        <div class="container-fluid">
            <nav class="nav flex-column">
                <ul>
                    <li class="nav-item">
                        <a class="nav-link" href="?rota=home">
                            <i class="bi bi-house-fill"></i><span>HOME</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="?rota=pacientes">
                            <i class="bi bi-people-fill"></i><span>PACIENTES</span>
                        </a>
                    </li>

                    <?php if ($_SESSION['usuario'] == '1') { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="?rota=profissionais">
                            <i class="bi bi-person-fill-add"></i><span>PROFISSIONAIS</span>
                        </a>
                    </li>
                    <?php } ?>

                    <?php if ($_SESSION['usuario'] == '1' || $_SESSION['usuario'] == '2') { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="?rota=prontuario">
                            <i class="bi bi-clipboard2-pulse-fill"></i><span>PRONTUÁRIO</span>
                        </a>
                    </li>
                    <?php } ?>

                    <li class="nav-item">
                        <a class="nav-link" href="?rota=historico">
                            <i class="bi bi-file-earmark-person"></i><span>HISTÓRICO</span>
                        </a>
                    </li>

                    <?php if ($_SESSION['usuario'] == '1') { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="?rota=producao">
                            <i class="bi bi-graph-up"></i><span>PRODUÇÃO</span>
                        </a>
                    </li>
                    <?php } ?>

                    <li class="nav-item">
                        <a class="nav-link" href="/prontuario_eletronico_mvc/app/controllers/logoutController.php">
                            <i class="bi bi-box-arrow-left"></i><span>SAIR</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="/prontuario_eletronico_mvc/app/view/apresentacao/script_menu.js"></script>
</body>
</html>