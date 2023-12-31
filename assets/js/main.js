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

$('#update-profile').click(function (e) {
    e.preventDefault()
    $('.input-block').each(function () {
        $(this).removeClass('error-input')
    })

    let nameSelector = $('#user-name')
    let emailSelector = $('#user-email')
    let innSelector = $('#inn')
    let orgSelector = $('#organization-name')
    let addrSelector = $('#organization-addres')
    let phoneSelector = $('#user-phone')
    let flag = 0;

    let name = nameSelector.val()
    let nameArr = name.split(' ')

    if(nameArr.length < 2) {
        nameSelector.parent().addClass('error-input')
        flag++
    }

    let organization = orgSelector.val()
    if(organization.length < 4) {
        orgSelector.parent().addClass('error-input')
        flag++
    }

    let email = emailSelector.val()
    let regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(!regex.test(email)){
        emailSelector.parent().addClass('error-input')
        flag++
    }

    let phone = phoneSelector.val()
    let clearPhone = phone.replace(/[^0-9]/g, '');
    if(clearPhone.length < 8) {
        phoneSelector.parent().addClass('error-input')
        flag++
    }

    let inn = innSelector.val()
    if(inn.length < 9) {
        innSelector.parent().addClass('error-input')
        flag++
    }

    let addr = addrSelector.val()
    if(addr.length < 10) {
        addrSelector.parent().addClass('error-input')
        flag++
    }


    if(flag === 0) {
        $('#profile-form').submit()
    }
})

$('#update-password').click(function (e){
    e.preventDefault()
    $('.input-block').each(function () {
        $(this).removeClass('error-input')
    })

    let currPassSelector = $('#curr-password')
    let newPassSelector = $('#new-password')
    let repeatPassSelector = $('#repeat-password')
    let flag = 0;

    let newPass = newPassSelector.val()
    let repeatPass = repeatPassSelector.val()

    if(newPass.length < 5) {
        $('#new-password').parent().addClass('error-input')
        flag++
    }

    if(newPass !== repeatPass) {
        repeatPassSelector.parent().addClass('error-input')
        flag++
    }

    let currPass = currPassSelector.val()

    if(flag === 0) {
        $.ajax({
            url: '/profile/change-password',
            method: 'post',
            dataType: 'json',
            data: {
                'password': currPass,
                'new-password': newPass
            },
            success: function(data){
                if(data.msg !== 'password was changed') {
                    currPassSelector.parent().addClass('error-input')
                } else {
                    window.location.replace("/profile");
                }
            }
        });
    }
})