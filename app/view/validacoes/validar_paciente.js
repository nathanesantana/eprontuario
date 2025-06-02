function validarDataNascimento(){
    return {
        rules: [
            {
                rule: 'required',
                errorMessage: 'A data de nascimento precisa ser preenchida'
            },
            {
                validator: (value) => {
                    const dataDigitada = new Date(value)
                    const hoje = new Date()
                    hoje.setHours(0,0,0,0)

                    return dataDigitada < hoje
                },
                errorMessage: 'A data de nascimento não pode ser superior a data atual'
            }
        ]
    }
}

function validarTelefoneContato() {
  return {
    rules: [
      {
        validator: (value) => {
          if (!value) return true;
          return /^\d+$/.test(value);
        },
        errorMessage: 'O número de telefone para contato deve conter apenas números',
      },
      {
        validator: (value) => {
          if (!value) return true;
          return !/(\d)\1{10}/.test(value);
        },
        errorMessage: 'O número de telefone para contato não pode ser uma sequência de dígitos repetidos',
      },
      {
        validator: (value) => {
          if (!value) return true;
          return /^\d{11}$/.test(value);
        },
        errorMessage: 'O número de telefone para contato precisa ter 11 dígitos',
      }
    ]
  }
}

function validarRua(){
    return {
        rules : [
            {
                rule: 'required',
                errorMessage: 'A rua precisa ser preenchida'
            },
            {   rule: 'maxLength', 
                value: 100, errorMessage: 'A rua pode ter no máximo 100 caracteres'
            },
            {
                rule: 'customRegexp',
                value: /^[A-Za-zÀ-ÿ0-9\s,.'-]+$/,
                errorMessage: 'Caracteres especiais não são permitidos no nome da rua. Use apenas letras, números e sinais como vírgula, ponto, hífen e apóstrofo'
            }
        ]
    }
}

function validarNumero(){
    return {
        rules : [
            {
                rule: 'required',
                errorMessage: 'O número precisa ser preenchido'
            },
            {
                rule: 'number',
                errorMessage: 'O campo precisa ser um número'
            },
            {
                rule: 'minNumber',
                value: 0,
                errorMessage: 'O número não pode ser negativo'
            }
        ]
    }
}

function validarComplemento() {
  return {
    rules: [
      {
        validator: (value) => {
          if (!value) return true; // Se não foi preenchido, não valida
          return value.length <= 60;
        },
        errorMessage: 'O complemento pode ter no máximo 60 caracteres'
      }
    ]
  };
}

function validarBairro(){
    return {
        rules: [
            {
                rule: 'required',
                errorMessage: 'O  bairro precisa ser preenchido'
            },
            { 
                rule: 'maxLength', 
                value: 33, errorMessage: 'O bairro pode ter no máximo 33 caracteres' 
            }
        ]   
    }
}

function validarCidade(){
    return {
        rules: [
            {
                rule: 'required',
                errorMessage: 'A cidade precisa ser preenchida'
            },
            {
                rule: 'minLength',
                value: 3,
                errorMessage: 'O nome da cidade precisa ter no mínimo 3 letras'
            },
            { 
                rule: 'maxLength', 
                value: 100, errorMessage: 'A cidade pode ter no máximo 100 caracteres' 
            }
        ]
    }
}

function validarUF(){
    return {
        rules: [
            {
                rule: 'required',
                errorMessage: 'A UF precisa ser preenchida'
            },
            { 
                rule: 'maxLength', 
                value: 2, errorMessage: 'O estado deve ter 2 letras' 
            }
        ]
    }
}

function validarCEP(){
    return {
        rules: [
            {
                rule: 'required',
                errorMessage: 'O CEP precisa ser preenchido'
            },
            {   rule: 'minLength', 
                value: 8, 
                errorMessage: 'O CEP precisa ter exatamente 8 dígitos' 
            },
            {   rule: 'maxLength', 
                value: 11, 
                errorMessage: 'O CEP precisa ter exatamente 8 dígitos' 
            },
            {
                validator: (value) => /^\d+$/.test(value),
                errorMessage: 'O CEP deve conter apenas números'
            },
            {
                validator: (value) => !/(\d)\1{5}/.test(value),
                errorMessage: 'O CEP não pode ser uma sequência de dígitos repetidos'
            }
        ]
    }
}