@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-primary" href="{{route('role.add')}}">Thêm</a>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Tên</th>
                    <th scope="col">Tên hiển thị</th>
                    <th scope="col">Thao tác</th>
                </tr>
                </thead>
                <tbody>
                @foreach($listRole as $role)
                <tr>
                    <th scope="row">{{$loop->index + 1}}</th>
                    <td>{{$role->name}}</td>
                    <td>{{$role->display_name}}</td>
                    <td>
                        <a class="btn btn-primary" href="{{route('role.edit', ['id'=>$role->id])}}">Sửa</a>
                        <a class="btn btn-danger" href="{{route('role.delete', ['id'=>$role->id])}}">Xóa</a>
                    </td>
                </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
@endsection



