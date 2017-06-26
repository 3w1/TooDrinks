<?php foreach ($notificaciones as $notificacion ): ?>
	{{ $notificacion->titulo }}
	{{ $notificacion->url}}
<?php endforeach ?>