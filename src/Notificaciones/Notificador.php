<?php
// Llama a la función con los datos deseados
// notificacion_logro("Nombre del logro", "100 Créditos");
class Notificador {
    function notificacion_logro($nombre, $creditos) {
        // Al llamar a esta función, se imprimirá el script JavaScript con los datos proporcionados
        echo "<script>
                // Esta función se ejecutará al cargar la página
                document.addEventListener('DOMContentLoaded', function() {
                    // Crea el contenedor de notificaciones
                    var notificationContainer = document.createElement('div');
                    notificationContainer.className = 'notification-container';
    
                    // Crea el elemento de notificación
                    var achievementBanner = document.createElement('div');
                    achievementBanner.className = 'achievement-banner';
    
                    // Configura el contenido del banner con los datos proporcionados
                    achievementBanner.innerHTML = `
                        <div class='achievement-icon'>
                            <span class='icon'><span class='icon-trophy'></span></span>
                        </div>
                        <div class='achievement-text'>
                            <p class='achievement-notification'>¡Logro desbloqueado!</p>
                            <p class='achievement-name'>$creditos G&ndash; $nombre</p>
                        </div>
                    `;
    
                    // Modifica el estilo para que aparezca centrado en la parte superior
                    achievementBanner.style.position = 'fixed';
                    achievementBanner.style.top = '10%';
                    achievementBanner.style.left = '35%';
    
                    // Agrega el elemento al contenedor
                    notificationContainer.appendChild(achievementBanner);
    
                    // Agrega el contenedor al cuerpo del documento
                    document.body.appendChild(notificationContainer);
    
                    // Después de 3 segundos, mueve el banner 10em a la izquierda
                    setTimeout(function() {
                        achievementBanner.style.left = 'calc(50% - 4em)';
                    }, 2000);
                });
              </script>";
    }
    
}
