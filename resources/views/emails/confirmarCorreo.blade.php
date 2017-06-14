<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Prueba Mail</title>
</head>
<body>
	<h3><strong>¡¡Gracias por registrarte en TooDrinks!!</strong></h3>
	
	<span>Para finalizar tu registro y empezar a disfrutar de nuestro sitio web, confirma tu correo aquí <a href="http://localhost:8000/confirmar-correo/{{$data['id_usuario']}}${{$data['codigo_confirmacion']}}">CONFIRMAR CORREO</a></span>
</body>
</html>