<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <form action="{{$user->exists?route('user.update',$user):route('user.store')}}" class="space-y-4" method="post">
        @csrf
        @if($user->exists)
            @method('PUT')
        @endif
        <div class="space-y-2">
            <x-input-label for="name">Nome</x-input-label>
            <x-text-input name="name" value="{{old('name',$user->name)}}" class="w-full"/>
            <x-input-error :messages="$errors->get('name')" />
        </div>
        <div class="space-y-2">
            <x-input-label for="email">E-mail</x-input-label>
            <x-text-input name="email" value="{{old('email',$user->email)}}" class="w-full"/>
            <x-input-error :messages="$errors->get('email')" />
        </div>
        <footer class="flex justify-end">
            <x-button type="submit">Salvar</x-button>
        </footer>
    </form>
</div>
</div>
</x-app-layout>
