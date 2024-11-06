@extends('adminlte::page')
@section('title', 'Payment Methods')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Create Payment Method</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.paymentMethods.index') }}">Payment Methods</a></li>
                <li class="breadcrumb-item active">Create Payment Method</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.paymentMethods.store') }}" method="POST" enctype="multipart/form-data" id="admin-form">
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
                                    <input id="name" name="name" class="form-control" placeholder="Enter payment method name" value="{{ old('name') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="amount">Amount <span class="text-danger font-weight-bolder">*</span></label>
                                    <input id="amount" name="amount" type="number" step="0.01" class="form-control" placeholder="Enter amount"
                                           value="{{ old('amount') }}" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" class="form-control"
                                              placeholder="Enter description">{{ old('description') }}</textarea>
                                </div>
                            </div>
                        </div>

                        @can('paymentMethods.create')
                            <button class="btn btn-success" type="submit">Create</button>
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
@section('plugins.Summernote', true)
@section('css')

@stop

@section('js')
    <script>
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
    </script>
@stop
