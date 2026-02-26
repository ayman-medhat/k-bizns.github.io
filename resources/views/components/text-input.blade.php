@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-[#dbbf9f] focus:border-[#be9f81] focus:ring-[#be9f81] rounded-xl shadow-sm bg-[#fff9f0] text-[#3e2e21]']) !!}>