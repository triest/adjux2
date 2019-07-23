@extends('layouts.main', ['title' => 'Назначить представителей'])

@section('content')
    <a class="btn btn-secondary" href="{{route('adminA')}}" role="link">меропрятие A</a>
    <a class="btn btn-secondary" href="{{route('adminB')}}" role="link">мероприятие B </a> <br>
    <br>
    <a class="btn btn-primary" href="{{route('makeOrganizer')}}" role="link">Назначить организаторов на мероприятия</a>

    <br><br><br>
    <?php if (\App\Http\Controllers\MainController::existMain() == false and Auth::user()->isSuperAdmin() == true){ ?>
    <a class="btn btn-secondary" href="{{route('createMain')}}" role="link">Добавить контент на главную страницу</a>
    <?php ;} elseif (\App\Http\Controllers\MainController::existMain() == true and Auth::user()->isSuperAdmin()
    == true) { ?>
    <a class="btn btn-secondary" href="{{route('editMain')}}" role="link">Редактировать контент главной страницы</a>

    <?php }  ?>

@endsection