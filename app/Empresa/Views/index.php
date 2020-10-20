<?php

use TesteElian\Core\View;

?>

<div class="container mt-4 mb-4">
    
    <div class="col-12">
        <h1>
            Empresas
            <form action="index.php" class="float-right" method="POST">
                <button type="submit" name="cadastrar" class="btn btn-success float-right" title="Nova empresa"><i class="fa fa-plus"></i> Adicionar</button>
            </form>
        </h1>
        <hr>
    </div>

    <div class="col-12">
        <form method="POST" action="">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="cnpj">CNPJ</label>
                    <input type="cnpj" class="form-control cnpj" value="<?= isset($_POST['cnpj']) ? $_POST['cnpj'] : '' ?>" name="cnpj" id="cnpj" placeholder="Cnpj">
                </div>
                <div class="form-group col-md-6">
                    <label for="nome">Nome</label>
                    <input type="text" class="form-control" value="<?= isset($_POST['nome']) ? $_POST['nome'] : '' ?>"name="nome" id="nome" placeholder="Nome">
                </div>
            </div>
            <button type="submit" name="filtrar" class="btn btn-primary">Filtrar</button>
        </form>
    </div>
    <hr>
    <div class="col-12 mt-5">
        <?php if (empty($empresas)): ?>
            <div class="alert alert-warning">
                Nenhuma empresa encontrada.
            </div>
        <?php else: ?>
            <table class="table datatable" id="datatable">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">CNPJ</th>
                        <th scope="col">Data de criação</th>
                        <th scope="col">Data da última alteração</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($empresas as $empresa): ?>
                        <tr>
                            <th scope="row" class="align-middle">
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Ações
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <form method="POST">
                                            <input type="hidden" name="empresaId" value="<?= $empresa['empresaId']; ?>">
                                            <button type="submit" name="alterar" class="dropdown-item">
                                                <i class="far fa-edit"></i> Editar
                                            </button>
                                        </form>
                                        <form method="POST">
                                            <input type="hidden" name="empresaId" value="<?= $empresa['empresaId']; ?>">
                                            <button type="submit" name="delete" class="dropdown-item">
                                                <i class="far fa-trash-alt text-danger"></i> Excluir
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </th>
                            <td class="align-middle"><?= $empresa['nome']; ?></td>
                            <td class="align-middle"><?= View::formatCnpjCpf($empresa['cnpj']); ?></td>
                            <td class="align-middle"><?= date('d/m/Y', strtotime($empresa['dataCadastro'])); ?></td>
                            <td class="align-middle"><?= date('d/m/Y', strtotime($empresa['dataAlteracao'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>