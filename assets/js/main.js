$(document).ready(function(){
    $('.banner-block').owlCarousel({
        loop: true,
        items: 1,
        nav: false,
        dots: true
    });
});

$('.menu-btn').click(function(){
    $('.header-menu').slideToggle();
})

$('.more-options').click(function(){
    $(this).parent().find('.option-list').slideToggle()
})

$('.display-pass').click(function(){
    let selector = $(this).parent().find('input')
    let type = selector.attr('type');
    if(type == 'password') {
        selector.attr('type','text')
    } else {
        selector.attr('type','password')
    }
})