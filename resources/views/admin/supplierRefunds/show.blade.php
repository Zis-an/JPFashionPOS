@extends('adminlte::page')
@section('title', 'View Supplier Refund')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>View Supplier Refund - {{ $refund->supplier->name }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.supplier-refunds.index')}}">Supplier Refunds</a></li>
                <li class="breadcrumb-item active">View Supplier Refund</li>
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
                    <table class="table table-bordered w-100 text-left">
                        <tr>
                            <th style="width: 30%;">Supplier</th>
                            <td>{{ $refund->supplier->name ?? '' }}</td>
                        </tr>
                        <tr>
                            <th style="width: 30%;">Account</th>
                            <td>{{ $refund->account->name ?? '' }}</td>
                        </tr>
                        <tr>
                            <th style="width: 30%;">Amount</th>
                            <td>{{ $refund->amount ?? '' }} BDT</td>
                        </tr>
                        <tr>
                            <th style="width: 30%;">Details</th>
                            <td>{{ strip_tags($refund->details) ?? '' }}</td>
                        </tr>
                        <tr>
                            <th style="width: 30%;">Date</th>
                            <td>{{ $refund->date ?? '' }}</td>
                        </tr>
                        <tr>
                            <th style="width: 30%;">Received By</th>
                            <td>{{ strip_tags($refund->received_by) ?? '' }}</td>
                        </tr>
                        <tr>
                            <th style="width: 30%;">Status</th>
                            <td>{{ ucfirst($refund->status) }}</td>
                        </tr>
                    </table>
                    <div class="my-3">
                        <legend>Supplier Refund's Photos</legend>
                    </div>
                    <div id="image-preview-container" class="form-group mb-2 d-flex flex-wrap">
                        @if($refund->image)
                            <img src="{{ asset($refund->image) }}" alt="Refund Photo" class="selected-image">
                        @else
                            <p>No photos available.</p>
                        @endif
                    </div>

                    <form action="{{ route('admin.supplier-refunds.destroy', $refund->id) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <a href="{{route('admin.supplier-refunds.index')}}" class="btn btn-success" >Go Back</a>
                        @can('supplierRefunds.update')
                            <a href="{{route('admin.supplier-refunds.edit',['supplier_refund'=>$refund->id])}}" class="btn btn-warning ">
                                <i class="fa fa-pen"></i> Edit
                            </a>
                        @endcan
                        @can('supplierRefunds.delete')
                            <button onclick="isDelete(this)" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                        @endcan
                    </form>

                    <div class="row mt-4 mb-4">
                        <div class="col-md-12">
                            <h5>Activity Log</h5>
                            @if($activities->isEmpty())
                                <p>No activities found for this refund.</p>
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
    <style>
        .selected-image {
            width: 150px; /* Moderate width */
            height: 100px; /* Rectangular shape */
            border: 2px solid #ddd;
            border-radius: 8px;
            object-fit: cover;
            display: block;
            margin-right: 10px; /* Space between images */
            margin-bottom: 10px; /* Space between rows if needed */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: opacity 0.3s ease;
        }

        #image-preview-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px; /* Space between images */
        }

        @media (max-width: 767px) {
            .selected-image {
                width: 120px; /* Adjust for smaller screens */
                height: 80px; /* Adjust for smaller screens */
            }
        }
    </style>
@stop

@section('js')
    <script>
        function isDelete(button) {
            event.preventDefault();
            var row = $(button).closest("tr");
            var form = $(button).closest("form");
            Swal.fire({
                title: @json(__('Delete Refund')),
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
