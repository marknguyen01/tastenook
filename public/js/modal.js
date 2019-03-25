$(document).ready(() => {
    $('.menu-modal').mousedown(e => {
        let clicked = $(e.target);

        if(clicked.is('.menu-modal__content') || clicked.parents().is('.menu-modal__content')) {
            return;
        } else {
            $('.menu-modal').removeClass("menu-modal--show");
            $('.menu-modal__content').removeClass("menu-modal__content--show");
        }
    });

    $('.menu-modal__trigger').click(() => {
        $('.menu-modal').addClass("menu-modal--show");
        $('.menu-modal__content').addClass("menu-modal__content--show");
    });

    $('.menu-modal__close').click(() => {
        $('.menu-modal').removeClass("menu-modal--show");
        $('.menu-modal__content').removeClass("menu-modal__content--show");
    });

    $('.default-modal').mousedown(e => {
        let clicked = $(e.target);

        if(clicked.is('.default-modal__content') || clicked.parents().is('.default-modal__content')) {
            return;
        } else {
            if(clicked.is('.default-modal--contact')) {
                $('.default-modal--contact').removeClass("default-modal--show");
                $('.default-modal__content--contact').removeClass("default-modal__content--show");
            } else if(clicked.is('.default-modal--review')) {
                $('.default-modal--review').removeClass("default-modal--show");
                $('.default-modal__content--review').removeClass("default-modal__content--show");
            } else if(clicked.is('.default-modal--register')) {
                $('.default-modal--register').removeClass("default-modal--show");
                $('.default-modal__content--register').removeClass("default-modal__content--show");
            } else {
                return;
            }   
        }
    });

    $('.default-modal__trigger').click(e => {
        let clicked = $(e.target);

        if(clicked.is('.default-modal__trigger--contact')) {
            $('.default-modal--contact').addClass("default-modal--show");
            $('.default-modal__content--contact').addClass("default-modal__content--show");
        } else if(clicked.is('.default-modal__trigger--review')) {
            $('.default-modal--review').addClass("default-modal--show");
            $('.default-modal__content--review').addClass("default-modal__content--show");
        } else if(clicked.is('.default-modal__trigger--register')) {
            $('.default-modal--register').addClass("default-modal--show");
            $('.default-modal__content--register').addClass("default-modal__content--show");
        } else {
            return;
        }   
    });

    $('.default-modal__close').click(() => {
        if(clicked.is('.default-modal--contact')) {
            $('.default-modal--contact').removeClass("default-modal--show");
            $('.default-modal__content--contact').removeClass("default-modal__content--show");
        } else if(clicked.is('.default-modal--review')) {
            $('.default-modal--review').removeClass("default-modal--show");
            $('.default-modal__content--review').removeClass("default-modal__content--show");
        } else if(clicked.is('.default-modal--register')) {
            $('.default-modal--register').removeClass("default-modal--show");
            $('.default-modal__content--register').removeClass("default-modal__content--show");
        } else {
            return;
        } 
    });

    $('.default-form__star-rating input:radio').attr('checked', false);

    $('.default-form__star-rating input').click(e => {
        $('.default-form__star-rating span').removeClass("default-form__star-rating--checked");
        $(e.target).parent().addClass("default-form__star-rating--checked");
        $('#review-submission').prop('disabled', false)
            .removeClass('bubble-button--inactive')
            .addClass('bubble-button--med');
    });
})