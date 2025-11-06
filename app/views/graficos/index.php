<?php require APPROOT . '/views/templates/header.php'; ?>
<div class="container py-4">
    <h2><i class="bi bi-graph-up-arrow"></i> <?php echo $data['title']; ?></h2>
    <p>Selecciona un producto y un mercado para visualizar la evolución de su precio a lo largo del tiempo.</p>
    <div class="card card-body mb-4">
        <div class="row g-3" id="selection-form">
            <div class="col-md-5">
                <label for="product_id" class="form-label">Producto</label>
                <select id="product_id" class="form-select">
                    <option value="" disabled selected>-- Elige un producto --</option>
                    <?php foreach($data['products'] as $product): ?>
                        <option value="<?php echo $product->id_producto; ?>"><?php echo $product->nombre; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-5">
                <label for="market_id" class="form-label">Mercado</label>
                <select id="market_id" class="form-select">
                    <option value="" disabled selected>-- Elige un mercado --</option>
                    <?php foreach($data['markets'] as $market): ?>
                        <option value="<?php echo $market->id_mercado; ?>"><?php echo $market->nombre; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button id="generate-chart" class="btn btn-primary w-100">Generar Gráfico</button>
            </div>
        </div>
    </div>
    <div id="chart-container" class="card card-body" style="display: none;">
        <h3 id="chart-title"></h3>
        <canvas id="priceChart"></canvas>
    </div>
    <div id="chart-placeholder" class="alert alert-info">
        Por favor, selecciona un producto y un mercado y haz clic en "Generar Gráfico".
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
    const generateBtn = document.getElementById('generate-chart');
    const chartContainer = document.getElementById('chart-container');
    const chartPlaceholder = document.getElementById('chart-placeholder');
    const chartTitle = document.getElementById('chart-title');
    const productIdSelect = document.getElementById('product_id');
    const marketIdSelect = document.getElementById('market_id');
    const canvas = document.getElementById('priceChart');
    let myChart = null;

    generateBtn.addEventListener('click', async function() {
        const productId = productIdSelect.value;
        const marketId = marketIdSelect.value;
        
        if (!productId || !marketId) {
            alert('Por favor, selecciona un producto y un mercado.');
            return;
        }

        const apiUrl = `<?php echo URLROOT; ?>/api/priceHistory/${productId}/${marketId}`;

        try {
            const response = await fetch(apiUrl);
            if (!response.ok) throw new Error('La respuesta de la red no fue exitosa.');
            
            const apiResponse = await response.json();

            console.log("Respuesta completa de la API:", apiResponse);

            const historicalLabels = apiResponse.labels;
            const historicalData = apiResponse.data;
            const prediction = apiResponse.prediction;

            if (!historicalData || historicalData.length < 2) {
                 throw new Error('No hay suficientes datos históricos para generar un gráfico.');
            }

            chartContainer.style.display = 'block';
            chartPlaceholder.style.display = 'none';

            const productName = productIdSelect.options[productIdSelect.selectedIndex].text;
            const marketName = marketIdSelect.options[marketIdSelect.selectedIndex].text;
            chartTitle.innerText = `Evolución de Precio: ${productName} en ${marketName}`;
            
            if(myChart) myChart.destroy();

            const datasets = [{
                label: 'Precio Histórico (S/)',
                data: historicalData,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1,
                borderWidth: 3,
                fill: false
            }];

            if (prediction && prediction.date && prediction.price) {
                console.log("Predicción recibida:", prediction);
                const lastHistoricalPrice = historicalData[historicalData.length - 1];
                
                const predictionLineData = new Array(historicalData.length - 1).fill(null);
                predictionLineData.push(lastHistoricalPrice, prediction.price);
                
                datasets.push({
                    label: 'Predicción (S/)',
                    data: predictionLineData,
                    borderColor: 'rgb(255, 99, 132)',
                    borderDash: [5, 5],
                    borderWidth: 2,
                    fill: false,
                    tension: 0.1
                });
            } else {
                console.warn("No se recibió una predicción válida desde la API.");
            }

            console.log("Datasets enviados al gráfico:", datasets);

            const ctx = canvas.getContext('2d');
            myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: prediction ? historicalLabels.concat(prediction.date) : historicalLabels,
                    datasets: datasets
                },
                options: { scales: { y: { beginAtZero: false, ticks: { callback: function(value) { return 'S/ ' + value.toFixed(2); } } } } }
            });

        } catch (error) {
            console.error('Error al generar el gráfico:', error);
            chartPlaceholder.innerHTML = '<div class="alert alert-danger">Ocurrió un error. Revisa la consola (F12) para más detalles.</div>';
            chartContainer.style.display = 'none';
            chartPlaceholder.style.display = 'block';
        }
    });
});
</script>
<?php require APPROOT . '/views/templates/footer.php'; ?>
