<?php

namespace TesteElian\Core;

use TesteElian\Core\Controller;

class View
{

    private $js = [];

    function __construct()
    {
    }

    public function header()
    {
        $Controller = new Controller();

        $Controller->setViewDir('Base');

        $Controller->render('header');
    }

    public function footer($js = [])
    {
        $Controller = new Controller();

        $Controller->setViewDir('Base');

        $Controller->setVars(['aJs' => $js]);

        $Controller->render('footer');
    }

    public function messageError($message)
    {
        $Controller = new Controller();

        $Controller->setViewDir('Base');

        $Controller->setVars(['message' => $message]);
        
        $Controller->render('messageError');
    }

    public function messageSuccess($message)
    {
        $Controller = new Controller();

        $Controller->setViewDir('Base');

        $Controller->setVars(['message' => $message]);

        $Controller->render('messageSuccess');
    }

    public static function formatCnpjCpf($value)
    {
        $cpfLength = 11;
        $cnpjCpf = preg_replace("/\D/", '', $value);

        if (strlen($cnpjCpf) === $cpfLength) {
            return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpjCpf);
        } 

        return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpjCpf);
    }

    public function setJs($js)
    {
        $this->js[] = $js;
    }

    public function getJs()
    {
        return $this->js;
    }
}