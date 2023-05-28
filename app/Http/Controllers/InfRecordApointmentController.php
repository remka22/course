<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Car;
use App\Models\RecordApointment;
use App\Models\TimeRecord;
use Illuminate\Http\Request;
use Carbon\Carbon;

class InfRecordApointmentController extends Controller
{
    public static function showView(Request $request)
    {
        // dd($id = $request->get('id'));
        if ($request->get('id') != null) {
            $id = $request->get('id');

            $date = TimeRecord::find($id);
            $record = RecordApointment::find($date->id_record);
            $client = Client::find($record->id_client);
            $car = Car::find($record->id_car);

            $actual = true;
            $dateString = new Carbon('now');
            $dateString = $dateString->addHours(8);
            if (Carbon::parse($date->date) <= Carbon::parse(substr($dateString->toDateTimeString(), 0, -3))) {
                $actual = false;
            }
            $dateOut = new Carbon($date->date);
            $dateOut = $dateOut->format('Y-m-d');
        }
        else{
            $id_record = $request->get('id_record');

            $record = RecordApointment::find($id_record);
            $date = TimeRecord::where('date', '=', $record->datetime)->get()->first();
            $client = Client::find($record->id_client);
            $car = Car::find($record->id_car);

            $actual = true;
            $dateString = new Carbon('now');
            $dateString = $dateString->addHours(8);
            if (Carbon::parse($date->date) <= Carbon::parse(substr($dateString->toDateTimeString(), 0, -3))) {
                $actual = false;
            }
            $dateOut = new Carbon($date->date);
            $dateOut = $dateOut->format('Y-m-d');
        }

        return view('InfRecordApointmentView', [
            'date' => $date,
            'dateback' => $dateOut,
            'record' => $record,
            'client' => $client,
            'car' => $car,
            'actual' => $actual
        ]);
    }

    public static function setStatus(Request $request)
    {

        $id_record = $request->input('record');
        $record = RecordApointment::find($id_record);
        $id_date = $request->input('date');
        $date = TimeRecord::find($id_date);
        $selectStatus = $request->input('selectStatus');

        $record->status = $selectStatus;
        // dd($selectStatus);
        if ($selectStatus == "2") {
            $date->status = 0;
            $date->id_record = null;
            $date->save();
            $record->status = 2;
            $record->save();
            $dateOut = new Carbon($date->date);
            $dateOut = $dateOut->format('Y-m-d');
            return redirect("/?date=" . $dateOut);
        } elseif ($selectStatus == "1") {
            $record->status = 1;
            $record->save();
            $dateOut = new Carbon($date->date);
            $dateOut = $dateOut->format('Y-m-d');
            return redirect("/?date=" . $dateOut);
        }

        $dateOut = new Carbon($date->date);
        $dateOut = $dateOut->format('Y-m-d');
        // dd($client);
        return redirect("/?date=" . $dateOut);
    }
}
