newContact = function() {
    let table = $('#table-contact');

    table.find('tbody').append(
        '<tr>'+
            '<td class="align-middle"><input type="text" name="contact[email][]" class="form-control"></td>'+
            '<td class="align-middle"><input type="text" name="contact[telefone][]" class="form-control phone"></td>'+
            '<td class="align-middle"><i class="far fa-trash-alt text-danger cursor-pointer" onclick="deleteContact(this)" title="Remover"></i></td>'+
        '</tr>'
    )
    
    $('.phone').mask(behavior, options);
}

deleteContact = function(elem) {
    let button = $(elem);

    let table = $('#table-contact');

    if (table.find('tbody tr').length > 1) {
        button.closest('tr').remove();
    } else {
        button.closest('tr').find('td input').val('');
    }
}
