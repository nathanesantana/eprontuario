<?php ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recuperar Senha</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <link rel="stylesheet" href="/prontuario_eletronico_mvc/app/view/recuperar_senha/style_recuperar_senha.css">
  
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
  <div class="container rounded shadow-lg bg-purple text-white p-4" style="max-width: 500px;">
    
    <div class="text-center mb-4">
      <h2 class="fw-bold">Recuperar Senha</h2>
      <p class="mb-1">Informe o e-mail cadastrado no sistema.</p>
      <small class="text-warning fst-italic">O e-mail deve ser o mesmo usado no cadastro.</small>
    </div>

    <form id="formRecuperacao" action="index.php?url=recuperar_senha" method="POST">
      <div class="mb-3">
        <input name="email" type="email"
               class="form-control text-center bg-purple border-white text-white rounded-pill input-purple"
               placeholder="E-MAIL" required>
      </div>
      <div class="text-center">
        <button type="submit" class="btn btn-light rounded-pill px-4 fw-semibold mb-2">
          <i class="bi bi-envelope-arrow-up me-1"></i> ENVIAR
        </button>
      </div>

      <!-- Feedback -->
      <?php if (isset($_GET['recuperacao'])): ?>
        <?php if ($_GET['recuperacao'] == 'token_expirou'): ?>
          <div class="text-warning mt-3 text-center">O token de recuperação expirou. Gere um novo e tente novamente.</div>
        <?php elseif ($_GET['recuperacao'] == 'e-mail_nao_encontrado'): ?>
          <div class="text-warning mt-3 text-center">E-mail não encontrado.</div>
        <?php elseif ($_GET['recuperacao'] == '...'): ?>
          <div class="text-warning mt-3 text-center">...</div>
        <?php elseif ($_GET['recuperacao'] == 'enviado'): ?>
          <div class="text-warning mt-3 text-center">E-mail enviado com sucesso! Verifique sua caixa de entrada.</div>
    <?php endif; ?>
    <?php endif; ?>
    </form>

    <div class="text-center mt-3">
      <a href="index.php?autenticacao/login" class="btn btn-outline-light rounded-pill px-4 no-underline">
        <i class="bi bi-arrow-left me-1"></i> Voltar para Login
      </a>
    </div>
  </div>
</body>
</html>