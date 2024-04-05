<div class="container">
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-primary">
			  <div class="panel-heading">Listado de debitos</div>
			  <div class="panel-body">
                    <select class="form-control" id="fechas">
                        <option value="">Seleccione</option>
                        <?php foreach($fechas as $fe) {  ?>
                            <option value="<?=$fe->fecha?>"><?=$fe->fechaf?></option>
                        <?php } ?>
                    </select>
                    <a href="" class="btn success">Descargar</a>
                    <hr>
                    <table class="table table-hover">
                    <thead>
                        <tr>
                        <th scope="col">Unico</th>
                        <th scope="col">Alumno</th>
                        <th scope="col">cbu</th>
                        <th scope="col">total</th>
                        </tr>
                    </thead>
                    <tbody id="tabla">                        
                    </tbody>
                </table>


			  </div>
			</div>
		</div>
	</div>
</div>
<script>
    var CFG = {
        url: '<?php echo $this->config->item('base_url');?>',
        token: '<?php echo $this->security->get_csrf_hash();?>'
    };  
$(document).ready(function(){
        $("#fechas").change(function(){                
            $.post(CFG.url+"debito_automatico/debitos/", {fecha: $("#fechas").val()}, function(result){          
                $("#tabla").html(result);
            });  
	    });
});
</script>