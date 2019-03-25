$(document).ready(() => {
    $('.user-panel__settings').hide();

    $('.user-panel__trigger').click(() => {
        $('.user-panel__settings').slideToggle(250, () => {
            $('.fa-chevron-circle-down').toggleClass("fa-chevron-circle-up");
        });
    });

    $('.profile__gallery-slider').slick({
        dots: true,
        infinite: true,
        speed: 300,
        centerPadding: '100px',
        slidesToShow: 1,
        centerMode: true,
        variableWidth: true
    });
})