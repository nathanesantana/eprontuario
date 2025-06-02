function validarQueixaPrincipal() {
    return {
        rules: [
            {
                rule: 'required',
                errorMessage: 'O campo "Queixa principal" é obrigatório.'
            },
            {
                rule: 'maxLength',
                value: 200,
                errorMessage: 'O campo "Queixa principal" deve ter no máximo 200 caracteres.'
            }
        ]
    };
}

function validarHistoriaDoenca() {
    return {
        rules: [
            {
                rule: 'required',
                errorMessage: 'O campo "História da doença atual" é obrigatório.'
            },
            {
                rule: 'maxLength',
                value: 200,
                errorMessage: 'O campo "História da doença atual" deve ter no máximo 200 caracteres.'
            }
        ]
    };
}

function validarConduta() {
    return {
        rules: [
            {
                rule: 'required',
                errorMessage: 'O campo "Conduta" é obrigatório.'
            },
            {
                rule: 'maxLength',
                value: 200,
                errorMessage: 'O campo "Conduta" deve ter no máximo 200 caracteres.'
            }
        ]
    };
}

function validarAnexo() {
    return {
        rules: [
            {
                rule: 'files',
                value: {
                    files: {
                        extensions: ['pdf', 'jpg', 'png'],
                        maxSize: 5000000, // 5MB
                        types: ['application/pdf', 'image/jpeg', 'image/png']
                    }
                },
                errorMessage: 'O anexo deve ser um arquivo PDF, JPG ou PNG com no máximo 5MB.'
            },
            {
                validator: (value, fields) => {
                    const file = fields['#anexo']?.elem?.files?.[0];
                    if (!file) return true;
                    return file.name.length <= 255;
                },
                errorMessage: 'O nome do arquivo anexo deve ter no máximo 255 caracteres.'
            }
        ]
    };
}