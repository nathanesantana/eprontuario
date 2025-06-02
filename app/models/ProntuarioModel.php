<?php

class ProntuarioModel {
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

    public static function salvarAtendimento($dados, $arquivos) {
        $conexao = self::conectar();
        $id_profissional = $dados['profissional'];
        $id_paciente = $dados['paciente'];
        $queixa = $dados['queixa_principal'];
        $historia = $dados['historia_doenca_atual'];
        $conduta = $dados['conduta'];

        $nomes_arquivos = [];

        if (isset($arquivos['anexo'])) {
            for ($i = 0; $i < count($arquivos['anexo']['name']); $i++) {
                if ($arquivos['anexo']['error'][$i] == 0) {
                    $nome_temp = $arquivos['anexo']['tmp_name'][$i];
                    $nome_final = uniqid() . '_' . $arquivos['anexo']['name'][$i];
                    $caminho_destino = __DIR__ . '/../anexos/' . $nome_final;

                    if (move_uploaded_file($nome_temp, $caminho_destino)) {
                        $nomes_arquivos[] = $nome_final;
                    }
                }
            }
        }

        $anexos_salvos = json_encode($nomes_arquivos);

        $sql = 'INSERT INTO prontuario (id_profissional, id_paciente, queixa_principal, historia_doenca_atual, conduta, anexos)
                VALUES (:id_profissional, :id_paciente, :queixa_principal, :historia_doenca_atual, :conduta, :anexos)';

        $stmt = $conexao->prepare($sql);
        $stmt->execute([
            "id_profissional" => $id_profissional,
            "id_paciente" => $id_paciente,
            "queixa_principal"=> $queixa,
            "historia_doenca_atual"=>$historia,
            "conduta" =>$conduta,
            "anexos" => $anexos_salvos
        ]);

        return 'Atendimento salvo';
    }
}