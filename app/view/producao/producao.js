$(document).ready(function(){
    carregarAutocomplete("profissional", '#profissional', '#id_profissional')

    function getData(){
        return {
            profissional : $("#id_profissional").val(),
            data1 : $("#data1").val(),
            data2: $("#data2").val()
        }
    }

    const validacao = new JustValidate("#formProducao")
        validacao
        .addField("#profissional", validarNome().rules)
        .addField("#data1", validarDataInicial().rules)
        .addField("#data2", validarDataFinal().rules)
        .onSuccess((e)=> {
            e.preventDefault()
            dados = getData()
            console.log(dados)
            $.ajax({
                url: 'index.php?url=producao/gerar-pdf',
                type: 'GET',
                data: dados,
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(blob) {
                  e.preventDefault();
                    const dados = getData();
                    const query = new URLSearchParams(dados).toString();
                    window.open('index.php?url=producao/gerar-pdf&' + query, '_self'); // abre na mesma aba
                },
                error: function () {
                    console.error('Erro:', response);
                }
            }); 
        })
})