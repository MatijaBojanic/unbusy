<?php

use function Pest\Laravel\{get};

it('returns a list of bus lines', function () {
    \App\Models\BusLine::factory(3)->create();

    $response = get('/api/v1/bus-lines');

    $response->assertJsonStructure([
        'type',
        'features' => [
            '*' => [
                'type',
                'properties' => [
                    'id',
                    'name'
                ],
                'geometry' => [
                    'type',
                    'coordinates',
                ],
            ],
        ],
    ]);
});

it('returns a specific bus line', function () {
    $busLine = \App\Models\BusLine::factory()->create();

    $response = get("/api/v1/bus-lines/{$busLine->id}");

    $response->assertJsonStructure([
        'type',
        'features' => [
            '*' => [
                'type',
                'properties' => [
                    'id',
                    'name'
                ],
                'geometry' => [
                    'type',
                    'coordinates',
                ],
            ],
        ],
    ]);

    $this->assertEquals($busLine->id, $response->json('features.0.properties.id'));

});
