@extends('layout.index')
@section('content')

    @foreach($authorityList as $val)
        {{ $val->name }}
    @endforeach

@endsection