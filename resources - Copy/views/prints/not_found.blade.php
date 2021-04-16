<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Realtime PCR | Test Reports</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link href="https://pcr.realtimepcr.pk/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/cmp-style.css')}}" rel="stylesheet" type="text/css">


    <!-- <link rel="stylesheet" href="https://pcr.realtimepcr.pk/assets/css/cmp-style.css"> -->


    <!-- <link rel="stylesheet" href="cmp-style.css"> -->
<style type="text/css">
.trh4{
    text-align: left;
    font-size: 22px; 
    font-weight:700;
}
</style>
</head>

<body>

<div class="container" style="padding: 20px;" id="errNoRecord">
        <div class="component">
            <img src="https://pcr.realtimepcr.pk/assets/images/errNoRecord.jpg" alt="Payment Error" class="errImg">
        </div>
    </div>

</body>

</html>