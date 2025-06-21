import Swal from "sweetalert2";

document.addEventListener('DOMContentLoaded', function() {
    const formulario = document.getElementById('FormLogin');
    
    if(formulario) {
        formulario.addEventListener('submit', function(e) {
            e.preventDefault();
            procesarLogin();
        });
    }
});

async function procesarLogin() {
    const dpi = document.querySelector('input[name="dpi"]').value;
    const password = document.querySelector('input[name="password"]').value;
    
    if(!dpi || !password) {
        Swal.fire('Error', 'Todos los campos son obligatorios', 'error');
        return;
    }
    
    if(dpi.length !== 13) {
        Swal.fire('Error', 'El DPI debe tener exactamente 13 dígitos', 'error');
        return;
    }
    
    if(!/^\d{13}$/.test(dpi)) {
        Swal.fire('Error', 'El DPI solo debe contener números', 'error');
        return;
    }
    
    try {
        Swal.fire({
            title: 'Iniciando sesión...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        const datos = new FormData();
        datos.append('dpi', dpi);
        datos.append('password', password);
        
        const respuesta = await fetch('/clemente_final_capacitaciones_ingSoft3/login', {
            method: 'POST',
            body: datos
        });
        
        if(respuesta.redirected) {
            window.location.href = respuesta.url;
        } else {
            Swal.fire('Error', 'Credenciales incorrectas', 'error');
        }
    } catch (error) {
        Swal.fire('Error', 'Error de conexión', 'error');
    }
}