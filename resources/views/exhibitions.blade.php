@extends('layouts.master')

@section('title')
    Výstavy | @parent
@endsection

@section('content')
    <div class="mx-12 my-12">
        <h1 class="font-bold mb-8 pl-8 text-2xl">Výstavy</h1>

        <table class="table-auto border-collapse w-full">
            <thead>
                <tr>
                    <th class="border-b font-bold p-4 pl-8 pt-0 pb-3 text-left">Názov</th>
                    <th class="border-b font-bold p-4 pl-8 pt-0 pb-3 text-left"># kódov</th>
                    <th class="border-b font-bold p-4 pl-8 pt-0 pb-3 text-left"></th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach ($exhibitions as $exhibition)
                <tr>
                    <td class="border-b border-gray-soft p-4 pl-8">{{ $exhibition->name }}</td>
                    <td class="border-b border-gray-soft p-4 pl-8">{{ $exhibition->codes_count }}</td>
                    <td class="border-b border-gray-soft p-4 pl-8">
                        <x-button href="/items/?exhibition_id={{ $exhibition->id }}">diela</x-button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
