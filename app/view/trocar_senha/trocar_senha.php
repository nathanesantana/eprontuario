<?php
$token = $_GET['token'] ?? '';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Redefinir Senha</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <link rel="stylesheet" href="/prontuario_eletronico_mvc/app/view/recuperar_senha/style_recuperar_senha.css">
  <script>
    function validarSenhas() {
      const senha = document.getElementById('nova_senha').value;
      const confirmar = document.getElementById('confirmar_senha').value;
      if (senha !== confirmar) {
        alert('As senhas não coincidem.');
        return false;
      }
      return true;
    }
  </script>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
  <div class="container rounded shadow-lg bg-purple text-white p-4" style="max-width: 500px;">
    
    <div class="text-center mb-4">
      <h2 class="fw-bold">Redefinir Senha</h2>
      <p class="mb-1">Crie sua nova senha de acesso ao sistema.</p>
      <small class="text-warning fst-italic">Digite duas vezes para confirmar.</small>
    </div>

    <form action="index.php?url=salvar_nova_senha" method="POST" onsubmit="return validarSenhas()">
      <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

      <div class="mb-3">
        <input id="nova_senha" name="nova_senha" type="password"
               class="form-control text-center bg-purple border-white text-white rounded-pill input-purple"
               placeholder="NOVA SENHA" required>
      </div>

      <div class="mb-3">
        <input id="confirmar_senha" name="confirmar_senha" type="password"
               class="form-control text-center bg-purple border-white text-white rounded-pill input-purple"
               placeholder="CONFIRMAR SENHA" required>
      </div>

      <div class="text-center">
        <button type="submit" class="btn btn-light rounded-pill px-4 fw-semibold mb-2">
          <i class="bi bi-shield-lock-fill me-1"></i> SALVAR NOVA SENHA
        </button>
      </div>

      <!-- Feedback -->
      <div class="text-center mt-3">
        <?php if(isset($_GET['status']) && $_GET['status'] === 'sucesso') { ?>
          <div class="alert alert-success p-2" role="alert">
            <i class="bi bi-check-circle-fill me-1"></i> Senha redefinida com sucesso!
          </div>
        <?php } ?>
        <?php if(isset($_GET['status']) && $_GET['status'] === 'invalido') { ?>
          <div class="alert alert-danger p-2" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-1"></i> Token inválido ou expirado.
          </div>
        <?php } ?>
      </div>
    </form>

  </div>
</body>
</html>