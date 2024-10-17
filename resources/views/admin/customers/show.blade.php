@extends('adminlte::page')

@section('title', 'View Customer')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>View Customer - {{ $customer->name }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.customers.index') }}">Customer</a></li>
                <li class="breadcrumb-item active">View Customer</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <table class="table table-bordered w-100 text-left mb-3">
                        <tr>
                            <th style="width: 30%;">Customer Name</th>
                            <td>{{ $customer->name ?? '' }}</td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td>{{ $customer->phone ?? '' }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $customer->email ?? '' }}</td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td>{{ $customer->address ?? '' }}</td>
                        </tr>
                        <tr>
                            <th>Date of Birth</th>
                            <td>{{ $customer->dob ? \Carbon\Carbon::parse($customer->dob)->format('d M Y') : '' }}</td>
                        </tr>
                        <tr>
                            <th>Anniversary Date</th>
                            <td>{{ $customer->anniversary_date ? \Carbon\Carbon::parse($customer->anniversary_date)->format('d M Y') : '' }}</td>
                        </tr>
                        <tr>
                            <th>Registration Date</th>
                            <td>{{ $customer->registration_date ? \Carbon\Carbon::parse($customer->registration_date)->format('d M Y') : '' }}</td>
                        </tr>
                        <tr>
                            <th>Family Details</th>
                            <td>
                                @if (!empty($customer->family_details))
                                    @php
                                        $familyDetails = json_decode($customer->family_details, true);
                                        $relations = $familyDetails['relation_type'] ?? [];
                                        $names = $familyDetails['family_name'] ?? [];
                                        $ages = $familyDetails['family_age'] ?? [];
                                    @endphp
                                <ul>
                                    @foreach($relations as $index => $relation)
                                        <li class="text-capitalize">{{ $names[$index] ?? '' }} ({{ $ages[$index] ?? '' }}) - {{ $relation }}</li>
                                    @endforeach
                                </ul>

                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                    </table>

                    <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <a href="{{ route('admin.customers.index') }}" class="btn btn-success">Go Back</a>
                        @can('customers.update')
                            <a href="{{ route('admin.customers.edit', ['customer' => $customer->id]) }}" class="btn btn-warning"><i class="fa fa-pen"></i> Edit</a>
                        @endcan
                        @can('customers.delete')
                            <button onclick="isDelete(this)" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                        @endcan
                    </form>

                    <div class="row mt-4 mb-4">
                        <div class="col-md-12">
                            <h5>Activity Log</h5>
                            @if($activities->isEmpty())
                                <p>No activities found for this customer.</p>
                            @else
                                <div class="table-responsive">
                                    <table id="activityTable" class="table order-table table-bordered w-100">
                                        <thead>
                                        <tr>
                                            <th>SL.</th>
                                            <th>Action</th>
                                            <th>Admin</th>
                                            <th>IP Address</th>
                                            <th>Date</th>
                                            <th>Details</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($activities as $key => $activity)
                                            @php
                                                $activityData = json_decode($activity->data, true);
                                                $adminName = $activity->admin->name ?? 'Unknown';
                                            @endphp
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td class="text-capitalize">{{ $activity->action }}</td>
                                                <td>{{ $adminName }}</td>
                                                <td>{{ $activity->ip_address }}</td>
                                                <td>{{ $activity->created_at->format('d M Y H:i A') }}</td>
                                                <td>
                                                    <a class="badge badge-info badge-sm " style="cursor: pointer" data-toggle="modal"
                                                       data-target="#activityModal-{{ $activity->id }}">
                                                        <i class="fa fa-eye"></i> Details
                                                    </a>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="activityModal-{{ $activity->id }}" tabindex="-1" role="dialog" aria-labelledby="activityModalLabel-{{ $activity->id }}" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="activityModalLabel-{{ $activity->id }}">Activity Details</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <pre>{{ json_encode($activityData, JSON_PRETTY_PRINT) }}</pre>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer')
    <strong>Developed by <a href="https://www.techyfo.com">Techyfo</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
        <b>version</b> {{ env('DEV_VERSION') }}
    </div>
@stop

@section('plugins.toastr', true)
@section('plugins.Sweetalert2', true)
@section('plugins.datatablesPlugins', true)
    @section('plugins.Datatables', true)

    @section('css')
    @stop

    @section('js')
        <script>
            function isDelete(button) {
                event.preventDefault();
                var form = $(button).closest("form");
                Swal.fire({
                    title: @json(__('Delete Customer')),
                    text: @json(__('Are you sure you want to delete this?')),
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: @json(__('Delete')),
                    cancelButtonText: @json(__('Cancel')),
                }).then((result) => {
                    if (result.value) {
                        // Trigger the form submission
                        form.submit();
                    }
                });
            }

            $(document).ready(function() {
                $("#activityTable").DataTable({
                    dom: 'Bfrtip',
                    responsive: true,
                    lengthChange: false,
                    autoWidth: false,
                    searching: true,
                    ordering: true,
                    info: true,
                    paging: true,
                    buttons: [
                        {
                            text: "Created",
                            action: function(e, dt, node, config) {
                                dt.column(1).search("created").draw();
                            }
                        },
                        {
                            text: "Updated",
                            action: function(e, dt, node, config) {
                                dt.column(1).search("updated").draw();
                            }
                        },
                        {
                            text: "Deleted",
                            action: function(e, dt, node, config) {
                                dt.column(1).search("deleted").draw();
                            }
                        },
                        { extend: 'copy', text: 'Copy' },
                        { extend: 'csv', text: 'Export CSV' },
                        { extend: 'excel', text: 'Export Excel' },
                        { extend: 'pdf', text: 'Export PDF' },
                        { extend: 'print', text: 'Print' },
                        { extend: 'colvis', text: 'Colvis' }
                    ],
                    pagingType: 'full_numbers',
                    pageLength: 10,
                    lengthMenu: [10, 25, 50, 100],
                    language: {
                        paginate: {
                            first: "{{ __('First') }}",
                            previous: "{{ __('Previous') }}",
                            next: "{{ __('Next') }}",
                            last: "{{ __('Last') }}",
                        },
                        info: "{{ __('Showing _START_ to _END_ of _TOTAL_ entries') }}",
                        infoEmpty: "{{ __('No entries found') }}",
                        emptyTable: "{{ __('No data available in table') }}",
                        search: "{{ __('Search:') }}",
                        lengthMenu: "{{ __('Show _MENU_ entries') }}",
                    }
                });
            });
        </script>
    @stop
