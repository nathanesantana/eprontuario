<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/prontuario_eletronico_mvc/app/view/autenticacao/style.css">
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">
  <div class="container rounded shadow-lg overflow-hidden" style="max-width: 1030px;">
    <div class="row g-4">
      
      <!-- Coluna da imagem e mensagem -->
      <div class="col-lg-6 d-none d-lg-block bg-white text-center p-4">
        <h3 class="text-purple">Bem-vindo ao eProntuário!</h3>
        <h5 class="text-purple">Acompanhe seus pacientes de forma fácil e segura.</h5>
        <img src="/prontuario_eletronico_mvc/app/view/assets/img/imagemLogin.jpg" alt="Profissional da Saúde" class="img-fluid mt-4" style="max-height: 350px;">
      </div>

      <!-- Coluna visível em todas as telas (formulário + mensagem em telas pequenas) -->
      <div class="col-lg-6 bg-purple text-white p-4 d-flex flex-column justify-content-center">
        <!-- Mensagem visível só em telas menores -->
        <div id="titlecel" class="d-lg-none text-center mb-4">
          <h3 class="text-white">Bem-vindo ao eProntuário!</h3>
          <h5 class="text-white">Acompanhe seus pacientes de forma fácil e segura.</h5>
        </div>

        <form id="formulario" action="?url=autenticacao/login" method="POST">
          <h2 class="text-center mb-4">Autenticação</h2>
          <div class="mb-3">
            <input name="usuario" type="text" class="form-control text-center bg-purple border-white text-white rounded-pill" placeholder="USUÁRIO">
          </div>
          <div class="mb-3">
            <input name="senha" type="password" class="form-control text-center bg-purple border-white text-white rounded-pill" placeholder="SENHA">
          </div>
          
          <div class="text-center">
            <button type="submit" class="btn btn-light rounded-pill px-4">ENTRAR</button>
          </div>
          <div class="mt-4 text-center text-lg-end">
            <a href="/prontuario_eletronico_mvc/app/view/recuperar_senha/recuperar_senha.php" 
              class="d-inline-block fw-semibold text-white fs-6 link-recuperar" id="recuperarSenha">
               Esqueceu a senha?
            </a>
          </div>
          <!-- Mensagens de erro -->
          <div class="text-warning mt-3 text-center">
            <?php if(isset($_GET['login']) && $_GET['login'] === 'erro') { ?>
              <p>Usuário ou senha inválido</p>
            <?php } ?>
            <?php if(isset($_GET['login']) && $_GET['login'] === 'errodeautenticacao') { ?>
              <p>É necessário realizar login para acessar a página</p>
            <?php } ?>
            <?php if(isset($_GET['login']) && $_GET['login'] === 'acessonegado') { ?>
              <p>Acesso bloqueado.</p>
            <?php } ?>
          </div>
        </form>
      </div>

    </div>
  </div>
</body>
</html>