<?php

require_once 'app/models/ProfissionalModel.php';
require_once 'Validacoes.php';

class ProfissionalController {
    public function inserir() {
        $dados = json_decode(file_get_contents('php://input'), true);
        $erros = Validacoes::validarInsercaoProfissionais($dados);

        if (!empty($erros)) {
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'erro_validacao',
                'erros' => $erros
            ]);
            return;
        }

        $resposta = ProfissionalModel::inserir($dados);

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
        $erros = Validacoes::validarInsercaoProfissionais($dados);
        if (!empty($erros)) {
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'erro_validacao',
                'erros' => $erros
            ]);
            return;
        }
        $resposta = ProfissionalModel::editar($dados);
        echo json_encode([
            'status' => 'sucesso',
            'mensagem' => 'Cadastro atualizado com sucesso'
        ]);
    }

    public function buscar(){
        $dados = json_decode(file_get_contents('php://input'), true);
        $resposta = ProfissionalModel::buscar($dados['id']);
        if ($resposta === 'id_nao_existe'){
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'erro_busca',
                'mensagem' => 'Não foi encontrado profissional com o ID informado'
            ]);
            return;
        }
        echo json_encode($resposta);
    }

    public function ler() {
        $resposta = ProfissionalModel::ler();
        echo json_encode($resposta);
    }

    public function inativar() {
        $dados = json_decode(file_get_contents('php://input'), true);
        $resposta = ProfissionalModel::inativar($dados['id'], $dados['status']);
        echo json_encode($resposta);
    }

    public function reativar(){
        $dados = json_decode(file_get_contents('php://input'), true);
        $resposta = ProfissionalModel::reativar($dados['id'], $dados['status']);
        echo json_encode($resposta);
    }

    public function localizar(){
        $dados = json_decode(file_get_contents('php://input'), true);
        $resposta = ProfissionalModel::localizar($dados['termo']);
        echo json_encode($resposta);
    }
}