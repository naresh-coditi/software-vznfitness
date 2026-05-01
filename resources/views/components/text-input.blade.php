@props(['disabled' => false])
<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'w-full py-2 px-2.5 rounded border-0 ring-1 ring-slate-200 bg-[#F5F5F5] focus:ring-orange-600 focus:outline-0 placeholder:text-sm']) !!}>
