import Swal from "sweetalert2";
import { validarFormulario } from '../funciones';
import DataTable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";

const FormCapacitacion = document.getElementById('FormCapacitacion');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');
const BtnLimpiar = document.getElementById('BtnLimpiar');
const BtnBuscar = document.getElementById('BtnBuscar');
const SelectUsuario = document.getElementById('capacitacion_usuario_creo');


const CargarUsuarios = async () => {
    const url = `/clemente_final_capacitaciones_ingSoft3/API/capacitacion/obtenerUsuarios`;
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
                SelectUsuario.innerHTML += `<option value="${usuario.usuario_id}">${usuario.usuario_nom1} ${usuario.usuario_ape1}</option>`;
            });
        }

    } catch (error) {
        console.log(error)
    }
}

const GuardarCapacitacion = async (event) => {
    event.preventDefault();
    BtnGuardar.disabled = true;

    if (!validarFormulario(FormCapacitacion, 
        ['capacitacion_id', 
          'capacitacion_fecha_creacion', 
          'capacitacion_situacion'])) {
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

    const body = new FormData(FormCapacitacion);
    const url = '/clemente_final_capacitaciones_ingSoft3/API/capacitacion/guardar';
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
            BuscarCapacitacion();
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

const BuscarCapacitacion = async () => {
    const url = `/clemente_final_capacitaciones_ingSoft3/API/capacitacion/buscar`;
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

const datatable = new DataTable('#TableCapacitacion', {
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
            data: 'capacitacion_id',
            width: '5%',
            render: (data, type, row, meta) => meta.row + 1
        },
        { title: 'Nombre', data: 'capacitacion_nombre', width: '20%' },
        { title: 'Descripción', data: 'capacitacion_descripcion', width: '25%' },
        { 
            title: 'Duración (Hrs)', 
            data: 'capacitacion_duracion_horas', 
            width: '10%',
            render: (data, type, row) => {
                return `${data} hrs`;
            }
        },
        { title: 'Objetivos', data: 'capacitacion_objetivos', width: '25%' },
        { 
            title: 'Creado por', 
            data: 'usuario_nom1', 
            width: '10%',
            render: (data, type, row) => {
                return `${row.usuario_nom1 || ''} ${row.usuario_ape1 || ''}`;
            }
        },
        {
            title: 'Acciones',
            data: 'capacitacion_id',
            searchable: false,
            orderable: false,
            width: '5%',
            render: (data, type, row, meta) => {
                return `
                 <div class='d-flex justify-content-center'>
                     <button class='btn btn-warning modificar mx-1 btn-sm' 
                         data-id="${data}" 
                         data-capacitacion_nombre="${row.capacitacion_nombre || ''}"  
                         data-capacitacion_descripcion="${row.capacitacion_descripcion || ''}"
                         data-capacitacion_duracion_horas="${row.capacitacion_duracion_horas || ''}"
                         data-capacitacion_objetivos="${row.capacitacion_objetivos || ''}"
                         data-capacitacion_usuario_creo="${row.capacitacion_usuario_creo || ''}">
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

    document.getElementById('capacitacion_id').value = datos.id;
    document.getElementById('capacitacion_nombre').value = datos.capacitacion_nombre;
    document.getElementById('capacitacion_descripcion').value = datos.capacitacion_descripcion;
    document.getElementById('capacitacion_duracion_horas').value = datos.capacitacion_duracion_horas;
    document.getElementById('capacitacion_objetivos').value = datos.capacitacion_objetivos;
    document.getElementById('capacitacion_usuario_creo').value = datos.capacitacion_usuario_creo;

    BtnGuardar.classList.add('d-none');
    BtnModificar.classList.remove('d-none');

    window.scrollTo({
        top: 0,
    });
}

const limpiarTodo = () => {
    FormCapacitacion.reset();
    
    BtnGuardar.classList.remove('d-none');
    BtnModificar.classList.add('d-none');
}

const ModificarCapacitacion = async (event) => {
    event.preventDefault();
    BtnModificar.disabled = true;

    if (!validarFormulario(FormCapacitacion, [
        'capacitacion_id', 
        'capacitacion_fecha_creacion', 
        'capacitacion_situacion'])) {
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

    const body = new FormData(FormCapacitacion);
    const url = '/clemente_final_capacitaciones_ingSoft3/API/capacitacion/modificar';
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
            BuscarCapacitacion();
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

const EliminarCapacitacion = async (e) => {
    const idCapacitacion = e.currentTarget.dataset.id

    const AlertaConfirmarEliminar = await Swal.fire({
        position: "center",
        icon: "question",
        title: "¿Desea eliminar esta capacitación?",
        text: 'Esta acción no se puede deshacer',
        showConfirmButton: true,
        confirmButtonText: 'Sí, Eliminar',
        confirmButtonColor: '#dc3545',
        cancelButtonText: 'No, Cancelar',
        showCancelButton: true
    });

    if (AlertaConfirmarEliminar.isConfirmed) {
        const url = `/clemente_final_capacitaciones_ingSoft3/API/capacitacion/eliminar?id=${idCapacitacion}`;
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
                
                BuscarCapacitacion();
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

CargarUsuarios();

datatable.on('click', '.eliminar', EliminarCapacitacion);
datatable.on('click', '.modificar', llenarFormulario);
FormCapacitacion.addEventListener('submit', GuardarCapacitacion);
BtnLimpiar.addEventListener('click', limpiarTodo);
BtnModificar.addEventListener('click', ModificarCapacitacion);
BtnBuscar.addEventListener('click', BuscarCapacitacion);