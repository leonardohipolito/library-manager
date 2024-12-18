<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <form action="{{$loan->exists?route('loan.update',$loan):route('loan.store')}}" class="space-y-4" method="post">
        @csrf
        @if($loan->exists)
            @method('PUT')
        @endif

        <div class="space-y-2">
            <x-input-label for="borrower_id">Usuário</x-input-label>
            <div>
              <div class="grid grid-cols-1">
                <select id="borrower_id" name="borrower_id" class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                    @foreach($users as $borrower_id=>$name)
                    <option value="{{$borrower_id}}" {{$borrower_id == old('borrower_id',$loan->borrower_id)?'selected':''}}>{{$name}}</option>
                    @endforeach
                </select>
                <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                  <path fill-rule="evenodd" d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                </svg>
              </div>
            </div>
            <x-input-error :messages="$errors->get('borrower_id')" />
        </div>
        <div class="space-y-2">
            <x-input-label for="expires_at">Data para devolução</x-input-label>
            <x-text-input name="expires_at" type="date" value="{{old('expires_at',$loan->expires_at?->format('Y-m-d'))}}" class="w-full"/>
            <x-input-error :messages="$errors->get('expires_at')" />
        </div>
        <div class="space-y-2">
            <x-input-label for="book_id">Livro</x-input-label>
            <div>
              <div class="grid grid-cols-1">
                <select id="book_id" name="book_id" class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                    @foreach($books as $book_id=>$name)
                    <option value="{{$book_id}}" {{$book_id == old('book_id',$loan->book_id)?'selected':''}}>{{$name}}</option>
                    @endforeach
                </select>
                <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                  <path fill-rule="evenodd" d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                </svg>
              </div>
            </div>
            <x-input-error :messages="$errors->get('book_id')" />
        </div>
        @if($loan->exists)
        <div class="space-y-2">
            <x-input-label for="status">Status</x-input-label>
            <div>
              <div class="grid grid-cols-1">
                <select id="status" name="status" class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                    @foreach(\App\Enums\LoanStatus::options() as $key=>$status)
                    <option value="{{$key}}" {{$key == old('status',$loan->status?->name)?'selected':''}}>{{$status}}</option>
                    @endforeach
                </select>
                <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                  <path fill-rule="evenodd" d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                </svg>
              </div>
            </div>
            <x-input-error :messages="$errors->get('status')" />
        </div>
        @endif
        <footer class="flex justify-end">
            <x-button type="submit">Salvar</x-button>
        </footer>
    </form>
</div>
</div>
</x-app-layout>
