<div class="container">
	<div class="row">
		<div class="alert alert-warning" role="alert">
			Eliminar este conepto ? 
		<?php $a=$concepto[0] ; 
		echo $a->nombre ." ". $a->monto 	?>
		</div>
		<div>
		<a href="/damaso/conceptos/borrar/<?php echo $a->id; ?>" type="button" class="btn btn-primary">Borrar</a>
		<a href="/damaso/conceptos/listado" type="button"  class="btn btn-success">Volver</a>
		</div>
	</div>	
</div>	
