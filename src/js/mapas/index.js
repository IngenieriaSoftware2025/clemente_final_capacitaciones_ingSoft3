import L from 'leaflet';

// Crear el mapa centrado en Guatemala
const map = L.map('map').setView([14.6349, -90.5069], 13);

// Agregar las tiles del mapa
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(map);

// Agregar UN solo marcador
L.marker([14.6349, -90.5069]).addTo(map)
  .bindPopup('Mi Tienda de Celulares')
  .openPopup();

  // AGREGAR MÁS MARCADORES CON NUEVAS COORDENADAS:
L.marker([14.6280, -90.5150]).addTo(map)
  .bindPopup('Sucursal Zona 1');

L.marker([14.5995, -90.5069]).addTo(map)
  .bindPopup('Sucursal Zona 10');

L.marker([14.6500, -90.4800]).addTo(map)
  .bindPopup('Sucursal Zona 4');




  
// Polígono usando múltiples coordenadas
const zonaCentro = [
    [14.6400, -90.5200],
    [14.6400, -90.4900], 
    [14.6200, -90.4900],
    [14.6200, -90.5200]
];

L.polygon(zonaCentro, {color: 'blue'}).addTo(map)
    .bindPopup('Zona de entrega gratuita');


// Círculo en una ubicación específica
    L.circle([14.6349, -90.5069], {
    color: 'red',
    fillColor: '#f03',
    fillOpacity: 0.2,
    radius: 500
}).addTo(map).bindPopup('Zona de cobertura principal');