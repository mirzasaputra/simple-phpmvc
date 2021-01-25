if($(window).scrollTop() > 60){
    $('.navbar').addClass('navbar-fixed');
} else {
    $('.navbar').removeClass('navbar-fixed');
}

if($(window).scrollTop() < $('#about').offset().top){
    $('.home').addClass('active');
    $('.about').removeClass('active');
    $('.prosedur').removeClass('active');
    $('.contact').removeClass('active');
}

if($(window).scrollTop() > $('#about').offset().top - 250){
    $('.home').removeClass('active');
    $('.about').addClass('active');
    $('.prosedur').removeClass('active');
    $('.contact').removeClass('active');
}

if($(window).scrollTop() > $('#prosedur').offset().top - 250){
    $('.home').removeClass('active');
    $('.about').removeClass('active');
    $('.prosedur').addClass('active');
    $('.contact').removeClass('active');
}

if($(window).scrollTop() > $('#contact').offset().top - 250){
    $('.home').removeClass('active');
    $('.about').removeClass('active');
    $('.prosedur').removeClass('active');
    $('.contact').addClass('active');
}

$(window).scroll(function(){
    if($(window).scrollTop() > 60){
        $('.navbar').addClass('navbar-fixed');
    } else {
        $('.navbar').removeClass('navbar-fixed');
    }

    if($(window).scrollTop() < $('#about').offset().top){
        $('.home').addClass('active');
        $('.about').removeClass('active');
        $('.prosedur').removeClass('active');
        $('.contact').removeClass('active');
    }

    if($(window).scrollTop() > $('#about').offset().top - 250){
        $('.home').removeClass('active');
        $('.about').addClass('active');
        $('.prosedur').removeClass('active');
        $('.contact').removeClass('active');
    }

    if($(window).scrollTop() > $('#prosedur').offset().top - 250){
        $('.home').removeClass('active');
        $('.about').removeClass('active');
        $('.prosedur').addClass('active');
        $('.contact').removeClass('active');
    }

    if($(window).scrollTop() > $('#contact').offset().top - 250){
        $('.home').removeClass('active');
        $('.about').removeClass('active');
        $('.prosedur').removeClass('active');
        $('.contact').addClass('active');
    }
})

$('.home').click(function(e){
    e.preventDefault()
    $('.home').addClass('active');
    $('.about').removeClass('active');
    $('.prosedur').removeClass('active');
    $('.contact').removeClass('active');
    $('html, body').animate({
        scrollTop: $('#home').offset().top
    }, 500)
})

$('.about').click(function(e){
    e.preventDefault()
    $('.home').removeClass('active');
    $('.about').addClass('active');
    $('.prosedur').removeClass('active');
    $('.contact').removeClass('active');
    $('html, body').animate({
        scrollTop: $('#about').offset().top - 150
    }, 500)
})

$('.prosedur').click(function(e){
    e.preventDefault()
    $('.home').removeClass('active');
    $('.about').removeClass('active');
    $('.prosedur').addClass('active');
    $('.contact').removeClass('active');
    $('html, body').animate({
        scrollTop: $('#prosedur').offset().top - 150
    }, 500)
})

$('.contact').click(function(e){
    e.preventDefault()
    $('.home').removeClass('active');
    $('.about').removeClass('active');
    $('.prosedur').removeClass('active');
    $('.contact').addClass('active');
    $('html, body').animate({
        scrollTop: $('#contact').offset().top - 150
    }, 500)
})

$('input[name="username"]').keydown(function(){
    $('#userErr').addClass('d-none');
    $('input[name="username"]').removeClass('is-invalid');
})

$('input[name="password"]').keydown(function(){
    $('#passErr').addClass('d-none');
    $('input[name="password"]').removeClass('is-invalid');
})

$('#login').submit(function(e){
    e.preventDefault();
    //set display error
    $('#userErr').addClass('d-none');
    $('input[name="username"]').removeClass('is-invalid');
    $('#passErr').addClass('d-none');
    $('input[name="password"]').removeClass('is-invalid');

    $('button[type="submit"]').addClass('disabled');
    $('button[type="submit"]').html('Loading...');
    $.ajax({
        url: $(this).attr('action'),
        method: $(this).attr('method'),
        data: new FormData(this),
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function(data){
            $('button[type="submit"]').removeClass('disabled');
            $('button[type="submit"]').html('Login');
            if(data.status == 200){
                swal.fire({
                    title: 'Success',
                    icon: 'success',
                    text: data.pesan
                }).then(function(){
                    // window.location.assign(base_url + 'HomeController/home');
                });
            } else {
                if(data.username){
                    $('#userErr').removeClass('d-none');
                    $('#userErr').html(data.username);
                    $('input[name="username"]').addClass('is-invalid');
                }
                if(data.password){
                    $('#passErr').removeClass('d-none');
                    $('#passErr').html(data.password);
                    $('input[name="password"]').addClass('is-invalid');
                }
            }
        },
        error: function(xhr, ajaxOptions, thrownError){
            $('button[type="submit"]').removeClass('disabled');
            $('button[type="submit"]').html('Login');
            swal.fire({
                title: xhr.status,
                icon: 'warning',
                text: thrownError
            });
        }
    })
})