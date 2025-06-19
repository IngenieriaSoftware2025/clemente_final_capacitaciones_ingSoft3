// --- VARIABLES GLOBALES ---
const FormPermisos = document.getElementById('FormPermisos');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');
const BtnLimpiar = document.getElementById('BtnLimpiar');
const BtnBuscar = document.getElementById('BtnBuscar');
const bodyPermisos = document.getElementById('bodyPermisos');
const seccionTabla = document.getElementById('seccionTabla');

// --- FUNCIONES ---

// Cargar usuarios en select
const CargarUsuarios = async () => {
    try {
        const respuesta = await fetch('/clemente_final_capacitaciones_ingSoft3/API/permisos/buscarUsuarios');
        const datos = await respuesta.json();

        if (datos.codigo == 1) {
            const selectUsuario = document.getElementById('usuario_id');
            const selectAsigno = document.getElementById('permiso_usuario_asigno');
            selectUsuario.innerHTML = '<option value="">Seleccione un usuario</option>';
            selectAsigno.innerHTML = '<option value="">Seleccione quién asigna</option>';

            datos.data.forEach(usuario => {
                const nombre = `${usuario.usuario_nom1} ${usuario.usuario_ape1}`;
                const option = `<option value="${usuario.usuario_id}">${nombre}</option>`;
                selectUsuario.innerHTML += option;
                selectAsigno.innerHTML += option;
            });
        }
    } catch (error) {
        console.error(error);
        Swal.fire({ icon: "error", title: "Error", text: "No se pudieron cargar los usuarios." });
    }
};

// Cargar aplicaciones en select
const CargarAplicaciones = async () => {
    try {
        const respuesta = await fetch('/clemente_final_capacitaciones_ingSoft3/API/permisos/buscarAplicaciones');
        const datos = await respuesta.json();

        if (datos.codigo == 1) {
            const select = document.getElementById('app_id');
            select.innerHTML = '<option value="">Seleccione una aplicación</option>';

            datos.data.forEach(app => {
                select.innerHTML += `<option value="${app.app_id}">${app.app_nombre_corto}</option>`;
            });
        }
    } catch (error) {
        console.error(error);
        Swal.fire({ icon: "error", title: "Error", text: "No se pudieron cargar las aplicaciones." });
    }
};

// Limpiar formulario
const LimpiarFormulario = () => {
    FormPermisos.reset();
    document.getElementById('permiso_id').value = '';
    BtnGuardar.classList.remove('d-none');
    BtnModificar.classList.add('d-none');
};

// Guardar permiso
const GuardarPermiso = async (event) => {
    event.preventDefault();
    const formData = new FormData(FormPermisos);

    try {
        const respuesta = await fetch('/clemente_final_capacitaciones_ingSoft3/API/permisos/guardar', {
            method: 'POST',
            body: formData
        });

        const datos = await respuesta.json();
        if (datos.codigo == 1) {
            Swal.fire({ icon: "success", title: "Éxito", text: datos.mensaje });
            LimpiarFormulario();
            BuscarPermisos();
        } else {
            Swal.fire({ icon: "error", title: "Error", text: datos.mensaje });
        }
    } catch (error) {
        console.error(error);
        Swal.fire({ icon: "error", title: "Error", text: "No se pudo guardar el permiso." });
    }
};

// Modificar permiso
const ModificarPermiso = async (event) => {
    event.preventDefault();
    const formData = new FormData(FormPermisos);

    try {
        const respuesta = await fetch('/clemente_final_capacitaciones_ingSoft3/API/permisos/modificar', {
            method: 'POST',
            body: formData
        });

        const datos = await respuesta.json();
        if (datos.codigo == 1) {
            Swal.fire({ icon: "success", title: "Modificado", text: datos.mensaje });
            LimpiarFormulario();
            BuscarPermisos();
        } else {
            Swal.fire({ icon: "error", title: "Error", text: datos.mensaje });
        }
    } catch (error) {
        console.error(error);
        Swal.fire({ icon: "error", title: "Error", text: "Error al modificar el permiso." });
    }
};

// Eliminar permiso
const EliminarPermiso = async (id, nombre) => {
    const confirmacion = await Swal.fire({
        title: `¿Eliminar "${nombre}"?`,
        text: "Esta acción no se puede deshacer",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
    });

    if (confirmacion.isConfirmed) {
        try {
            const respuesta = await fetch(`/clemente_final_capacitaciones_ingSoft3/API/permisos/eliminar?id=${id}`);
            const datos = await respuesta.json();

            if (datos.codigo == 1) {
                Swal.fire({ icon: "success", title: "Eliminado", text: datos.mensaje });
                BuscarPermisos();
            } else {
                Swal.fire({ icon: "error", title: "Error", text: datos.mensaje });
            }
        } catch (error) {
            console.error(error);
            Swal.fire({ icon: "error", title: "Error", text: "No se pudo eliminar." });
        }
    }
};

// Buscar permisos
const BuscarPermisos = async () => {
    try {
        const respuesta = await fetch('/clemente_final_capacitaciones_ingSoft3/API/permisos/buscar');
        const datos = await respuesta.json();

        if (datos.codigo == 1) {
            bodyPermisos.innerHTML = '';

            datos.data.forEach((permiso, index) => {
                bodyPermisos.innerHTML += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${permiso.permiso_nombre}</td>
                        <td>${permiso.descripcion}</td>
                        <td>${permiso.fecha_creacion || 'Sin fecha'}</td>
                        <td>
                            <button class="btn btn-warning btn-sm modificar" 
                                    data-id="${permiso.id_permiso}" 
                                    data-nombre="${permiso.permiso_nombre}" 
                                    data-desc="${permiso.descripcion}">
                                <i class="bi bi-pencil"></i> Editar
                            </button>
                            <button class="btn btn-danger btn-sm eliminar" 
                                    data-id="${permiso.id_permiso}" 
                                    data-nombre="${permiso.permiso_nombre}">
                                <i class="bi bi-trash"></i> Eliminar
                            </button>
                        </td>
                    </tr>
                `;
            });
        }
    } catch (error) {
        console.error(error);
        Swal.fire({ icon: "error", title: "Error", text: "No se pudieron cargar los permisos." });
    }
};

// Mostrar datos en formulario
const llenarFormulario = (event) => {
    const datos = event.target.closest('.modificar').dataset;
    document.getElementById('permiso_id').value = datos.id;
    document.getElementById('permiso_nombre').value = datos.nombre;
    document.getElementById('descripcion').value = datos.desc;

    BtnGuardar.classList.add('d-none');
    BtnModificar.classList.remove('d-none');

    window.scrollTo({ top: 0, behavior: 'smooth' });
};

// Mostrar u ocultar tabla
const MostrarTabla = () => {
    if (seccionTabla.style.display === 'none') {
        seccionTabla.style.display = 'block';
        BuscarPermisos();
    } else {
        seccionTabla.style.display = 'none';
    }
};

// --- EVENTOS ---
document.addEventListener('DOMContentLoaded', () => {
    CargarUsuarios();
    CargarAplicaciones();
    BuscarPermisos();

    BtnGuardar.addEventListener('click', GuardarPermiso);
    BtnModificar.addEventListener('click', ModificarPermiso);
    BtnLimpiar.addEventListener('click', LimpiarFormulario);
    BtnBuscar.addEventListener('click', MostrarTabla);

    document.addEventListener('click', (e) => {
        if (e.target.closest('.modificar')) {
            llenarFormulario(e);
        }

        if (e.target.closest('.eliminar')) {
            const btn = e.target.closest('.eliminar');
            EliminarPermiso(btn.dataset.id, btn.dataset.nombre);
        }
    });
});
