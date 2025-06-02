<?php
class Usuario {
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

    public function buscarPorLoginSenha($login) {
        $conexao = self::conectar();
        $sql = "SELECT * FROM usuarios WHERE login = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$login]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}