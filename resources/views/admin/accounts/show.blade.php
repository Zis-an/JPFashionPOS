@extends('adminlte::page')
@section('title', 'View Account')
<!-- Include DataTables CSS -->

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>View Account - {{ $account->name }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.accounts.index')}}">Accounts</a></li>
                <li class="breadcrumb-item active">View Account</li>
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
                            <div class="position-absolute">
                                <ul class="list-unstyled d-flex float-sm-right">
                                    <!-- Deposit Button -->
                                    <li class="mr-1">
                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#depositModal">
                                            Deposit
                                        </button>
                                    </li>
                                    <!-- Withdraw Button -->
                                    <li class="mr-1">
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#withdrawModal">
                                            Withdraw
                                        </button>
                                    </li>
                                    <!-- Transfer Button -->
                                    <li class="">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#transferModal">
                                            Transfer
                                        </button>
                                    </li>
                                </ul>
                            </div>
                            <!-- Deposit Modal -->
                            <div class="modal fade" id="depositModal" tabindex="-1" role="dialog" aria-labelledby="depositModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-md" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="depositModalLabel">Deposit Funds</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Deposit Form -->
                                            <form id="depositForm" action="{{ route('admin.deposits.store') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="row">
                                                    <input type="hidden" name="account_id" value="{{ $account->id }}">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="amount">Amount</label>
                                                            <input id="amount" name="amount" type="number" class="form-control" placeholder="Enter amount">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="details">Notes</label>
                                                            <textarea name="notes" id="summernote" class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="photo">Select photo</label>
                                                            <input name="old_photo" value="" class="d-none">
                                                            <input name="photo" type="file" class="form-control" id="photo">
                                                        </div>
                                                        <div class="form-group mb-2">
                                                            <img src="" alt="Selected Image" id="selected-image">
                                                        </div>
                                                    </div>
                                                </div>
                                                @can('deposits.create')
                                                    <button class="btn btn-success float-right" type="submit">Create</button>
                                                @endcan
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Withdraw Modal -->
                            <div class="modal fade" id="withdrawModal" tabindex="-1" role="dialog" aria-labelledby="withdrawModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-md" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="withdrawModalLabel">Withdraw Funds</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Withdraw Form -->
                                            <form id="withdrawForm" action="{{ route('admin.withdraws.store') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="row">
                                                    <input type="hidden" name="account_id" value="{{ $account->id }}">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="amount">Amount</label>
                                                            <input id="amount" name="amount" type="number" class="form-control" placeholder="Enter amount" max="{{ $account->balance }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="details">Notes</label>
                                                            <textarea name="notes" id="summernote-withdraw" class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="photo">Select photo</label>
                                                            <input name="old_photo" value="" class="d-none">
                                                            <input name="photo" type="file" class="form-control" id="photo-withdraw">
                                                        </div>
                                                        <div class="form-group mb-2">
                                                            <img src="" alt="Selected Image" id="selected-image-withdraw">
                                                        </div>
                                                    </div>
                                                </div>
                                                @can('withdraws.create')
                                                    <button class="btn btn-success float-right" type="submit">Create</button>
                                                @endcan
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Transfer Modal -->
                            <div class="modal fade" id="transferModal" tabindex="-1" role="dialog" aria-labelledby="transferModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-md" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="withdrawModalLabel">Transfer Funds</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <small class="ml-3">Account Balance: <span class="text-danger">{{$account->balance}}</span> /-</small>
                                        <div class="modal-body">
                                            <!-- Transfer Form -->
                                            <form id="transferForm" action="{{ route('admin.account-transfers.store') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="row">
                                                    <input type="hidden" name="from_account_id" value="{{ $account->id }}">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="to_account_id">Select Account</label>
                                                            <br>
                                                            <select name="to_account_id" class="select2 form-control" id="role" style="width: 100%;">
                                                                @if(!empty($accounts))
                                                                    @foreach($accounts as $select_account)
                                                                        @if($select_account->id != $account->id)
                                                                            <option value="{{ $select_account->id }}">{{ $select_account->name }}</option>
                                                                        @endif
                                                                    @endforeach
                                                                @else
                                                                    <option>No account available</option>
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="amount">Amount</label>
                                                            <input id="amount" name="amount" type="number" class="form-control" placeholder="Enter amount" max="{{ $account->balance }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="photo">Select photo</label>
                                                            <input name="old_photo" value="" class="d-none">
                                                            <input name="photo" type="file" class="form-control" id="photo-transfer">
                                                        </div>
                                                        <div class="form-group mb-2">
                                                            <img src="" alt="Selected Image" id="selected-image-transfer">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="details">Notes</label>
                                                            <textarea name="notes" id="summernote-transfer" class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                @can('account_transfers.create')
                                                    <button class="btn btn-success float-right" type="submit">Create</button>
                                                @endcan
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-start gy-3 mt-5">
                                <div class="col-md-4">
                                    <table class="table table-bordered w-100 text-left">
                                        <thead>
                                        <tr>
                                            <th>Key</th>
                                            <th>Value</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <th style="width: 30%;">Name</th>
                                            <td>{{ $account->name ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th style="width: 30%;">Balance</th>
                                            <td>{{ $account->balance ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th style="width: 30%;">Admin</th>
                                            <td>{{ $account->admin->name ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th style="width: 30%;">Account Type</th>
                                            <td>{{ ucfirst($account->type) ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th style="width: 30%;">Status</th>
                                            <td>{{ ucfirst($account->status) }}</td>
                                        </tr>
                                        </tbody>

                                    </table>
                                </div>
                                <div class="col-md-8">
                                    <table id="transactionTable" class="table table-bordered table-sm text-center">
                                        <thead>
                                        <tr>
                                            <th>Trx. ID</th>
                                            <th>Type</th>
                                            <th>Amount</th>
                                            <th>Reference</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($transactionInfo as $info)
                                            <tr>
                                                <td class="text-left">{{ $info->transaction_id }}</td>
                                                <td>
                                                    @if($info->transaction_type == 'in')
                                                        <span class="badge badge-success px-3">
                                                            {{ $info->transaction_type }}
                                                        </span>
                                                    @else
                                                        <span class="badge badge-danger px-3">
                                                            {{ $info->transaction_type }}
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="text-right">{{ number_format($info->amount )}}</td>
                                                <td class="text-left"><small>{{ $info->reference }}</small></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- New Line Chart -->
                                <div class="col-md-9" style="background-color: white;">
                                    <div>
                                        <canvas id="lineChart"></canvas>
                                    </div>
                                </div>
                                <div class="col-md-3 d-flex justify-content-center">
                                    <div>
                                        <canvas id="pieChart"></canvas>
                                    </div>
                                </div>
                            </div>

                        <form action="{{ route('admin.accounts.destroy', $account->id) }}" method="POST" class="mt-3">
                            @method('DELETE')
                            @csrf
                            <a href="{{ route('admin.accounts.index') }}" class="btn btn-success" >Go Back</a>
                            @can('accounts.update')
                                <a href="{{ route('admin.accounts.edit',['account'=>$account->id]) }}" class="btn btn-warning "><i class="fa fa-pen"></i> Edit</a>
                            @endcan
                            @can('accounts.delete')
                                <button onclick="isDelete(this)" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                            @endcan
                        </form>

                        <div class="row mt-4 mb-4">
                            <div class="col-md-6">
                                <h5>Activity Log</h5>
                                @if($activities->isEmpty())
                                    <p>No activities found for this account.</p>
                                @else
                                    <div class="table-responsive table-sm">
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
                            <div class="col-md-6">
                                <h5>Pending Transactions</h5>
                                @if($activities->isEmpty())
                                    <p>No pending Transactions found for this account.</p>
                                @else
                                    <div class="table-responsive table-sm">
                                        <table id="pendingTransactionTable" class="table order-table table-bordered w-100">
                                            <thead>
                                            <tr>
                                                <th>Receiving Account</th>
                                                <th>Amount</th>
                                                <th>Date & Time</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($pendingTransactions as $pendingTr)
                                                <tr>
                                                    <td class="text-capitalize">{{ $pendingTr->toAccount->name ?? 'N/A' }}</td>
                                                    <td>{{ $pendingTr->amount }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($pendingTr->created_at)->format('F j, Y, g:i A') }}</td>
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
@section('plugins.Select2',true)
@section('plugins.Summernote', true)
@section('css')
    <style>
        #selected-image, #selected-image-withdraw, #selected-image-transfer {
            max-height: 150px;
            border: 2px solid #ddd;
            border-radius: 8px;
            object-fit: cover;
            display: block;
            margin: 10px 0; /* Center horizontally */
            padding: 5px; /* Add padding inside the border */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Add shadow */
            transition: opacity 0.3s ease;
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

        @media (max-width: 767px) {
            #selected-image, #selected-image-withdraw, #selected-image-transfer {
                max-height: 120px; /* Reduce height on smaller screens */
            }
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(function() {
            // Select2 Initialization
            $('.select2').select2({
                theme: "classic"
            });

            // Reusable function to display existing photo
            function displayExistingPhoto(selectedImage, existingPhotoUrl) {
                if (existingPhotoUrl) {
                    selectedImage.src = existingPhotoUrl;
                    selectedImage.style.display = 'block';
                } else {
                    selectedImage.style.display = 'none';
                }
            }

            // Reusable function to handle image input change event
            function handleFileInput(photoInput, selectedImage) {
                photoInput.addEventListener('change', function() {
                    const file = this.files[0];
                    if (file) {
                        const imageUrl = URL.createObjectURL(file);
                        selectedImage.src = imageUrl;
                        selectedImage.style.display = 'block';
                    } else {
                        selectedImage.src = '';
                        selectedImage.style.display = 'none';
                    }
                });
            }

            // Photo handling for admin-form
            const adminImageForm = document.getElementById('admin-form');
            const selectedAdminImage = document.getElementById('selected-image');
            const adminPhotoInput = document.getElementById('photo');
            displayExistingPhoto(selectedAdminImage, '');
            handleFileInput(adminPhotoInput, selectedAdminImage);

            // Photo handling for withdraw
            const selectedWithdrawImage = document.getElementById('selected-image-withdraw');
            const withdrawPhotoInput = document.getElementById('photo-withdraw');
            displayExistingPhoto(selectedWithdrawImage, '');
            handleFileInput(withdrawPhotoInput, selectedWithdrawImage);

            // Photo handling for transfer
            const selectedTransferImage = document.getElementById('selected-image-transfer');
            const transferPhotoInput = document.getElementById('photo-transfer');
            displayExistingPhoto(selectedTransferImage, '');
            handleFileInput(transferPhotoInput, selectedTransferImage);

            // Summernote Initialization
            function initializeSummernote(selector) {
                $(selector).summernote({
                    height: 200,
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
            }

            initializeSummernote('#summernote');
            initializeSummernote('#summernote-withdraw');
            initializeSummernote('#summernote-transfer');

            // Swal Delete Confirmation
            window.isDelete = function(button) {
                event.preventDefault();
                var form = $(button).closest("form");
                Swal.fire({
                    title: @json(__('Delete Account')),
                    text: @json(__('Are you sure you want to delete this?')),
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: @json(__('Delete')),
                    cancelButtonText: @json(__('Cancel')),
                }).then((result) => {
                    if (result.value) {
                        form.submit();
                    }
                });
            };

            // Permission Checking
            window.checkSinglePermission = function(idName, className, inGroupCount, total, groupCount) {
                if($('.' + className + ' input:checked').length === inGroupCount){
                    $('#' + idName).prop('checked', true);
                } else {
                    $('#' + idName).prop('checked', false);
                }
                if($('.permissions input:checked').length === total + groupCount){
                    $('#select_all').prop('checked', true);
                } else {
                    $('#select_all').prop('checked', false);
                }
            };

            window.checkPermissionByGroup = function(idName, className, total, groupCount) {
                if($('#' + idName).is(':checked')){
                    $('.' + className + ' input').prop('checked', true);
                } else {
                    $('.' + className + ' input').prop('checked', false);
                }
                if($('.permissions input:checked').length === total + groupCount){
                    $('#select_all').prop('checked', true);
                } else {
                    $('#select_all').prop('checked', false);
                }
            };

            // Select All Permissions
            $('#select_all').click(function(event) {
                $(':checkbox').each(function() {
                    this.checked = event.target.checked;
                });
            });

            // Initialize DataTable
            function initializeDataTable(tableId) {
                $("#" + tableId).DataTable({
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
                    pageLength: 5,
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
            }

            // Initialize DataTable for both activityTable and transactionTable
            $(document).ready(function() {
                initializeDataTable("activityTable");
                initializeDataTable("transactionTable");
                initializeDataTable("pendingTransactionTable");
            });

            <!-- Ajax Scripts -->
            // Reusable function to handle form submissions
            function handleFormSubmission(formId, modalId, successMessage) {
                $(formId).on('submit', function(event) {
                    event.preventDefault();

                    $.ajax({
                        url: $(this).attr('action'),
                        type: 'POST',
                        data: new FormData(this),
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            alert(successMessage); // Change this to a notification if needed
                            $(modalId).modal('hide'); // Hide the modal after submission
                        },
                        error: function(xhr) {
                            if (xhr.status === 422) { // Validation error
                                let errors = xhr.responseJSON.errors;
                                let errorMessages = '';

                                $.each(errors, function(key, error) {
                                    errorMessages += error[0] + '\n'; // Get the first error for each field
                                });

                                alert('Validation errors:\n' + errorMessages);
                            } else {
                                alert(xhr.responseJSON.message || 'Unknown error');
                            }
                        }
                    });
                });
            }

            // Initialize form handlers
            handleFormSubmission('#depositForm', '#depositModal', 'Deposit successful!');
            handleFormSubmission('#withdrawForm', '#withdrawModal', 'Withdrawal successful!');
            handleFormSubmission('#transferForm', '#transferModal', 'Account Transfer successful!');
        });

        <!-- Chart scripts -->
        var ctxPie = document.getElementById('pieChart').getContext('2d');
        var ctxLine = document.getElementById('lineChart').getContext('2d');

        // Pie chart
        var myChart = new Chart(ctxPie, {
            type: 'pie',
            options: {
                layout: {
                    padding: 0
                },
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        align: 'center',
                    },
                    tooltip: {
                        enabled: true,
                    }
                },
            },
            data: {
                labels: @json($data['labels']),
                datasets: [{
                    data: @json($data['data']),
                    backgroundColor: [
                        'rgba(255,0,51,0.7)',
                        'rgba(41,126,0,0.85)',
                    ],
                    borderColor: [
                        'rgba(255,0,51,0.7)',
                        'rgba(41,126,0,0.85)',
                    ],
                    borderWidth: 1
                }]
            }
        });

        // Line chart
        var myLineChart = new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: @json($lineChartData['labels']),
                datasets: @json($lineChartData['datasets'])
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@stop

