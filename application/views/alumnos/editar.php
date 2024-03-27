<script>
	$( document ).ready(function() {
		$("#curso").val("<?=@$alumno->id_curso?>");
	});
</script>
<div class="container">
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-primary">
			  <div class="panel-heading">Alumno</div>
			  <div class="panel-body">
			 <?php 
			 $this->load->helper('form');
			
			 echo form_open('alumnos/editar','id="myform"');
			 echo form_hidden('id', $alumno->id);
			 ?>
			 	
					<div class="form-group">
						<label for="cuit">Nombre</label>
					<?php echo form_error('nombre'); ?>	
					<?php	echo form_input('nombre',$alumno->nombre,'class="form-control"'); ?>
				
					</div>
					<div class="form-group">
						<label for="iibb">Apellido</label>
						<?php echo form_error('apellido'); ?>	
						<?php echo form_input('apellido', $alumno->apellido,'class="form-control"'); ?>
				
					</div>
					<div class="form-group">
						<label for="iibb">DNI</label>
						<?php echo form_error('dni'); ?>	
						<?php	echo form_input('dni', $alumno->dni,'class="form-control"'); ?>
		
					</div>
					<div class="form-group">
						<label for="curso">Curso</label>
						<?php echo form_error('curso'); ?>	
						<select id="curso" name="curso" class="form-control">
							<option value=""></option>
						<?php foreach($cursos as $curso){?>
							<option value="<?=$curso->id_curso?>"><?=$curso->curso?></option>
						<?php } ?>
						</select>
					</div>
					<div class="form-group">
						<label for="dni">Dirección</label>
							<?php echo form_error('direccion'); ?>	
						<?php	echo form_input('direccion', $alumno->direccion,'class="form-control"'); ?>
		
					</div>
					<div class="form-group">
						<label for="razon_social">Teléono</label>
						<?php echo form_error('telefono'); ?>	
						<?php	echo form_input('telefono', $alumno->telefono,'class="form-control"'); ?>
					
					</div>
					<div class="form-group">
						<label for="nombre_fantasia">Email</label>
							<?php echo form_error('email'); ?>	
						<?php	echo form_input('email', $alumno->email,'class="form-control"'); ?>
					
					</div>
					<div class="form-group">
						<label for="domicilio_real">Fecha Nacimiento</label>
							<?php echo form_error('fechanacimiento'); ?>	
					   <?php	echo form_input('fechanacimiento', $alumno->fechanacimiento,'class="form-control"'); ?>
					</div>
					<div class="form-group">
						
						<label for="provincia_real">Fecha Ingreso</label>
					 <?php echo form_error('fechaingreso'); ?>	
					  <?php	echo form_input('fechaingreso', $alumno->fechaingreso,'class="form-control"'); ?>
					</div>
					<div class="form-group">
						<label for="provincia_real">Otros</label>
						  <?php	echo form_input('otros',$alumno->otros,'class="form-control"'); ?>
					</div>
					<div class="form-group">
						<label for="provincia_real">CUIT EMPRESA(sin guiones)</label>
						 <?php echo form_error('cuit'); ?>	
						  <?php	echo form_input('cuit',$alumno->cuit,'class="form-control"'); ?>
					</div>
					<div class="form-group">
						<label for="provincia_real">Razon Social</label>
						 <?php echo form_error('razonsocial'); ?>	
						  <?php	echo form_input('razonsocial',$alumno->razonsocial,'class="form-control"'); ?>
					</div>
					<div class="form-group">
						<label for="curso">Condicion Iva</label>
						<?php echo form_error('codiva');?>
						<select id="condiva" name="codiva" class="form-control">
						<?php foreach($ivas as $iva){?>
							<option value="<?=$iva["id"]?>"
							<?php
							 if($alumno->codiva==$iva["id"])
								 echo ' " selected " ';
							 ?>
							 >
							<?=$iva["descripcion"]?></option>
							
						<?php } ?>
						</select>
					</div>
					<div class="form-group">
						<label for="cbu">CBU</label>
						 <?php echo form_error('cbu'); ?>	
						  <?php	echo form_input('cbu',$alumno->cbu,'class="form-control"'); ?>
					</div>
					<input type="submit" class="form-control btn-primary" value="Agregar"/>
				</form>
			  </div>
			</div>
		</div>
	</div>
</div>
