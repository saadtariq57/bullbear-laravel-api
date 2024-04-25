@extends('admin.layouts.master')

@section('title')
    Edit Group
@endsection

@section('page-title')
    Edit Group
@endsection

@section('body')
    <body data-sidebar="colored">
@endsection

@section('content')
    <div class="row">
        <form id="editGroupForm" enctype="multipart/form-data" onsubmit="event.preventDefault(); submitForm();">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="group_name">Group Name</label>
                        <input type="text" class="form-control" name="group_name" id="group_name" value="{{ $group->group_name }}">
                    </div>

                    <div class="form-group">
                        <label for="group_title">Group Title</label>
                        <input type="text" class="form-control" name="group_title" value="{{ $group->group_title }}">
                    </div>

                    <div class="form-group">
                        <label for="avatar">Avatar</label>
                        <input type="file" class="form-control" name="avatar">
                        <img src="{{ URL::asset('uploads/' . $group->avatar) }}" class="rounded-circle me-2" height="100px" width="100px">
                    </div>

                    <div class="form-group">
                        <label for="cover">Cover Image</label>
                        <input type="file" class="form-control" name="cover">
                        <img src="{{ URL::asset('uploads/' . $group->cover) }}" class="rounded-circle me-2" height="100px" width="100px">
                    </div>

                    <div class="form-group">
                        <label for="about">About</label>
                        <textarea class="form-control" name="about" rows="3">{{ $group->about }}</textarea>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="symbol">Symbol</label>
                        <input type="text" class="form-control" name="symbol" id="symbol" value="{{ $group->symbol }}">
                    </div>

                    <div class="form-group">
                        <label for="exchange">Exchange</label>
                        <input type="text" class="form-control" name="exchange" id="exchange" value="{{ $group->exchange }}">
                    </div>

                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select class="form-control" name="category_id">
                            @foreach(App\Models\GroupCategory::all() as $category)
                                <option value="{{ $category->id }}" {{ $group->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="privacy">Privacy</label>
                        <select class="form-control" name="privacy">
                            <option value="public" {{ $group->privacy == 'public' ? 'selected' : '' }}>Public</option>
                            <option value="private" {{ $group->privacy == 'private' ? 'selected' : '' }}>Private</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="join_privacy">Join Privacy</label>
                        <select class="form-control" name="join_privacy">
                            <option value="public" {{ $group->join_privacy == 'public' ? 'selected' : '' }}>Public</option>
                            <option value="private" {{ $group->join_privacy == 'private' ? 'selected' : '' }}>Private</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="active">Active</label>
                        <select class="form-control" name="active">
                            <option value="1" {{ $group->active ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ !$group->active ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <button type="button" class="btn btn-success float-right" onclick="submitForm()">Update Group</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    function submitForm() {
        const formData = new FormData(document.getElementById('editGroupForm'));

        axios.post('{{ route("admin.groups.update", $group->id) }}', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
        .then(function (response) {
            Swal.fire({
                title: 'Success!',
                text: response.data.message,
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/admin/groups'; 
                }
            });
        })
        .catch(function (error) {
            Swal.fire({
                title: 'Error!',
                text: error.response.data.message || 'Failed to update group.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
    }

</script>
@endsection
