<?php

class ProducaoModel{
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

    public function buscarProducao($profissional, $data1, $data2){
        $conexao = self::conectar();
        $sql = "
            SELECT 
                p.data_atendimento,
                p.queixa_principal,
                p.historia_doenca_atual,
                p.conduta,
                pac.nome AS nome_paciente,
                prof.nome AS nome_profissional
            FROM prontuario p
            JOIN usuarios prof ON p.id_profissional = prof.id_usuario
            JOIN pacientes pac ON p.id_paciente = pac.id_paciente
            WHERE prof.id_usuario = ?
            AND DATE(p.data_atendimento) BETWEEN ? AND ?
            ORDER BY p.data_atendimento ASC
        ";

        $stmt = $conexao->prepare($sql);
        $stmt->execute([$profissional, $data1, $data2]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}