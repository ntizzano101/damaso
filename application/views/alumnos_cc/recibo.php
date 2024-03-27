<html>
<head>
<style  type="text/css">
body{
	font-family:verdana;
	font-size:small;
}
.tr1{

border-bottom:1px solid #000;
}
.texto{
font-size:small;
}
</style>
</head>
<body>
<center>
<table border=1>
<tr>
	<td width="45%" style="text-align:left;margin-left:100px">
		 Instituto Damaso Valdes <br>
		 Rivadavia N&deg 38<br>
		 San Nicolas de Los Arroyos<br>
		Buenos Aires CP 2900	<br>
		0336 - 4428102 <br>
		IVA EXENTO				
	</td>
	<td width="10%" style="text-align:center" valign="top"><span style="font-size:60px">C</span><br>
		<span style="font-size:20px">COD.0<?=$recibo->tipo_comp?>
		
		</span>
	</td>
		
	<td width="45%" align="right" valign="top">
	    FECHA :<?php echo $recibo->fecha ?> <br>
		<?php
		if($recibo->tipo_comp=='11')
		echo "FACTURA ";
		elseif($recibo->tipo_comp=='13')
		echo "NOTA DE CREDITO"
		?>
		 : <?php printf("C 0003-%1$08d",$recibo->comprobante) ?> <br>
		CUIT :33-70879612-9 <br>
		IIBB : 33-70879612-9
		
		
	
	</td>
	
</tr>
<tr>
	<td colspan="3">
		 Alumno : <?php echo $recibo->nombre ."," . $recibo->apellido ?> <br> 
		 Direcci&oacute;n: <?php echo $recibo->direccion ?> <br>
		 Curso: <?php echo $recibo->curso ?> <br>
		 DNI: <?php echo $recibo->dni ?><br>
		 <?php if(strlen($otros->nro_doc) > 10) { ?>
			CUIT : <?php echo $otros->nro_doc ?>  -  EMPRESA : <?php echo $otros->rz ?>    - Cond.Iva: <?php echo $otros->descripcion ?>  
		 <?php } else {?>	 
		 CONSUMIDOR FINAL	
		 <?php } ?>
	</td>
</tr>
<tr>
	<td colspan="4">
	<table width="100%" class="texto">
		<td  style="border:1px solid #000" >Periodo</td>
		<td  style="border:1px solid #000">Descripcion</td>
		<td  style="border:1px solid #000">Original</td>
			<td  style="border:1px solid #000">Pendiente(A)</td>
			<td  style="border:1px solid #000">Interes(B)</td>
			<td  style="border:1px solid #000">Desuento(C)</td>
			<td  style="border:1px solid #000">Debe(A+B-C)</td>
			<td  style="border:1px solid #000">Pago(E)</td>
			<td  style="border:1px solid #000">Saldo(A+B-C-E)</td>
		<td  style="border:1px solid #000" align="right">Importe(E)</td>
		<?php 
		if($recibo->NC>0){
		$it=new stdclass;
		$it->original=0;
		$it->periodo="";
		$it->pendiente=0;
		$it->interes=0;
		$it->descuento=0;
		$it->debe=0;
		$it->saldo=0;
		$it->descripcion=sprintf("ANULACION RECIBO C 0003-%1$08d",$recibo->NC);
		$it->importe=$recibo->importe;
		$items=array($it);
		}
		foreach ($items as $it){ ?>
		<tr>
			<td  ><?php echo $it->periodo ?></td>
			<td ><?php echo $it->descripcion ?></td>
			<td align="right"><?php echo $it->original ?></td>
			<td align="right"><?php echo $it->pendiente ?></td>
			<td align="right"><?php echo $it->interes ?></td>
			<td align="right"><?php echo $it->descuento ?></td>
			<td align="right"><?php echo $it->debe ?></td>
			<td align="right"><?php echo $it->importe ?></td>
			<td align="right"><?php echo $it->saldo ?></td>
			<td align="right"><?php echo $it->importe ?></td>
		</tr>
	<?php } 	
	for($j=0;$j<30 - count($items);$j++){ ?>	
			<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			
			</tr>
		<?php
		}		
		?>
		<tr>
			<td width="80%" colspan="9" align="right">TOTAL</td>
			
			<td width="20%" align="right"><b><?php echo $recibo->importe ?></b></td>
		</tr>
		<tr>
			<td width="100%" colspan="10" align="center">
				<table width="100%" align="center">
					<tr>
						<td>
							
							<?php
							//QR V1
							//ver 	Numérico 1 digito 	OBLIGATORIO – versión del formato de los datos del comprobante 	1
							$qr1["ver"]=1;
							//fecha 	full-date (RFC3339) 	OBLIGATORIO – Fecha de emisión del comprobante 	"2020-10-13"
							$qr1["fecha"]=$otros->fecha;
							//cuit 	Numérico 11 dígitos 	OBLIGATORIO – Cuit del Emisor del comprobante 	30000000007
							$qr1["cuit"]=33708796129;
							//ptoVta 	Numérico hasta 5 digitos 	OBLIGATORIO – Punto de venta utilizado para emitir el comprobante 	10
							$qr1["ptoVta"]=3; //Sori Pero lo tengo HArdoce DAMASO;
							//tipoCmp 	Numérico hasta 3 dígitos 	OBLIGATORIO – tipo de comprobante (según Tablas del sistema ) 	1
							$qr1["tipoCmp"]=$otros->tipo_comp;
							//nroCmp 	Numérico hasta 8 dígitos 	OBLIGATORIO – Número del comprobante 	94
							$qr1["nroCmp"]=$otros->comprobante;
							//importe 	Decimal hasta 13 enteros y 2 decimales 	OBLIGATORIO – Importe Total del comprobante (en la moneda en la que fue emitido) 	12100
							$qr1["importe"]=$otros->importe;
							//moneda 	3 caracteres 	OBLIGATORIO – Moneda del comprobante (según Tablas del sistema ) 	"DOL"
							$qr1["moneda"]="PES";
							//ctz 	Decimal hasta 13 enteros y 6 decimales 	OBLIGATORIO – Cotización en pesos argentinos de la moneda utilizada (1 cuando la moneda sea pesos) 	65
							$qr1["ctz"]=1;
							//tipoDocRec 	Numérico hasta 2 dígitos 	DE CORRESPONDER – Código del Tipo de documento del receptor (según Tablas del sistema ) 	80
							$qr1["tipoDocRec"]=$otros->codigo_iva; // le erre mal es el tipo de documento CUIT DNI
							//nroDocRec 	Numérico hasta 20 dígitos 	DE CORRESPONDER – Número de documento del receptor correspondiente al tipo de documento indicado 	20000000001
							if($otros->nro_doc > 0){
								$qr1["nroDocRec"]=$otros->nro_doc;
								$qr1["tipoDocRec"]=80;
								}
							else{
								$qr1["nroDocRec"]=$recibo->dni;	
								$qr1["tipoDocRec"]=96;
							}
							//tipoCodAut 	string 	OBLIGATORIO – “A” para comprobante autorizado por CAEA, “E” para comprobante autorizado por CAE 	"E"
							$qr1["tipoCodAut"]="E";	
							//codAut 	Numérico 14 dígitos 	OBLIGATORIO – Código de autorización otorgado por AFIP para el comprobante 	70417054367476
							$qr1["codAut"]=$otros->cae;
							$valor=json_encode($qr1);
							$valor="https://www.afip.gob.ar/fe/qr/?p=" . base64_encode($valor);
							?>
							<img src="https://chart.googleapis.com/chart?cht=qr&chs=250x250&chl=<?=$valor?>">
						</td>
						<td>
							<img src="/damaso/img/afip.png">
						</td>
						<td>
							<table width="100%" align="center">
							<tr>
								<td>
								<?php 
								/* <img src="/damaso/img/<?php echo $recibo->barraimagen ?>">
								*/
								?>
								</td>
							</tr>
							<tr>
								<td>
									CAE Nro: <?php echo $recibo->cae ?>
								</td>
							</tr>
							<tr>
								<td>
									Fecha.Vto.Cae: <?php echo $recibo->vto ?>
								</td>
							</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>		
	</table>	
	</td>
</tr>

</table>
</center>	
</body>
</html>
