@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-primary" href="{{route('user.add')}}">Thêm</a>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col">Tên</th>
                    <th scope="col">Email</th>
                    <th scope="col">Thao tác</th>
                </tr>
                </thead>
                <tbody>
                @foreach($listUser as $user)
                <tr>
                    <th scope="row">{{$loop->index + 1}}</th>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>
                        <a class="btn btn-primary" href="{{route('user.edit', ['id'=>$user->id])}}">Sửa</a>
                        <a class="btn btn-danger" href="{{route('user.delete', ['id'=>$user->id])}}">Xóa</a>
                    </td>
                </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
@endsection



