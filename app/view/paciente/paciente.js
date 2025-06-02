$(document).ready(function(){
    lerDados();

    setTimeout(() => {
        if ($.fn.DataTable.isDataTable('#tablePaciente')) {
            $('#tablePaciente').DataTable().columns.adjust();
        }
    }, 300);
 
 function getData(){
        return {
        'id' : $('#id').val(),
        'nome' : $('#nome').val(),
        'cpf' : $('#cpf').val(),
        'datanascimento' : $('#datanascimento').val(),
        'sexo' : $(`input[type="radio"]:checked`).val(),
        'telefone' : $('#telefone').val(),
        'telefone_contato' : $('#telefone_contato').val(),
        'status' : $('#status').val(),
        'cep' : $('#cep').val(),
        'logradouro' : $('#logradouro').val(),
        'bairro' : $('#bairro').val(),
        'complemento' : $('#complemento').val(),
        'numero' : $('#numero').val(),
        'estado' : $('#estado').val(),
        'cidade' : $('#cidade').val()  
    }}

     const validacaoPaciente = new JustValidate("#formulario")
        validacaoPaciente
            .addField('#telefone_contato', validarTelefoneContato().rules)
            .addField("#nome", validarNome().rules)
            .addField("#cpf", validarCPF().rules)
            .addField("#datanascimento", validarDataNascimento().rules)
            .addRequiredGroup('#grupo-sexo', 'O sexo precisa ser selecionado')
            .addField("#telefone", validarTelefone().rules)
            .addField("#telefone_contato", validarTelefoneContato().rules)
            .addField("#status", validarStatus().rules)
            .addField("#logradouro", validarRua().rules)
            .addField("#numero", validarNumero().rules)
            .addField("#complemento", validarComplemento().rules)
            .addField("#bairro", validarBairro().rules)
            .addField("#cidade", validarCidade().rules)
            .addField("#estado", validarUF().rules)
            .addField("#cep", validarCEP().rules)
            .onSuccess((event)=> {
                event.preventDefault?.()
                const dados = getData();
                if(dados.id == ''){
                    $.ajax({
                        url: 'index.php?url=paciente/inserir',
                        type: 'POST',
                        contentType: 'application/json',
                        data: JSON.stringify(dados),
                        success: function(response) {
                            if (response.status === 'erro_validacao') {
                                let mensagens = '';
                                for (let campo in response.erros) {
                                    mensagens += `<li>${response.erros[campo]}</li>`;
                                }
                                exibirModalMensagem('danger', `<ul>${mensagens}</ul>`);
                            } else if (response.status === 'erro') {
                                exibirModalMensagem('danger', response.mensagem);
                            } else if (response.status === 'sucesso') {
                                exibirModalMensagem('success', response.mensagem);
                                $('form')[0].reset();
                                lerDados();
                            }
                        },
                        error: function (response) {
                            console.log(response);
                            exibirModalMensagem('danger', 'Erro ao salvar cadastro! Tente novamente.');
                        }   
                    });
                } else {
                    $.ajax({
                        url: 'index.php?url=paciente/editar',
                        type: 'POST',
                        contentType: 'application/json',
                        data: JSON.stringify(dados),
                        success: function(response) {
                            if (response.status === 'erro_validacao') {
                                let mensagens = '';
                                for (let campo in response.erros) {
                                    mensagens += `<li>${response.erros[campo]}</li>`;
                                }
                                exibirModalMensagem('danger', `<ul>${mensagens}</ul>`);
                            } else if (response.status === 'sucesso') {
                                exibirModalMensagem('success', response.mensagem);
                                $('form')[0].reset();
                                lerDados();
                            }
                        },
                        error: function (response) {
                            console.log(response)
                            exibirModalMensagem('danger', 'Erro ao salvar cadastro! Tente novamente.');
                        }
                    });
                }      
        });

    function lerDados(){
        $.ajax({
            url : 'index.php?url=paciente/ler',
            type : 'GET',
            contentType : 'application/json',
            success : function(response){
                preencherTabela(response)
            },
            error : function(){
                exibirModalMensagem('danger', 'Erro ao buscar pacientes! Atualize a página e tente novamente.');
            }
        })
    }

    function preencherTabela(response) {
    let dados = typeof response === "string" ? JSON.parse(response) : response;

    // Se já é uma DataTable, destruir para recriar
    if ($.fn.DataTable.isDataTable('#tablePaciente')) {
        $('#tablePaciente').DataTable().clear().destroy();
    }

    $("#tablePaciente tbody").empty();

    let tbody = '';
    dados.forEach(paciente => {
        let classeLinha = paciente.id_status == 2 ? 'paciente-desativado' : '';

        tbody += `
            <tr class="${classeLinha}">
                <td data-label='ID'>${paciente.id_paciente}</td>
                <td data-label='NOME'>${paciente.nome}</td>
                <td data-label='CPF'>${paciente.cpf}</td>
                <td data-label='DATA DE NASCIMENTO'>${paciente.data_nascimento}</td>
                <td data-label='AÇÕES'>
                    ${gerarAcoes(paciente)}
                </td>
            </tr>`;
    });

    $("#tablePaciente tbody").html(tbody);

    $('#tablePaciente').DataTable({
        paging: true,
        searching: false,
        info: true,
        lengthChange: false,
        pageLength: 4,
        ordering: false,
        autoWidth: false,
        language: {
            paginate: {
                previous: 'Anterior',
                next: 'Próximo'
            },
            info: 'Mostrando _START_ até _END_ de _TOTAL_ registros',
        }
    });

        // Limpar eventos anteriores e atribuir novos
        $('#tablePaciente').off('click').on('click', '.editar', function () {
            let id = $(this).data('id');
            buscarPaciente(id);
        }).on('click', '.inativar', function () {
            let id = $(this).data('id');
            let id_status = $(this).data('status')
            confirmarInativacao(id, id_status);
        }).on('click', '.reativar', function () {
            let id = $(this).data('id');
            let id_status = $(this).data('status')
            confirmarReativacao(id, id_status);
        });
    }

function gerarAcoes(paciente) {
    if (paciente.id_status == 2) {
        return `
            <button type="button" class="reativar" data-id="${paciente.id_paciente}" data-status='1' title="Reativar" style="border: none">
                <i class="bi bi-arrow-clockwise"></i>
            </button>`;
    } else {
        return `
            <button type="button" class="editar" data-id="${paciente.id_paciente}" title="Editar" style="border: none">
                <i class="bi bi-pencil-square"></i>
            </button>
            <button type="button" class="inativar" data-id="${paciente.id_paciente}" data-status="2" title="Inativar" style="border: none">
                <i class="bi bi-person-x"></i>
            </button>`;
    }
}

    function buscarPaciente(id){
        $.ajax({
            url : 'index.php?url=paciente/buscar',
            type: 'POST',
            contentType : 'application/json',
            data : JSON.stringify({id: id}),
            success: function(response) {
                if(response.status == "erro_busca"){
                    exibirModalMensagem('danger', response.mensagem);
                }
                preencherFormulario(response)
            },
            erro: function (response) {
                exibirModalMensagem('danger', 'Erro ao buscar cadastro do paciente. Atualize a página e tente novamente');
            }
        })
    }

    function preencherFormulario(response){
        let data = typeof response === "string" ? JSON.parse(response) : response
        $("#id").val(data.id_paciente),
        $("#nome").val(data.nome)
        $("#cpf").val(data.cpf),
        $("#datanascimento").val(data.data_nascimento),
        $(`input[name="sexo"][value="${data.sexo}"]`).prop("checked", true),
        $("#telefone").val(data.telefone),
        $("#telefonecontato").val(data.telefone_contato),
        $("#status").val(data.id_status),
        $("#cep").val(data.cep),
        $("#logradouro").val(data.logradouro),
        $("#bairro").val(data.bairro),
        $("#complemento").val(data.complemento),
        $("#numero").val(data.numero),
        $("#estado").val(data.estado),
        $("#cidade").val(data.cidade)
    }

    function confirmarInativacao(id, id_status) {
        mostrarConfirmacao('Deseja realmente inativar este paciente?', () => {
            inativarPaciente(id, id_status);
        });
    }

    function confirmarReativacao(id, id_status) {
        mostrarConfirmacao('Deseja realmente reativar este paciente?', () => {
        reativarPaciente(id, id_status);
        });
    }
    

    function inativarPaciente(id, id_status){
        let dados = {
            id : id,
            id_status: id_status}
        $.ajax({
            url: 'index.php?url=paciente/inativar',
            type : 'POST',
            contentType : 'application/Json',
            data : JSON.stringify(dados),
            success : function(response){
                lerDados();
                exibirModalMensagem('success', 'Paciente inativado com sucesso!');
            },
            error : function(){
                exibirModalMensagem('danger', 'Erro ao inativar cadastro. Atualize a página e tente novamente');
            }
        })
    }

    function reativarPaciente(id, id_status){
        let dados = {
            id : id,
            id_status: id_status}
        $.ajax({
            url: 'index.php?url=paciente/reativar',
            type : 'POST',
            contentType : 'application/Json',
            data : JSON.stringify(dados),
            success : function(response){
                lerDados();
                exibirModalMensagem('success', 'Paciente reativado com sucesso!');
            },
            error : function(){
                exibirModalMensagem('danger', 'Erro ao tentar reativar cadastro. Atualize a página e tente novamente.');
            }
        })
    }

    $("#campoBusca").on('keydown', function(e){
        if(e.key === 'Enter'){
            localizarPaciente()
        }
    })

    $("#botaoBuscar").on('click', function(){
        localizarPaciente()
    })

    function localizarPaciente(){
        const termo = $('#campoBusca').val().trim();
        $.ajax({
            url: 'index.php?url=paciente/localizar',
            type: 'POST',
            contentType : 'application/json',
            data: JSON.stringify({termo: termo}),
            success: function (resposta) {
              $('#tabelaPacientes').empty();
        
              if (resposta.length === 0) {
                $('#tabelaPacientes').append('<tr><td colspan="4">Nenhum paciente encontrado.</td></tr>');
              } else {

                resposta.forEach(paciente => {
                    let classeLinha = paciente.id_status == 2 ? 'paciente-desativado' : '';

                  $('#tabelaPacientes').append(`
                    <tr class="${classeLinha}">
                      <td data-label='ID'>${paciente.id_paciente}</td>
                      <td data-label='Nome'>${paciente.nome}</td>
                      <td data-label='CPF'>${paciente.cpf}</td>
                      <td data-label='DATA DE NASCIMENTO'>${paciente.data_nascimento}</td>
                      <td data-label='AÇÕES'>
                        ${gerarAcoes(paciente)}
                      </td>
                    </tr> `);
                });
              }
            }
        });
    }
     // mensagem de sucesso/ erro
    function exibirModalMensagem(tipo, texto) {
        const modal = new bootstrap.Modal(document.getElementById('modalMensagem'));
        const corpo = document.getElementById('corpoModalMensagem');
        const conteudo = document.getElementById('conteudoModalMensagem');
        const titulo = document.getElementById('tituloModalMensagem');
        const icone = document.getElementById('iconeModalMensagem');

        // Limpa classes anteriores
        corpo.classList.remove('modal-sucesso', 'modal-erro');

        if (tipo === 'success') {
            corpo.classList.add('modal-sucesso');
            icone.innerHTML = '✔️';
            titulo.textContent = 'Sucesso';
        } else if (tipo === 'danger') {
            corpo.classList.add('modal-erro');
            icone.innerHTML = '❌';
            titulo.textContent = 'Erro';
        }

        conteudo.textContent = texto;
        modal.show();
    }


    // mensagem de confirmação
    function mostrarConfirmacao(mensagem, callbackConfirmar) {
        document.getElementById('mensagemConfirmacao').textContent = mensagem;

        const modal = new bootstrap.Modal(document.getElementById('modalConfirmacao'));
        modal.show();

        const botao = document.getElementById('btnConfirmarAcao');
        botao.replaceWith(botao.cloneNode(true)); // Evita múltiplos listeners
        const novoBotao = document.getElementById('btnConfirmarAcao');

        novoBotao.addEventListener('click', () => {
            modal.hide();
            callbackConfirmar();
        });
    }
});