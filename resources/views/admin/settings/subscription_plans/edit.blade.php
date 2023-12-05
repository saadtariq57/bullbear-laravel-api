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
                        <div id="features-list">
                            @php
                                $features = json_decode($subscription_plan->features, true) ?: [];
                            @endphp
                            @foreach($features as $feature)
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="features[]" placeholder="Feature" value="{{ $feature }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-danger remove-feature" type="button">Remove</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-primary mt-2" id="add-feature">Add Feature</button>
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
            document.getElementById('add-feature').addEventListener('click', function () {
                let featuresList = document.getElementById('features-list');
                let newFeature = document.createElement('div');
                newFeature.classList.add('input-group', 'mb-2');
                newFeature.innerHTML = `
                    <input type="text" class="form-control" name="features[]" placeholder="Feature">
                    <div class="input-group-append">
                        <button class="btn btn-danger remove-feature" type="button">Remove</button>
                    </div>
                `;
                featuresList.appendChild(newFeature);

                newFeature.querySelector('.remove-feature').addEventListener('click', function () {
                    this.parentElement.parentElement.remove();
                });
            });

            // Add remove functionality to existing features
            document.querySelectorAll('.remove-feature').forEach(button => {
                button.addEventListener('click', function () {
                    this.parentElement.parentElement.remove();
                });
            });
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