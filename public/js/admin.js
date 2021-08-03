$(document).ready(function () {

    $('#selfprice-form').change(function (event) {
        if (event.target.tagName !== 'INPUT') {
            data = $(this).serializeArray();
            if (data.length === 6) {
                $.ajax({
                    url: window.location.href + '/selfpricevalue',
                    data: data,
                    success: function (data) {
                        $('#selfprice-form #selfprice-val').val(data);
                    },
                    error: function () {
                        console.log('e');
                    },
                    dataType: 'html'
                })
            }
        }
    });

    $('#sellprice-form').change(function () {
        if (event.target.tagName !== 'INPUT') {
            data = $(this).serializeArray();
            if (data.length === 6) {
                $.ajax({
                    url: window.location.href + '/sellpricevalue',
                    data: data,
                    success: function (data) {
                        console.log(data)
                        $('#sellprice-form #sellprice-val').val(data);
                    },
                    error: function () {
                        console.log('e');
                    },
                    dataType: 'html'
                })
            }
        }
    });

});
