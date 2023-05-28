<?php

namespace Tests\Feature;

use App\Models\TimeRecord;
use App\Models\RecordApointment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Carbon\Carbon;
use Tests\TestCase;

use function PHPUnit\Framework\isEmpty;

class AddRecordTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_get_on_old_date(): void
    {
        //Запросим из БД расписания Запись даты и времени с прошлвм временем для записи
        $date = TimeRecord::where('date', '<', now())->take(1)->get()->first();

        $response = $this->get("/record_appointment?id=" . $date->id);
        $response->assertStatus(302); //302 - код редиректа
    }

    public function test_get_on_will_date(): void
    {
        // Получим текущую дату и время в формате как в БД (Г-м-д ч:с)
        $now = new Carbon('now');
        $now->addHours(8);
        $now = substr($now->toDateTimeString(), 0, -3);

        //Запросим из БД расписания Запись даты и времени с будущим временем для записи
        $date = TimeRecord::where('date', '>', $now)->take(10)->get()->last();

        $response = $this->get("/record_appointment?id=" . $date->id);
        $response->assertStatus(200); //200 - код успешной загрузки сайта
    }

    public function test_post_add_record(): void
    {
        //Делаем пост запрос
        $this->postJson('/record_appointment', [
            'new' => 'add',
            'id' => 1750,
            'client_reson' => 'Замена фильтров',
            'select_client' => 3,
            'select_car' => 4,
        ]);

        //Получаем запись даты и времени, чтобы взять поле дата
        $date = TimeRecord::find(1750);

        //Ищем ту запись которую мы хотели создать в тесте
        $record = RecordApointment::where('datetime', '=', $date->date)->where('status', '=', 0)->get();

        //Проверяем количество полученых записей на прием, если 0 то пост запрос не работает
        $this->assertTrue($record->count() !=0);
    }
}
