@extends('admin.layouts.master')

@section('title')
    @if (isset($isEditing) && $isEditing)
        Edit Menu: {{ $menu->name }}
    @else
        Menus
    @endif
@endsection

@section('page-title')
    Menus
@endsection

@section('css')
    <!-- Sweet Alert-->
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('body')

    <body data-sidebar="colored">
        <style>
            .select-menu {
                width: 200px;
            }
        </style>
    @endsection

    @section('content')
        <div class="row bg-white">
            <div class="col-lg-12">
                <div class="d-flex align-items-center gap-2 p-3 fs-5">
                    <span>Select a menu to edit:</span>
                    <select id="menuSelect" class="form-select select-menu">
                        <option value="" selected disabled>Select a menu</option>
                        @foreach ($menus as $menuOption)
                            <option value="{{ $menuOption->id }}"
                                {{ isset($isEditing) && $isEditing && $menuOption->id == $menu->id ? 'selected' : '' }}>
                                {{ $menuOption->name }}
                            </option>
                        @endforeach
                    </select>
                    <button id="selectMenuButton" class="btn btn-primary" onclick="selectMenu()">Select</button>
                    @if (isset($isEditing) && $isEditing)
                        <p id="orText" class="m-0">or</p>
                        <button id="createNewMenuButton" class="btn btn-border" onclick="createNewMenu()">Create a new
                            menu</button>
                    @endif
                </div>
            </div>
        </div>
        <div id="menuForm" class="row bg-white mt-4 py-4 px-3">
            <form
                action="{{ isset($isEditing) && $isEditing ? route('admin.menus.update', $menu->id) : route('admin.menus.store') }}"
                method="POST" class="row">
                @csrf
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label for="menunameFormControlInput1" class="form-label">Menu Name</label>
                        <input type="text" name="name" class="form-control" id="menunameFormControlInput1"
                            placeholder="Enter Menu Name" value="{{ isset($isEditing) && $isEditing ? $menu->name : '' }}">
                    </div>
                </div>
                <div class="col-lg-4 align-self-center mt-2">
                    <button type="submit"
                        class="btn btn-primary">{{ isset($isEditing) && $isEditing ? 'Update' : 'Save' }}</button>
                </div>
            </form>
            <div class="col-lg-12 mt-4">
                @if (isset($isEditing) && $isEditing)
                    <h4>Menu Items</h4>
                    <form action="{{ route('admin.menus.update', $menu->id) }}" method="POST">
                        @csrf
                        {{-- @method('PUT') --}}
                        <input type="hidden" name="name" value="{{ $menu->name }}">
                        <div id="menuItemsContainer">
                            @foreach ($menu->items as $item)
                                <div class="menu-item" data-id="{{ $item->id }}">
                                    <input type="hidden" name="items[{{ $loop->index }}][id]"
                                        value="{{ $item->id }}">
                                    <div class="row mb-3">
                                        <div class="col-lg-2">
                                            <label for="title-{{ $item->id }}" class="form-label">Title</label>
                                            <input type="text" name="items[{{ $loop->index }}][title]"
                                                class="form-control" id="title-{{ $item->id }}"
                                                value="{{ $item->title }}">
                                        </div>
                                        <div class="col-lg-2">
                                            <label for="url-{{ $item->id }}" class="form-label">URL</label>
                                            <input type="text" name="items[{{ $loop->index }}][url]"
                                                class="form-control" id="url-{{ $item->id }}"
                                                value="{{ $item->url }}">
                                        </div>
                                        <div class="col-lg-1">
                                            <label for="menu_relation-{{ $item->id }}" class="form-label">Menu
                                                Relation</label>
                                            <select name="items[{{ $loop->index }}][menu_relation]"
                                                class="form-select menu-relation-select"
                                                id="menu_relation-{{ $item->id }}">
                                                <option value="none"
                                                    {{ $item->menu_relation == 'none' ? 'selected' : '' }}>None</option>
                                                <option value="parent"
                                                    {{ $item->menu_relation == 'parent' ? 'selected' : '' }}>Parent
                                                </option>
                                                <option value="child"
                                                    {{ $item->menu_relation == 'child' ? 'selected' : '' }}>Child</option>
                                                <option value="sub-child"
                                                    {{ $item->menu_relation == 'sub-child' ? 'selected' : '' }}>Sub-Child
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-lg-1 parent-select-div">
                                            <label for="parent-{{ $item->id }}"
                                                class="form-label parent-label">Parent</label>
                                            <select name="items[{{ $loop->index }}][parent_id]"
                                                class="form-select parent-select" id="parent-{{ $item->id }}">
                                                <option value="" {{ is_null($item->parent_id) ? 'selected' : '' }}>
                                                    None</option>
                                                @foreach ($menu->items as $parentItem)
                                                    @if ($parentItem->menu_relation == 'parent' || $parentItem->menu_relation == 'child')
                                                        <option value="{{ $parentItem->id }}"
                                                            {{ $item->parent_id == $parentItem->id ? 'selected' : '' }}>
                                                            {{ $parentItem->title }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-1">
                                            <label for="order-{{ $item->id }}" class="form-label">Order</label>
                                            <input type="number" name="items[{{ $loop->index }}][order]"
                                                class="form-control" id="order-{{ $item->id }}"
                                                value="{{ $item->order }}">
                                        </div>
                                        <div class="col-lg-1">
                                            <label for="menu_type-{{ $item->id }}" class="form-label">Menu Type</label>
                                            <select name="items[{{ $loop->index }}][menu_type]"
                                                class="form-select menu-type-select" id="menu_type-{{ $item->id }}">
                                                <option value="none" {{ $item->menu_type == 'none' ? 'selected' : '' }}>
                                                    None</option>
                                                <option value="widget"
                                                    {{ $item->menu_type == 'widget' ? 'selected' : '' }}>Widget</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-2 widget-name-div"
                                            style="display: {{ $item->menu_type == 'widget' ? 'block' : 'none' }};">
                                            <label for="widget_name-{{ $item->id }}"
                                                class="form-label widget-name-label">Widget Name</label>
                                            <select name="items[{{ $loop->index }}][widget_id]"
                                                class="form-select widget-name-input"
                                                id="widget_name-{{ $item->id }}">
                                                <option value="" selected disabled>Select a widget</option>
                                                @foreach ($widgets as $widget)
                                                    <option value="{{ $widget->id }}"
                                                        {{ $item->widget_id == $widget->id ? 'selected' : '' }}>
                                                        {{ $widget->widget_title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" name="items[{{ $loop->index }}][widget_name]"
                                                value="{{ $item->widget_name }}">
                                        </div>
                                        <div class="col-lg-1">
                                            <button type="button" class="btn btn-danger mt-4"
                                                onclick="removeMenuItem(this)">Remove</button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-border" onclick="addMenuItem()">Add Menu Item</button>
                        <button type="submit" class="btn btn-primary">Update Menu Items</button>
                    </form>
                @endif
            </div>
        </div>
    @endsection

    @section('scripts')
        <script src="{{ URL::asset('build/js/app.js') }}"></script>
        <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
        <script>
            @if (session('success'))
                Swal.fire({
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            @endif

            function selectMenu() {
                const selectedValue = document.getElementById('menuSelect').value;
                if (selectedValue) {
                    window.location.href = `/admin/menus/${selectedValue}`;
                }
            }

            function createNewMenu() {
                window.location.href = `/admin/menus`;
            }

            let itemIndex = {{ isset($menu) ? $menu->items->count() : 1 }};

            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.menu-type-select').forEach(function(select) {
                    select.addEventListener('change', function() {
                        const parentDiv = select.closest('.menu-item');
                        const widgetNameDiv = parentDiv.querySelector('.widget-name-div');

                        if (select.value === 'widget') {
                            widgetNameDiv.style.display = 'block';
                        } else {
                            widgetNameDiv.style.display = 'none';
                        }
                    });
                });

                // document.querySelectorAll('.menu-relation-select').forEach(function(select) {
                //     select.addEventListener('change', function() {
                //         const parentDiv = select.closest('.menu-item');
                //         const parentSelectDiv = parentDiv.querySelector('.parent-select-div');

                //         if (select.value === 'child' || select.value === 'sub-child') {
                //             parentSelectDiv.style.display = 'block';
                //             const parentSelect = parentSelectDiv.querySelector('.parent-select');
                //             const parentLabel = parentSelectDiv.querySelector('.parent-label');

                //             parentSelect.innerHTML = '<option value="">None</option>';
                //             const relation = select.value === 'child' ? 'parent' : 'child';
                //             document.querySelectorAll(
                //                 `.menu-relation-select option[value="${relation}"]`).forEach(
                //                 function(option) {
                //                     const parentItem = option.closest('.menu-item');
                //                     const parentItemId = parentItem.dataset.id;
                //                     const parentItemTitle = parentItem.querySelector(
                //                         '[name$="[title]"]').value;
                //                     parentSelect.innerHTML +=
                //                         `<option value="${parentItemId}">${parentItemTitle}</option>`;
                //                 });
                //             parentLabel.textContent = select.value === 'child' ? 'Parent' : 'Child';
                //         } else {
                //             parentSelectDiv.style.display = 'none';
                //         }
                //     });
                // });
            });

            @if (isset($isEditing) && $isEditing)
                function addMenuItem() {
                    const container = document.getElementById('menuItemsContainer');
                    const newItem = document.createElement('div');
                    newItem.classList.add('menu-item');
                    newItem.dataset.id = `new-${itemIndex}`;
                    newItem.innerHTML = `
                <input type="hidden" name="items[${itemIndex}][id]" value="new-${itemIndex}">
                <div class="row mb-3">
                    <div class="col-lg-2">
                        <label for="title-new-${itemIndex}" class="form-label">Title</label>
                        <input type="text" name="items[${itemIndex}][title]" class="form-control" id="title-new-${itemIndex}">
                    </div>
                    <div class="col-lg-2">
                        <label for="url-new-${itemIndex}" class="form-label">URL</label>
                        <input type="text" name="items[${itemIndex}][url]" class="form-control" id="url-new-${itemIndex}">
                    </div>
                    <div class="col-lg-1">
                        <label for="menu_relation-new-${itemIndex}" class="form-label">Menu Relation</label>
                        <select name="items[${itemIndex}][menu_relation]" class="form-select menu-relation-select" id="menu_relation-new-${itemIndex}">
                            <option value="none">None</option>
                            <option value="parent">Parent</option>
                            <option value="child">Child</option>
                            <option value="sub-child">Sub-Child</option>
                        </select>
                    </div>
                    <div class="col-lg-1 parent-select-div">
                        <label for="parent-new-${itemIndex}" class="form-label parent-label">Parent</label>
                        <select name="items[${itemIndex}][parent_id]" class="form-select parent-select" id="parent-new-${itemIndex}">
                            <option value="">None</option>
                            @foreach ($menu->items as $parentItem)
                                @if ($parentItem->menu_relation == 'parent' || $parentItem->menu_relation == 'child')
                                    <option value="{{ $parentItem->id }}">{{ $parentItem->title }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-1">
                        <label for="order-new-${itemIndex}" class="form-label">Order</label>
                        <input type="number" name="items[${itemIndex}][order]" class="form-control" id="order-new-${itemIndex}">
                    </div>
                    <div class="col-lg-1">
                        <label for="menu_type-new-${itemIndex}" class="form-label">Menu Type</label>
                        <select name="items[${itemIndex}][menu_type]" class="form-select menu-type-select" id="menu_type-new-${itemIndex}">
                            <option value="none">None</option>
                            <option value="widget">Widget</option>
                        </select>
                    </div>
                    <div class="col-lg-2 widget-name-div" style="display: none;">
                        <label for="widget_name-new-${itemIndex}" class="form-label">Widget Name</label>
                        <select name="items[${itemIndex}][widget_id]" class="form-select widget-name-input" id="widget_name-new-${itemIndex}">
                            <option value="" selected disabled>Select a widget</option>
                            @foreach ($widgets as $widget)
                                <option value="{{ $widget->id }}">{{ $widget->widget_title }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="items[${itemIndex}][widget_name]">
                    </div>
                    <div class="col-lg-1">
                        <button type="button" class="btn btn-danger mt-4" onclick="removeMenuItem(this)">Remove</button>
                    </div>
                </div>
            `;
                    container.appendChild(newItem);
                    itemIndex++;
                    // Attach the event listeners to the new select elements
                    newItem.querySelector('.menu-type-select').addEventListener('change', function() {
                        const parentDiv = newItem;
                        const widgetNameDiv = parentDiv.querySelector('.widget-name-div');

                        if (this.value === 'widget') {
                            widgetNameDiv.style.display = 'block';
                        } else {
                            widgetNameDiv.style.display = 'none';
                        }
                    });
                    // newItem.querySelector('.menu-relation-select').addEventListener('change', function() {
                    //     const parentDiv = newItem;
                    //     const parentSelectDiv = parentDiv.querySelector('.parent-select-div');

                    //     if (this.value === 'child' || this.value === 'sub-child') {
                    //         parentSelectDiv.style.display = 'block';
                    //         const parentSelect = parentSelectDiv.querySelector('.parent-select');
                    //         const parentLabel = parentSelectDiv.querySelector('.parent-label');

                    //         parentSelect.innerHTML = '<option value="">None</option>';
                    //         const relation = this.value === 'child' ? 'parent' : 'child';
                    //         document.querySelectorAll(`.menu-relation-select option[value="${relation}"]`).forEach(
                    //             function(option) {
                    //                 const parentItem = option.closest('.menu-item');
                    //                 const parentItemId = parentItem.dataset.id;
                    //                 const parentItemTitle = parentItem.querySelector('[name$="[title]"]').value;
                    //                 parentSelect.innerHTML +=
                    //                     `<option value="${parentItemId}">${parentItemTitle}</option>`;
                    //             });
                    //         parentLabel.textContent = this.value === 'child' ? 'Parent' : 'Child';
                    //     } else {
                    //         parentSelectDiv.style.display = 'none';
                    //     }
                    // });
                }
            @endif

            function removeMenuItem(button) {
                const menuItem = button.closest('.menu-item');
                menuItem.remove();
            }
        </script>
    @endsection
