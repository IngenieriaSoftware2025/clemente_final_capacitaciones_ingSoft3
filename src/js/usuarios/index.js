import Swal from "sweetalert2";
import { validarFormulario } from '../funciones';
import DataTable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";


const FormUsuarios = document.getElementById('FormUsuarios');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');
const BtnLimpiar = document.getElementById('BtnLimpiar');
const BtnBuscar = document.getElementById('BtnBuscar');

const GuardarUsuario = async (event) => {
    event.preventDefault();
    BtnGuardar.disabled = true;

    if (!validarFormulario(FormUsuarios, 
        ['usuario_id', 
          'usuario_token', 
          'usuario_fecha_creacion', 
          'usuario_fecha_contra', 
          'usuario_situacion', 
          'usuario_fotografia'])) {
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

    const body = new FormData(FormUsuarios);
    const url = '/clemente_final_capacitaciones_ingSoft3/API/usuarios/guardar';
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
            BuscarUsuarios();
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

const BuscarUsuarios = async () => {
    const url = `/clemente_final_capacitaciones_ingSoft3/API/usuarios/buscar`;
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

const datatable = new DataTable('#TableUsuarios', {
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
            width: '3%',
            render: (data, type, row, meta) => meta.row + 1
        },
        { title: 'Primer Nombre', data: 'usuario_nom1', width: '9%' },
        { title: 'Segundo Nombre', data: 'usuario_nom2', width: '9%' },
        { title: 'Primer Apellido', data: 'usuario_ape1', width: '9%' },
        { title: 'Segundo Apellido', data: 'usuario_ape2', width: '9%' },
        { title: 'Correo', data: 'usuario_correo', width: '12%' },
        { title: 'Teléfono', data: 'usuario_tel', width: '8%' },
        { title: 'DPI', data: 'usuario_dpi', width: '8%' },
        { title: 'Dirección', data: 'usuario_direc', width: '10%' },
        {
            title: 'Fotografía',
            data: 'usuario_fotografia',
            searchable: false,
            orderable: false,
            width: '7%',
            render: (data, type, row) => {
                console.log('Datos de foto:', data); 
                if (data && data.trim() !== '') {
                    const rutaFoto = `/${data}`;
                    
                    return `<img src="${rutaFoto}" alt="Foto" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;" onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-block';">
                            <span class="text-muted" style="display: none;">Error foto</span>`;
                } else {
                    return '<span class="text-muted">Sin foto</span>';
                }
            }
        },
        {
            title: 'Acciones',
            data: 'usuario_id',
            searchable: false,
            orderable: false,
            width: '8%',
            render: (data, type, row, meta) => {
                return `
                 <div class='d-flex justify-content-center'>
                     <button class='btn btn-warning modificar mx-1 btn-sm' 
                         data-id="${data}" 
                         data-usuario_nom1="${row.usuario_nom1 || ''}"  
                         data-usuario_nom2="${row.usuario_nom2 || ''}"  
                         data-usuario_ape1="${row.usuario_ape1 || ''}"  
                         data-usuario_ape2="${row.usuario_ape2 || ''}"  
                         data-usuario_tel="${row.usuario_tel || ''}"  
                         data-usuario_direc="${row.usuario_direc || ''}"  
                         data-usuario_dpi="${row.usuario_dpi || ''}"  
                         data-usuario_correo="${row.usuario_correo || ''}">
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

    document.getElementById('usuario_id').value = datos.id;
    document.getElementById('usuario_nom1').value = datos.usuario_nom1;
    document.getElementById('usuario_nom2').value = datos.usuario_nom2;
    document.getElementById('usuario_ape1').value = datos.usuario_ape1;
    document.getElementById('usuario_ape2').value = datos.usuario_ape2;
    document.getElementById('usuario_tel').value = datos.usuario_tel;
    document.getElementById('usuario_direc').value = datos.usuario_direc;
    document.getElementById('usuario_dpi').value = datos.usuario_dpi;
    document.getElementById('usuario_correo').value = datos.usuario_correo;
    document.getElementById('usuario_contra').value = '';
    document.getElementById('confirmar_contra').value = '';

    BtnGuardar.classList.add('d-none');
    BtnModificar.classList.remove('d-none');

    window.scrollTo({
        top: 0,
    });
}

const limpiarTodo = () => {
    FormUsuarios.reset();
    
    BtnGuardar.classList.remove('d-none');
    BtnModificar.classList.add('d-none');
}

const ModificarUsuario = async (event) => {
    event.preventDefault();
    BtnModificar.disabled = true;

    if (!validarFormulario(FormUsuarios, [
        'usuario_id', 
        'usuario_token', 
        'usuario_fecha_creacion', 
        'usuario_fecha_contra', 
        'usuario_situacion', 
        'usuario_fotografia'])) {
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

    const body = new FormData(FormUsuarios);
    const url = '/clemente_final_capacitaciones_ingSoft3/API/usuarios/modificar';
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
            BuscarUsuarios();
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

const EliminarUsuarios = async (e) => {
    const idUsuario = e.currentTarget.dataset.id

    const AlertaConfirmarEliminar = await Swal.fire({
        position: "center",
        icon: "question",
        title: "¿Desea eliminar este usuario?",
        text: 'Esta acción no se puede deshacer',
        showConfirmButton: true,
        confirmButtonText: 'Sí, Eliminar',
        confirmButtonColor: '#dc3545',
        cancelButtonText: 'No, Cancelar',
        showCancelButton: true
    });

    if (AlertaConfirmarEliminar.isConfirmed) {
        const url = `/clemente_final_capacitaciones_ingSoft3/API/usuarios/eliminar?id=${idUsuario}`;
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
                
                BuscarUsuarios();
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

datatable.on('click', '.eliminar', EliminarUsuarios);
datatable.on('click', '.modificar', llenarFormulario);
FormUsuarios.addEventListener('submit', GuardarUsuario);
BtnLimpiar.addEventListener('click', limpiarTodo);
BtnModificar.addEventListener('click', ModificarUsuario);
BtnBuscar.addEventListener('click', BuscarUsuarios);