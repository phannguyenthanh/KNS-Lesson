@extends('admin::layouts.master')
@section('title')
    Edit User
@endsection
@section('content')

    <div class="content-wrapper">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i> Home</a></li>
            <li class="breadcrumb-item active">Users</li>
        </ol>
        <form action="{{route('admin.user.edit', ['id' => 1])}}" method="post" class="validation-form">
            {{csrf_field()}}
            <section class="content">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">User</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            @include('admin::user._form')
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                        <a href="{{route('admin.user.index')}}" type="button" class="btn btn-default">Quay trở lại</a>
                    </div>
                </div>
            </section>
        </form>
    </div>
@endsection
@push('scripts')
    {{--<script src="{{ asset('modules/js/backend/role/role-vailidate.js') }}"></script>--}}
    {{--<script src="{{ asset('modules/js/backend/role/role.js') }}"></script>--}}
@endpush
