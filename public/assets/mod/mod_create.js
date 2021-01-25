$(document).ready(function(){

    $('#form').submit(function(e){
        e.preventDefault();
        $('button[type="submit"]').addClass('disabled');
        $('button[type="submit"]').html('Loading...');
    })

})