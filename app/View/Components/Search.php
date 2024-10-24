<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Symbol;
use App\Models\Group;
use App\Models\GroupMember;
use Illuminate\Support\Facades\Auth;

class Search extends Component
{
    public $symbols;
    public $groups;
    public $members;
    public $searchQuery;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($searchQuery = '')
    {
        $this->searchQuery = $searchQuery;
        $this->symbols = Symbol::when($searchQuery, function($query) use ($searchQuery) {
                            $query->where('symbol', 'like', "%{$searchQuery}%")
                                  ->orWhere('company_name', 'like', "%{$searchQuery}%")
                                  ->orWhere('name', 'like', "%{$searchQuery}%");
                        })
                        ->get();

        $this->groups = Group::when($searchQuery, function($query) use ($searchQuery) {
                            $query->where('group_name', 'like', "%{$searchQuery}%")
                                  ->orWhere('group_title', 'like', "%{$searchQuery}%");
                        })
                        ->get();

        $this->members = GroupMember::when($searchQuery, function($query) use ($searchQuery) {
                            $query->where('name', 'like', "%{$searchQuery}%");
                        })
                        ->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.search');
    }
}
