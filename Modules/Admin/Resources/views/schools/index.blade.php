@extends('admin::layouts.master')
@section('title')
    School
@endsection
@push('style')
    <link rel="stylesheet" href="{{asset('common/pagination.css')}}" xmlns:v-on="http://www.w3.org/1999/xhtml"
          xmlns:v-on="http://www.w3.org/1999/xhtml">
@endpush
@section('content')

    <div class="content-wrapper" id="app">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> 
                Trường học
                <small>Control panel</small>
            </h1> 
            <ol class="breadcrumb">
                <li><a href="{{route('admin.index')}}"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
                <li class="active">Trường học</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group col-md-4">
                        <label>Khu vực </label>
                        <div class="clearfix">
                            <select  class="form-control areas_S" name="area_id" id="areas" data-table="area_id">
                                <option value="">Chọn khu vực</option>
                                @foreach ($areas as $key => $area)
                                    <option value="{{$area->id}}">{{$area->name}}</option>
                                @endforeach
                            </select>
                        </div>     
                    </div>
                    <div class="form-group col-md-4">
                        <label>Tỉnh/thành phố </label>
                        <div class="clearfix">
                            <select  class="form-control provinces_S" name="province_id" id="provinces" data-table="province_id" >
                                <option value="">Chọn Tỉnh</option>
                                @foreach ($provinces as $key => $province)
                                    <option value="{{$province->id}}">{{$province->name}}</option>
                                @endforeach
                            </select>
                        </div>     
                    </div>    
                    <div class="form-group col-md-4">
                        <label>Quận/Huyện </label>
                        <div class="clearfix">
                            <select  class="form-control districts_S" name="district_id" id="districts" data-table="district_id">
                                <option value="">Chọn quận/huyện</option>
                                @foreach ($districts as $key => $district)
                                    <option value="{{$district->id}}">{{$district->name}}</option>
                                @endforeach
                            </select>
                        </div>     
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <a href="{{route('admin.school.create')}}" class="btn btn-primary">Tạo trường học</a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    @include('common.message')
                </div>
                <section class="col-lg-12 connectedSortable">
                    <!-- TO DO List -->
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Danh sách trường</h3>

                            <div class="box-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" id="nav-search-input" name="table_search" class="form-control pull-right" placeholder="Tìm kiếm">
                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover results-table" >
                                <thead>
                                <tr>
                                    <th class="order-number">STT</th>
                                    <th>Tên</th>
                                    <th>Cấp</th>
                                    <th>Khu vực</th>
                                    <th>Tỉnh</th>
                                    <th>Quận/Huyện</th>
                                    <th>Key</th>
                                    <th class="item-action-3">Trạng thái</th>
                                </tr>
                                </thead>
                                <tbody id="tbody">
                                @if(!empty($schools))
                                    @foreach($schools as $key => $school)
                                        <tr>
                                            <td class="text-center">{{$key + 1}}</td>
                                            <td>{{$school->name}}</td>
                                            <td>{{!empty($school->schoolLevel) ? $school->schoolLevel->name: ''}}</td>
                                             <td>{{!empty($school->area) ? $school->area->name: ''}}</td>
                                             <td>{{!empty($school->province) ? $school->province->name: ''}}</td>
                                            <td>{{!empty($school->district) ? $school->district->name: ''}}</td>
                                           
                                            <td> {{$school->license_key}}</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a class="btn btn-success"
                                                       href="{{route('admin.school.show',['id' => $school->id])}}"
                                                       title="Detail">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <a class="btn btn-info"
                                                       href="{{route('admin.school.edit',['id' => $school->id])}}"
                                                       title="Edit">
                                                        <i class="ace-icon fa fa-pencil"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-danger delete-object"
                                                       title="Delete"
                                                       object_id="{{$school->id}}"
                                                       object_name="{{$school->name}}">
                                                        <i class="fa fa-trash-o"></i>
                                                    </a>

                                                </div>
                                            </td>
                                        </tr> 
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5">Không có bản ghi nào</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-md-6 pull-left widget-page">
                                    @include('pagination.index',['current_page' => 1,'total_page' => $pages])
                                </div>
                                <div class="col-md-6 pull-right">
                                    <div class="form-group pull-right">
                                        <label class="view-by">
                                            Xem với
                                            <select id="show-records" class="form-control input-sm">
                                                <option value="10">10</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                            </select>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box -->
                </section>
                <!-- /.col -->
            </div>
        </section>
        <!-- /.content -->


    </div>
    <input type="hidden" id="url-ajax" value="/admin/school/pagination/">
    <input type="hidden" id="pagination_Select" value="/admin/school/pagination_Select/">
@endsection

@push('scripts')
    {{--    <script src="{{ asset('assets/admin/plugins/iCheck/icheck.min.js') }}"></script>--}}
    <script src="{{ asset('common/pagination-search.js') }}"></script>
    <script src="{{ asset('modules/admin/school/school.js') }}"></script>
@endpush
