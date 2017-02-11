<div class="encuesta-resultados-container">

	<h2>Resultados</h2>

	<h3>Total: <?php echo encuesta_get_registros();?></h3>

	<h3>Huevo: <?php echo encuesta_get_registros_respuesta( 'Huevo' );?></h3>
	<h3>Gallina: <?php echo encuesta_get_registros_respuesta( 'Gallina' );?></h3>

</div>
