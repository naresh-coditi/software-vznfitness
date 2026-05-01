@props(['disabled' => false])
<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'w-full h-12 rounded-lg border-0 ring-1 ring-slate-200 bg-[#F5F5F5] focus:ring-orange-600 focus:outline-0']) !!}>
