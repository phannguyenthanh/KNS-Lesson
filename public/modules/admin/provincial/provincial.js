$(function () {
    activeMenu('data','provincial',true);
    $(document).on('click', '.delete-object', function (e) {
        e.preventDefault();
        var object_name = $(this).attr('object_name');
        var object_id = $(this).attr('object_id');
        var row = $(this).closest('tr');
        $.confirm({
            title: 'Confirm!',
            content: 'Bạn có muốn xóa: ' + object_name + '?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        type: 'GET',
                        url: '/admin/province/delete/' + object_id,
                        success: function (result) {
                            if (result['status']) {
                                $('.alert-success').show();
                                $('.alert-danger').hide();
                                row.remove();
                            }
                            else {
                                $('.alert-success').hide();
                                $('.alert-danger').show();
                                window.location.href = '/admin/province/index';
                            }
                        }
                    });
                },
                cancel: function () {

                }

            }
        });
    });
});

