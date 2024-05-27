<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Widget;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::all();
        $widgets = Widget::all();
        return view('admin.widgets.menu', ['menus' => $menus, 'widgets' => $widgets, 'isEditing' => false]);
    }

    public function store(Request $request)
    {
        // Validate the request
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'items.*.title' => 'required|string|max:255',
        //     'items.*.url' => 'required|url',
        //     'items.*.order' => 'required|integer',
        //     // Add other validation rules as necessary
        // ]);

        // Store a new menu item
        $menu = Menu::create($request->only('name'));

        // if ($request->items) {
        //     foreach ($request->items as $item) {
        //         MenuItem::create([
        //             'menu_id' => $menu->id,
        //             'title' => $item['title'],
        //             'url' => $item['url'] ?? null,
        //             'menu_relation' => $item['menu_relation'],
        //             'parent_id' => $item['parent_id'] ?? null,
        //             'menu_type' => $item['menu_type'],
        //             'widget_id' => $item['widget_id'] ?? null,
        //             // 'widget_name' => $item['widget_name'] ?? null,
        //             'order' => $item['order'],
        //         ]);
        //     }
        // }

        return redirect()->route('admin.menus.index')->with('success', 'Menu created successfully!');
    }

    public function edit(Menu $menu)
    {
        $menus = Menu::all();
        $widgets = Widget::all();
        return view('admin.widgets.menu', ['menu' => $menu, 'menus' => $menus, 'widgets' => $widgets, 'isEditing' => true]);
    }

    public function update(Request $request, Menu $menu)
    {
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'items.*.title' => 'required|string|max:255',
        //     'items.*.url' => 'required|string|max:255',
        //     'items.*.order' => 'required|integer',
        // ]);
    
        $menu->update(['name' => $request->name]);
    
        // Track existing item IDs
        $existingItemIds = $menu->items->pluck('id')->toArray();
    
        if ($request->items) {
            foreach ($request->items as $item) {
                if (isset($item['id']) && !str_contains($item['id'], 'new-')) {
                    // Update existing item
                    $menuItem = MenuItem::find($item['id']);
                    if ($menuItem) {
                        $menuItem->update($item);
                    }
                    // Remove from existing items array
                    $existingItemIds = array_diff($existingItemIds, [$item['id']]);
                } else {
                    // Create new item
                    MenuItem::create([
                        'menu_id' => $menu->id,
                        'title' => $item['title'],
                        'view_name' => $item['view_name'] ?? null,
                        'url' => $item['url'] ?? null,
                        'menu_relation' => $item['menu_relation'],
                        'parent_id' => $item['parent_id'] ?? null,
                        'menu_type' => $item['menu_type'],
                        'widget_id' => $item['widget_id'] ?? null,
                        'order' => $item['order'],
                    ]);
                }
            }
        }
    
        // Delete items that are no longer in the form
        MenuItem::destroy($existingItemIds);
    
        return redirect()->route('admin.menus.edit', ['menu' => $menu])->with('success', 'Menu updated successfully!');
    }
    

    public function fetchMenu()
    {
        try {
            // Fetch menu items from the database based on menu_id
            $menuItems = MenuItem::where('menu_id', 1)->get();

            // Return menu items as JSON response
            return response()->json($menuItems);
        } catch (\Exception $e) {
            // Handle any errors
            return response()->json(['error' => 'Failed to fetch menu items'], 500);
        }
    }
    public function fetchMenuItems(Request $request)
{
    try {
        $category = $request->category;
        $subCategory = $request->subCategory;

        // Fetch menu items from the database based on category and subCategory
        $query = MenuItem::query();

        if ($category) {
            $query->where('title', 'indices');
        }

        if ($subCategory) {
            $query->where('title', $subCategory);
        }

        $menuItems = $query->get();

        // Return menu items as JSON response
        return response()->json($menuItems);
    } catch (\Exception $e) {
        // Handle any errors
        return response()->json(['error' => 'Failed to fetch menu items'], 500);
    }
}


}
