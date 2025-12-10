<?php require APPROOT . '/views/templates/header.php'; ?>

<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold text-petroleum mb-2"><i class="fas fa-chart-line me-2 text-primary"></i><?php echo $data['title']; ?></h2>
        <p class="text-muted">Visualiza la tendencia histórica de precios y predicciones futuras.</p>
    </div>

    <!-- Panel de Control -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white p-4">
        <div class="row g-3 align-items-end" id="selection-form">
            <div class="col-md-5">
                <label for="product_id" class="form-label fw-bold text-muted small text-uppercase">Producto</label>
                <select id="product_id" class="form-select form-select-lg bg-light border-0">
                    <option value="" disabled selected>Seleccionar producto...</option>
                    <?php foreach($data['products'] as $product): ?>
                        <option value="<?php echo $product->id_producto; ?>"><?php echo $product->nombre; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-5">
                <label for="market_id" class="form-label fw-bold text-muted small text-uppercase">Mercado</label>
                <select id="market_id" class="form-select form-select-lg bg-light border-0">
                    <option value="" disabled selected>Seleccionar mercado...</option>
                    <?php foreach($data['markets'] as $market): ?>
                        <option value="<?php echo $market->id_mercado; ?>"><?php echo $market->nombre; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <button id="generate-chart" class="btn btn-primary btn-lg w-100 rounded-3 shadow-sm fw-bold">
                    <i class="fas fa-play me-2"></i>Ver
                </button>
            </div>
        </div>
    </div>

    <!-- Área del Gráfico -->
    <div id="chart-container" class="card border-0 shadow-lg rounded-4 p-4" style="display: none;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-petroleum mb-0" id="chart-title"></h4>
            <span class="badge bg-light text-primary border">Datos en Tiempo Real</span>
        </div>
        <div style="position: relative; height:400px; width:100%">
            <canvas id="priceChart"></canvas>
        </div>
    </div>

    <!-- Placeholder -->
    <div id="chart-placeholder" class="text-center py-5 opacity-50">
        <i class="fas fa-chart-area fa-4x text-muted mb-3"></i>
        <p class="text-muted">Selecciona los datos arriba para generar la visualización.</p>
    </div>
</div>

<style>
    .text-petroleum { color: #34495E; }
    .form-select:focus { box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1); background-color: #fff !important; }
</style>

<!-- Aquí va tu script JS original intacto -->
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

            // Mismo código JS original tuyo...
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
            chartTitle.innerText = `${productName} en ${marketName}`;
            
            if(myChart) myChart.destroy();

            const datasets = [{
                label: 'Precio Histórico (S/)',
                data: historicalData,
                borderColor: '#34495E',
                backgroundColor: 'rgba(52, 73, 94, 0.1)',
                tension: 0.3,
                borderWidth: 3,
                fill: true,
                pointRadius: 4,
                pointBackgroundColor: '#34495E'
            }];

            if (prediction && prediction.date && prediction.price) {
                const lastHistoricalPrice = historicalData[historicalData.length - 1];
                const predictionLineData = new Array(historicalData.length - 1).fill(null);
                predictionLineData.push(lastHistoricalPrice, prediction.price);
                
                datasets.push({
                    label: 'Predicción IA (S/)',
                    data: predictionLineData,
                    borderColor: '#2ECC71',
                    borderDash: [5, 5],
                    borderWidth: 2,
                    fill: false,
                    tension: 0.3,
                    pointRadius: 5,
                    pointBackgroundColor: '#2ECC71'
                });
            }

            const ctx = canvas.getContext('2d');
            myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: prediction ? historicalLabels.concat(prediction.date) : historicalLabels,
                    datasets: datasets
                },
                options: { 
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: { 
                        y: { 
                            beginAtZero: false, 
                            grid: { color: '#f0f0f0' },
                            ticks: { callback: function(value) { return 'S/ ' + value.toFixed(2); }, font: {family: 'Poppins'} } 
                        },
                        x: { grid: { display: false }, ticks: { font: {family: 'Poppins'} } }
                    },
                    plugins: {
                        legend: { labels: { font: { family: 'Poppins' } } }
                    }
                }
            });

        } catch (error) {
            console.error('Error:', error);
            chartPlaceholder.innerHTML = '<div class="alert alert-danger rounded-3">No hay suficientes datos para graficar este producto.</div>';
            chartContainer.style.display = 'none';
            chartPlaceholder.style.display = 'block';
        }
    });
});
</script>
<?php require APPROOT . '/views/templates/footer.php'; ?>