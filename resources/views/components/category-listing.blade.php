@props(['categories' => null, 'rest' => false])
<div>
    <select {!! $attributes->merge([
        'class' =>
            'mt-2 block w-full rounded border-0 py-1.5 text-gray-900 text-xs font-medium shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-orange-500 sm:text-sm sm:leading-6',
    ]) !!}>
        @if ($rest)
            <option value="">Rest</option>
        @endif
        @forelse ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}
            </option>
        @empty
            <option value="">No records</option>
        @endforelse
    </select>
</div>
