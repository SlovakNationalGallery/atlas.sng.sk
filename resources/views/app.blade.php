<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="md:bg-gray-softest">

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
    <title>{{ trans('Atlas SNG') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @if (App::environment('production'))
        {{-- Clarity --}}
        <script type="text/javascript">
        (function(c,l,a,r,i,t,y){
            c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
            t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
            y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
        })(window, document, "clarity", "script", "etpn9t949w");
        </script>
        {{-- /Clarity --}}
        {{-- GA --}}
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-PEB9HHLHHY"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-PEB9HHLHHY');
        </script>
        {{-- /GA --}}
    @endif
</head>

<body>
    <div id="app" class="md:max-w-lg md:mx-auto md:my-auto bg-white min-h-screen flex flex-col"></div>
</body>

</html>
