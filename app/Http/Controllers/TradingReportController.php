<?php

namespace App\Http\Controllers;

use App\Models\TradingReport;
use App\Models\TradingProfit;
use App\Models\TradingPerformanceCategory;
use Illuminate\Http\Request;

class TradingReportController extends Controller
{
    // Reports Index
    public function index(Request $request)
    {
        $search = $request->query('search');
        $reports = TradingReport::with('category')
            ->when($search, function ($query, $search) {
                return $query->where('title', 'LIKE', "%{$search}%")
                             ->orWhereHas('category', function ($q) use ($search) {
                                 $q->where('name', 'LIKE', "%{$search}%");
                             });
            })
            ->paginate(10);

        return view('admin.trading_reports.index', compact('reports'));
    }

    // Show Create Report Form
    public function create()
    {
        $categories = TradingPerformanceCategory::all();
        return view('admin.trading_reports.create', compact('categories'));
    }

    // Store New Report
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:trading_performance_categories,id',
            'description' => 'nullable|string',
        ]);

        TradingReport::create($data);

        return redirect()->route('admin.trading_reports.index')->with('success', 'Report created successfully.');
    }

    // Show Edit Report Form
    public function edit(TradingReport $tradingReport)
    {
        $categories = TradingPerformanceCategory::all();
        return view('admin.trading_reports.edit', compact('tradingReport', 'categories'));
    }

    // Update Report
    public function update(Request $request, TradingReport $tradingReport)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:trading_performance_categories,id',
            'description' => 'nullable|string',
        ]);

        $tradingReport->update($data);

        return redirect()->route('admin.trading_reports.index')->with('success', 'Report updated successfully.');
    }

    // Delete Report
    public function destroy(TradingReport $tradingReport)
    {
        $tradingReport->delete();
        return redirect()->route('admin.trading_reports.index')->with('success', 'Report deleted successfully.');
    }

    // Profits Index
    public function profitsIndex(Request $request, TradingReport $tradingReport)
{
    $editProfit = null;
    if ($request->has('editProfit')) {
        $editProfit = TradingProfit::find($request->query('editProfit'));
    }

    $profits = $tradingReport->profits()->paginate(10);
    return view('admin.trading_reports.profits.index', compact('tradingReport', 'profits', 'editProfit'));
}
    // Show Create Profit Form
    public function profitsCreate(TradingReport $tradingReport)
    {
        return view('admin.trading_reports.profits.create', compact('tradingReport'));
    }

    // Store New Profit
    public function profitsStore(Request $request, TradingReport $tradingReport)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'symbol' => 'required|string|max:255',
            'profit_percentage' => 'required|numeric',
            'linkedin_post_link' => 'nullable|url',
            'tradingview_post_link' => 'nullable|url',
            'web_post_link' => 'nullable|url',
        ]);

        $tradingReport->profits()->create($data);

        return redirect()->route('admin.trading_reports.profits.index', $tradingReport)->with('success', 'Profit added successfully.');
    }

    // Show Edit Profit Form
    public function profitsEdit(TradingProfit $tradingProfit)
    {
        return view('admin.trading_reports.profits.edit', compact('tradingProfit'));
    }

    // Update Profit
    public function profitsUpdate(Request $request, TradingProfit $tradingProfit)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'symbol' => 'required|string|max:255',
            'profit_percentage' => 'required|numeric',
            'linkedin_post_link' => 'nullable|url',
            'tradingview_post_link' => 'nullable|url',
            'web_post_link' => 'nullable|url',
        ]);

        $tradingProfit->update($data);

        return redirect()->route('admin.trading_reports.profits.index', $tradingProfit->report)->with('success', 'Profit updated successfully.');
    }

    // Delete Profit
    public function profitsDestroy(TradingProfit $tradingProfit)
    {
        $tradingProfit->delete();
        return redirect()->route('admin.trading_reports.profits.index', $tradingProfit->report)->with('success', 'Profit deleted successfully.');
    }

    // Categories Index
    public function categoriesIndex(Request $request)
    {
        $search = $request->query('search');
        $categories = TradingPerformanceCategory::when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', "%{$search}%")
                         ->orWhere('description', 'LIKE', "%{$search}%");
        })->paginate(10);

        return view('admin.trading_reports.performance_categories.index', compact('categories'));
    }

    // Show Create Category Form
    public function categoriesCreate()
    {
        return view('admin.trading_reports.performance_categories.create');
    }

    // Store New Category
    public function categoriesStore(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:trading_performance_categories,name',
            'description' => 'nullable|string',
        ]);

        TradingPerformanceCategory::create($data);

        return redirect()->route('admin.trading_reports.performance_categories.index')->with('success', 'Category created successfully.');
    }

    // Show Edit Category Form
    public function categoriesEdit(TradingPerformanceCategory $tradingPerformanceCategory)
    {
        return view('admin.trading_reports.performance_categories.edit', compact('tradingPerformanceCategory'));
    }

    // Update Category
    public function categoriesUpdate(Request $request, TradingPerformanceCategory $tradingPerformanceCategory)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:trading_performance_categories,name,' . $tradingPerformanceCategory->id,
            'description' => 'nullable|string',
        ]);

        $tradingPerformanceCategory->update($data);

        return redirect()->route('admin.trading_reports.performance_categories.index')->with('success', 'Category updated successfully.');
    }

    // Delete Category
    public function categoriesDestroy(TradingPerformanceCategory $tradingPerformanceCategory)
    {
        $tradingPerformanceCategory->delete();
        return redirect()->route('admin.trading_reports.performance_categories.index')->with('success', 'Category deleted successfully.');
    }
    // Fetch all categories with their reports
    public function getCategoriesWithReports()
    {
        $categories = TradingPerformanceCategory::with('reports')->get();
        return response()->json($categories);
    }

    // Fetch profits for a specific report
    public function getReportProfits($reportId)
    {
        $profits = TradingProfit::where('trading_report_id', $reportId)->get();
        return response()->json($profits);
    }
}