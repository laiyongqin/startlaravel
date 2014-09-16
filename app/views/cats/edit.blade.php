@extends('master')
@section('header')
<a href="{{url('cats/'.$cat->id.'')}}">&larr; Cancel </a>
<h2>
@if($method == 'post') 
Add a new cat
@elseif($method == 'delete') 
Delete {{$cat->name}}?
@else 
Edit {{$cat->name}}
@endif

</h2>
@stop

@section('content')
{{Form::model($cat, array('method' => $method, 'url'=>'cats/'.$cat->id))}}
@unless($method == 'delete')
<div class="form-group">
{{Form::label('Name')}} 
{{Form::text('name')}}
<span id="name"></span>
</div>
<div class="form-group">
{{Form::label('Date of birth')}}
{{Form::text('date_of_birth')}}
<span id="date_of_birth"></span>

</div>
<div class="form-group">
{{Form::label('Breed')}}
{{Form::select('breed_id', $breed_options)}}
<span id="breed_id"></span>
</div>
{{Form::submit("Save", array("class"=>"btn btn-default"))}}
@else
{{Form::submit("Delete", array("class"=>"btn btn-default"))}}
@endif
{{$jsprinterror}}
{{Form::close()}}
@stop
