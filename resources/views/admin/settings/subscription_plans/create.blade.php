@extends('admin.layouts.master')
@section('title')
    Add Subscription Plan
@endsection
@section('page-title')
    Add New Subscription Plan
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
                    <div class="form-group my-2">
                        <label for="name">Plan Name</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>

                    <div class="form-group my-2">
                        <label for="amount">Monthly Price</label>
                        <input type="number" class="form-control" name="amount" id="amount" step="0.01">
                    </div>

                    <div class="form-group my-2">
                        <label for="amount">Monthly Price ID</label>
                        <input type="text" class="form-control" name="monthly_price_id" id="monthly_price_id">
                    </div>

                    <div class="form-group my-2">
                        <label for="yearly_price">Yearly Price</label>
                        <input type="number" class="form-control" name="yearly_price" id="yearly_price" step="0.01">
                    </div>

                    <div class="form-group my-2">
                        <label for="amount">Yearly Price ID</label>
                        <input type="text" class="form-control" name="yearly_price_id" id="yearly_price_id">
                    </div>

                    <div class="form-group my-2">
                        <label for="stripe_price_id">Stripe Product ID</label>
                        <input type="text" class="form-control" name="stripe_product_id" id="stripe_price_id">
                    </div>

                </div>

                <div class="col-md-6">
                    <div class="form-group my-2">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" id="description" rows="4"></textarea>
                    </div>
                    <div class="form-group my-2">
                        <label for="features">Features</label>
                        <div id="features-list">
                            <!-- Dynamic feature fields will be added here -->
                        </div>
                        <button type="button" class="btn btn-primary mt-2" id="add-feature">Add Feature</button>
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
    <!-- App js -->
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    <!-- Sweet Alerts js -->
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let featureCount = 0;

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