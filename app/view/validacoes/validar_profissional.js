function validarEmail(){
    return {
        rules: [
            {
                rule: 'required',
                errorMessage: 'O e-mail precisa ser preenchido'
            },
            {
                rule: 'email',
                errorMessage: 'O e-mail informado é inválido'
            },
            { 
                rule: 'maxLength', 
                value: 256, errorMessage: 'O valor máximo aceito no campo e-mail é 256 caracteres' 
            }
        ]
    }
}

/*function validarSenha(){
    return {
        rules: [
            {
                rule: 'required',
                errorMessage: 'A senha precisa ser preenchida'
            },
            {
                rule: 'password',
                errorMessage: 'A senha deve conter no mínimo oito caracteres, pelo menos uma letra e um número'
            }
        ]
    }
}*/

function validarLogin(){
    return {
        rules: [
            { 
                rule: 'required',
                errorMessage: 'O login precisa ser preenchido'
            },
            {   rule: 'maxLength', 
                value: 15, errorMessage: 'O login pode ter no máximo 15 caracteres' 
            }
        ]
    }
}

function validarPerfil(){
    return {
        rules: [
            {
                rule: 'required',
                errorMessage: 'O perfil precisa ser selecionado'
            },
            {
                validator: (value) => ['1', '2', '3'].includes(value),
                errorMessage: 'O perfil do profissional não é válido'
            }
        ]
    }
}