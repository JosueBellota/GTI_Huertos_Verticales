

  // Array de instalaciones con mediciones
// const instalaciones = [
//   {
//     id: 1,
//     name: "Instalación 1",
//     measurements: [
//       { date: "2024-05-14", humidity: 55, luminosity: 5000, ph: 7.2, salinity: 0.5, temperature: 20 },
//       { date: "2024-05-15", humidity: 60, luminosity: 5200, ph: 7.4, salinity: 0.6, temperature: 22 },
//       { date: "2024-05-16", humidity: 50, luminosity: 4800, ph: 7.1, salinity: 0.55, temperature: 21 },
//       { date: "2024-05-17", humidity: 55, luminosity: 5000, ph: 7.2, salinity: 0.5, temperature: 20 },
//       { date: "2024-05-18", humidity: 60, luminosity: 5200, ph: 7.4, salinity: 0.6, temperature: 22 },
//       { date: "2024-05-19", humidity: 50, luminosity: 4800, ph: 7.1, salinity: 0.55, temperature: 21 },
//       { date: "2024-05-20", humidity: 50, luminosity: 4800, ph: 7.1, salinity: 0.55, temperature: 21 }
//     ]
//   },
//   {
//     id: 2,
//     name: "Instalación 2",
//     measurements: [
//       { date: "2024-05-14", humidity: 90, luminosity: 4000, ph: 6.8, salinity: 0.4, temperature: 18 },
//       { date: "2024-05-15", humidity: 48, luminosity: 4200, ph: 6.9, salinity: 0.42, temperature: 19 },
//       { date: "2024-05-16", humidity: 47, luminosity: 4300, ph: 6.7, salinity: 0.43, temperature: 20 },
//       { date: "2024-05-17", humidity: 90, luminosity: 4000, ph: 6.8, salinity: 0.4, temperature: 18 },
//       { date: "2024-05-18", humidity: 48, luminosity: 4200, ph: 6.9, salinity: 0.42, temperature: 19 },
//       { date: "2024-05-19", humidity: 47, luminosity: 4300, ph: 6.7, salinity: 0.43, temperature: 20 },
//       { date: "2024-05-20", humidity: 90, luminosity: 4000, ph: 6.8, salinity: 0.4, temperature: 18 },
//       { date: "2024-05-21", humidity: 48, luminosity: 4200, ph: 6.9, salinity: 0.42, temperature: 19 },
//       { date: "2024-05-22", humidity: 47, luminosity: 4300, ph: 6.7, salinity: 0.43, temperature: 20 }
//     ]
//   }
// ];

// console.log("js de prueba", instalaciones)
  // Función para poblar el dropdown de instalaciones
  function populateInstalacionesDropdown() {
    const selectElement = document.getElementById('instalacion');

    // Clear existing options before populating
    selectElement.innerHTML = '';

    instalaciones.forEach(instalacion => {
        const option = document.createElement('option');
        option.value = instalacion.id;
        option.textContent = instalacion.name;
        selectElement.appendChild(option);
    });

    // Agregar event listener para llamar a procesarDatos cuando se selecciona una instalación
    selectElement.addEventListener('change', function () {
        const selectedId = parseInt(this.value);
        const selectedInstalacion = instalaciones.find(instalacion => instalacion.id === selectedId);
        if (selectedInstalacion) {
            procesarDatos(selectedInstalacion.measurements);
        }
    });

    // Disparar evento de cambio para cargar datos de la primera instalación por defecto
    selectElement.dispatchEvent(new Event('change'));
}


// Función para procesar los datos
function procesarDatos(data) {
  // Ordenar los datos por fecha para asegurar que estén en orden
  data.sort((a, b) => new Date(a.date) - new Date(b.date));

  // Obtener los últimos días según el filtro seleccionado
  const filtroMedidas = parseInt(document.getElementById('filtro-medidas').value);
  const lastXDaysData = data.slice(-filtroMedidas);

  // Extraer las fechas
  const lastDays = lastXDaysData.map(entry => entry.date);

  // Extraer los datos para cada sensor
  const humidityData = lastXDaysData.map(entry => entry.humidity);
  const luminosityData = lastXDaysData.map(entry => entry.luminosity);
  const phData = lastXDaysData.map(entry => entry.ph);
  const salinityData = lastXDaysData.map(entry => entry.salinity);
  const temperatureData = lastXDaysData.map(entry => entry.temperature);

  // Actualizar el objeto datos
  datos.labels = lastDays;
  datos.datasets[0].data = humidityData;
  datos.datasets[1].data = luminosityData;
  datos.datasets[2].data = phData;
  datos.datasets[3].data = salinityData;
  datos.datasets[4].data = temperatureData;

  // Actualizar el gráfico
  miGrafica.update();
}

// Función para manejar el filtro de medidas
function filtrarMediciones() {
  const selectedInstalacionId = parseInt(document.getElementById('instalacion').value);
  const selectedInstalacion = instalaciones.find(instalacion => instalacion.id === selectedInstalacionId);
  if (selectedInstalacion) {
      procesarDatos(selectedInstalacion.measurements);
  }
}

// Inicializar la carga de instalaciones al cargar la página
populateInstalacionesDropdown();