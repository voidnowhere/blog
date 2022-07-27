@props(['name', 'type' => 'text'])
<x-form.field>
    <x-form.label name="{{ $name }}"/>
    <input type="{{ $type }}" name="{{ $name }}" {{ $attributes(['value' => old($name)]) }}
    class="border border-gray-300 p-2 w-full">
    <x-form.error name="{{ $name }}"/>
</x-form.field>
