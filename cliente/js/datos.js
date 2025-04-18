
  let datos = {
        labels: [],
        datasets: [
            {
                label: 'Humedad (%)',
                data: [],
                unit: '°C',
                fill: true,
                backgroundColor: 'rgba(97, 190, 35, 0.0)',
                borderColor: '#61be23',
                yAxisID: 'y-temp',
                tension: .5,
                pointStyle: 'rectRot',
                pointRadius: 10,
            },
            {
                label: 'Luminosidad (lx)',
                data: [],
                fill: true,
                backgroundColor: 'rgba(67, 116, 143, 0.0)',
                borderColor: '#43748F',
                yAxisID: 'y-humidity',
                tension: .5,
                pointStyle: 'rectRot',
                pointRadius: 10,
            },
            {
                label: 'Ph (ph)',
                data: [],
                fill: true,
                backgroundColor: 'rgba(97, 139, 37, 0.0)',
                borderColor: '#618B25',
                yAxisID: 'y-pressure',
                tension: .4,
                pointStyle: 'triangle',
                pointRadius: 8,
            },
            {
                label: 'Salinidad (g/L)',
                data: [],
                fill: true,
                backgroundColor: 'rgba(89, 0, 58, 0.0)',
                borderColor: '#59003a',
                yAxisID: 'y-wind',
                tension: .3,
                pointStyle: 'rect',
                pointRadius: 6,
            },
            {
                label: 'Temperatura (°C)',
                data: [],
                fill: true,
                backgroundColor: 'rgba(0, 0, 0, 0.0)',
                borderColor: '#000000',
                yAxisID: 'y-precipitation',
                tension: .2,
                pointStyle: 'circle',
                pointRadius: 5,
            }
        ]
    };

    let opciones = {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            x: {
                grid: {
                    color: 'rgba(0, 0, 0, 0.4)',
                    lineWidth: 1,
                },
                ticks: {
                    padding: 10,
                    font: {
                        size: 14 // Adjust font size for week labels
                    }
                }
            },
            'y-temp': {
                type: 'linear',
                position: 'left',
                ticks: {
                    color: '#61be23',
                    font: {
                        size: 12 // Adjust font size for y-axis ticks
                    },
                    padding: 10,
                },
                grid: {
                    color: 'rgba(0, 0, 0, 0.4)',
                    lineWidth: 1,
                },
            },
            'y-humidity': {
                type: 'linear',
                position: 'left',
                ticks: {
                    color: '#43748F',
                    font: {
                        size: 12
                    },
                },
                grid: {
                    color: 'rgba(0, 0, 0, 0.4)',
                    lineWidth: 1,
                },
            },
            'y-pressure': {
                type: 'linear',
                position: 'left',
                offset: true,
                ticks: {
                    color: '#618B25',
                    font: {
                        size: 12
                    },
                },
                grid: {
                    color: 'rgba(0, 0, 0, 0.4)',
                    lineWidth: 1,
                },
            },
            'y-wind': {
                type: 'linear',
                position: 'left',
                offset: true,
                ticks: {
                    color: '#59003a',
                    font: {
                        size: 12
                    },
                },
                grid: {
                    color: 'rgba(0, 0, 0, 0.4)',
                    lineWidth: 1,
                },
            },
            'y-precipitation': {
                type: 'linear',
                position: 'left',
                offset: true,
                ticks: {
                    color: '#000000',
                    font: {
                        size: 12
                    },
                },
                grid: {
                    color: 'rgba(0, 0, 0, 0.4)',
                    lineWidth: 1,
                },
            }
        },
        plugins: {
            legend: {
                display: false // Hide legend
            },
            title: {
                display: false,
            },
            tooltip: {
                backgroundColor: '#fff',
                titleColor: '#000',
                titleAlign: 'center',
                bodyColor: '#333',
                borderColor: '#666',
                borderWidth: 1,
            },
        },
    };

    let ctx = document.getElementById('chart').getContext('2d');
    let miGrafica = new Chart(ctx, {
        type: 'line',
        data: datos,
        options: opciones,
    });


