<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Car;
use App\Models\DayWeek;
use App\Models\RecordApointment;
use App\Models\TimeRecord;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ServiceScheduleController extends Controller
{
    public static function  showDay(Request $request)
    {
        $statusPage = "day";
        $dateInput = $request->input('date') ?? date('Y-m-d');
        $dates = TimeRecord::where('date', 'like', "%" . $dateInput . "%")->get();
        ServiceScheduleController::setMonth();

        $data = json_decode($dates, true, 512, JSON_THROW_ON_ERROR);
        $data_out_filter = ServiceScheduleController::makeDataArrayTimeRecord($data, 9);


        return view('serviceScheduleView', [
            'dates' => $data_out_filter,
            'dateInput' => $dateInput,
            'fio' => '',
            'statusPage' => $statusPage
        ]);
    }

    public static function makeDataArrayTimeRecord($data, $hoursAdd){
        $data_out_filter = array();
        $i = 0;
        while ($i < count($data)) {
            $dateString = new Carbon('now');
            $dateString = $dateString->addHours($hoursAdd);
            // dd(Carbon::parse(substr($dateString->toDateTimeString(),0,-3)));

            $actual = false;
            if (Carbon::parse($data[$i]['date']) >= Carbon::parse(substr($dateString->toDateTimeString(), 0, -3))) {
                $actual = true;
            }

            $dateForData = $data[$i]['date'];
            if ($hoursAdd == 9){
                $dateForData = substr(Carbon::parse($data[$i]['date'])->toTimeString(), 0, -3);
            }

            if ($data[$i]['status'] == 1) {
                $record = RecordApointment::find($data[$i]['id_record']);
                $client = Client::find($record->id_client);
                $car = Car::find($record->id_car);
                $data_model = [
                    'id' => $data[$i]['id'],
                    'date' => $dateForData,
                    'status' => $data[$i]['status'],

                    'id_record' => $record->id,
                    'status_record' =>  $record->status,
                    'id_client' => $record->id_client,
                    'description' => $record->description,
                    'fio' => $client->fio,
                    'number' => $client->number,
                    'car' => "$car->mark $car->model $car->gos_number",

                    'actual' => $actual

                ];
            } else {
                $data_model = [
                    'id' => $data[$i]['id'],
                    'date' => $dateForData,
                    'status' => $data[$i]['status'],
                    'statusStr' => "Свободно",
                    'actual' => $actual
                ];
            }


            array_push($data_out_filter, $data_model);

            $i++;
        }
        return $data_out_filter;
    }

    public static function getRecordFio(Request $request)
    {
        $statusPage = "record";
        $fio = $request->input('fio');
        $fio_array = preg_split("/ /", $fio);
        $clients = Client::query();
        foreach ($fio_array as $fio_a){
            $str = $fio_a;
            $clients = $clients->where('fio', 'like', "%$str%");
        }
        $clients = $clients->get();


        $id_clients = [];
        foreach ($clients as $client) {
            array_push($id_clients, $client->id);
        }
        $records = RecordApointment::whereIn('id_client', $id_clients)->get();
        // dd($records);
        $id_records = [];
        foreach ($records as $record) {
            array_push($id_records, $record->id);
        }
        $dates = TimeRecord::whereIn('id_record', $id_records)->get();
        // dd($dates);
        $dateInput = $request->input('date') ?? date('Y-m-d');

        $data = json_decode($dates, true, 512, JSON_THROW_ON_ERROR);
        $data_out_filter = ServiceScheduleController::makeDataArrayTimeRecord($data, 8);


        return view('serviceScheduleView', [
            'dates' => $data_out_filter,
            'dateInput' => $dateInput,
            'fio' => $fio,
            'statusPage' => $statusPage
        ]);
    }


    public static function setMonth()
    {
        $start = new Carbon('now');
        $startdate =  $start->addHours(8)->format('Y-m-d');
        $date = $startdate;
        for ($i = 1; $i <= 31; $i++) {
            $dates = TimeRecord::where('date', 'like', "%$date%")->get();
            if ($dates->count() == 0) {
                $yearmonthday = $start->format('Y-m-d');
                $hour = 8;
                $minute = "00";
                $workday = [10, 11];
                $liteday = [10, 11, 20, 21, 22, 23];
                $arrayfree = $workday;
                if ($start->dayOfWeek == 6 || $start->dayOfWeek == 0) {
                    $arrayfree = $liteday;
                }
                for ($j = 0; $j < 24; $j++) {
                    if (!in_array($j, $arrayfree)) {
                        $timeRecoed = new TimeRecord();
                        $timeRecoed->date = $yearmonthday . " " . $hour . ":" . $minute;
                        $timeRecoed->status = 0;
                        $timeRecoed->id_record = null;
                        $timeRecoed->save();
                    }

                    switch ($minute) {
                        case "00":
                            $minute = "30";
                            break;
                        case "30":
                            $minute = "00";
                            $hour++;
                    }
                }
            }
            $date = $start->addDays(1)->format('Y-m-d');
        }
    }
}
