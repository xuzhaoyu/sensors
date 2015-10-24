<?php

class ExhaustController extends \BaseController
{

    public function getIndex()
    {
            $all_mac = DB::table('exhaustname')->select('mac')->get();
            $data_list = array();

            foreach ($all_mac as $mac) {
                $mac_addr = $mac->mac;
                $a = DB::table('exhaust')
                    ->where('mac', '=', $mac_addr)
                    ->orderBy('serverTime', 'DESC')
                    ->select( 'mac', 'serverTime', 'co', 'no1', 'so2', 'lel', 'dust')
                    ->first();

                $n = DB::table('exhaustname')
                    ->select('room')
                    ->where('mac', '=', $mac_addr)
                    ->first();

                if ($a && $n) {
                    $data_list[] = array(
                        'room' => $n->room,
                        'mac' => $mac_addr,
                        'co' => $a->co,
                        'no1' => $a->no1,
                        'so2' => $a->so2,
                        'lel' => $a->lel,
                        'dust' => $a->dust,
                        'serverTime' => $a->serverTime
                    );
                }
            }
            sort($data_list);
            return View::make('exhaust.presentData')->with('data', $data_list);
    }

    public function getForm()
    {

        $room = DB::table('exhaustname')->select('room', 'mac', 'ip')->get();
        return View::make('exhaust.setRoom')->with('room', $room);
    }

    public function postRoom()
    {
        $input = Input::all();
        $mac = DB::table('exhaustname')->select('mac')->where('mac', '=', $input['mac'])->get();
        if ($mac == []) {
            DB::table('exhaustname')->insert(array('mac' => $input['mac']));
        }
        if (strlen($input['name']) > 0) {
            DB::table('exhaustname')->where('mac', '=', $input['mac'])->update(array('room' => $input['name']));
        }
        return View::make('success');
    }

    public function getRooms()
    {
            $data = DB::table('exhaustname')->select('ip', 'mac', 'room')->get();
            return View::make('exhaust.presentRooms')->with('data', $data);

    }

    public function getGraph($mac, $time_length)
    {
        $room = DB::table('exhaustname')->select('room')->where('mac', '=', $mac)->first();
        $q = DB::table('exhaust')
            ->where('mac', '=', $mac)
            ->orderBy('serverTime', 'DEST')
            ->select('serverTime', 'co', 'no1', 'so2', 'lel', 'dust')
            ->first();
        $date = new DateTime($q->serverTime);
        if ($time_length == 'month') {
            $start_from = $date->modify('-1 month')->format('Y-m-d H:i:s');
            $all_tp = DB::table('exhaust')
                ->where('serverTime', '>=', $start_from)
                ->where('mac', '=', $mac)
                ->orderBy('serverTime')
                ->select('serverTime',  'co', 'no1', 'so2', 'lel', 'dust')
                ->get();
        } elseif ($time_length == 'day') {
            $start_from = $date->modify('-1 day')->format('Y-m-d H:i:s');
            $all_tp = DB::table('exhaust')
                ->where('serverTime', '>=', $start_from)
                ->where('mac', '=', $mac)
                ->orderBy('serverTime')
                ->select('serverTime', 'co', 'no1', 'so2', 'lel', 'dust')
                ->get();
        } else {
            $all_tp = DB::table('exhaust')
                ->where('mac', '=', $mac)
                ->orderBy('serverTime')
                ->select('serverTime', 'co', 'no1', 'so2', 'lel', 'dust')
                ->get();
        }

        return View::make('exhaust.presentGraph')->with('data', $all_tp)->with('room', $room->room)->with('time_length', $time_length)-> with('mac', $mac);
    }

    public function getDelete($mac)
    {
        DB::table('exhaust')
            -> where('mac', '=', $mac)
            -> delete();

        DB::table('exhaustname')
            -> where('mac', '=', $mac)
            -> delete();
        return Redirect::to(URL::route('exhaustRooms'));
    }

    public function postReading()
    {
        $input = (object)Input::all();
        date_default_timezone_set('Asia/Shanghai');
        $date = date('Y-m-d H:i:s');
        DB::table('exhaust')->insert(
            array('serverTime' => $date,
                'ip' => $input->ip,
                'mac' => $input->mac,
                'co' => $input->co,
                'no1' => $input->no1,
                'so2' => $input->so2,
                'lel' => $input->lel,
                'dust' => $input->dust)
        );
        $name = DB::table('exhaustname')
            ->where('mac', $input->mac)
            ->first();

        if ($name == NULL) {
            DB::table('exhaustname')
                ->insert(array(
                    'mac' => $input->mac,
                    'ip' => $input->ip,
                    'room' => 'New Room'
                ));
        } else if ($name->ip != $input->ip) {
            DB::table('exhaustname')
                ->where('mac', $input->mac)
                ->update(array('ip' => $input->ip));
        }
    }

}
