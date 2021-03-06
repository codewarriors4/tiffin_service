<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">


    </head>
    <body>
        <div class="flex-center position-ref full-height">

        <h>Hello {{$tsname}},<h>
        <h> Your payment was successful, below is a summary of the payment details to TiffinService <h>
        <p> Subscribed to : {{$data["hmname"]}} <p>

        <p>Subscription start date: {{$data["subsc_start_date"]}}</p>
        <p>Subscription end date: {{$data["subsc_end_date"]}}</p>

        <p> Package name: {{$data["packageTitle"]}}</p>
        <p> Package cost : {{$data["paymentSubTotal"]}} CAD </p>
        <p> Tax : {{$data["tax"]}} CAD</p>
        <p> Total cost : {{$data["totalcost"]}} CAD </p>
        <p> Your transaction id for refernce is {{$data["transacId"]}}</p>
        <p> Thanks - TiffinService Team </p>

        </div>
    </body>
</html>
