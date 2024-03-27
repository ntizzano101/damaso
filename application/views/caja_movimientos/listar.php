 <div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
			  <div class="panel-heading">
			  	<?php 
			  	 if($banco) 
			  	 	echo "Movimiento BANCO";
			  	 else
					echo "Movimiento de Caja";
				?>
			  </div>
			  <div class="panel-body">
				<form class="navbar-form navbar-left" role="search" method="POST" action="<?php echo base_url(); ?>movimientos_caja/<?php 
			  	 if($banco) 
			  	 	echo "banco";
			  	 else
					echo "listar";
				?>/">
				Desde <input type="text" class="form-control" name="desde" value="<?php printf('%s', $desde) ?>">
				Hasta <input type="text" class="form-control" name="hasta" value="<?php printf('%s',$hasta) ?>">
				<button type="submit" class="btn btn-primary">Filtrar</button>								
				</form>	
			  </div>
				<table class="table">
				  <thead>
					<tr>
					  <th>Fecha</th>
					  <th>Descripcion</th>
					  <th>Concepto</th>
					  <th>Medio Pago</th>
					  <th>Accion</th>
					  <th align="right">Debe</th>
					   <th align="right">Haber</th>
					  <th align="right">Saldo</th>
					</tr>
				  </thead>
				  <tbody>
					<?php 
					$aux="";
					$total=0;
					
					foreach($items as $c){ 
						if(
							($banco and 
								in_array($c->tipo2,array('BANCO','Deposito','Transferencia','Debito','Credito'))) 
							or (!$banco and in_array($c->tipo2,array('CAJA','Efectivo','Cheque'))))
						{
							$borrar=false;
							?>
							<tr>
							<td scope="row"><?=$c->fechaM?></td>
							<td>
							<?php 
							if($c->concepto=='Cobro Cuota'){
								if($c->tipo=="H"){
									echo " NC ";
								}
								printf("C 0003-%1$08d",$c->descripcion);
								}
							else{
								echo $c->descripcion;
								$borrar=true;
								}
							?>
							</td>
							<td><?=$c->concepto;?></td>
							<td><?=$c->tipo2;?></td>
							<td>
							<?php
							if($borrar){
									?>
									<a class="text-danger"  href="<?php echo base_url(); ?>movimientos_caja/borrar/<?=$c->id?>" 
							onClick="if(!(confirm('Borra El Item'))) return false;">Eliminar<a/> 
									
									
								<?php
							}
							else
								echo "&nbsp;";
							?>
							</td>
							<td align="right"><?php
							if($c->tipo=="D")
							{
							  printf("%0.2f",abs( $c->monto));
							  $total=$total-$c->monto; 	
							}
							else
							echo "0.00";
							?>
							</td>
							<td align="right"><?php
							if($c->tipo=="D")
							{
							echo "0.00";
							 
							}
							else
							{
							printf("%0.2f",abs( $c->monto));
							  $total=$total+$c->monto; 	
							}
							?>
							</td>
							<td align="right">
								<?php
								if($total>=0)
								printf("%0.2f",abs($total));
								else
								printf("(%0.2f)",abs($total)).")";
								?>
							</td>
							
					<?php		
					//print_r($c);die;
						} //endif
					} //endfor
									
							
											
				
					?>
				<tr><td colspan="7" align="right"><strong>
				<?php if($total>0) 
						echo "Saldo Acreedor";
					else
						echo "Saldo Deudor"

				?>
				</strong></td>
				<td align="right"><strong><?php printf("%0.2f",abs($total)) ;?></strong>
				</tr>				
				  </tbody>
				</table>
			</div>
		</div>
	</div>
</div>