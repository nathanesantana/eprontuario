<?php
if (!isset($_SESSION['usuario'])) {
    header("Location: ../autenticacao/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/prontuario_eletronico_mvc/app/assets/css_global/style_menu.css">
    <title>Document</title>
</head>
<body>
<div class="container my-5" style="max-width: 1000px;">
    <div class="bg-white p-5 rounded shadow-sm">
        <div class="row align-items-center">
        
        <!-- Texto -->
        <div class="col-md-6 mb-3 mb-md-0 text-center text-md-start">
            <h1 style="color: #6f42c1; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                Utilize o menu lateral para começar um novo atendimento ou consultar dados
            </h1>
        </div>
        
        <!-- Imagem -->
        <div class="col-md-6 text-center">
            <img src="/prontuario_eletronico_mvc/app/view/assets/img/imagemHome.jpg" alt="Imagem Home" class="img-fluid rounded">
        </div>

        </div>
    </div>
</div>
</body>
</html>