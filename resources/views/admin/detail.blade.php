@extends('layouts.main', ['title' => 'Панель администратора'])

@section('content')

    <h1>{{$did->name}}</h1>
    @if(Auth::user()->isSuperAdmin())
        <a class="btn btn-danger" onclick="return confirm('Вы уверены?')"
           href="{{route('deleteDid',['id'=>$did->id])}}" role="link">Удалить</a>
        <br>
    @endif
    <b>Создана:</b>
    <h7>{{$did->created_at}}</h7>
    <br>
    <b>Автор:</b>
    {{$did->femili}}
    {{$did->name}}
    <br>
    <b>Ip</b>
    {{$did->ip}}
    <br>

    <b>Образование:</b>
    <p>{{$did->getEducationName()}}</p>

    <b>Описание:</b>
    <p>{{$did->description}}</p>

@endsection