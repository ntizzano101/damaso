<div class="container">
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-primary">
			  <div class="panel-heading">Debitos Automaticos BBVA</div>
			  <div class="panel-body">
			<?php if($error!="") { ?>	
			  <div class="alert alert-danger" role="alert" id="alert">
                    <span id="txt_alert"><?=$error;?></span>
			  </div>  
			<?php } ?> 
			<form action="<?=base_url()?>debito_automatico/ver" method="POST">
					<div class="form-group">
						<label for="nombre">Fecha Creacion del Debito-HOY</label>
						<input type="date" name="fecha_archivo" value="<?=$fecha_archivo?>" class="form-control" readonly="readonly">
					</div>
					<div class="form-group">
						<label for="nombre">Fecha Proceso del Debito / Dia que Se Sube archivo a NET-CASH</label>
						<input type="date" name="fecha_proceso" value="<?=$fecha_proceso;?>" class="form-control">
					</div>
					<div class="form-group">
						<label for="nombre">Fecha Vencimiento / Dia que impacta debito en cuenta del cliente</label>
						<input type="date" name="fecha_vence" value="<?=$fecha_vence;?>" class="form-control">
					</div>					
						<?php # echo form_error('nombre'); ?>	
					<input type="submit" class="form-control btn-success" id="aceptar"  value="Agregar"/>
				</form>
			  </div>
			</div>
		</div>
	</div>
</div>
