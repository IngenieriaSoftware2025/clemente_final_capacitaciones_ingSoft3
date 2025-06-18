
import { Dropdown } from "bootstrap";

// VARIABLES GLOBALES
let graficos = {};

// URLs de las APIs
const urls = {
    comisionesTipo: '/clemente_final_capacitaciones_ingSoft3/API/estadisticas/comisionesPorTipo',
    comisionesEstado: '/clemente_final_capacitaciones_ingSoft3/API/estadisticas/comisionesPorEstado', 
    personalAsignado: '/clemente_final_capacitaciones_ingSoft3/API/estadisticas/personalMasAsignado',
    usuariosCreadores: '/clemente_final_capacitaciones_ingSoft3/API/estadisticas/usuariosCreadores',
    duracionPromedio: '/clemente_final_capacitaciones_ingSoft3/API/estadisticas/duracionPromedio',
    ubicacionesFrecuentes: '/clemente_final_capacitaciones_ingSoft3/API/estadisticas/ubicacionesFrecuentes',
    comisionesMes: '/clemente_final_capacitaciones_ingSoft3/API/estadisticas/comisionesPorMes',
    comisionesActivas: '/clemente_final_capacitaciones_ingSoft3/API/estadisticas/comisionesActivas',
    personalDisponible: '/clemente_final_capacitaciones_ingSoft3/API/estadisticas/personalDisponible',
    resumenGeneral: '/clemente_final_capacitaciones_ingSoft3/API/estadisticas/resumenGeneral'
};

// FUNCIÓN PARA OBTENER COLORES DINÁMICOS
const obtenerColor = (index) => {
    const colores = [
        'rgba(255, 99, 132, 0.8)',   // Rojo
        'rgba(54, 162, 235, 0.8)',   // Azul
        'rgba(255, 205, 86, 0.8)',   // Amarillo
        'rgba(75, 192, 192, 0.8)',   // Verde aguamarina
        'rgba(153, 102, 255, 0.8)',  // Púrpura
        'rgba(255, 159, 64, 0.8)',   // Naranja
        'rgba(199, 199, 199, 0.8)',  // Gris
        'rgba(83, 102, 255, 0.8)',   // Azul índigo
        'rgba(255, 99, 255, 0.8)',   // Magenta
        'rgba(99, 255, 132, 0.8)'    // Verde lima
    ];
    return colores[index % colores.length];
};

// INICIALIZAR GRÁFICOS
const inicializarGraficos = () => {
    // Gráfico 1: Comisiones por Tipo (PIE)
    const ctx1 = document.getElementById('grafico1').getContext('2d');
    graficos.comisionesTipo = new Chart(ctx1, {
        type: 'pie',
        data: {
            labels: [],
            datasets: [{
                data: [],
                backgroundColor: []
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: { size: 12 },
                        padding: 15
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const porcentaje = ((context.parsed / total) * 100).toFixed(1);
                            return `${context.label}: ${context.parsed} (${porcentaje}%)`;
                        }
                    }
                }
            }
        }
    });

    // Gráfico 2: Estados de Comisiones (DOUGHNUT)
    const ctx2 = document.getElementById('grafico2').getContext('2d');
    graficos.comisionesEstado = new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: [],
            datasets: [{
                data: [],
                backgroundColor: []
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: { size: 12 },
                        padding: 15
                    }
                }
            }
        }
    });

    // Gráfico 3: Personal más Asignado (BAR HORIZONTAL)
    const ctx3 = document.getElementById('grafico3').getContext('2d');
    graficos.personalAsignado = new Chart(ctx3, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: 'Asignaciones',
                data: [],
                backgroundColor: 'rgba(54, 162, 235, 0.8)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Gráfico 4: Usuarios Creadores (BAR)
    const ctx4 = document.getElementById('grafico4').getContext('2d');
    graficos.usuariosCreadores = new Chart(ctx4, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: 'Comisiones Creadas',
                data: [],
                backgroundColor: 'rgba(255, 99, 132, 0.8)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Gráfico 5: Duración Promedio (BAR)
    const ctx5 = document.getElementById('grafico5').getContext('2d');
    graficos.duracionPromedio = new Chart(ctx5, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: 'Promedio (días)',
                data: [],
                backgroundColor: 'rgba(75, 192, 192, 0.8)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Gráfico 6: Ubicaciones Frecuentes (PIE)
    const ctx6 = document.getElementById('grafico6').getContext('2d');
    graficos.ubicacionesFrecuentes = new Chart(ctx6, {
        type: 'pie',
        data: {
            labels: [],
            datasets: [{
                data: [],
                backgroundColor: []
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: { size: 12 },
                        padding: 15
                    }
                }
            }
        }
    });

    // Gráfico 7: Comisiones por Mes (LINE)
    const ctx7 = document.getElementById('grafico7').getContext('2d');
    graficos.comisionesMes = new Chart(ctx7, {
        type: 'line',
        data: {
            labels: [],
            datasets: []
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Gráfico 8: Comisiones Activas vs Personal (BAR)
    const ctx8 = document.getElementById('grafico8').getContext('2d');
    graficos.comisionesActivas = new Chart(ctx8, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: 'Personal Asignado',
                data: [],
                backgroundColor: 'rgba(153, 102, 255, 0.8)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Gráfico 9: Disponibilidad Personal (DOUGHNUT)
    const ctx9 = document.getElementById('grafico9').getContext('2d');
    graficos.personalDisponible = new Chart(ctx9, {
        type: 'doughnut',
        data: {
            labels: ['Disponible', 'Ocupado'],
            datasets: [{
                data: [0, 0],
                backgroundColor: [
                    'rgba(40, 167, 69, 0.8)',  // Verde
                    'rgba(220, 53, 69, 0.8)'   // Rojo
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Gráfico 10: Resumen General (BAR)
    const ctx10 = document.getElementById('grafico10').getContext('2d');
    graficos.resumenGeneral = new Chart(ctx10, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: 'Cantidad',
                data: [],
                backgroundColor: [],
                borderColor: [],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
};

// FUNCIONES PARA CARGAR DATOS
const cargarComisionesPorTipo = async () => {
    try {
        const response = await fetch(urls.comisionesTipo);
        const resultado = await response.json();

        if (resultado.codigo === 1 && resultado.data) {
            const etiquetas = resultado.data.map(item => item.tipo);
            const datos = resultado.data.map(item => parseInt(item.cantidad));
            const colores = datos.map((_, index) => obtenerColor(index));

            graficos.comisionesTipo.data.labels = etiquetas;
            graficos.comisionesTipo.data.datasets[0].data = datos;
            graficos.comisionesTipo.data.datasets[0].backgroundColor = colores;
            graficos.comisionesTipo.update();
        }
    } catch (error) {
        console.error('Error al cargar comisiones por tipo:', error);
    }
};

const cargarComisionesPorEstado = async () => {
    try {
        const response = await fetch(urls.comisionesEstado);
        const resultado = await response.json();

        if (resultado.codigo === 1 && resultado.data) {
            const etiquetas = resultado.data.map(item => item.estado);
            const datos = resultado.data.map(item => parseInt(item.cantidad));
            const colores = datos.map((_, index) => obtenerColor(index));

            graficos.comisionesEstado.data.labels = etiquetas;
            graficos.comisionesEstado.data.datasets[0].data = datos;
            graficos.comisionesEstado.data.datasets[0].backgroundColor = colores;
            graficos.comisionesEstado.update();
        }
    } catch (error) {
        console.error('Error al cargar estados de comisiones:', error);
    }
};

const cargarPersonalMasAsignado = async () => {
    try {
        const response = await fetch(urls.personalAsignado);
        const resultado = await response.json();

        if (resultado.codigo === 1 && resultado.data) {
            const etiquetas = resultado.data.map(item => item.personal);
            const datos = resultado.data.map(item => parseInt(item.asignaciones));

            graficos.personalAsignado.data.labels = etiquetas;
            graficos.personalAsignado.data.datasets[0].data = datos;
            graficos.personalAsignado.update();
        }
    } catch (error) {
        console.error('Error al cargar personal más asignado:', error);
    }
};

const cargarUsuariosCreadores = async () => {
    try {
        const response = await fetch(urls.usuariosCreadores);
        const resultado = await response.json();

        if (resultado.codigo === 1 && resultado.data) {
            const etiquetas = resultado.data.map(item => item.creador);
            const datos = resultado.data.map(item => parseInt(item.comisiones_creadas));

            graficos.usuariosCreadores.data.labels = etiquetas;
            graficos.usuariosCreadores.data.datasets[0].data = datos;
            graficos.usuariosCreadores.update();
        }
    } catch (error) {
        console.error('Error al cargar usuarios creadores:', error);
    }
};

const cargarDuracionPromedio = async () => {
    try {
        const response = await fetch(urls.duracionPromedio);
        const resultado = await response.json();

        if (resultado.codigo === 1 && resultado.data) {
            const etiquetas = resultado.data.map(item => item.tipo_duracion);
            const datos = resultado.data.map(item => parseFloat(item.promedio).toFixed(1));

            graficos.duracionPromedio.data.labels = etiquetas;
            graficos.duracionPromedio.data.datasets[0].data = datos;
            graficos.duracionPromedio.update();
        }
    } catch (error) {
        console.error('Error al cargar duración promedio:', error);
    }
};

const cargarUbicacionesFrecuentes = async () => {
    try {
        const response = await fetch(urls.ubicacionesFrecuentes);
        const resultado = await response.json();

        if (resultado.codigo === 1 && resultado.data) {
            const etiquetas = resultado.data.map(item => item.ubicacion);
            const datos = resultado.data.map(item => parseInt(item.cantidad));
            const colores = datos.map((_, index) => obtenerColor(index));

            graficos.ubicacionesFrecuentes.data.labels = etiquetas;
            graficos.ubicacionesFrecuentes.data.datasets[0].data = datos;
            graficos.ubicacionesFrecuentes.data.datasets[0].backgroundColor = colores;
            graficos.ubicacionesFrecuentes.update();
        }
    } catch (error) {
        console.error('Error al cargar ubicaciones frecuentes:', error);
    }
};

const cargarComisionesPorMes = async () => {
    try {
        const response = await fetch(urls.comisionesMes);
        const resultado = await response.json();

        if (resultado.codigo === 1 && resultado.data) {
            // Agrupar datos por tipo de comisión
            const tiposComision = [...new Set(resultado.data.map(item => item.comision_tipo))];
            const meses = [...new Set(resultado.data.map(item => item.mes))].sort();

            const datasets = tiposComision.map((tipo, index) => {
                const datosDelTipo = meses.map(mes => {
                    const item = resultado.data.find(d => d.mes === mes && d.comision_tipo === tipo);
                    return item ? parseInt(item.cantidad) : 0;
                });

                return {
                    label: tipo,
                    data: datosDelTipo,
                    borderColor: obtenerColor(index),
                    backgroundColor: obtenerColor(index),
                    fill: false,
                    tension: 0.4
                };
            });

            graficos.comisionesMes.data.labels = meses;
            graficos.comisionesMes.data.datasets = datasets;
            graficos.comisionesMes.update();
        }
    } catch (error) {
        console.error('Error al cargar comisiones por mes:', error);
    }
};

const cargarComisionesActivas = async () => {
    try {
        const response = await fetch(urls.comisionesActivas);
        const resultado = await response.json();

        if (resultado.codigo === 1 && resultado.data) {
            const etiquetas = resultado.data.map(item => item.titulo);
            const datos = resultado.data.map(item => parseInt(item.personal_asignado));

            graficos.comisionesActivas.data.labels = etiquetas;
            graficos.comisionesActivas.data.datasets[0].data = datos;
            graficos.comisionesActivas.update();
        }
    } catch (error) {
        console.error('Error al cargar comisiones activas:', error);
    }
};

const cargarPersonalDisponible = async () => {
    try {
        const response = await fetch(urls.personalDisponible);
        const resultado = await response.json();

        if (resultado.codigo === 1 && resultado.data) {
            const datos = [
                parseInt(resultado.data.usuarios_disponibles),
                parseInt(resultado.data.usuarios_ocupados)
            ];

            graficos.personalDisponible.data.datasets[0].data = datos;
            graficos.personalDisponible.update();
        }
    } catch (error) {
        console.error('Error al cargar disponibilidad de personal:', error);
    }
};

const cargarResumenGeneral = async () => {
    try {
        const response = await fetch(urls.resumenGeneral);
        const resultado = await response.json();

        if (resultado.codigo === 1 && resultado.data) {
            const etiquetas = [
                'Total Comisiones',
                'Programadas', 
                'En Curso',
                'Completadas',
                'Total Usuarios',
                'Total Rutas'
            ];
            
            const datos = [
                parseInt(resultado.data.total_comisiones),
                parseInt(resultado.data.comisiones_programadas),
                parseInt(resultado.data.comisiones_en_curso),
                parseInt(resultado.data.comisiones_completadas),
                parseInt(resultado.data.total_usuarios),
                parseInt(resultado.data.total_rutas)
            ];

            const colores = datos.map((_, index) => obtenerColor(index));

            graficos.resumenGeneral.data.labels = etiquetas;
            graficos.resumenGeneral.data.datasets[0].data = datos;
            graficos.resumenGeneral.data.datasets[0].backgroundColor = colores;
            graficos.resumenGeneral.data.datasets[0].borderColor = colores.map(color => color.replace('0.8', '1'));
            graficos.resumenGeneral.update();
        }
    } catch (error) {
        console.error('Error al cargar resumen general:', error);
    }
};

// FUNCIÓN PRINCIPAL PARA CARGAR TODOS LOS DATOS
const cargarTodosLosDatos = async () => {
    try {
        // Mostrar indicador de carga si existe
        const loader = document.getElementById('loader');
        if (loader) loader.style.display = 'block';

        // Cargar todos los gráficos de forma asíncrona
        await Promise.all([
            cargarComisionesPorTipo(),
            cargarComisionesPorEstado(),
            cargarPersonalMasAsignado(),
            cargarUsuariosCreadores(),
            cargarDuracionPromedio(),
            cargarUbicacionesFrecuentes(),
            cargarComisionesPorMes(),
            cargarComisionesActivas(),
            cargarPersonalDisponible(),
            cargarResumenGeneral()
        ]);

        // Ocultar indicador de carga
        if (loader) loader.style.display = 'none';

        Toast.fire({
            icon: 'success',
            title: 'Estadísticas cargadas correctamente'
        });

    } catch (error) {
        console.error('Error al cargar los datos:', error);
        Toast.fire({
            icon: 'error',
            title: 'Error al cargar las estadísticas'
        });
    }
};

// INICIALIZACIÓN
document.addEventListener('DOMContentLoaded', () => {
    inicializarGraficos();
    cargarTodosLosDatos();
    
    // Actualizar datos cada 5 minutos
    setInterval(cargarTodosLosDatos, 300000);
});