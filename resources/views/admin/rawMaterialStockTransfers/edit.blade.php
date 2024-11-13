@extends('adminlte::page')
@section('title', 'Edit Raw Material Stock Transfer')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Edit Raw Material Stock Transfer</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.raw-material-stock-transfers.index')}}">Raw Material Stock Transfers</a></li>
                <li class="breadcrumb-item active">Edit Raw Material Stock Transfer</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.raw-material-stock-transfers.update', $transfer->id)}}" method="POST" enctype="multipart/form-data" id="admin-form">
                        @csrf
                        @method('PUT')
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="row">

                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="from_warehouse_id">From Warehouse <span class="text-danger font-weight-bolder">*</span></label>
                                    <select id="from_warehouse_id" name="from_warehouse_id" class="form-control select2" readonly required>
                                        <option value="{{ $transfer->from_warehouse_id}}">{{$transfer->fromWarehouse->name ?? 'Deleted'}}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="to_warehouse_id">To Warehouse <span class="text-danger font-weight-bolder">*</span></label>
                                    <select id="to_warehouse_id" name="to_warehouse_id" class="form-control select2" required>
                                        <option value="">Select Warehouse</option>
                                        @foreach ($warehouses as $warehouse)
                                            <option value="{{ $warehouse->id }}" {{ $warehouse->id == $transfer->to_warehouse_id ? 'selected' : '' }}>
                                                {{ $warehouse->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="date">Date <span class="text-danger font-weight-bolder">*</span></label>
                                    <input type="date" name="date" class="form-control" value="{{ $transfer->date }}" required>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="note">Details</label>
                                    <textarea name="note" id="summernote" class="form-control">
                                        {{strip_tags($transfer->note) ?? ''}}
                                    </textarea>
                                </div>
                            </div>

                        </div>

                        <!-- Table for displaying raw materials info and quantity input -->
                        <div class="row" id="raw-material-table-container">
                            <div class="col-12">
                                <table id="activityTable" class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Select</th>
                                        <th>Raw Material Name</th>
                                        <th>Quantity</th>
                                        <th>Transfer Quantity</th>
                                    </tr>
                                    </thead>
                                    <tbody id="raw-material-table-body">
                                    @foreach($warehouseRawMaterials as $material)
                                        <tr>
                                            <td>
                                                <input type="checkbox" class="raw-material-checkbox" name="selected_raw_materials[]" value="{{ $material->id }}"
                                                       @if($transfer->rawMaterialStocks->pluck('id')->contains($material->id)) checked @endif>
                                            </td>
                                            <td>{{ $material->raw_material->name }}</td>
                                            <td>{{ $material->quantity }}</td>
                                            <td>
                                                <input type="number" name="transfer_quantities[{{ $material->id }}]" class="form-control transfer-quantity"
                                                       value="{{ old('transfer_quantities.' . $material->id, $transfer->rawMaterialStocks->firstWhere('id', $material->id)->pivot->quantity ?? 0) }}"
                                                       min="1" max="{{ $material->quantity }}">
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if($warehouseRawMaterials->isEmpty())
                                        <tr>
                                            <td colspan="7">No raw materials available in this warehouse.</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        @can('rawMaterialStockTransfers.update')
                            <button class="btn btn-success" type="submit">Update</button>
                        @endcan
                    </form>
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
@section('plugins.toastr', true)
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Summernote', true)
@section('plugins.Datatables', true)
@section('css')
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice{
            color: black;
        }
        .select2-container .select2-selection--single {
            box-sizing: border-box;
            cursor: pointer;
            display: block;
            height: 37px; /* Set to your desired height */
            user-select: none;
            -webkit-user-select: none;
        }

        /* Adjust the line-height of the rendered text inside Select2 */
        .select2-container--classic .select2-selection--single .select2-selection__rendered {
            color: #444;
            line-height: 34px; /* Adjust line height */
        }

        /* Style the Select2 arrow and set its height */
        .select2-container--classic .select2-selection--single .select2-selection__arrow {
            background-color: #ddd;
            border: none;
            border-left: 1px solid #aaa;
            border-top-right-radius: 4px;
            border-bottom-right-radius: 4px;
            height: 35px; /* Set height for the arrow */
            position: absolute;
            top: 1px;
            right: 1px;
            width: 20px;
            background-image: -webkit-linear-gradient(top, #eeeeee 50%, #cccccc 100%);
            background-image: -o-linear-gradient(top, #eeeeee 50%, #cccccc 100%);
            background-image: linear-gradient(to bottom, #eeeeee 50%, #cccccc 100%);
            background-repeat: repeat-x;
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#FFEEEEEE', endColorstr='#FFCCCCCC', GradientType=0);
        }
    </style>
@stop
@section('js')
    <script>
        $(document).ready(function() {
            // Get the current 'to_warehouse_id' from the transfer data
            var selectedToWarehouseId = {{ $transfer->to_warehouse_id }};

            // Get selected raw material IDs from the transfer
            var selectedRawMaterialIds = @json($transfer->rawMaterialStocks->pluck('id'));

            // Fetch raw materials for the selected warehouse when page loads
            $.ajax({
                url: '/api/raw-material-stocks/' + selectedToWarehouseId,
                type: 'GET',
                success: function(data) {
                    // Check if there are raw materials available
                    if (data.length > 0) {
                        // Show the raw material table container
                        $('#raw-material-table-container').show();

                        // Populate the raw material table with fetched data
                        $.each(data, function(index, rawMaterial) {
                            // Check if raw material is selected in the transfer
                            let isChecked = @json($transfer->rawMaterialStocks->pluck('id')->toArray()).includes(rawMaterial.id);

                            $('#raw-material-table-body').append(`
                                <tr>
                                    <td><input type="checkbox" class="raw-material-checkbox" name="selected_raw_materials[]" value="${rawMaterial.id}" ${isChecked ? 'checked' : ''}></td>
                                    <td>${rawMaterial.raw_material_name}</td>
                                    <td>${rawMaterial.quantity}</td>
                                    <td>
                                        <input type="number" name="transfer_quantities[${rawMaterial.id}]" class="form-control transfer-quantity"
                                            value="${rawMaterial.transfer_quantity || 0}" min="1" max="${rawMaterial.quantity}" ${isChecked ? '' : 'disabled'}>
                                    </td>
                                </tr>
                            `);
                        });

                        // Add event listener for toggling 'required' on transfer quantity input
                        $('#raw-material-table-body').on('change', '.raw-material-checkbox', function() {
                            const isChecked = $(this).is(':checked');
                            const row = $(this).closest('tr');
                            row.find('.transfer-quantity').prop('disabled', !isChecked);
                        });
                    } else {

                    }
                }
            });

            // Prevent form submission if required fields are not selected
            $('#admin-form').submit(function(e) {
                var selectedRawMaterials = $('input[name="selected_raw_materials[]"]:checked').length;
                if (selectedRawMaterials == 0) {
                    e.preventDefault();
                }
            });

            // Initialize Summernote
            $('#summernote').summernote({
                height: 200, // Set the height of the editor
                placeholder: 'Enter details here...',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
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
