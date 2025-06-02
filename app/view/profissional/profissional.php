<?php
if(!isset($_SESSION['id']) && $_SESSION['usuario'] !== '1'){
    header('Location: ../autenticacao/login.php?login=errodeautenticacao');
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/prontuario_eletronico_mvc/app/view/profissional/style_profissional.css">
    <title>Cadastro</title>
</head>
<body>
<div class="container my-5" style="max-width: 1000px;">
  <div class="bg-light p-4 rounded shadow-sm fundoformulario">
    <h2 class="text-center text-purple mb-5">Cadastro de Profissional</h2>  
    <form id="formulario">
        <!-- Dados Pessoais -->

          <div class="row mb-3">
            <div class="col-md-8">
              <div><input type="hidden" id="id"></div>
              <label for="nome" class="form-label">Nome</label>
              <input type="text" id="nome" class="form-control" placeholder="NOME COMPLETO">
            </div>
            <div class="col-md-4">
              <label for="cpf" class="form-label">CPF</label>
              <input type="text" id="cpf" class="form-control" placeholder="000.000.000-00">
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-4">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" id="email" class="form-control">
              </div>
            <div class="col-md-4" id="grupo-sexo">
              <label class="form-label">Sexo</label><br>
              <div class="form-check form-check-inline">
                <input type="radio" id="sexoF" class="form-check-input" name="sexo" value="F">
                <label for="sexoF" class="form-check-label">Feminino</label>
              </div>
              <div class="form-check form-check-inline">
                <input type="radio" id="sexoM" class="form-check-input" name="sexo" value="M">
                <label for="sexoM" class="form-check-label">Masculino</label>
              </div>
              <div class="form-check form-check-inline">
                <input type="radio" id="sexoO" class="form-check-input" name="sexo" value="O">
                <label for="sexoO" class="form-check-label">Outro</label>
              </div>
            </div>
            <div class="col-md-4">
              <label for="telefone" class="form-label">Telefone</label>
              <input type="text" id="telefone" class="form-control" placeholder="(00) 0000-0000">
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-4">
              <label for="login" class="form-label">Login</label>
              <input type="text" id="login" class="form-control">
            </div>
            
            <div class="col-md-4">
              <label for="tipoprofissional" class="form-label">Perfil do Profissional</label>
              <select id="tipoprofissional" class="form-select">
                <option value="" selected>Selecione o perfil</option>
                <option value="1">Administrador</option>
                <option value="2">Profissional de Saúde</option>
                <option value="3">Recepção</option>
              </select>
            </div>

            <!-- Status -->
            <div class="col-md-4">
              <label for="status" class="form-label">Status</label>
              <select class="form-select" id="status">
                <option value="" selected>Selecione o status</option>
                <option value="1">Ativo</option>
                <option value="2">Inativo</option>
              </select>
            </div>
          </div>

          <div class="text-end">
            <button type="submit" class="btn btn-purple px-4">Salvar</button>
          </div>
      </form>
    </div>
  </div>
        <!-- Campo de busca -->
    <div class="container my-4">
      <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="Buscar profissional" id="campoBusca">
        <button class="btn btn-purple" type="button" id="botaoBuscar">Buscar</button>
      </div>
    </div>

      <!-- Tabela de profissionais -->
      <div class="table-responsive">
        <table id="tableProfissional" class="table table-striped table-bordered align-middle text-center">
          <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>CPF</th>
                <th>Login</th>
                <th>Perfil</th>
                <th>Ações</th>
            </tr>
          </thead>
          <tbody id="tabelaProfissionais"></tbody>
        </table>
      </div>
    </div>
  </div>
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

<!-- Modal de Confirmação com estilo personalizado -->
<div class="modal fade" id="modalConfirmacao" tabindex="-1" aria-labelledby="tituloConfirmacao" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" id="modalConfirmacaoCorpo">
      <div class="modal-header border-0">
        <h5 class="modal-title d-flex align-items-center" id="tituloConfirmacao">
            <i class="bi bi-exclamation-circle-fill me-2 text-warning fs-4"></i>
            Confirmação
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body" id="mensagemConfirmacao">
        Tem certeza que deseja continuar?
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-confirmar" id="btnConfirmarAcao">Confirmar</button>
      </div>
    </div>
  </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/just-validate@4.3.0/dist/just-validate.production.min.js"></script>
    <script src="/prontuario_eletronico_mvc/app/view/validacoes/comuns.js"></script>
    <script src="/prontuario_eletronico_mvc/app/view/validacoes/validar_profissional.js"></script>
    <script src="/prontuario_eletronico_mvc/app/view/profissional/profissional.js"></script>
</body>
</html>