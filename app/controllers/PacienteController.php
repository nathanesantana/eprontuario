<?php

require_once 'app/models/PacienteModel.php';
require_once 'Validacoes.php';

class PacienteController {
    public function inserir() {
        $dados = json_decode(file_get_contents('php://input'), true);
        $erros = Validacoes::validarInsercaoPacientes($dados);

        if (!empty($erros)) {
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'erro_validacao',
                'erros' => $erros
            ]);
            return;
        }

    $resposta = PacienteModel::inserir($dados);

    if ($resposta === 'cpf_existente') {
        echo json_encode([
            'status' => 'erro',
            'mensagem' => 'Já existe paciente cadastrado com esse CPF'
        ]);
        return;
    }

        echo json_encode([
            'status' => 'sucesso',
            'mensagem' => 'Cadastro realizado com sucesso'
        ]);
    }

    public function editar() {
        $dados = json_decode(file_get_contents('php://input'), true);
        $erros = Validacoes::validarInsercaoPacientes($dados);
        if (!empty($erros)) {
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'erro_validacao',
                'erros' => $erros
            ]);
            return;
        }
        $resposta = PacienteModel::editar($dados);
        echo json_encode([
            'status' => 'sucesso',
            'mensagem' => 'Cadastro atualizado com sucesso'
        ]);
    }

    public function buscar(){
        $dados = json_decode(file_get_contents('php://input'), true);
        $resposta = PacienteModel::buscar($dados['id']);

        if ($resposta === 'id_nao_existe'){
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'erro_busca',
                'mensagem' => 'Não foi encontrado paciente com o ID informado'
            ]);
            return;
        }
        echo json_encode($resposta);
    }

    public function ler() {
        $resposta = PacienteModel::ler();
        echo json_encode($resposta);
    }

    public function inativar() {
        $dados = json_decode(file_get_contents('php://input'), true);
        $resposta = PacienteModel::inativar($dados['id'], $dados['id_status']);
        echo json_encode($resposta);
    }

    public function reativar(){
        $dados = json_decode(file_get_contents('php://input'), true);
        $resposta = PacienteModel::reativar($dados['id'], $dados['id_status']);
        echo json_encode($resposta);
    }

    public function localizar(){
        $dados = json_decode(file_get_contents('php://input'), true);
        $resposta = PacienteModel::localizar($dados['termo']);
        echo json_encode($resposta);
    }
}