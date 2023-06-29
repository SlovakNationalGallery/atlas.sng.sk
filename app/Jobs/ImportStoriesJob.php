<?php

namespace App\Jobs;

use App\Models\Story;
use App\Models\StoryLink;
use App\Traits\SyncsMedia;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\DataMappers\AirtableMapper;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ImportStoriesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, SyncsMedia;

    public function handle()
    {
        $mapper = app(AirtableMapper::class);
        $linksToField = $mapper->getField('story_links.story_id');

        $stories = \Airtable::table('stories')->all();
        $story_links = \Airtable::table('story_links')
            ->where($linksToField, '!=', '')
            ->all();

        $mapped = $mapper->mapTables(compact('stories', 'story_links'));

        DB::transaction(function () use ($mapped) {
            Story::whereNotIn('id', $mapped['stories']->pluck('id'))->delete();
            StoryLink::whereNotIn('id', $mapped['story_links']->pluck('id'))->delete();
            DB::table('story_story_link')->delete();

            Story::upsert($mapped['stories']->map->except(['links', 'media'])->toArray(), ['id']);
            StoryLink::upsert(
                $mapped['story_links']
                    // airtable single-linked record returns an array
                    ->map(fn(Collection $storyLink) => $storyLink->put('story_id', $storyLink['story_id'][0]))
                    ->toArray(),
                ['id']
            );

            // some links have empty Links to attribute
            $storyLinkIds = $mapped['story_links']->pluck('id');
            $allLinks = $mapped['stories']
                ->pluck('links', 'id')
                ->map(fn($links) => collect($links))
                ->map->filter(fn($link) => $storyLinkIds->contains($link));

            DB::table('story_story_link')->upsert(
                $allLinks
                    ->flatMap(
                        fn($links, $storyId) => $links->map(
                            fn($storyLinkId, $index) => [
                                'story_id' => $storyId,
                                'story_link_id' => $storyLinkId,
                                'ord' => $index,
                            ]
                        )
                    )
                    ->toArray(),
                ['story_id', 'story_link_id']
            );
        });

        $mapped['stories']->each(fn($record) => self::syncMedia(Story::find($record['id']), $record));
    }
}
