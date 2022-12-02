@extends('layouts.master')

@section('title')
    {{ trans('Stories') }} | @parent
@endsection

@section('content')
    <div class="mx-12 my-12">
        <h1 class="font-bold mb-8 pl-8 text-2xl">{{ trans('Stories') }}</h1>

        <div class="border-l border-t border-gray-soft flex flex-wrap">
        @foreach ($stories as $story)
            <div class="border-b border-r border-gray-soft p-8 w-full lg:w-1/2">
                <p class="my-2"><a class="underline hover:no-underline" href="/story/{{ $story->id }}">{{ $story->id }}</a></p>
                <p class="my-2">{{ $story->text }}</p>
                @foreach ($story->links as $link)
                    <a class="inline-block border-1 px-2 py-1" href="/story/{{ $link->story_id }}">{{ $link->title }}</a>
                @endforeach
            </div>
        @endforeach
        </div>
    </div>
@endsection
