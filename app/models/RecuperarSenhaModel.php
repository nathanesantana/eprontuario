<?php
class UsuarioModel {

    private static $conexao;

    // Conectar ao banco de dados
    private static function conectar() {
        if (!self::$conexao) {
            try {
                self::$conexao = new PDO('mysql:host=localhost;dbname=prontuario-eletronico', 'root', '');
                self::$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo 'Erro de conexão: ' . $e->getMessage();
            }
        }
        return self::$conexao;
    }

    public static function buscarPorEmail($email) {
        $pdo = self::conectar();
        $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function salvarTokenRecuperacao($email, $token) {
        $pdo = self::conectar();
        $sql = "UPDATE usuarios SET token_recuperacao = :token, token_expira = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
    }

    public static function buscarPorToken($token) {
        try {
        $pdo = self::conectar();

        // Ativa o modo de erro com exceção
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM usuarios WHERE token_recuperacao = :token AND token_expira > NOW() LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':token', $token);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        echo "Erro ao buscar por token: " . $e->getMessage();
        return false;
    }
    }

    public static function atualizarSenhaPorToken($token, $senhaHash) {
        try {
        $pdo = self::conectar();

        // Garante que exceções sejam lançadas
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "UPDATE usuarios SET senha = :senha, token_recuperacao = NULL, token_expira = NULL WHERE token_recuperacao = :token";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':senha', $senhaHash);
        $stmt->bindParam(':token', $token);

        $stmt->execute();
        $linhasAfetadas = $stmt->rowCount();

        return $linhasAfetadas;

    } catch (PDOException $e) {
        // Mostra o erro com clareza
        echo "Erro ao atualizar a senha: " . $e->getMessage();
        return false;
    }
    }
}