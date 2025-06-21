import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario } from "../funciones";
import DataTable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";
import { Chart } from "chart.js/auto";
import L from 'leaflet';

// Inicializar el mapa centrado en Guatemala
const map = L.map('map').setView([14.6349, -90.5069], 7); // Guatemala

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(map);

// Función para cargar y mostrar los dos puntos
const cargarPuntos = async () => {
    const url = `/clemente_final_capacitaciones_ingSoft3/mapas/buscarAPI`;
    const config = { method: 'GET' };

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, data } = datos;

        if (codigo == 1) {
            // Crear marcadores para cada punto
            data.forEach((punto, index) => {
                const iconColor = index === 0 ? 'red' : 'blue';
                
                const customIcon = L.divIcon({
                    className: 'custom-div-icon',
                    html: `<div style="background-color: ${iconColor}; width: 25px; height: 25px; border-radius: 50%; border: 3px solid white; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 12px;">${index + 1}</div>`,
                    iconSize: [25, 25],
                    iconAnchor: [12, 12]
                });

                L.marker([punto.lat, punto.lng], { icon: customIcon })
                    .addTo(map)
                    .bindPopup(`
                        <div style="text-align: center;">
                            <h6><strong>${punto.nombre}</strong></h6>
                            <p>${punto.descripcion}</p>
                            <small>📍 ${punto.lat.toFixed(4)}, ${punto.lng.toFixed(4)}</small>
                        </div>
                    `);
            });
        }
    } catch (error) {
        console.log('Error al cargar puntos:', error);
    }
}

// Cargar puntos al inicializar
document.addEventListener('DOMContentLoaded', async () => {
    await cargarPuntos();
});

// Agregar marcador principal de Guatemala
L.marker([14.6349, -90.5069]).addTo(map)
    .bindPopup(`
        <div style="text-align: center;">
            <h6><strong>🇬🇹 Guatemala</strong></h6>
            <p>Centro de Operaciones</p>
            <small>Sistema de Capacitaciones Militares</small>
        </div>
    `)
    .openPopup();