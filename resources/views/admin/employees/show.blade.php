@extends('adminlte::page')

@section('title', 'View Employee')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>View Employee - {{ $employee->name }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.employees.index')}}">Employees</a></li>
                <li class="breadcrumb-item active">View Employee</li>
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
                            <div class = "alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                            <table class="table table-bordered w-100 text-left mb-3">
                                <tr>
                                    <th style="width: 30%;">Name</th>
                                    <td>{{ $employee->name ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 30%;">Email</th>
                                    <td>{{ $employee->email ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 30%;">Phone</th>
                                    <td>{{ $employee->phone ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 30%;">Address</th>
                                    <td>{{ $employee->address ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 30%;">Date of Birth</th>
                                    <td>{{ \Carbon\Carbon::parse($employee->date_of_birth)->format('d F, Y') ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 30%;">Hiring Date</th>
                                    <td>{{ \Carbon\Carbon::parse($employee->hire_date)->format('d F, Y') ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 30%;">Position</th>
                                    <td>{{ $employee->position ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 30%;">Department</th>
                                    <td>{{ $employee->department ? $employee->department->name : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 30%;">Education Level</th>
                                    <td>{{ $employee->education_level ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 30%;">National ID</th>
                                    <td>{{ $employee->nid ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 30%;">Tenure</th>
                                    <td>{{ $employee->service_days ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 30%;">Gender</th>
                                    <td>{{ $employee->gender ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 30%;">Salary</th>
                                    <td>{{ $employee->salary ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 30%;">Status</th>
                                    <td class="text-capitalize">{{ $employee->status ?? '' }}</td>
                                </tr>
                            </table>

                            <div class="my-3">
                                <legend>Certificate's Photos</legend>
                            </div>

                            @if($employee->ed_certificate)
                                <div class="d-flex flex-column flex-wrap mb-3" style="width: 300px; height: 180px; gap: 10px;">
                                    @foreach(json_decode($employee->ed_certificate) as $certificate)
                                        <img src="{{ asset($certificate) }}" alt="Certificate's Photo" class="img-fluid img-thumbnail h-100">
                                    @endforeach
                                </div>
                            @else
                                <p>No photos available.</p>
                            @endif


                        <form action="{{ route('admin.employees.destroy', $employee->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <a href="{{route('admin.employees.index')}}" class="btn btn-success" >Go Back</a>
                            @can('employees.update')
                                <a href="{{route('admin.employees.edit',['employee'=>$employee->id])}}" class="btn btn-warning "><i class="fa fa-pen"></i> Edit</a>
                            @endcan
                            @can('employees.delete')
                                <button onclick="isDelete(this)" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                            @endcan
                        </form>

                            <div class="row mt-4 mb-4">
                                <div class="col-md-12">
                                    <h5>Activity Log</h5>
                                    @if($activities->isEmpty())
                                        <p>No activities found for this unit.</p>
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
        <b>version</b> {{env('DEV_VERSION')}}
    </div>
@stop
@section('plugins.toastr',true)
@section('plugins.Sweetalert2', true)
@section('plugins.datatablesPlugins', true)
@section('plugins.Datatables', true)
@section('css')

@stop

@section('js')
    <script>
        function isDelete(button) {
            event.preventDefault();
            var row = $(button).closest("tr");
            var form = $(button).closest("form");
            Swal.fire({
                title: @json(__('Delete Employee')),
                text: @json(__('Are you sure you want to delete this?')),
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: @json(__('Delete')),
                cancelButtonText: @json(__('Cancel')),
            }).then((result) => {
                console.log(result)
                if (result.value) {
                    // Trigger the form submission
                    form.submit();
                }
            });
        }

        function checkSinglePermission(idName, className,inGroupCount,total,groupCount) {
            if($('.'+className+' input:checked').length === inGroupCount){
                $('#'+idName).prop('checked',true);
            }else {
                $('#'+idName).prop('checked',false);
            }
            if($('.permissions input:checked').length === total+groupCount){
                $('#select_all').prop('checked',true);
            }else {
                $('#select_all').prop('checked',false);
            }
        }

        function checkPermissionByGroup(idName, className,total,groupCount) {
            if($('#'+idName).is(':checked')){
                $('.'+className+' input').prop('checked',true);
            }else {
                $('.'+className+' input').prop('checked',false);
            }
            if($('.permissions input:checked').length === total+groupCount){
                $('#select_all').prop('checked',true);
            }else {
                $('#select_all').prop('checked',false);
            }
        }

        $('#select_all').click(function(event) {
            if(this.checked) {
                // Iterate each checkbox
                $(':checkbox').each(function() {
                    this.checked = true;
                });
            } else {
                $(':checkbox').each(function() {
                    this.checked = false;
                });
            }
        });
    </script>

    <!-- Initialize DataTable -->
    <script>
        $(document).ready(function() {

            $("#activityTable").DataTable({
                dom: 'Bfrtip',
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                searching: true, // Disable the global search box
                ordering: true,
                info: true,
                paging: true,
                buttons: [
                    {
                        text: "Created",
                        action: function(e, dt, node, config){
                            dt.column(1).search("created").draw();
                        }
                    },
                    {
                        text: "Updated",
                        action: function(e, dt, node, config){
                            dt.column(1).search("updated").draw();
                        }
                    },
                    {
                        text: "Deleted",
                        action: function(e, dt, node, config){
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
                    }
                }
            });
        });
    </script>
@stop