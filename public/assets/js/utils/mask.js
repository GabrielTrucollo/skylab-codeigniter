var options = {
    onKeyPress: function (cpf, ev, el, op) {
        var masks = ['000.000.000-000', '00.000.000/0000-00'];
        $('.cpfCnpj').mask((cpf.length > 14) ? masks[1] : masks[0], op);
    }
}

$(document).ready(function(){
    $('#doc_cpf').mask('000.000.000-00', {reverse: true});
    $('#doc_cnpj').mask('00.000.000/0000-00', {reverse: true});
    $('#phone_with_ddd').mask('(00) 0000-0000');
    $('#date').mask('00/00/0000');
    $('#time').mask('00:00');
    $('#date_time').mask('00/00/0000 00:00:00');
    $('#money').mask("#.##0,00", {reverse: true});
    $("#cep").mask("00.000-000");
    $('#cpfCnpj').length > 11 ? $('.cpfCnpj').mask('00.000.000/0000-00', options) : $('.cpfCnpj').mask('000.000.000-00#', options);
})