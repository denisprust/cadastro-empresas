<?php

namespace TesteElian\Core;

/**
 * Arquivo de carregamento de classes
 */

class Autoload
{
    private $dirName;
    private $fileName;

    /**
     * Extrai o diretório do arquivo através do namespace
     *
     * @param string $className caminho completo até o script
     *
     * @return void
     *
     */
    public function setDirName($className)
    {
        $className = ltrim($className, "\\");

        if ($lastNsPos = strrpos($className, "\\")) {
            $namespace = substr($className, 0, $lastNsPos);
           
            $namespace = str_replace(PROJECT_NAMESPACE, '', $namespace);
           
            $this->dirName = $namespace;

        }
    }

    /**
     * Extrai o nome do arquivo através do namespace
     *
     * @param string $className caminho completo até o script
     *
     * @return void
     *
     */
    protected function setFilename($className)
    {
        $className = ltrim($className, "\\");

        if ($lastNsPos = strrpos($className, "\\")) {
            $className = substr($className, $lastNsPos + 1);
        }
        $this->fileName = str_replace('_', DS, $className) . '.php';
    }

    /**
     * Converte o padrão CamelCase para camel_case
     */
    public function fromCamelCase($input)
    {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('_', $ret);
    }

    /**
     * Faz o include dos arquivos controllers
     */
    public function loadControllers($className)
    {

        $this->setDirName($className);
        $this->setFilename($className);

        $fileName = ROOT . DS . $this->dirName . DS . $this->fileName;

        if (is_readable($fileName)) {
            include $fileName;
        }
    }

    /**
     * Faz o include dos arquivos models
     */
    public function loadModels($className)
    {
        $this->setDirName($className);
        $this->setFilename($className);

        $fileName = ROOT . DS . $this->dirName . DS . 'Models' . DS . $this->fileName;

        if (is_readable($fileName)) {
            include $fileName;
        }
    }

    /**
     * Faz o include dos arquivos helpers
     */
    public function loadHelpers($className)
    {
        $this->setDirName($className);
        $this->setFilename($className);

        $fileName = ROOT . DS . 'helpers' . DS . $this->dirName . DS .  $this->fileName;
        
        if (is_readable($fileName)) {
            include $fileName;
        }
    }
}