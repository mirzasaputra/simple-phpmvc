$(document).ready(function(){

    $('.logout').click(function(){
        swal.fire({
            title: 'Logout?',
            icon: 'question',
            text: 'Anda ingin keluar?',
            showConfirmButton: true,
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
        }).then((result) => {
            if(result.isConfirmed){
                window.location.assign('index.html');
            }
        })
    })

})