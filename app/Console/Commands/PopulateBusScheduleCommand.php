<?php

namespace App\Console\Commands;

use App\Models\BusLine;
use App\Models\BusSchedule;
use Illuminate\Console\Command;

class PopulateBusScheduleCommand extends Command
{
    protected $signature = 'populate:bus-schedule {id?}';

    protected $description = 'Populate the bus schedule for a line';

    public function handle(): void
    {
        $busLineId = $this->argument('id');

        $busLine = !empty($busLineId)? BusLine::find($busLineId) : BusLine::whereName('Stari aerodrom - Donja gorica')->first();

        if(!$busLine) {
            $this->error('Bus line not found');
            return;
        }

        $this->info('Populating bus schedule for bus line: ' . $busLine->name);


        BusSchedule::populateBusLineSchedule($busLine, 'Stari Aerodrom', 'weekday', '5:15' , 40, '21:55');
        BusSchedule::populateBusLineSchedule($busLine, 'Donja Gorica', 'weekday', '5:55' , 40, '21:55');
        BusSchedule::populateBusLineSchedule($busLine, 'Stari Aerodrom', 'saturday_and_holiday', '6:35' , 40, '21:55');
        BusSchedule::populateBusLineSchedule($busLine, 'Donja Gorica', 'saturday_and_holiday', '6:35' , 40, '21:55');
        BusSchedule::populateBusLineSchedule($busLine, 'Donja Gorica', 'sunday', '7:15' , 80, '21:55');
        BusSchedule::populateBusLineSchedule($busLine, 'Stari Aerodrom', 'sunday', '6:55' , 80, '21:55');

        $this->info('Bus schedule populated successfully');
    }
}
