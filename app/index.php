<?php
require_once __DIR__ . '/Core/bootstrap.php';

use TesteElian\Empresa\Controllers\EmpresaController;

$empresa = new EmpresaController();

$empresa->index([]);