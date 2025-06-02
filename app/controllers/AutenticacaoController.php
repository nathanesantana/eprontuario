<?php
require_once 'app/models/AutenticacaoModel.php';

class AutenticacaoController {
    public function login() {
        session_start();
        $usuario = $_POST['usuario'] ?? '';
        $senha = $_POST['senha'] ?? '';

        if ($usuario === '' || $senha === '') {
            header('Location: view/autenticacao/login.php?login=erro');
            exit;
        }

        $modelo = new Usuario();
        $resultado = $modelo->buscarPorLoginSenha($usuario);

        if (!$resultado || !password_verify($senha, $resultado['senha'])) {
            header('Location: view/autenticacao/login.php?login=erro');
            exit;
        }

        if ($resultado['status'] == 2) {
            header('Location: view/autenticacao/login.php?login=acessonegado');
            exit;
        }

        $_SESSION['id'] = $resultado['id_usuario'];
        $_SESSION['nome'] = $resultado['nome'];
        $_SESSION['usuario'] = $resultado['id_tipo_usuario'];
        $_SESSION['nome'] = $resultado['nome'];
        
        header('Location: /prontuario_eletronico_mvc/app/view/pagina_principal/principal.php?rota=home');
        exit;
    }
}