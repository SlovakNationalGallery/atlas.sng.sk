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
        'items' => ['stories', 'exhibitions'],
        'sections' => ['items'],
    ];

    protected $jobs = [
        'stories' => ImportStoriesJob::class,
        'exhibitions' => ImportExhibitionsJob::class,
        'items' => ImportItemsJob::class,
        'sections' => ImportSectionsJob::class,
        'authorities' => ImportAuthoritiesJob::class,
    ];

    public function __construct(protected string $type)
    {
        if (!isset($this->jobs[$type])) {
            throw new \InvalidArgumentException('Invalid type');
        }
    }

    public function handle()
    {
        $start = now();

        $this->resolveChain($this->type)
            ->map(fn($type) => new ($this->jobs[$type])())
            ->each->dispatchSync();

        $end = $start->diffInMilliseconds(now()) / 1000;
        $message = sprintf('Import of %s took %.1f seconds', $this->type, $end);
        Log::channel('import')->info($message);
    }

    protected function resolveChain(string $type)
    {
        return collect($this->dependencies[$type] ?? [])
            ->flatMap(fn($dependency) => $this->resolveChain($dependency))
            ->push($type);
    }
}