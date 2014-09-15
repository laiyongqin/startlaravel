@extends('master')
@section('header')
<a href="{{url('/')}}">Back to overview</a>
<h2>
{{{$cat->name}}}
</h2>
@if(Auth::check() and Auth::user()->canEdit($cat))
<a href="{{url('cats/'.$cat->id.'/edit')}}">
<span class="glyphicon glyphicon-edit"></span> Edit
</a>
<a href="{{url('cats/'.$cat->id.'/delete')}}">
<span class="glyphicon glyphicon-trash"></span> Delete
</a>
@endif
Last edited: {{$cat->updated_at}}
@stop
@section('content')
<p>Date of Birth: {{$cat->date_of_birth}} </p>
<p>
@if($cat->breed)
Breed:
{{link_to('cats/breeds/' . $cat->breed->name, 
$cat->breed->name)}}
@endif
</p>
@stop