import Swal from "sweetalert2";
import { validarFormulario } from '../funciones';
import DataTable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";

const FormAsignacion = document.getElementById('FormAsignacion');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');
const BtnLimpiar = document.getElementById('BtnLimpiar');
const BtnBuscar = document.getElementById('BtnBuscar');
const SelectUsuario = document.getElementById('asignacion_usuario_id');
const SelectAplicacion = document.getElementById('asignacion_app_id');
const SelectPermiso = document.getElementById('asignacion_permiso_id');
const SelectUsuarioAsigno = document.getElementById('asignacion_usuario_asigno');

// Cargar usuarios en el dropdown
const CargarUsuarios = async () => {
    const url = `/clemente_final_capacitaciones_ingSoft3/API/asignacionpermisos/obtenerUsuarios`;
    const config = {
        method: 'GET'
    }

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, data } = datos

        if (codigo == 1) {
            // Cargar usuarios para asignar
            SelectUsuario.innerHTML = '<option value="">Seleccione un usuario</option>';
            data.forEach(usuario => {
                const nombreCompleto = `${usuario.usuario_nom1} ${usuario.usuario_nom2 || ''} ${usuario.usuario_ape1} ${usuario.usuario_ape2 || ''}`.trim();
                SelectUsuario.innerHTML += `<option value="${usuario.usuario_id}">${nombreCompleto}</option>`;
            });

            // Cargar usuarios que pueden asignar
            SelectUsuarioAsigno.innerHTML = '<option value="">Seleccione quien asigna</option>';
            data.forEach(usuario => {
                const nombreCompleto = `${usuario.usuario_nom1} ${usuario.usuario_nom2 || ''} ${usuario.usuario_ape1} ${usuario.usuario_ape2 || ''}`.trim();
                SelectUsuarioAsigno.innerHTML += `<option value="${usuario.usuario_id}">${nombreCompleto}</option>`;
            });
        }

    } catch (error) {
        console.log(error)
    }
}

// Cargar aplicaciones en el dropdown
const CargarAplicaciones = async () => {
    const url = `/clemente_final_capacitaciones_ingSoft3/API/asignacionpermisos/obtenerAplicaciones`;
    const config = {
        method: 'GET'
    }

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, data } = datos

        if (codigo == 1) {
            SelectAplicacion.innerHTML = '<option value="">Seleccione una aplicación</option>';
            data.forEach(aplicacion => {
                const nombreCompleto = aplicacion.app_nombre_largo ? 
                    `${aplicacion.app_nombre_corto} - ${aplicacion.app_nombre_largo}` : 
                    aplicacion.app_nombre_corto;
                SelectAplicacion.innerHTML += `<option value="${aplicacion.app_id}">${nombreCompleto}</option>`;
            });
        }

    } catch (error) {
        console.log(error)
    }
}

// Cargar permisos basados en la aplicación seleccionada
const CargarPermisos = async (appId = null) => {
    let url = `/clemente_final_capacitaciones_ingSoft3/API/asignacionpermisos/obtenerPermisos`;
    if (appId) {
        url += `?app_id=${appId}`;
    }
    
    const config = {
        method: 'GET'
    }

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, data } = datos

        if (codigo == 1) {
            SelectPermiso.innerHTML = '<option value="">Seleccione un permiso</option>';
            data.forEach(permiso => {
                SelectPermiso.innerHTML += `<option value="${permiso.permiso_id}">${permiso.permiso_nombre} (${permiso.permiso_clave})</option>`;
            });
        } else {
            SelectPermiso.innerHTML = '<option value="">No hay permisos disponibles</option>';
        }

    } catch (error) {
        console.log(error)
        SelectPermiso.innerHTML = '<option value="">Error al cargar permisos</option>';
    }
}

// Event listener para cuando cambia la aplicación
SelectAplicacion.addEventListener('change', (e) => {
    const appId = e.target.value;
    if (appId) {
        CargarPermisos(appId);
    } else {
        SelectPermiso.innerHTML = '<option value="">Primero seleccione una aplicación</option>';
    }
});

const GuardarAsignacion = async (event) => {
    event.preventDefault();
    BtnGuardar.disabled = true;

    if (!validarFormulario(FormAsignacion, 
        ['asignacion_id', 
          'asignacion_situacion'])) {
        Swal.fire({
            position: "center",
            icon: "info",
            title: "FORMULARIO INCOMPLETO",
            text: "Debe completar todos los campos",
            showConfirmButton: true,
        });
        BtnGuardar.disabled = false;
        return;
    }

    const body = new FormData(FormAsignacion);
    const url = '/clemente_final_capacitaciones_ingSoft3/API/asignacionpermisos/guardar';
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
            BuscarAsignacion();
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
    BtnGuardar.disabled = false;
}

const BuscarAsignacion = async () => {
    const url = `/clemente_final_capacitaciones_ingSoft3/API/asignacionpermisos/buscar`;
    const config = {
        method: 'GET'
    }

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, mensaje, data } = datos

        if (codigo == 1) {
            datatable.clear().draw();
            datatable.rows.add(data).draw();
        } else {
            await Swal.fire({
                position: "center",
                icon: "info",
                title: "Error",
                text: mensaje,
                showConfirmButton: true,
            });
        }

    } catch (error) {
        console.log(error)
    }
}

const datatable = new DataTable('#TableAsignacion', {
    dom: `
        <"row mt-3 justify-content-between" 
            <"col" l> 
            <"col" B> 
            <"col-3" f>
        >
        t
        <"row mt-3 justify-content-between" 
            <"col-md-3 d-flex align-items-center" i> 
            <"col-md-8 d-flex justify-content-end" p>
        >
    `,
    language: lenguaje,
    data: [],
    columns: [
        {
            title: 'No.',
            data: 'asignacion_id',
            width: '5%',
            render: (data, type, row, meta) => meta.row + 1
        },
        { 
            title: 'Usuario', 
            data: 'usuario_nom1', 
            width: '20%',
            render: (data, type, row) => {
                return `${row.usuario_nom1 || ''} ${row.usuario_nom2 || ''} ${row.usuario_ape1 || ''} ${row.usuario_ape2 || ''}`.trim();
            }
        },
        { 
            title: 'Aplicación', 
            data: 'app_nombre_corto', 
            width: '15%',
            render: (data, type, row) => {
                return row.app_nombre_largo ? 
                    `${row.app_nombre_corto} - ${row.app_nombre_largo}` : 
                    row.app_nombre_corto;
            }
        },
        { 
            title: 'Permiso', 
            data: 'permiso_nombre', 
            width: '15%',
            render: (data, type, row) => {
                return `${data} (${row.permiso_clave})`;
            }
        },
        { 
            title: 'Asignado por', 
            data: 'asigno_nom1', 
            width: '15%',
            render: (data, type, row) => {
                return `${row.asigno_nom1 || ''} ${row.asigno_ape1 || ''}`.trim();
            }
        },
        {
            title: 'Fecha',
            data: 'asignacion_fecha',
            width: '10%',
            render: (data, type, row) => {
                if (data) {
                    return new Date(data).toLocaleDateString('es-ES');
                }
                return 'N/A';
            }
        },
        {
            title: 'Acciones',
            data: 'asignacion_id',
            searchable: false,
            orderable: false,
            width: '20%',
            render: (data, type, row, meta) => {
                return `
                 <div class='d-flex justify-content-center'>
                     <button class='btn btn-warning modificar mx-1 btn-sm' 
                         data-id="${data}" 
                         data-asignacion_usuario_id="${row.asignacion_usuario_id || ''}"  
                         data-asignacion_app_id="${row.asignacion_app_id || ''}"
                         data-asignacion_permiso_id="${row.asignacion_permiso_id || ''}"
                         data-asignacion_usuario_asigno="${row.asignacion_usuario_asigno || ''}"
                         data-asignacion_motivo="${row.asignacion_motivo || ''}">
                         <i class='bi bi-pencil-square me-1'></i> Modificar
                     </button>
                     <button class='btn btn-danger eliminar mx-1 btn-sm' 
                         data-id="${data}">
                        <i class="bi bi-trash3 me-1"></i>Eliminar
                     </button>
                 </div>`;
            }
        }
    ]
});

const llenarFormulario = async (event) => {
    const datos = event.currentTarget.dataset;

    document.getElementById('asignacion_id').value = datos.id;
    document.getElementById('asignacion_usuario_id').value = datos.asignacion_usuario_id;
    document.getElementById('asignacion_app_id').value = datos.asignacion_app_id;
    document.getElementById('asignacion_usuario_asigno').value = datos.asignacion_usuario_asigno;
    document.getElementById('asignacion_motivo').value = datos.asignacion_motivo;

    // Cargar permisos para la aplicación seleccionada y luego seleccionar el permiso
    if (datos.asignacion_app_id) {
        await CargarPermisos(datos.asignacion_app_id);
        document.getElementById('asignacion_permiso_id').value = datos.asignacion_permiso_id;
    }

    BtnGuardar.classList.add('d-none');
    BtnModificar.classList.remove('d-none');

    window.scrollTo({
        top: 0,
    });
}

const limpiarTodo = () => {
    FormAsignacion.reset();
    SelectPermiso.innerHTML = '<option value="">Primero seleccione una aplicación</option>';
    
    BtnGuardar.classList.remove('d-none');
    BtnModificar.classList.add('d-none');
}

const ModificarAsignacion = async (event) => {
    event.preventDefault();
    BtnModificar.disabled = true;

    if (!validarFormulario(FormAsignacion, [
        'asignacion_id', 
        'asignacion_situacion'])) {
        Swal.fire({
            position: "center",
            icon: "info",
            title: "FORMULARIO INCOMPLETO",
            text: "Debe completar todos los campos",
            showConfirmButton: true,
        });
        BtnModificar.disabled = false;
        return;
    }

    const body = new FormData(FormAsignacion);
    const url = '/clemente_final_capacitaciones_ingSoft3/API/asignacionpermisos/modificar';
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
            BuscarAsignacion();
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

const EliminarAsignacion = async (e) => {
    const idAsignacion = e.currentTarget.dataset.id

    const AlertaConfirmarEliminar = await Swal.fire({
        position: "center",
        icon: "question",
        title: "¿Desea eliminar esta asignación?",
        text: 'Esta acción no se puede deshacer',
        showConfirmButton: true,
        confirmButtonText: 'Sí, Eliminar',
        confirmButtonColor: '#dc3545',
        cancelButtonText: 'No, Cancelar',
        showCancelButton: true
    });

    if (AlertaConfirmarEliminar.isConfirmed) {
        const url = `/clemente_final_capacitaciones_ingSoft3/API/asignacionpermisos/eliminar?id=${idAsignacion}`;
        const config = {
            method: 'GET'
        }

        try {
            const consulta = await fetch(url, config);
            const respuesta = await consulta.json();
            const { codigo, mensaje } = respuesta;

            if (codigo == 1) {
                await Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "Éxito",
                    text: mensaje,
                    showConfirmButton: true,
                });
                
                BuscarAsignacion();
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
    }
}

// Cargar datos al iniciar
CargarUsuarios();
CargarAplicaciones();

datatable.on('click', '.eliminar', EliminarAsignacion);
datatable.on('click', '.modificar', llenarFormulario);
FormAsignacion.addEventListener('submit', GuardarAsignacion);
BtnLimpiar.addEventListener('click', limpiarTodo);
BtnModificar.addEventListener('click', ModificarAsignacion);
BtnBuscar.addEventListener('click', BuscarAsignacion);