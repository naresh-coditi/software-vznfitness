@props(['content', 'url' => null, 'class' => null])

<a class="rounded-md bg-brand px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-brand-700 inline-block {{ $class }}"
    href="{{ $url }}">{{ $content }}</a>
