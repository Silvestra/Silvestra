$(document).ready(function () {
    $('.silvestra-banner-delete, .silvestra-banner-zone-delete').click(function (e) {
        e.preventDefault();

        var $closeButton = $(this).data('close-button');
        var $confirmButton = $(this).data('confirm-button');
        var $errorTitle = $(this).data('error-title');
        var $url = $(this).attr('href');

        swal({
            title: $(this).data('title'),
            type: 'warning',
            showCancelButton: true,
            confirmButtonClass: 'btn-danger',
            confirmButtonText: $confirmButton,
            cancelButtonText: $closeButton,
            closeOnConfirm: false
        }, function () {
            $.ajax({
                url: $url,
                type: 'DELETE',
                success: function ($response) {
                    swal({
                        title: $response.title,
                        type: $response.type,
                        confirmButtonClass: 'btn-default',
                        confirmButtonText: $closeButton
                    }, function () {
                        location.reload();
                    });
                },
                error: function ($request, $status, $error) {
                    swal({
                        title: $errorTitle,
                        type: 'error',
                        confirmButtonClass: 'btn-default',
                        confirmButtonText: $closeButton
                    });
                }
            });
        });
    });
});
