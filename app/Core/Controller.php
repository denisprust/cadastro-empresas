<?php

namespace TesteElian\Core;

class Controller {
    /** @var string Diretório onde será buscado o arquivo da view */
    private $viewDir;

    /** @var array Array de variaveis que serão enviadas para a view */
    private $vars = [];

    function __construct()
    {
        $this->setViewDir();
    }

    /**
     * Faz o include do arquivo de view
     */
    public function render($view)
    {
        try {
            if(file_exists($this->getViewDir().$view.'.php')) {
                extract($this->vars);

                include $this->getViewDir().$view.'.php';
            } else {
                throw new \Exception("Arquivo de view '$view' não existe");
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Seta um array de variáveis que será enviado para a view
     */
    public function setVars(Array $vars = null)
    {
        if(!$vars) {
            return;
        }

        $this->vars = $this->vars + $vars;
    }

    /**
     * Permite setar o diretório específico de views para o controller
     */
    public function setViewDir($viewDir = null)
    {
        $reflection = new \ReflectionClass(get_called_class());
        if(isset($viewDir)) {
            $this->viewDir = dirname($reflection->getFileName()) . DS .'..' . DS . $viewDir . DS  . 'Views\\';
        } else {
            $this->viewDir = dirname($reflection->getFileName()) . DS .'..' . DS . 'Views' . DS;
        }
    }

    public function getViewDir()
    {
        return $this->viewDir;
    }

}