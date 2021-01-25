<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$title;?></title>

    <link rel="short icon" href="favicon.ico" type="image/icon">
    <link rel="stylesheet" href="<?=base_url();?>assets/css/bootstrap.min.css">
</head>
<body>
    <div class="col-md-4 col-sm-6 col-10 mx-auto my-5">
        <div class="card mb-3 shadow-sm">
            <div class="card-body text-center">
                <h2>Terminal</h2>
                <form action="<?=base_url();?>terminal/execute" method="post" id="form">
                    <div class="form-group">
                        <input type="text" name="code" placeholder="Input your code..." class="form-control" autocomplete="off" autofocus>
                        <div class="alert alert-warning my-3" id="errCode"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="<?=base_url();?>assets/js/jquery.min.js"></script>
    <script src="<?=base_url();?>assets/js/bootstrap.bundle.js"></script>
    <script>
        $(document).ready(function(){
            $('#errCode').hide();
            $('#form').submit(function(e){
                $('#errCode').show('fade');
                $('#errCode').html('Processing...');
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: new FormData(this),
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function(data){
                        $('#errCode').html(data.message);

                        setTimeout(function(){
                            $('#errCode').hide('fade');
                        }, 3000);
                    }
                })
            })
        })
    </script>
</body>
</html>