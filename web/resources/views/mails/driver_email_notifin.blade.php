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

        <h>Hello {{$data["drname"]}},<h>
        <p>Transaction id :  {{$data["transacId"]}} </p>
        <p>Your delivery for the following subscriber is confirmed. Below is the delivery address and subscription details</p> Delivery address: </p>
        <p> Street: {{$data["street"]}} </p>
        <p> City: {{$data["city"]}} </p>
        <p> Province: {{$data["province"]}} </p>
        <p> ZipCode: {{$data["ZipCode"]}} </p>
        <p> Country : {{$data["Country"]}} </p>
        </br>
        </br>

        </p> Delivery for subscription period: </p>

        <p>Subscription start date: {{$data["subsc_start_date"]}}</p>
        <p>Subscription end date: {{$data["subsc_end_date"]}}</p>

        
        <p> Thanks - TiffinService Team </p>

        </div>
    </body>
</html>
