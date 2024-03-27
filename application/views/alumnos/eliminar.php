<div class="container">
	<div class="row">
		<div class="alert alert-warning" role="alert">
			Eliminar este alumno ? 
		<?php $a=$alumnos[0] ; 
		echo $a->nombre ." ". $a->apellido 	?>
		</div>
		<div>
		<a href="/damaso/alumnos/borrar/<?php echo $a->id; ?>" type="button" class="btn btn-primary">Borrar</a>
		<a href="/damaso/alumnos/listado" type="button"  class="btn btn-success">Volver</a>
		</div>
	</div>	
</div>	
