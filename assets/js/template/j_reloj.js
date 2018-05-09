$(document).ready(function() {
	// Crea la función que actualizará la capa #hora-servidor
			jClock = function(jDate, jHora, jMin, jSec) { 
					$("#hora-servidor").val(jHora + ":" + jMin + ":" + jSec); }
					// $("#hora-servidor").html(jHora + ":" + jMin + ":" + jSec); }
					// $("#hora-servidor").html(jDate + ", " + jHora + ":" + jMin + ":" + jSec); }

			// Obtiene los valores de la fecha, hora, minutos y segundos del servidor
			// var jDate = "<?= date('d/m/Y') ?>";
			// var jHora = "<?= date('H') ?>";
			// var jMin = "<?= date('i') ?>";
			// var jSec = "<?= date('s') ?>";

			// Actualiza la capa #hora-servidor
			jClock(jDate, jHora,jMin,jSec);

			// Crea un intervalo cada 1000ms (1s)
			var jClockInterval = setInterval(function()
			{
			/** Incrementa segundos */
			jSec++;
			/** Si el valor de jSec es igual o mayor a 60 */
			if (jSec >= 60) {
			/** Incrementa jMin en 1 */
			jMin++;
			/** Si el valor de jMin es igual o mayor a 60 */
			if (jMin >= 60) {
			/** Incrementa jHora en 1 */
			jHora++;
			/** Si el valor de jHora es igual o mayor a 23 */
			if (jHora > 23) {
			/** Cambia la hora a 00 */
			jHora = "00";
			}

			/** Si el valor de jHora es menor a 10, le agrega un cero al valor */
			else if (jHora < 10) { jHora = "0"+jHora; }

			jMin = "00";
			} else if (jMin < 10) { jMin = "0"+jMin; }

			jSec = "00";
			} else if (jSec < 10) { jSec = "0"+jSec; }

			jClock(jDate, jHora,jMin,jSec);
			}, 1000);
});