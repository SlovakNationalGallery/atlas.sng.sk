<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="md:bg-gray-softest md:h-screen">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
        <title>{{ trans('Záložky SNG') }}</title>
        @if (App::environment('production'))
            {{-- Clarity --}}
            <script type="text/javascript"> (function(c,l,a,r,i,t,y){ c[a]=c[a]||function()
            {(c[a].q=c[a].q||[]).push(arguments)}
            ; t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i; y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y); })(window, document, "clarity", "script", "az0i6tv0rb"); </script>
             {{-- /Clarity --}}
             {{-- GA --}}
             <script async src="https://www.googletagmanager.com/gtag/js?id=UA-222618680-1"></script>
             <script>
               window.dataLayer = window.dataLayer || [];
               function gtag(){dataLayer.push(arguments);}
               gtag('js', new Date());  gtag('config', 'UA-222618680-1');
             </script>
             {{-- /GA --}}
        @endif
    </head>
    <body class="md:h-screen">
        <div id="app" class="md:max-w-lg md:mx-auto md:my-auto bg-white md:h-screen md:flex md:flex-col"></div>
        <script src="{{ mix('/js/app.js') }}"></script>
    </body>
</html>