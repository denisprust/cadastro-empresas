<?php
namespace TesteElian\Empresa\Models;

use Exception;
use PDO;
use TesteElian\Core\Model;
use TesteElian\Empresa\Models\EmpresaContatoModel;

class EmpresaModel extends Model {

    function __construct()
    {
        parent::__construct();
    }

    /**
     * Retorna todas as empresas com filtro
     */
    public function getEmpresas($request)
    {
        $query = 'SELECT empresaId
                       , cnpj
                       , nome
                       , dataCadastro
                       , dataAlteracao
                    FROM empresa
                   WHERE 1=1';

        if (!empty($request['cnpj'])) {
            // Mantém apenas números
            $cnpj = preg_replace('/[^0-9]/', '', $request['cnpj']);
            $query .= " AND cnpj = {$cnpj}";
        }

        if (!empty($request['nome'])) {
            $query .= " AND nome like '%{$request['nome']}%'";
        }

        $sth = $this->Connection->prepare($query);
        $sth->execute();

        return $sth->fetchAll();
    }

    /**
     * Retorna os dados da empresa
     */
    public function getEmpresa($request)
    {
        if (empty($request['empresaId'])) {
            return [];
        }

        $query = "SELECT empresaId
                       , cnpj
                       , nome
                       , dataCadastro
                       , dataAlteracao
                    FROM empresa
                   WHERE empresaId = :empresaId";

        $sth = $this->Connection->prepare($query);
        $sth->bindValue(':empresaId', $request['empresaId'], PDO::PARAM_INT);
        $sth->execute();

        return $sth->fetch();
    }

    /**
     * Retorna os dados da empresa pelo cnpj
     */
    private function getEmpresaByCnpj($cnpj, $empresaId = null)
    {
        $query = 'SELECT empresaId
                    FROM empresa
                   WHERE cnpj = :cnpj';

        if ($empresaId) {
            $query .= ' AND empresaId != :empresaId';
        }

        $sth = $this->Connection->prepare($query);

        $sth->bindValue(':cnpj', $cnpj, PDO::PARAM_STR);

        if ($empresaId) {
            $sth->bindValue(':empresaId', $empresaId, PDO::PARAM_STR);
        }
        
        $sth->execute();

        return $sth->rowCount();
    }

    /**
     * Insere ou atualiza uma empresa
     */
    public function save($request)
    {
        // Valida os campos obrigatórios
        if (empty($request['cnpj']) || empty($request['nome'])) {
            throw new Exception('Favor informar todos os campos.', 6000);
        }

        // Valida o Cnpj
        $request['cnpj'] = preg_replace('/[^0-9]/', '', $request['cnpj']);

        $empresaId = !empty($request['empresaId']) ? $request['empresaId'] : null;

        if ($this->validateCnpj($request['cnpj'])) {
            throw new Exception('Favor informar um CNPJ válido.', 6000);
        }

        // Valida se já existe uma empresa com o Cnpj informado
        if ($this->getEmpresaByCnpj($request['cnpj'], $empresaId)) {
            throw new Exception('Já existe uma empresa cadastrada com o Cnpj informado.', 6000);
        }

        // Se tem o id, atualiza, senão insere
        if ($empresaId) {
            $query = ' UPDATE empresa 
                          SET cnpj = :cnpj
                            , nome = :nome
                            , dataAlteracao = NOW()
                        WHERE empresaId = :empresaId';
    
            $sth = $this->Connection->prepare($query);
            $sth->bindValue(':empresaId', $request['empresaId'], PDO::PARAM_INT);

        } else {
            $query = ' INSERT INTO empresa (
                                    cnpj
                                  , nome
                                  , dataCadastro
                                  , dataAlteracao
                                  ) 
                            VALUES (
                                    :cnpj
                                  , :nome
                                  , NOW()
                                  , NOW()
                                  )';

            $sth = $this->Connection->prepare($query);
        }

        $sth->bindValue(':cnpj', $request['cnpj'], PDO::PARAM_STR);
        $sth->bindValue(':nome', $request['nome'], PDO::PARAM_STR);
        if (!$sth->execute()) {
            return false;
        }

        if (!empty($request['contact'])) {

            $empresaId = !empty($request['empresaId']) ? $request['empresaId'] : $this->Connection->lastInsertId();

            $empresaContatoModel = new EmpresaContatoModel();
            $empresaContatoModel->Connection = $this->Connection;

            // Remove todos os contatos para inserir novamente
            if (!$empresaContatoModel->deleteByEmpresa($empresaId)) {
                throw new Exception('Não foi possível salvar os contatos', 6000);
            }

            if (!$empresaContatoModel->save($empresaId, $request['contact'])) {
                $this->Error = $empresaContatoModel->Error;
                return false;
            }
            
        }

        return true;
    }

    /**
     * Insere ou atualiza uma empresa
     */
    public function delete($request)
    {
        if (empty($request['empresaId'])) {
            $this->Error = 'Empresa não encontrada.';
            return false;
        }

        // Se tem o id, atualiza, senão insere
        $query = 'DELETE FROM empresa 
                        WHERE empresaId = :empresaId';
            
        $sth = $this->Connection->prepare($query);

        $sth->bindValue(':empresaId', $request['empresaId'], PDO::PARAM_INT);

        return $sth->execute();
    }

    private function validateCnpj($cnpj)
    {
        $cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);
        
        // Valida tamanho
        if (strlen($cnpj) != 14) {
            return false;
        }

        // Verifica se todos os dígitos são iguais
        if (preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;	
        }

        // Valida primeiro dígito verificador
        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;

        if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto)) {
            return false;
        }

        // Valida segundo dígito verificador
        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;

        return $cnpj[13] == ($resto < 2 ? 0 : 11 - $resto);
    }

}