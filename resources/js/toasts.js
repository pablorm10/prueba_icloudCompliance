$(document).ready(function() {
    // Verifica si hay un toast mostrado
    var $toast = $('.toast');
    if ($toast.length) {
        // Muestra el toast y establece un delay para ocultarlo
        $toast.toast({ delay: 3000 }); // Muestra el toast por 3000 ms
        $toast.toast('show');

        // Oculta y elimina el toast después de 3 segundos
        setTimeout(function() {
            $toast.toast('hide'); // Oculta el toast
            $toast.remove(); // Elimina el toast del DOM
        }, 3000); // 3000 ms = 3 segundos
    }
});
