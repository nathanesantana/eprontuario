<?php
class HistoricoModel {
    private static $conexao;

    // Conectar ao banco de dados
    private static function conectar() {
        if (!self::$conexao) {
            try {
                self::$conexao = new PDO('mysql:host=localhost;dbname=prontuario-eletronico','root',"");
                self::$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo 'Erro de conexão: ' . $e->getMessage();
            }
        }
        return self::$conexao;
    }

    public function buscarHistorico($paciente, $data1, $data2) {
        $conexao = self::conectar();
        $sql = "SELECT p.*, pa.nome AS nome_paciente, pr.nome AS nome_profissional
                FROM prontuario p
                JOIN pacientes pa ON p.id_paciente = pa.id_paciente
                JOIN usuarios pr ON p.id_profissional = pr.id_usuario
                WHERE p.id_paciente = ? AND DATE(data_atendimento) BETWEEN ? AND ?
                ORDER BY p.data_atendimento DESC";

        $stmt = $conexao->prepare($sql);
        $stmt->execute([$paciente, $data1, $data2]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
