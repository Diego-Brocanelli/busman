@extends('layouts.admin.dashboard')

@section('title', 'Users')

@section('main-content')
    <!-- Widgets -->
    <div class="row clearfix">
        {!! Route::current()->getPrefix() !!}
         <br>
        List users here
    </div>
    <!-- #END# Widgets -->
@endsection
