@extends('layouts.master')

@section('title')
    {{ trans('Items') }} | @parent
@endsection

@section('content')
    <div class="mx-12 my-12">
        <h1 class="font-bold mb-8 pl-8 text-2xl">{{ trans('Items') }}</h1>

        <table class="table-auto border-collapse w-full">
            <thead>
                <tr>
                    <th class="border-b font-bold p-4 pl-8 pt-0 pb-3 text-left">#</th>
                    <th class="border-b font-bold p-4 pl-8 pt-0 pb-3 text-left">Kód</th>
                    <th class="border-b font-bold p-4 pl-8 pt-0 pb-3 text-left">ID diela</th>
                    <th class="border-b font-bold p-4 pl-8 pt-0 pb-3 text-left">Názov</th>
                    <th class="border-b font-bold p-4 pl-8 pt-0 pb-3 text-left">Autor</th>
                    <th class="border-b font-bold p-4 pl-8 pt-0 pb-3 text-left">Výstava</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach ($items as $item)
                <tr>
                    <td class="border-b border-gray-soft p-4 pl-8">{{ $item->code->id }}</td>
                    <td class="border-b border-gray-soft p-4 pl-8"><img class="h-auto w-10" src="/img/{{ $item->code->code }}.svg?color=black&v=1" alt="{{ $item->code->code }}" /></td>
                    <td class="border-b border-gray-soft p-4 pl-8">{{ $item->id }}</td>
                    <td class="border-b border-gray-soft p-4 pl-8">{{ $item->title }}</td>
                    <td class="border-b border-gray-soft p-4 pl-8">{{ $item->author_name }}</td>
                    <td class="border-b border-gray-soft p-4 pl-8">{{ $item->code->exhibition->name ?? '' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection