@extends('admin.layouts.master')
@section('title')
    Edit Subscription Plan
@endsection
@section('page-title')
    Edit Subscription Plan
@endsection
@section('css')
    <!-- Sweet Alert-->
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('body')
    <body data-sidebar="colored">
@endsection
@section('content')
    <!--  Start your content -->
    <div class="row">
        <form action="{{ route('admin.settings.subscription_plans.update', $subscription_plan->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group my-2">
                        <label for="name">Plan Name</label>
                        <input type="text" class="form-control" name="name" value="{{$subscription_plan->name}}">
                    </div>

                    <div class="form-group my-2">
                        <label for="monthly_price">Monthly Price</label>
                        <input type="number" class="form-control" name="monthly_price" value="{{$subscription_plan->monthly_price}}" step="0.01">
                    </div>

                    <div class="form-group my-2">
                        <label for="yearly_price">Yearly Price</label>
                        <input type="number" class="form-control" name="yearly_price" value="{{ $subscription_plan->yearly_price }}" step="0.01">
                    </div>

                    <!-- Non-editable fields -->
                    <div class="form-group my-2">
                        <label>Stripe Product ID</label>
                        <input type="text" class="form-control" value="{{$subscription_plan->stripe_product_id}}" disabled>
                        <input type="hidden" name="stripe_product_id" value="{{$subscription_plan->stripe_product_id}}">
                    </div>
                    <div class="form-group my-2">
                        <label>Stripe Monthly Price ID</label>
                        <input type="text" class="form-control" value="{{$subscription_plan->stripe_monthly_price_id}}" disabled>
                        <input type="hidden" name="stripe_monthly_price_id" value="{{$subscription_plan->stripe_monthly_price_id}}">
                    </div>
                    <div class="form-group my-2">
                        <label>Stripe Yearly Price ID</label>
                        <input type="text" class="form-control" value="{{$subscription_plan->stripe_yearly_price_id}}" disabled>
                        <input type="hidden" name="stripe_yearly_price_id" value="{{$subscription_plan->stripe_yearly_price_id}}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group my-2">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" rows="4">{{$subscription_plan->description}}</textarea>
                    </div>
                    <!-- Features -->
                    <div class="form-group my-2">
                        <label for="features">Features</label>
                        <div id="features-list"></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-success float-right">
                            Save Changes
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
    <!-- App js -->
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const existingFeatures = {!! json_encode($planFeatures) !!};
            function generateFeatureHTML(feature) {
                return `
                    <div class="input-group mb-2">
                        <input type="text" class="form-control" name="feature_name[]" value="${feature.feature_name}" readonly>
                        <input type="number" class="form-control" name="limit[]" placeholder="Limit" value="${feature.limit}">
                        <select class="form-control" name="enabled[]">
                            <option value="1" ${feature.enabled == 1 ? 'selected' : ''}>Enabled</option>
                            <option value="0" ${feature.enabled == 0 ? 'selected' : ''}>Disabled</option>
                        </select>
                        <select class="form-control" name="featureType[]">
                            <option value="" ${feature.feature_type == 'null' ? 'selected' : ''}>Select Feature Type</option>
                            <option value="Free" ${feature.feature_type == 'Free' ? 'selected' : ''}>Free</option>
                            <option value="Basic" ${feature.feature_type == 'Basic' ? 'selected' : ''}>Basic</option>
                            <option value="Advanced" ${feature.feature_type == 'Advanced' ? 'selected' : ''}>Advanced</option>
                            <option value="Pro" ${feature.feature_type == 'Pro' ? 'selected' : ''}>Pro</option>
                            <option value="Premium" ${feature.feature_type == 'Premium' ? 'selected' : ''}>Premium</option>
                        </select>
                    </div>
                `;
            }
            function addFeaturesToForm() {
                const featuresList = document.getElementById('features-list');
                existingFeatures.forEach(feature => {
                    const featureHTML = generateFeatureHTML(feature);
                    featuresList.insertAdjacentHTML('beforeend', featureHTML);
                });
            }
            addFeaturesToForm();
            // document.getElementById('add-feature').addEventListener('click', function () {
            //     let featuresList = document.getElementById('features-list');
            //     let newFeature = document.createElement('div');
            //     newFeature.classList.add('input-group', 'mb-2');
            //     newFeature.innerHTML = `
            //         <input type="text" class="form-control" name="feature_name[]" placeholder="Feature Name">
            //         <input type="number" class="form-control" name="limit[]" placeholder="Limit">
            //         <select class="form-control" name="enabled[]">
            //             <option value="1">Enable</option>
            //             <option value="0">Disable</option>
            //         </select>
            //         <select class="form-control" name="featureType[]">
            //             <option value="Free">Free</option>
            //             <option value="Basic">Basic</option>
            //             <option value="Advanced">Advanced</option>
            //             <option value="Pro">Pro</option>
            //             <option value="Premium">Premium</option>
            //         </select>
            //     `;
            //     featuresList.appendChild(newFeature);

            //     newFeature.querySelector('.remove-feature').addEventListener('click', function () {
            //         this.parentElement.parentElement.remove();
            //     });
            // });

            // Add remove functionality to existing features
            // document.querySelectorAll('.remove-feature').forEach(button => {
            //     button.addEventListener('click', function () {
            //         this.parentElement.parentElement.remove();
            //     });
            // });
        });
    </script>
    <!-- Sweet Alerts js -->
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
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