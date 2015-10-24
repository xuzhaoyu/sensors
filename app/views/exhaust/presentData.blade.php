@extends('layouts.master')

@section('content')

    <?php
    header("refresh:120;");
    ?>

    <style>
        table, th, td {
            border: 1px solid black;
            font-size: 27px;
            font-weight: 600;
        }

        th {
            background-color: #1e90ff;
            color: #2c3e50;
        }

        td {
            background-color: #94C5CC;
        }

        a:link {
            color: #2c3e50;
        }

        a:visited {
            color: #2c3e50;
        }
    </style>

    <table>
        <tr>
            <th>房间</th>
            <th>CO</th>
            <th>NO</th>
            <th>SO2</th>
            <th>LEL</th>
            <th>Dust</th>
            <th>时间</th>
        </tr>

        @foreach($data as $a)
            <tr>
                <td style="background-color:#1e90ff"><a href="/exhaust/graph/{{$a['mac']}}/day">{{$a['room']}}</a></td>
                <td>{{$a['co']}}</td>
                <td>{{$a['no1']}}</td>
                <td>{{$a['so2']}}</td>
                <td>{{$a['lel']}}</td>
                <td>{{$a['dust']}}</td>
                <td>{{$a['serverTime']}}</td>
            </tr>
        @endforeach
    </table>

    <body>
    <br>
    <br>

    <div id="co" style="height:400px"></div>
    <div id="no1" style="height:400px"></div>
    <div id="so2" style="height:400px"></div>
    <div id="lel" style="height:400px"></div>
    <div id="dust" style="height:400px"></div>
    <!-- ECharts import -->
    {{ HTML::script('js/echarts/build/dist/echarts.js'); }}

    <script type="text/javascript">
        require.config({
            paths: {
                echarts: '../js/echarts/build/dist'
            }
        });
        require(
                [
                    'echarts',
                    'echarts/chart/bar'
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
                                    @foreach($data as $a)
                                        '{{$a['room']}}',
                                    @endforeach
                                    ],
                                axisLabel: {
                                    textStyle: {
                                        fontWeight: 'bolder'
                                    }
                                }
                            }],
                        yAxis: [
                            {
                                type: 'value',
                                axisLabel: {
                                    formatter: '{value} CO',
                                    textStyle: {
                                        fontWeight: 'bolder'
                                    }
                                }
                            }],
                        series: [
                            {
                                "name": "CO",
                                "type": "bar",
                                "barWidth": 50,
                                "itemStyle": {normal: {color: '#1e90ff'}},
                                "data": [
                                    @foreach($data as $a)
                                        {{$a['co']}},
                                    @endforeach
                                ]
                            }]
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
                    'echarts/chart/bar'
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
                                    @foreach($data as $a)
                                        '{{$a['room']}}',
                                    @endforeach
                                ],
                                axisLabel: {
                                    textStyle: {
                                        fontWeight: 'bolder'
                                    }
                                }
                            }],
                        yAxis: [
                            {
                                type: 'value',
                                axisLabel: {
                                    formatter: '{value} 个',
                                    textStyle: {
                                        fontWeight: 'bolder'
                                    }
                                }
                            }],
                        series: [
                            {
                                "name": "DUST",
                                "type": "bar",
                                "barWidth": 50,
                                "itemStyle": {normal: {color: '#1e90ff'}},
                                "data": [
                                    @foreach($data as $a)
                                        {{$a['dust']}},
                                    @endforeach
                                ]
                            }]
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
                    'echarts/chart/bar'
                ],
                function (ec) {
                    var myChart = ec.init(document.getElementById('no1'));
                    var option = {
                        tooltip: {
                            show: true
                        },
                        legend: {
                            data: ['NO1'],
                            textStyle: {
                                fontSize: 24
                            }
                        },
                        xAxis: [
                            {
                                type: 'category',
                                data: [
                                    @foreach($data as $a)
                                        '{{$a['room']}}',
                                    @endforeach
                                ],
                                axisLabel: {
                                    textStyle: {
                                        fontWeight: 'bolder'
                                    }
                                }
                            }],
                        yAxis: [
                            {
                                type: 'value',
                                axisLabel: {
                                    formatter: '{value} NO1',
                                    textStyle: {
                                        fontWeight: 'bolder'
                                    }
                                }
                            }],
                        series: [
                            {
                                "name": "NO1",
                                "type": "bar",
                                "barWidth": 50,
                                "itemStyle": {normal: {color: '#1e90ff'}},
                                "data": [
                                    @foreach($data as $a)
                                        {{$a['no1']}},
                                    @endforeach
                                ]
                            }]
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
                    'echarts/chart/bar'
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
                                    @foreach($data as $a)
                                        '{{$a['room']}}',
                                    @endforeach
                                ],
                                axisLabel: {
                                    textStyle: {
                                        fontWeight: 'bolder'
                                    }
                                }
                            }],
                        yAxis: [
                            {
                                type: 'value',
                                axisLabel: {
                                    formatter: '{value} SO2',
                                    textStyle: {
                                        fontWeight: 'bolder'
                                    }
                                }
                            }],
                        series: [
                            {
                                "name": "SO2",
                                "type": "bar",
                                "barWidth": 50,
                                "itemStyle": {normal: {color: '#1e90ff'}},
                                "data": [
                                    @foreach($data as $a)
                                        {{$a['so2']}},
                                    @endforeach
                                ]
                            }]
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
                    'echarts/chart/bar'
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
                                    @foreach($data as $a)
                                        '{{$a['room']}}',
                                    @endforeach
                                ],
                                axisLabel: {
                                    textStyle: {
                                        fontWeight: 'bolder'
                                    }
                                }
                            }],
                        yAxis: [
                            {
                                type: 'value',
                                axisLabel: {
                                    formatter: '{value} LEL',
                                    textStyle: {
                                        fontWeight: 'bolder'
                                    }
                                }
                            }],
                        series: [
                            {
                                "name": "LEL",
                                "type": "bar",
                                "barWidth": 50,
                                "itemStyle": {normal: {color: '#1e90ff'}},
                                "data": [
                                    @foreach($data as $a)
                                        {{$a['lel']}},
                                    @endforeach
                                ]
                            }]
                    };
                    myChart.setOption(option);
                }
        );
    </script>
    </body>
@stop
