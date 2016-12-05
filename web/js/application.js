$(document).ready(function () {

    $('#form-add-application').submit(function (e) {

        var url = $('#input-url').val();
        var name = $('#input-name').val();

        if (url === '' || name === '') {
            e.preventDefault();
            swal("Ooops!", "All fields must be filled!", "error");
        }

    });

    $('.toggle-trace').click(function(e) {
        e.preventDefault();
        var elem = $($(this).data('toggle'));

        if($(elem).hasClass('hidden')) {
            $(elem).removeClass('hidden');
        } else {
            $(elem).addClass('hidden');
        }
    });

});
