@props(['name'])
<x-form.field>
    <x-form.label name="{{ $name }}"/>
    <textarea name="{{ $name }}" required
              class="border border-gray-300 p-2 w-full">{{ $slot ?? old($name) }}</textarea>
    <x-form.error name="{{ $name }}"/>
</x-form.field>
