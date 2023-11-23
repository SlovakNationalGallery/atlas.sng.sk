<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Spatie\ResponseCache\Facades\ResponseCache;

class ImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $dependencies = [
        'items' => ['stories', 'exhibitions', 'locations'],
        'sections' => ['items'],
        'places' => ['stories', 'exhibitions', 'locations'],
        'bucketlists' => ['items'],
    ];

    protected $jobs = [
        'stories' => ImportStoriesJob::class,
        'exhibitions' => ImportExhibitionsJob::class,
        'items' => ImportItemsJob::class,
        'sections' => ImportSectionsJob::class,
        'places' => ImportPlacesJob::class,
        'authorities' => ImportAuthoritiesJob::class,
        'locations' => ImportLocationsJob::class,
        'bucketlists' => ImportBucketlistsJob::class,
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
        } finally {
            // clear API response cache after import
            ResponseCache::clear();
        }
    }

    protected function resolveChain(string $type)
    {
        return collect($this->dependencies[$type] ?? [])
            ->flatMap(fn($dependency) => $this->resolveChain($dependency))
            ->push($type);
    }
}
