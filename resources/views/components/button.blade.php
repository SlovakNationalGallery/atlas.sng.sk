<a {{ $attributes->merge(['class' => 'inline-block rounded-xl text-sm border-2 border-black bg-green/30 px-2.5 py-1 mr-2 hover:bg-green', 'target' => '_blank']) }}>
    {{ $slot }}
</a>