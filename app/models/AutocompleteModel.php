<?php

class AutocompleteModel {
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

    public static function buscarProfissionais($termo, $somenteAtivos = false) {
        $conexao = self::conectar();

        $sql = 'SELECT id_usuario, nome
                FROM usuarios
                WHERE nome LIKE :termo';

        if ($somenteAtivos) {
            $sql .= ' AND status = 1'; // ou o valor do seu status "ativo"
        }

        $sql .= ' ORDER BY nome ASC LIMIT 4';

        $stmt = $conexao->prepare($sql);
        $stmt->execute([':termo' => "%$termo%"]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function buscarPacientes($termo, $somenteAtivos = false) {
        $conexao = self::conectar();
        $sql = 'SELECT id_paciente, nome
                FROM pacientes
                WHERE nome LIKE :termo';

                if ($somenteAtivos) {
                    $sql .= ' AND id_status = 1'; // ou o valor do seu status "ativo"
                }

                $sql .= ' ORDER BY nome ASC LIMIT 4';

        $stmt = $conexao->prepare($sql);
        $stmt->execute([':termo' => "%$termo%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}