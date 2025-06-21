import Swal from "sweetalert2";
import { validarFormulario } from '../funciones';
import DataTable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";

const FormInstructor = document.getElementById('FormInstructor');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');
const BtnLimpiar = document.getElementById('BtnLimpiar');
const BtnBuscar = document.getElementById('BtnBuscar');
const SelectUsuario = document.getElementById('instructor_usuario_id');

// Cargar usuarios en el dropdown
const CargarUsuarios = async () => {
    const url = `/clemente_final_capacitaciones_ingSoft3/API/instructor/obtenerUsuarios`;
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

const GuardarInstructor = async (event) => {
    event.preventDefault();
    BtnGuardar.disabled = true;

    if (!validarFormulario(FormInstructor, 
        ['instructor_id', 
          'instructor_fecha_registro', 
          'instructor_situacion'])) {
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

    const body = new FormData(FormInstructor);
    const url = '/clemente_final_capacitaciones_ingSoft3/API/instructor/guardar';
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
            BuscarInstructor();
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

const BuscarInstructor = async () => {
    const url = `/clemente_final_capacitaciones_ingSoft3/API/instructor/buscar`;
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

const datatable = new DataTable('#TableInstructor', {
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
            data: 'instructor_id',
            width: '5%',
            render: (data, type, row, meta) => meta.row + 1
        },
        { 
            title: 'Nombre Completo', 
            data: 'usuario_nom1', 
            width: '25%',
            render: (data, type, row) => {
                return `${row.usuario_nom1 || ''} ${row.usuario_nom2 || ''} ${row.usuario_ape1 || ''} ${row.usuario_ape2 || ''}`.trim();
            }
        },
        { title: 'Grado', data: 'instructor_grado', width: '15%' },
        { title: 'Arma', data: 'instructor_arma', width: '15%' },
        { 
            title: 'Años Servicio', 
            data: 'instructor_anos_servicio', 
            width: '10%',
            render: (data, type, row) => {
                return `${data} años`;
            }
        },
        {
            title: 'Fecha Registro',
            data: 'instructor_fecha_registro',
            width: '15%',
            render: (data, type, row) => {
                if (data) {
                    return new Date(data).toLocaleDateString('es-ES');
                }
                return 'N/A';
            }
        },
        {
            title: 'Acciones',
            data: 'instructor_id',
            searchable: false,
            orderable: false,
            width: '15%',
            render: (data, type, row, meta) => {
                return `
                 <div class='d-flex justify-content-center'>
                     <button class='btn btn-warning modificar mx-1 btn-sm' 
                         data-id="${data}" 
                         data-instructor_usuario_id="${row.instructor_usuario_id || ''}"  
                         data-instructor_grado="${row.instructor_grado || ''}"
                         data-instructor_arma="${row.instructor_arma || ''}"
                         data-instructor_anos_servicio="${row.instructor_anos_servicio || ''}">
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

    document.getElementById('instructor_id').value = datos.id;
    document.getElementById('instructor_usuario_id').value = datos.instructor_usuario_id;
    document.getElementById('instructor_grado').value = datos.instructor_grado;
    document.getElementById('instructor_arma').value = datos.instructor_arma;
    document.getElementById('instructor_anos_servicio').value = datos.instructor_anos_servicio;

    BtnGuardar.classList.add('d-none');
    BtnModificar.classList.remove('d-none');

    window.scrollTo({
        top: 0,
    });
}

const limpiarTodo = () => {
    FormInstructor.reset();
    
    BtnGuardar.classList.remove('d-none');
    BtnModificar.classList.add('d-none');
}

const ModificarInstructor = async (event) => {
    event.preventDefault();
    BtnModificar.disabled = true;

    if (!validarFormulario(FormInstructor, [
        'instructor_id', 
        'instructor_fecha_registro', 
        'instructor_situacion'])) {
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

    const body = new FormData(FormInstructor);
    const url = '/clemente_final_capacitaciones_ingSoft3/API/instructor/modificar';
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
            BuscarInstructor();
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

const EliminarInstructor = async (e) => {
    const idInstructor = e.currentTarget.dataset.id

    const AlertaConfirmarEliminar = await Swal.fire({
        position: "center",
        icon: "question",
        title: "¿Desea eliminar este instructor?",
        text: 'Esta acción no se puede deshacer',
        showConfirmButton: true,
        confirmButtonText: 'Sí, Eliminar',
        confirmButtonColor: '#dc3545',
        cancelButtonText: 'No, Cancelar',
        showCancelButton: true
    });

    if (AlertaConfirmarEliminar.isConfirmed) {
        const url = `/clemente_final_capacitaciones_ingSoft3/API/instructor/eliminar?id=${idInstructor}`;
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
                
                BuscarInstructor();
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

datatable.on('click', '.eliminar', EliminarInstructor);
datatable.on('click', '.modificar', llenarFormulario);
FormInstructor.addEventListener('submit', GuardarInstructor);
BtnLimpiar.addEventListener('click', limpiarTodo);
BtnModificar.addEventListener('click', ModificarInstructor);
BtnBuscar.addEventListener('click', BuscarInstructor);