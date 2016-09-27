<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="utf-8">

	<title>IT Utils</title>

	@include('includes.jQueryBootstrap')

	@include('includes.datatablesCSS')
	@include('includes.churchillStuffCSS')


	@yield('head')

</head>


<body>



{{--@include('partials.message')--}}


@yield('content')


@include('includes.churchillJS')
@include('includes.datatablesJS')

@yield('js')


</body>
</html>














