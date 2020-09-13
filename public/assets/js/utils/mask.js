var options = {
    onKeyPress: function (cpf, ev, el, op) {
        var masks = ['000.000.000-000', '00.000.000/0000-00'];
        $('#doc_cpf_cnpj').mask((cpf.length > 14) ? masks[1] : masks[0], op);
    }
}

$(document).ready(function(){
    $('#doc_cpf').mask('000.000.000-00');
    $('#doc_cnpj').mask('00.000.000/0000-00');
    $('#phone_with_ddd').mask('(00) 0000-0000');
    $('#date').mask('00/00/0000');
    $('#time').mask('00:00');
    $('#date1').mask('00/00/0000');
    $('#time1').mask('00:00');
    $('#date_time').mask('00/00/0000 00:00:00');
    $('#money').mask("#.##0,00");
    $("#address_zipcode").mask("00.000-000");
    $('#doc_cpf_cnpj').length > 11 ? $('#doc_cpf_cnpj').mask('00.000.000/0000-00', options) : $('#doc_cpf_cnpj').mask('000.000.000-00#', options)
})