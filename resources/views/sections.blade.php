<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#000000">
    <meta name="theme-color" content="#ffffff">

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <title>{{ trans('Sections') }} | {{ trans('SNG Codes') }}</title>
</head>

<body>
    <div class="mx-12 my-12">
        <h1 class="font-bold mb-8 pl-8 text-2xl">{{ trans('Sections') }}</h1>

        <table class="table-auto border-collapse w-full">
            <thead>
                <tr>
                    <th class="border-b font-bold p-4 pl-8 pt-0 pb-3 text-left">#</th>
                    <th class="border-b font-bold p-4 pl-8 pt-0 pb-3 text-left">Kód</th>
                    <th class="border-b font-bold p-4 pl-8 pt-0 pb-3 text-left">Názov</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach ($sections as $section)
                <tr>
                    <td class="border-b border-gray-soft p-4 pl-8">{{ $section->code->id }}</td>
                    <td class="border-b border-gray-soft p-4 pl-8"><img class="h-10 w-10" src="/img/{{ $section->code->code }}.svg?color=black" alt="{{ $section->code->code }}" /></td>
                    <td class="border-b border-gray-soft p-4 pl-8">{{ $section->title }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script src="{{ mix('/js/app.js') }}"></script>
</body>

</html>
