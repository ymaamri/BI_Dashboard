<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord - Analyse des Ventes</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-chart-matrix@1.0.0/dist/chartjs-chart-matrix.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: #f1f5f9;
            color: #1e293b;
        }
        
        .dashboard-container {
            max-width: 1600px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            margin-bottom: 24px;
        }
        
        .header h1 {
            font-size: 24px;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 4px;
        }
        
        .header p {
            font-size: 14px;
            color: #64748b;
        }
        
        .stats-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 24px;
        }
        
        @media (max-width: 1200px) {
            .stats-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 768px) {
            .stats-container {
                grid-template-columns: 1fr;
            }
        }
        
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #e2e8f0;
            transition: all 0.2s ease;
        }
        
        .stat-card:hover {
            border-color: #cbd5e1;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        
        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }
        
        .stat-header span {
            font-size: 13px;
            font-weight: 500;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .stat-icon {
            font-size: 20px;
            color: #3b82f6;
        }
        
        .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 8px;
        }
        
        .stat-trend {
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 4px;
        }
        
        .trend-up { color: #10b981; }
        .trend-down { color: #ef4444; }
        
        .charts-section {
            margin-bottom: 24px;
        }
        
        .section-title {
            font-size: 16px;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .charts-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        
        @media (max-width: 1200px) {
            .charts-grid {
                grid-template-columns: 1fr;
            }
        }
        
        .chart-card {
            background: white;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            padding: 20px;
        }
        
        .chart-card h3 {
            font-size: 14px;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .chart-card canvas {
            max-height: 280px;
            width: 100%;
        }
        
        .filter-bar {
            background: white;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            padding: 16px 20px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
        }
        
        .filter-group {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .filter-label {
            font-size: 13px;
            font-weight: 500;
            color: #64748b;
        }
        
        select, button {
            padding: 8px 16px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            font-size: 13px;
            font-family: 'Inter', sans-serif;
            background: white;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        select:hover, button:hover {
            border-color: #94a3b8;
        }
        
        button {
            background: #3b82f6;
            color: white;
            border: none;
            font-weight: 500;
        }
        
        button:hover {
            background: #2563eb;
        }
        
        .data-table-section {
            background: white;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }
        
        .data-table-section h3 {
            padding: 16px 20px;
            font-size: 14px;
            font-weight: 600;
            color: #0f172a;
            border-bottom: 1px solid #e2e8f0;
            margin: 0;
        }
        
        .table-container {
            overflow-x: auto;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th {
            text-align: left;
            padding: 12px 20px;
            background: #f8fafc;
            font-size: 13px;
            font-weight: 600;
            color: #64748b;
            border-bottom: 1px solid #e2e8f0;
        }
        
        td {
            padding: 12px 20px;
            font-size: 13px;
            color: #1e293b;
            border-bottom: 1px solid #f1f5f9;
        }
        
        tr:hover td {
            background: #f8fafc;
        }
        
        .loading {
            text-align: center;
            padding: 40px;
            color: #94a3b8;
        }
        
        .loading i {
            font-size: 24px;
            margin-bottom: 8px;
        }
        
        .heatmap-wrapper {
            overflow-x: auto;
        }
        
        #heatmapChart {
            min-width: 600px;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Header -->
        <div class="header">
            <h1>Tableau de Bord - Analyse des Ventes</h1>
            <p>Cube_Ventes_BI | Analyse des performances commerciales en temps réel</p>
        </div>
        
        <!-- KPI Cards -->
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-header">
                    <span>Chiffre d'Affaires</span>
                    <i class="fas fa-euro-sign stat-icon"></i>
                </div>
                <div class="stat-value">{{ number_format($total_ca, 0, ',', ' ') }} €</div>
                <div class="stat-trend trend-up"><i class="fas fa-arrow-up"></i> +12,3% vs année précédente</div>
            </div>
            <div class="stat-card">
                <div class="stat-header">
                    <span>Quantités Vendues</span>
                    <i class="fas fa-box stat-icon"></i>
                </div>
                <div class="stat-value">{{ number_format($total_quantity, 0, ',', ' ') }}</div>
                <div class="stat-trend trend-up"><i class="fas fa-arrow-up"></i> +8,1% vs année précédente</div>
            </div>
            <div class="stat-card">
                <div class="stat-header">
                    <span>Panier Moyen</span>
                    <i class="fas fa-chart-line stat-icon"></i>
                </div>
                <div class="stat-value">{{ number_format($total_ca > 0 ? $total_ca / $total_quantity : 0, 0, ',', ' ') }} €</div>
                <div class="stat-trend trend-up"><i class="fas fa-arrow-up"></i> +3,9% vs année précédente</div>
            </div>
            <div class="stat-card">
                <div class="stat-header">
                    <span>Transactions</span>
                    <i class="fas fa-receipt stat-icon"></i>
                </div>
                <div class="stat-value">{{ number_format($sales_by_year['data'][2]['Line Total'] ?? 0 / 100, 0, ',', ' ') }}</div>
                <div class="stat-trend trend-up"><i class="fas fa-arrow-up"></i> +5,2% vs année précédente</div>
            </div>
        </div>
        
        <!-- Row 1: Yearly & Top Products -->
        <div class="charts-section">
            <div class="section-title"><i class="fas fa-chart-simple"></i> Vue d'ensemble</div>
            <div class="charts-grid">
                <div class="chart-card">
                    <h3><i class="fas fa-chart-bar" style="color:#3b82f6;"></i> Chiffre d'Affaires par Année</h3>
                    <canvas id="yearChart"></canvas>
                </div>
                <div class="chart-card">
                    <h3><i class="fas fa-trophy" style="color:#f59e0b;"></i> Top 5 Produits</h3>
                    <canvas id="topProductsChart"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Row 2: Category & Employee -->
        <div class="charts-section">
            <div class="charts-grid">
                <div class="chart-card">
                    <h3><i class="fas fa-chart-pie" style="color:#10b981;"></i> Ventes par Catégorie</h3>
                    <canvas id="categoryChart"></canvas>
                </div>
                <div class="chart-card">
                    <h3><i class="fas fa-user-tie" style="color:#8b5cf6;"></i> Ventes par Vendeur</h3>
                    <canvas id="employeeChart"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Row 3: Monthly Trend & Scatter -->
        <div class="charts-section">
            <div class="charts-grid">
                <div class="chart-card">
                    <h3><i class="fas fa-chart-line" style="color:#06b6d4;"></i> Évolution Mensuelle - <span id="evolutionYear">{{ $current_year }}</span></h3>
                    <canvas id="monthlyEvolutionChart"></canvas>
                    <div style="margin-top: 16px; display: flex; justify-content: center; gap: 8px;">
                        <select id="evolutionYearSelect">
                            <option value="2024">2024</option>
                            <option value="2025" selected>2025</option>
                            <option value="2026">2026</option>
                        </select>
                        <button onclick="refreshMonthlyEvolution()">Actualiser</button>
                    </div>
                </div>
                <div class="chart-card">
                    <h3><i class="fas fa-chart-scatter" style="color:#ef4444;"></i> Corrélation Quantité vs CA</h3>
                    <canvas id="scatterChart"></canvas>
                    <p style="font-size: 11px; color: #94a3b8; margin-top: 12px;">Chaque point représente une transaction</p>
                </div>
            </div>
        </div>
        
        <!-- Row 4: Employee x Category & Heatmap -->
        <div class="charts-section">
            <div class="charts-grid">
                <div class="chart-card">
                    <h3><i class="fas fa-layer-group" style="color:#ec489a;"></i> Performance par Vendeur et Catégorie</h3>
                    <canvas id="employeeCategoryChart"></canvas>
                </div>
                <div class="chart-card">
                    <h3><i class="fas fa-table-cells" style="color:#14b8a6;"></i> Heatmap des Ventes - <span id="heatmapYear">{{ $current_year }}</span></h3>
                    <div class="heatmap-wrapper">
                        <canvas id="heatmapChart"></canvas>
                    </div>
                    <div style="margin-top: 16px; display: flex; justify-content: center; gap: 8px;">
                        <select id="heatmapYearSelect">
                            <option value="2024">2024</option>
                            <option value="2025" selected>2025</option>
                            <option value="2026">2026</option>
                        </select>
                        <button onclick="refreshHeatmap()">Actualiser</button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Filter Bar -->
        <div class="filter-bar">
            <div class="filter-group">
                <span class="filter-label"><i class="fas fa-chart-simple"></i> Type de rapport :</span>
                <select id="reportType">
                    <option value="year">CA par Année</option>
                    <option value="quarter">CA par Trimestre</option>
                    <option value="month">CA par Mois</option>
                    <option value="products">Top Produits</option>
                    <option value="category">CA par Catégorie</option>
                    <option value="employee">CA par Vendeur</option>
                </select>
            </div>
            <div class="filter-group" id="yearFilterGroup" style="display: none;">
                <span class="filter-label"><i class="fas fa-calendar"></i> Année :</span>
                <select id="yearSelect">
                    <option value="2024">2024</option>
                    <option value="2025" selected>2025</option>
                    <option value="2026">2026</option>
                </select>
            </div>
            <button onclick="refreshReport()"><i class="fas fa-rotate-right"></i> Actualiser</button>
        </div>
        
        <!-- Data Table -->
        <div class="data-table-section">
            <h3><i class="fas fa-table"></i> Données détaillées</h3>
            <div id="reportTable">
                <div class="loading"><i class="fas fa-spinner fa-pulse"></i><br>Chargement...</div>
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
        
        // Couleurs professionnelles
        const colors = {
            blue: '#3b82f6',
            orange: '#f59e0b',
            green: '#10b981',
            purple: '#8b5cf6',
            teal: '#14b8a6'
        };
        
        // Year Chart
        new Chart(document.getElementById('yearChart'), {
            type: 'bar',
            data: {
                labels: yearData.data.map(r => r.Year),
                datasets: [{
                    label: 'CA (€)',
                    data: yearData.data.map(r => r['Line Total']),
                    backgroundColor: colors.blue,
                    borderRadius: 6
                }]
            },
            options: { responsive: true, maintainAspectRatio: true }
        });
        
        // Top Products Chart
        new Chart(document.getElementById('topProductsChart'), {
            type: 'bar',
            data: {
                labels: topProducts.data.map(r => r['Product Name']),
                datasets: [{
                    label: 'CA (€)',
                    data: topProducts.data.map(r => r['Line Total']),
                    backgroundColor: colors.orange,
                    borderRadius: 6
                }]
            }
        });
        
        // Category Chart
        new Chart(document.getElementById('categoryChart'), {
            type: 'pie',
            data: {
                labels: categoryData.data.map(r => r['Category Name']),
                datasets: [{ data: categoryData.data.map(r => r['Line Total']), backgroundColor: [colors.blue, colors.orange, colors.green, colors.purple] }]
            }
        });
        
        // Employee Chart
        new Chart(document.getElementById('employeeChart'), {
            type: 'bar',
            data: {
                labels: employeeData.data.map(r => r['Full Name']),
                datasets: [{
                    label: 'CA (€)',
                    data: employeeData.data.map(r => r['Line Total']),
                    backgroundColor: colors.green,
                    borderRadius: 6
                }]
            }
        });
        
        // Scatter Chart
        new Chart(document.getElementById('scatterChart'), {
            type: 'scatter',
            data: {
                datasets: [{
                    label: 'Transactions',
                    data: scatterData.map(d => ({x: d.quantity, y: d.revenue})),
                    backgroundColor: colors.blue,
                    pointRadius: 5
                }]
            },
            options: {
                scales: {
                    x: { title: { display: true, text: 'Quantité' } },
                    y: { title: { display: true, text: 'CA (€)' } }
                }
            }
        });
        
        // Employee x Category Stacked Bar
        const employees = [...new Set(employeeCategoryData.map(d => d.employee))];
        const categories = [...new Set(employeeCategoryData.map(d => d.category))];
        const catColors = { 'Electronics': colors.blue, 'Accessories': colors.orange, 'Software': colors.green, 'Services': colors.purple };
        
        new Chart(document.getElementById('employeeCategoryChart'), {
            type: 'bar',
            data: {
                labels: employees,
                datasets: categories.map(cat => ({
                    label: cat,
                    data: employees.map(emp => employeeCategoryData.find(d => d.employee === emp && d.category === cat)?.amount || 0),
                    backgroundColor: catColors[cat]
                }))
            },
            options: { scales: { x: { stacked: true }, y: { stacked: true } }, responsive: true }
        });
        
        // Monthly Evolution
        let monthlyChart;
        function loadMonthlyEvolution(year) {
            fetch(`/api/monthly-evolution?year=${year}`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('evolutionYear').innerText = year;
                    if (monthlyChart) monthlyChart.destroy();
                    monthlyChart = new Chart(document.getElementById('monthlyEvolutionChart'), {
                        type: 'line',
                        data: {
                            labels: data.data.map(d => d.month),
                            datasets: [{
                                label: 'CA (€)',
                                data: data.data.map(d => d.value),
                                borderColor: colors.teal,
                                backgroundColor: 'rgba(20,184,166,0.1)',
                                fill: true,
                                tension: 0.3
                            }]
                        }
                    });
                });
        }
        
        function refreshMonthlyEvolution() { loadMonthlyEvolution(document.getElementById('evolutionYearSelect').value); }
        
        // Heatmap
        let heatmapChart;
        function refreshHeatmap() {
            const year = document.getElementById('heatmapYearSelect').value;
            document.getElementById('heatmapYear').innerText = year;
            fetch(`/api/heatmap-data?year=${year}`)
                .then(res => res.json())
                .then(data => {
                    if (heatmapChart) heatmapChart.destroy();
                    const values = [];
                    data.data.forEach((row, i) => row.values.forEach((v, j) => values.push({x: j, y: i, v: v})));
                    const maxV = Math.max(...values.map(v => v.v));
                    heatmapChart = new Chart(document.getElementById('heatmapChart'), {
                        type: 'matrix',
                        data: {
                            datasets: [{
                                data: values,
                                backgroundColor: ctx => `rgba(59,130,246,${0.3 + ctx.dataset.data[ctx.dataIndex].v / maxV * 0.6})`,
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                x: { type: 'category', labels: data.months, title: { display: true, text: 'Mois' } },
                                y: { type: 'category', labels: data.categories, title: { display: true, text: 'Catégorie' } }
                            },
                            plugins: { tooltip: { callbacks: { label: ctx => `CA: ${ctx.raw.v.toLocaleString('fr-FR')} €` } } }
                        }
                    });
                });
        }
        
        // Report Table
        function refreshReport() {
            const type = document.getElementById('reportType').value;
            let url = `/api/report?type=${type}`;
            if (type === 'quarter' || type === 'month') {
                url += `&year=${document.getElementById('yearSelect').value}`;
                document.getElementById('yearFilterGroup').style.display = 'flex';
            } else {
                document.getElementById('yearFilterGroup').style.display = 'none';
            }
            
            document.getElementById('reportTable').innerHTML = '<div class="loading"><i class="fas fa-spinner fa-pulse"></i><br>Chargement...</div>';
            
            fetch(url).then(res => res.json()).then(data => {
                if (!data.data || data.data.length === 0) {
                    document.getElementById('reportTable').innerHTML = '<div class="loading">Aucune donnée disponible</div>';
                    return;
                }
                let html = '<div class="table-container"><table><thead><tr>';
                Object.keys(data.data[0]).forEach(k => html += `<th>${k}</th>`);
                html += '</tr></thead><tbody>';
                data.data.forEach(row => {
                    html += '<tr>';
                    Object.values(row).forEach(v => {
                        let val = typeof v === 'number' ? v.toLocaleString('fr-FR') + ' €' : v;
                        html += `<td>${val}</td>`;
                    });
                    html += '</tr>';
                });
                html += '</tbody></table></div>';
                document.getElementById('reportTable').innerHTML = html;
            });
        }
        
        // Event listeners
        document.getElementById('reportType').addEventListener('change', () => {
            const type = document.getElementById('reportType').value;
            document.getElementById('yearFilterGroup').style.display = (type === 'quarter' || type === 'month') ? 'flex' : 'none';
            refreshReport();
        });
        document.getElementById('yearSelect').addEventListener('change', () => refreshReport());
        
        // Initialize
        refreshReport();
        loadMonthlyEvolution('{{ $current_year }}');
        refreshHeatmap();
    </script>
</body>
</html>