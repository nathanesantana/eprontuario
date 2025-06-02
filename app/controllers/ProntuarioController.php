<?php

require_once 'app/models/ProntuarioModel.php';
require_once 'Validacoes.php';

class ProntuarioController {
    public function salvarAtendimento() {
        $dados = $_POST;
        $arquivos = $_FILES;
        $erros = Validacoes::validarProntuario($dados,$arquivos);

        if (!empty($erros)){
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'erro_validacao',
                'erros' => $erros
            ]);
            return;
        }

        $resposta = ProntuarioModel::salvarAtendimento($dados, $arquivos);

        echo json_encode([
            'status' => 'sucesso',
            'mensagem' => 'Atendimento registrado com sucesso!'
        ]);
    }
}