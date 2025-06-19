import L from 'leaflet';

// Crear el mapa centrado en Guatemala
const map = L.map('map').setView([14.6349, -90.5069], 13);

// Agregar las tiles del mapa
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(map);

// Agregar UN SOLO marcador - PEREZ COMISIONES
L.marker([14.6349, -90.5069]).addTo(map)
  .bindPopup('PEREZ COMISIONES - Sistema de Gestión')
  .openPopup();