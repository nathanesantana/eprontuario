 // validações comuns entre paciente e profissional
 function validarNome(){
    return {
        rules: [
            {
                rule: 'required',
                errorMessage: 'O nome precisa ser preenchido',
            },
            {
                rule: 'minLength',
                value : 3,
                errorMessage: 'O nome precisa ter no mínimo 3 letras'
            },
            {   rule: 'maxLength', 
                value: 32, 
                errorMessage: 'O nome pode ter no máximo 32 caracteres' },
            {
                validator: (value) => isNaN(value),
                errorMessage: 'O nome não pode ser um número'
            },
            {
                rule: 'customRegexp',
                value: /^[A-Za-zÀ-ÿ0-9\s,.'-]+$/,
                errorMessage: 'Caracteres especiais não são permitidos no nome'
            }
        ],
    }
}
 function validarCPF(){
    return {
        rules: [
            {
                rule: 'required',
                errorMessage: 'O CPF precisa ser preenchido'
            },
            {   rule: 'minLength', 
                value: 11, 
                errorMessage: 'O CPF precisa ter exatamente 11 dígitos' 
            },
            {   rule: 'maxLength', 
                value: 11, 
                errorMessage: 'O CPF precisa ter exatamente 11 dígitos' 
            },
            {
                validator: (value) => /^\d+$/.test(value),
                errorMessage: 'O CPF deve conter apenas números'
            },
            {
                validator: (value) => !/(\d)\1{10}/.test(value),
                errorMessage: 'O CPF não pode ser uma sequência de dígitos repetidos'
            }
        ]
    }
}

 function validarTelefone(){
    return{
        rules: [
            {
                rule: 'required',
                errorMessage: 'O número de telefone precisa ser preenchido'
            },
            {
                validator: (value) => /^\d+$/.test(value),
                errorMessage: 'O número de telefone deve conter apenas números'
            },
            {
                validator: (value) => !/(\d)\1{10}/.test(value),
                errorMessage: 'O número de telefone não pode ser um sequência de dígitos repetidos'
            },
            {
                validator: (value) => /^\d{11}$/.test(value),
                errorMessage: 'O número de telefone precisa ter 11 dígitos'
            }
        ]
    }
}


 function validarStatus(){
    return {
        rules: [
            {
                rule: 'required',
                errorMessage: 'O status precisa ser preenchido'
            }
        ]
    }
}

// validações comuns entre historico e produção

function validarDataInicial(){
    return {
        rules: [
            {
                rule:  'required',
                errorMessage: 'A data inicial precisa ser preenchida'
            },
            {
                validator: (value) => {
                    const dataDigitada = new Date(value)
                    const hoje = new Date()
                    hoje.setHours(0,0,0,0)

                    return dataDigitada < hoje
                },
                errorMessage: 'A inicial não pode ser superior a data atual'
            }
        ]
    }
}

function validarDataFinal(){
    return {
        rules: [
            {
                rule:  'required',
                errorMessage: 'A data final precisa ser preenchida'
            },
            {
                validator: (value) => {
                    const dataDigitada = new Date(value)
                    const hoje = new Date()
                    hoje.setHours(0,0,0,0)

                    return dataDigitada < hoje
                },
                errorMessage: 'A data final não pode ser superior a data atual'
            }
        ]
    }
}