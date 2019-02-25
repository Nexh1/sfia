$(document).ready(function() {

    $('#entreprises_create_export').on('change', function() {
        $('#entreprises_create_exportTotal').closest(".form-group").toggle(this.checked);
    }).trigger('change');

    $('#entreprises_create_qualiteAgrement').on('change', function() {
        $('#entreprises_create_qualite').closest(".form-group").toggle(this.checked);
    }).trigger('change');   
});