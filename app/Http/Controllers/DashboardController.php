<?php

namespace App\Http\Controllers;

use App\Services\SSASService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $ssas;

    public function __construct(SSASService $ssas)
    {
        $this->ssas = $ssas;
    }

    public function index()
    {
        $data = $this->ssas->getDashboardData();
        $currentYear = date('Y');
        $monthlyEvolution = $this->ssas->getMonthlyEvolution($currentYear);
        $scatterData = $this->ssas->getScatterData();
        $employeeCategoryData = $this->ssas->getSalesByEmployeeAndCategory();
        $heatmapData = $this->ssas->getHeatmapData($currentYear);

        return view('dashboard.index', [
            'total_ca' => $data['total_ca'],
            'total_quantity' => $data['total_quantity'],
            'sales_by_year' => $data['sales_by_year'],
            'top_products' => $data['top_products'],
            'sales_by_category' => $data['sales_by_category'],
            'sales_by_employee' => $data['sales_by_employee'],
            'monthly_evolution' => $monthlyEvolution,
            'current_year' => $currentYear,
            'scatter_data' => $scatterData,
            'employee_category_data' => $employeeCategoryData,
            'heatmap_data' => $heatmapData,
        ]);
    }

    public function getReport(Request $request)
    {
        $type = $request->input('type', 'year');
        $year = $request->input('year', date('Y'));

        switch ($type) {
            case 'year':
                $data = $this->ssas->getSalesByYear();
                break;
            case 'quarter':
                $data = $this->ssas->getSalesByQuarter($year);
                break;
            case 'month':
                $data = $this->ssas->getSalesByMonth($year);
                break;
            case 'products':
                $top = $request->input('top', 5);
                $data = $this->ssas->getTopProducts($top);
                break;
            case 'category':
                $data = $this->ssas->getSalesByCategory();
                break;
            case 'employee':
                $data = $this->ssas->getSalesByEmployee();
                break;
            default:
                $data = $this->ssas->getSalesByYear();
        }

        return response()->json($data);
    }

    public function getMonthlyEvolution(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $data = $this->ssas->getMonthlyEvolution($year);
        return response()->json($data);
    }

    public function getScatterData()
    {
        $data = $this->ssas->getScatterData();
        return response()->json($data);
    }

    public function getEmployeeCategoryData()
    {
        $data = $this->ssas->getSalesByEmployeeAndCategory();
        return response()->json($data);
    }

    public function getHeatmapData(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $data = $this->ssas->getHeatmapData($year);
        return response()->json($data);
    }
}