
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="http://www.werollon.com/bootstrap/css/bootstrap.min.css" rel="stylesheet"  />
    

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
<meta name="csrf_token" content="{{ csrf_token() }}">

</head>
<body>


<!--login modal-->
<div id="loginModal" class="modal show" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> -->
                <h1 class="text-center">Login</h1>
            </div>
            <div class="modal-body">

                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {!! Form::Open(array("method"=>"post",'route'=>array('adminlogin'))) !!}



             <div>{!! Form::text('email','',array('class'=>'form-control input-lg','placeholder'=>'User Name','required'=>'required')) !!}</div>
<br/>




                <div class="form-group">

                    <input placeholder="Password" class="form-control input-lg" name="password" type="password" value="" required="required">
                </div>

                {!! Form::submit('Sign in', array('class'=>'send-btn btn btn-primary btn-lg btn-block')) !!}
                {!! Form::Close() !!}

            </div>

        </div>
    </div>
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="../../../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>


<script type="text/javascript">
    (function ( $ ) {


    }( jQuery ));
</script>


</body>
</html>