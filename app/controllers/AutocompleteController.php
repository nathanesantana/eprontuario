<?php
require_once 'app/models/AutocompleteModel.php';

class AutocompleteController {
    public function buscar() {
        $dados = json_decode(file_get_contents('php://input'), true);
        $tipo = $dados['tipo'] ?? '';
        $termo = strip_tags(trim($dados['termo'] ?? ''));
        $somenteAtivos = isset($dados['somente_ativos']) && $dados['somente_ativos'];
        $data = [];

        if ($tipo === 'profissional') {
            $resultados = AutocompleteModel::buscarProfissionais($termo, $somenteAtivos);
            foreach ($resultados as $row) {
                $data[] = [
                    'label' => $row['nome'],
                    'value' => $row['id_usuario']
                ];
            }
        } elseif ($tipo === 'paciente') {
            $resultados = AutocompleteModel::buscarPacientes($termo, $somenteAtivos);
            foreach ($resultados as $row) {
                $data[] = [
                    'label' => $row['nome'],
                    'value' => $row['id_paciente']
                ];
            }
        }

        echo json_encode($data);
    }
}