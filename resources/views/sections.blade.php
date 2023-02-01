@extends('layouts.master')

@section('title')
    Sekcie | @parent
@endsection

@section('content')
    <div class="mx-12 my-12">
        <h1 class="font-bold mb-8 pl-8 text-2xl">Sekcie</h1>

        <table class="table-auto border-collapse w-full">
            <thead>
                <tr>
                    <th class="border-b font-bold p-4 pl-8 pt-0 pb-3 text-left">#</th>
                    <th class="border-b font-bold p-4 pl-8 pt-0 pb-3 text-left">Kód</th>
                    <th class="border-b font-bold p-4 pl-8 pt-0 pb-3 text-left">Názov</th>
                    <th class="border-b font-bold p-4 pl-8 pt-0 pb-3 text-left">Výstava</th>
                    <th class="border-b font-bold p-4 pl-8 pt-0 pb-3 text-left"></th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach ($sections as $section)
                <tr>
                    <td class="border-b border-gray-soft p-4 pl-8">{{ $section->code->id }}</td>
                    <td class="border-b border-gray-soft p-4 pl-8"><img class="h-auto w-10" src="/img/{{ $section->code->code }}.svg?color=black&v=1" alt="{{ $section->code->code }}" /></td>
                    <td class="border-b border-gray-soft p-4 pl-8">{{ $section->title }}</td>
                    <td class="border-b border-gray-soft p-4 pl-8">{{ $section->code->exhibition->name ?? '' }}</td>
                    <td class="border-b border-gray-soft p-4 pl-8">
                        <x-button href="/group/{{ $section->id }}">zobraziť</x-button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
