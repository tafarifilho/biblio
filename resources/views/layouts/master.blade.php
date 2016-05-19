<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>

	<meta name="description" content="Sistema de Gestão de Conteúdo e Empréstimos">

	<link rel="manifest" href="manifest.json">

	<!-- Fallback to homescreen for Chrome <39 on Android -->
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="application-name" content="Biblioteca">
	<link rel="icon" sizes="192x192" href="/images/chrome-touch-icon-192x192.png">

	<!-- Add to homescreen for Safari on iOS -->
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="apple-mobile-web-app-title" content="Biblioteca">
	<link rel="apple-touch-icon" href="/images/apple-touch-icon.png">

	<!-- Tile icon for Win8 (144x144 + tile color) -->
	<meta name="msapplication-TileImage" content="/images/ms-touch-icon-144x144-precomposed.png">
	<meta name="msapplication-TileColor" content="#3372DF">

	<meta name="theme-color" content="#3372DF">

	<title>Biblioteca</title>

	{!! Html::style('css/bootstrap.min.css', array('media' => 'screen,projection,print'), null) !!}
	{!! Html::style('css/biblioteca.css') !!}

	@yield('styles')
</head>
<body>

	@include('layouts.barranavegacao')

	<div class="container">

		@include('layouts.avisos')
		@include('layouts.erros')

		@yield('content')

	</div>

	<!--  Scripts-->
	{!! Html::script('js/vendor/jquery.min.js') !!}
	{!! Html::script('js/vendor/bootstrap.min.js') !!}
	@yield('scripts')

</body>
</html>
