@extends('layouts.master')

@section('content')
{{ Form::open(array('route' => 'room_name')) }}

<?php
    $room_drop_down = array();
    foreach ($room as $r)
         $room_drop_down =  array_add($room_drop_down, $r -> mac, $r -> room."/".$r -> mac."/".$r -> ip);
    echo Form::select('mac', $room_drop_down);
?>
<br>
<br>
{{ Form::label('name', '房间名称:'); }}
{{ Form::text('name'); }}
<br>
<br>
{{ Form::token() }}
{{ Form::submit('确认') }}
{{ Form::close() }}
@stop
