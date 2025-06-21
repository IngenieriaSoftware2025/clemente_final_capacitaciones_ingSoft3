import Swal from "sweetalert2";
import { validarFormulario } from '../funciones';
import DataTable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";

const FormPermiso = document.getElementById('FormPermiso');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');
const BtnLimpiar = document.getElementById('BtnLimpiar');
const BtnBuscar = document.getElementById('BtnBuscar');
const SelectUsuario = document.getElementById('usuario_id');
const SelectAplicacion = document.getElementById('app_id');

// Cargar usuarios en el dropdown
const CargarUsuarios = async () => {
    const url = `/clemente_final_capacitaciones_ingSoft3/API/permisos/obtenerUsuarios`;
    const config = {
        method: 'GET'
    }

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, data } = datos

        if (codigo == 1) {
            SelectUsuario.innerHTML = '<option value="">Seleccione un usuario</option>';
            data.forEach(usuario => {
                SelectUsuario.innerHTML += `<option value="${usuario.usuario_id}">${usuario.usuario_nom1} ${usuario.usuario_nom2 || ''} ${usuario.usuario_ape1} ${usuario.usuario_ape2 || ''}</option>`;
            });
        }

    } catch (error) {
        console.log(error)
    }
}

// Cargar aplicaciones en el dropdown
const CargarAplicaciones = async () => {
    const url = `/clemente_final_capacitaciones_ingSoft3/API/permisos/obtenerAplicaciones`;
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

const GuardarPermiso = async (event) => {
    event.preventDefault();
    BtnGuardar.disabled = true;

    if (!validarFormulario(FormPermiso, 
        ['permiso_id', 
          'permiso_situacion'])) {
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

    const body = new FormData(FormPermiso);
    const url = '/clemente_final_capacitaciones_ingSoft3/API/permisos/guardar';
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
            BuscarPermiso();
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

const BuscarPermiso = async () => {
    const url = `/clemente_final_capacitaciones_ingSoft3/API/permisos/buscar`;
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

const datatable = new DataTable('#TablePermiso', {
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
        { title: 'Nombre', data: 'permiso_nombre', width: '15%' },
        { title: 'Clave', data: 'permiso_clave', width: '10%' },
        { title: 'Tipo', data: 'permiso_tipo', width: '10%' },
        {
            title: 'Fecha',
            data: 'permiso_fecha',
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
            data: 'permiso_id',
            searchable: false,
            orderable: false,
            width: '15%',
            render: (data, type, row, meta) => {
                return `
                 <div class='d-flex justify-content-center'>
                     <button class='btn btn-warning modificar mx-1 btn-sm' 
                         data-id="${data}" 
                         data-usuario_id="${row.usuario_id || ''}"  
                         data-app_id="${row.app_id || ''}"
                         data-permiso_nombre="${row.permiso_nombre || ''}"
                         data-permiso_clave="${row.permiso_clave || ''}"
                         data-permiso_desc="${row.permiso_desc || ''}"
                         data-permiso_motivo="${row.permiso_motivo || ''}"
                         data-permiso_tipo="${row.permiso_tipo || ''}">
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

const llenarFormulario = (event) => {
    const datos = event.currentTarget.dataset;

    document.getElementById('permiso_id').value = datos.id;
    document.getElementById('usuario_id').value = datos.usuario_id;
    document.getElementById('app_id').value = datos.app_id;
    document.getElementById('permiso_nombre').value = datos.permiso_nombre;
    document.getElementById('permiso_clave').value = datos.permiso_clave;
    document.getElementById('permiso_desc').value = datos.permiso_desc;
    document.getElementById('permiso_motivo').value = datos.permiso_motivo;
    document.getElementById('permiso_tipo').value = datos.permiso_tipo;

    BtnGuardar.classList.add('d-none');
    BtnModificar.classList.remove('d-none');

    window.scrollTo({
        top: 0,
    });
}

const limpiarTodo = () => {
    FormPermiso.reset();
    
    BtnGuardar.classList.remove('d-none');
    BtnModificar.classList.add('d-none');
}

const ModificarPermiso = async (event) => {
    event.preventDefault();
    BtnModificar.disabled = true;

    if (!validarFormulario(FormPermiso, [
        'permiso_id', 
        'permiso_situacion'])) {
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

    const body = new FormData(FormPermiso);
    const url = '/clemente_final_capacitaciones_ingSoft3/API/permisos/modificar';
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
            BuscarPermiso();
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

const EliminarPermiso = async (e) => {
    const idPermiso = e.currentTarget.dataset.id

    const AlertaConfirmarEliminar = await Swal.fire({
        position: "center",
        icon: "question",
        title: "¿Desea eliminar este permiso?",
        text: 'Esta acción no se puede deshacer',
        showConfirmButton: true,
        confirmButtonText: 'Sí, Eliminar',
        confirmButtonColor: '#dc3545',
        cancelButtonText: 'No, Cancelar',
        showCancelButton: true
    });

    if (AlertaConfirmarEliminar.isConfirmed) {
        const url = `/clemente_final_capacitaciones_ingSoft3/API/permisos/eliminar?id=${idPermiso}`;
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
                
                BuscarPermiso();
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

datatable.on('click', '.eliminar', EliminarPermiso);
datatable.on('click', '.modificar', llenarFormulario);
FormPermiso.addEventListener('submit', GuardarPermiso);
BtnLimpiar.addEventListener('click', limpiarTodo);
BtnModificar.addEventListener('click', ModificarPermiso);
BtnBuscar.addEventListener('click', BuscarPermiso);