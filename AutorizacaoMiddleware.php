<?php

function verificarAcesso($tipoUsuario){
    
    if (!isset($_SESSION['usuario'])){
        http_response_code(401);
        echo json_encode(['erro' => 'Não autenticado, é necessário realizar login no sistema']);
        exit;
    }

    $usuario = $_SESSION['usuario'];

        if(!in_array($usuario, $tipoUsuario)){
            http_response_code(403);
            echo json_encode(['erro' => 'Você não tem permissão para acessar essa página']);
            exit;
        }
}