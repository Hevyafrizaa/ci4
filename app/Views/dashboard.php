<?= $this->extend('template') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Dashboard</h1>

    <!-- Card Total Produk -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Produk</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalProduk; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Kategori iOS -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Kategori iOS</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $kategoriIos; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-apple-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Kategori Android -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Kategori Android</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $kategoriAndroid; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-android fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Smaller Donut Chart -->
    <div class="row">
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Produk</h6>
                </div>
                <div class="card-body" style="position: relative; height: 700px;"> <!-- Reduced card height -->
                    <canvas id="productChart" width="50%" height="50%"></canvas> <!-- Adjusted to 100% width and height of the card -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Chart.js -->
<script>
    var ctx = document.getElementById('productChart').getContext('2d');
    var productChart = new Chart(ctx, {
        type: 'pie', // Pie chart to create a donut
        data: {
            labels: ['iOS', 'Android', 'Others'], // Labels for the categories
            datasets: [{
                label: 'Jumlah Produk',
                data: [<?= $kategoriIos; ?>, <?= $kategoriAndroid; ?>, <?= $totalProduk - $kategoriIos - $kategoriAndroid; ?>], // Data for the segments
                backgroundColor: [
                    'navy', // Blue for iOS
                    'yellow', // Yellow for Android
                    'rgba(108, 117, 125, 0.5)' // Gray for Others
                ],
                borderColor: [
                    'rgba(0, 123, 255, 1)', // Blue border for iOS
                    'rgba(255, 193, 7, 1)', // Yellow border for Android
                    'rgba(108, 117, 125, 1)' // Gray border for Others
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true, // Makes the chart responsive to window resizing
            cutoutPercentage: 70, // Makes the chart a donut (cutout percentage determines the size of the hole)
            plugins: {
                legend: {
                    position: 'top', // Display legend at the top
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.label + ': ' + tooltipItem.raw; // Show the label and value in the tooltip
                        }
                    }
                }
            }
        }
    });
</script>

<?= $this->endSection() ?>
