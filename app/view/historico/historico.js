$(document).ready(function(){
    carregarAutocomplete("paciente", '#paciente', '#id_paciente')

    function getData(){
        return {
            paciente : $("#id_paciente").val(),
            data1 : $("#data1").val(),
            data2: $("#data2").val()
        }
    }

    const validacao = new JustValidate("#formHistorico")
        validacao
        .addField("#paciente", validarNome().rules)
        .addField("#data1", validarDataInicial().rules)
        .addField("#data2", validarDataFinal().rules)
        .onSuccess((e)=> {
            e.preventDefault()
            dados = getData()
            $.ajax({
                url: 'index.php?url=historico/gerar-pdf',
                type: 'POST',
                data: dados,
                xhrFields: {
                  responseType: 'blob'
                },
                success: function(blob) {
                  const url = window.URL.createObjectURL(blob);
                  const a = document.createElement('a');
                  a.href = url;
                  a.download = "consultas.pdf";
                  document.body.appendChild(a);
                  a.click();
                  a.remove();
                }
            });
             
        })
})
