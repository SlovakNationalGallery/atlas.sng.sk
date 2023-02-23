<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $dependencies = [
        'items' => ['stories', 'exhibitions', 'locations'],
        'sections' => ['items', 'locations'],
        'places' => ['stories', 'exhibitions', 'locations'],
    ];

    protected $jobs = [
        'stories' => ImportStoriesJob::class,
        'exhibitions' => ImportExhibitionsJob::class,
        'items' => ImportItemsJob::class,
        'sections' => ImportSectionsJob::class,
        'places' => ImportPlacesJob::class,
        'authorities' => ImportAuthoritiesJob::class,
        'locations' => ImportLocationsJob::class,
    ];

    public function __construct(protected string $type)
    {
        if (!isset($this->jobs[$type])) {
            throw new \InvalidArgumentException('Invalid type');
        }
    }

    public function handle()
    {
        try {
            $start = now();

            $this->resolveChain($this->type)
                ->map(fn($type) => new ($this->jobs[$type])())
                ->each->dispatchSync();

            $end = $start->diffInMilliseconds(now()) / 1000;
            $message = sprintf('Import of %s took %.1f seconds', $this->type, $end);
            Log::channel('import')->info($message);
        } catch (\Exception $e) {
            Log::channel('import')->error($e);
            throw $e;
        }
    }

    protected function resolveChain(string $type)
    {
        return collect($this->dependencies[$type] ?? [])
            ->flatMap(fn($dependency) => $this->resolveChain($dependency))
            ->push($type);
    }
}
