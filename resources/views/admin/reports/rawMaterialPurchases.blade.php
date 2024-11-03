@extends('adminlte::page')
@section('title', 'Sell Reports')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Raw Material Purchase Reports</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Raw Material Purchase Reports</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            @can('sellReports.list')
                <div class="card">
                    <div class="card-body table-responsive">
                        <form method="GET" action="{{ route('admin.rawMaterialPurchaseReports') }}" id="filterForm">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="customerFilter">Filter By Customer</label>
                                        <select id="customerFilter" name="customerId" class="select2 form-control">
                                            <option value="">Select an option</option>
                                            {{--                                            @foreach($customers as $customer)--}}
                                            {{--                                                <option value="{{ $customer->id }}" {{ request('customerId') == $customer->id ? 'selected' : '' }}>--}}
                                            {{--                                                    {{ $customer->name }}--}}
                                            {{--                                                </option>--}}
                                            {{--                                            @endforeach--}}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="salesmanFilter">Filter By Salesman</label>
                                        <select id="salesmanFilter" name="salesmanId" class="select2 form-control">
                                            <option value="">Select an option</option>
                                            {{--                                            @foreach($salesmen as $salesman)--}}
                                            {{--                                                <option value="{{ $salesman->id }}" {{ request('salesmanId') == $salesman->id ? 'selected' : '' }}>--}}
                                            {{--                                                    {{ $salesman->name }}--}}
                                            {{--                                                </option>--}}
                                            {{--                                            @endforeach--}}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="accountFilter">Filter By Account</label>
                                        <select id="accountFilter" name="accountId" class="select2 form-control">
                                            <option value="">Select an option</option>
                                            {{--                                            @foreach($accounts as $account)--}}
                                            {{--                                                <option value="{{ $account->id }}" {{ request('accountId') == $account->id ? 'selected' : '' }}>--}}
                                            {{--                                                    {{ $account->name }}--}}
                                            {{--                                                </option>--}}
                                            {{--                                            @endforeach--}}
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
                                <th>Customer</th>
                                <th>Salesman</th>
                                <th>Account</th>
                                <th>Total Amount</th>
                                <th>Discount Amount</th>
                                <th>Net Total</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            {{--                            @foreach($sells as $sell)--}}
                            {{--                                <tr>--}}
                            {{--                                    <td>{{ $sell->customer->name ?? '' }}</td>--}}
                            {{--                                    <td>{{ $sell->salesman->name ?? '' }}</td>--}}
                            {{--                                    <td>{{ $sell->account->name ?? '' }}</td>--}}
                            {{--                                    <td>{{ number_format($sell->total_amount, 2) }}</td>--}}
                            {{--                                    <td>{{ number_format($sell->discount_amount, 2) }}</td>--}}
                            {{--                                    <td>{{ number_format($sell->net_total, 2) }}</td>--}}
                            {{--                                    <td>{{ $sell->created_at ? \Carbon\Carbon::parse($sell->created_at)->format('F j, Y') : '' }}</td>--}}
                            {{--                                </tr>--}}
                            {{--                            @endforeach--}}
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Customer</th>
                                <th>Salesman</th>
                                <th>Account</th>
                                <th>Total Amount</th>
                                <th>Discount Amount</th>
                                <th>Net Total</th>
                                <th>Date</th>
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
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print', 'colvis'],
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
