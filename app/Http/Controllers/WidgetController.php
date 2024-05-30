<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use App\Models\Widget;
use App\Models\WidgetCategory;
use App\Models\WidgetSymbol;
use App\Models\Symbol;
use Illuminate\Support\Facades\Log;

class WidgetController extends Controller
{
        /**
         * Display a listing of the widgets.
         */
        public function index()
        {
            $widgets = Widget::paginate(10); // Displays 10 widgets per page. You can adjust this number as needed.
            return view('admin.widgets.index', compact('widgets'));
        }

    /**
     * Display and edit the symbols of a specific widget.
     */
        public function showSymbols(Widget $widget, Request $request)
        {
            if ($request->isMethod('post')) {
                $incomingSymbols = $request->input('symbols');
                
                // Existing symbol IDs in the widget
                $existingSymbolIds = $widget->symbols()->pluck('symbol_id')->toArray();

                // Process each incoming symbol
                foreach ($incomingSymbols as $incomingSymbol) {
                    $symbolId = $incomingSymbol['symbol_Id'];
                    
                    if (in_array($symbolId, $existingSymbolIds)) {
                        // Update the existing WidgetSymbol
                        $widgetSymbol = $widget->symbols()->where('symbol_id', $symbolId)->first();
                        $widgetSymbol->update([
                            'added_date' => $incomingSymbol['added_date'],
                            'price' => $incomingSymbol['price']
                        ]);
                    } else {
                        // Create a new WidgetSymbol
                        $widget->symbols()->create([
                            'symbol_id' => $symbolId,
                            'added_date' => $incomingSymbol['added_date'],
                            'price' => $incomingSymbol['price']
                        ]);
                    }
                }

                // Find symbols to delete that aren't in the incoming list
                $incomingSymbolIds = array_column($incomingSymbols, 'symbol_Id');
                $symbolsToDelete = array_diff($existingSymbolIds, $incomingSymbolIds);
                foreach ($symbolsToDelete as $symbolIdToDelete) {
                    $widget->symbols()->where('symbol_id', $symbolIdToDelete)->delete();
                }
                
                return response()->json(['message' => 'Symbols updated successfully.']);
            } else { // It's a GET request
                $symbols = $widget->symbols()->select('symbol_id', 'added_date', 'price')->get();
                
                foreach ($symbols as &$symbol) {
                    $symbolDetail = $symbol->symbol;
                    $symbol->id = $symbolDetail->id;
                    $symbol->name = $symbolDetail->name;
                    $symbol->exchange = $symbolDetail->exchange;
                    $symbol->company_name = $symbolDetail->company_name;
                }

                return view('admin.widgets.show_symbols', ['symbols' => $symbols, 'widget' => $widget]);
            }
        }

    /**
     * Show the form for creating a new widget.
     */
    public function create()
    {
        $categories = WidgetCategory::all();
        return view('admin.widgets.create', compact('categories'));
    }


    /**
     * Store a newly created widget in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'widget_type' => 'required|string|max:255',
            'date_posted' => 'nullable|date',
            'layout' => 'nullable|string|max:255',
            'widget_title' => 'nullable|string|max:255',
            'widget_width' => 'nullable|string|max:255',
            'widget_height' => 'nullable|string|max:255',
            'symbols_length' => 'nullable|integer',
            'category_id' => 'nullable|exists:widget_categories,id',
            'display_order' => 'required|integer'
        ]);

        $widget = Widget::create($request->all());

        return redirect('/admin/widgets')->with('success', 'Widget saved!');
    }

    /**
     * Show the form for editing the specified widget.
     */
    public function edit(Widget $widget)
    {
        $categories = WidgetCategory::all();
        return view('admin.widgets.edit', compact('widget', 'categories'));
    }

    /**
     * Update the specified widget in storage.
     */
    public function update(Request $request, Widget $widget)
    {
        $request->validate([
            'widget_type' => 'required|string|max:255',
            'date_posted' => 'nullable|date',
            'layout' => 'nullable|string|max:255',
            'widget_title' => 'nullable|string|max:255',
            'widget_width' => 'nullable|string|max:255',
            'widget_height' => 'nullable|string|max:255',
            'symbols_length' => 'nullable|integer',
            'category_id' => 'nullable|exists:widget_categories,id',
            'display_order' => 'required|integer'
        ]);

        $widget->update($request->all());
        return redirect('/admin/widgets')->with('success', 'Widget updated!');
    }

    /**
     * Remove the specified widget from storage.
     */
    public function destroy(Widget $widget)
    {
        $widget->symbols()->delete();
        $widget->delete();

        return redirect('/admin/widgets')->with('success', 'Widget and its symbols deleted!');
    }
    
        public function fetchPostWordpress(Request $request, $categoryIds)
        {
            $wordpressApiUrl = config('services.wordpress.api_url');
            $wordpressApiUrl .= $categoryIds . '/?secret_key=H2F1aR6nJR7K91MmD3Fe4Q';

            try {
                $response = file_get_contents($wordpressApiUrl);
                $posts = json_decode($response, true);
                return $posts;
            } catch (\Exception $e) {
                \Log::error('Error fetching WordPress posts: ' . $e->getMessage());
                return [];
            }
        }
    //Widget Categories
    public function categoriesIndex(Request $request)
    {

        $search = $request->query('search');

        if ($search) {
            $categories = WidgetCategory::where('name', 'LIKE', "%{$search}%")
                ->paginate(10);
        } else {
            $categories = WidgetCategory::paginate(10);
        }

        return view('admin.widgets.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new group category.
     */
    public function categoriesCreate()
    {
        $categories = WidgetCategory::all();
        return view('admin.widgets.categories.create', compact('categories'));
    }

    public function categoriesStore(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'string|max:255',
            // other validation rules
        ]);
        
        WidgetCategory::create($validatedData);
        return redirect()->route('admin.widgets.categories.index')->with('success', 'Category created successfully');
    }

    public function categoriesEdit(WidgetCategory $category)
    {
        return view('admin.widgets.categories.edit', compact('category'));
    }

    public function categoriesUpdate(Request $request, WidgetCategory $category)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'string|max:255',
        ]);
        
        $category->update($validatedData);
        return redirect()->route('admin.widgets.categories.index')->with('success', 'Category updated successfully');
    }

    public function categoriesDestroy(WidgetCategory $category)
    {
        $category->delete();
        return redirect()->route('admin.widgets.categories.index')->with('success', 'Category deleted successfully');
    }

        // user widgets
        public function getWidgetData(Request $request){
            $widgetId = $request->input('widgetId');
            $widget = Widget::where('id', $widgetId)
            ->with([
                'symbols' => function ($query) {
                    $query->orderBy('created_at');
                },
                'symbols.symbol'
            ])->get();
            // $existingSymbolIds = $widget->symbols()->pluck('symbol_id')->toArray();
            return response()->json(['widgetDetails' => $widget]);
        }

        public function getSymbols($widgetId)
        {
            // $widget = $this->getWidgetData($widgetId);
            $widget = Widget::where('id', $widgetId)
            ->with([
                'symbols' => function ($query) {
                    $query->orderBy('created_at');
                },
                'symbols.symbol'
            ])
            ->first();

            if ($widget) {
                $symbolNames = $widget->symbols->pluck('symbol.symbol')->toArray();
                $stats = $this->getSymbolsStats($symbolNames);
                $widget->symbols->each(function ($widgetSymbol) use ($stats) {
                    $symbol = $widgetSymbol->symbol;
                    $symbol->stats = $stats[$symbol->symbol] ?? [];
                });

                return response()->json($widget);
            } else {
                return response()->json(['error' => 'Watchlist not found'], 404);
            }
        }
        public function getSymbolsStats($symbols)
        {
            $url = config('thirdparty.mboum.base_url');
            $url .= config('thirdparty.mboum.quote_endpoint');
            $url .= implode(',', $symbols);
            $url .= config('thirdparty.mboum.api_key');

            try {
                $response = file_get_contents($url);
                $data = json_decode($response, true);
                $stats = [];
                foreach ($data['data'] as $symbolData) {
                    $stats[$symbolData['symbol']] = $symbolData;
                }

                return $stats;
            } catch (Exception $e) {
                \Log::error('Error in getSymbolsStats: ' . $e->getMessage());
                return [];
            }
        }
}