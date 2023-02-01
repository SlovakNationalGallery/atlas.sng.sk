@extends('layouts.master')

@section('title')
    Miesta | @parent
@endsection

@section('content')
    <div class="mx-12 my-12">
        <h1 class="font-bold mb-8 pl-8 text-2xl">Miesta</h1>

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
                @foreach ($places as $place)
                <tr>
                    <td class="border-b border-gray-soft p-4 pl-8">{{ $place->code->id }}</td>
                    <td class="border-b border-gray-soft p-4 pl-8"><img class="h-auto w-10" src="/img/{{ $place->code->code }}.svg?color=black&v=1" alt="{{ $place->code->code }}" /></td>
                    <td class="border-b border-gray-soft p-4 pl-8">{{ $place->title }}</td>
                    <td class="border-b border-gray-soft p-4 pl-8">{{ $place->code->exhibition->name ?? '' }}</td>
                    <td class="border-b border-gray-soft p-4 pl-8">
                        <x-button href="/place/{{ $place->id }}">zobraziť</x-button>
                        <x-button href="/place/{{ $place->id }}?edit=1">upraviť</x-button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
