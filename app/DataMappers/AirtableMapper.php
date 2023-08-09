<?php

namespace App\DataMappers;

use Illuminate\Support\Arr;

class AirtableMapper
{
    protected static array $tables = [
        'authorities' => [
            'id' => 'WU ID',
            'name' => 'Meno',
            'biography' => [
                'sk' => 'Text SK',
                'en' => 'Text EN',
            ],
            'related_items' => 'Odporúčané diela',
        ],
        'stories' => [
            'text' => [
                'sk' => 'Text SK',
                'en' => 'Text EN',
            ],
            'links' => 'Interakcie',
            'media' => 'Media',
            'video' => [
                'sk' => 'Video SK',
                'en' => 'Video EN',
            ],
        ],
        'story_links' => [
            'title' => [
                'sk' => 'Text SK',
                'en' => 'Text EN',
            ],
            'story_id' => 'Links to',
        ],
        'exhibitions' => [
            'name' => 'Name',
        ],
        'places' => [
            'title' => [
                'sk' => 'Názov SK',
                'en' => 'Názov EN',
            ],
            'description' => [
                'sk' => 'Text SK',
                'en' => 'Text EN',
            ],
            'media' => 'Media',
            'offset_top' => 'offsetTop',
            'exhibition' => 'Výstava.0',
            'video_title' => [
                'sk' => 'Video title SK',
                'en' => 'Video title EN',
            ],
            'video_subtitle' => [
                'sk' => 'Video subtitle SK',
                'en' => 'Video subtitle EN',
            ],
            'video' => [
                'sk' => 'Video URL SK',
                'en' => 'Video URL EN',
            ],
            'location_id' => 'Lokácia.0',
        ],
        'locations' => [
            'name' => [
                'sk' => 'Lokácia SK',
                'en' => 'Lokácia EN',
            ],
            'title' => [
                'sk' => 'Názov SK',
                'en' => 'Názov EN',
            ],
            'floor' => 'Podlažie',
            'building' => 'Budova',
        ],
        'bucketlists' => [
            'title' => [
                'sk' => 'Názov',
                'en' => 'Názov EN',
            ],
            'text' => [
                'sk' => 'Text',
                'en' => 'Text EN',
            ],
            'media' => 'Image',
            'items' => 'Diela',
        ],
        'sections' => [
            'title' => [
                'sk' => 'Názov sekcie',
                'en' => 'Názov sekcie EN',
            ],
            'description' => [
                'sk' => 'Text sekcie',
                'en' => 'Text sekcie EN',
            ],
            'media' => 'Media',
            'location_id' => 'Lokácia.0',
            'exhibition' => 'Výstava.0',
            'items' => 'Diela sekcie',
        ],
    ];

    public function getField(string $field)
    {
        return Arr::get(self::$tables, $field);
    }

    public function mapTables($tables)
    {
        return collect($tables)->map([$this, 'mapTable']);
    }

    public function mapTable($records, string $tableName, bool $encodeJson = true)
    {
        return $records->map(function ($record) use ($tableName, $encodeJson) {
            $mappedFields = collect(self::$tables[$tableName])->map(function ($source) use ($record, $encodeJson) {
                if (is_array($source)) {
                    $data = collect($source)->map(fn($source) => Arr::get($record, "fields.$source"));
                    return $encodeJson ? $data->toJson() : $data->toArray();
                } else {
                    return Arr::get($record, "fields.$source");
                }
            });

            return collect(['id' => $record['id'], ...$mappedFields]);
        });
    }
}
