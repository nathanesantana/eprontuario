function carregarAutocomplete(tipoBusca, label, value, somenteAtivos = false){
    $(label).autocomplete({
        source: function(request, response){
            $.ajax({
                url: 'index.php?url=autocomplete/buscar',
                type: 'POST',
                contentType: 'application/json',
                dataType: 'json',
                data: JSON.stringify({
                    termo: request.term,
                    tipo: tipoBusca,
                    somente_ativos: somenteAtivos ? 1 : 0
                }),
                success: function(data) {
                    response(data);
                }
            });
        },
        minLength: 2,
        select: function(event, ui) {
            $(label).val(ui.item.label);
            $(value).val(ui.item.value);
            return false;
        }
    });
}