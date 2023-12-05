$(document).ready(function(){
    let selector = $('.banner-block');
    if(selector.length) {
        selector.owlCarousel({
            loop: true,
            items: 1,
            nav: false,
            dots: true
        });
    }

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

$('.register-btn').click(function (e) {
    e.preventDefault()
    let name = $('#name').val()
    let organization = $('#organization').val()
    let email = $('#email').val()
    let phone = $('#phone').val()
    let pass = $('#password').val()
    let repeatPass =$('#repeat-password').val()
    let flag = 0;

    $('.input-block').each(function () {
        $(this).removeClass('error-input')
    })

    let nameArr = name.split(' ')
    if(nameArr.length < 2) {
        $('#name').parent().addClass('error-input')
        flag++
    }

    if(organization.length < 4) {
        $('#organization').parent().addClass('error-input')
        flag++
    }

    let regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(!regex.test(email)){
        $('#email').parent().addClass('error-input')
        flag++
    }

    let clearPhone = phone.replace(/[^0-9]/g, '');
    if(clearPhone.length < 8) {
        $('#phone').parent().addClass('error-input')
        flag++
    }

    if(pass.length < 5) {
        $('#password').parent().addClass('error-input')
        flag++
    }

    if(pass !== repeatPass) {
        $('#repeat-password').parent().addClass('error-input')
        flag++
    }

    if(flag == 0) {
        $('#register-form').submit()
    }
})

$('.reset-pass-btn').click(function (e) {
    e.preventDefault()
    $('.input-block').each(function () {
        $(this).removeClass('error-input')
    })

    let pass = $('#new-password').val()
    let repeatPass = $('#repeat-password').val()
    let flag = 0;

    if(pass.length < 5) {
        $('#new-password').parent().addClass('error-input')
        flag++
    }

    if(pass !== repeatPass) {
        $('#repeat-password').parent().addClass('error-input')
        flag++
    }

    if(flag === 0) {
        $('#change-pass-form').submit()
    }
})