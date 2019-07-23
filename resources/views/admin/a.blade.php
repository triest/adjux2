@extends('layouts.main', ['title' => 'Панель администратора'])

@section('content')

    <table id="example" class="table table-striped table-bordered">
        <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">Имя</th>
            <th scope="col">Фамилия</th>
            <th scope="col">Образование</th>
            <th scope="col">Создана</th>
        </tr>
        </thead>
        <tbody>
        @foreach($rands as $did)
            <tr>
                <td>{{$did->id}}</td>
                <td>{{$did->name}}</td>
                <td>{{$did->femili}}</td>
                <td>{{$did->getEducationName()}}</td>
                <td>{{$did->created_at}}</td>
                <td><a href="{{route('showA',['id'=>$did->id])}}">Детали</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <a class="button blue" href="{{route('admin')}}" role="link">К панеле администратора</a>
@endsection

