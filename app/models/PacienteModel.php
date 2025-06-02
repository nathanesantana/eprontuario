<?php
class PacienteModel {
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

    // Inserir um novo paciente
    public static function inserir($dados) {
        $nomeFormatado = ucwords($dados['nome']);
        $conexao = self::conectar();
        
        $sqlVerificar = 'SELECT cpf FROM pacientes WHERE cpf = :cpf';
        $stmtVerificar = $conexao->prepare($sqlVerificar);
        $stmtVerificar->execute(["cpf" => $dados['cpf']]);

        if ($stmtVerificar->rowCount() > 0) {
            return 'cpf_existente';
        } else {
            $sql = 'INSERT INTO pacientes (nome, data_nascimento, sexo, cpf, cep, logradouro, numero, complemento, bairro, estado, cidade, telefone, telefone_contato, id_status)
                    VALUES (:nome, :data_nascimento, :sexo, :cpf, :cep, :logradouro, :numero, :complemento, :bairro, :estado, :cidade, :telefone, :telefone_contato, :id_status)';

            $stmt = $conexao->prepare($sql);
            $stmt->execute([
                "nome" => $nomeFormatado,
                "data_nascimento" => $dados['datanascimento'],
                "sexo" => $dados['sexo'],
                "cpf" => $dados['cpf'],
                "cep" => $dados['cep'],
                "logradouro" => $dados['logradouro'],
                "numero" => $dados['numero'],
                "complemento" => $dados['complemento'],
                "bairro" => $dados['bairro'],
                "estado" => $dados['estado'],
                "cidade" => $dados['cidade'],
                "telefone" => $dados['telefone'],
                "telefone_contato" => $dados['telefone_contato'],
                "id_status" => $dados['status']
            ]);
            return 'Cadastro Salvo!';
        }
    }

    // Editar os dados de um paciente
    public static function editar($dados) {
        $nomeFormatado = ucwords($dados['nome']);
        $conexao = self::conectar();
        
            $sql = "UPDATE pacientes SET nome = :nome, data_nascimento = :data_nascimento, sexo = :sexo, cpf = :cpf, 
                    cep = :cep, logradouro = :logradouro, numero = :numero, complemento = :complemento, 
                    bairro = :bairro, estado = :estado, cidade = :cidade, telefone = :telefone, 
                    telefone_contato = :telefone_contato, id_status = :id_status WHERE id_paciente = :id_paciente";
            
            $stmt = $conexao->prepare($sql);
            $stmt->execute([
                "id_paciente" => $dados['id'],
                "nome" => $nomeFormatado,
                "data_nascimento" => $dados['datanascimento'],
                "sexo" => $dados['sexo'],
                "cpf" => $dados['cpf'],
                "cep" => $dados['cep'],
                "logradouro" => $dados['logradouro'],
                "numero" => $dados['numero'],
                "complemento" => $dados['complemento'],
                "bairro" => $dados['bairro'],
                "estado" => $dados['estado'],
                "cidade" => $dados['cidade'],
                "telefone" => $dados['telefone'],
                "telefone_contato" => $dados['telefone_contato'],
                "id_status" => $dados['status']
            ]);
            return 'Cadastro Atualizado!';
    }

    public static function buscar($id){
        $conexao = self::conectar();
        
        $sqlVerificarBusca = 'SELECT * from pacientes WHERE id_paciente = :id_paciente';
        $stmtVerificarBusca = $conexao->prepare($sqlVerificarBusca);
        $stmtVerificarBusca->execute(["id_paciente" => $id]);
        $stmtVerificarBusca->fetch(PDO::FETCH_ASSOC); 
        if($stmtVerificarBusca->rowCount() === 0) {
            return 'id_nao_existe';
        } else {
            $sql = "SELECT * from pacientes WHERE id_paciente = :id_paciente";
            $stmt = $conexao->prepare($sql);
            $stmt->execute(["id_paciente"=> $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC); 
        }
    }

    // Ler todos os pacientes
    public static function ler() {
        $conexao = self::conectar();
        $sql = 'SELECT * FROM pacientes';
        $stmt = $conexao->prepare($sql);
        $stmt->execute();
        $pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($pacientes as &$paciente){
            if (!empty($paciente['data_nascimento'])){
                $paciente['data_nascimento'] = date('d/m/Y', strtotime($paciente['data_nascimento']));
            }
        }
        return $pacientes;
    }

    // Inativar um paciente
    public static function inativar($id, $id_status) {
        if (is_array($id_status)) {
            $id_status = $id_status[0];
        }
        $conexao = self::conectar();
        $sql = 'UPDATE pacientes SET id_status = :id_status WHERE id_paciente = :id_paciente';
        $stmt = $conexao->prepare($sql);
        $stmt->execute(["id_paciente" => $id,
                        "id_status" => $id_status]);
        return 'Cadastro inativado!';
    }

    // Reativar um paciente
    public static function reativar($id, $id_status){
        if (is_array($id_status)) {
            $id_status = $id_status[0];
        }
        $conexao = self::conectar();
        $sql = 'UPDATE pacientes SET id_status = :id_status WHERE id_paciente = :id_paciente';
        $stmt = $conexao->prepare($sql);
        $stmt->execute(["id_paciente" => $id,
                        "id_status" => $id_status]);
        return 'Cadastro reativado!';
    }

    // Localizar um paciente
    public static function localizar($termo){
        $conexao = self::conectar();
        $sql = "SELECT * FROM pacientes 
            WHERE nome LIKE :termo or cpf LIKE :termo
            LIMIT 4";
        $stmt = $conexao->prepare($sql);
        $stmt->execute(["termo" => "%$termo%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}