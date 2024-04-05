  <nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?=base_url()?>">D&aacute;maso Vald&eacute;s</a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
		         <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Alumnos<span class="caret"></span></a>
          <ul class="dropdown-menu">
			<li><a href="<?=base_url()?>alumnos/editar/">Nuevo</a></li>
            <li><a href="<?=base_url()?>alumnos/listado">Listado</a></li>
            <li><hr></li>
            <li><a href="<?=base_url()?>conceptos/conceptosalumno">Conceptos Alumnos</a></li>
             
            
          </ul>
        </li> 
		   <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Conceptos<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?=base_url()?>conceptos/editar/">Nuevo</a></li>
            <li><a href="<?=base_url()?>conceptos/listado">Listado</a></li>
          </ul>
        </li> 
		  
       
	    <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Caja<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?=base_url()?>conceptos_caja/editar/">Nuevo Concepto</a></li>
            <li><a href="<?=base_url()?>conceptos_caja/listado">Listar Conceptos</a></li>
			 <li><hr></li>
			  <li><a href="<?=base_url()?>movimientos_caja/editar/">Nuevo Movimiento</a></li>
            <li><a href="<?=base_url()?>movimientos_caja/listar">Listar Movimientos</a></li>
						 <li><hr></li>
			  <li><a href="<?=base_url()?>cierre_caja/verificar/">Cerrar / Abrir</a></li>
            <li><a href="<?=base_url()?>cierre_caja/listar">Listar Cierres</a></li>
          </ul>
        </li> 
	   
	   
		   <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Cursos<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?=base_url()?>cursos/nuevo/">Nuevo</a></li>
            <li><a href="<?=base_url()?>cursos">Listado</a></li>
          </ul>
        </li>      

        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Facturas<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?=base_url()?>alumnos_cc/listar_facturas">Listar Facturas</a></li>
            <li><a href="<?=base_url()?>alumnos_cc/listar_ingresos">Listar Ingresos</a></li>
          </ul>
         </li>  
         <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Debitos BBVA<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?=base_url()?>debito_automatico/nuevo">Nuevo</a></li>
            <li><a href="<?=base_url()?>debito_automatico/listar">Listar</a></li>
          </ul>  

        </li>
        <li><a href="<?=base_url()?>movimientos_caja/banco">BANCO</a></li>
        </ul>
       
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $this->session->userdata("titulo") ?><span class="caret"></span></a>
          <ul class="dropdown-menu">
			<li><a href="<?=base_url()?>cambiar_contrasena">Cambiar contraseña</a></li>
            <li><a href="<?=base_url()?>salir">Salir</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<?php /*
<ul class="nav nav-tabs">
  <li class="active"><a href="#">D&aacute;maso Vald&eacute;s</a></li>
  <li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Alumnos
    <span class="caret"></span></a>
    <ul class="dropdown-menu">
      <li><a href="#">Agregar</a></li>
      <li><a href="<?php echo base_url(); ?>/alumnos/listar">Listar</a></li>
    </ul>
  </li>
   <li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Cuenta Corriente
    <span class="caret"></span></a>
    <ul class="dropdown-menu">
      <li><a href="#">Agregar</a></li>
      <li><a href="#">Listar</a></li>
    </ul>
  </li>
   <li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Caja
    <span class="caret"></span></a>
    <ul class="dropdown-menu">
           <li><a href="#">Agregar</a></li>
		   <li><a href="#">Listar</a></li>
    </ul>
  </li>
</ul>
*/
?>
