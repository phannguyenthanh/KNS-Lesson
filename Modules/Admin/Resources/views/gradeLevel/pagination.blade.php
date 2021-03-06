<tr>
    <th class="order-number">STT</th>
    <th>Tên khối</th>
   
    <th class="item-action-3">Trạng thái</th>
</tr>
@if(!empty($grades))
    @foreach($grades as $key => $item)
        <tr>
            <td class="text-center">{{$key + 1}}</td>
            <td>{{$item->name}}</td>
         
            <td>
                <div class="btn-group btn-group-sm">
                    <a class="btn btn-success"
                       href="{{route('admin.grade.show',['id' => $item->id])}}"
                       title="Detail">
                        <i class="fa fa-eye"></i>
                    </a>
                    <a class="btn btn-info"
                       href="{{route('admin.grade.edit',['id' => $item->id])}}"
                       title="Edit">
                        <i class="ace-icon fa fa-pencil"></i>
                    </a>
                    <a href="#" class="btn btn-danger delete-object"
                       title="Delete"
                       object_id="{{$item->id}}"
                       object_name="{{$item->name}}">
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
<input id="total-pages-current" type="hidden" value="{{ isset($pages) ? $pages : 0 }}">