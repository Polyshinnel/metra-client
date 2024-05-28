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


$(document).ready(function() {
    let result = $('.search-block__result');

    if(result.length > 0) {
        let searchInput = $('#product-search');
        $(searchInput).on('keyup', function () {
            let query = $(this).val()
            if((query !== '') && (query.length > 3)) {
                $.ajax({
                    type: "POST",
                    url: "/search",
                    data: {'query': query},
                    success: function (msg) {
                        if (msg.products.length > 0) {
                            result.html('')
                            let products = msg.products
                            for(let i=0; i < products.length; i++) {
                                let elem = '<li class="bg-white hover:bg-blue-50 transition-all duration-300">\n' +
                                    '                        <a href="/catalog/product/'+products[i].id+'">\n' +
                                    '                            <div class="search-block__result-item flex items-start py-2 px-3 border-b border-gray-400">\n' +
                                    '                                <div class="search-block__result-item-img w-11 h-11 flex items-center justify-center">\n' +
                                    '                                    <img src="'+products[i].img+'" alt="" class="w-full h-full object-cover">\n' +
                                    '                                </div>\n' +
                                    '\n' +
                                    '                                <p class="ml-3 text-xs">'+products[i].name+'</p>\n' +
                                    '                            </div>\n' +
                                    '                        </a>\n' +
                                    '                    </li>';
                                result.append(elem)
                            }
                            result.fadeIn();
                        } else {
                            result.html('')
                            result.fadeOut(200)
                        }
                    }
                })
            }

        });

        $(document).on('click', function(e){
            if (!$(e.target).closest('.search-block').length){
                result.html('');
                result.fadeOut(100);
            }
        });

        $(searchInput).keydown(function(e) {
            if(e.keyCode === 13) {
                let query = $(this).val()
                let url = '/search?query='+encodeURI(query)
                window.location.href = url;
            }
        });
    }


})


$('.mark-read').click(function () {
    let notificationId = $(this).attr('data-item')
    $.ajax({
        type: "POST",
        url: "/notification/update-status",
        data: {'notification_id': notificationId},
        success: function (msg) {
            if(msg.msg == 'success') {
                location.reload();
            }
        }
    })
})

$('.create-client').click(function () {
    let innSelector = $('#inn');
    let orgSelector = $('#company-name');
    let addrSelector = $('#company-addr');
    let nameSelector = $('#contact-name');
    let phoneSelector = $('#contact-phone');
    let attr = $(this).attr('data-role')

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

    if(attr === 'create') {
        $.ajax({
            type: "POST",
            url: "/clients/create",
            data: {
                'inn': inn,
                'name': organization,
                'address': addr,
                'contact_name': name,
                'phone': phone
            },
            success: function (msg) {
                if(msg.msg === 'client was created') {
                    location.reload();
                }
            }
        })
    }

    if(attr === 'update') {
        let clientId = $(this).attr('data-id');
        $.ajax({
            type: "POST",
            url: "/clients/update",
            data: {
                'client_id': clientId,
                'inn': inn,
                'name': organization,
                'address': addr,
                'contact_name': name,
                'phone': phone
            },
            success: function (msg) {
                if(msg.msg === 'client was updated') {
                    location.reload();
                }
            }
        })
    }
})


$('.edit-client-btn').click(function (){
    let id = $(this).attr('data-item')
    let selector = $('.create-client')
    selector.attr('data-id', id)
    selector.attr('data-role', 'update')

    let innSelector = $('#inn');
    let orgSelector = $('#company-name');
    let addrSelector = $('#company-addr');
    let nameSelector = $('#contact-name');
    let phoneSelector = $('#contact-phone');
    $('.create-client').html('Обновить данные')

    $.ajax({
        type: "POST",
        url: "/clients/get-by-id",
        data: {
            'client_id': id,
        },
        success: function (data) {
            innSelector.val(data.inn)
            orgSelector.val(data.name)
            addrSelector.val(data.address)
            nameSelector.val(data.contact_name)
            phoneSelector.val(data.phone)
        }
    })

    Fancybox.show([{ src: "#add-client-form", type: "inline" }]);
})

$('.delete-client-btn').click(function () {
    let id = $(this).attr('data-item')
    $.ajax({
        type: "POST",
        url: "/clients/delete",
        data: {
            'client_id': id,
        },
        success: function (data) {
            location.reload();
        }
    })

})


$(document).ready(function() {
    let result = $('.search-block__result');

    if(result.length > 0) {
        let searchInput = $('#tkp-search');
        $(searchInput).on('keyup', function () {
            let query = $(this).val()
            if((query !== '') && (query.length > 3)) {
                $.ajax({
                    type: "POST",
                    url: "/tkp/search",
                    data: {'query': query},
                    success: function (msg) {
                        if (msg.length > 0) {
                            result.html('')
                            for(let i=0; i < msg.length; i++) {
                                let elem = '<li class="bg-white hover:bg-blue-50 transition-all duration-300">\n' +
                                    '                        <a href="/tkp/tkp-create/'+msg[i].id+'">\n' +
                                    '                            <div class="search-block__result-item flex items-start py-2 px-3 border-b border-gray-400">\n' +
                                    '                                <div class="search-block__result-item-img w-11 h-11 flex items-center justify-center">\n' +
                                    '                                    <img src="'+msg[i].img+'" alt="" class="object-cover">\n' +
                                    '                                </div>\n' +
                                    '\n' +
                                    '                                <p class="ml-3 text-xs">'+msg[i].name+'</p>\n' +
                                    '                            </div>\n' +
                                    '                        </a>\n' +
                                    '                    </li>';
                                result.append(elem)
                            }
                            result.fadeIn();
                        } else {
                            result.html('')
                            result.fadeOut(200)
                        }
                    }
                })
            }

        });

        $(document).on('click', function(e){
            if (!$(e.target).closest('.search-block').length){
                result.html('');
                result.fadeOut(100);
            }
        });
    }


})

function getTkpParamsUrl() {
    let SearchParams = decodeURIComponent(window.location.search);
    let SearchParamsArr = SearchParams.split('&');
    let clearParamObj = {}
    for(let i = 0; i < SearchParamsArr.length; i++) {
        let param = SearchParamsArr[i]
        param = param.replace('?','');
        param = param.replace('[]','');
        param = param.split('=')

        if(clearParamObj[param[0]] !== undefined) {
            if(typeof(clearParamObj[param[0]]) != 'object') {
                clearParamObj[param[0]] = [clearParamObj[param[0]], param[1]]
            } else {
                let arr = clearParamObj[param[0]];
                arr.push(param[1])
                clearParamObj[param[0]] = arr
            }
        } else {
            clearParamObj[param[0]] = param[1];
        }
    }
    return clearParamObj
}


let url = $.param(getTkpParamsUrl())

$('.next-tkp-step').click(function () {
    let params = getTkpParamsUrl()
    let selector = $('.input-block-select select')
    let paramId = selector.attr('data-id')
    let paramVal = selector.val()

    if(params['category'] === undefined) {
        params['category'] = 1
    }

    if(params['tkp_params'] === undefined) {
        console.log('empty!')
        params['tkp_params'] = [paramId]
        params['tkp_values'] = [paramVal]
    } else {
        let paramArr = params['tkp_params'];
        let valArr = params['tkp_values'];

        if(typeof(params['tkp_params']) != 'object') {
            paramArr = [params['tkp_params'], paramId];
            valArr = [params['tkp_values'], paramVal];
        } else {
            paramArr.push(paramId);
            valArr.push(paramVal);
        }


        params['tkp_params'] = paramArr;
        params['tkp_values'] = valArr;
    }
    window.location.href = '/tkp?'+$.param(params)
})


$('.create-tkp-step').click(function () {
    let params = getTkpParamsUrl()
    let selector = $('.input-block-select select')
    let paramId = selector.attr('data-id')
    let paramVal = selector.val()


    let paramArr = params['tkp_params'];
    let valArr = params['tkp_values'];

    
    if(typeof(params['tkp_params']) != 'object') {
        paramArr = [params['tkp_params'], paramId];
        valArr = [params['tkp_values'], paramVal];
    } else {
        paramArr.push(paramId);
        valArr.push(paramVal);
    }


    params['tkp_params'] = paramArr;
    params['tkp_values'] = valArr;
    window.location.href = '/tkp/results?'+$.param(params)
})

$('.create_tkp').click(function () {
    let tkpId = $(this).attr('data-item')
    let customerId = $('.user-clients').val()
    let installationPlace = $('#installation_place').val()
    let expiredDate = $('#expired_date').val()

    $.ajax({
        type: "POST",
        url: "/tkp/generate",
        data: {
            'tkp_id': tkpId,
            'customer_id': customerId,
            'installation_place': installationPlace,
            'expired_date': expiredDate,
        },
        success: function (data) {
            window.location.href = data.output;
        }
    })
})