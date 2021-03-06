<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="utf-8">

	<title>IT Utils</title>


	<link rel="stylesheet" href="{{ elixir('css/all.css') }}">

	<link rel="shortcut icon" href="/favicon.ico" >

	<meta name="csrf-token" content="{{ csrf_token() }}">

	<!-- Scripts -->
	<script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
	</script>


	@yield('head')

</head>


<body>


{{--@include('partials.message')--}}


@yield('content')



<script src="{{ elixir('js/all.js') }}"></script>
<script src="{{ elixir('js/app.js') }}"></script>
@yield('js')


</body>
</html>














