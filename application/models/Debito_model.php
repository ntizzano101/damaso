<?php
class Debito_Model extends CI_Model {
        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }
		public function traer($periodo,$fecha)
		{
            $sql="select c.id,cbus.ident ,c.id_alumno,concat(a.nombre,' ',a.apellido) as nombre,a.cbu as cj ,c.original as importe,g.nombre as concepto,
            cbus.ident,cbus.cbu,c.id_concepto                
            from alumnos_cc c inner join 
            alumnos a on c.id_alumno=a.id
            inner join conceptos g on g.id=c.id_concepto
            inner join (select max(id) as ident,cbu from alumnos where cbu<>'' group by cbu) as cbus 
            on a.cbu=cbus.cbu
            where c.periodo=? and a.cbu<>'' and c.original=c.pendiente and c.pendiente > 0  order by cbus.cbu,cbus.ident,c.id_alumno
            ";
            $debitos=$this->db->query($sql,$periodo)->result();
            $ident="";$cbu="";$id_alumno="";
            foreach($debitos as $deb){
                   if($ident<>$deb->ident or $cbu<>$deb->cbu or $id_alumno<>$deb->id_alumno){
                    ## agrego encabezado
                    $nuevo= new stdClass;
                    $nuevo->id=Null;
                    $nuevo->fecha=$fecha;
                    $nuevo->ident=$deb->ident;
                    $nuevo->cbu=$deb->cbu;
                    $nuevo->id_alumno=$deb->id_alumno;
                    $nuevo->nombre=$deb->nombre;
                    $nuevo->concepto="CUOTA " . $periodo;
                    $nuevo->total=0;
                    $query=$this->db->insert('debito', $nuevo);
                    $nuevo->id=$this->db->insert_id();
                    $ident=$deb->ident ;
                    $cbu=$deb->cbu;
                    $id_alumno=$deb->id_alumno;
                   }
                   ## agrego detalle 
                   $det= new stdClass;
                   $det->id_debito=$nuevo->id;
                   $det->id_concepto=$deb->id_concepto;
                   $det->monto=$deb->importe;
                   $det->id_alumno=$deb->id_alumno;
                   $det->ident=$deb->ident;
                   $det->id_cc=$deb->id;
                   $det->concepto=$deb->concepto;
                   $query=$this->db->insert('debito_items', $det);
                   $nuevo->total+=$deb->importe;
                   $this->db->where('id',$nuevo->id);
	     		   $this->db->update('debito', $nuevo);
            }
            
          $sql="select * from debito where fecha=? order by cbu,nombre"  ;
          return $this->db->query($sql,$fecha)->result();

        }

        public function existe($fecha){
            $sql="select * from debito where fecha=? limit 1 "  ;
            return $this->db->query($sql,$fecha)->result();
        }

        public function fechas(){
            $sql="select distinct fecha,date_format(fecha,'%d/%m/%Y') as fechaf from debito order by fecha desc"  ;
            return $this->db->query($sql)->result();
        }

        public function debitos($fecha){
            $sql="select * from debito where fecha=? order by nombre"  ;
            return $this->db->query($sql,$fecha)->result();
        }
    }
