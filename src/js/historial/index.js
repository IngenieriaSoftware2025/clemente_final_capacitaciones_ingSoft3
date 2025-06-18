import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import DataTable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";
import { Toast, validarFormulario } from "../funciones";

// ELEMENTOS DEL DOM
const BtnBuscar = document.getElementById('BtnBuscar');
const BtnLimpiarFiltros = document.getElementById('BtnLimpiarFiltros');
const filtroUsuario = document.getElementById('filtro_usuario');
const filtroRuta = document.getElementById('filtro_ruta');
const fechaInicio = document.getElementById('fecha_inicio');
const fechaFin = document.getElementById('fecha_fin');

// URLs DE LAS APIS
const urls = {
    buscarActividades: '/clemente_final_capacitaciones_ingSoft3/API/historial/buscar',
    buscarUsuarios: '/clemente_final_capacitaciones_ingSoft3/API/historial/buscarUsuarios',
    buscarRutas: '/clemente_final_capacitaciones_ingSoft3/API/rutas/buscar',
    exportarReporte: '/clemente_final_capacitaciones_ingSoft3/API/historial/exportarReporte'
};

// FUNCIÓN PARA CARGAR USUARIOS EN EL SELECT
const cargarUsuarios = async () => {
    try {
        const response = await fetch(urls.buscarUsuarios);
        const resultado = await response.json();
        
        if (resultado.codigo === 1 && resultado.data) {
            filtroUsuario.innerHTML = '<option value="">Todos los usuarios</option>';
            
            resultado.data.forEach(usuario => {
                const option = document.createElement('option');
                option.value = usuario.historial_usuario_id;
                option.textContent = `${usuario.usuario_nom1} ${usuario.usuario_ape1}`;
                filtroUsuario.appendChild(option);
            });
        }
    } catch (error) {
        console.error('Error al cargar usuarios:', error);
        Toast.fire({
            icon: 'error',
            title: 'Error al cargar usuarios'
        });
    }
};

// FUNCIÓN PARA CARGAR RUTAS EN EL SELECT
const cargarRutas = async () => {
    try {
        const response = await fetch('/clemente_final_capacitaciones_ingSoft3/API/rutas/buscar');
        const resultado = await response.json();
        
        if (resultado.codigo === 1 && resultado.data) {
            filtroRuta.innerHTML = '<option value="">Todas las rutas</option>';
            
            resultado.data.forEach(ruta => {
                const option = document.createElement('option');
                option.value = ruta.ruta_id;
                option.textContent = ruta.ruta_nombre;
                filtroRuta.appendChild(option);
            });
        }
    } catch (error) {
        console.error('Error al cargar rutas:', error);
        Toast.fire({
            icon: 'error',
            title: 'Error al cargar rutas'
        });
    }
};

// FUNCIÓN PARA BUSCAR ACTIVIDADES
const buscarActividades = async () => {
    try {
        const params = new URLSearchParams();
        
        if (filtroUsuario.value) params.append('usuario_id', filtroUsuario.value);
        if (filtroRuta.value) params.append('ruta_id', filtroRuta.value);
        if (fechaInicio.value) params.append('fecha_inicio', fechaInicio.value);
        if (fechaFin.value) params.append('fecha_fin', fechaFin.value);
        
        const url = `${urls.buscarActividades}${params.toString() ? '?' + params.toString() : ''}`;
        const response = await fetch(url);
        const resultado = await response.json();
        
        if (resultado.codigo === 1) {
            console.log('Actividades encontradas:', resultado.data);
            
            if (datatable) {
                datatable.clear().draw();
                datatable.rows.add(resultado.data).draw();
            }
            
            Toast.fire({
                icon: 'success',
                title: `${resultado.data.length} actividades encontradas`
            });
        } else {
            Toast.fire({
                icon: 'info',
                title: resultado.mensaje
            });
        }
    } catch (error) {
        console.error('Error al buscar actividades:', error);
        Toast.fire({
            icon: 'error',
            title: 'Error al buscar actividades'
        });
    }
};

// FUNCIÓN PARA LIMPIAR FILTROS
const limpiarFiltros = () => {
    filtroUsuario.value = '';
    filtroRuta.value = '';
    fechaInicio.value = '';
    fechaFin.value = '';
    
    // Recargar datos sin filtros
    buscarActividades();
    
    Toast.fire({
        icon: 'info',
        title: 'Filtros limpiados'
    });
};

// FUNCIÓN PARA EXPORTAR REPORTE
const exportarReporte = async () => {
    try {
        const params = new URLSearchParams();
        
        if (filtroUsuario.value) params.append('usuario_id', filtroUsuario.value);
        if (fechaInicio.value) params.append('fecha_inicio', fechaInicio.value);
        if (fechaFin.value) params.append('fecha_fin', fechaFin.value);
        
        const url = `${urls.exportarReporte}${params.toString() ? '?' + params.toString() : ''}`;
        const response = await fetch(url);
        const resultado = await response.json();
        
        if (resultado.codigo === 1 && resultado.data) {
            // Convertir datos a CSV
            const csvContent = convertirACSV(resultado.data);
            
            // Crear y descargar archivo
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            const url_objeto = URL.createObjectURL(blob);
            
            link.setAttribute('href', url_objeto);
            link.setAttribute('download', `reporte_actividades_${new Date().toISOString().split('T')[0]}.csv`);
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            
            Toast.fire({
                icon: 'success',
                title: 'Reporte exportado correctamente'
            });
        } else {
            Toast.fire({
                icon: 'error',
                title: resultado.mensaje || 'Error al exportar reporte'
            });
        }
    } catch (error) {
        console.error('Error al exportar reporte:', error);
        Toast.fire({
            icon: 'error',
            title: 'Error al exportar reporte'
        });
    }
};

// FUNCIÓN PARA CONVERTIR DATOS A CSV
const convertirACSV = (data) => {
    if (!data || data.length === 0) return '';
    
    const headers = ['Fecha', 'Usuario', 'Ruta', 'Descripción', 'Ejecución'];
    const csvRows = [];
    
    // Agregar encabezados
    csvRows.push(headers.join(','));
    
    // Agregar datos
    data.forEach(row => {
        const valores = [
            row.fecha || '',
            row.usuario || '',
            row.ruta || '',
            (row.descripcion || '').replace(/,/g, ';'), // Reemplazar comas para evitar problemas en CSV
            row.ejecucion || ''
        ];
        csvRows.push(valores.join(','));
    });
    
    return csvRows.join('\n');
};

// CONFIGURACIÓN DE DATATABLES
const datatable = new DataTable('#TableHistorialActividades', {
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
    order: [[0, 'desc']], // Ordenar por fecha descendente
    columns: [
        {
            title: 'No.',
            data: 'historial_id',
            width: '5%',
            render: (data, type, row, meta) => meta.row + 1
        },
        {
            title: 'Usuario',
            data: null,
            width: '15%',
            render: (data, type, row) => {
                return `${row.usuario_nom1} ${row.usuario_ape1}`;
            }
        },
        {
            title: 'Ruta',
            data: 'ruta_nombre',
            width: '20%'
        },
        {
            title: 'Descripción',
            data: 'ruta_descripcion',
            width: '25%',
            render: (data) => {
                if (!data) return 'N/A';
                return data.length > 50 ? data.substring(0, 50) + '...' : data;
            }
        },
        {
            title: 'Ejecución',
            data: 'historial_ejecucion',
            width: '10%',
            render: (data) => {
                const estados = {
                    'EXITOSO': '<span class="badge bg-success">EXITOSO</span>',
                    'FALLIDO': '<span class="badge bg-danger">FALLIDO</span>',
                    'PENDIENTE': '<span class="badge bg-warning">PENDIENTE</span>',
                    'PROCESANDO': '<span class="badge bg-info">PROCESANDO</span>'
                };
                return estados[data] || `<span class="badge bg-secondary">${data}</span>`;
            }
        },
        {
            title: 'Fecha',
            data: 'historial_fecha',
            width: '15%',
            render: (data) => {
                if (!data) return 'N/A';
                const fecha = new Date(data);
                return fecha.toLocaleString('es-GT', {
                    year: 'numeric',
                    month: '2-digit',
                    day: '2-digit',
                    hour: '2-digit',
                    minute: '2-digit'
                });
            }
        },
        {
            title: 'Estado',
            data: 'historial_situacion',
            width: '10%',
            render: (data) => {
                return data == 1 
                    ? '<span class="badge bg-success">ACTIVO</span>' 
                    : '<span class="badge bg-danger">INACTIVO</span>';
            }
        }
    ],
    buttons: [
        {
            text: '<i class="bi bi-download me-1"></i>Exportar CSV',
            className: 'btn btn-success btn-sm',
            action: function() {
                exportarReporte();
            }
        },
        {
            text: '<i class="bi bi-arrow-clockwise me-1"></i>Actualizar',
            className: 'btn btn-primary btn-sm',
            action: function() {
                buscarActividades();
            }
        }
    ]
});

// EVENT LISTENERS
BtnBuscar.addEventListener('click', buscarActividades);
BtnLimpiarFiltros.addEventListener('click', limpiarFiltros);

// Filtros automáticos cuando cambian los valores
filtroUsuario.addEventListener('change', buscarActividades);
filtroRuta.addEventListener('change', buscarActividades);
fechaInicio.addEventListener('change', buscarActividades);
fechaFin.addEventListener('change', buscarActividades);

// INICIALIZACIÓN
document.addEventListener('DOMContentLoaded', () => {
    cargarUsuarios();
    cargarRutas();
    buscarActividades();
    
    // Establecer fecha por defecto (últimos 30 días)
    const hoy = new Date();
    const hace30Dias = new Date();
    hace30Dias.setDate(hoy.getDate() - 30);
    
    fechaFin.value = hoy.toISOString().split('T')[0];
    fechaInicio.value = hace30Dias.toISOString().split('T')[0];
    
    Toast.fire({
        icon: 'info',
        title: 'Historial de actividades cargado'
    });
});