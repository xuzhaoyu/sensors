<?php

class ReadingsController extends \BaseController
{

    public function getIndex()
    {
        if (Auth::user()) {
            $email = User::find(Auth::id())->email;
            $all_mac = DB::table('ip2name')->select('mac', 'ip')->where('email', $email)->get();
            $columns = DB::table('users')->select('temp', 'pressure', 'dust')->where('email', $email)->first();
            $data_list = array();

            foreach ($all_mac as $mac) {
                $mac_addr = $mac->mac;
                $a = DB::table('sensors')
                    ->where('mac', '=', $mac_addr)
                    ->orderBy('serverTime', 'DESC')
                    ->select('ip', 'mac', 'serverTime', 'temp', 'humidity', 'pressure', 'dust')
                    ->first();

                $n = DB::table('ip2name')
                    ->select('room')
                    ->where('mac', '=', $mac_addr)
                    ->first();

                if ($a && $n) {
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

            }
            return View::make('data.presentData')->with('data', $data_list)->with('columns', $columns);
        }
        return Redirect::to(URL::route('account-login'));
    }

    public function getForm()
    {
        if (Auth::user()) {
            $email = User::find(Auth::id())->email;
            $columns = DB::table('users')->select('temp', 'pressure', 'dust')->where('email', $email)->first();
            $room = DB::table('ip2name')->select('room', 'mac', 'ip')->where('email', $email)->get();
            return View::make('data.setThreshold')->with('room', $room)->with('columns', $columns);
        }
        return Redirect::to(URL::route('account-login'));
    }

    public function postVariable()
    {
        $input = Input::all();
        $email = User::find(Auth::id())->email;
        $columns = DB::table('users')->select('temp', 'pressure', 'dust')->where('email', $email)->first();
        $mac = DB::table('thresholds')->select('mac')->where('mac', '=', $input['mac'])->get();
        if ($mac == []) {
            DB::table('thresholds')->insert(array('mac' => $input['mac']));
        }
        if($columns->temp) {
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
        }
        if($columns->pressure) {
            if (is_numeric($input['pressureMin'])) {
                DB::table('thresholds')->where('mac', '=', $input['mac'])->update(array('pressureMin' => $input['pressureMin']));
            }
            if (is_numeric($input['pressureMax'])) {
                DB::table('thresholds')->where('mac', '=', $input['mac'])->update(array('pressureMax' => $input['pressureMax']));
            }
        }
        if($columns->dust) {
            if (is_numeric($input['dustMin'])) {
                DB::table('thresholds')->where('mac', '=', $input['mac'])->update(array('dustMin' => $input['dustMin']));
            }
            if (is_numeric($input['dustMax'])) {
                DB::table('thresholds')->where('mac', '=', $input['mac'])->update(array('dustMax' => $input['dustMax']));
            }
        }
        if (is_numeric($input['intervals'])) {
            DB::table('thresholds')->where('mac', '=', $input['mac'])->update(array('intervals' => $input['intervals']));
        }
        if (strlen($input['name']) > 0) {
            DB::table('ip2name')->where('mac', '=', $input['mac'])->update(array('room' => $input['name']));
        }
        return View::make('success');
    }

    public function postControls()
    {
        $input = Input::all();
        $thresholds = DB::table('thresholds')->select('*')->where('mac', '=', $input['mac'])->get();
        return $thresholds;
    }

    public function getRooms()
    {
        if (Auth::user()) {
            $email = User::find(Auth::id())->email;
            $data = DB::table('ip2name')->select('ip', 'mac', 'room')->where('email', $email)->get();
            return View::make('data.presentRooms')->with('data', $data);
        }
        return Redirect::to(URL::route('account-login'));
    }

    public function getRecordsData($room)
    {
        $m = DB::table('ip2name')
            ->where('room', '=', $room)
            ->select('mac')
            ->first();
        $email = User::find(Auth::id())->email;
        $columns = DB::table('users')->select('temp', 'pressure', 'dust')->where('email', $email)->first();
        $data = DB::table('sensors')->select('id','temp', 'humidity', 'pressure', 'dust', 'serverTime')->where('mac', '=', $m->mac)->orderBy('serverTime', 'DESC')->get();
        return View::make('data.presentRecords')->with('data', $data)->with('columns', $columns);
    }

    public function getRecords(){
        $email = User::find(Auth::id())->email;
        $path = app_path('files/'.$email."_".date("Ymd").'_backup.txt');
        if(file_exists($path)){
            unlink($path);
        }
        DB::statement("select ip2name.room, sensors.ip,sensors.mac,sensors.temp, sensors.humidity, sensors.serverTime from sensors join ip2name on sensors.mac = ip2name.mac order by sensors.serverTime desc into outfile '".$path."' fields terminated by '\t'");
        App::finish(function($request, $response) use ($path)
        {
            unlink($path);
        });
        //DB::statement("truncate table sensors");
        return Response::download($path);
    }

    public function postEditRecords(){
        $email = User::find(Auth::id())->email;
        $columns = DB::table('users')->select('temp', 'pressure', 'dust')->where('email', $email)->first();
        $input = Input::all();
        for($i = 1; $i <= $input['count']; $i++){
            if($columns->temp) {
                if (is_numeric($input['temp' . $i])) {
                    DB::table('sensors')->where('id', '=', $input['id' . $i])->update(array('temp' => $input['temp' . $i]));
                }
                if (is_numeric($input['humidity' . $i])) {
                    DB::table('sensors')->where('id', '=', $input['id' . $i])->update(array('humidity' => $input['humidity' . $i]));
                }
            }
            if($columns->pressure) {
                if (is_numeric($input['pressure' . $i])) {
                    DB::table('sensors')->where('id', '=', $input['id' . $i])->update(array('pressure' => $input['pressure' . $i]));
                }
            }
            if($columns->dust) {
                if (is_numeric($input['dust' . $i])) {
                    DB::table('sensors')->where('id', '=', $input['id' . $i])->update(array('dust' => $input['dust' . $i]));
                }
            }
        }
        return Redirect::to(URL::route('readings'));
    }

    public function getGraph($mac, $time_length)
    {
        $email = User::find(Auth::id())->email;
        $columns = DB::table('users')->select('temp', 'pressure', 'dust')->where('email', $email)->first();
        $room = DB::table('ip2name')->select('room')->where('mac', '=', $mac)->first();
        $q = DB::table('sensors')
            ->where('mac', '=', $mac)
            ->orderBy('serverTime', 'DEST')
            ->select('serverTime', 'temp', 'humidity', 'pressure', 'dust')
            ->first();
        $date = new DateTime($q->serverTime);
        if ($time_length == 'month') {
            $start_from = $date->modify('-1 month')->format('Y-m-d H:i:s');
            $all_tp = DB::table('sensors')
                ->where('serverTime', '>=', $start_from)
                ->where('mac', '=', $mac)
                ->orderBy('serverTime')
                ->select('serverTime', 'temp', 'humidity', 'pressure', 'dust')
                ->get();
        } elseif ($time_length == 'day') {
            $start_from = $date->modify('-1 day')->format('Y-m-d H:i:s');
            $all_tp = DB::table('sensors')
                ->where('serverTime', '>=', $start_from)
                ->where('mac', '=', $mac)
                ->orderBy('serverTime')
                ->select('serverTime', 'temp', 'humidity', 'pressure', 'dust')
                ->get();
        } else {
            $all_tp = DB::table('sensors')
                ->where('mac', '=', $mac)
                ->orderBy('serverTime')
                ->select('serverTime', 'temp', 'humidity', 'pressure', 'dust')
                ->get();
        }


        $t = DB::table('thresholds')->where('mac', '=', $mac)
            ->select('tempMin', 'tempMax', 'humidityMin', 'humidityMax', 'pressureMin', 'pressureMax', 'dustMin', 'dustMax')
            ->first();

        return View::make('data.presentGraph')->with('data', $all_tp)->with('room', $room->room)->with('t', $t)->with('time_length', $time_length)->with('columns', $columns)->with('mac', $mac);
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
        $name = DB::table('ip2name')
            ->where('mac', $input->mac)
            ->first();
        $thresh = DB::table('thresholds')
            ->where('mac', $input->mac)
            ->first();
        if ($name == NULL) {
            DB::table('ip2name')
                ->insert(array(
                    'mac' => $input->mac,
                    'ip' => $input->ip,
                    'room' => '新车间',
                    'email' => 'new'
                ));
        } else if ($name->ip != $input->ip) {
            DB::table('ip2name')
                ->where('mac', $input->mac)
                ->update(array('ip' => $input->ip));
        }
        if ($thresh == NULL) {
            DB::table('thresholds')
                ->insert(array(
                    'mac' => $input->mac,
                    'tempMin' => 0,
                    'tempMax' => 0,
                    'humidityMin' => 0,
                    'humidityMax' => 0,
                    'pressureMin' => 0,
                    'pressureMax' => 0,
                    'dustMin' => 0,
                    'dustMax' => 0,
                    'intervals' => 30
                ));
        }
    }

    public function postRecords()
    {
        $input = (object)Input::all();
        date_default_timezone_set('Asia/Shanghai');
        $date = date('Y-m-d H:i:s');
        DB::table('records')->insert(
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

    public function postServer(){
        $input = Input::all();
        $email = DB::table('ip2name')->select('email')->where('mac', '=', $input['mac'])->first();
        $server = DB::table('users')->select('server')->where('email', '=', $email->email)->first();
        return $server->server;
    }
}
