@extends('layouts.master')

@section('content')

<?php
header( "refresh:120;" );
?>

<style>
    table, th, td {
      border: 1px solid black;
      font-size:37px;
      font-weight:600;
    }
    th{
        background-color: #1e90ff;
        color: #2c3e50;
    }
    td{
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
    <th>温度</th>
    <th>湿度</th>
    <th>压力</th>
    <th>尘埃微粒</th>
    <th>时间</th>
  </tr>

  <?php
  foreach ($data as $a) {

    $t = DB::table('thresholds')->where('mac', '=', $a['mac'])
    ->select('tempMin', 'tempMax', 'humidityMin', 'humidityMax', 'pressureMin', 'pressureMax', 'dustMin', 'dustMax')
    ->first();
    echo '<tr>';
    echo '<td style="background-color:#1e90ff">';
    echo '<a href="';
    echo URL::route('graphs');
    echo '/';
    print_r($a['room']);
    echo '/day';

    echo '">';
    print_r($a['room']);
    echo '</a>';
    echo '</td>';

    if (($a['temp'] > $t -> tempMax) or ($a['temp'] < $t -> tempMin)) {
      echo '<td style="background-color:blue"><span style="color:red;">';
      print_r($a['temp']);
      echo '</span></td>';
    } else {
      echo '<td>';
      print_r($a['temp']);
      echo '</td>';
    }

    if (($a['humidity'] > $t -> humidityMax) or ($a['humidity'] < $t -> humidityMin)) {
      echo '<td style="background-color:blue"><span style="color:red;">';
      print_r($a['humidity']);
      echo '</span></td>';
    } else {
      echo '<td>';
      print_r($a['humidity']);
      echo '</td>';
    }

    if (($a['pressure'] > $t -> pressureMax) or ($a['pressure'] < $t -> pressureMin)) {
      echo '<td style="background-color:blue"><span style="color:red;">';
      print_r($a['pressure']);
      echo '</span></td>';
    } else {
      echo '<td>';
      print_r($a['pressure']);
      echo '</td>';
    }

    if (($a['dust'] > $t -> dustMax) or ($a['dust'] < $t -> dustMin)) {
      echo '<td style="background-color:blue"><span style="color:red;">';
      print_r($a['dust']);
      echo '</span></td>';
    } else {
      echo '<td>';
      print_r($a['dust']);
      echo '</td>';
    }

    echo '<td>';
    print_r($a['serverTime']);
    echo '</td>';

    echo '</tr>';
  }
  ?>
</table>

<body>
  <br>
  <br>
  <div id="pressure" style="height:400px; width:600px"></div>
  <div id="dust" style="height:400px; width:600px"></div>
  <!-- ECharts import -->
  {{ HTML::script('js/echarts/build/dist/echarts.js'); }}
  <script type="text/javascript">
  require.config({
    paths: {
      echarts:'http://123.57.251.73/js/echarts/build/dist'
    }
  });
  require(
    [
    'echarts',
    'echarts/chart/bar'
    ],
    function (ec) {
      var myChart = ec.init(document.getElementById('pressure'));
      var option = {
        tooltip: {
          show: true
        },
        legend: {
          data:['压差'],
          textStyle:{
            fontSize: 24
          }
        },
        xAxis : [
        {
          type : 'category',
          data : [<?php
          foreach ($data as $a) {
            echo '\'';
            print_r ($a['room']);
            echo '\'';
            echo ', ';
          }
          ?>],
            axisLabel : {
                textStyle:{
                    fontWeight: 'bolder'
                }
            }
        }],
        yAxis : [
        {
          type : 'value',
          axisLabel : {
            formatter: '{value} Pa',
            textStyle:{
                  fontWeight: 'bolder'
            }
          }
        }],
        series : [
        {
          "name":"压差",
          "type":"bar",
          "barWidth": 50,
          "itemStyle":{normal:{color:'#1e90ff'}},
          "data": [<?php
          foreach ($data as $a) {
            echo $a['pressure'];
            echo ', ';
          }
          ?>]
        }]
      };
      myChart.setOption(option);
    }
  );
  </script>

  <script type="text/javascript">
  require.config({
    paths: {
      echarts: 'http://123.57.251.73/js/echarts/build/dist'
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
          data:['尘埃微粒'],
          textStyle:{
            fontSize: 24
          }
        },
        xAxis : [
        {
          type : 'category',
          data : [<?php
          foreach ($data as $a) {
            echo '\'';
            print_r ($a['room']);
            echo '\'';
            echo ', ';
          }
          ?>],
            axisLabel : {
                textStyle:{
                    fontWeight: 'bolder'
                }
            }
        }],
        yAxis : [
        {
          type : 'value',
          axisLabel : {
            formatter: '{value} 个',
            textStyle:{
                fontWeight: 'bolder'
            }
          }
        }],
        series : [
        {
          "name":"尘埃微粒",
          "type":"bar",
          "barWidth": 50,
          "itemStyle":{normal:{color:'#1e90ff'}},
          "data": [<?php
          foreach ($data as $a) {
            echo $a['dust'];
            echo ', ';
          }
          ?>]
        }]
      };
      myChart.setOption(option);
    }
  );
  </script>
</body>
@stop
