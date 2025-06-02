<?php

$rota = $_GET['rota'] ?? 'home';

// Define rotas e permissões
$rotas = [
    'home' => [
        'arquivo' => __DIR__ . '/../view/apresentacao/apresentacao.php',
        'permissoes' => ['1', '2', '3']
    ],
    'pacientes' => [
        'arquivo' => __DIR__ . '/../view/paciente/paciente.php',
        'permissoes' => ['1', '2', '3']
    ],
    'profissionais' => [
        'arquivo' => __DIR__ . '/../view/profissional/profissional.php',
        'permissoes' => ['1']
    ],
    'prontuario' => [
        'arquivo' => __DIR__ . '/../view/prontuario/prontuario.php',
        'permissoes' => ['1', '2']
    ],
    'historico' => [
        'arquivo' => __DIR__ . '/../view/historico/historico.php',
        'permissoes' => ['1', '2', '3']
    ],
    'producao' => [
        'arquivo' => __DIR__ . '/../view/producao/producao.php',
        'permissoes' => ['1']
    ]
];

$perfil = $_SESSION['usuario'] ?? null;

if (isset($rotas[$rota]) && in_array($perfil, $rotas[$rota]['permissoes'])) {
    include $rotas[$rota]['arquivo'];
} else {
    echo "Você não tem permissão para acessar essa pagina";
}