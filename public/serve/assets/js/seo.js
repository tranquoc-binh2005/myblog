seoPreview = () => {
    $('input[name=meta_title]').on('keyup', function () {
        let input = $(this)
        let value = input.val()
        $('.meta_title').html(value)
    })

    $('input[name=meta_keyword]').on('keyup', function () {
        let input = $(this)
        let value = input.val()
        $('.meta_keyword').html(value)
    })

    // $('input[name=price]').on('keyup', function () {
    //     let value = this.value.replace(/[^0-9]/g, '');
    //     value = Number(value).toLocaleString('vi-VN');
    //     this.value = value;
    //     $('.price').html(value + ' ₫');
    // });

    $('input[name=canonical]').css({
        'padding-left': parseInt($('.baseUrl').outerWidth()) - 4
    })

    $('input[name=canonical]').on('keyup', function() {
        let input = $(this)
        let value = input.val()
        $('.canonical').html(BASE_URL + value + SUFFIX)
    })

    $('textarea[name=meta_description]').on('keyup', function() {
        let input = $(this)
        let value = input.val()
        $('.meta_description').html(value)
    })
}


$(document).ready(function () {
    seoPreview()
})