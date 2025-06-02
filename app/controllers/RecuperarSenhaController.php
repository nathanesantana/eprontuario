<?php
require_once 'app/models/RecuperarSenhaModel.php';
require_once 'PHPMailer/PHPMailer.php';
require_once 'PHPMailer/SMTP.php';
require_once 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class RecuperarSenhaController {

    public function solicitar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
            $email = trim($_POST['email']);

            $usuarioModel = new UsuarioModel();
            $usuario = $usuarioModel->buscarPorEmail($email);
            var_dump($usuario);

            if ($usuario) {
                // Gera token de redefinição
                $token = bin2hex(random_bytes(16));
                $usuarioModel->salvarTokenRecuperacao($email, $token);

                // Envia e-mail com link de redefinição
                $link = "http://localhost/prontuario_eletronico_mvc/index.php?url=redefinir_senha&token=" . $token;

                $mail = new PHPMailer(true);
                try {
                    // Configuração do servidor SMTP
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com'; // Ex: smtp.gmail.com
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'eprontuarioe@gmail.com';
                    $mail->Password   = 'qckg dyed zwnk fhln';
                    $mail->SMTPSecure = 'tls'; // ou 'ssl'
                    $mail->Port       = 587;   // ou 465 para SSL
                    $mail->CharSet = 'UTF-8'; // Define o charset do conteúdo
                    $mail->Encoding = 'base64'; // Garante a codificação correta para conteúdos especiais

                    // Remetente e destinatário
                    $mail->setFrom('eprontuarioe@gmail.com', 'Sistema Prontuário Eletronico');
                    $mail->addAddress($email);

                    // Conteúdo do e-mail
                    $mail->isHTML(true);
                    $mail->Subject = 'Redefinição de Senha';
                    $mail->Body    = "
                                        <p>Olá,</p>

                                        <p>Recebemos uma solicitação para redefinir sua senha.</p>

                                        <p>Clique no link abaixo para continuar o processo. <strong>O link é válido por 1 hora</strong>:</p>

                                        <p><a href='$link'>Redefinir Senha</a></p>

                                        <p>Se você não solicitou a redefinição, ignore este e-mail. Nenhuma ação será tomada.</p>

                                        <p>Atenciosamente,<br>
                                        Equipe do Sistema de Prontuário</p>
                                    ";
                    
                    
                    "Olá, clique no link abaixo para redefinir sua senha:<br><br>
                                      <a href='$link'>$link</a><br><br>
                                      Se você não solicitou isso, ignore este e-mail.";

                    $mail->send();
                    header('Location: /prontuario_eletronico_mvc/app/view/recuperar_senha/recuperar_senha.php?recuperacao=enviado');
                    exit;
                } catch (Exception $e) {
                    echo $e;
                    header('Location: view/recuperar_senha/recuperar_senha.php?...');
                    exit;
                }
            } else {
                header('Location: /prontuario_eletronico_mvc/app/view/recuperar_senha/recuperar_senha.php?recuperacao=e-mail_nao_encontrado');
                exit;
            }
        }
    }

    public function mostrarTelaRedefinicao() {
        if (isset($_GET['token'])) {
            $token = $_GET['token'];
            require 'app/view/redefinir_senha/redefinir_senha.php';
        } else {
            header('Location: index.php?url=autenticacao/login');
            exit;
        }
    }

    public function redefinir() {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['token'], $_POST['nova_senha'], $_POST['confirmar_senha'])) {
            $token = $_POST['token'];
            $senha = $_POST['nova_senha'];
            $confirmar = $_POST['confirmar_senha'];
            var_dump($_POST);
            if ($senha === $confirmar) {
                $usuarioModel = new UsuarioModel();
                $usuario = $usuarioModel->buscarPorToken($token);
                
                var_dump($usuario);
                if ($usuario) {
                    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
                    $resultado = $usuarioModel->atualizarSenhaPorToken($token, $senhaHash);
                    //var_dump($resultado);
                    header('Location: index.php?url=autenticacao/login&redefinido=sucesso');
                    exit;
                }
            } 
        }
        header('Location: /prontuario_eletronico_mvc/app/view/recuperar_senha/recuperar_senha.php?recuperacao=token_expirou');
        exit;
    }
}