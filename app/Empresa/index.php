<?php
require_once __DIR__ . '/../Core/bootstrap.php';

use TesteElian\Empresa\Controllers\EmpresaController;
use TesteElian\Core\View;

$empresa = new EmpresaController();

$post = ($_GET ? $_GET : []) + ($_POST ? $_POST : []);

View::header();

if (isset($post['salvar'])) {
    $save = $empresa->save($post);

    if ($save['error'] == true) {
        echo View::messageError($save['message']);
        $empresa->post($post);
    } else {
        echo View::messageSuccess($save['message']);
        $empresa->index([]);
    }

} elseif (isset($post['cadastrar'])) {
    $empresa->post($post);
} elseif (isset($post['alterar'])) {
    $empresa->post($post);
} elseif (isset($post['delete'])) {
    $delete = $empresa->delete($post);

    if ($delete['error'] == true) {
        echo View::messageError($delete['message']);
    } else {
        echo View::messageSuccess($delete['message']);
    }

    $empresa->index($post);
} else {
    $empresa->index($post);
}

View::footer(['empresa/empresa.js']);
