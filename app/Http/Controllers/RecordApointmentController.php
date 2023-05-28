<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Car;
use App\Models\RecordApointment;
use App\Models\TimeRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RecordApointmentController extends Controller
{
    public static function showView(Request $request)
    {
        $id = $request->get('id');
        $date = TimeRecord::find($id);

        $dateOut = new Carbon($date->date);
        $dateOut = $dateOut->format('Y-m-d');
        $dateString = new Carbon('now');
        $dateString = $dateString->addHours(9);
        if (Carbon::parse($date->date) <= Carbon::parse(substr($dateString->toDateTimeString(), 0, -3))) {
            return redirect("/?date=" . $dateOut);
        }

        if ($date->status == 1) {
            return redirect("/?date=" . $dateOut);
        }

        $clients = null;
        $cars = null;
        $fio = $request->get('fio');

        // dd($fio);
        if ($fio != '') {
            $fio_array = preg_split("/ /", $fio);
            $clients = Client::query();
            foreach ($fio_array as $fio_a) {
                $str = $fio_a;
                $clients = $clients->where('fio', 'like', "%$str%");
            }
            $clients = $clients->get();

            $id_clients = array();
            foreach ($clients as $client) {
                array_push($id_clients, $client->id);
            }
            // dd($client);
            $cars = Car::whereIn('id_client', $id_clients)->get();
            // dd($car);
        }

        $new = 'add';

        return view('addRecordApointmentView', [
            'date' => $date,
            'new' => $new,
            'clients' => $clients,
            'cars' => $cars,
            'fio' => $fio
        ]);
    }
    public static function addRecord(Request $request)
    {
        // dd($request);
        $id = $request->input('id');
        $reson = $request->input('client_reson');
        $date = TimeRecord::find($id);

        $id_client = $request->input('select_client');
        $id_car = $request->input('select_car');

        $record = new RecordApointment();
        $record->id_client = $id_client;
        $record->id_car = $id_car;
        $record->datetime = $date->date;
        $record->description = $reson;
        $record->status = 0;
        $record->save();

        $date->status = 1;
        $date->id_record = $record->id;
        $date->save();

        $dateOut = new Carbon($date->date);
        $dateOut = $dateOut->format('Y-m-d');
        // dd($client);
        return redirect("/?date=" . $dateOut);
    }

    public static function addWithNewCar(Request $request)
    {
        $id = $request->input('id');
        $reson = $request->input('client_reson');
        $date = TimeRecord::find($id);

        $id_client = $request->input('select_client');
        $mark = $request->input('add_mark');
        $model = $request->input('add_model');
        $gos_number = $request->input('add_gos_number');

        $car = new Car();
        $car->id_client = $id_client;
        $car->mark = $mark;
        $car->model = $model;
        $car->gos_number = $gos_number;
        $car->save();

        $record = new RecordApointment();
        $record->id_client = $id_client;
        $record->id_car = $car->id;
        $record->datetime = $date->date;
        $record->description = $reson;
        $record->status = 0;
        $record->save();

        $date->status = 1;
        $date->id_record = $record->id;
        $date->save();

        $dateOut = new Carbon($date->date);
        $dateOut = $dateOut->format('Y-m-d');
        // dd($client);
        return redirect("/?date=" . $dateOut);
    }

    public static function newClientAndCar(Request $request)
    {
        $id = $request->input('id');
        $reson = $request->input('client_reson');
        $date = TimeRecord::find($id);

        $fio = $request->input('client_fio');
        $number = $request->input('client_number');
        $mark = $request->input('client_mark');
        $model = $request->input('client_model');
        $gos_number = $request->input('client_gos_number');

        $client = new Client();
        $client->fio = $fio;
        $client->number = $number;
        $client->save();

        $car = new Car();
        $car->id_client = $client->id;
        $car->mark = $mark;
        $car->model = $model;
        $car->gos_number = $gos_number;
        $car->save();

        $record = new RecordApointment();
        $record->id_client = $client->id;
        $record->id_car = $car->id;
        $record->datetime = $date->date;
        $record->description = $reson;
        $record->status = 0;
        $record->save();

        $date->status = 1;
        $date->id_record = $record->id;
        $date->save();

        $dateOut = new Carbon($date->date);
        $dateOut = $dateOut->format('Y-m-d');
        // dd($client);
        return redirect("/?date=" . $dateOut);
    }
}
