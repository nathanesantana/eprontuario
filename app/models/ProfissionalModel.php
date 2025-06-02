<?php
class ProfissionalModel {
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

    // Inserir um novo profissional
    public static function inserir($dados) {
        $hash = password_hash($dados['senha'],PASSWORD_DEFAULT);
        $nomeFormatado = ucwords($dados['nome']);
        $conexao = self::conectar();
        
        $sqlVerificar = 'SELECT cpf FROM usuarios WHERE cpf = :cpf';
        $stmtVerificar = $conexao->prepare($sqlVerificar);
        $stmtVerificar->execute(["cpf" => $dados['cpf']]);

        if ($stmtVerificar->rowCount() > 0) {
            return 'cpf_existente';
        } else {
            $sql = 'INSERT INTO usuarios (nome, sexo, cpf, telefone, email, status, id_tipo_usuario, login, senha)
                VALUES (:nome, :sexo, :cpf, :telefone, :email, :status, :id_tipo_usuario, :login, :senha)';

        $stmt = $conexao->prepare($sql); 
        $stmt->execute([
            "nome" => $nomeFormatado,
            "sexo"=> $dados['sexo'],
            "cpf"=> $dados['cpf'],
            "telefone" => $dados['telefone'],
            "email"=>$dados['email'],
            "status" => $dados['status'],
            "id_tipo_usuario"=>$dados['perfil'],
            "login"=>$dados['login'],
            "senha"=>$hash
        ]);
            return 'Cadastro Salvo!';
        }
    }

    // Editar os dados de um profissional
    public static function editar($dados) {
        $hash = password_hash($dados['senha'],PASSWORD_DEFAULT);
        $nomeFormatado = ucwords($dados['nome']);
        $conexao = self::conectar();
            $sql = 'UPDATE usuarios SET nome = :nome, cpf = :cpf, login = :login, senha = :senha, email = :email, telefone = :telefone, 
            sexo = :sexo, id_tipo_usuario = :id_tipo_usuario, status = :status WHERE id_usuario = :id_usuario';
            $stmt = $conexao->prepare($sql);
            $stmt->execute([
                'id_usuario'=>$dados['id'],
                'nome'=>$nomeFormatado,
                'cpf'=>$dados['cpf'],
                'login'=>$dados['login'],
                'senha'=>$hash,
                'email'=>$dados['email'],
                'telefone'=>$dados['telefone'],
                'sexo'=>$dados['sexo'],
                'id_tipo_usuario'=>$dados['perfil'],
                'status'=>$dados['status']
            ]);
            return 'Cadastro Atualizado!';
    }

    // buscar um profissional
    public static function buscar($id){
        $conexao = self::conectar();
        $sqlVerificarBusca = 'SELECT * from usuarios WHERE id_usuario = :id_usuario';
        $stmtVerificarBusca = $conexao->prepare($sqlVerificarBusca);
        $stmtVerificarBusca->execute(["id_usuario" => $id]);
        $stmtVerificarBusca->fetch(PDO::FETCH_ASSOC); 
        if($stmtVerificarBusca->rowCount() === 0) {
            return 'id_nao_existe';
        } else {
            $sql = "SELECT * from usuarios WHERE id_usuario = :id_usuario";
            $stmt = $conexao->prepare($sql);
            $stmt->execute(["id_usuario"=> $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC); 
        }
    }

    // Ler todos os profissionais
    public static function ler() {
        $conexao = self::conectar();
        $sql = 'SELECT * from usuarios JOIN `tipo-usuario` ON usuarios.id_tipo_usuario = `tipo-usuario`.id_tipo_usuario;';
        $stmt = $conexao->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Inativar um profissional
    public static function inativar($id, $status) {
        if (is_array($status)) {
            $status = $status[0];
        }
        $conexao = self::conectar();
        $sql = 'UPDATE usuarios SET status = :status WHERE id_usuario = :id_usuario';
        $stmt = $conexao->prepare($sql);
        $stmt->execute(["id_usuario" => $id,
                        "status" => $status]);
        return 'Cadastro inativado!';
    }

    // Reativar um profissional
    public static function reativar($id, $status){
        if (is_array($status)) {
            $status = $status[0];
        }
        $conexao = self::conectar();
        $sql = 'UPDATE usuarios SET status = :status WHERE id_usuario = :id_usuario';
        $stmt = $conexao->prepare($sql);
        $stmt->execute(["id_usuario" => $id,
                        "status" => $status]);
        return 'Cadastro reativado!';
    }

    // Localizar um profissional
    public static function localizar($termo){
        $conexao = self::conectar();
        $sql = "SELECT usuarios.id_usuario, usuarios.nome, usuarios.cpf, usuarios.login, `tipo-usuario`.tipo, usuarios.status
            FROM usuarios
            JOIN `tipo-usuario` ON usuarios.id_tipo_usuario = `tipo-usuario`.id_tipo_usuario
            JOIN status_cadastro ON usuarios.status = status_cadastro.id_status
            WHERE usuarios.nome LIKE :termo
            OR usuarios.cpf LIKE :termo
            LIMIT 4";
        $stmt = $conexao->prepare($sql);
        $stmt->execute(["termo" => "%$termo%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}