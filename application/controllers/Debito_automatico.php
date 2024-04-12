<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Debito_automatico extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	/*public function __construct()
	{
		if($this->session->usuario=""){
				redirect('login');
				exit;
		}		
	  
				
	}
		*/
	public function __construct(){
		
		      parent::__construct();
			if(!isset($this->session->usuario)){
				redirect('salir');
				exit;
		}		
		
		
	}	

    public function index(){

    }

    

    public function nuevo(){
        //$this->load->model('debito_model');
		//$data["alumnos"]=$this->alumnos_model->traer($p);
        # Fecha del archivo
        if($this->input->post('fecha_archivo')!="")
                $fecha_archivo=$this->input->post('fecha_archivo');
        else    
                $fecha_archivo=date('Y-m-d');
        # Fecha Vence 
        if($this->input->post('fecha_vence')!="")
                $fecha_vence=$this->input->post('fecha_vence');
        else    
                $fecha_vence=date("Y-m-d");        
        # Fecha Proceso
        if($this->input->post('fecha_proceso')!="")
                $fecha_proceso=$this->input->post('fecha_proceso');
        else    
                $fecha_proceso=date("Y-m-d");        
        $data["fecha_archivo"]=$fecha_archivo;
        $data["fecha_proceso"]=$fecha_proceso;
        $data["fecha_vence"]=$fecha_vence;
        $data["error"]="";
		$this->load->view('encabezado.php',$data);
        $this->load->view('menu.php',$data);
		$this->load->view('debito_automatico/nuevo.php',$data);

    }


    public function ver(){
        $error="";
        $this->load->model('debito_model');        
        # Fecha del archivo
        $fecha_archivo=$this->input->post('fecha_archivo');
        # Fecha Vence 
        $fecha_vence=$this->input->post('fecha_vence');
        # Fecha Proceso
        $fecha_proceso=$this->input->post('fecha_proceso');
        
        $existe=$this->debito_model->existe($fecha_archivo);        

        $debito=$this->debito_model->traer(substr($fecha_archivo,0,7),$fecha_archivo);        
        
        if(empty($debito)){$error="NO HAY INFORMACION PARA ENVIAR, REVISE QUE LAS CUOTAS ESTAN GENERADAS";}
        
        if(!empty($existe)){$error="YA EXISTE UN ENVIO PARA LA FECHA SELECCIONADA";}

        if($fecha_proceso<$fecha_archivo){$error="FECHA DE PROCESO DEBE SER MAYOR A LA FECHA DEL ARCHIVO";}

        if($fecha_vence<$fecha_proceso){$error="FECHA DE VENCIMIENTO DEBE SER MAYOR A LA FECHA DEL PROCESO";}

        if($error!=""){
            $data["fecha_archivo"]=$fecha_archivo;
            $data["fecha_proceso"]=$fecha_proceso;
            $data["fecha_vence"]=$fecha_vence;
            $data["error"]=$error;
            $this->load->view('encabezado.php',$data);
            $this->load->view('menu.php',$data);
            $this->load->view('debito_automatico/nuevo.php',$data);
            return ;
            exit;
        }
        
        # Registro de cabecera
        # Campo 1 FIJO 4110
        $cabeza="4110";
        # campo 2 Identificacion de la empresa 37080
        $cabeza.="17888";
        # campo 3  Fecha del archivo AAAAMMDD
        $cabeza.=str_replace("-","",$fecha_archivo)    ;
        # campo 4  Fecha Vence o fecha que hay que procecsar  AAAAMMDD
        $cabeza.=str_replace("-","",$fecha_vence)    ;
        # campo 5 banco emisor 0017
        $cabeza.="0017";
        # campo 6 Sucursal  0079
        $cabeza.="0079";
        #campo 7 digito control 50
        $cabeza.="50";
        #campo 8 numero de cuenta
        $cabeza.="0103400706";
        #campo 9 Codigo de servicio
        $cabeza.="CUOTA     ";
        #campo 10 Divisa de la Cuenta 
        $cabeza.="ARS";
        # campo 11 fijo "0"
        $cabeza.="0";
        # campo 12 nombre del fichero lo ponemos nosotos 12
        $cabeza.="DAMA" . str_replace("-","",$fecha_archivo)    ;
        # campo 13 Empresa nombre 36
        $cabeza.="INSTITUTO EDUCATIVO DAMASO VALDES   ";
        # CAMPO 14  fijo "20"
        $cabeza.="20";
        # campo 15 libre 
        $cabeza.=str_repeat(" ",141) . PHP_EOL;
        #--------------------------FIN CABEZA
        #AHORA POR CADA DEBITO
        $registros="";
        $total=0;
        $cant=0;        
        foreach($debito as $deb){
            $cant++;
            $total+=$deb->total;
            # cada uno de los 4 registros individuales
            $reg1="";$reg2="";$reg3="";$reg4="";
            # campo 1
            $reg1="4210";
            #campo 2 Empresa    
            $reg1.="17888";
            # campo 3 libre  dos en blnco
            $reg1.="  ";
            # campo 4 Identificacion del beneficiarios es el ID del alumno 22 posiciones 
            # pero tenemos que tener un solo valor por cada cbu  max(id_alumno),cbu group by cbu
            $id_alumno=str_pad($deb->ident,22,"0",STR_PAD_LEFT);
            $reg1.=$id_alumno;
            # campo 5 cbu
            $reg1.=$deb->cbu;
            # campo 6 importe ENTERO
            list($importe,$decimal)=explode(".",$deb->total);
            $reg1.=str_pad($importe,13,"0",STR_PAD_LEFT);    
            # campo 7 importe DECIMAL            
            $reg1.=substr($decimal,0,2);
            # campo 8  lo llenan con el resultado dehjar en blanco
            $reg1.="      ";
            #campo 9 REFERECNIA   concepto total  22 caracteres
            $deb->concepto=$this->limpiar($deb->concepto);
            if(strlen($deb->concepto)>22){$concepto=substr($deb->concepto,0,22);}
            else{$concepto=$deb->concepto;}
            $reg1.=str_pad($concepto,22," ",STR_PAD_RIGHT);
            #campo 10   
            $reg1.=str_replace("-","",$fecha_proceso);
            #campo 11 libre dos blancos
            $reg1.="  ";
            #campo 12  numero de factura usamos el ID de la deuda 15 long
            $reg1.=str_pad($deb->id,15,"0",STR_PAD_LEFT);
            #campo 13  1 blanco
            $reg1.=" ";
            #campo 14    40 blancos
            $reg1.=str_repeat(" ",40);
            # campo 15  libre 86 blancos
            $reg1.=str_repeat(" ",86).PHP_EOL;
            #--------- FIN REG 1
            #comienzo REg 2
            # campo 1
            $reg2="4220";
             #campo 2 Empresa    
            $reg2.="17888";
            # campo 3 libre  dos en blnco
            $reg2.="  ";
            # campo 4 Identificacion del beneficiarios es el ID del alumno 22 posiciones 
            # pero tenemos que tener un solo valor por cada cbu  max(id_alumno),cbu group by cbu            
            $reg2.=$id_alumno;            
            #campo 5  NOMBRE del Alumno
            $deb->nombre=$this->limpiar($deb->nombre);
            if(strlen($deb->nombre)>36){$nombre=substr($deb->nombre,0,36);}
            else{$nombre=$deb->nombre;}
            $reg2.=str_pad($nombre,36," ",STR_PAD_RIGHT); 
            # campo 6 7 8 no son obligatiors
            $reg2.=str_repeat(" ",36+36+109).PHP_EOL;
            #-----------FIN REG 2
            # comienzo reG3
              # campo 1
              $reg3="4230";
              #campo 2 Empresa    
             $reg3.="17888";
             # campo 3 libre  dos en blnco
             $reg3.="  ";
             # campo 4 Identificacion del beneficiarios es el ID del alumno 22 posiciones 
             # pero tenemos que tener un solo valor por cada cbu  max(id_alumno),cbu group by cbu            
             $reg3.=$id_alumno;
             # del 5 al 8 no obligario
             $reg3.=str_repeat(" ",36+36+36+109).PHP_EOL;
             #-------------------FIN REG 3
             #comienzo REG 4
                 # campo 1
                 $reg4="4240";
                 #campo 2 Empresa    
                $reg4.="17888";
                # campo 3 libre  dos en blnco
                $reg4.="  ";
                # campo 4 Identificacion del beneficiarios es el ID del alumno 22 posiciones 
                # pero tenemos que tener un solo valor por cada cbu  max(id_alumno),cbu group by cbu            
                $reg4.=$id_alumno;
                # campo del 5 informar concepto 40 
                $reg4.=str_pad($concepto,40," ",STR_PAD_RIGHT);
                # relleno
                $reg4.=str_repeat(" ",177).PHP_EOL;
                #FIN CAMPOI 4
                $registros.=$reg1.$reg2.$reg3.$reg4;                
        }
            #comienzo Pie    
              # campo 1
              $pie="4910";
              #campo 2 Empresa    
              $pie.="17888";
              # campo 3 total entero 13 
              list($importe,$decimal)=explode(".",$total);
              $pie.=str_pad($importe,13,"0",STR_PAD_LEFT);
              # campo 4 decimales 2              
              $pie.=substr($decimal,0,2);              
              # campo 5 total operaciones 
              $pie.=str_pad($cant,8,"0",STR_PAD_LEFT);
              # campo 6 numero total de registros
              $pie.=str_pad(($cant*4) + 2 ,10,"0",STR_PAD_LEFT);
              # campo 7 libre 208
              $pie.=str_repeat(" ",208).PHP_EOL;


              file_put_contents("debitos/DAMA" . str_replace("-","",$fecha_archivo),$cabeza.$registros.$pie);


              $data["fecha_archivo"]=$fecha_archivo;
              $data["fecha_proceso"]=$fecha_proceso;
              $data["fecha_vence"]=$fecha_vence;
              $data["debito"]=$debito;
              $this->listar();
              


    }
    public function limpiar($cad){        
            if(strlen($cad)==0){return "";}
            $r=strlen($cad);
            $rta="";
            $validos="0123456789qwertyuiopasdfghjlzxcvbnm0-_. QWERTYUIOPASDFGHJKLZXCVBNM";    
            for($i=0;$i<$r;$i++){
                $c=substr($cad,$i,1);    
                if(strpos($validos,$c)===false){$c=".";}
                $rta=$rta.$c;
            }
            return $rta;
      
    }

    public function listar(){
        $this->load->model('debito_model');               
        $fechas=$this->debito_model->fechas();   
        $data["fechas"]=$fechas;
        $this->load->view('encabezado.php',$data);
        $this->load->view('menu.php',$data);
        $this->load->view('debito_automatico/listar.php',$data);

    }

    public function debitos(){
        $this->load->model('debito_model');      
        $deb=$this->debito_model->debitos($this->input->post('fecha'));
        $tabla="";
        foreach($deb as $de){
            $tabla.="<tr>";
            $tabla.="<td>".$de->id."</td>";
            $tabla.="<td>".$de->nombre."</td>";
            $tabla.="<td>".$de->cbu."</td>";
            $tabla.="<td>".$de->total."</td>";
            $tabla.="</tr>";
        }
        echo $tabla;
        return;
        exit;
    }    
}