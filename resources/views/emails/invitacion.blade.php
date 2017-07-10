<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Invitación a TooDrinks</title>
</head>
<body>
	<h3><strong>¡¡Bienvenido a TooDrinks!!</strong></h3>
	
	<span>
		Hola {{ $productor['nombre'] }}, te queremos invitar a que pruebes nuestro Sitio Web, donde podrás contactar con otros productores, importadores, distribuidores y clientes finales a nivel mundial. Podrás gestionar tus marcas y realizar ofertas de tus productos, así como recibir demandas de los producto que ofreces. ¿Qué estas esperando?

		<a href="http://localhost:8000/registrarse/{{$productor['tipo']}}${{$productor['id']}}${{str_random(25)}}">Registrate aquí</a>
	</span>
</body>
</html>