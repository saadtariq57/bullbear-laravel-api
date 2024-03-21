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
                                    <tr data-id="{{ $member->user_id }}">
                                        <td>{{ $member->user_id }}</td>
                                        <td>{{ $member->user->name }}</td>
                                        <td data-field="role">{{ $member->role }}</td>
                                        <td data-field="active">{{ $member->active ? 'Active' : 'Inactive' }}</td>
                                        <td>{{ $member->last_seen }}</td>
                                        <td>
                                            <a class="btn btn-outline-secondary btn-sm edit" title="Edit">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <a class="btn btn-danger btn-sm removeMember" title="Remove">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <button id="updateMembers" class="btn btn-success" disabled>Update Members</button>
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
        // Initialize table editable
        function initializeEditable(target) {
            // Initialize all fields with common editable settings
            target.editable({
                edit: function (values) {
                    $(".edit i", this)
                        .removeClass('fa-pencil-alt')
                        .addClass('fa-save')
                        .attr('title', 'Save');
                },
                save: function (values) {
                    $(".edit i", this)
                        .removeClass('fa-save')
                        .addClass('fa-pencil-alt')
                        .attr('title', 'Edit');
                     // Enable UpdateSymbols Button
                     $('#updateSymbols').prop('disabled', false);
                },
                cancel: function (values) {
                    $(".edit i", this)
                        .removeClass('fa-save')
                        .addClass('fa-pencil-alt')
                        .attr('title', 'Edit');
                }
            });

            // Special initialization for date field
            target.find('td[data-field="added_date"]').editable({
                type: 'date',
                format: 'yyyy-mm-dd',
                viewformat: 'yyyy-mm-dd',
                datepicker: {
                    weekStart: 1
                }
            });
        }

        // Initialize table editable for existing rows
        initializeEditable($('.table-edits tr'));

        // Temporary array to store current member IDs
        let currentMembers = @json($members).map(member => member.user_id);

        // Member search functionality
        $('#memberSearch').on('input', function() {
            let searchTerm = $(this).val();
            $.ajax({
                url: '/admin/users/search', // Adjust the URL to your search endpoint
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

            if (currentMembers.includes(userID)) {
                // Member already exists in the group
                alert("Member already exists in the group.");
                return;
            }

            let newRow = `<tr data-id="${userID}">
                            <td>${userID}</td>
                            <td>${userName}</td>
                            <td data-field="role">member</td>
                            <td data-field="active">Active</td>
                            <td>Just now</td>
                            <td>
                                <a class="btn btn-outline-secondary btn-sm edit" title="Edit">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <a class="btn btn-danger btn-sm removeMember" title="Remove">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                          </tr>`;

            $('#groupMembers tbody').append(newRow);
            initializeEditable($('#groupMembers tbody tr:last'));
            $('#updateMembers').prop('disabled', false);
            currentMembers.push(userID);
        });

        // Update Members
        $('#updateMembers').click(function() {
            let membersData = [];
            $('#groupMembers tbody tr').each(function() {
                let row = $(this);
                let memberData = {
                    group_id: $('#groupId').val(),
                    user_id: row.data('id'), 
                    role: row.find('td[data-field="role"]').text(),
                    active: row.find('td[data-field="active"]').text() === 'Active' ? 1 : 0
                };
                membersData.push(memberData);
            });

            $.ajax({
                url: '/admin/groups/' + $('#groupId').val() + '/members', 
                type: 'POST',
                data: { members: membersData },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    alert("Members updated successfully.");
                    $('#updateMembers').prop('disabled', true);
                },
                error: function(error) {
                    alert("Error updating members.");
                }
            });
        });

        // Remove Member from Group
        $(document).on('click', '.removeMember', function() {
            let row = $(this).closest('tr');
            let userIDToRemove = row.data('id');

            // Confirm removal
            if (confirm("Are you sure you want to remove this member?")) {
                currentMembers = currentMembers.filter(userID => userID !== userIDToRemove);
                row.remove();
                $('#updateMembers').prop('disabled', false);
            }
        });
    });
</script>
@endsection