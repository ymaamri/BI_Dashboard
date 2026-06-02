<?php

namespace App\Services;

class SSASService
{
    /**
     * FAKE DATA FOR DEVELOPMENT ON UBUNTU
     * When you return to Windows, replace all methods with real ADODB connection
     * See README_WINDOWS_SETUP.md for Windows version
     */

    public function getSalesByYear()
    {
        return [
            'columns' => ['Year', 'Line Total'],
            'data' => [
                ['Year' => 2024, 'Line Total' => 125000],
                ['Year' => 2025, 'Line Total' => 148000],
                ['Year' => 2026, 'Line Total' => 162000],
            ]
        ];
    }

    public function getSalesByQuarter($year = '2025')
    {
        $quarterData = [
            '2024' => [1 => 28000, 2 => 31000, 3 => 29000, 4 => 37000],
            '2025' => [1 => 33000, 2 => 35000, 3 => 38000, 4 => 42000],
            '2026' => [1 => 38000, 2 => 40000, 3 => 42000, 4 => 42000],
        ];

        $quarters = ['Q1', 'Q2', 'Q3', 'Q4'];
        $data = [];

        for ($q = 1; $q <= 4; $q++) {
            $data[] = [
                'Quarter' => $quarters[$q - 1],
                'Line Total' => $quarterData[$year][$q] ?? 0
            ];
        }

        return [
            'columns' => ['Quarter', 'Line Total'],
            'data' => $data
        ];
    }

    public function getSalesByMonth($year = '2025')
    {
        $monthData = [
            '2024' => ['January' => 9500, 'February' => 10200, 'March' => 10800, 'April' => 11200, 'May' => 11800, 'June' => 12500, 'July' => 13100, 'August' => 12800, 'September' => 13500, 'October' => 14200, 'November' => 14800, 'December' => 16200],
            '2025' => ['January' => 12500, 'February' => 13200, 'March' => 13800, 'April' => 14500, 'May' => 15100, 'June' => 15800, 'July' => 16500, 'August' => 16200, 'September' => 17000, 'October' => 17800, 'November' => 18500, 'December' => 19500],
            '2026' => ['January' => 14500, 'February' => 15200, 'March' => 15800, 'April' => 16500, 'May' => 17200, 'June' => 18000, 'July' => 18800, 'August' => 18500, 'September' => 19200, 'October' => 19800, 'November' => 20500, 'December' => 21000],
        ];

        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $data = [];

        foreach ($months as $month) {
            $data[] = [
                'Month Name' => $month,
                'Line Total' => $monthData[$year][$month] ?? 0
            ];
        }

        return [
            'columns' => ['Month Name', 'Line Total'],
            'data' => $data
        ];
    }

    public function getTopProducts($top = 5)
    {
        return [
            'columns' => ['Product Name', 'Line Total'],
            'data' => [
                ['Product Name' => 'Laptop Pro X', 'Line Total' => 45000],
                ['Product Name' => 'Gaming Mouse', 'Line Total' => 32000],
                ['Product Name' => 'Mechanical Keyboard', 'Line Total' => 28000],
                ['Product Name' => '4K Monitor', 'Line Total' => 25000],
                ['Product Name' => 'USB-C Hub', 'Line Total' => 18000],
            ]
        ];
    }

    public function getSalesByCategory()
    {
        return [
            'columns' => ['Category Name', 'Line Total'],
            'data' => [
                ['Category Name' => 'Electronics', 'Line Total' => 85000],
                ['Category Name' => 'Accessories', 'Line Total' => 45000],
                ['Category Name' => 'Software', 'Line Total' => 25000],
                ['Category Name' => 'Services', 'Line Total' => 15000],
            ]
        ];
    }

    public function getSalesByEmployee()
    {
        return [
            'columns' => ['Full Name', 'Line Total'],
            'data' => [
                ['Full Name' => 'John Doe', 'Line Total' => 52000],
                ['Full Name' => 'Jane Smith', 'Line Total' => 48000],
                ['Full Name' => 'Mike Johnson', 'Line Total' => 41000],
                ['Full Name' => 'Sarah Williams', 'Line Total' => 39000],
            ]
        ];
    }

    public function getTotalCA()
    {
        return 435000;
    }

    public function getTotalQuantity()
    {
        return 12500;
    }

    public function getDashboardData()
    {
        return [
            'total_ca' => $this->getTotalCA(),
            'total_quantity' => $this->getTotalQuantity(),
            'sales_by_year' => $this->getSalesByYear(),
            'top_products' => $this->getTopProducts(),
            'sales_by_category' => $this->getSalesByCategory(),
            'sales_by_employee' => $this->getSalesByEmployee(),
        ];
    }

    /**
     * Get monthly evolution data for line chart
     */
    public function getMonthlyEvolution($year = '2025')
    {
        $monthlyData = [
            '2024' => [9500, 10200, 10800, 11200, 11800, 12500, 13100, 12800, 13500, 14200, 14800, 16200],
            '2025' => [12500, 13200, 13800, 14500, 15100, 15800, 16500, 16200, 17000, 17800, 18500, 19500],
            '2026' => [14500, 15200, 15800, 16500, 17200, 18000, 18800, 18500, 19200, 19800, 20500, 21000],
        ];

        $months = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'];

        $data = [];
        foreach ($months as $index => $month) {
            $data[] = [
                'month' => $month,
                'value' => $monthlyData[$year][$index] ?? 0
            ];
        }

        return [
            'year' => $year,
            'data' => $data
        ];
    }

    /**
     * Scatter plot data: Quantity vs Line Total correlation
     */
    public function getScatterData()
    {
        // Generate realistic correlation data (Quantity vs Revenue)
        $data = [];
        for ($i = 1; $i <= 50; $i++) {
            $quantity = rand(1, 20);
            // Revenue increases with quantity but with some variation
            $revenue = $quantity * (rand(80, 120) + rand(-20, 20));
            $data[] = [
                'quantity' => $quantity,
                'revenue' => $revenue,
                'product' => 'Product ' . rand(1, 10)
            ];
        }

        return $data;
    }

    /**
     * Sales by Employee AND Category (Multi-dimensional)
     */
    public function getSalesByEmployeeAndCategory()
    {
        $employees = ['John Doe', 'Jane Smith', 'Mike Johnson', 'Sarah Williams'];
        $categories = ['Electronics', 'Accessories', 'Software', 'Services'];

        $data = [];
        foreach ($employees as $employee) {
            foreach ($categories as $category) {
                // Generate realistic sales data
                $baseAmount = ($employee === 'John Doe' ? 45000 :
                    ($employee === 'Jane Smith' ? 38000 :
                        ($employee === 'Mike Johnson' ? 35000 : 32000)));
                $categoryFactor = ($category === 'Electronics' ? 0.5 :
                    ($category === 'Accessories' ? 0.25 :
                        ($category === 'Software' ? 0.15 : 0.1)));
                $value = $baseAmount * $categoryFactor * (0.8 + rand(0, 40) / 100);

                $data[] = [
                    'employee' => $employee,
                    'category' => $category,
                    'amount' => round($value, 2)
                ];
            }
        }

        return $data;
    }

    /**
     * Heatmap data: Sales by Month and Category
     */
    public function getHeatmapData($year = '2025')
    {
        $months = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'];
        $categories = ['Electronics', 'Accessories', 'Software', 'Services'];

        // Different patterns for each year
        $yearPatterns = [
            '2024' => [
                'Electronics' => [8000, 8500, 9000, 9500, 10000, 10500, 11000, 11500, 12000, 14000, 15000, 16000],
                'Accessories' => [4000, 4200, 4500, 4800, 5000, 5500, 6000, 5800, 5500, 5200, 5000, 4800],
                'Software' => [3000, 3500, 3200, 3400, 3600, 3800, 4000, 4200, 4500, 4800, 5000, 5200],
                'Services' => [2000, 2100, 2200, 2300, 2400, 2500, 2600, 2700, 2800, 2900, 3000, 3100]
            ],
            '2025' => [
                'Electronics' => [10000, 10500, 11000, 11500, 12000, 13000, 14000, 14500, 15000, 17000, 18000, 19000],
                'Accessories' => [5000, 5200, 5500, 5800, 6000, 6500, 7000, 6800, 6500, 6200, 6000, 5800],
                'Software' => [4000, 4500, 4200, 4400, 4600, 4800, 5000, 5200, 5500, 5800, 6000, 6200],
                'Services' => [2500, 2600, 2700, 2800, 2900, 3000, 3100, 3200, 3300, 3400, 3500, 3600]
            ],
            '2026' => [
                'Electronics' => [12000, 12500, 13000, 13500, 14000, 15000, 16000, 16500, 17000, 19000, 20000, 21000],
                'Accessories' => [6000, 6200, 6500, 6800, 7000, 7500, 8000, 7800, 7500, 7200, 7000, 6800],
                'Software' => [5000, 5500, 5200, 5400, 5600, 5800, 6000, 6200, 6500, 6800, 7000, 7200],
                'Services' => [3000, 3100, 3200, 3300, 3400, 3500, 3600, 3700, 3800, 3900, 4000, 4100]
            ],
        ];

        $selectedData = $yearPatterns[$year] ?? $yearPatterns['2025'];
        $data = [];

        foreach ($categories as $category) {
            $data[] = [
                'category' => $category,
                'values' => $selectedData[$category]
            ];
        }

        return [
            'year' => $year,
            'months' => $months,
            'categories' => $categories,
            'data' => $data
        ];
    }
}