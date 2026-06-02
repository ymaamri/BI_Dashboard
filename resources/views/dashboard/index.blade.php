<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BI Dashboard - Analyse des Ventes</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-chart-matrix@1.0.0/dist/chartjs-chart-matrix.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #1e3a5f 0%, #0f2b4a 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .dashboard-container {
            max-width: 1600px;
            margin: 0 auto;
        }

        /* Header */
        .header {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 25px 30px;
            margin-bottom: 25px;
            box-shadow: 0 20px 35px -10px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .header h1 {
            font-size: 28px;
            font-weight: 700;
            background: linear-gradient(135deg, #1e3a5f 0%, #2c5f8a 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 5px;
        }

        .header h1 i {
            -webkit-text-fill-color: #2c5f8a;
        }

        .header p {
            color: #666;
            font-size: 14px;
        }

        /* Stats Cards */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 35px -10px rgba(0, 0, 0, 0.2);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #1e3a5f, #3b82f6);
        }

        .stat-icon {
            font-size: 40px;
            margin-bottom: 15px;
        }

        .stat-card h3 {
            color: #888;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .stat-card .value {
            font-size: 36px;
            font-weight: 800;
            color: #1a1a2e;
            margin-top: 5px;
        }

        .stat-card .trend {
            font-size: 12px;
            margin-top: 10px;
            color: #10b981;
        }

        /* Charts Grid */
        .charts-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(550px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .chart-card {
            background: white;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .chart-card:hover {
            transform: translateY(-3px);
        }

        .chart-card h3 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #1a1a2e;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f0f0;
        }

        .chart-card h3 i {
            margin-right: 10px;
            color: #3b82f6;
        }

        canvas {
            max-height: 320px;
            width: 100%;
        }

        /* Filters Section */
        .filters-section {
            background: white;
            border-radius: 20px;
            padding: 20px 25px;
            margin-bottom: 25px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .filters-title {
            font-weight: 600;
            margin-bottom: 15px;
            color: #1a1a2e;
        }

        .filters {
            display: flex;
            gap: 20px;
            align-items: flex-end;
            flex-wrap: wrap;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .filter-group label {
            font-size: 12px;
            font-weight: 600;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        select,
        button {
            padding: 10px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
            background: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        select:hover {
            border-color: #3b82f6;
        }

        button {
            background: linear-gradient(135deg, #1e3a5f 0%, #3b82f6 100%);
            color: white;
            border: none;
            font-weight: 600;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(59, 130, 246, 0.4);
        }

        /* Report Table */
        .report-section {
            background: white;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            margin-bottom: 25px;
        }

        .report-section h3 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #1a1a2e;
        }

        .table-container {
            overflow-x: auto;
            border-radius: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: linear-gradient(135deg, #1e3a5f 0%, #3b82f6 100%);
            color: white;
            padding: 15px;
            font-weight: 600;
            font-size: 14px;
        }

        td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #f0f0f0;
            color: #333;
            font-weight: 500;
        }

        tr:hover td {
            background-color: #eff6ff;
        }

        .heatmap-wrapper {
            width: 100%;
            overflow-x: auto;
            position: relative;
        }

        #heatmapChart {
            min-width: 800px;
        }

        /* Loading Spinner */
        .loading-spinner {
            text-align: center;
            padding: 40px;
        }

        .loading-spinner i {
            font-size: 40px;
            color: #3b82f6;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @media (max-width: 1200px) {
            .charts-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="dashboard-container">
        <!-- Header -->
        <div class="header">
            <h1><i class="fas fa-chart-line"></i> Tableau de Bord - Analyse des Ventes</h1>
            <p>Cube OLAP - Cube_Ventes_BI | Données en temps réel | Analyse multidimensionnelle</p>
        </div>

        <!-- Stats Cards -->
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-icon">💰</div>
                <h3>Chiffre d'Affaires Total</h3>
                <div class="value">{{ number_format($total_ca, 2, ',', ' ') }} €</div>
                <div class="trend"><i class="fas fa-arrow-up"></i> +12% vs année dernière</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">📦</div>
                <h3>Quantité Vendue</h3>
                <div class="value">{{ number_format($total_quantity, 0, ',', ' ') }}</div>
                <div class="trend"><i class="fas fa-arrow-up"></i> +8% vs année dernière</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">🛒</div>
                <h3>Panier Moyen</h3>
                <div class="value">{{ number_format($total_ca > 0 ? $total_ca / $total_quantity : 0, 2, ',', ' ') }} €
                </div>
                <div class="trend"><i class="fas fa-chart-line"></i> En progression</div>
            </div>
        </div>

        <!-- Charts Row 1 -->
        <div class="charts-container">
            <div class="chart-card">
                <h3><i class="fas fa-chart-bar"></i> Chiffre d'Affaires par Année</h3>
                <canvas id="yearChart"></canvas>
            </div>
            <div class="chart-card">
                <h3><i class="fas fa-trophy"></i> Top 5 Produits</h3>
                <canvas id="topProductsChart"></canvas>
            </div>
        </div>

        <!-- Charts Row 2 -->
        <div class="charts-container">
            <div class="chart-card">
                <h3><i class="fas fa-chart-pie"></i> Ventes par Catégorie</h3>
                <canvas id="categoryChart"></canvas>
            </div>
            <div class="chart-card">
                <h3><i class="fas fa-users"></i> Ventes par Vendeur</h3>
                <canvas id="employeeChart"></canvas>
            </div>
        </div>

        <!-- Charts Row 3 -->
        <div class="charts-container">
            <div class="chart-card">
                <h3><i class="fas fa-chart-line"></i> Évolution Mensuelle du CA - Année <span id="evolutionYear"
                        style="color:#3b82f6; font-weight:700;">{{ $current_year }}</span></h3>
                <canvas id="monthlyEvolutionChart"></canvas>
                <div style="margin-top: 15px; text-align: center;">
                    <select id="evolutionYearSelect">
                        <option value="2024" {{ $current_year == 2024 ? 'selected' : '' }}>2024</option>
                        <option value="2025" {{ $current_year == 2025 ? 'selected' : '' }}>2025</option>
                        <option value="2026" {{ $current_year == 2026 ? 'selected' : '' }}>2026</option>
                    </select>
                    <button onclick="refreshMonthlyEvolution()" style="margin-left: 10px;">Actualiser</button>
                </div>
            </div>
            <div class="chart-card">
                <h3><i class="fas fa-chart-scatter"></i> Corrélation : Quantité vs Chiffre d'Affaires</h3>
                <canvas id="scatterChart"></canvas>
                <p style="margin-top: 10px; font-size: 12px; color: #888;">Analyse de la corrélation entre quantité
                    vendue et montant généré</p>
            </div>
        </div>

        <!-- Charts Row 4 -->
        <div class="charts-container">
            <div class="chart-card">
                <h3><i class="fas fa-chart-stacked"></i> Performance par Vendeur et Catégorie</h3>
                <canvas id="employeeCategoryChart"></canvas>
                <p style="margin-top: 10px; font-size: 12px; color: #888;">Répartition détaillée des ventes par vendeur
                    et par catégorie</p>
            </div>
            <div class="chart-card">
                <h3><i class="fas fa-fire"></i> Heatmap des Ventes - Année <span id="heatmapYear"
                        style="color:#3b82f6; font-weight:700;">{{ $current_year }}</span></h3>
                <div class="heatmap-wrapper">
                    <canvas id="heatmapChart"></canvas>
                </div>
                <div style="margin-top: 15px; text-align: center;">
                    <select id="heatmapYearSelect">
                        <option value="2024" {{ $current_year == 2024 ? 'selected' : '' }}>2024</option>
                        <option value="2025" {{ $current_year == 2025 ? 'selected' : '' }}>2025</option>
                        <option value="2026" {{ $current_year == 2026 ? 'selected' : '' }}>2026</option>
                    </select>
                    <button onclick="refreshHeatmap()" style="margin-left: 10px;">Actualiser</button>
                </div>
            </div>
        </div>

        <!-- Filters and Report Section -->
        <div class="filters-section">
            <div class="filters-title"><i class="fas fa-sliders-h"></i> Analyse dynamique des données</div>
            <div class="filters">
                <div class="filter-group">
                    <label>Type de rapport</label>
                    <select id="reportType">
                        <option value="year">📊 CA par Année</option>
                        <option value="quarter">📅 CA par Trimestre</option>
                        <option value="month">📆 CA par Mois</option>
                        <option value="products">🏆 Top Produits</option>
                        <option value="category">📁 CA par Catégorie</option>
                        <option value="employee">👔 CA par Vendeur</option>
                    </select>
                </div>
                <div class="filter-group" id="yearFilter" style="display: none;">
                    <label>Année</label>
                    <select id="yearSelect">
                        <option value="2024">2024</option>
                        <option value="2025" selected>2025</option>
                        <option value="2026">2026</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>&nbsp;</label>
                    <button onclick="refreshReport()"><i class="fas fa-sync-alt"></i> Actualiser</button>
                </div>
            </div>
        </div>

        <!-- Report Table -->
        <div class="report-section">
            <h3><i class="fas fa-table"></i> Données détaillées du rapport</h3>
            <div id="reportTable">
                <div class="loading-spinner">
                    <i class="fas fa-spinner"></i>
                    <p>Chargement des données...</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Data from Laravel
        const yearData = @json($sales_by_year);
        const topProducts = @json($top_products);
        const categoryData = @json($sales_by_category);
        const employeeData = @json($sales_by_employee);
        const scatterData = @json($scatter_data);
        const employeeCategoryData = @json($employee_category_data);

        // Color palette - Professional Blue Theme
        const bluePalette = ['#3b82f6', '#2563eb', '#1d4ed8', '#1e40af', '#2c5f8a'];
        const orangePalette = ['#f59e0b', '#d97706', '#b45309'];
        const greenPalette = ['#10b981', '#059669', '#047857'];

        // Year Chart
        if (yearData.data && yearData.data.length > 0) {
            new Chart(document.getElementById('yearChart'), {
                type: 'bar',
                data: {
                    labels: yearData.data.map(row => row.Year),
                    datasets: [{
                        label: 'Chiffre d\'Affaires (€)',
                        data: yearData.data.map(row => row['Line Total']),
                        backgroundColor: bluePalette[0],
                        borderRadius: 10,
                        barPercentage: 0.6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: { position: 'top' },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    return 'CA: ' + context.raw.toLocaleString('fr-FR') + ' €';
                                }
                            }
                        }
                    }
                }
            });
        }

        // Top Products Chart
        if (topProducts.data && topProducts.data.length > 0) {
            new Chart(document.getElementById('topProductsChart'), {
                type: 'bar',
                data: {
                    labels: topProducts.data.map(row => row['Product Name']),
                    datasets: [{
                        label: 'Chiffre d\'Affaires (€)',
                        data: topProducts.data.map(row => row['Line Total']),
                        backgroundColor: orangePalette[0],
                        borderRadius: 10,
                        barPercentage: 0.6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    return 'CA: ' + context.raw.toLocaleString('fr-FR') + ' €';
                                }
                            }
                        }
                    }
                }
            });
        }

        // Category Chart (Pie)
        if (categoryData.data && categoryData.data.length > 0) {
            new Chart(document.getElementById('categoryChart'), {
                type: 'pie',
                data: {
                    labels: categoryData.data.map(row => row['Category Name']),
                    datasets: [{
                        data: categoryData.data.map(row => row['Line Total']),
                        backgroundColor: bluePalette,
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const value = context.raw;
                                    const percentage = ((value / total) * 100).toFixed(1);
                                    return `${context.label}: ${value.toLocaleString('fr-FR')} € (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        }

        // Employee Chart
        if (employeeData.data && employeeData.data.length > 0) {
            new Chart(document.getElementById('employeeChart'), {
                type: 'bar',
                data: {
                    labels: employeeData.data.map(row => row['Full Name']),
                    datasets: [{
                        label: 'Chiffre d\'Affaires (€)',
                        data: employeeData.data.map(row => row['Line Total']),
                        backgroundColor: greenPalette[0],
                        borderRadius: 10,
                        barPercentage: 0.6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    return 'CA: ' + context.raw.toLocaleString('fr-FR') + ' €';
                                }
                            }
                        }
                    }
                }
            });
        }

        // Scatter Chart
        if (scatterData && scatterData.length > 0) {
            new Chart(document.getElementById('scatterChart'), {
                type: 'scatter',
                data: {
                    datasets: [{
                        label: 'Transactions',
                        data: scatterData.map(item => ({ x: item.quantity, y: item.revenue })),
                        backgroundColor: bluePalette[0],
                        pointRadius: 6,
                        pointHoverRadius: 8,
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: (context) => `Quantité: ${context.parsed.x} | CA: ${context.parsed.y.toLocaleString('fr-FR')} €`
                            }
                        }
                    },
                    scales: {
                        x: {
                            title: { display: true, text: 'Quantité vendue', font: { weight: 'bold' } }
                        },
                        y: {
                            title: { display: true, text: 'Chiffre d\'Affaires (€)', font: { weight: 'bold' } },
                            ticks: {
                                callback: function (value) {
                                    return value.toLocaleString('fr-FR') + ' €';
                                }
                            }
                        }
                    }
                }
            });
        }

        // Employee & Category Stacked Bar
        if (employeeCategoryData && employeeCategoryData.length > 0) {
            const employees = [...new Set(employeeCategoryData.map(item => item.employee))];
            const categories = [...new Set(employeeCategoryData.map(item => item.category))];
            const stackedColors = ['#3b82f6', '#f59e0b', '#10b981', '#8b5cf6'];
            const datasets = categories.map((category, idx) => ({
                label: category,
                data: employees.map(emp => employeeCategoryData.find(i => i.employee === emp && i.category === category)?.amount || 0),
                backgroundColor: stackedColors[idx % stackedColors.length],
                borderRadius: 5
            }));

            new Chart(document.getElementById('employeeCategoryChart'), {
                type: 'bar',
                data: { labels: employees, datasets },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    scales: {
                        x: { stacked: true, title: { display: true, text: 'Vendeur', font: { weight: 'bold' } } },
                        y: { stacked: true, title: { display: true, text: 'Chiffre d\'Affaires (€)', font: { weight: 'bold' } } }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    return `${context.dataset.label}: ${context.raw.toLocaleString('fr-FR')} €`;
                                }
                            }
                        }
                    }
                }
            });
        }

        // Monthly Evolution
        let monthlyChart = null;
        function loadMonthlyEvolution(year) {
            fetch(`/api/monthly-evolution?year=${year}`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('evolutionYear').innerText = year;
                    const ctx = document.getElementById('monthlyEvolutionChart').getContext('2d');
                    if (monthlyChart) monthlyChart.destroy();
                    monthlyChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: data.data.map(i => i.month),
                            datasets: [{
                                label: 'Chiffre d\'Affaires (€)',
                                data: data.data.map(i => i.value),
                                borderColor: bluePalette[0],
                                backgroundColor: 'rgba(59,130,246,0.1)',
                                borderWidth: 3,
                                fill: true,
                                tension: 0.3,
                                pointBackgroundColor: bluePalette[0],
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2,
                                pointRadius: 5,
                                pointHoverRadius: 7
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: true,
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function (context) {
                                            return 'CA: ' + context.raw.toLocaleString('fr-FR') + ' €';
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    ticks: {
                                        callback: function (value) {
                                            return value.toLocaleString('fr-FR') + ' €';
                                        }
                                    }
                                }
                            }
                        }
                    });
                });
        }

        function refreshMonthlyEvolution() {
            loadMonthlyEvolution(document.getElementById('evolutionYearSelect').value);
        }

        // Heatmap
        let heatmapChart = null;
        function refreshHeatmap() {
            const year = document.getElementById('heatmapYearSelect').value;
            document.getElementById('heatmapYear').innerText = year;
            fetch(`/api/heatmap-data?year=${year}`)
                .then(res => res.json())
                .then(data => {
                    const ctx = document.getElementById('heatmapChart').getContext('2d');
                    if (heatmapChart) heatmapChart.destroy();

                    const values = [];
                    data.data.forEach((row, i) => {
                        row.values.forEach((v, j) => values.push({ x: j, y: i, v: v }));
                    });

                    const maxVal = Math.max(...values.map(v => v.v));
                    const minVal = Math.min(...values.map(v => v.v));

                    heatmapChart = new Chart(ctx, {
                        type: 'matrix',
                        data: {
                            datasets: [{
                                label: 'Chiffre d\'Affaires (€)',
                                data: values,
                                backgroundColor(context) {
                                    const val = context.dataset.data[context.dataIndex].v;
                                    const intensity = (val - minVal) / (maxVal - minVal);
                                    return `rgba(59, 130, 246, ${0.3 + intensity * 0.7})`;
                                },
                                borderWidth: 1,
                                borderColor: '#fff'
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: true,
                            scales: {
                                x: { type: 'category', labels: data.months, title: { display: true, text: 'Mois', font: { weight: 'bold' } } },
                                y: { type: 'category', labels: data.categories, title: { display: true, text: 'Catégorie', font: { weight: 'bold' } } }
                            },
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: (ctx) => `CA: ${ctx.raw.v.toLocaleString('fr-FR')} €`
                                    }
                                }
                            }
                        }
                    });
                });
        }

        // Report Table
        function refreshReport() {
            const type = document.getElementById('reportType').value;
            let url = `/api/report?type=${type}`;
            if (type === 'quarter' || type === 'month') {
                const year = document.getElementById('yearSelect').value;
                url += `&year=${year}`;
                document.getElementById('yearFilter').style.display = 'flex';
            } else {
                document.getElementById('yearFilter').style.display = 'none';
            }

            document.getElementById('reportTable').innerHTML = '<div class="loading-spinner"><i class="fas fa-spinner"></i><p>Chargement...</p></div>';

            fetch(url)
                .then(res => res.json())
                .then(data => {
                    if (!data.data || data.data.length === 0) {
                        document.getElementById('reportTable').innerHTML = '<p style="text-align:center; padding:40px;">Aucune donnée disponible</p>';
                        return;
                    }

                    let html = '<div class="table-container"><table><thead><tr>';
                    Object.keys(data.data[0]).forEach(key => html += `<th>${key}</th>`);
                    html += '</tr></thead><tbody>';
                    data.data.forEach(row => {
                        html += '<tr>';
                        Object.values(row).forEach(val => {
                            let display = typeof val === 'number' ? val.toLocaleString('fr-FR') + ' €' : val;
                            html += `<td>${display}</td>`;
                        });
                        html += '</tr>';
                    });
                    html += '</tbody></table></div>';
                    document.getElementById('reportTable').innerHTML = html;
                });
        }

        // Event Listeners
        document.getElementById('reportType').addEventListener('change', function () {
            document.getElementById('yearFilter').style.display = (this.value === 'quarter' || this.value === 'month') ? 'flex' : 'none';
            refreshReport();
        });
        document.getElementById('yearSelect').addEventListener('change', () => refreshReport());

        // Initialize everything
        refreshReport();
        loadMonthlyEvolution('{{ $current_year }}');
        refreshHeatmap();
    </script>
</body>

</html>