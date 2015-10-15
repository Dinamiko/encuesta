<div id="encuesta-container">

	<h2>¿Qué fue antes, el huevo o la gallina?</h2>

	<form id="form-encuesta">

		<div class="encuesta-container-radio">

			<label for="radio-choice-1">Huevo</label>
			<input type="radio" name="encuesta_radiochoices" id="radio-choice-1" tabindex="1" value="Huevo" required>

			<label for="radio-choice-2">Gallina</label>
			<input type="radio" name="encuesta_radiochoices" id="radio-choice-2" tabindex="2" value="Gallina" required>

		</div>

		<input id="encuesta_email" type="email" name="encuesta_email" placeholder="Email" required>

		<p id="encuesta-error"></p>
		
		<input class="submit-button" type="submit" value="Enviar">
		<?php wp_nonce_field( 'encuesta_action', 'encuesta_nonce_field' ); ?> 

	</form>

</div>