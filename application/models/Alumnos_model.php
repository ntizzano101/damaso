<?php
class Alumnos_model extends CI_Model {

       

        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }

         public function listado()
        {
				$this->db->select('*');
				$this->db->order_by("apellido","asc");
				$this->db->from('alumnos');
				$this->db->join('cursos', 'alumnos.id_curso = cursos.id_curso','left');
				$this->db->where("fechabaja is null");
				$query=$this->db->get();
				return $query->result();
        }
		public function buscar($p)
        {
				
				$this->db->select('*');
				$this->db->order_by("apellido","asc");
				$this->db->from('alumnos');
				//Si sacas el inner JOIN para mostrar alumnos sin cursos, habilita decomenta el foreach en alumnos/listado()
				$this->db->join('cursos', 'alumnos.id_curso = cursos.id_curso','left');
				$this->db->where(array("apellido like"=>$p.'%',"fechabaja is null"));
				$query=$this->db->get();
				return $query->result();
				
        }
        public function editar($p)
        {
				$query=$this->db->get_where('alumnos',array("id"=>$p));
				//echo $this->db->queries[0];die;
				return $query->result();
        }
         public function guardar($p)
        {
				$object=$p["alumno"];
				
				if($object->id > 0){
					$this->db->where('id',$object->id);
					$this->db->update('alumnos', $object);
				    //var_dump($object);die;
				}
				else{
					$query=$this->db->insert('alumnos', $object);
						
				}	
			return true;
        }public function traer($p)
        {
				
				$this->db->select('*');
				$this->db->order_by("apellido","asc");
				$this->db->from('alumnos');
				$this->db->where(array("id"=>$p));
				$query=$this->db->get();
				return $query->result();
				
        }
        public function borrar($p){
       $data = array(
        'fechabaja' => date('Y-m-d')
		);
		$this->db->where('id', $p);
		$this->db->update('alumnos', $data);
	}
}
?>
