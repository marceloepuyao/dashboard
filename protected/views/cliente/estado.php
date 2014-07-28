<?php


$this->breadcrumbs=array(
	'Estado Cliente',
);
?>
Cliente: 
<select id="clients" onchange="changeClient()">
	<?php foreach ($clientes as $cl){?>
  <option value="<?php echo $cl['id'];?>"><?php echo $cl['nombre'];?></option>
  <?php }?>
</select>


<p>Último Estado Cliente: <?php echo $cliente->nombre?> </p>

<h2>Resumen</h2>
 Percepción del Cliente: <?php //echo $seguimientoitil[0]->per_client;?>
 <br>
 Percepción Interna: <?php //echo $seguimientoitil[0]->per_sm;?>
  <br>

  <br>
 Issues Activos: 
 
 <?php 
 $cs = Yii::app()->getClientScript();
	$cs->registerScript('id', " 
						function changeClient(){
								var client = $('#clients').val();
								window.location.replace('estado?id='+ client);
							}

						$( document ).ready(function() {

							function changeClient(){
								var client = $('#clients').val();
								window.location.replace('estado?id='+ client);
							}
						});	
								");
?>
 
 
 