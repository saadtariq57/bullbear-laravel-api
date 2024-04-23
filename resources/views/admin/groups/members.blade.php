@extends('admin.layouts.master')

@section('title', 'Show Members')

@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('build/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('build/libs/datatables.net-autofill-bs4/css/autoFill.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('build/libs/datatables.net-keytable-bs4/css/keyTable.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ URL::asset('build/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('build/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Sweet Alert-->
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-title', 'Group Members')

@section('body')
    <body data-sidebar="colored">
@endsection

@section('content')
    <!-- Start your content -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <!-- Search Box for Adding Members -->
                    <div class="row mb-2">
                        <div class="form-inline float-md-start mb-3">
                            <div class="search-box me-2">
                                <div class="position-relative">
                                    <input class="form-control border" id="memberSearch" type="text" placeholder="Search Users">
                                    <table class="table mb-0">
                                        <tbody data-testid="dropdownMemberResults">
                                        <!-- Dynamically populated using JavaScript/Ajax -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Members Table -->
                    <div class="table-responsive mb-4">
                        <table id="groupMembers" class="table table-editable table-nowrap align-middle table-edits" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>Name</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Last Seen</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($members as $member)
                                <tr data-id="{{ $member->id }}">
                                    <td>{{ $member->id }}</td>
                                    <td>{{ $member->name }}</td>
                                    <td data-field="role">
                                        <select class="form-control role-select">
                                            <option value="member" {{ $member->pivot->role === 'member' ? 'selected' : '' }}>Member</option>
                                            <option value="admin" {{ $member->pivot->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                        </select>
                                    </td>
                                    <td data-field="active">
                                        <select class="form-control active-select">
                                            <option value="1" {{ $member->pivot->active ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ !$member->pivot->active ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </td>
                                    <td>{{ $member->pivot->last_seen }}</td>
                                    <td>
                                        <button class="btn btn-outline-secondary btn-sm saveMember" title="Save">
                                            <i class="fas fa-save"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm removeMember" title="Remove">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
        </div>
        <input type="hidden" id="groupId" value="{{ $group->id }}">
    </div>
@endsection

@section('scripts')
    <!-- Table Editable plugin -->
    <script src="{{ URL::asset('build/libs/table-edits/build/table-edits.min.js') }}"></script>
    <!-- Sweet Alerts js -->
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Sweet DatePicker js -->
    <script src="{{ URL::asset('build/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <!-- Sweet alert init js-->
    <script src="{{ URL::asset('build/js/pages/sweet-alerts.init.js') }}"></script>
    <!-- App js -->
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    <script>
$(document).ready(function() {
    // Function to clear the search results and input
    function clearSearchResults() {
        $('#memberSearch').val('');
        $('[data-testid="dropdownMemberResults"]').empty();
    }

    // Member search functionality
    $('#memberSearch').on('input', function() {
        let searchTerm = $(this).val().trim();
        if (!searchTerm) return; // Avoid empty search requests

        $.ajax({
            url: '/admin/users/search',
            type: 'GET',
            data: { query: searchTerm },
            success: function(data) {
                let results = '';
                data.forEach(user => {
                    results += `<tr class="MemberDropdownItem" 
                                    data-id="${user.id}" 
                                    data-name="${user.name}">
                                    <td>${user.name}</td>
                                    <td><button class="btn btn-success btn-sm addMemberToGroup">Add</button></td>
                                </tr>`;
                });
                $('[data-testid="dropdownMemberResults"]').html(results);
            }
        });
    });

    // Add Member to Group
    $(document).on('click', '.addMemberToGroup', function() {
        let memberRow = $(this).closest('tr');
        let userID = memberRow.data('id');
        let userName = memberRow.data('name');

        let newRow = `<tr data-id="${userID}">
                        <td>${userID}</td>
                        <td>${userName}</td>
                        <td data-field="role">
                            <select class="form-control role-select">
                                <option value="member">Member</option>
                                <option value="admin">Admin</option>
                            </select>
                        </td>
                        <td data-field="active">
                            <select class="form-control active-select">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </td>
                        <td>Just now</td>
                        <td>
                            <button class="btn btn-outline-secondary btn-sm saveMember" title="Save">
                                <i class="fas fa-save"></i>
                            </button>
                            <button class="btn btn-danger btn-sm removeMember" title="Remove">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>`;

        $('#groupMembers tbody').append(newRow);
        clearSearchResults(); // Clear the search input and results
    });

    // Save individual member changes
    $(document).on('click', '.saveMember', function() {
        let row = $(this).closest('tr');
        let userID = row.data('id');
        let role = row.find('.role-select').val();
        let active = row.find('.active-select').val();
            $.ajax({
                url: '/admin/groups/' + $('#groupId').val() + '/updateMember',
                type: 'POST',
                data: {
                    user_id: userID,
                    role: role,
                    active: active
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    alert("Member updated successfully.");
                },
                error: function(error) {
                    alert("Error updating member.");
                }
            });
        });

        // Remove Member from Group
        $(document).on('click', '.removeMember', function() {
            let row = $(this).closest('tr');
            let userIDToRemove = row.data('id');

            if (confirm("Are you sure you want to remove this member?")) {
                $.ajax({
                    url: '/admin/groups/' + $('#groupId').val() + '/removeMember',
                    type: 'DELETE',
                    data: {
                        user_id: userIDToRemove
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        row.remove();
                        alert("Member removed successfully.");
                    },
                    error: function(error) {
                        alert("Error removing member.");
                    }
                });
            }
        });
    });

</script>
@endsection