const llenarFormulario = (event) => {
    const datos = event.currentTarget.dataset;

    document.getElementById('permiso_id').value = datos.id;
    document.getElementById('usuario_id').value = datos.usuario;
    document.getElementById('app_id').value = datos.app;
    document.getElementById('permiso_nombre').value = datos.nombre;
    document.getElementById('permiso_clave').value = datos.clave;
    document.getElementById('permiso_desc').value = datos.desc;
    document.getElementById('permiso_tipo').value = datos.tipo;
    document.getElementById('permiso_motivo').value = datos.motivo;

    // Cambiar la visibilidad de los botones
    BtnGuardar.style.display = 'none';
    BtnModificar.style.display = 'inline-block';
    BtnLimpiar.style.display = 'inline-block';
}

// También necesitarás la función para limpiar el formulario
const limpiarTodo = () => {
    FormPermisos.reset();
    document.getElementById('permiso_id').value = '';
    
    // Restaurar la visibilidad de los botones
    BtnGuardar.style.display = 'inline-block';
    BtnModificar.style.display = 'none';
    BtnLimpiar.style.display = 'inline-block';
}

// Función para modificar permiso
const ModificarPermiso = async (event) => {
    event.preventDefault();
    BtnModificar.disabled = true;

    if (!validarFormulario(FormPermisos, ['permiso_id'])) {
        Swal.fire({
            position: "center",
            icon: "info",
            title: "FORMULARIO INCOMPLETO",
            text: "Debe completar los campos obligatorios",
            showConfirmButton: true,
        });
        BtnModificar.disabled = false;
        return;
    }

    const body = new FormData(FormPermisos);
    
    const url = '/clemente_final_capacitaciones_ingSoft3/permisos/modificarAPI';
    const config = {
        method: 'POST',
        body
    }

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, mensaje } = datos

        if (codigo == 1) {
            await Swal.fire({
                position: "center",
                icon: "success",
                title: "Éxito",
                text: mensaje,
                showConfirmButton: true,
            });

            limpiarTodo();
            BuscarPermisos();
        } else {
            await Swal.fire({
                position: "center",
                icon: "error",
                title: "Error",
                text: mensaje,
                showConfirmButton: true,
            });
        }

    } catch (error) {
        console.log(error)
    }
    BtnModificar.disabled = false;
}

// Función para eliminar permiso
const EliminarPermiso = async (id) => {
    const result = await Swal.fire({
        title: '¿Está seguro?',
        text: "Esta acción no se puede deshacer",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    });

    if (result.isConfirmed) {
        try {
            const url = '/clemente_final_capacitaciones_ingSoft3/permisos/eliminarAPI';
            const body = new FormData();
            body.append('permiso_id', id);

            const config = {
                method: 'POST',
                body
            }

            const respuesta = await fetch(url, config);
            const datos = await respuesta.json();
            const { codigo, mensaje } = datos;

            if (codigo == 1) {
                await Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "Eliminado",
                    text: mensaje,
                    showConfirmButton: true,
                });
                BuscarPermisos();
            } else {
                await Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "Error",
                    text: mensaje,
                    showConfirmButton: true,
                });
            }
        } catch (error) {
            console.log(error);
            await Swal.fire({
                position: "center",
                icon: "error",
                title: "Error",
                text: "Ocurrió un error al eliminar el permiso",
                showConfirmButton: true,
            });
        }
    }
}

// Event listeners
document.addEventListener('DOMContentLoaded', () => {
    // Cargar datos iniciales
    CargarUsuarios();
    CargarAplicaciones();
    BuscarPermisos();

    // Event listeners para botones principales
    BtnGuardar.addEventListener('click', GuardarPermiso);
    BtnModificar.addEventListener('click', ModificarPermiso);
    BtnLimpiar.addEventListener('click', limpiarTodo);
    BtnBuscar.addEventListener('click', BuscarPermisos);

    // Event listeners para botones de la tabla (usando delegación de eventos)
    document.addEventListener('click', (e) => {
        if (e.target.closest('.modificar')) {
            llenarFormulario(e);
        }
        
        if (e.target.closest('.eliminar')) {
            const id = e.target.closest('.eliminar').dataset.id;
            EliminarPermiso(id);
        }
    });
});