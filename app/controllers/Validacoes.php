<?php
class Validacoes {
        public static function validarInsercaoPacientes($dados) {
        $erros = [];

        // Nome (mínimo 3, máximo 32)
        if (empty($dados['nome'])) {
            $erros['nome'] = 'O nome precisa ser preenchido';
        } elseif (strlen($dados['nome']) < 3) {
            $erros['nome'] = 'O nome precisa ter no mínimo 3 letras';
        } elseif (strlen($dados['nome']) > 32) {
            $erros['nome'] = 'O nome pode ter no máximo 32 caracteres';
        } elseif (is_numeric($dados['nome'])){
            $erros['nome'] = 'O nome não pode ser um número';
        }

        // CPF (exatamente 11)
        if (empty($dados['cpf'])) {
            $erros['cpf'] = 'O CPF precisa ser preenchido';
        } elseif (strlen($dados['cpf']) !== 11) {
            $erros['cpf'] = 'O CPF deve conter exatamente 11 dígitos';
        }

        // Telefone (mínimo 10, máximo 14)
        if (empty($dados['telefone'])) {
            $erros['telefone'] = 'O telefone precisa ser preenchido';
        } elseif (strlen($dados['telefone']) < 10) {
            $erros['telefone'] = 'O telefone deve conter no mínimo 10 dígitos';
        } elseif (strlen($dados['telefone']) > 14) {
            $erros['telefone'] = 'O telefone pode ter no máximo 14 dígitos';
        }

        // Telefone de contato (mínimo 10, máximo 14)
        if (!empty($dados['telefone_contato'])){
            if (strlen($dados['telefone_contato']) < 10) {
                $erros['telefone_contato'] = 'O telefone de contato deve conter no mínimo 10 dígitos';
            } elseif (strlen($dados['telefone_contato']) > 14) {
                $erros['telefone_contato'] = 'O telefone de contato pode ter no máximo 14 dígitos';
            }
        } 

        // Data de nascimento
        if (empty($dados['datanascimento'])) {
            $erros['data_nascimento'] = 'A data de nascimento precisa ser preenchida';
        } else {
            try {
                $dataNascimento = new DateTime($dados['datanascimento']);
                $agora = new DateTime();
                if ($dataNascimento > $agora) {
                    $erros['datanascimento'] = 'A data de nascimento não pode ser no futuro';
                }
            } catch (Exception $e) {
                $erros['datanascimento'] = 'A data de nascimento não é válida';
            }
        }

        // Status (string "1" ou "2")
        if (!isset($dados['status']) || ($dados['status'] !== "1" && $dados['status'] !== "2")) {
            $erros['status'] = 'O status deve ser "1" (ativo) ou "2" (inativo)';
        }

        // Logradouro (mínimo 3, máximo 100)
        if (empty($dados['logradouro'])) {
            $erros['logradouro'] = 'O logradouro precisa ser preenchido';
        } elseif (strlen($dados['logradouro']) < 3) {
            $erros['logradouro'] = 'O logradouro precisa ter no mínimo 3 letras';
        } elseif (strlen($dados['logradouro']) > 100) {
            $erros['logradouro'] = 'O logradouro pode ter no máximo 100 caracteres';
        }

        // Número (máximo 10)
        if (empty($dados['numero'])) {
            $erros['numero'] = 'O número precisa ser preenchido';
        } elseif (strlen($dados['numero']) > 10) {
            $erros['numero'] = 'O número pode ter no máximo 10 caracteres';
        }

        // Complemento (máximo 60 — validado se enviado)
        if (!empty($dados['complemento']) && strlen($dados['complemento']) > 60) {
            $erros['complemento'] = 'O complemento pode ter no máximo 60 caracteres';
        }

        // Bairro ( máximo 33)
        if (empty($dados['bairro'])) {
            $erros['bairro'] = 'O bairro precisa ser preenchido';
        } elseif (strlen($dados['bairro']) > 33) {
            $erros['bairro'] = 'O bairro pode ter no máximo 33 caracteres';
        }

        // Cidade (mínimo 3, máximo 100)
        if (empty($dados['cidade'])) {
            $erros['cidade'] = 'A cidade precisa ser preenchida';
        } elseif (strlen($dados['cidade']) < 3) {
            $erros['cidade'] = 'A cidade precisa ter no mínimo 3 letras';
        } elseif (strlen($dados['cidade']) > 100) {
            $erros['cidade'] = 'A cidade pode ter no máximo 100 caracteres';
        }

        // Estado (exatamente 2)
        if (empty($dados['estado'])) {
            $erros['estado'] = 'O estado precisa ser preenchido';
        } elseif (strlen($dados['estado']) !== 2) {
            $erros['estado'] = 'O estado deve conter exatamente 2 caracteres';
        }

        // CEP (exatamente 8)
        if (empty($dados['cep'])) {
            $erros['cep'] = 'O CEP precisa ser preenchido';
        } elseif (strlen($dados['cep']) !== 8) {
            $erros['cep'] = 'O CEP deve conter exatamente 8 dígitos';
        }

        return $erros;
    }

        public static function validarInsercaoProfissionais($dados) {
        $erros = [];

        // nome (máximo 32)
        if (empty($dados['nome'])) {
            $erros['nome'] = 'O nome precisa ser preenchido';
        } elseif (strlen($dados['nome']) < 3) {
            $erros['nome'] = 'O nome precisa ter no mínimo 3 caracteres';
        } elseif (strlen($dados['nome']) > 32) {
            $erros['nome'] = 'O tamanho máximo aceito para o campo nome é 32 caracteres';
        } elseif (is_numeric($dados['nome'])) {
            $erros['nome'] = 'O nome não pode ser um número';
        }

        // cpf (exatamente 11)
        if (empty($dados['cpf'])) {
            $erros['cpf'] = 'O CPF precisa ser preenchido';
        } elseif (strlen($dados['cpf']) !== 11) {
            $erros['cpf'] = 'O CPF precisa ter exatamente 11 caracteres';
        } elseif (preg_match('/(\d)\1{10}/', $dados['cpf'])) {
            $erros['cpf'] = 'O CPF não pode ser uma sequência de dígitos repetidos';
        } elseif (!ctype_digit($dados['cpf'])) {
            $erros['cpf'] = 'O CPF deve conter apenas números';
        }

        // login (máximo 15)
        if (empty($dados['login'])) {
            $erros['login'] = 'O login precisa ser preenchido';
        } elseif (strlen($dados['login']) > 15) {
            $erros['login'] = 'O tamanho máximo aceito para o campo login é 15 caracteres';
        }

        // senha (exatamente 8)
        /*if (empty($dados['senha'])) {
            $erros['senha'] = 'A senha precisa ser preenchida';
        } elseif (strlen($dados['senha']) < 8 || strlen($dados['senha']) > 20) {
            $erros['senha'] = 'O tamanho aceito para o campo senha precisa ter entre 8 e 20 caracteres';
        }*/

        // email (máximo 256)
        if (empty($dados['email'])) {
            $erros['email'] = 'O e-mail precisa ser preenchido';
        } elseif (strlen($dados['email']) > 256) {
            $erros['email'] = 'O tamanho máximo aceito para o campo e-mail é 256 caracteres';
        } elseif (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL)) {
            $erros['email'] = 'O e-mail informado é inválido';
        }

        // telefone (exatamente 11)
        if (empty($dados['telefone'])) {
            $erros['telefone'] = 'O telefone precisa ser preenchido';
        } elseif (strlen($dados['telefone']) !== 11) {
            $erros['telefone'] = 'O telefone precisa ter exatamente 11 caracteres';
        } elseif (!ctype_digit($dados['telefone'])) {
            $erros['telefone'] = 'O telefone deve conter apenas números';
        }

        // sexo (1 caractere, F/M/O)
        if (empty($dados['sexo'])) {
            $erros['sexo'] = 'O sexo precisa ser preenchido';
        } elseif (!in_array($dados['sexo'], ['F', 'M', 'O'])) {
            $erros['sexo'] = 'O sexo deve ser preenchido com uma das opções: Feminino, Masculino ou Outro';
        } elseif (strlen($dados['sexo']) > 1) {
            $erros['sexo'] = 'O tamanho máximo aceito para o campo sexo é 1 caractere';
        }

        // tipo do usuário (máximo 11)
        if (empty($dados['perfil'])) {
            $erros['perfil'] = 'O tipo do usuário precisa ser preenchido';
        } elseif (strlen($dados['perfil']) > 11) {
            $erros['perfil'] = 'O tamanho máximo aceito para o campo tipo do usuário é 11 caracteres';
        }

        // status (máximo 11)
        if (empty($dados['status'])) {
            $erros['status'] = 'O status precisa ser preenchido';
        } elseif (strlen($dados['status']) > 11) {
            $erros['status'] = 'O tamanho máximo aceito para o campo status é 11 caracteres';
        }

        return $erros;
    }

    public static function validarProntuario($dados, $arquivos){
        $erros = [];

    // Queixa principal (máximo 200)
    if (empty($dados['queixa_principal'])) {
        $erros['queixa_principal'] = 'É necessário preencher a queixa principal';
    } elseif (strlen($dados['queixa_principal']) > 200) {
        $erros['queixa_principal'] = 'O campo queixa principal deve ter no máximo 200 caracteres';
    }

    // História da doença atual (máximo 200)
    if (empty($dados['historia_doenca_atual'])) {
        $erros['historia_doenca_atual'] = 'É necessário preencher a história da doença atual';
    } elseif (strlen($dados['historia_doenca_atual']) > 200) {
        $erros['historia_doenca_atual'] = 'O campo história da doença atual deve ter no máximo 200 caracteres';
    }

    // Conduta (máximo 200)
    if (empty($dados['conduta'])) {
        $erros['conduta'] = 'É necessário preencher a conduta';
    } elseif (strlen($dados['conduta']) > 200) {
        $erros['conduta'] = 'O campo conduta deve ter no máximo 200 caracteres';
    }

    // Anexo (máximo 255 + validações de tipo e tamanho)
    if (!empty($arquivos['anexo']['name'])) {
    $arquivo = $arquivos['anexo'];

    $extensoesPermitidas = ['pdf', 'jpg', 'png'];
    $tiposPermitidos = ['application/pdf', 'image/jpeg', 'image/png'];
    $tamanhoMaximo = 5 * 1024 * 1024; // 5MB

    foreach ($arquivos['anexo']['name'] as $index => $nomeArquivo) {
        if (strlen($nomeArquivo) > 255) {
            $erros['anexo'] = 'O nome de um dos arquivos é muito longo (máximo 255 caracteres)';
            break;
        }

    $extensao = strtolower(pathinfo($nomeArquivo, PATHINFO_EXTENSION));
    $tipo = $arquivos['anexo']['type'][$index];
    $tamanho = $arquivos['anexo']['size'][$index];

        if (!in_array($extensao, $extensoesPermitidas) ||
            !in_array($tipo, $tiposPermitidos) ||
            $tamanho > $tamanhoMaximo) {
            $erros['anexo'] = 'Um dos arquivos é inválido ou muito grande';
            break;
        }
    }
    
    }

    return $erros;
    }
}