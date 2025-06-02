$(document).ready(function(){
    carregarAutocomplete("paciente", '#paciente', '#id_paciente', true)


    function getData() {
        const formData = new FormData();
        formData.append("profissional", $("#id_profissional").val());
        formData.append("paciente", $("#id_paciente").val());
        formData.append("queixa_principal", $("#queixa_principal").val());
        formData.append("historia_doenca_atual", $("#historia_doenca_atual").val());
        formData.append("conduta", $("#conduta").val());

        const arquivos = $('input[name="anexo[]"]')[0].files;
        for (let i = 0; i < arquivos.length; i++) {
            formData.append("anexo[]", arquivos[i]);
        }
    
        return formData;
    }
        
        const validacao = new JustValidate("#form")
            validacao
            .addField("#nameProfissional", validarNome().rules)
            .addField("#paciente", validarNome().rules)
            .addField("#queixa_principal", validarQueixaPrincipal().rules)
            .addField("#historia_doenca_atual", validarHistoriaDoenca().rules)
            .addField("#conduta", validarConduta().rules)
            .addField('input[name="anexo[]"]',validarAnexo().rules)
            .onSuccess((e)=>{
                e.preventDefault()
                const dados = getData()
                $.ajax({
                    url: 'index.php?url=prontuario/salvar',
                    type: 'POST',
                    data: dados,
                    contentType: false,
                    processData: false,
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
                        }
                    },
                    error: function () {
                        exibirModalMensagem('danger', 'Erro ao salvar atendimento! Tente novamente.');
                    }
                });
            }) 

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
})
