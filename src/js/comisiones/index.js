import Swal from "sweetalert2";
import { validarFormulario } from '../funciones';
import DataTable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";

const FormComisiones = document.getElementById('FormComisiones');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');
const BtnLimpiar = document.getElementById('BtnLimpiar');
const BtnBuscar = document.getElementById('BtnBuscar');

const GuardarComision = async (event) => {
    event.preventDefault();
    BtnGuardar.disabled = true;

    if (!validarFormulario(FormComisiones, ['comision_id'])) {
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

    const body = new FormData(FormComisiones);
    body.append('comision_usuario_creo', 1); // ID del usuario actual
    
    const url = '/clemente_final_capacitaciones_ingSoft3/comisiones/guardarAPI';
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
            BuscarComisiones();
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

const BuscarComisiones = async () => {
    const url = `/clemente_final_capacitaciones_ingSoft3/comisiones/buscarAPI`;
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
                title: "Info",
                text: mensaje,
                showConfirmButton: true,
            });
        }

    } catch (error) {
        console.log(error)
    }
}

const datatable = new DataTable('#TableComisiones', {
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
            data: 'comision_id',
            width: '5%',
            render: (data, type, row, meta) => meta.row + 1
        },
        { 
            title: 'Título', 
            data: 'comision_titulo', 
            width: '20%' 
        },
        { 
            title: 'Tipo', 
            data: 'comision_tipo', 
            width: '10%',
            render: (data) => {
                const badge = data === 'TRANSMISIONES' ? 'bg-primary' : 'bg-info';
                return `<span class="badge ${badge}">${data}</span>`;
            }
        },
        { 
            title: 'Fecha Inicio', 
            data: 'comision_fecha_inicio', 
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
            title: 'Duración', 
            data: 'comision_duracion', 
            width: '10%',
            render: (data, type, row) => `${data} ${row.comision_duracion_tipo}`
        },
        { 
            title: 'Ubicación', 
            data: 'comision_ubicacion', 
            width: '15%' 
        },
        { 
            title: 'Estado', 
            data: 'comision_estado', 
            width: '10%',
            render: (data) => {
                let badge = 'bg-secondary';
                switch(data) {
                    case 'PROGRAMADA':
                        badge = 'bg-warning';
                        break;
                    case 'EN_CURSO':
                        badge = 'bg-primary';
                        break;
                    case 'COMPLETADA':
                        badge = 'bg-success';
                        break;
                    case 'CANCELADA':
                        badge = 'bg-danger';
                        break;
                }
                return `<span class="badge ${badge}">${data}</span>`;
            }
        },
        { 
            title: 'Creado por', 
            data: 'usuario_nom1', 
            width: '10%',
            render: (data, type, row) => `${row.usuario_nom1} ${row.usuario_ape1}`
        },
        {
            title: 'Acciones',
            data: 'comision_id',
            searchable: false,
            orderable: false,
            width: '10%',
            render: (data, type, row, meta) => {
                return `
                 <div class='d-flex justify-content-center'>
                     <button class='btn btn-warning modificar mx-1 btn-sm' 
                         data-id="${data}" 
                         data-titulo="${row.comision_titulo}"
                         data-descripcion="${row.comision_descripcion}"
                         data-tipo="${row.comision_tipo}"
                         data-fecha-inicio="${row.comision_fecha_inicio}"
                         data-duracion="${row.comision_duracion}"
                         data-duracion-tipo="${row.comision_duracion_tipo}"
                         data-ubicacion="${row.comision_ubicacion}"
                         data-observaciones="${row.comision_observaciones}"
                         data-estado="${row.comision_estado}">
                         <i class='bi bi-pencil-square me-1'></i> Editar
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

    document.getElementById('comision_id').value = datos.id;
    document.getElementById('comision_titulo').value = datos.titulo;
    document.getElementById('comision_descripcion').value = datos.descripcion;
    document.getElementById('comision_tipo').value = datos.tipo;
    document.getElementById('comision_fecha_inicio').value = datos.fechaInicio;
    document.getElementById('comision_duracion').value = datos.duracion;
    document.getElementById('comision_duracion_tipo').value = datos.duracionTipo;
    document.getElementById('comision_ubicacion').value = datos.ubicacion;
    document.getElementById('comision_observaciones').value = datos.observaciones;
    document.getElementById('comision_estado').value = datos.estado;

    BtnGuardar.classList.add('d-none');
    BtnModificar.classList.remove('d-none');

    window.scrollTo({ top: 0 });
}

const limpiarTodo = () => {
    FormComisiones.reset();
    document.getElementById('comision_id').value = '';
    BtnGuardar.classList.remove('d-none');
    BtnModificar.classList.add('d-none');
}

const ModificarComision = async (event) => {
    event.preventDefault();
    BtnModificar.disabled = true;

    if (!validarFormulario(FormComisiones, ['comision_id'])) {
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

    const body = new FormData(FormComisiones);
    const url = '/clemente_final_capacitaciones_ingSoft3/comisiones/modificarAPI';
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
            BuscarComisiones();
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

const EliminarComision = async (e) => {
    const idComision = e.currentTarget.dataset.id

    const AlertaConfirmarEliminar = await Swal.fire({
        position: "center",
        icon: "question",
        title: "¿Desea eliminar esta comisión?",
        text: 'Esta acción no se puede deshacer',
        showConfirmButton: true,
        confirmButtonText: 'Sí, Eliminar',
        confirmButtonColor: '#dc3545',
        cancelButtonText: 'No, Cancelar',
        showCancelButton: true
    });

    if (AlertaConfirmarEliminar.isConfirmed) {
        const url = `/clemente_final_capacitaciones_ingSoft3/comisiones/eliminarAPI?id=${idComision}`;
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
                
                BuscarComisiones();
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

BuscarComisiones();

datatable.on('click', '.eliminar', EliminarComision);
datatable.on('click', '.modificar', llenarFormulario);
FormComisiones.addEventListener('submit', GuardarComision);
BtnLimpiar.addEventListener('click', limpiarTodo);
BtnModificar.addEventListener('click', ModificarComision);
BtnBuscar.addEventListener('click', BuscarComisiones);