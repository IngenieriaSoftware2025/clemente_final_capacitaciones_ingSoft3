import Swal from "sweetalert2";
import { validarFormulario } from '../funciones';
import DataTable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";

const FormEntrenamiento = document.getElementById('FormEntrenamiento');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');
const BtnLimpiar = document.getElementById('BtnLimpiar');
const BtnBuscar = document.getElementById('BtnBuscar');


const obtenerCapacitaciones = async () => {
    try {
        const url = '/clemente_final_capacitaciones_ingSoft3/API/horarioentrenamiento/obtenerCapacitaciones';
        const respuesta = await fetch(url);
        const datos = await respuesta.json();
        
        if (datos.codigo == 1) {
            const select = document.getElementById('entrenamiento_capacitacion_id');
            select.innerHTML = '<option value="">Seleccione una capacitación</option>';
            
            datos.data.forEach(capacitacion => {
                const option = document.createElement('option');
                option.value = capacitacion.capacitacion_id;
                option.textContent = capacitacion.capacitacion_nombre;
                select.appendChild(option);
            });
        }
    } catch (error) {
        console.log('Error al obtener capacitaciones:', error);
    }
}

const obtenerCompanias = async () => {
    try {
        const url = '/clemente_final_capacitaciones_ingSoft3/API/horarioentrenamiento/obtenerCompanias';
        const respuesta = await fetch(url);
        const datos = await respuesta.json();
        
        if (datos.codigo == 1) {
            const select = document.getElementById('entrenamiento_compania_id');
            select.innerHTML = '<option value="">Seleccione una compañía</option>';
            
            datos.data.forEach(compania => {
                const option = document.createElement('option');
                option.value = compania.app_id;
                option.textContent = compania.app_nombre_largo;
                select.appendChild(option);
            });
        }
    } catch (error) {
        console.log('Error al obtener compañías:', error);
    }
}

const obtenerInstructores = async () => {
    try {
        const url = '/clemente_final_capacitaciones_ingSoft3/API/horarioentrenamiento/obtenerInstructores';
        const respuesta = await fetch(url);
        const datos = await respuesta.json();
        
        if (datos.codigo == 1) {
            const select = document.getElementById('entrenamiento_instructor_id');
            select.innerHTML = '<option value="">Seleccione un instructor</option>';
            
            datos.data.forEach(instructor => {
                const option = document.createElement('option');
                option.value = instructor.instructor_id;
                option.textContent = instructor.instructor_nombre;
                select.appendChild(option);
            });
        }
    } catch (error) {
        console.log('Error al obtener instructores:', error);
    }
}

const obtenerAreas = async () => {
    try {
        const url = '/clemente_final_capacitaciones_ingSoft3/API/horarioentrenamiento/obtenerAreas';
        const respuesta = await fetch(url);
        const datos = await respuesta.json();
        
        if (datos.codigo == 1) {
            const select = document.getElementById('entrenamiento_area_id');
            select.innerHTML = '<option value="">Seleccione un área</option>';
            
            datos.data.forEach(area => {
                const option = document.createElement('option');
                option.value = area.area_id;
                option.textContent = area.area_nombre;
                select.appendChild(option);
            });
        }
    } catch (error) {
        console.log('Error al obtener áreas:', error);
    }
}

const GuardarEntrenamiento = async (event) => {
    event.preventDefault();
    BtnGuardar.disabled = true;

    if (!validarFormulario(FormEntrenamiento, ['entrenamiento_id', 'entrenamiento_usuario_creo', 'entrenamiento_situacion', 'entrenamiento_observaciones'])) {
        Swal.fire({
            position: "center",
            icon: "info",
            title: "FORMULARIO INCOMPLETO",
            text: "Debe completar todos los campos obligatorios",
            showConfirmButton: true,
        });
        BtnGuardar.disabled = false;
        return;
    }

    const body = new FormData(FormEntrenamiento);
    const url = '/clemente_final_capacitaciones_ingSoft3/API/horarioentrenamiento/guardar';
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
            BuscarEntrenamientos();
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

const BuscarEntrenamientos = async () => {
    const url = `/clemente_final_capacitaciones_ingSoft3/API/horarioentrenamiento/buscar`;
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

const datatable = new DataTable('#TableEntrenamiento', {
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
            data: 'entrenamiento_id',
            width: '3%',
            render: (data, type, row, meta) => meta.row + 1
        },
        { title: 'Capacitación', data: 'capacitacion_nombre', width: '15%' },
        { title: 'Compañía', data: 'compania_nombre', width: '12%' },
        { title: 'Instructor', data: 'instructor_nombre', width: '12%' },
        { title: 'Área', data: 'area_nombre', width: '10%' },
        { 
            title: 'Fecha Inicio', 
            data: 'entrenamiento_fecha_inicio', 
            width: '10%',
            render: (data) => {
                if (data) {
                    const fecha = new Date(data);
                    return fecha.toLocaleDateString('es-ES') + ' ' + fecha.toLocaleTimeString('es-ES', {hour: '2-digit', minute:'2-digit'});
                }
                return '';
            }
        },
        { 
            title: 'Fecha Fin', 
            data: 'entrenamiento_fecha_fin', 
            width: '10%',
            render: (data) => {
                if (data) {
                    const fecha = new Date(data);
                    return fecha.toLocaleDateString('es-ES') + ' ' + fecha.toLocaleTimeString('es-ES', {hour: '2-digit', minute:'2-digit'});
                }
                return '';
            }
        },
        { 
            title: 'Estado', 
            data: 'entrenamiento_estado', 
            width: '8%',
            render: (data) => {
                let badgeClass = 'bg-secondary';
                switch(data) {
                    case 'PROGRAMADO': badgeClass = 'bg-primary'; break;
                    case 'EN_CURSO': badgeClass = 'bg-warning text-dark'; break;
                    case 'COMPLETADO': badgeClass = 'bg-success'; break;
                    case 'CANCELADO': badgeClass = 'bg-danger'; break;
                }
                return `<span class="badge ${badgeClass}">${data}</span>`;
            }
        },
        { title: 'Creado por', data: 'usuario_creo_nombre', width: '10%' },
        {
            title: 'Acciones',
            data: 'entrenamiento_id',
            searchable: false,
            orderable: false,
            width: '10%',
            render: (data, type, row, meta) => {
                const fechaInicio = row.entrenamiento_fecha_inicio ? new Date(row.entrenamiento_fecha_inicio).toISOString().slice(0, 16) : '';
                const fechaFin = row.entrenamiento_fecha_fin ? new Date(row.entrenamiento_fecha_fin).toISOString().slice(0, 16) : '';
                
                return `
                 <div class='d-flex justify-content-center'>
                     <button class='btn btn-warning modificar mx-1 btn-sm' 
                         data-id="${data}" 
                         data-entrenamiento_capacitacion_id="${row.entrenamiento_capacitacion_id || ''}"  
                         data-entrenamiento_compania_id="${row.entrenamiento_compania_id || ''}"  
                         data-entrenamiento_instructor_id="${row.entrenamiento_instructor_id || ''}"  
                         data-entrenamiento_area_id="${row.entrenamiento_area_id || ''}"  
                         data-entrenamiento_fecha_inicio="${fechaInicio}"  
                         data-entrenamiento_fecha_fin="${fechaFin}"  
                         data-entrenamiento_estado="${row.entrenamiento_estado || ''}"  
                         data-entrenamiento_observaciones="${row.entrenamiento_observaciones || ''}">
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

    document.getElementById('entrenamiento_id').value = datos.id;
    document.getElementById('entrenamiento_capacitacion_id').value = datos.entrenamiento_capacitacion_id;
    document.getElementById('entrenamiento_compania_id').value = datos.entrenamiento_compania_id;
    document.getElementById('entrenamiento_instructor_id').value = datos.entrenamiento_instructor_id;
    document.getElementById('entrenamiento_area_id').value = datos.entrenamiento_area_id;
    document.getElementById('entrenamiento_fecha_inicio').value = datos.entrenamiento_fecha_inicio;
    document.getElementById('entrenamiento_fecha_fin').value = datos.entrenamiento_fecha_fin;
    document.getElementById('entrenamiento_estado').value = datos.entrenamiento_estado;
    document.getElementById('entrenamiento_observaciones').value = datos.entrenamiento_observaciones;

    BtnGuardar.classList.add('d-none');
    BtnModificar.classList.remove('d-none');

    window.scrollTo({
        top: 0,
    });
}

const limpiarTodo = () => {
    FormEntrenamiento.reset();
    
    BtnGuardar.classList.remove('d-none');
    BtnModificar.classList.add('d-none');
}

const ModificarEntrenamiento = async (event) => {
    event.preventDefault();
    BtnModificar.disabled = true;

    if (!validarFormulario(FormEntrenamiento, ['entrenamiento_id', 'entrenamiento_usuario_creo', 'entrenamiento_situacion', 'entrenamiento_observaciones'])) {
        Swal.fire({
            position: "center",
            icon: "info",
            title: "FORMULARIO INCOMPLETO",
            text: "Debe completar todos los campos obligatorios",
            showConfirmButton: true,
        });
        BtnModificar.disabled = false;
        return;
    }

    const body = new FormData(FormEntrenamiento);
    const url = '/clemente_final_capacitaciones_ingSoft3/API/horarioentrenamiento/modificar';
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
            BuscarEntrenamientos();
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

const EliminarEntrenamiento = async (e) => {
    const idEntrenamiento = e.currentTarget.dataset.id

    const AlertaConfirmarEliminar = await Swal.fire({
        position: "center",
        icon: "question",
        title: "¿Desea eliminar este entrenamiento?",
        text: 'Esta acción no se puede deshacer',
        showConfirmButton: true,
        confirmButtonText: 'Sí, Eliminar',
        confirmButtonColor: '#dc3545',
        cancelButtonText: 'No, Cancelar',
        showCancelButton: true
    });

    if (AlertaConfirmarEliminar.isConfirmed) {
        const url = `/clemente_final_capacitaciones_ingSoft3/API/horarioentrenamiento/eliminar?id=${idEntrenamiento}`;
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
                
                BuscarEntrenamientos();
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

datatable.on('click', '.eliminar', EliminarEntrenamiento);
datatable.on('click', '.modificar', llenarFormulario);
FormEntrenamiento.addEventListener('submit', GuardarEntrenamiento);
BtnLimpiar.addEventListener('click', limpiarTodo);
BtnModificar.addEventListener('click', ModificarEntrenamiento);
BtnBuscar.addEventListener('click', BuscarEntrenamientos);

obtenerCapacitaciones();
obtenerCompanias();
obtenerInstructores();
obtenerAreas();