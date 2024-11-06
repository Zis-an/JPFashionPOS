@extends('adminlte::page')
@section('title', 'Balance Sheets')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Balance Sheets</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Balance Sheets</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            @can('balanceSheets.list')
                <div class="card">
                    <div class="card-body table-responsive">
                        <form method="GET" action="{{ route('admin.balanceSheetReports') }}" id="filterForm">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="accountFilter">Filter By Account</label>
                                        <select id="accountFilter" name="accountId" class="select2 form-control">
                                            <option value="">Select an option</option>
                                                @foreach($accounts as $account)
                                                    <option value="{{ $account->id }}" {{ request('accountId') == $account->id ? 'selected' : '' }}>
                                                        {{ $account->name }}
                                                    </option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="transactionTypeFilter">Filter By Transaction Type</label>
                                        <select id="transactionTypeFilter" name="transactionType" class="select2 form-control">
                                            <option value="">Select an option</option>
                                                <option value="out" {{ request('transactionType') == 'out' ? 'selected' : '' }}>OUT</option>
                                                <option value="in" {{ request('transactionType') == 'in' ? 'selected' : '' }}>IN</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="startDate">Start Date</label>
                                        <input type="date" id="startDate" name="startDate" class="form-control" value="{{ request('startDate') }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="endDate">End Date</label>
                                        <input type="date" id="endDate" name="endDate" class="form-control" value="{{ request('endDate') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <button type="submit" class="btn btn-primary px-5">Filter</button>
                                </div>
                            </div>
                        </form>

                        <table id="sellList" class="table dataTable table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Account</th>
                                <th>Total In</th>
                                <th>Total Out</th>
                                <th>Balance</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($accountsWithBalances as $accountData)
                                <tr>
                                    <td>{{ $accountData['account']->name }}</td>
                                    <td class="text-right">{{ number_format($accountData['total_in'], 2) }}</td>
                                    <td class="text-right">{{ number_format($accountData['total_out'], 2) }}</td>
                                    <td class="text-right">{{ number_format($accountData['balance'], 2) }}</td>
                                    <td>{{ $accountData['latest_date'] ? \Carbon\Carbon::parse($accountData['latest_date'])->format('F j, Y') : '' }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Total</th>
                                <th class="text-right">{{ number_format($totalInSum, 2) }}</th>
                                <th class="text-right">{{ number_format($totalOutSum, 2) }}</th>
                                <th class="text-right">{{ number_format($balanceSum, 2) }}</th>
                                <th></th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            @endcan
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
@section('plugins.datatablesPlugins', true)
@section('plugins.Datatables', true)
@section('plugins.Select2',true)
@section('plugins.Sweetalert2', true)
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
            $('.select2').select2({
                theme: "classic"
            });

            // Initialize DataTable
            var table = $("#sellList").DataTable({
                dom: 'Bfrtip',
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                buttons: [
                    {
                        extend: 'copy',
                        footer: true
                    },
                    {
                        extend: 'csv',
                        footer: true
                    },
                    {
                        extend: 'excel',
                        footer: true
                    },
                    {
                        extend: 'pdf',
                        footer: true
                    },
                    {
                        extend: 'print',
                        footer: true // Include the footer in the print view
                    },
                    'colvis'
                ],
                language: {
                    paginate: {
                        first: "{{ __('First') }}",
                        previous: "{{ __('Previous') }}",
                        next: "{{ __('Next') }}",
                        last: "{{ __('Last') }}"
                    }
                }
            });
        });
    </script>
@stop
