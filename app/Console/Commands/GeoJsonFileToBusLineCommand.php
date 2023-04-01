<?php

namespace App\Console\Commands;

use App\Models\BusLine;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GeoJsonFileToBusLineCommand extends Command
{
    protected $signature = 'populate:bus-lines-from-directory';

    protected $description = 'From each geojson file in the bus-lines directory, create a bus line';

    public function handle(): void
    {
        $this->info('Starting the import of bus lines from geojson files');

        $files = Storage::disk('public')->files('bus-lines');

        foreach ($files as $file) {
            $jsonContents = Storage::disk('public')->get($file);
            $decodedContents = json_decode($jsonContents, true);

            $busLine = BusLine::fromGeoJson($decodedContents['features']);
            $this->line('Created bus line ' . $busLine->name);
        }

        $this->info('Done!');
    }
}
