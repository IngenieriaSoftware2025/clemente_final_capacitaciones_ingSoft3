import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario } from '../funciones';
import DataTable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";


const FormUsuarios = document.getElementById('FormUsuarios');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');
const BtnLimpiar = document.getElementById('BtnLimpiar');
const BtnBuscar = document.getElementById('BtnBuscar');


const usuario_id = document.getElementById('usuario_id');
const usuario_nom1 = document.getElementById('usuario_nom1');
const usuario_nom2 = document.getElementById('usuario_nom2');
const usuario_ape1 = document.getElementById('usuario_ape1');
const usuario_ape2 = document.getElementById('usuario_ape2');
const usuario_tel = document.getElementById('usuario_tel');
const usuario_dpi = document.getElementById('usuario_dpi');
const usuario_direc = document.getElementById('usuario_direc');
const usuario_correo = document.getElementById('usuario_correo');
const usuario_contra = document.getElementById('usuario_contra');
const confirmar_contra = document.getElementById('confirmar_contra');
const usuario_fotografia = document.getElementById('usuario_fotografia');


const urls = {
    guardar: '/clemente_final_capacitaciones_ingSoft3/API/usuarios/guardar',
    buscar: '/clemente_final_capacitaciones_ingSoft3/API/usuarios/buscar',
    modificar: '/clemente_final_capacitaciones_ingSoft3/API/usuarios/modificar',
    eliminar: '/clemente_final_capacitaciones_ingSoft3/API/usuarios/eliminar'
};


const GuardarUsuario = async (event) => {
    event.preventDefault();
    BtnGuardar.disabled = true;

    if (!validarFormulario(FormUsuarios, ['usuario_id', 'usuario_token', 'usuario_fecha_creacion', 'usuario_fecha_contra', 'usuario_situacion', 'usuario_fotografia'])) {
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

    if (usuario_contra.value !== confirmar_contra.value) {
        Swal.fire({
            position: "center",
            icon: "error",
            title: "ERROR",
            text: "Las contraseñas no coinciden",
            showConfirmButton: true,
        });
        BtnGuardar.disabled = false;
        return;
    }

    if (usuario_contra.value.length < 8) {
        Swal.fire({
            position: "center",
            icon: "error",
            title: "ERROR",
            text: "La contraseña debe tener al menos 8 caracteres",
            showConfirmButton: true,
        });
        BtnGuardar.disabled = false;
        return;
    }

    const body = new FormData(FormUsuarios);
    const config = {
        method: 'POST',
        body
    }

    try {
        const respuesta = await fetch(urls.guardar, config);
        const datos = await respuesta.json();
        const { codigo, mensaje } = datos;

        if (codigo == 1) {
            await Swal.fire({
                position: "center",
                icon: "success",
                title: "ÉXITO",
                text: mensaje,
                showConfirmButton: true,
            });
            
            limpiarFormulario();
            BuscarUsuarios();
        } else {
            await Swal.fire({
                position: "center",
                icon: "error",
                title: "ERROR",
                text: mensaje,
                showConfirmButton: true,
            });
        }

    } catch (error) {
        console.error('Error al guardar usuario:', error);
        await Swal.fire({
            position: "center",
            icon: "error",
            title: "ERROR",
            text: "Error interno del servidor",
            showConfirmButton: true,
        });
    }
    
    BtnGuardar.disabled = false;
};


const BuscarUsuarios = async () => {
    try {
        const response = await fetch(urls.buscar);
        const resultado = await response.json();
        const { codigo, mensaje, data } = resultado;

        if (codigo == 1) {
            datatable.clear().draw();
            datatable.rows.add(data).draw();
        } else {
            Toast.fire({
                icon: 'info',
                title: mensaje
            });
        }

    } catch (error) {
        console.error('Error al buscar usuarios:', error);
        Toast.fire({
            icon: 'error',
            title: 'Error al cargar usuarios'
        });
    }
};

const ModificarUsuario = async (event) => {
    event.preventDefault();
    BtnModificar.disabled = true;

    if (!validarFormulario(FormUsuarios, ['usuario_contra', 'confirmar_contra', 'usuario_fotografia'])) {
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

    const body = new FormData(FormUsuarios);
    const config = {
        method: 'POST',
        body
    }

    try {
        const respuesta = await fetch(urls.modificar, config);
        const datos = await respuesta.json();
        const { codigo, mensaje } = datos;

        if (codigo == 1) {
            await Swal.fire({
                position: "center",
                icon: "success",
                title: "ÉXITO",
                text: mensaje,
                showConfirmButton: true,
            });
            
            limpiarFormulario();
            BuscarUsuarios();
        } else {
            await Swal.fire({
                position: "center",
                icon: "error",
                title: "ERROR",
                text: mensaje,
                showConfirmButton: true,
            });
        }

    } catch (error) {
        console.error('Error al modificar usuario:', error);
        await Swal.fire({
            position: "center",
            icon: "error",
            title: "ERROR",
            text: "Error interno del servidor",
            showConfirmButton: true,
        });
    }
    
    BtnModificar.disabled = false;
};


const EliminarUsuario = async (event) => {
    const id = event.currentTarget.dataset.id;
    
    const confirmacion = await Swal.fire({
        title: '¿Está seguro?',
        text: "Esta acción no se puede revertir",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    });

    if (confirmacion.isConfirmed) {
        try {
            const response = await fetch(`${urls.eliminar}?id=${id}`);
            const resultado = await response.json();
            const { codigo, mensaje } = resultado;

            if (codigo == 1) {
                await Swal.fire(
                    'Eliminado',
                    mensaje,
                    'success'
                );
                BuscarUsuarios();
            } else {
                await Swal.fire(
                    'Error',
                    mensaje,
                    'error'
                );
            }

        } catch (error) {
            console.error('Error al eliminar usuario:', error);
            await Swal.fire(
                'Error',
                'Error interno del servidor',
                'error'
            );
        }
    }
};

const llenarFormulario = (event) => {
    const btn = event.currentTarget;
    const data = btn.dataset;

    usuario_id.value = data.id;
    usuario_nom1.value = data.nom1;
    usuario_nom2.value = data.nom2;
    usuario_ape1.value = data.ape1;
    usuario_ape2.value = data.ape2;
    usuario_tel.value = data.tel;
    usuario_dpi.value = data.dpi;
    usuario_direc.value = data.direc;
    usuario_correo.value = data.correo;


    usuario_contra.parentElement.style.display = 'none';
    confirmar_contra.parentElement.style.display = 'none';


    BtnGuardar.style.display = 'none';
    BtnModificar.style.display = 'inline-block';
    BtnModificar.classList.remove('d-none');

  
    FormUsuarios.scrollIntoView({ behavior: 'smooth' });
};


const limpiarFormulario = () => {
    FormUsuarios.reset();
    usuario_id.value = '';
    

    usuario_contra.parentElement.style.display = 'block';
    confirmar_contra.parentElement.style.display = 'block';
    

    BtnGuardar.style.display = 'inline-block';
    BtnModificar.style.display = 'none';
    BtnModificar.classList.add('d-none');
    

    FormUsuarios.classList.remove('was-validated');
    const inputs = FormUsuarios.querySelectorAll('.form-control');
    inputs.forEach(input => {
        input.classList.remove('is-invalid', 'is-valid');
    });
};


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
            width: '5%',
            render: (data, type, row, meta) => meta.row + 1
        },
        { 
            title: 'Primer Nombre', 
            data: 'usuario_nom1', 
            width: '12%' 
        },
        { 
            title: 'Segundo Nombre', 
            data: 'usuario_nom2', 
            width: '12%',
            render: (data) => data || ''
        },
        { 
            title: 'Primer Apellido', 
            data: 'usuario_ape1', 
            width: '12%' 
        },
        { 
            title: 'Segundo Apellido', 
            data: 'usuario_ape2', 
            width: '12%',
            render: (data) => data || ''
        },
        { 
            title: 'Teléfono', 
            data: 'usuario_tel', 
            width: '10%' 
        },
        { 
            title: 'DPI', 
            data: 'usuario_dpi', 
            width: '12%' 
        },
        { 
            title: 'Correo', 
            data: 'usuario_correo', 
            width: '15%' 
        },
        {
            title: 'Fotografía',
            data: 'usuario_fotografia',
            searchable: false,
            orderable: false,
            width: '8%',
            render: (data, type, row) => {
                if (data && data.trim() !== '') {
                    return `<img src="${data}" alt="Foto" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover; cursor: pointer;" onclick="mostrarImagenCompleta('${data}')">`;
                } else {
                    return '<span class="text-muted">Sin foto</span>';
                }
            }
        },
        {
            title: 'Fecha Creación',
            data: 'usuario_fecha_creacion',
            width: '10%',
            render: (data) => {
                if (!data) return 'N/A';
                const fecha = new Date(data);
                return fecha.toLocaleDateString('es-GT');
            }
        },
        {
            title: 'Acciones',
            data: 'usuario_id',
            searchable: false,
            orderable: false,
            width: '12%',
            render: (data, type, row, meta) => {
                return `
                    <div class='d-flex justify-content-center'>
                        <button class='btn btn-warning modificar mx-1 btn-sm' 
                            data-id="${data}" 
                            data-nom1="${row.usuario_nom1}"
                            data-nom2="${row.usuario_nom2 || ''}"
                            data-ape1="${row.usuario_ape1}"
                            data-ape2="${row.usuario_ape2 || ''}"
                            data-tel="${row.usuario_tel}"
                            data-dpi="${row.usuario_dpi}"
                            data-direc="${row.usuario_direc}"
                            data-correo="${row.usuario_correo}"
                            title="Modificar">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <button class='btn btn-danger eliminar mx-1 btn-sm' 
                            data-id="${data}" 
                            title="Eliminar">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                `;
            }
        }
    ]
});


window.mostrarImagenCompleta = (src) => {
    Swal.fire({
        imageUrl: src,
        imageWidth: 400,
        imageHeight: 400,
        imageAlt: 'Fotografía del usuario',
        showConfirmButton: false,
        showCloseButton: true
    });
};


usuario_dpi.addEventListener('input', (e) => {
    e.target.value = e.target.value.replace(/\D/g, '');
    if (e.target.value.length > 13) {
        e.target.value = e.target.value.slice(0, 13);
    }
});

usuario_tel.addEventListener('input', (e) => {
    e.target.value = e.target.value.replace(/\D/g, '');
    if (e.target.value.length > 8) {
        e.target.value = e.target.value.slice(0, 8);
    }
});


usuario_correo.addEventListener('blur', (e) => {
    const email = e.target.value;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
    if (email && !emailRegex.test(email)) {
        e.target.classList.add('is-invalid');
        Toast.fire({
            icon: 'error',
            title: 'Formato de correo inválido'
        });
    } else {
        e.target.classList.remove('is-invalid');
    }
});

confirmar_contra.addEventListener('input', (e) => {
    if (usuario_contra.value !== e.target.value) {
        e.target.classList.add('is-invalid');
    } else {
        e.target.classList.remove('is-invalid');
        e.target.classList.add('is-valid');
    }
});


FormUsuarios.addEventListener('submit', GuardarUsuario);
BtnModificar.addEventListener('click', ModificarUsuario);
BtnLimpiar.addEventListener('click', limpiarFormulario);
BtnBuscar.addEventListener('click', BuscarUsuarios);


datatable.on('click', '.eliminar', EliminarUsuario);
datatable.on('click', '.modificar', llenarFormulario);


document.addEventListener('DOMContentLoaded', () => {
    BuscarUsuarios();
    
    Toast.fire({
        icon: 'info',
        title: 'Módulo de usuarios cargado'
    });
});