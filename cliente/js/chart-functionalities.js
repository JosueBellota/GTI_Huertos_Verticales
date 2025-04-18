// Function to update button style based on dataset visibility
function updateButtonStyle(index, isHidden) {
    const button = document.querySelector(`.toggle-btn:nth-child(${index + 1})`);
    if (isHidden) {
        button.classList.remove('on');
        button.classList.add('off');
    } else {
        button.classList.remove('off');
        button.classList.add('on');
    }                       
}

// Function to toggle dataset visibility along with the y-axis
function toggleDataset(index) {
    const meta = miGrafica.getDatasetMeta(index);
    const yAxisID = miGrafica.data.datasets[index].yAxisID;
    meta.hidden = !meta.hidden;

    // Toggle x-axis visibility
    const allHidden = miGrafica.data.datasets.every((dataset, i) => miGrafica.getDatasetMeta(i).hidden);
    miGrafica.options.scales.x.display = !allHidden;

    // Toggle y-axis visibility
    const allHiddenForYAxis = miGrafica.data.datasets.every((dataset, i) => {
        const datasetMeta = miGrafica.getDatasetMeta(i);
        return dataset.yAxisID !== yAxisID || datasetMeta.hidden;
    });
    miGrafica.options.scales[yAxisID].display = !allHiddenForYAxis;

    updateButtonStyle(index, meta.hidden);

    miGrafica.update();
}

// Function to select all datasets
function selectAll() {
    miGrafica.data.datasets.forEach((dataset, index) => {
        const meta = miGrafica.getDatasetMeta(index);
        meta.hidden = false;
        updateButtonStyle(index, false); // Update button to 'on' state
    });

    // Show all y-axes
    for (const yAxisID in miGrafica.options.scales) {
        miGrafica.options.scales[yAxisID].display = true;
    }

    miGrafica.update();
}

// Function to select none (hide all datasets)
function selectNone() {
    miGrafica.data.datasets.forEach((dataset, index) => {
        const meta = miGrafica.getDatasetMeta(index);
        meta.hidden = true;
        updateButtonStyle(index, true); // Update button to 'off' state
    });

    // Hide all y-axes
    for (const yAxisID in miGrafica.options.scales) {
        miGrafica.options.scales[yAxisID].display = false;
    }

    miGrafica.update();
}
