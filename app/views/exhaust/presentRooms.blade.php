@extends('layouts.master')

@section('content')

    <style>
        table, th, td {
            border: 1px solid black;
            font-size:27px;
            font-weight:600;
        }
        th{
            background-color: #1e90ff;
            color: #2c3e50;
        }
        td{
            background-color: #94C5CC;
        }
    </style>

    <table>
        <tr>
            <th>IP地址</th>
            <th>MAC</th>
            <th>房间</th>
        </tr>
        @foreach ($data as $line)
            <tr>
                <td>{{$line -> ip}}</td>
                <td>{{$line -> mac}}</td>
                <td>{{$line -> room}}</td>
                <td><a href="/exhaust/delete/{{$line -> mac}}">删除</a></td>
            </tr>
        @endforeach
    </table>

    <br>
    <br>
@stop