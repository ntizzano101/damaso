<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Funciones {

        public function fecha_nacimiento($fecha)
        {
			$rta=True;
			//si es vacio o una fecha devuelve true
			if($fecha!=""){
				$rta=False;
				$a=explode("/",$fecha);
			if(count($a)==3){
					$rta=checkdate( $a[1],  $a[0],  $a[2]);
			}		
			}
	return $rta;
	}
        
         public function fecha_ingreso($fecha)
        {
			$rta=True;
	//si es vacio o una fecha devuelve true
		if($fecha!=""){
			$rta=False;
			$a=explode("/",$fecha);
			if(count($a)==3){
					$rta=checkdate( $a[1],  $a[0],  $a[2]);
			}		
	}
	return $rta;
        }
    
     public function fechaToDb($fecha)
        {
	    $fecha=substr($fecha,0,10); 
		$rta="";
		if($fecha!=""){
			$a=explode("/",$fecha);
			if(count($a)==3){
					$rta=$a[2]."-".$a[1]."-".$a[0];
			}		
		}
			return $rta;
        }
      
      public function DbTofecha($fecha)
        {
	    $fecha=substr($fecha,0,10); 
		if($fecha!=""){
			$a=explode("-",$fecha);
			if(count($a)==3){
					$rta=$a[2]."/".$a[1]."/".$a[0];
			}		
		}
			return $rta;
        } 
      
      public function periodo($p){
				$c=explode("-",$p);				
				if(count($c)==2){
					if(strlen($c[1])==2){
						if($c[0]>2006 and $c[0]<=date('Y')+1 and in_array($c[1],array("01","02","03","04","05","06","07","08","09","10","11","12"),true)){
								
								return true;	
						}	
					}
				}	
			return false;
		  }
	public	function codigo_barras($url,$nom,$valores){
			//par1 path completo archivo.png	
			//par2 valores del codigo de barras
			$par=true;
			$pares="0";
			$impares="0";
			for($i=0;$i<strlen($valores);$i++){
				if($par)
					$pares=$pares + substr($valores,$i,1);
				else
					$impares=$impares + substr($valores,$i,1);
				$par=!$par;
			}
			$impares=$impares*3;
			$total=$impares+$pares;
			if(substr($total,strlen($total)-1,1)=='0')
				$digito="0";
			else
				$digito= (substr($total,0,strlen($total)-1).'0')+10 -  $total ;
			$f=fopen("http://www.sannicolas.gov.ar/barcode2/image.php?code=$valores$digito&style=68&type=I25&width=400&height=50&xres=1","r");
			$//f=fopen("http://".$url."/barcode/barcode.php?code=$valores$digito&encoding=I25&scale=1&mode=png","r");
			$png="";
			while($c=fgets($f,1204)){
				$png=$png.$c;	
			}
			fclose($f);
			$a=fopen($nom,"w");
			 fputs($a,$png,strlen($png));
			fclose($a); 
			return $digito;	
			}  
	 
	public function razonsocial($cuit,$rz){

		 if(trim($cuit)<>'' and trim($rz)==''){
			 //si ingeso cuit la razon social no puede ser vacia
			  return false;
			 }
		else{
			 return true;
			}	 
		
		}	       
	public function cuit($cuit){	
		   if (null == $cuit) {
            return true;
        }
        
        $esCuit = false;
        $cuit_rearmado = "";
        
        //separo cualquier caracter que no tenga que ver con numeros
        for ($i = 0; $i < strlen($cuit); $i++) {
            if ((ord(substr($cuit, $i, 1)) >= 48) && (ord(substr($cuit, $i, 1)) <= 57)) {
                $cuit_rearmado = $cuit_rearmado . substr($cuit, $i, 1);
            }
        }
        
        $cuit = $cuit_rearmado;
        
        if (strlen($cuit_rearmado) <> 11) {  // si to estan todos los digitos
            $esCuit = false;
        } else {
            $x = $i = $dv = 0;
            // Multiplico los dígitos.
            $vec[0] = (substr($cuit, 0, 1)) * 5;
            $vec[1] = (substr($cuit, 1, 1)) * 4;
            $vec[2] = (substr($cuit, 2, 1)) * 3;
            $vec[3] = (substr($cuit, 3, 1)) * 2;
            $vec[4] = (substr($cuit, 4, 1)) * 7;
            $vec[5] = (substr($cuit, 5, 1)) * 6;
            $vec[6] = (substr($cuit, 6, 1)) * 5;
            $vec[7] = (substr($cuit, 7, 1)) * 4;
            $vec[8] = (substr($cuit, 8, 1)) * 3;
            $vec[9] = (substr($cuit, 9, 1)) * 2;

            // Suma cada uno de los resultado.
            for ($i = 0; $i <= 9; $i++) {
                $x += $vec[$i];
            }
            $dv = (11 - ($x % 11)) % 11;
            if ($dv == (substr($cuit, 10, 1))) {
                $esCuit = true;
            }
        }

        return $esCuit;
		}

		public  function validCbu($cbu)
		{
			// Estrictamente sólo 22 números
			if (!preg_match('/[0-9]{22}/', $cbu))
				return false;
			
			$arr = str_split($cbu);
			if ($arr[7] <> self::getDigitoVerificador($arr, 0, 6))
				return false;
			if ($arr[21] <> self::getDigitoVerificador($arr, 8, 20))
				return false;
			
			return true;
		}
		
		/**
		 * Devuelve el dígito verificador para los dígitos de las posiciones "pos_inicial" a "pos_final" 
		 * de la cadena "$numero" usando clave 10 con ponderador 9713
		 *
		 * @param array $numero arreglo de digitos
		 * @param integer $pos_inicial
		 * @param integer $pos_final 
		 * @return integer digito verificador de la cadena $numero
		 */
		private static function getDigitoVerificador($numero, $pos_inicial, $pos_final)
		{
			$ponderador = array(3,1,7,9);
			$suma = 0;
			$j = 0;
			for ($i = $pos_final; $i >= $pos_inicial; $i--)
			{
				$suma = $suma + ($numero[$i] * $ponderador[$j % 4]);
				$j++;
			}
			return (10 - $suma % 10) % 10;
		}	
}
