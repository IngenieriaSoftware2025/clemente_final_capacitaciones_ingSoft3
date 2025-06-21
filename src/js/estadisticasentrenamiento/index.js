import { Chart } from "chart.js/auto";
import Swal from "sweetalert2";

const grafico1 = document.getElementById("grafico1").getContext("2d");
const grafico2 = document.getElementById("grafico2").getContext("2d");
const grafico3 = document.getElementById("grafico3").getContext("2d");
const grafico4 = document.getElementById("grafico4").getContext("2d");
const grafico5 = document.getElementById("grafico5").getContext("2d");
const grafico6 = document.getElementById("grafico6").getContext("2d");

// Colores militares/profesionales
const coloresMilitares = [
    'rgba(34, 139, 34, 0.8)',    // Verde militar
    'rgba(25, 25, 112, 0.8)',    // Azul marino
    'rgba(139, 69, 19, 0.8)',    // Marrón
    'rgba(128, 128, 0, 0.8)',    // Oliva
    'rgba(105, 105, 105, 0.8)',  // Gris
    'rgba(220, 20, 60, 0.8)',    // Rojo comando
    'rgba(255, 140, 0, 0.8)',    // Naranja
    'rgba(75, 0, 130, 0.8)',     // Índigo
    'rgba(0, 100, 0, 0.8)',      // Verde oscuro
    'rgba(72, 61, 139, 0.8)'     // Púrpura oscuro
];

function getColorMilitar(index) {
    return coloresMilitares[index % coloresMilitares.length];
}

// 1. GRÁFICO ENTRENAMIENTOS POR CAPACITACIÓN (Barras)
window.graficaCapacitaciones = new Chart(grafico1, {
    type: 'bar',
    data: {
        labels: [],
        datasets: []
    },
    options: {
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: 'Entrenamientos por Capacitación',
                color: '#2d5a27',
                font: {
                    size: 16,
                    weight: 'bold'
                }
            },
            legend: {
                display: false
            }
        },
        scales: {
            y: { 
                beginAtZero: true,
                ticks: {
                    color: '#2d5a27'
                }
            },
            x: {
                ticks: {
                    color: '#2d5a27',
                    maxRotation: 45
                }
            }
        }
    }
});

// 2. GRÁFICO ESTADOS DE ENTRENAMIENTOS (Dona)
window.graficaEstados = new Chart(grafico2, {
    type: 'doughnut',
    data: {
        labels: [],
        datasets: []
    },
    options: {
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: 'Estados de Entrenamientos',
                color: '#1a365d',
                font: {
                    size: 16,
                    weight: 'bold'
                }
            },
            legend: {
                position: 'bottom',
                labels: {
                    color: '#1a365d'
                }
            }
        }
    }
});

// 3. GRÁFICO INSTRUCTORES MÁS ACTIVOS (Barras horizontales)
window.graficaInstructores = new Chart(grafico3, {
    type: 'bar',
    data: {
        labels: [],
        datasets: []
    },
    options: {
        responsive: true,
        indexAxis: 'y',
        plugins: {
            title: {
                display: true,
                text: 'Instructores Más Activos',
                color: '#8b4513',
                font: {
                    size: 16,
                    weight: 'bold'
                }
            },
            legend: {
                display: false
            }
        },
        scales: {
            x: { 
                beginAtZero: true,
                ticks: {
                    color: '#8b4513'
                }
            },
            y: {
                ticks: {
                    color: '#8b4513'
                }
            }
        }
    }
});

// 4. GRÁFICO ENTRENAMIENTOS POR MES (Línea)
window.graficaEntrenamientosMes = new Chart(grafico4, {
    type: 'line',
    data: {
        labels: [],
        datasets: []
    },
    options: {
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: 'Entrenamientos por Mes',
                color: '#2d5a27',
                font: {
                    size: 16,
                    weight: 'bold'
                }
            },
            legend: {
                labels: {
                    color: '#2d5a27'
                }
            }
        },
        scales: {
            x: {
                ticks: {
                    color: '#2d5a27'
                },
                grid: {
                    color: 'rgba(45, 90, 39, 0.1)'
                }
            },
            y: { 
                beginAtZero: true,
                ticks: {
                    color: '#2d5a27'
                },
                grid: {
                    color: 'rgba(45, 90, 39, 0.1)'
                }
            }
        }
    }
});

// 5. GRÁFICO COMPAÑÍAS (Barras)
window.graficaCompanias = new Chart(grafico5, {
    type: 'bar',
    data: {
        labels: [],
        datasets: []
    },
    options: {
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: 'Compañías con Más Entrenamientos',
                color: '#1a365d',
                font: {
                    size: 16,
                    weight: 'bold'
                }
            },
            legend: {
                display: false
            }
        },
        scales: {
            y: { 
                beginAtZero: true,
                ticks: {
                    color: '#1a365d'
                }
            },
            x: {
                ticks: {
                    color: '#1a365d',
                    maxRotation: 45
                }
            }
        }
    }
});

// 6. GRÁFICO ÁREAS DE ENTRENAMIENTO (Pastel)
window.graficaAreas = new Chart(grafico6, {
    type: 'pie',
    data: {
        labels: [],
        datasets: []
    },
    options: {
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: 'Áreas de Entrenamiento Más Utilizadas',
                color: '#8b4513',
                font: {
                    size: 16,
                    weight: 'bold'
                }
            },
            legend: {
                position: 'bottom',
                labels: {
                    color: '#8b4513'
                }
            }
        }
    }
});

const BuscarEstadisticasEntrenamientos = async () => {
    const url = '/clemente_final_capacitaciones_ingSoft3/API/estadisticasentrenamiento/buscar';
    const config = {
        method: 'GET'
    }

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, mensaje, capacitaciones, estados, instructores, entrenamientosMes, companias, areas } = datos;
        
        if (codigo == 1) {
            console.log('Estadísticas de entrenamientos:', datos);
            
            // 1. PROCESAR CAPACITACIONES
            if (capacitaciones && capacitaciones.length > 0) {
                const etiquetasCapacitaciones = capacitaciones.map(c => c.capacitacion);
                const datosCapacitaciones = capacitaciones.map(c => parseInt(c.cantidad_entrenamientos));
                
                window.graficaCapacitaciones.data.labels = etiquetasCapacitaciones;
                window.graficaCapacitaciones.data.datasets = [{
                    label: 'Entrenamientos',
                    data: datosCapacitaciones,
                    backgroundColor: datosCapacitaciones.map((_, index) => getColorMilitar(index)),
                    borderColor: datosCapacitaciones.map((_, index) => getColorMilitar(index).replace('0.8', '1')),
                    borderWidth: 2
                }];
                window.graficaCapacitaciones.update();
            }
            
            // 2. PROCESAR ESTADOS
            if (estados && estados.length > 0) {
                const etiquetasEstados = estados.map(e => e.estado);
                const datosEstados = estados.map(e => parseInt(e.cantidad));
                
                window.graficaEstados.data.labels = etiquetasEstados;
                window.graficaEstados.data.datasets = [{
                    data: datosEstados,
                    backgroundColor: datosEstados.map((_, index) => getColorMilitar(index)),
                    borderColor: '#ffffff',
                    borderWidth: 3
                }];
                window.graficaEstados.update();
            }
            
            // 3. PROCESAR INSTRUCTORES
            if (instructores && instructores.length > 0) {
                const etiquetasInstructores = instructores.map(i => 
                    `${i.instructor_grado} ${i.instructor_nombre}`.substring(0, 30)
                );
                const datosInstructores = instructores.map(i => parseInt(i.total_entrenamientos));
                
                window.graficaInstructores.data.labels = etiquetasInstructores;
                window.graficaInstructores.data.datasets = [{
                    label: 'Entrenamientos Dirigidos',
                    data: datosInstructores,
                    backgroundColor: datosInstructores.map((_, index) => getColorMilitar(index)),
                    borderColor: datosInstructores.map((_, index) => getColorMilitar(index).replace('0.8', '1')),
                    borderWidth: 2
                }];
                window.graficaInstructores.update();
            }
            
            // 4. PROCESAR ENTRENAMIENTOS POR MES
            if (entrenamientosMes && entrenamientosMes.length > 0) {
                const mesesNombres = ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 
                                    'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'];
                
                const etiquetasMeses = entrenamientosMes.map(e => 
                    `${mesesNombres[parseInt(e.mes) - 1]} ${e.anio}`
                );
                const datosMeses = entrenamientosMes.map(e => parseInt(e.total_entrenamientos));
                
                window.graficaEntrenamientosMes.data.labels = etiquetasMeses;
                window.graficaEntrenamientosMes.data.datasets = [{
                    label: 'Entrenamientos por Mes',
                    data: datosMeses,
                    backgroundColor: 'rgba(34, 139, 34, 0.3)',
                    borderColor: 'rgba(34, 139, 34, 1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: 'rgba(34, 139, 34, 1)',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 6
                }];
                window.graficaEntrenamientosMes.update();
            }
            
            // 5. PROCESAR COMPAÑÍAS
            if (companias && companias.length > 0) {
                const etiquetasCompanias = companias.map(c => 
                    c.compania_nombre.length > 25 ? c.compania_nombre.substring(0, 25) + '...' : c.compania_nombre
                );
                const datosCompanias = companias.map(c => parseInt(c.total_entrenamientos));
                
                window.graficaCompanias.data.labels = etiquetasCompanias;
                window.graficaCompanias.data.datasets = [{
                    label: 'Entrenamientos',
                    data: datosCompanias,
                    backgroundColor: datosCompanias.map((_, index) => getColorMilitar(index)),
                    borderColor: datosCompanias.map((_, index) => getColorMilitar(index).replace('0.8', '1')),
                    borderWidth: 2
                }];
                window.graficaCompanias.update();
            }
            
            // 6. PROCESAR ÁREAS
            if (areas && areas.length > 0) {
                const etiquetasAreas = areas.map(a => a.area_nombre);
                const datosAreas = areas.map(a => parseInt(a.total_entrenamientos));
                
                window.graficaAreas.data.labels = etiquetasAreas;
                window.graficaAreas.data.datasets = [{
                    data: datosAreas,
                    backgroundColor: datosAreas.map((_, index) => getColorMilitar(index)),
                    borderColor: '#ffffff',
                    borderWidth: 3
                }];
                window.graficaAreas.update();
            }

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
        console.log('Error al cargar estadísticas:', error);
        await Swal.fire({
            position: "center",
            icon: "error",
            title: "Error de conexión",
            text: "No se pudieron cargar las estadísticas",
            showConfirmButton: true,
        });
    }
}

// Llamar la función al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    BuscarEstadisticasEntrenamientos();
});

// Recargar estadísticas cada 5 minutos
setInterval(BuscarEstadisticasEntrenamientos, 300000);