@props(['img' => null, 'count' => null, 'label' => null, 'color' => null, 'href' => '#'])
<a href="{{ $href }}">
    <div class="px-4 py-10 rounded-lg border text-black w-full
     {{ $color ? $color : '' }} relative">
        <!-- Count at the top-right corner -->
        <div class="absolute top-2 right-2 text-xs font-medium bg-orange-100 border border-orange-500 text-orange-500 rounded-full px-2 py-1">
            {{ $count }}
        </div>
        
        <!-- SVG or image at the top center -->
        <div class="flex justify-center mb-4">
            {{ $img }}
        </div>
        
        <!-- Label at the bottom -->
        <div class="text-center space-y-4">
            {{ $slot }}
            <h3 class="font-bold text-base mt-4">{{ $label }}</h3>
        </div>
    </div>
</a>
