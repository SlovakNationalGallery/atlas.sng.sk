@extends('layouts.master')

@section('title')
    Import | @parent
@endsection

@section('content')
    <div class="mx-12 my-12">
        <h1 class="font-bold mb-8 pl-8 text-2xl">Import</h1>

        <div class="pl-8">
            <a class="underline hover:no-underline" target="_blank" href="{{ route('import_type', ['type' => 'sections']) }}">sections (w/ items, exhibitions, stories, locations)</a><br />
            <a class="underline hover:no-underline" target="_blank" href="{{ route('import_type', ['type' => 'bucketlists']) }}">bucketlists (w/ items, exhibitions, stories, locations)</a><br />
            <a class="underline hover:no-underline" target="_blank" href="{{ route('import_type', ['type' => 'items']) }}">items (w/ exhibitions, stories, locations)</a><br />
            <a class="underline hover:no-underline" target="_blank" href="{{ route('import_type', ['type' => 'places']) }}">places (w/ exhibitions, stories, locations)</a><br />
            <a class="underline hover:no-underline" target="_blank" href="{{ route('import_type', ['type' => 'exhibitions']) }}">exhibitions</a><br />
            <a class="underline hover:no-underline" target="_blank" href="{{ route('import_type', ['type' => 'authorities']) }}">authorities</a><br />
            <a class="underline hover:no-underline" target="_blank" href="{{ route('import_type', ['type' => 'stories']) }}">stories</a><br />
            <a class="underline hover:no-underline" target="_blank" href="{{ route('import_type', ['type' => 'locations']) }}">locations</a><br />
        </div>
    </div>
@endsection