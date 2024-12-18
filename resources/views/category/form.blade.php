<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <form action="{{$category->exists?route('category.update',$category):route('category.store')}}" class="space-y-4" method="post">
        @csrf
        @if($category->exists)
            @method('PUT')
        @endif
        <div class="space-y-2">
            <x-input-label for="name">Nome</x-input-label>
            <x-text-input name="name" value="{{old('name',$category->name)}}" class="w-full"/>
        </div>
        <footer class="flex justify-end">
            <x-button type="submit">Salvar</x-button>
        </footer>
    </form>
</div>
</div>
</x-app-layout>
