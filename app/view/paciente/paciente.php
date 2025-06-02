<?php
if(!isset($_SESSION['id'])){
    header('Location: ../autenticacao/login.php?login=errodeautenticacao');
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/prontuario_eletronico_mvc/app/view/paciente/style_paciente.css">

</head>
<body>
<div class="container my-5" style="max-width: 1000px;">
  <div class="bg-light p-4 rounded shadow-sm">
    <h2 class="text-center text-purple mb-5">Cadastro de Paciente</h2>

    <form id="formulario" class="needs-validation">
      <!-- Nome e CPF -->
      <div class="row mb-3">
        <div id="id" type="hidden"></div>
        <div class="col-md-8">
          <label for="nome" class="form-label">Nome</label>
          <input type="text" class="form-control" id="nome" placeholder="Nome completo">
        </div>
        <div class="col-md-4">
          <label for="cpf" class="form-label">CPF</label>
          <input type="text" class="form-control" id="cpf" placeholder="000.000.000-00">
        </div>
      </div>

      <!-- Data de nascimento e Sexo -->
      <div class="row mb-3">
        <div class="col-md-6">
          <label for="datanascimento" class="form-label">Data de Nascimento</label>
          <input type="date" class="form-control" id="datanascimento">
        </div>
        <div class="col-md-6" id="grupo-sexo">
          <label class="form-label d-block">Sexo</label>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="sexo" id="feminino" value="F">
            <label class="form-check-label" for="feminino">Feminino</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="sexo" id="masculino" value="M">
            <label class="form-check-label" for="masculino">Masculino</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="sexo" id="outro" value="O">
            <label class="form-check-label" for="outro">Outro</label>
          </div>
        </div>
      </div>

      <!-- Telefones -->
      <div class="row mb-3">
        <div class="col-md-6">
          <label for="telefone" class="form-label">Telefone</label>
          <input type="tel" class="form-control" id="telefone" placeholder="(00) 0000-0000">
        </div>
        <div class="col-md-6">
          <label for="telefone_contato" class="form-label">Telefone para Contato</label>
          <input type="tel" class="form-control" id="telefone_contato" placeholder="(00) 00000-0000">
        </div>
      </div>

      <!-- Status -->
      <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select id="status" class="form-select">
          <option value="" selected>Selecione o status</option>
          <option value="1">Ativo</option>
          <option value="2">Inativo</option>
        </select>
      </div>

      <!-- Endereço -->
      <div class="row mb-3">
        <div class="col-md-8">
          <label for="rua" class="form-label">Rua</label>
          <input type="text" class="form-control" id="logradouro">
        </div>
        <div class="col-md-4">
          <label for="numero" class="form-label">Número</label>
          <input type="text" class="form-control" id="numero">
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label for="complemento" class="form-label">Complemento</label>
          <input type="text" class="form-control" id="complemento">
        </div>
        <div class="col-md-6">
          <label for="bairro" class="form-label">Bairro</label>
          <input type="text" class="form-control" id="bairro">
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label for="cidade" class="form-label">Cidade</label>
          <input type="text" class="form-control" id="cidade">
        </div>
        <div class="col-md-3">
          <label for="uf" class="form-label">UF</label>
          <select class="form-select" id="estado">
            <option value="" selected>Selecione</option>
            <option>AC</option><option>AL</option><option>AP</option><option>AM</option>
            <option>BA</option><option>CE</option><option>DF</option><option>ES</option>
            <option>GO</option><option>MA</option><option>MT</option><option>MS</option>
            <option>MG</option><option>PA</option><option>PB</option><option>PR</option>
            <option>PE</option><option>PI</option><option>RJ</option><option>RN</option>
            <option>RS</option><option>RO</option><option>RR</option><option>SC</option>
            <option>SP</option><option>SE</option><option>TO</option>
          </select>
        </div>
        <div class="col-md-3">
          <label for="cep" class="form-label">CEP</label>
          <input type="text" class="form-control" id="cep" placeholder="00000-000">
        </div>
      </div>

      <!-- Botão -->
      <div class="text-end">
        <button type="submit" class="btn btn-purple px-4">Salvar</button>
      </div>
    </form>
  </div>
</div>
<!-- Campo de busca -->
<div class="container my-4">
  <div class="input-group mb-3">
    <input type="text" class="form-control" placeholder="Buscar paciente" id="campoBusca">
    <button class="btn btn-purple" type="button" id="botaoBuscar">Buscar</button>
  </div>
</div>
  
  <!-- Tabela de pacientes -->
  <div class="table-responsive">
    <table id="tablePaciente" class="table table-striped table-bordered align-middle text-center">
      <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>CPF</th>
            <th>Data de Nascimento</th>
            <th>Ações</th>
        </tr>
      </thead>
      <tbody id="tabelaPacientes"></tbody>
    </table>
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
    <script src="/prontuario_eletronico_mvc/app/view/validacoes/validar_paciente.js"></script>
    <script src="/prontuario_eletronico_mvc/app/view/paciente/paciente.js"></script>
</body>
</html>