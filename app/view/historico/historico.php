<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/prontuario_eletronico_mvc/app/view/historico/style_historico.css">
    <title>Histórico de Atendimentos</title>
</head>
<body>
  <div class="container my-5" style="max-width: 1000px;">
    <div class="bg-light p-4 rounded shadow-sm">
      <h2 class="text-center text-purple mb-5">HISTÓRICO DE ATENDIMENTOS</h2>

        <form id="formHistorico" class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Paciente</label>
            <div class="col-md-12">
              <input type="text" id="paciente" placeholder="PACIENTE:" class="form-control">
              <input type="hidden" id="id_paciente">
            </div>
          </div>

          <div class="col-md-3">
            <label class="form-label">Data Início</label>
            <input type="date" id="data1" name="data1" class="form-control" required>
          </div>

          <div class="col-md-3">
            <label class="form-label">Data Fim</label>
            <input type="date" id="data2" name="data2" class="form-control" required>
          </div>

          <div class="text-end">
              <button type="submit" class="btn btn-purple px-4">Gerar PDF</button>
          </div>
        </form>
    </div>
  </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/just-validate@4.3.0/dist/just-validate.production.min.js"></script>
    <script src="/prontuario_eletronico_mvc/app/view/assets/js/autocomplete.js"></script>
    <script src="/prontuario_eletronico_mvc/app/view/validacoes/comuns.js"></script>
    <script src="/prontuario_eletronico_mvc/app/view/historico/historico.js"></script>
</body>
</html>