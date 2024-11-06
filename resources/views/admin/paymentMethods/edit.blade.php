@extends('adminlte::page')
@section('title', 'Update Payment Method')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Update Payment Method</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.paymentMethods.index') }}">Payment Methods</a></li>
                <li class="breadcrumb-item active">Update Payment Method</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.paymentMethods.update',['paymentMethod'=>$paymentMethod->id]) }}" method="POST" enctype="multipart/form-data" id="admin-form">
                        @method('PUT')
                        @csrf
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Payment Method Name <span class="text-danger font-weight-bolder">*</span></label>
                                    <input id="name" name="name" value="{{ $paymentMethod->name ?? '' }}" class="form-control"
                                           placeholder="Enter payment method name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="amount">Amount <span class="text-danger font-weight-bolder">*</span></label>
                                    <input id="amount" name="amount" value="{{ $paymentMethod->amount ?? '' }}" class="form-control"
                                           placeholder="Enter amount" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea id="description" name="description"
                                              class="form-control" placeholder="Enter description">{{ $paymentMethod->description ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                        @can('paymentMethods.update')
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

@section('plugins.toastr',true)
@section('css')

@stop

@section('js')

@stop
