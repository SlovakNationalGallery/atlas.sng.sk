@extends('layouts.master')

@section('content')
    <div class="mx-12 my-12">
        <a class="underline hover:no-underline" target="_blank" href="{{ route('import_type', ['type' => 'sections']) }}">sections (w/ items, exhibitions, stories)</a><br />
        <a class="underline hover:no-underline" target="_blank" href="{{ route('import_type', ['type' => 'items']) }}">items (w/ exhibitions, stories)</a><br />
        <a class="underline hover:no-underline" target="_blank" href="{{ route('import_type', ['type' => 'exhibitions']) }}">exhibitions</a><br />
        <a class="underline hover:no-underline" target="_blank" href="{{ route('import_type', ['type' => 'authorities']) }}">authorities</a><br />
        <a class="underline hover:no-underline" target="_blank" href="{{ route('import_type', ['type' => 'stories']) }}">stories</a><br />
    </div>
@endsection