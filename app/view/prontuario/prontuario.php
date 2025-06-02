<?php
if(!isset($_SESSION['id']) && $_SESSION['usuario'] !== '1'){
    header('Location: ../autenticacao/login.php?login=errodeautenticacao');
}
$nomeProfissional = $_SESSION['nome'];
$idProfissional = $_SESSION['id'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prontuário Eletrônico</title>
    <link rel="stylesheet" href="/prontuario_eletronico_mvc/app/view/prontuario/style_prontuario.css">
</head>
<body>
<div class="container mt-4">
  <form id="form">
    <h2 class="text-center text-purple mb-5">PRONTUÁRIO ELETRÔNICO</h2>

    <div class="row mb-4">
      <div class="col-md-6">
        <input type="text" id="nomeProfissionalDisabled" class="form-control" value="<?=htmlspecialchars($nomeProfissional)?>" disabled>
        <input type="hidden" id="nameProfissional" value="<?=htmlspecialchars($nomeProfissional)?>">
        <input type="hidden" id="id_profissional" value="<?=htmlspecialchars($idProfissional)?>">
      </div>
      <div class="col-md-6">
        <input type="text" id="paciente" placeholder="Paciente:" class="form-control">
        <input type="hidden" id="id_paciente">
      </div>
    </div>

    <div class="form-section">
      <label for="queixaprincipal" class="form-label">Queixa Principal</label>
      <textarea id="queixa_principal" class="form-control" rows="3"></textarea>
    </div>

    <div class="form-section">
      <label for="historiadadoenca" class="form-label">História da Doença Atual</label>
      <textarea id="historia_doenca_atual" class="form-control" rows="4"></textarea>
    </div>

    <div class="form-section">
      <label for="conduta" class="form-label">Conduta</label>
      <textarea id="conduta" class="form-control" rows="3"></textarea>
    </div>

    <div class="form-section">
      <label for="anexo" class="form-label"></label>
      <p class="text-muted">Adicione receitas, atestados, laudos aqui:</p>
      <input type="file" id="anexo" name="anexo[]" accept=".pdf,.jpg,.png" class="form-control" multiple>
    </div>

    <div class="text-end">
      <button type="submit" class="btn btn-purple px-5">Salvar</button>
    </div>
  </form>
</div>

<!-- Mensagem de erro/sucesso-->

<div class="modal fade" id="modalMensagem" tabindex="-1" aria-labelledby="modalMensagemLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" id="corpoModalMensagem">
      <div class="modal-header border-0">
        <h5 class="modal-title d-flex align-items-center" id="modalMensagemLabel">
          <span id="iconeModalMensagem" class="me-2 fs-4"></span>
          <span id="tituloModalMensagem">Mensagem</span>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body" id="conteudoModalMensagem"></div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/just-validate@4.3.0/dist/just-validate.production.min.js"></script>
    <script src="/prontuario_eletronico_mvc/app/view/assets/js/autocomplete.js"></script>
    <script src="/prontuario_eletronico_mvc/app/view/validacoes/comuns.js"></script>
    <script src="/prontuario_eletronico_mvc/app/view/validacoes/validar_prontuario.js"></script>
    <script src="/prontuario_eletronico_mvc/app/view/prontuario/prontuario.js"></script>
</body>
</html>