<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<title>ScreenSaver</title>
	<!-- Icons -->
	<script src="https://unpkg.com/feather-icons"></script>

	<!-- CSS -->
	<link href="/css/app.css" rel="stylesheet" />
	<!-- Styles -->
	<style>
	</style>
</head>

<body>
	<div id="app">
		<app :images='@json($images)'></app>
	</div>


	<script src="/js/app.js"></script>
	<script>
		feather.replace();
	</script>
	<script>
		db.set('csrf', '{{ csrf_token() }}');
	</script>
</body>

</html>