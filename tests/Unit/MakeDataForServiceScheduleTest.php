<?php

namespace Tests\Unit;

use App\Models\TimeRecord;
use PHPUnit\Framework\TestCase;
use Carbon\Carbon;
use App\Http\Controllers\ServiceScheduleController;


class MakeDataForServiceScheduleTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_get_request_schedule(): void
    {
        $dates = TimeRecord::factory()->count(3)->make();

        $data_array = ServiceScheduleController::makeDataArrayTimeRecord($dates, 9);

        $date = new Carbon($data_array[0]['date']);
        $this->assertEquals(substr($date->toTimeString(), 0, -3), $date->format('h:i'));
    }

    public function test_post_request_schedule(): void
    {
        $dates = TimeRecord::factory()->count(3)->make();

        $data_array = ServiceScheduleController::makeDataArrayTimeRecord($dates, 8);

        $date = new Carbon($data_array[0]['date']);
        $this->assertEquals(substr($date->toDateTimeString(), 0, -3), $date->format('Y-m-d h:i'));
    }


}
