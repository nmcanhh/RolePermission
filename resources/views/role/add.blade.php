    @extends('layouts.app')

    @section('content')
        <div class="container">
            <div class="row">
                <form class="col-md-8" method="POST" action="">
                    @csrf
                    <div class="form-group">
                        <label>Tên</label>
                        <input type="text" class="form-control" placeholder="Nhập tên" name="name">
                    </div>

                    <div class="form-group">
                        <label>Tên hiển thị</label>
                        <input type="text" class="form-control" placeholder="Nhập tên hiển thị" name="display_name">
                    </div>

                    @foreach($listPermission as $permission)
                    <div class="form-check">
                    {{-- Dùng mảng vì ghét nhiều value--}}
                        <input type="checkbox" class="form-check-input"  value="{{$permission->id}}" name="permissions[]">
                        <label class="form-check-label" >{{$permission->display_name}}</label>
                    </div>
                    @endforeach
                    <button type="submit" class="btn btn-primary">Thêm</button>
                </form>
         </div>
        </div>
    @endsection



