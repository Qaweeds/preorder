$(document).ready(function () {

    $('#ready_or_not').change(function () {
        $timeInput = $('#makeTimeBlock');
        switch ($(this).val()) {
            case '1':
                $timeInput.hide(400);
                break;
            case '2':
                $timeInput.show(400);
                break;
        }
    });

    $('#group').change(function () {
        var data = $('#group').serialize();
        $.ajax({
            url: cat_route,
            data: data,
            success: function (data) {
                var ops;
                data.forEach(el => ops += '<option value="'+el+'">' +el+'</option>');
                $('#category').html(ops);
            },
            error: function () {
                console.log('e')
            },
            dataType: 'json'
        })
    });

});
