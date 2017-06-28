<h2>Toodrinks</h2>
<h3>Notificaciones del Dia</h3>

<?php foreach ($notificaciones as $notificacion ): ?>
	{{ $notificacion->titulo }} 
	<a href="http://localhost:8000/{{ $notificacion->url}}">Ver</a> <br>
<?php endforeach ?>

