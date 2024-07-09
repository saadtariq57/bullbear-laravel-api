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
            $widgets = Widget::paginate(10);
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
                $existingSymbolIds = $widget->widgetSymbols()->pluck('symbol_id')->toArray();

                // Process each incoming symbol
                foreach ($incomingSymbols as $incomingSymbol) {
                    $symbolId = $incomingSymbol['symbol_id']; // Corrected the key to match incoming data
                    
                    if (in_array($symbolId, $existingSymbolIds)) {
                        // Update the existing WidgetSymbol
                        $widgetSymbol = $widget->widgetSymbols()->where('symbol_id', $symbolId)->first();
                        $widgetSymbol->update([
                            'added_date' => $incomingSymbol['added_date'],
                            'price' => $incomingSymbol['price']
                        ]);
                    } else {
                        // Create a new WidgetSymbol
                        $widget->widgetSymbols()->create([
                            'symbol_id' => $symbolId,
                            'added_date' => $incomingSymbol['added_date'],
                            'price' => $incomingSymbol['price']
                        ]);
                    }
                }

                // Find symbols to delete that aren't in the incoming list
                $incomingSymbolIds = array_column($incomingSymbols, 'symbol_id'); // Corrected the key to match incoming data
                $symbolsToDelete = array_diff($existingSymbolIds, $incomingSymbolIds);
                foreach ($symbolsToDelete as $symbolIdToDelete) {
                    $widget->widgetSymbols()->where('symbol_id', $symbolIdToDelete)->delete();
                }
                
                return response()->json(['message' => 'Symbols updated successfully.']);
            } else { 
                $symbols = $widget->widgetSymbols()->select('symbol_id', 'added_date', 'price')->get();
                
                foreach ($symbols as &$symbol) {
                    $symbolDetail = Symbol::find($symbol->symbol_id);
                    if ($symbolDetail) {
                        $symbol->id = $symbolDetail->id;
                        $symbol->symbol = $symbolDetail->symbol;
                        $symbol->name = $symbolDetail->name;
                        $symbol->exchange = $symbolDetail->exchange;
                        $symbol->type = $symbolDetail->type;
                    }
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

    // API Methods
    public function getWidgetsByCategory(Request $request)
    {
        $categoryName = $request->input('category');
        $subCategoryName = $request->input('subCategory');

        $query = Widget::query();

        if ($categoryName) {
            $category = WidgetCategory::where('name', $categoryName)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        if ($subCategoryName) {
            $subCategory = WidgetCategory::where('name', $subCategoryName)->first();
            if ($subCategory) {
                $query->where('category_id', $subCategory->id);
            }
        }

        // Load widgets with symbols including symbol details
        $widgets = $query->with(['widgetSymbols.symbol'])->orderBy('display_order')->get();

        // Transform the data to include only necessary fields
        $widgets->each(function($widget) {
            $widget->symbols = $widget->widgetSymbols->map(function($widgetSymbol) {
                // Check if symbol exists
                if ($widgetSymbol->symbol) {
                    return [
                        'symbol_id' => $widgetSymbol->symbol_id,
                        'symbol' => $widgetSymbol->symbol->symbol,
                        'name' => $widgetSymbol->symbol->name,
                        'type' => $widgetSymbol->symbol->type,
                        'price' => $widgetSymbol->price,
                        'added_date' => $widgetSymbol->added_date,
                        'peak_price' => $widgetSymbol->peak_price,
                    ];
                }
                return null; // Return null if symbol does not exist
            })->filter(); // Filter out null values
            $widget->makeHidden('widgetSymbols'); // Hide the widgetSymbols relationship from the response
        });

        return response()->json($widgets);
    }

}