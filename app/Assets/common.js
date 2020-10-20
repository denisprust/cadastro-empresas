/** Máscaras */
$('.cnpj').mask('00.000.000/0000-00', {reverse: true});

var behavior = function (val) {
    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
},
options = {
    onKeyPress: function (val, e, field, options) {
        field.mask(behavior.apply({}, arguments), options);
    }
};

$('.phone').mask(behavior, options);
/** Fim Máscaras */

/** Datatables */
$(document).ready(function() {
    $('#datatable').DataTable({
        language: {
            'sEmptyTable': 'Nenhum registro encontrado',
            'sInfo': 'Mostrando de _START_ até _END_ de _TOTAL_ registros',
            'sInfoEmpty': 'Mostrando 0 até 0 de 0 registros',
            'sInfoFiltered': '(Filtrados de _MAX_ registros)',
            'sInfoPostFix': '',
            'sInfoThousands': '.',
            'sLengthMenu': '_MENU_ resultados por página',
            'sLoadingRecords': 'Carregando...',
            'sProcessing': 'Processando...',
            'sZeroRecords': 'Nenhum registro encontrado',
            'sSearch': 'Pesquisar',
            'oPaginate': {
                'sNext': 'Próximo',
                'sPrevious': 'Anterior',
                'sFirst': 'Primeiro',
                'sLast': 'Último'
            },
            'oAria': {
                'sSortAscending': ': Ordenar colunas de forma ascendente',
                'sSortDescending': ': Ordenar colunas de forma descendente'
            },
            'select': {
                'rows': {
                    '_': 'Selecionado %d linhas',
                    '0': 'Nenhuma linha selecionada',
                    '1': 'Selecionado 1 linha'
                }
            },
            'buttons': {
                'copy': 'Copiar para a área de transferência',
                'copyTitle': 'Cópia bem sucedida',
                'copySuccess': {
                    '1': 'Uma linha copiada com sucesso',
                    '_': '%d linhas copiadas com sucesso'
                }
            }
        }
    });
});
/** Fim Datatables */