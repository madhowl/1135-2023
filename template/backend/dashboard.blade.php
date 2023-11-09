@extends('layout')
@section('title')

 <li class="breadcrumb-item active">{{ $title }}</li>
@endsection

@section('content')
 <div class="card">
  <div class="card-body">
   <h5 class="card-title">Добро пожаловать!</h5>
   <p>Приятно снова вас здесь встретить</p>
  </div>
 </div>
 @endsection