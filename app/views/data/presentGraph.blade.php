@extends('layouts.master')

@section('content')
<?php
  header( "refresh:10;" );
?>
<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <title>{{$room}}</title>
</head>
<body>
    {{$room}}
    <br>
    <div id="temp" style="height:400px"></div>
    <div id="humidity" style="height:400px"></div>
    <div id="pressure" style="height:400px"></div>
    <div id="smoke" style="height:400px"></div>
    <div id="dust" style="height:400px"></div>
    {{ HTML::script('js/echarts/build/dist/echarts.js'); }}
    <script type="text/javascript">
        require.config({
            paths: {
                echarts: 'http://123.57.66.77/js/echarts/build/dist'
            }
        });
        require(
            [
                'echarts',
                'echarts/chart/line'
            ],
            function (ec) {
                var myChart = ec.init(document.getElementById('temp'));
                var option = {
                    tooltip: {
                        show: true
                    },
                    legend: {
                        data:['温度']
                    },
                    xAxis : [
                        {
                            type : 'category',
                            data : [<?php
                                        foreach ($data as $a) {
                                            echo '\'';
                                            print_r (explode(" ", $a->serverTime)[1]);
                                            echo '\'';
                                            echo ', ';
                                        }
                                  ?>]
                        }
                    ],
                    yAxis : [
                        {
                            type : 'value',
                            axisLabel : {
                              formatter: '{value} °C'
                            }
                        }
                    ],
                    series : [
                        {
                            "name":"温度",
                            "type":"line",
                            "data": [<?php
                                         foreach ($data as $a) {
                                             echo $a -> dhtTemp;
                                             echo ', ';
                                         }
                                     ?>]
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
                echarts: 'http://123.57.66.77/js/echarts/build/dist'
            }
        });
        require(
            [
                'echarts',
                'echarts/chart/line'
            ],
            function (ec) {
                var myChart = ec.init(document.getElementById('humidity'));
                var option = {
                    tooltip: {
                        show: true
                    },
                    legend: {
                        data:['湿度']
                    },
                    xAxis : [
                        {
                            type : 'category',
                            data : [<?php
                                        foreach ($data as $a) {
                                            echo '\'';
                                            print_r (explode(" ", $a->serverTime)[1]);
                                            echo '\'';
                                            echo ', ';
                                        }
                                  ?>]
                        }
                    ],
                    yAxis : [
                        {
                            type : 'value',
                            axisLabel : {
                              formatter: '{value} %RH'
                            }
                        }
                    ],
                    series : [
                        {
                            "name":"湿度",
                            "type":"line",
                            "data": [<?php
                                         foreach ($data as $a) {
                                             echo $a -> dhtHumidity;
                                             echo ', ';
                                         }
                                     ?>]
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
                echarts: 'http://123.57.66.77/js/echarts/build/dist'
            }
        });
        require(
            [
                'echarts',
                'echarts/chart/line'
            ],
            function (ec) {
                var myChart = ec.init(document.getElementById('pressure'));
                var option = {
                    tooltip: {
                        show: true
                    },
                    legend: {
                        data:['压差']
                    },
                    xAxis : [
                        {
                            type : 'category',
                            data : [<?php
                                        foreach ($data as $a) {
                                            echo '\'';
                                            print_r (explode(" ", $a->serverTime)[1]);
                                            echo '\'';
                                            echo ', ';
                                        }
                                  ?>]
                        }
                    ],
                    yAxis : [
                        {
                            type : 'value',
                            axisLabel : {
                              formatter: '{value} Pa'
                            }
                        }
                    ],
                    series : [
                        {
                            "name":"压差",
                            "type":"line",
                            "data": [<?php
                                         foreach ($data as $a) {
                                             echo $a -> MS5611Pressure;
                                             echo ', ';
                                         }
                                     ?>]
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
                echarts: 'http://123.57.66.77/js/echarts/build/dist'
            }
        });
        require(
            [
                'echarts',
                'echarts/chart/line' // require the specific chart type
            ],
            function (ec) {
                var myChart = ec.init(document.getElementById('smoke'));
                var option = {
                    tooltip: {
                        show: true
                    },
                    legend: {
                        data:['烟雾']
                    },
                    xAxis : [
                        {
                            type : 'category',
                            data : [<?php
                                        foreach ($data as $a) {
                                            echo '\'';
                                            print_r (explode(" ", $a->serverTime)[1]);
                                            echo '\'';
                                            echo ', ';
                                        }
                                  ?>]
                        }
                    ],
                    yAxis : [
                        {
                            type : 'value',
                            axisLabel : {
                              formatter: '{value} Volt'
                            }
                        }
                    ],
                    series : [
                        {
                            "name":"烟雾",
                            "type":"line",
                            "data": [<?php
                                         foreach ($data as $a) {
                                             echo $a -> MQ2Smoke;
                                             echo ', ';
                                         }
                                     ?>]
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
                echarts: 'http://123.57.66.77/js/echarts/build/dist'
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
                        data:['尘埃微粒']
                    },
                    xAxis : [
                        {
                            type : 'category',
                            data : [<?php
                                        foreach ($data as $a) {
                                            echo '\'';
                                            print_r (explode(" ", $a->serverTime)[1]);
                                            echo '\'';
                                            echo ', ';
                                        }
                                  ?>]
                        }
                    ],
                    yAxis : [
                        {
                            type : 'value',
                            axisLabel : {
                              formatter: '{value} Volt'
                            }
                        }
                    ],
                    series : [
                        {
                            "name":"尘埃微粒",
                            "type":"line",
                            "data": [<?php
                                         foreach ($data as $a) {
                                             echo $a -> Dust;
                                             echo ', ';
                                         }
                                     ?>]
                        }
                    ]
                };
                myChart.setOption(option);
            }
        );
    </script>
</body>
