$(document).ready(function () {

    inactive();

    function current_date() {
        let d = new Date();

        let month = d.getMonth() + 1;
        let day = d.getDate();
        let h = d.getHours();
        let m = d.getMinutes();


        return (day < 10 ? '0' : '') + day + '-' +
            (month < 10 ? '0' : '') + month + '-' +
            d.getFullYear() + ', ' +
            h + ':' +
            m;
    }

    function newComment(author, value) {
        let comment = '<div class="comment-body">' +
            '<h5>' + author + '</h5>' +
            '<small>' + current_date() + '</small>' +
            '<p>' + value + '</p>' +
            '</div>';
        return comment;
    }

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
        let range = 250;
        if ($(this).hasClass('open')) {
            range = -250;
            $(this).removeClass('open');
        } else {
            $(this).addClass('open');
        }
        $('html, body').animate({scrollTop: $(window).scrollTop() + range});
        $(this).parent().next('.comments').toggle(600).children('.new-comment').css('display', 'block');
    });
    $('.admin-button-reserve').click(function () {
        $(this).next().slideToggle(200);
    });
    $('.filter-button').click(function () {
        $('.filter').slideToggle(200);
    });
    $('.vote-range').change(function () {
        $(this).parents('.form-container').prev('.rating-mark').find('.users-mark').html($(this).val());
    });
    $('.do-rating-button').click(function () {
        $(this).prevAll('.users-mark').html('');
        var data = $(this).parent().next('.form-container').find('form').serializeArray();
        $.ajax({
            url: vote_route,
            data: data,
            success: function (response) {
                let item = '#item-mark-' + data[0]['value'];
                $(item).find('.rating-total').html(response);
            },
            error: function () {
                let message = '<span> ???? ?????? ???????????????????? </span>';
                $('#alert').html(message);
                setTimeout(function () {
                    $('#alert span').remove();
                }, 5000);
            },
            dataType: 'html'
        })
    });

    $('.comment-button').click(function () {
        event.preventDefault();
        let data = $(this).closest('form').serializeArray();
        let obj = $(this);
        let comment_button = obj.parents('.comments').prev('.admin-container').children('.admin-button-comments');
        let number = comment_button.children('.comments-count').html();

        $.ajax({
            url: comment_route,
            data: data,
            success: function (response) {
                obj.prev('textarea').val('');
                obj.parents('.new-comment').next().prepend(newComment(user, data[1]['value']));
                obj.parents('.new-comment').css('display', 'none');
                // comment_button.click();
                number++;
                comment_button.children('.comments-count').html(number);
            },
            error: function (response) {
                let message = '<span> ?????????????????? ???? ???????????? ???????? ???????????? </span>';
                $('#alert').html(message);
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
                console.log(response)
                let message = '<span> ???????????? ???????????????? </span>';
                $('#success').html(message);
                setTimeout(function () {
                    $('#success span').remove();
                }, 5000);
            },
            error: function () {
                let message = '<span> ???????????????????? ???? ?????????? ???????? ?????????????????????????? </span>';
                $('#alert').html(message);
                setTimeout(function () {
                    $('#alert span').remove();
                }, 5000);
            },
            dataType: 'html'
        })
    });

    $('.dropdown-toggle').click(function () {
        $(this).next().slideToggle(0);
    });

    $('.order-success').click(function () {
        if (confirm('?????????????????')) {
            let elem = this;
            let url = window.location + "success/?id=" + this.getAttribute('name');
            console.log(url);
            $.ajax({
                url: url,
                success: function (res) {
                    console.log(res);
                    $('body').find(res).addClass('inactive');
                    inactive();
                },
                error: function (res) {
                },
                dataType: 'html'
            });
        }
    });

    $('.order-denied').click(function () {
        if (confirm('?????????????????????')) {
            let elem = this;
            let url = window.location + "denied/?id=" + this.getAttribute('name');
            $.ajax({
                url: url,
                success: function (res) {
                    $('body').find(res).addClass('inactive');
                    inactive();
                },
                error: function (res) {
                },
                dataType: 'html'
            });
        }
    });

    function inactive() {
        $('.inactive *').click(function (event) {
            event.preventDefault();
        }).attr('disabled', true);
        $('.inactive button').off();
    }
});
