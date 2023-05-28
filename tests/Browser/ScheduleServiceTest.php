<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use App\Models\RecordApointment;
use App\Models\TimeRecord;
use App\Models\Client;
use App\Models\Car;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ScheduleServiceTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function test_on_find_record_whith_fio_pilipenkoMihailMihailovich(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/') //Переходим на страницу календаря расписания
                    ->type('@fio', 'Ми') //Вводим часть ФИО клиента
                    ->press('find_record_fio_bt') //Нажимаем на кнопку "Поиск"
                    ->assertSee('Пилипенко Михаил Михайлович'); //Проверяем надичие записи с таким тектом
        });
    }

    public function test_on_find_record_and_visit_add_record(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/?date=2023-06-11') //Переходим на страницу календаря расписания
                                                //с датой 2023-06-11
                    ->clickAndWaitForReload('@recordBt1789') //Нажимаем на кнопку "Записать"
                    ->assertPathIs('/record_appointment'); //Проверяем что нас перебросило на страницу
                                                            //создания записи на прием
        });
    }

    public function test_on_add_new_client_car_record(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/?date=2023-06-11')//Заходим на страницу расписания
                    ->clickAndWaitForReload('@recordBt1790') //Нажимаем на кнопку "Записаться"
                    //и пеереходим на страницу создания записи на прием
                    ->click('@new_client') //Нажимаем на кнопку "Новый клиент"
                    ->type('@fio', 'Тест ФИО') //Вводим ФИО клиент
                    ->type('@number', '890000000') //Вводим номер клиента
                    ->type('@mark', 'ТестМарка') //Вводим марку
                    ->type('@model', 'ТестМодель') //Вводим модель
                    ->type('@gos_number', 'ТестГосНомер') //Вводим гос номер
                    ->type('@resone', 'ТестПричина') //Вводим причину посещения автосервиса
                    ->press('@add'); //Нажимаем кнопку "Записать"
        });
        //Получаем данные которые мы создали
        $client = Client::where('fio', '=', 'Тест ФИО')->get();
        $car = Car::where('mark', '=', 'ТестМарка')->get();
        $record = RecordApointment::where('id_client', '=', $client->last()->id)->get();
        $date = TimeRecord::find(1790);

        //Проверяем то что данные все есть
        $this->assertTrue($client->count() != 0 && $car->count() != 0 && $record->count() != 0 && $date->status == 1);
    }
}
