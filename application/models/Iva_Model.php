<?php
class Iva_Model extends CI_Model {
        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }
		public function curso($id)
		{
			$sql="SELECT * from cursos WHERE id_curso = ?";
			return $this->db->query($sql, array($id))->result_array();
		}
        public function listado()
        {
   $sql="SELECT id,descripcion FROM categoria_iva WHERE codigo >0 ";
			return $this->db->query($sql)->result_array();
        }
		public function guardar_curso($curso, $id)
		{
			if($id==0){
				$sql="INSERT INTO cursos (curso) VALUES (?)";
				$this->db->query($sql, array($curso));
			}
			else
			{
				$sql="UPDATE cursos SET curso = ? WHERE id_curso = ?";
				$this->db->query($sql, array($curso, $id));
			}
		}
		public function checkear_curso_sin_alumnos($id)
		{
			$sql="SELECT * FROM alumnos WHERE id_curso = ?";
			return $this->db->query($sql, array($id))->result_array();
		}
		public function eliminar_curso($id)
		{
			$sql="DELETE FROM cursos WHERE id_curso = ?";
			$this->db->query($sql, array($id));
		}
}
?>
