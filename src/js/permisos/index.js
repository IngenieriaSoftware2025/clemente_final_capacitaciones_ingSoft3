<<<<<<< HEAD
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
=======
import Swal from "sweetalert2";
//import { Dropdown } from "bootstrap";


const FormPermisos = document.getElementById('FormPermisos');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');
const BtnLimpiar = document.getElementById('BtnLimpiar');
const BtnBuscar = document.getElementById('BtnBuscar');
const seccionTabla = document.getElementById('seccionTabla');
const bodyPermisos = document.getElementById('bodyPermisos');


const GuardarPermiso = async (event) => {
    event.preventDefault(); // Evita que se recargue la página

    // Obtener los datos del formulario
    const formData = new FormData(FormPermisos);
    
    try {
        // Enviar datos al servidor
        const respuesta = await fetch('/clemente_final_capacitaciones_ingSoft3/permisos/guardarAPI', {
            method: 'POST',
            body: formData
        });

        const datos = await respuesta.json();

        if (datos.codigo == 1) {
            // Si todo salió bien
            Swal.fire({
                icon: "success",
                title: "¡Éxito!",
                text: datos.mensaje,
            });
            LimpiarFormulario();
            BuscarPermisos();
        } else {
            // Si hubo error
            Swal.fire({
                icon: "error",
                title: "Error",
                text: datos.mensaje,
>>>>>>> d2a8c3cdb20f7cff9ab25a7a1b6a528ae532b3db
            });
        }

    } catch (error) {
<<<<<<< HEAD
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
=======
        console.log(error);
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "No se pudo conectar con el servidor",
        });
    }
}

//FUNCIÓN PARA BUSCAR PERMISOS
const BuscarPermisos = async () => {
    try {
        const respuesta = await fetch('/clemente_final_capacitaciones_ingSoft3/permisos/buscarAPI');
        const datos = await respuesta.json();

        if (datos.codigo == 1) {
            // Limpiar la tabla
            bodyPermisos.innerHTML = '';

            // Llenar la tabla con los datos
            datos.data.forEach((permiso, index) => {
                bodyPermisos.innerHTML += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${permiso.nombre_permiso}</td>
                        <td>${permiso.descripcion}</td>
                        <td>${permiso.fecha_creacion || 'Sin fecha'}</td>
                        <td>
                            <button class="btn btn-warning btn-sm me-1" 
                                    onclick="EditarPermiso(${permiso.id_permiso}, '${permiso.nombre_permiso}', '${permiso.descripcion}')">
                                <i class="bi bi-pencil"></i> Editar
                            </button>
                            <button class="btn btn-danger btn-sm" 
                                    onclick="EliminarPermiso(${permiso.id_permiso}, '${permiso.nombre_permiso}')">
                                <i class="bi bi-trash"></i> Eliminar
                            </button>
                        </td>
                    </tr>
                `;
            });
        }

    } catch (error) {
        console.log(error);
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "No se pudieron cargar los permisos",
        });
    }
}

// FUNCIÓN PARA MOSTRAR/OCULTAR TABLA
const MostrarTabla = () => {
    if (seccionTabla.style.display === 'none') {
        seccionTabla.style.display = 'block';
        BuscarPermisos();
    } else {
        seccionTabla.style.display = 'none';
    }
}

//FUNCIÓN PARA LIMPIAR FORMULARIO
const LimpiarFormulario = () => {
    FormPermisos.reset();
    BtnGuardar.classList.remove('d-none');
    BtnModificar.classList.add('d-none');
}

//FUNCIÓN PARA EDITAR PERMISO
window.EditarPermiso = (id, nombre, descripcion) => {
    // Llenar el formulario con los datos
    document.getElementById('id_permiso').value = id;
    document.getElementById('nombre_permiso').value = nombre;
    document.getElementById('descripcion').value = descripcion;

    // Cambiar los botones
    BtnGuardar.classList.add('d-none');
    BtnModificar.classList.remove('d-none');

    // Ir arriba de la página
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

//FUNCIÓN PARA MODIFICAR PERMISO
const ModificarPermiso = async () => {
    const formData = new FormData(FormPermisos);
    
    try {
        const respuesta = await fetch('/clemente_final_capacitaciones_ingSoft3/permisos/modificarAPI', {
            method: 'POST',
            body: formData
        });

        const datos = await respuesta.json();

        if (datos.codigo == 1) {
            Swal.fire({
                icon: "success",
                title: "¡Éxito!",
                text: datos.mensaje,
            });
            LimpiarFormulario();
            BuscarPermisos();
        } else {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: datos.mensaje,
            });
        }

    } catch (error) {
        console.log(error);
    }
}

// FUNCIÓN PARA ELIMINAR PERMISO
window.EliminarPermiso = async (id, nombre) => {
    const confirmacion = await Swal.fire({
        title: `¿Eliminar "${nombre}"?`,
        text: "Esta acción no se puede deshacer",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
    });

    if (confirmacion.isConfirmed) {
        try {
            const respuesta = await fetch(`/clemente_final_capacitaciones_ingSoft3/permisos/eliminarAPI?id=${id}`);
            const datos = await respuesta.json();

            if (datos.codigo == 1) {
                Swal.fire({
                    icon: "success",
                    title: "¡Eliminado!",
                    text: datos.mensaje,
                });
                BuscarPermisos();
            }

        } catch (error) {
            console.log(error);
        }
    }
}

//FUNCIONES CON LOS BOTONES
FormPermisos.addEventListener('submit', GuardarPermiso);
BtnLimpiar.addEventListener('click', LimpiarFormulario);
BtnModificar.addEventListener('click', ModificarPermiso);
BtnBuscar.addEventListener('click', MostrarTabla);
>>>>>>> d2a8c3cdb20f7cff9ab25a7a1b6a528ae532b3db
