<?php
namespace TesteElian\Empresa\Models;

use Exception;
use TesteElian\Core\Model;
use PDO;

class EmpresaContatoModel extends Model {

    function __construct()
    {
        parent::__construct();
    }

    /**
     * Retorna os contatos da empresa
     */
    public function getEmpresaContatos($empresaId)
    {
        $query = 'SELECT contatoId
                       , email
                       , telefone
                    FROM empresaContato
                   WHERE empresaId = :empresaId';

        $sth = $this->Connection->prepare($query);
        $sth->bindValue(':empresaId', $empresaId, PDO::PARAM_INT);
        $sth->execute();

        return $sth->fetchAll();
    }

    /**
     * Insere ou atualiza uma empresa
     */
    public function save($empresaId, $contacts)
    {
        if (empty($empresaId) || empty($contacts)) {
            return false;
        }

        if (count(array_filter($contacts['email'])) != count(array_unique(array_filter($contacts['email'])))) {
            $this->Error = 'Os e-mails dos contatos não podem ser iguais.';
            throw new Exception($this->Error, 6000);
        }

        foreach ($contacts['email'] as $key => $email) {
            $telefone = preg_replace('/[^0-9]/', '', $contacts['telefone'][$key]);

            if (empty($email) || empty($telefone) || !in_array(strlen($telefone), [10, 11])) {
                continue;
            }
            
            $query = 'INSERT INTO empresaContato (
                                  empresaId
                                , email
                                , telefone
                                ) 
                           VALUES (
                                  :empresaId
                                , :email
                                , :telefone
                                )';
        
            $sth = $this->Connection->prepare($query);

            $sth->bindValue(':empresaId', $empresaId, PDO::PARAM_INT);
            $sth->bindValue(':email', $email, PDO::PARAM_STR);
            $sth->bindValue(':telefone', $telefone, PDO::PARAM_STR);
            
            if (!$sth->execute()) {
                $this->Error = 'Não foi possível salvar os contatos da empresa';
                throw new Exception($this->Error);
            }
        }

        return true;
    }

    /**
     * Retorna os contatos pelo e-mail
     */
    public function getContactByEmail($empresaId, $email)
    {
        $query = 'SELECT contatoId
                    FROM empresaContato
                   WHERE empresaId = :empresaId
                     AND email = :email';

        $sth = $this->Connection->prepare($query);

        $sth->bindValue(':empresaId', $empresaId, PDO::PARAM_INT);
        $sth->bindValue(':email', $email, PDO::PARAM_STR);

        $sth->execute();

        return $sth->fetch();
    }

    /**
     * Exclui os contatos de uma empresa
     */
    public function deleteByEmpresa($empresaId)
    {
        // Se tem o id, atualiza, senão insere
        $query = 'DELETE FROM empresaContato 
                        WHERE empresaId = :empresaId';
            
        $sth = $this->Connection->prepare($query);

        $sth->bindValue(':empresaId', $empresaId, PDO::PARAM_INT);

        return $sth->execute();
    }

}