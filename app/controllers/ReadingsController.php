<?php

class ReadingsController extends \BaseController
{

    public function getIndex()
    {
        $all_mac = DB::table('sensors')->select('mac', 'ip')->groupBy('mac')->get();

        $data_list = array();

        foreach ($all_mac as $mac) {
            $mac_addr = $mac->mac;
            $ip = $mac->ip;
            $name = DB::table('ip2name')
                ->where('mac',$mac_addr)
                ->first();
            $thresh = DB::table('thresholds')
                ->where('mac',$mac_addr)
                ->first();
            if ($name == NULL){
                DB::table('ip2name')
                    -> insert(array(
                        'mac' => $mac_addr,
                        'ip' => $ip,
                        'room' => '新车间'
                    ));
            }
            if ($thresh == NULL){
                DB::table('thresholds')
                    -> insert(array(
                        'mac' => $mac_addr,
                        'tempMin' => 0,
                        'tempMax' => 0,
                        'humidityMin' => 0,
                        'humidityMax' => 0,
                        'pressureMin' => 0,
                        'pressureMax' => 0,
                        'dustMin' => 0,
                        'dustMax' => 0
                    ));
            }
            $a = DB::table('sensors')
                ->where('mac', '=', $mac_addr)
                ->orderBy('serverTime', 'DESC')
                ->select('ip', 'mac', 'serverTime', 'temp', 'humidity', 'pressure', 'dust')
                ->first();

            $n = DB::table('ip2name')
                ->select('room')
                ->where('mac', '=', $mac_addr)
                ->first();

            $data_list[] = array(
                'room' => $n->room,
                'mac' => $mac_addr,
                'temp' => $a->temp,
                'humidity' => $a->humidity,
                'pressure' => $a->pressure,
                'dust' => $a->dust,
                'serverTime' => $a->serverTime
            );

        }
        return View::make('data.presentData')->with('data', $data_list);
    }

    public function getForm()
    {
        $room = DB::table('ip2name')->select('room', 'mac')->get();
        return View::make('data.setThreshold')->with('room', $room);
    }

    public function postVariable()
    {
        $input = Input::all();
        $mac = DB::table('thresholds')->select('mac')->where('mac', '=', $input['mac'])->get();
        if ($mac == []) {
            DB::table('thresholds')->insert(array('mac' => $input['mac']));
        }
        if (is_numeric($input['tempMin'])) {
            DB::table('thresholds')->where('mac', '=', $input['mac'])->update(array('tempMin' => $input['tempMin']));
        }
        if (is_numeric($input['tempMax'])) {
            DB::table('thresholds')->where('mac', '=', $input['mac'])->update(array('tempMax' => $input['tempMax']));
        }
        if (is_numeric($input['humidityMin'])) {
            DB::table('thresholds')->where('mac', '=', $input['mac'])->update(array('humidityMin' => $input['humidityMin']));
        }
        if (is_numeric($input['humidityMax'])) {
            DB::table('thresholds')->where('mac', '=', $input['mac'])->update(array('humidityMax' => $input['humidityMax']));
        }
        if (is_numeric($input['pressureMin'])) {
            DB::table('thresholds')->where('mac', '=', $input['mac'])->update(array('pressureMin' => $input['pressureMin']));
        }
        if (is_numeric($input['pressureMax'])) {
            DB::table('thresholds')->where('mac', '=', $input['mac'])->update(array('pressureMax' => $input['pressureMax']));
        }
        if (is_numeric($input['dustMin'])) {
            DB::table('thresholds')->where('mac', '=', $input['mac'])->update(array('dustMin' => $input['dustMin']));
        }
        if (is_numeric($input['dustMax'])) {
            DB::table('thresholds')->where('mac', '=', $input['mac'])->update(array('dustMax' => $input['dustMax']));
        }
        if(strlen($input['name']) > 0){
          DB::table('ip2name')->where('mac', '=', $input['mac'])->update(array('room' => $input['name']));
        }
        return View::make('success');
    }

    public function postControls(){
      $input = Input::all();
      $thresholds = DB::table('thresholds')->select('*')->where('mac', '=', $input['mac'])->get();
      return $thresholds;
    }

    public function getGraph($room)
    {
        $m = DB::table('ip2name')
            ->where('room', '=', $room)
            ->select('mac')
            ->first();

        $mac = $m->mac;

        $all_tp = DB::table('sensors')
            ->where('mac', '=', $mac)
            ->orderBy('serverTime')
            ->select('serverTime', 'temp', 'humidity', 'pressure', 'dust')
            ->get();

        $t = DB::table('thresholds')->where('mac', '=', $mac)
            ->select('tempMin', 'tempMax', 'humidityMin', 'humidityMax', 'pressureMin', 'pressureMax', 'dustMin', 'dustMax')
            ->first();

        return View::make('data.presentGraph')->with('data', $all_tp)->with('room', $room)->with('t', $t);
    }

    public function postReading()
    {
        $input = (object)Input::all();
        date_default_timezone_set('Asia/Shanghai');
        $date = date('Y-m-d H:i:s');
        DB::table('sensors')->insert(
            array('clientTime' => $input->clientTime,
                'serverTime' => $date,
                'ip' => $input->ip,
                'mac' => $input->mac,
                'temp' => $input->temp,
                'humidity' => $input->humidity,
                'pressure' => $input->pressure,
                'dust' => $input->dust)
        );
    }
}
