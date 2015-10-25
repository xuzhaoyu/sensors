@extends('layouts.master')

@section('content')
<?php
header("refresh:120;");
?>

        <!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <title>{{$room}}</title>
</head>
<body>

<a href="/graph/{{$mac}}/all">所有数据</a>
<br>
<a href="/graph/{{$mac}}/month">一个月的数据</a>
<br>
<a href="/graph/{{$mac}}/day">今天的数据</a>
<br>

<br>
<br>

房间名称： {{$room}}
<br>
<div id="co" style="height:400px"></div>
<div id="no1" style="height:400px"></div>
<div id="so2" style="height:400px"></div>
<div id="lel" style="height:400px"></div>
<div id="dust" style="height:400px"></div>

{{ HTML::script('js/echarts/build/dist/echarts.js'); }}
<script type="text/javascript">
    require.config({
        paths: {
            echarts: 'http://123.57.251.73/js/echarts/build/dist'
        }
    });
    require(
            [
                'echarts',
                'echarts/chart/line'
            ],
            function (ec) {
                var myChart = ec.init(document.getElementById('co'));
                var option = {
                    tooltip: {
                        show: true
                    },
                    legend: {
                        data: ['CO'],
                        textStyle: {
                            fontSize: 24
                        }
                    },
                    xAxis: [
                        {
                            type: 'category',
                            data: [
                                @foreach ($data as $a)
                                @if ($time_length == 'day')
                                '{{explode(" ", $a->serverTime)[1]}}',
                                @else
                                    '{{explode(" ", $a->serverTime)[0]}}',
                                @endif
                              @endforeach
                              ]
                        }
                    ],
                    yAxis: [
                        {
                            type: 'value',
                            axisLabel: {
                                formatter: '{value} CO'
                            }
                        }
                    ],
                    series: [
                        {
                            "name": "CO",
                            "type": "line",
                            "itemStyle": {normal: {color: '#1e90ff'}},
                            "data": [
                                @foreach ($data as $a)
                                {{$a -> co}},
                                @endforeach
                                ]
                        }
                    ]
                };
                myChart.setOption(option);
            }
    );
</script>

<script type="text/javascript">
    require.config({
        paths: {
            echarts: './js/echarts/build/dist'
        }
    });
    require(
            [
                'echarts',
                'echarts/chart/line'
            ],
            function (ec) {
                var myChart = ec.init(document.getElementById('no1'));
                var option = {
                    tooltip: {
                        show: true
                    },
                    legend: {
                        data: ['NO2'],
                        textStyle: {
                            fontSize: 24
                        }
                    },
                    xAxis: [
                        {
                            type: 'category',
                            data: [
                                @foreach ($data as $a)
                                @if ($time_length == 'day')
                                '{{explode(" ", $a->serverTime)[1]}}',
                                @else
                                    '{{explode(" ", $a->serverTime)[0]}}',
                                @endif
                              @endforeach
                              ]
                        }
                    ],
                    yAxis: [
                        {
                            type: 'value',
                            axisLabel: {
                                formatter: '{value} NO2'
                            }
                        }
                    ],
                    series: [
                        {
                            "name": "NO2",
                            "type": "line",
                            "itemStyle": {normal: {color: '#1e90ff'}},
                            "data": [
                                @foreach ($data as $a)
                                {{$a -> no1}},
                                @endforeach
                                ]
                        }
                    ]
                };
                myChart.setOption(option);
            }
    );
</script>

<script type="text/javascript">
    require.config({
        paths: {
            echarts: './js/echarts/build/dist'
        }
    });
    require(
            [
                'echarts',
                'echarts/chart/line'
            ],
            function (ec) {
                var myChart = ec.init(document.getElementById('so2'));
                var option = {
                    tooltip: {
                        show: true
                    },
                    legend: {
                        data: ['SO2'],
                        textStyle: {
                            fontSize: 24
                        }
                    },
                    xAxis: [
                        {
                            type: 'category',
                            data: [
                                @foreach ($data as $a)
                                @if ($time_length == 'day')
                                '{{explode(" ", $a->serverTime)[1]}}',
                                @else
                                    '{{explode(" ", $a->serverTime)[0]}}',
                                @endif
                              @endforeach
                              ]
                        }
                    ],
                    yAxis: [
                        {
                            type: 'value',
                            axisLabel: {
                                formatter: '{value} SO2'
                            }
                        }
                    ],
                    series: [
                        {
                            "name": "SO2",
                            "type": "line",
                            "itemStyle": {normal: {color: '#1e90ff'}},
                            "data": [
                                @foreach ($data as $a)
                                {{$a -> so2}},
                                @endforeach
                                ]
                        }
                    ]
                };
                myChart.setOption(option);
            }
    );
</script>

<script type="text/javascript">
    require.config({
        paths: {
            echarts: './js/echarts/build/dist'
        }
    });
    require(
            [
                'echarts',
                'echarts/chart/line'
            ],
            function (ec) {
                var myChart = ec.init(document.getElementById('lel'));
                var option = {
                    tooltip: {
                        show: true
                    },
                    legend: {
                        data: ['LEL'],
                        textStyle: {
                            fontSize: 24
                        }
                    },
                    xAxis: [
                        {
                            type: 'category',
                            data: [
                                @foreach ($data as $a)
                                @if ($time_length == 'day')
                                '{{explode(" ", $a->serverTime)[1]}}',
                                @else
                                    '{{explode(" ", $a->serverTime)[0]}}',
                                @endif
                              @endforeach
                              ]
                        }
                    ],
                    yAxis: [
                        {
                            type: 'value',
                            axisLabel: {
                                formatter: '{value} LEL'
                            }
                        }
                    ],
                    series: [
                        {
                            "name": "LEL",
                            "type": "line",
                            "itemStyle": {normal: {color: '#1e90ff'}},
                            "data": [
                                @foreach ($data as $a)
                                {{$a -> lel}},
                                @endforeach
                                ]
                        }
                    ]
                };
                myChart.setOption(option);
            }
    );
</script>

<script type="text/javascript">
    require.config({
        paths: {
            echarts: './js/echarts/build/dist'
        }
    });
    require(
            [
                'echarts',
                'echarts/chart/line'
            ],
            function (ec) {
                var myChart = ec.init(document.getElementById('dust'));
                var option = {
                    tooltip: {
                        show: true
                    },
                    legend: {
                        data: ['DUST'],
                        textStyle: {
                            fontSize: 24
                        }
                    },
                    xAxis: [
                        {
                            type: 'category',
                            data: [
                                @foreach ($data as $a)
                                @if ($time_length == 'day')
                                '{{explode(" ", $a->serverTime)[1]}}',
                                @else
                                    '{{explode(" ", $a->serverTime)[0]}}',
                                @endif
                              @endforeach
                              ]
                        }
                    ],
                    yAxis: [
                        {
                            type: 'value',
                            axisLabel: {
                                formatter: '{value} DUST'
                            }
                        }
                    ],
                    series: [
                        {
                            "name": "DUST",
                            "type": "line",
                            "itemStyle": {normal: {color: '#1e90ff'}},
                            "data": [
                                @foreach ($data as $a)
                                {{$a -> dust}},
                                @endforeach
                                ]
                        }
                    ]
                };
                myChart.setOption(option);
            }
    );
</script>
</body>
@stop
