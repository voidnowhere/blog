<x-layout>
    <main class="px-6 py-8">
        <section class="max-w-lg p-6 mx-auto">
            <x-panel>
                <h1 class="text-center font-bold text-xl">Log In!</h1>
                <form method="post" class="mt-10">
                    @csrf
                    <x-form.input name="email" type="email"/>
                    <x-form.input name="password" type="password"/>
                    <x-form.button>Log In</x-form.button>
                </form>
            </x-panel>
        </section>
    </main>
</x-layout>
