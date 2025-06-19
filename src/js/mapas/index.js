import L from 'leaflet';


const map = L.map('map').setView([14.6349, -90.5069], 13);


L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(map);


L.marker([14.6349, -90.5069]).addTo(map)
  .bindPopup('area de entrenamiento')
  .openPopup();


L.marker([14.6280, -90.5150]).addTo(map)
  .bindPopup('Sucursal Zona 1');

L.marker([14.5995, -90.5069]).addTo(map)
  .bindPopup('Sucursal Zona 10');

L.marker([14.6500, -90.4800]).addTo(map)
  .bindPopup('Sucursal Zona 4');


L.polygon(zonaCentro, {color: 'blue'}).addTo(map)
    .bindPopup('Poligono de Pistola');

