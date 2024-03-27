<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alumnos extends CI_Controller {

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
 
    public function guardar()
    {
				$this->load->helper(array('form', 'url'));
                $this->load->library('form_validation');
				
                if ($this->form_validation->run() == FALSE)
                {
                        $aux= new stdClass;
						$aux->nombre=$this->input->post('nombre');
						$aux->apellido=$this->input->post('apellido');
						$aux->direccion=$this->input->post('direccion');
						$aux->dni=$this->input->post('dni');
						$aux->id_curso=$this->input->post('curso');
						$aux->telefono=$this->input->post('telefono');
						$aux->email=$this->input->post('email');
						$aux->otros=$this->input->post('otros');
						$aux->fechaingreso=$this->input->post('fechaingreso');
						$aux->fechanacimiento=$this->input->post('fechanacimiento');
						$aux->cuit=$this->input->post('cuit');
						$aux->razonsocial=$this->input->post('razonsocial');
    					$aux->codiva=$this->input->post('codiva');
						$data["alumno"]=$aux;
                        $this->load->view('encabezado.php',$data);
						$this->load->view('menu.php',$data);
						$this->load->view('alumnos/editar',$data);
                }
                else
                {
                        $this->load->view('formsuccess');
                }
		 		
		
		
		
	}
 
	public function listar()
	{
		$data["mensaje"]="";
		$this->load->view('encabezado.php',$data);
		$this->load->view('menu.php',$data);
		$this->load->view('alumnos/listado',$data);
		

	}
	public function buscar()
	{
		$p=$this->input->post('buscar');
		$this->load->model('alumnos_model');
		$data["alumnos"]=$this->alumnos_model->buscar($p);
		$this->load->view('encabezado.php',$data);
		$this->load->view('menu.php',$data);
		$this->load->view('alumnos/listado',$data);


	}
	public function listado()
	{
		$this->load->model('alumnos_model');
		$data["alumnos"]=$this->alumnos_model->listado();
		/* Con esto evitamos hacer el inner join en el modelo, y en cambio vamos buscando el nombre del curso para el id_curso de cada alumno
		$this->load->model('
        _Model');
		foreach($data["alumnos"] as $alumno)
		{
			$curso=$this->Cursos_Model->curso($alumno->id_curso);
			$alumno->id_curso=$curso["nombre"];
			//Atento a esto, si usamos este foreach en la vista tenemos que mostrar $alumno->id_curso en vez de $alumno->curso
		}*/
		$this->load->view('encabezado.php',$data);
		$this->load->view('menu.php',$data);
		$this->load->view('alumnos/listado',$data);
	}
		public function editar($p='')
	{
		$this->load->model('alumnos_model');
		
		if($p>0){
			
			$rta=$this->alumnos_model->editar($p);
			$data["alumno"]=$rta[0];
		}	
		if($p=='' or $this->input->post('id')!==null or count($rta)==0){
			$aux= new stdClass;
			$aux->id=$this->input->post('id');
			$aux->nombre=$this->input->post('nombre');
			$aux->apellido=$this->input->post('apellido');
			$aux->direccion=$this->input->post('direccion');
			$aux->dni=$this->input->post('dni');
			$aux->id_curso=$this->input->post('curso');
			$aux->telefono=$this->input->post('telefono');
			$aux->email=$this->input->post('email');
			$aux->otros=$this->input->post('otros');
			$aux->fechaingreso=$this->input->post('fechaingreso');
			$aux->fechanacimiento=$this->input->post('fechanacimiento');
				$aux->cuit=$this->input->post('cuit');
						$aux->razonsocial=$this->input->post('razonsocial');
    					$aux->codiva=$this->input->post('codiva');
			$data["alumno"]=$aux;
		}
		if($p=='')	
			$data["id"]=$p;
		else	
			$data["id"]=$this->input->post('id');
		if($this->input->post('id')!==null){
				$this->load->helper(array('form', 'url'));
                $this->load->library('form_validation');				
                if ($this->form_validation->run() == True)
                {
					$this->alumnos_model->guardar($data);
					redirect('alumnos/listado');
				}
				
		}
		$this->load->model("Cursos_Model");
		$data["cursos"]=$this->Cursos_Model->listado();
		$this->load->model("Iva_Model");
		$data["ivas"]=$this->Iva_Model->listado();
		$this->load->view('encabezado.php',$data);
		$this->load->view('menu.php',$data);
		$this->load->view('alumnos/editar',$data);
		

	}
	
/*	public function ingreso()
	{
		$usuario=$this->input->post('usuario');
		$pass=$this->input->post('password');
		$this->load->model('login_model');
		$usu=$this->login_model->ingreso($usuario,$pass);
		if($usu){
				redirect('pincipal');
		}
		else{
			$data["mensaje"]="Usuario o Password Incorrecto";
			$this->load->view('login/login.php',$data);
			}
	}*/
 public function es_fecha($fecha){
	$this->load->library('funciones');
	return $this->funciones->fecha_nacimiento($fecha);
}
 public function es_razonsocial($cuit,$rz){
	$this->load->library('funciones');
	$cuit = $this->input->post('cuit');
	$rz = $this->input->post('razonsocial');
	return $this->funciones->razonsocial($cuit,$rz);
}
 public function es_cuit($cuit){
	$this->load->library('funciones');
	return $this->funciones->cuit($cuit);
}
 public function eliminar($p){
	$this->load->library('funciones');
	//Marcamos Con Fecha Baja !!! 
	//	die($p);
		$this->load->model('alumnos_model');
		$data["alumnos"]=$this->alumnos_model->traer($p);
		$this->load->view('encabezado.php',$data);
		$this->load->view('alumnos/eliminar',$data);
}
 public function borrar($p){
	$this->load->library('funciones');
	//Marcamos Con Fecha Baja !!! 
	//	die($p);
		$this->load->model('alumnos_model');
		$this->alumnos_model->borrar($p);
		redirect('alumnos/listado');
}
}
?>
