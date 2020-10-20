<?php
namespace TesteElian\Empresa\Controllers;

use Exception;
use TesteElian\Core\Controller;
use TesteElian\Empresa\Models\EmpresaModel;
use TesteElian\Empresa\Models\EmpresaContatoModel;
use DB;

class EmpresaController extends Controller{

    public $Model;

    function __construct()
    {
        parent::__construct();
        $this->Model = new EmpresaModel();
    }

    public function getModel()
    {
        return $this->Model;
    }

    public function index($request)
    {
        $this->setVars([
            'empresas' => $this->getModel()->getEmpresas($request)
        ]);

        $this->render('index');
    }

    public function post($request)
    {
        $empresaContatoModel = new EmpresaContatoModel();
        $contacts = !empty($request['empresaId']) ? $empresaContatoModel->getEmpresaContatos($request['empresaId']) : [];

        $this->setVars([
            'empresa' => $this->getModel()->getEmpresa($request),
            'contatos' => $contacts
        ]);

        $this->render('post');
    }

    public function save($request)
    {
        $response = [
            'message' => 'Empresa salva com sucesso!',
            'error' => false,
        ];

        $model = $this->getModel();
        $model->beginTransaction();

        try {
            if (!$this->getModel()->save($request)) {
                throw new Exception('Não foi possível salvar a empresa.', 6000);
            }

            $model->commit();
        } catch (Exception $e) {
            $model->rollback();

            $message = $this->getModel()->Error ? $this->getModel()->Error : 'Não foi possível salvar a empresa';

            if (in_array($e->getCode(), [6000])) {
                $message = $e->getMessage();
            }

            $response = [
                'message' => $message,
                'error' => true,
            ];
        }

        unset($_POST);

        return $response;
    }
    
    public function delete($request)
    {
        $response = [
            'message' => 'Empresa removida com sucesso!',
            'error' => false,
        ];

        try {
            if (!$this->getModel()->delete($request)) {
                throw new Exception('Não foi possível remover a empresa.', 600);
            }
        } catch (Exception $e) {
            $response = [
                'message' => $this->getModel()->Error ? $this->getModel()->Error : 'Não foi possível remover a empresa',
                'error' => true,
            ];
        }

        unset($_POST);

        return $response;
    }
    
}