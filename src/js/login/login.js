import Swal from 'sweetalert2';
import { validarFormulario } from '../funciones';

const FormLogin = document.getElementById('FormLogin');
const BtnIniciar = document.getElementById('BtnIniciar');

const login = async (e) => {
    e.preventDefault();
    console.log('🚀 Iniciando proceso de login...');
    
    BtnIniciar.disabled = true;
    const textoOriginal = BtnIniciar.innerHTML;
    BtnIniciar.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Verificando...';

    // Obtener valores del formulario
    const dpi = document.getElementById('usuario_dpi').value.trim();
    const contrasena = document.getElementById('usuario_contra').value.trim();
    
    console.log('📝 Datos del formulario:', { dpi, contrasena: contrasena ? '***' : 'vacío' });

    // Validación de campos vacíos
    if (!dpi || !contrasena) {
        console.log('❌ Campos vacíos detectados');
        Swal.fire({
            title: "Campos requeridos",
            text: "Por favor ingrese su DPI y contraseña",
            icon: "warning",
            confirmButtonColor: "#46a545"
        });
        BtnIniciar.disabled = false;
        BtnIniciar.innerHTML = textoOriginal;
        return;
    }

    // Validar formato de DPI (13 dígitos)
    if (!/^\d{13}$/.test(dpi)) {
        console.log('❌ DPI inválido:', dpi);
        Swal.fire({
            title: "DPI inválido",
            text: "El DPI debe tener exactamente 13 dígitos numéricos",
            icon: "warning",
            confirmButtonColor: "#46a545"
        });
        BtnIniciar.disabled = false;
        BtnIniciar.innerHTML = textoOriginal;
        return;
    }

    // Validar longitud mínima de contraseña
    if (contrasena.length < 6) {
        console.log('❌ Contraseña muy corta');
        Swal.fire({
            title: "Contraseña muy corta",
            text: "La contraseña debe tener al menos 6 caracteres",
            icon: "warning",
            confirmButtonColor: "#46a545"
        });
        BtnIniciar.disabled = false;
        BtnIniciar.innerHTML = textoOriginal;
        return;
    }

    try {
        const body = new FormData(FormLogin);
        
        console.log('📤 Enviando datos al servidor...');
        const url = '/clemente_final_capacitaciones_ingsoft3/login';
        console.log('🌐 URL de la API:', url);
        
        const config = {
            method: 'POST',
            body
        };

        console.log('⏳ Realizando petición...');
        const respuesta = await fetch(url, config);
        
        console.log('📡 Respuesta recibida:', respuesta.status, respuesta.statusText);
        
        if (!respuesta.ok) {
            throw new Error(`Error HTTP ${respuesta.status}: ${respuesta.statusText}`);
        }

        const data = await respuesta.json();
        console.log('📊 Datos de respuesta:', data);
        
        const { codigo, mensaje, usuario_id, nombre } = data;

        if (codigo == 1) {
            console.log('✅ Login exitoso para usuario:', nombre);
            
            await Swal.fire({
                title: '¡Bienvenido!',
                html: `
                    <div style="text-align: center;">
                        <i class="fas fa-check-circle" style="color: #46a545; font-size: 3rem; margin-bottom: 15px;"></i>
                        <h4>${mensaje}</h4>
                        ${nombre ? `<p style="color: #666;">Hola, <strong>${nombre}</strong></p>` : ''}
                        <p style="font-size: 0.9em; color: #999;">Redirigiendo al sistema...</p>
                    </div>
                `,
                icon: 'success',
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true,
                backdrop: `
                    rgba(70, 165, 69, 0.4)
                    left top
                    no-repeat
                `
            });

            console.log('🔄 Limpiando formulario y redirigiendo...');
            FormLogin.reset();
            location.href = '/clemente_final_capacitaciones_ingsoft3/inicio';
            
        } else {
            console.log('❌ Error de autenticación:', mensaje);
            Swal.fire({
                title: 'Error de autenticación',
                text: mensaje,
                icon: 'error',
                confirmButtonColor: "#d33",
                footer: '<small>Verifique sus credenciales e intente nuevamente</small>'
            });
        }

    } catch (error) {
        console.error('💥 Error en la petición:', error);
        
        let mensajeError = 'No se pudo conectar con el servidor';
        if (error.message.includes('Failed to fetch')) {
            mensajeError = 'Error de conectividad. Verifique su conexión a internet.';
        } else if (error.message.includes('500')) {
            mensajeError = 'Error interno del servidor. Contacte al administrador.';
        }
        
        Swal.fire({
            title: 'Error de conexión',
            text: mensajeError,
            icon: 'error',
            confirmButtonColor: "#d33",
            footer: `<small>Detalles técnicos: ${error.message}</small>`
        });
    }

    BtnIniciar.disabled = false;
    BtnIniciar.innerHTML = textoOriginal;
}

// Función de logout mejorada
const logout = async () => {
    console.log('🚪 Iniciando proceso de logout...');
    try {
        const confirmacion = await Swal.fire({
            title: '¿Cerrar sesión?',
            text: "¿Está seguro que desea salir del sistema?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, cerrar sesión',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: "#46a545",
            cancelButtonColor: "#6c757d",
            reverseButtons: true
        });

        if (confirmacion.isConfirmed) {
            await Swal.fire({
                title: 'Cerrando sesión',
                text: 'Gracias por usar el sistema',
                icon: 'success',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true
            });

            console.log('🔄 Redirigiendo al login...');
            location.href = '/clemente_final_capacitaciones_ingsoft3/logout';
        }

    } catch (error) {
        console.error('💥 Error al cerrar sesión:', error);
        Swal.fire({
            title: 'Error',
            text: 'Ocurrió un error al cerrar la sesión',
            icon: 'error',
            confirmButtonColor: "#d33"
        });
    }
}

// Event listeners
FormLogin.addEventListener('submit', login);

// Validación en tiempo real del DPI
document.getElementById('usuario_dpi').addEventListener('input', function(e) {
    // Solo permitir números
    this.value = this.value.replace(/[^0-9]/g, '');
    
    // Limitar a 13 dígitos
    if (this.value.length > 13) {
        this.value = this.value.slice(0, 13);
    }
    
    // Cambiar color del borde según validez
    if (this.value.length === 13) {
        this.style.borderColor = '#46a545';
    } else if (this.value.length > 0) {
        this.style.borderColor = '#ffc107';
    } else {
        this.style.borderColor = '';
    }
});

// Validación en tiempo real de la contraseña
document.getElementById('usuario_contra').addEventListener('input', function(e) {
    // Remover espacios en blanco
    this.value = this.value.replace(/\s/g, '');
    
    // Cambiar color del borde según longitud
    if (this.value.length >= 6) {
        this.style.borderColor = '#46a545';
    } else if (this.value.length > 0) {
        this.style.borderColor = '#ffc107';
    } else {
        this.style.borderColor = '';
    }
});

// Enter en DPI pasa a contraseña
document.getElementById('usuario_dpi').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        document.getElementById('usuario_contra').focus();
    }
});

// Hacer logout disponible globalmente
window.logout = logout;

// Inicialización al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    console.log('🎯 Sistema de login inicializado');
    FormLogin.reset();
    BtnIniciar.disabled = false;
    
    // Mostrar mensaje de bienvenida
    setTimeout(() => {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        Toast.fire({
            icon: 'info',
            title: 'Sistema listo para usar'
        });
    }, 1000);
});