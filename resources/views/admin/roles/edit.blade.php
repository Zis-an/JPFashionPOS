@extends('adminlte::page')
@section('title', 'Update Role')
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Update Roles - {{$role->name}}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.roles.index')}}">Roles</a></li>
                <li class="breadcrumb-item active">Update Roles</li>
            </ol>
        </div>
    </div>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.roles.update',['role'=>$role->id])}}" method="POST">
                        @method('PUT')
                        @csrf
                        @if (count($errors) > 0)
                            <div class = "alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="form-group">

                            <label for="name">Name</label>
                            <input name="name" value="{{$role->name}}" type="text" required class="form-control" id="name" placeholder="Enter role name">
                        </div>
                        <div class="form-group">
                            <label for="guard_name">Guard Name</label>
                            <input name="guard_name" type="text" value="{{ $role->guard_name }}" required class="form-control" id="guard_name" placeholder="Enter guard name" readonly>
                        </div>
                        <h4>Permissions</h4>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="select_all"
                                   {{(checkRolePermissions($role,$permissions)?'checked':'')}}
                                   value="All">
                            <label for="select_all" class="custom-control-label">Select All</label>
                        </div>
                        <hr>
                        <div class="form-group row permissions">
                            @foreach($permissions_groups as $permission_group)
                                <div class="custom-control custom-checkbox col-md-6 ">
                                    <input class="custom-control-input" type="checkbox" id="group_{{$permission_group->group_name}}_id"
                                           {{(checkRolePermissions($role,$permissions->where('group_name',$permission_group->group_name))?'checked':'')}}
                                           onclick="checkPermissionByGroup('group_{{$permission_group->group_name}}_id','group_{{$permission_group->group_name}}_class',{{count($permissions)}},{{count($permissions_groups)}})" value="{{$permission_group->group_name}}">
                                    <label for="group_{{$permission_group->group_name}}_id" class="custom-control-label">{{$permission_group->group_name}}</label>
                                    @foreach($permissions->where('group_name',$permission_group->group_name) as $permission)
                                        <div class="custom-control custom-checkbox group_{{$permission_group->group_name}}_class">
                                            <input class="custom-control-input" type="checkbox" id="permission.{{$permission->id}}"
                                                   {{($role->hasPermissionTo($permission))?'checked':''}}
                                                   onclick="checkSinglePermission('group_{{$permission_group->group_name}}_id','group_{{$permission_group->group_name}}_class',{{count($permissions->where('group_name',$permission_group->group_name))}},{{count($permissions)}},{{count($permissions_groups)}})" name="permissions[]" value="{{$permission->name}}">
                                            <label for="permission.{{$permission->id}}" class="custom-control-label">{{$permission->name}}</label>
                                        </div>

                                    @endforeach
                                    <hr>
                                </div>
                            @endforeach
                        </div>
                        @can('roles.update')
                            <button class="btn btn-success" type="submit">Update</button>
                        @endcan
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
@section('footer')
    <strong>Developed by <a href="https://techyfo.com">Techyfo</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
        <b>versions</b> {{env('DEV_VERSION')}}
    </div>
@stop
@section('toastr',true)
@section('css')

@stop

@section('js')
    <script>
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
@stop
