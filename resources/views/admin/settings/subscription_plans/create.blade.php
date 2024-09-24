@extends('admin.layouts.master')
@section('title')
    Add Subscription Plan
@endsection
@section('page-title')
    Add New Subscription Plan
@endsection
@section('css')
    <!-- Sweet Alert-->
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('body')
    <body data-sidebar="colored">
@endsection
@section('content')
    <!-- Start your content -->
    <div class="row">
        <form action="{{ route('admin.settings.subscription_plans.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <!-- Plan Details -->
                    <div class="form-group my-2">
                        <label for="name">Plan Name</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>

                    <div class="form-group my-2">
                        <label for="monthly_price">Monthly Price</label>
                        <input type="number" class="form-control" name="monthly_price" id="monthly_price" step="0.01" required>
                    </div>

                    <div class="form-group my-2">
                        <label for="monthly_price_id">Monthly Price ID</label>
                        <input type="text" class="form-control" name="monthly_price_id" id="monthly_price_id" required>
                    </div>

                    <div class="form-group my-2">
                        <label for="yearly_price">Yearly Price</label>
                        <input type="number" class="form-control" name="yearly_price" id="yearly_price" step="0.01">
                    </div>

                    <div class="form-group my-2">
                        <label for="yearly_price_id">Yearly Price ID</label>
                        <input type="text" class="form-control" name="yearly_price_id" id="yearly_price_id">
                    </div>

                    <div class="form-group my-2">
                        <label for="stripe_product_id">Stripe Product ID</label>
                        <input type="text" class="form-control" name="stripe_product_id" id="stripe_product_id" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <!-- Description -->
                    <div class="form-group my-2">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" id="description" rows="4" required></textarea>
                    </div>

                    <!-- Features -->
                    <div class="form-group my-2">
                        <label for="features">Features</label>
                        <div id="features-list">
                            <!-- Features will be dynamically added here -->
                        </div>
                        <button type="button" class="btn btn-primary mt-2" id="add-feature-btn">Add Feature</button>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group my-2">
                        <button type="submit" class="btn btn-success float-right">Create Plan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
    <!-- Sweet Alerts js -->
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- App js -->
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            console.log("Add Subscription Plan page loaded.");

            // Predefined list of available features
            const availableFeatures = [
                { name: "real_time_watchlists", label: "Real-Time Watchlists", type: "limit", placeholder: "Limit" },
                { name: "market_insights_digest", label: "Market Insights Digest", type: "boolean" },
                { name: "community_chatroom_access", label: "Community Chatroom Access", type: "boolean" },
                { name: "richtv_live", label: "RichTV Live", type: "boolean" },
                { name: "daily_watchlist_snapshot_email", label: "Daily Watchlist Snapshot Email", type: "limit", placeholder: "Limit" },
                { name: "basic_alerts", label: "Basic Alerts", type: "boolean" },
                { name: "stock_screener_access", label: "Stock Screener Access", type: "boolean" },
                { name: "richpicks_pro_access", label: "RichPicks Pro Access", type: "boolean" },
                { name: "pro_chatroom_access", label: "Pro Chatroom Access", type: "boolean" },
                { name: "daily_pro_watchlist_email", label: "Daily Pro Watchlist Email", type: "limit", placeholder: "Limit" },
                { name: "monthly_personal_session", label: "Monthly Personal Session", type: "limit", placeholder: "Limit" },
                { name: "advanced_alerts_symbol_notifications", label: "Advanced Alerts & Symbol Notifications", type: "limit", placeholder: "Limit" },
                { name: "educational_content", label: "Educational Content", type: "boolean" },
                { name: "advanced_stock_screener", label: "Advanced Stock Screener", type: "boolean" },
                { name: "richpicks_premium", label: "RichPicks Premium", type: "boolean" },
                { name: "advanced_exam_trading_videos", label: "Advanced Exam & Trading Videos", type: "boolean" },
                { name: "pro_meeting_chat_sessions", label: "Pro Meeting & Chat Sessions", type: "boolean" },
                { name: "daily_premium_watchlist_email", label: "Daily Premium Watchlist Email", type: "limit", placeholder: "Limit" },
                { name: "monthly_personal_sessions", label: "Monthly Personal Sessions", type: "limit", placeholder: "Limit" },
                { name: "exclusive_market_intelligence", label: "Exclusive Market Intelligence", type: "boolean" },
            ];

            const featuresList = document.getElementById('features-list');
            const addFeatureBtn = document.getElementById('add-feature-btn');

            // Function to create feature HTML using template literals
            function generateFeatureHTML(feature) {
                console.log("Generating HTML for feature:", feature);
                return `
                    <div class="card my-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>Feature</label>
                                    <input type="hidden" name="feature_name[]" value="${feature.name}">
                                    <input type="text" class="form-control" value="${feature.label}" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Feature Type</label>
                                    <input type="hidden" name="featureType[]" value="${feature.type}">
                                    <input type="text" class="form-control" value="${feature.type}" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Limit</label>
                                    ${feature.type === 'limit' ? 
                                        `<input type="number" class="form-control" name="limit[]" placeholder="${feature.placeholder}" required>` 
                                        : `
                                            <input type="hidden" name="limit[]" value="">
                                            <input type="text" class="form-control" value="N/A" readonly>
                                        `}
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Enabled</label>
                                    <select class="form-control" name="enabled[]" required>
                                        <option value="1" selected>Enabled</option>
                                        <option value="0">Disabled</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Action</label>
                                    <button type="button" class="btn btn-danger btn-sm remove-feature-btn">Remove Feature</button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }

            // Add Feature Button Click
            addFeatureBtn.addEventListener('click', function () {
                console.log("Add Feature button clicked.");
                // Get already added features to prevent duplicates
                const addedFeatures = Array.from(document.querySelectorAll('input[name="feature_name[]"]')).map(input => input.value);
                console.log("Added features:", addedFeatures);

                const remainingFeatures = availableFeatures.filter(feature => !addedFeatures.includes(feature.name));
                console.log("Remaining features to add:", remainingFeatures);

                if (remainingFeatures.length === 0) {
                    Swal.fire({
                        title: 'No More Features',
                        text: 'All available features have been added.',
                        icon: 'info',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Show a selection dialog using SweetAlert2
                Swal.fire({
                    title: 'Select a Feature to Add',
                    input: 'select',
                    inputOptions: remainingFeatures.reduce((acc, feature) => {
                        acc[feature.name] = feature.label;
                        return acc;
                    }, {}),
                    inputPlaceholder: 'Select a feature',
                    showCancelButton: true,
                }).then((result) => {
                    if (result.isConfirmed && result.value) {
                        const selectedFeature = remainingFeatures.find(f => f.name === result.value);
                        if (selectedFeature) {
                            console.log("Selected feature to add:", selectedFeature);
                            const featureHTML = generateFeatureHTML(selectedFeature);
                            featuresList.insertAdjacentHTML('beforeend', featureHTML);
                        }
                    } else {
                        console.log("Add Feature action cancelled.");
                    }
                }).catch(error => {
                    console.error("Error adding feature:", error);
                });
            });

            // Remove Feature Button Click
            featuresList.addEventListener('click', function (e) {
                if (e.target && e.target.matches('button.remove-feature-btn')) {
                    console.log("Remove Feature button clicked.");
                    e.target.closest('.card').remove();
                }
            });

            // Initialize the form without any features
            // Users can add features using the "Add Feature" button
            console.log("Initialize features list as empty.");
        });
    </script>
    @if(session('success'))
        <script>
            Swal.fire({
                title: 'Success!',
                text: '{{ session("success") }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            Swal.fire({
                title: 'Error!',
                text: '{{ session("error") }}',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>
    @endif
@endsection