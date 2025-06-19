import Swal from "sweetalert2";
import { validarFormulario } from '../funciones';
import DataTable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";

const FormAsignacionPermisos = document.getElementById('FormAsignacionPermisos');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');
const BtnLimpiar = document.getElementById('BtnLimpiar');
const BtnBuscar = document.getElementById('BtnBuscar');
const BtnVerPermisos = document.getElementById('BtnVerPermisos');
const seccionPermisosUsuario = document.getElementById('seccionPermisosUsuario');

let datatable, datatablePermisos;

const GuardarAsignacion = async (event) => {
    event.preventDefault();
    BtnGuardar.disabled = true;

    if (!validarFormulario(FormAsignacionPermisos, ['asignacion_id'])) {
        Swal.fire({
            position: "center",
            icon: "info",
            title: "FORMULARIO INCOMPLETO",
            text: "Debe completar los campos obligatorios",
            showConfirmButton: true,
        });
        BtnGuardar.disabled = false;
        return;
    }

    const body = new FormData(FormAsignacionPermisos);
    body.append('asignacion_usuario_asigno', 1); 
    
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
            BuscarAsignaciones();
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

const CargarUsuarios = async () => {
    try {
        const respuesta = await fetch('/clemente_final_capacitaciones_ingSoft3/API/asignacionpermisos/buscarUsuarios');
        const datos = await respuesta.json();
        
        if (datos.codigo === 1) {
            const selectUsuario = document.getElementById('asignacion_usuario_id');
            const selectAsigno = document.getElementById('asignacion_usuario_asigno');
            const filtroUsuario = document.getElementById('filtroUsuario');
            
            selectUsuario.innerHTML = '<option value="">Seleccione un usuario</option>';
            selectAsigno.innerHTML = '<option value="">Seleccione quién asigna</option>';
            filtroUsuario.innerHTML = '<option value="">Seleccione un usuario para ver sus permisos</option>';
            
            datos.data.forEach(usuario => {
                const option = `<option value="${usuario.usuario_id}">${usuario.usuario_nom1} ${usuario.usuario_ape1}</option>`;
                selectUsuario.innerHTML += option;
                selectAsigno.innerHTML += option;
                filtroUsuario.innerHTML += option;
            });
        }
    } catch (error) {
        console.log(error);
    }
}

const CargarAplicaciones = async () => {
    try {
        const respuesta = await fetch('/clemente_final_capacitaciones_ingSoft3/API/asignacionpermisos/buscarAplicaciones');
        const datos = await respuesta.json();
        
        if (datos.codigo === 1) {
            const selectAplicacion = document.getElementById('asignacion_app_id');
            selectAplicacion.innerHTML = '<option value="">Seleccione una aplicación</option>';
            
            datos.data.forEach(aplicacion => {
                const option = `<option value="${aplicacion.app_id}">${aplicacion.app_nombre_corto}</option>`;
                selectAplicacion.innerHTML += option;
            });
        }
    } catch (error) {
        console.log(error);
    }
}

const CargarPermisos = async (appId) => {
    try {
        const respuesta = await fetch(`/clemente_final_capacitaciones_ingSoft3/API/asignacionpermisos/buscarPermisos?app_id=${appId}`);
        const datos = await respuesta.json();
        
        if (datos.codigo === 1) {
            const selectPermiso = document.getElementById('asignacion_permiso_id');
            selectPermiso.innerHTML = '<option value="">Seleccione un permiso</option>';
            
            datos.data.forEach(permiso => {
                const option = `<option value="${permiso.permiso_id}">${permiso.permiso_nombre} (${permiso.permiso_clave})</option>`;
                selectPermiso.innerHTML += option;
            });
        }
    } catch (error) {
        console.log(error);
    }
}

const BuscarAsignaciones = async () => {
    const url = `/clemente_final_capacitaciones_ingSoft3/API/asignacionpermisos/buscar`;
    const config = {
        method: 'GET'
    }

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, mensaje, data } = datos

        if (codigo == 1) {
            if (!datatable) {
                initializeDataTable();
            }
            datatable.clear().draw();
            datatable.rows.add(data).draw();
        } else {
            await Swal.fire({
                position: "center",
                icon: "info",
                title: "Info",
                text: mensaje,
                showConfirmButton: true,
            });
        }

    } catch (error) {
        console.log(error)
    }
}

const initializeDataTable = () => {
    datatable = new DataTable('#TableAsignacionPermisos', {
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
                width: '15%',
                render: (data, type, row) => `${row.usuario_nom1} ${row.usuario_ape1}`
            },
            { 
                title: 'Aplicación', 
                data: 'app_nombre_corto', 
                width: '15%' 
            },
            { 
                title: 'Permiso', 
                data: 'permiso_nombre', 
                width: '20%' 
            },
            { 
                title: 'Clave', 
                data: 'permiso_clave', 
                width: '10%' 
            },
            { 
                title: 'Fecha Asignación', 
                data: 'asignacion_fecha', 
                width: '10%',
                render: (data) => {
                    if(data) {
                        const fecha = new Date(data);
                        return fecha.toLocaleDateString('es-GT');
                    }
                    return '';
                }
            },
            { 
                title: 'Asignado por', 
                data: 'asigno_nom1', 
                width: '15%',
                render: (data, type, row) => `${row.asigno_nom1} ${row.asigno_ape1}`
            },
            {
                title: 'Acciones',
                data: 'asignacion_id',
                searchable: false,
                orderable: false,
                width: '10%',
                render: (data, type, row, meta) => {
                    return `
                     <div class='d-flex justify-content-center'>
                         <button class='btn btn-danger revocar mx-1 btn-sm' 
                             data-id="${data}">
                            <i class="bi bi-x-circle me-1"></i>Revocar
                         </button>
                     </div>`;
                }
            }
        ]
    });

    datatable.on('click', '.revocar', RevocarPermiso);
}

const RevocarPermiso = async (e) => {
    const idAsignacion = e.currentTarget.dataset.id

    const AlertaConfirmarRevocacion = await Swal.fire({
        position: "center",
        icon: "question",
        title: "¿Desea revocar este permiso?",
        text: 'Esta acción no se puede deshacer',
        showConfirmButton: true,
        confirmButtonText: 'Sí, Revocar',
        confirmButtonColor: '#dc3545',
        cancelButtonText: 'No, Cancelar',
        showCancelButton: true
    });

    if (AlertaConfirmarRevocacion.isConfirmed) {
        const url = `/clemente_final_capacitaciones_ingSoft3/API/asignacionpermisos/revocar?id=${idAsignacion}`;
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
                
                BuscarAsignaciones();
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

const mostrarPermisosUsuario = () => {
    if (seccionPermisosUsuario.style.display === 'none') {
        seccionPermisosUsuario.style.display = 'block';
        BtnVerPermisos.textContent = 'Ocultar Permisos';
        
        if (!datatablePermisos) {
            initializePermisosTable();
        }
    } else {
        seccionPermisosUsuario.style.display = 'none';
        BtnVerPermisos.textContent = 'Ver Permisos por Usuario';
    }
}

const initializePermisosTable = () => {
    datatablePermisos = new DataTable('#TablePermisosUsuario', {
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
                data: 'permiso_id',
                width: '10%',
                render: (data, type, row, meta) => meta.row + 1
            },
            { 
                title: 'Aplicación', 
                data: 'app_nombre_corto', 
                width: '20%' 
            },
            { 
                title: 'Permiso', 
                data: 'permiso_nombre', 
                width: '30%' 
            },
            { 
                title: 'Clave', 
                data: 'permiso_clave', 
                width: '20%' 
            },
            { 
                title: 'Fecha Asignación', 
                data: 'asignacion_fecha', 
                width: '20%',
                render: (data) => {
                    if(data) {
                        const fecha = new Date(data);
                        return fecha.toLocaleDateString('es-GT');
                    }
                    return '';
                }
            }
        ]
    });
}

const buscarPermisosUsuario = async (usuarioId) => {
    if (!usuarioId) {
        datatablePermisos.clear().draw();
        return;
    }

    try {
        const respuesta = await fetch(`/clemente_final_capacitaciones_ingSoft3/API/asignacionpermisos/buscarPermisosUsuario?usuario_id=${usuarioId}`);
        const datos = await respuesta.json();
        
        if (datos.codigo === 1) {
            datatablePermisos.clear().draw();
            datatablePermisos.rows.add(datos.data).draw();
        }
    } catch (error) {
        console.log(error);
    }
}

const limpiarTodo = () => {
    FormAsignacionPermisos.reset();
    document.getElementById('asignacion_id').value = '';
    document.getElementById('asignacion_permiso_id').innerHTML = '<option value="">Seleccione primero una aplicación</option>';
    BtnGuardar.classList.remove('d-none');
    BtnModificar.classList.add('d-none');
}


document.getElementById('asignacion_app_id').addEventListener('change', (e) => {
    if (e.target.value) {
        CargarPermisos(e.target.value);
    } else {
        document.getElementById('asignacion_permiso_id').innerHTML = '<option value="">Seleccione primero una aplicación</option>';
    }
});

document.getElementById('filtroUsuario').addEventListener('change', (e) => {
    buscarPermisosUsuario(e.target.value);
});

FormAsignacionPermisos.addEventListener('submit', GuardarAsignacion);
BtnLimpiar.addEventListener('click', limpiarTodo);
BtnBuscar.addEventListener('click', BuscarAsignaciones);
BtnVerPermisos.addEventListener('click', mostrarPermisosUsuario);


CargarUsuarios();
CargarAplicaciones();
BuscarAsignaciones();