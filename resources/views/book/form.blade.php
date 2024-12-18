<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <form action="{{$book->exists?route('book.update',$book):route('book.store')}}" class="space-y-4" method="post">
        @csrf
        @if($book->exists)
            @method('PUT')
        @endif
        <div class="space-y-2">
            <x-input-label for="name">Nome</x-input-label>
            <x-text-input name="name" value="{{old('name',$book->name)}}" class="w-full"/>
            <x-input-error :messages="$errors->get('name')" />
        </div>
        <div class="space-y-2">
            <x-input-label for="author_id">Autor</x-input-label>
            <div>
              <div class="grid grid-cols-1">
                <select id="author_id" name="author_id" class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                    @foreach($authors as $author_id=>$author)
                    <option value="{{$author_id}}" {{$author_id == old('author_id',$book->author_id)?'selected':''}}>{{$author}}</option>
                    @endforeach
                </select>
                <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                  <path fill-rule="evenodd" d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                </svg>
              </div>
            </div>
            <x-input-error :messages="$errors->get('author_id')" />
        </div>
        <div class="space-y-2">
            <x-input-label for="category_id">Categoria</x-input-label>
            <div>
              <div class="grid grid-cols-1">
                <select id="category_id" name="category_id" class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                    @foreach($categories as $category_id=>$category)
                    <option value="{{$category_id}}" {{$category_id == old('category_id',$book->category_id)?'selected':''}}>{{$category}}</option>
                    @endforeach
                </select>
                <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                  <path fill-rule="evenodd" d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                </svg>
              </div>
            </div>
            <x-input-error :messages="$errors->get('category_id')" />
        </div>
        <div class="space-y-2">
            <x-input-label for="status">Status</x-input-label>
            <div>
              <div class="grid grid-cols-1">
                <select id="status" name="status" class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                    @foreach(\App\Enums\BookStatus::options() as $key=>$status)
                    <option value="{{$key}}" {{$key == old('status',$book->status?->name)?'selected':''}}>{{$status}}</option>
                    @endforeach
                </select>
                <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                  <path fill-rule="evenodd" d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                </svg>
              </div>
            </div>
            <x-input-error :messages="$errors->get('status')" />
        </div>
        <footer class="flex justify-end">
            <x-button type="submit">Salvar</x-button>
        </footer>
    </form>
</div>
</div>
</x-app-layout>
