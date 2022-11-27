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
        ],
        'stories' => [
            'text' => [
                'sk' => 'Text SK',
                'en' => 'Text EN',
            ],
            'links' => 'Interakcie',
            'media' => 'Media',
            'video' => 'Video',
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
        'stories' => [
            'text' => [
                'sk' => 'Text SK',
                'en' => 'Text EN',
            ],
            'links' => 'Interakcie',
            'media' => 'Media',
        ],
        'story_links' => [
            'title' => [
                'sk' => 'Text SK',
                'en' => 'Text EN',
            ],
            'story_id' => 'Links to',
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

    public function mapTable($records, string $tableName)
    {
        return $records->map(function ($record) use ($tableName) {
            $mappedFields = collect(self::$tables[$tableName])->map(function ($source) use ($record) {
                if (is_array($source)) {
                    return collect($source)
                        ->map(fn($source) => Arr::get($record, "fields.$source"))
                        ->toJson();
                } else {
                    return Arr::get($record, "fields.$source");
                }
            });

            return collect(['id' => $record['id'], ...$mappedFields]);
        });
    }
}
