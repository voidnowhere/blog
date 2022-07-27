@props(['heading'])
<section class="py-8 max-w-4xl mx-auto">
    <h1 class="text-lg font-bold mb-6 pb-3 border-b">{{ $heading }}</h1>
    <div class="flex">
        <aside class="w-48">
            <h4 class="font-semibold mb-2">Links</h4>
            <ul class="pl-4">
                <li>
                    <a href="{{ route('admin.posts') }}"
                       class="{{ request()->routeIs('admin.posts') ? 'text-blue-500 border-b-2 border-blue-500' : '' }}">All Posts</a>
                </li>
                <li>
                    <a href="{{ route('admin.posts.create') }}"
                       class="{{ request()->routeIs('admin.posts.create') ? 'text-blue-500 border-b-2 border-blue-500' : '' }}">New Post</a>
                </li>
            </ul>
        </aside>
        <x-panel class="flex-1">
            {{ $slot }}
        </x-panel>
    </div>
</section>
