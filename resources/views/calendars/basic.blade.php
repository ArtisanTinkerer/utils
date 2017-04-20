<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Churchill Calendar</title>

        <script>
            // rename myToken as you like
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
            ]); ?>
        </script>

        <link rel="stylesheet" href="{{ elixir('css/all.css') }}">

    </head>
    <body>


    <div id='app'>
        <ch-calendar entrypoint={{$entryPoint}}>


        </ch-calendar>
    </div>


    <script src="{{ elixir('js/all.js') }}"></script>
    <script src="{{ elixir('js/app.js') }}"></script>








    </body>
</html>
