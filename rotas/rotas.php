<?php
class Router {
    public function run() {
        session_start();
        $uri = $_GET['url'] ?? '';
        $uri = trim($uri, '/');
        $method = $_SERVER['REQUEST_METHOD'];

         /* ---------------- ROTAS DE PÁGINA (HTML) ---------------- */
        if ($uri === '') {                
            require 'app/view/autenticacao/login.php';
            return;
        }

        if ($uri === 'redefinir_senha'){
            require 'app/view/trocar_senha/trocar_senha.php';
            return;
        }
        
        if (in_array($uri, ['autenticacao/login', 'paciente/inserir', 'paciente/editar', 
            'paciente/ler', 'paciente/inativar', 'paciente/reativar', 'paciente/localizar',
            'profissional/inserir', 'profissional/editar', 'profissional/ler', 'profissional/inativar', 
            'profissional/reativar', 'profissional/localizar', 'prontuario/salvar', 'autocomplete/buscar'])) {
            header('Content-Type: application/json');
        }

        switch ($uri) {
            case 'autenticacao/login':
                require_once 'app/controllers/AutenticacaoController.php';
                (new AutenticacaoController)->login();
                break;
            
            case 'recuperar_senha':
                require_once 'app/controllers/RecuperarSenhaController.php';
                (new RecuperarSenhaController)->solicitar();
                break;

            case 'salvar_nova_senha':
                require_once 'app/controllers/RecuperarSenhaController.php';
                (new RecuperarSenhaController)->redefinir();
                break;

            // rotas de pacientes
            case 'paciente/inserir':
                require_once 'AutorizacaoMiddleware.php';
                verificarAcesso([1,2,3]);

                require_once 'app/controllers/PacienteController.php';
                (new PacienteController)->inserir();
                break;
                
            case 'paciente/editar':
                require_once 'AutorizacaoMiddleware.php';
                verificarAcesso([1,2,3]);

                require_once 'app/controllers/PacienteController.php';
                (new PacienteController)->editar();
                break;

            case 'paciente/buscar':
                require_once 'AutorizacaoMiddleware.php';
                verificarAcesso([1,2,3]);

                require_once 'app/controllers/PacienteController.php';
                (new PacienteController)->buscar();
                break;

            case 'paciente/ler':
                require_once 'AutorizacaoMiddleware.php';
                verificarAcesso([1,2,3]);

                if ($method === 'GET') {
                    require_once 'app/controllers/PacienteController.php';
                    (new PacienteController)->ler();
                }
                break;

            case 'paciente/inativar':
                require_once 'AutorizacaoMiddleware.php';
                verificarAcesso([1,2,3]);

                require_once 'app/controllers/PacienteController.php';
                (new PacienteController)->inativar();
                break;
            
            case 'paciente/reativar':
                require_once 'AutorizacaoMiddleware.php';
                verificarAcesso([1,2,3]);

                require_once 'app/controllers/PacienteController.php';
                (new PacienteController)->reativar();
                break;

            case 'paciente/localizar':
                require_once 'AutorizacaoMiddleware.php';
                verificarAcesso([1,2,3]);

                require_once 'app/controllers/PacienteController.php';
                (new PacienteController)->localizar();
                break;
            
            // rota de profissionais
             case 'profissional/inserir':
                require_once 'AutorizacaoMiddleware.php';
                verificarAcesso([1,2,3]);

                require_once 'app/controllers/ProfissionalController.php';
                (new ProfissionalController)->inserir();
                break;
                
            case 'profissional/editar':
                require_once 'AutorizacaoMiddleware.php';
                verificarAcesso([1,2,3]);

                require_once 'app/controllers/ProfissionalController.php';
                (new ProfissionalController)->editar();
                break;

            case 'profissional/buscar':
                require_once 'AutorizacaoMiddleware.php';
                verificarAcesso([1,2,3]);

                require_once 'app/controllers/ProfissionalController.php';
                (new ProfissionalController)->buscar();
                break;

            case 'profissional/ler':
                require_once 'AutorizacaoMiddleware.php';
                verificarAcesso([1,2,3]);

                if ($method === 'GET') {
                    require_once 'app/controllers/ProfissionalController.php';
                    (new ProfissionalController)->ler();
                }
                break;

            case 'profissional/inativar':
                require_once 'AutorizacaoMiddleware.php';
                verificarAcesso([1,2,3]);

                require_once 'app/controllers/ProfissionalController.php';
                (new ProfissionalController)->inativar();
                break;
            
            case 'profissional/reativar':
                require_once 'AutorizacaoMiddleware.php';
                verificarAcesso([1,2,3]);

                require_once 'app/controllers/ProfissionalController.php';
                (new ProfissionalController)->reativar();
                break;

            case 'profissional/localizar':
                require_once 'AutorizacaoMiddleware.php';
                verificarAcesso([1,2,3]);

                require_once 'app/controllers/ProfissionalController.php';
                (new ProfissionalController)->localizar();
                break;

            case 'prontuario/salvar':
                require_once 'AutorizacaoMiddleware.php';
                verificarAcesso([1,2,3]);

                require_once 'app/controllers/ProntuarioController.php';
                (new ProntuarioController)->salvarAtendimento();
            break;

            // rota para autocomplete
            case 'autocomplete/buscar':
                require_once 'AutorizacaoMiddleware.php';
                verificarAcesso([1,2,3]);

                require_once 'app/controllers/AutocompleteController.php';
                (new AutocompleteController)->buscar();
            break;

            // rota para gerar pdf historico
            case 'historico/gerar-pdf':
                require_once 'AutorizacaoMiddleware.php';
                verificarAcesso([1,2,3]);

                require_once 'app/controllers/HistoricoController.php';
                header('Content-Type: application/pdf');
                header('Content-Disposition: inline; filename="consultas.pdf"');
                (new HistoricoController)->gerarPdf($_POST['paciente'], $_POST['data1'], $_POST['data2']);
            break;

            //rota para gerar pdf producao
            case 'producao/gerar-pdf':
                require_once 'AutorizacaoMiddleware.php';
                verificarAcesso([1,2,3]);
                
                require_once 'app/controllers/ProducaoController.php';
                header('Content-Type: application/pdf');
                header('Content-Disposition: inline; filename="consultas.pdf"');
                (new ProducaoController)->gerarPdf($_POST['profissional'], $_POST['data1'], $_POST['data2']);
            break;

            default:
                echo json_encode(['erro' => 'Rota não encontrada']);
        }
    }
}