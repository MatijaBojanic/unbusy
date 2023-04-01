<?php

namespace App\Console\Commands;

use App\Models\BusLine;
use Illuminate\Console\Command;

class BusLinesToFilesCommand extends Command
{
    protected $signature = 'bus:lines-to-files';

    protected $description = 'Take each busLine and save it to a file as geojson';

    public function handle(): void
    {
        $this->info('Starting to save bus lines to files');
        $busLines = BusLine::all();
        $this->info('Got all bus lines, now saving them to files');
        foreach($busLines as $busLine) {
            $this->line('Saving bus line ' . $busLine->name);
            $busLine->saveToGeoJsonFile();
        }
        $this->info('Done!');
    }
}
