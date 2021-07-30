$(document).ready(function () {

    $('.img-container').click(function () {

        if ($(this).hasClass('full')) {
            $(this).animate({height: 300}, 600);
            $(this).removeClass('full');
        } else {
            let elems = $(this).children().length;
            let height = 300 * elems;
            $(this).animate({height: height}, 600);
            $(this).addClass('full');
        }

    })


    $('.admin-button-comments').click(function () {
        $(this).parent().next('.comments').toggle(600);
    });
    $('.admin-button-reserve').click(function () {
        $(this).next().toggle(200);
    });
    $('.filter-button').click(function () {
        $('.filter').slideToggle(200);
    });

    $('.vote-range').change(function () {
        var data = $(this).closest('form').serializeArray();
        $.ajax({
            url: vote_route,
            data: data,
            success: function (response) {
                let item = '#item-mark-' + data[0]['value'];
                $(item).find('p').html(response);
            },
            error: function () {
                console.log('e')
            },
            dataType: 'html'
        })
    });

    $('.comment-button').click(function () {
        event.preventDefault();
        let data = $(this).closest('form').serializeArray();
        let obj = $(this);
        $.ajax({
            url: comment_route,
            data: data,
            success: function (response) {
                obj.parents('.new-comment').next().prepend(newComment(user, data[1]['value']));
            },
            error: function (response) {
                let message = '<span> Сообщение не должно быть пустым </span>';
                $('#alert').append(message);
                setTimeout(function () {
                    $('#alert span').remove();
                }, 5000);

            },
            dataType: 'html'
        })
    });

    $('.reserve-button').click(function () {
        event.preventDefault();
        let data = $(this).closest('form').serializeArray();
        $.ajax({
            url: reserve_route,
            data: data,
            success: function (response) {
                let message = '<span> Резерв добавлен </span>';
                $('#success').append(message);
                setTimeout(function () {
                    $('#success span').remove();
                }, 5000);
            },
            error: function () {
                let message = '<span> Количество не может быть отрицательным </span>';
                $('#alert').append(message);
                setTimeout(function () {
                    $('#alert span').remove();
                }, 5000);
            },
            dataType: 'html'
        })
    });

    $('.dropdown-toggle').click(function () {
        $(this).next().slideToggle(0);
    })

    function current_date() {
        let d = new Date();

        let month = d.getMonth() + 1;
        let day = d.getDate();

        return d.getFullYear() + '-' +
            (month < 10 ? '0' : '') + month + '-' +
            (day < 10 ? '0' : '') + day;
    }

    function newComment(author, value) {
        let comment = '<div class="comment-body">' +
            '<h5>' + author + '</h5>' +
            '<small>' + current_date() + '</small>' +
            '<p>' + value + '</p>' +
            '</div>';
        return comment;
    }
});
