import Swal from "sweetalert2";
import { validarFormulario } from '../funciones';
import DataTable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";

const FormComisionPersonal = document.getElementById('FormComisionPersonal');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');
const BtnLimpiar = document.getElementById('BtnLimpiar');
const BtnBuscar = document.getElementById('BtnBuscar');
const BtnPersonalDisponible = document.getElementById('BtnPersonalDisponible');
const seccionPersonalDisponible = document.getElementById('seccionPersonalDisponible');

let datatable, datatablePersonal;

const GuardarAsignacion = async (event) => {
    event.preventDefault();
    BtnGuardar.disabled = true;

    if (!validarFormulario(FormComisionPersonal, ['comision_personal_id'])) {
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

    const body = new FormData(FormComisionPersonal);
    body.append('comision_personal_usuario_asigno', 1); // ID del usuario actual
    
    const url = '/clemente_final_capacitaciones_ingSoft3/comisionpersonal/guardarAPI';
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
            CargarUsuarios(); // Recargar usuarios disponibles
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

const CargarComisiones = async () => {
    try {
        const respuesta = await fetch('/clemente_final_capacitaciones_ingSoft3/comisionpersonal/buscarComisionesAPI');
        const datos = await respuesta.json();
        
        if (datos.codigo === 1) {
            const selectComision = document.getElementById('comision_id');
            selectComision.innerHTML = '<option value="">Seleccione una comisión</option>';
            
            datos.data.forEach(comision => {
                const option = `<option value="${comision.comision_id}">${comision.comision_titulo} (${comision.comision_tipo})</option>`;
                selectComision.innerHTML += option;
            });
        }
    } catch (error) {
        console.log(error);
    }
}

const CargarUsuarios = async () => {
    try {
        const respuesta = await fetch('/clemente_final_capacitaciones_ingSoft3/comisionpersonal/buscarUsuariosDisponiblesAPI');
        const datos = await respuesta.json();
        
        if (datos.codigo === 1) {
            const selectUsuario = document.getElementById('usuario_id');
            selectUsuario.innerHTML = '<option value="">Seleccione personal</option>';
            
            datos.data.forEach(usuario => {
                const option = `<option value="${usuario.usuario_id}">${usuario.usuario_nom1} ${usuario.usuario_ape1}</option>`;
                selectUsuario.innerHTML += option;
            });
        }
    } catch (error) {
        console.log(error);
    }
}

const BuscarAsignaciones = async () => {
    const url = `/clemente_final_capacitaciones_ingSoft3/comisionpersonal/buscarAPI`;
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
    datatable = new DataTable('#TableComisionPersonal', {
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
                data: 'comision_personal_id',
                width: '5%',
                render: (data, type, row, meta) => meta.row + 1
            },
            { 
                title: 'Comisión', 
                data: 'comision_titulo', 
                width: '15%' 
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
                title: 'Personal Asignado', 
                data: 'usuario_nom1', 
                width: '15%',
                render: (data, type, row) => `${row.usuario_nom1} ${row.usuario_ape1}`
            },
            { 
                title: 'Fecha Asignación', 
                data: 'comision_personal_fecha_asignacion', 
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
                title: 'Estado Comisión', 
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
                title: 'Fecha Fin', 
                data: 'comision_fecha_fin', 
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
                width: '10%',
                render: (data, type, row) => `${row.asigno_nom1} ${row.asigno_ape1}`
            },
            {
                title: 'Acciones',
                data: 'comision_personal_id',
                searchable: false,
                orderable: false,
                width: '5%',
                render: (data, type, row, meta) => {
                    return `
                     <div class='d-flex justify-content-center'>
                         <button class='btn btn-danger eliminar mx-1 btn-sm' 
                             data-id="${data}">
                            <i class="bi bi-trash3 me-1"></i>Eliminar
                         </button>
                     </div>`;
                }
            }
        ]
    });

    datatable.on('click', '.eliminar', EliminarAsignacion);
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
        const url = `/clemente_final_capacitaciones_ingSoft3/comisionpersonal/eliminarAPI?id=${idAsignacion}`;
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
                CargarUsuarios(); // Recargar usuarios disponibles
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

const mostrarPersonalDisponible = async () => {
    if (seccionPersonalDisponible.style.display === 'none') {
        seccionPersonalDisponible.style.display = 'block';
        BtnPersonalDisponible.textContent = 'Ocultar Personal Disponible';
        
        if (!datatablePersonal) {
            initializePersonalTable();
        }
        await BuscarPersonalDisponible();
    } else {
        seccionPersonalDisponible.style.display = 'none';
        BtnPersonalDisponible.textContent = 'Ver Personal Disponible';
    }
}

const initializePersonalTable = () => {
    datatablePersonal = new DataTable('#TablePersonalDisponible', {
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
                data: 'usuario_id',
                width: '10%',
                render: (data, type, row, meta) => meta.row + 1
            },
            { 
                title: 'Nombre Completo', 
                data: 'usuario_nom1', 
                width: '40%',
                render: (data, type, row) => `${row.usuario_nom1} ${row.usuario_ape1}`
            },
            { 
                title: 'Estado', 
                data: null,
                width: '50%',
                render: () => '<span class="badge bg-success">Disponible</span>'
            }
        ]
    });
}

const BuscarPersonalDisponible = async () => {
    try {
        const respuesta = await fetch('/clemente_final_capacitaciones_ingSoft3/comisionpersonal/buscarUsuariosDisponiblesAPI');
        const datos = await respuesta.json();
        
        if (datos.codigo === 1) {
            datatablePersonal.clear().draw();
            datatablePersonal.rows.add(datos.data).draw();
        }
    } catch (error) {
        console.log(error);
    }
}

const limpiarTodo = () => {
    FormComisionPersonal.reset();
    document.getElementById('comision_personal_id').value = '';
    BtnGuardar.classList.remove('d-none');
    BtnModificar.classList.add('d-none');
}

// Event Listeners
FormComisionPersonal.addEventListener('submit', GuardarAsignacion);
BtnLimpiar.addEventListener('click', limpiarTodo);
BtnBuscar.addEventListener('click', BuscarAsignaciones);
BtnPersonalDisponible.addEventListener('click', mostrarPersonalDisponible);

// Inicializar
CargarComisiones();
CargarUsuarios();
BuscarAsignaciones();