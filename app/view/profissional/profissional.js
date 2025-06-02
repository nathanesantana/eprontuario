$(document).ready(function(){
    lerDados();

    setTimeout(() => {
        if ($.fn.DataTable.isDataTable('#tableProfissional')) {
            $('#tableProfissional').DataTable().columns.adjust();
        }
    }, 300);

    function pegarDados(){
        return {
        'id' : $("#id").val(),
        'nome' : $("#nome").val(),
        'cpf' : $("#cpf").val(),
        'email' : $("#email").val(),
        'telefone' : $("#telefone").val(),
        'sexo' : $(`input[type="radio"]:checked`).val(),
        'perfil' : $("#tipoprofissional").val(),
        'login' : $("#login").val(),
        'senha' : $("#senha").val(),
        'status' : $("#status").val()
        }
    }

    const validacao = new JustValidate("#formulario")
        validacao
            .addField("#nome", validarNome().rules)
            .addField("#cpf", validarCPF().rules)
            .addField("#email",validarEmail().rules)
            .addRequiredGroup('#grupo-sexo', 'O sexo precisa ser selecionado')
            .addField("#telefone", validarTelefone().rules)
            .addField("#status", validarStatus().rules)
            //.addField("#senha",validarSenha().rules)
            .addField("#login", validarLogin().rules)
            .addField("#tipoprofissional", validarPerfil().rules)
            .onSuccess((e)=> {
                e.preventDefault()
                const dados = pegarDados()
                if(dados.id === ''){
                    $.ajax({
                        url: 'index.php?url=profissional/inserir',
                        type : 'POST',
                        contentType : 'application/json',
                        data : JSON.stringify(dados),
                        success : function(response){
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
                        url: 'index.php?url=profissional/editar',
                        type : 'POST',
                        contentType : 'application/json',
                        data : JSON.stringify(dados),
                        success : function(response){
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
                        error : function(){
                            exibirModalMensagem('danger', 'Erro ao salvar cadastro! Tente novamente.');
                        }  
                    })
                }
            })

    function lerDados(){
        $.ajax({
            url : 'index.php?url=profissional/ler',
            type : 'GET',
            contentType : 'application/json',
            success : function(response){
                console.log(response)
                preecherTabela(response)
            },
            error : function(){
                exibirModalMensagem('danger', 'Erro buscar cadastros de profissionais! Atualize a pagina e tente novamente.');
            }
        })
    }

    function preecherTabela(response){
        let dados = typeof response === "string" ? JSON.parse(response) : response

        // Verificar se a tabela já é uma DataTable, e se for, destruir e recriar
        if ($.fn.DataTable.isDataTable('#tableProfissional')) {
            $('#tableProfissional').DataTable().clear().destroy();
        }

        // Limpar o conteúdo da tabela antes de adicionar novos dados
        $("#tableProfissional tbody").empty();

        let tbody = '';
        dados.forEach(profissional => {
        let classeLinha = profissional.status == 2 ? 'profissional-desativado' : '';
            
            tbody += `
            <tr class="${classeLinha}">
                <td data-label='ID'>${profissional.id_usuario}</td>
                <td data-label='NOME'>${profissional.nome}</td>
                <td data-label='CPF'>${profissional.cpf}</td>
                <td data-label='LOGIN'>${profissional.login}</td>
                <td data-label='PERFIL'>${profissional.tipo}</td>
                <td data-label='AÇÕES'>
                    ${gerarAcoes(profissional)}
                </td>
                
            </tr> `;
        });

        // Atualizar a tabela com os novos dados
        $("#tableProfissional tbody").html(tbody);
        
        $('#tableProfissional').DataTable({
            paging: true,          // Ativa a paginação
            searching: false,      // Desativa a busca do DataTables
            info: true,            // Remove o texto "Mostrando X de Y"
            lengthChange: false,   // Remove o seletor "mostrar X registros"
            pageLength: 4,         // Número padrão por página
            ordering: false,       // Desativa ordenação de colunas
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
        $('#tableProfissional').off('click').on('click', '.editar', function () {
            let id = $(this).data('id');
            buscarProfissional(id);
        }).on('click', '.inativar', function () {
            let id = $(this).data('id');
            let status = $(this).data('status')
            confirmarInativacao(id, status);
        }).on('click', '.reativar', function () {
            let id = $(this).data('id');
            let status = $(this).data('status')
            confirmarReativacao(id, status);
        });
    }

    function gerarAcoes(profissional) {
        console.log(profissional);
        if (profissional.status == 2) {
            return `
                <button type="button" class="reativar" data-id="${profissional.id_usuario}" data-status='1' title="Reativar" style="border: none">
                    <i class="bi bi-arrow-clockwise"></i>
                </button>`;
        } else {
            return `
                <button type="button" class="editar" data-id="${profissional.id_usuario}" title="Editar" style="border: none">
                    <i class="bi bi-pencil-square"></i>
                </button>
                <button type="button" class="inativar" data-id="${profissional.id_usuario}" data-status="2" title="Inativar" style="border: none">
                    <i class="bi bi-person-x"></i>
                </button>`;
        }
    }
   

    function buscarProfissional(id){
        $.ajax({
            url : 'index.php?url=profissional/buscar',
            type: 'POST',
            contentType : 'application/json',
            data : JSON.stringify({id: id}),
            success: function(response) {
                if(response.status == "erro_busca"){
                    exibirModalMensagem('danger', response.mensagem);
                }
                preencherFormulario(response)
            },
            erro: function () {
                exibirModalMensagem('danger', 'Erro ao buscar cadastro do profissional. Atualize a página e tente novamente');
            }
        })
    }

    function preencherFormulario(response){
        let data = typeof response === "string" ? JSON.parse(response) : response
        $("#id").val(data.id_usuario),
        $("#nome").val(data.nome)
        $("#cpf").val(data.cpf),
        $("#email").val(data.email),
        $(`input[name="sexo"][value="${data.sexo}"]`).prop("checked", true),
        $("#telefone").val(data.telefone),
        $("#tipoprofissional").val(data.id_tipo_usuario),
        $("#login").val(data.login),
        $("#senha").val(data.senha),
        $("#status").val(data.status)
    }

    function confirmarInativacao(id, status) {
        mostrarConfirmacao('Deseja realmente inativar este profissional?', () => {
            inativarProfissional(id, status);
        });
    }

    function confirmarReativacao(id, status) {
        mostrarConfirmacao('Deseja realmente reativar este profissional?', () => {
            reativarProfissional(id, status);
        });
    }

    function inativarProfissional(id, status){
        let dados = {
            id : id,
            status: status}
        $.ajax({
            url: 'index.php?url=profissional/inativar',
            type : 'POST',
            contentType : 'application/Json',
            data : JSON.stringify(dados),
            success : function(response){
                lerDados();
                exibirModalMensagem('success', 'Profissional inativado com sucesso!');
            },
            error : function(){
                exibirModalMensagem('danger', 'Erro ao inativar cadastro. Atualize a página e tente novamente');
            }
        })
    }

    function reativarProfissional(id, status){
        let dados = {
            id : id,
            status: status}
        $.ajax({
            url: 'index.php?url=profissional/reativar',
            type : 'POST',
            contentType : 'application/Json',
            data : JSON.stringify(dados),
            success : function(response){
                lerDados();
                exibirModalMensagem('success', 'Profissional reativado com sucesso!');
            },
            error : function(){
                exibirModalMensagem('danger', 'Erro ao tentar reativar cadastro. Atualize a página e tente novamente.');
            }
        })
    }

    $('#botaoBuscar').on('click', function () {
        localizarProfissional()
    });
    
    $("#campoBusca").on('keydown', function(e){
        if(e.key === "Enter"){
            localizarProfissional()
        }
    })

    function localizarProfissional(){
      const termo = $('#campoBusca').val().trim();
    
      $.ajax({
        url: 'index.php?url=profissional/localizar',
        type: 'POST',
        contentType : 'application/json',
        data: JSON.stringify({termo: termo}),
        success: function (response) {
          $('#tabelaProfissionais').empty();
  
          if (response.length === 0) {
            $('#tabelaProfissionais').append('<tr><td colspan="4">Nenhum profissional encontrado.</td></tr>');
          } else {

            response.forEach(profissional => {
                console.log(profissional);
                let classeLinha = profissional.status == 2 ? 'profissional-desativado' : '';

              $('#tabelaProfissionais').append(`
                <tr class="${classeLinha}">
                  <td data-label='ID'>${profissional.id_usuario}</td>
                  <td data-label='Nome'>${profissional.nome}</td>
                  <td data-label='CPF'>${profissional.cpf}</td>
                  <td data-label='Login'>${profissional.login}</td>
                  <td data-label='Perfil'>${profissional.tipo}</td>
                  <td data-label='AÇÕES'>
                        ${gerarAcoes(profissional)}
                  </td>
                </tr>`);
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
})