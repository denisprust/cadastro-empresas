<div class="container mt-4 mb-4">
    
    <div class="col-12">
        <h2>
            Cadastro de empresa
            <a href="index.php" class="btn btn-primary float-right" title="Voltar"><i class="fa fa-arrow-left"></i> Voltar</a>
        </h2>
        <hr>
    </div>

    <div class="col-12">
        <form method="POST" action="">
            <input type="hidden" value="<?= isset($empresa['empresaId']) ? $empresa['empresaId'] : ''; ?>" name="empresaId">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="cnpj">CNPJ</label>
                    <input type="cnpj" class="form-control cnpj" value="<?= isset($empresa['cnpj']) ? $empresa['cnpj'] : '' ?>" name="cnpj" id="cnpj" placeholder="Cnpj">
                </div>
                <div class="form-group col-md-6">
                    <label for="nome">Nome</label>
                    <input type="text" class="form-control" value="<?= isset($empresa['nome']) ? $empresa['nome'] : '' ?>"name="nome" id="nome" placeholder="Nome">
                </div>
            </div>

            <div class="form-row mt-5">
                <div class="form-group col-xs-12 col-md-6">
                    <h4>
                        Contatos
                        <hr>
                    </h4>
                    <table class="table table-condensed table-bordered" id="table-contact">
                        <thead>
                            <th>E-mail</th>
                            <th>Telefone</th>
                            <th><i class="fas fa-plus text-success cursor-pointer" id="new-contact" onclick="newContact(this)" title="Novo contato"></i></th>
                        </thead>
                        <tbody>
                            <?php if (!empty($contatos)): ?>
                                <?php foreach ($contatos as $contato): ?>
                                    <tr>
                                        <td class="align-middle">
                                            <input type="text" name="contact[email][]" class="form-control" value="<?= $contato['email']; ?>">
                                        </td>
                                        <td class="align-middle">
                                            <input type="text" name="contact[telefone][]" class="form-control phone"  value="<?= $contato['telefone']; ?>">
                                        </td>
                                        <td class="align-middle">
                                            <i class="far fa-trash-alt text-danger cursor-pointer" onclick="deleteContact(this)" title="Remover"></i>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <?php $hash = uniqid();?>
                                <tr>
                                    <td class="align-middle">
                                        <input type="text" name="contact[email][]" class="form-control">
                                    </td>
                                    <td class="align-middle">
                                        <input type="text" name="contact[telefone][]" class="form-control phone">
                                    </td>
                                    <td class="align-middle">
                                        <i class="far fa-trash-alt text-danger cursor-pointer" onclick="deleteContact(this)" title="Remover"></i>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <hr>
            <button type="submit" name="salvar" class="btn btn-success">Salvar</button>
        </form>
    </div>
</div>