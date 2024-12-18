<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-base font-semibold text-gray-900">Emprestimos</h1>
                    </div>
                    <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                        @can('create',\App\Models\Loan::class)
                        <a href="{{route('loan.create')}}"
                                class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            Cadastar Emprestimo
                        </a>
                        @endcan
                    </div>
                </div>
                <div class="mt-8 flow-root">
                    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead>
                                <tr>
                                    <th scope="col"
                                        class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                                        Livro
                                    </th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                        Usuário
                                    </th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                        Emprestado por
                                    </th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                        Data para devolução
                                    </th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                        Status
                                    </th>
                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                        <span class="sr-only">Edit</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                @foreach($loans as $loan)
                                    <tr>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">{{$loan->book->name}}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$loan->borrower->name}}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$loan->attendant->name}}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$loan->expires_at->format('d/m/Y')}}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$loan->status}}</td>
                                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                            @can('update',$loan)
                                            <a href="{{route('loan.edit',$loan)}}" class="text-indigo-600 hover:text-indigo-900">Editar<span
                                                    class="sr-only">, {{$loan->name}}</span></a>
                                            @endcan
                                            @can('delete',$loan)
                                            <button x-on:click="$deleteModal(@js(route('loan.destroy',$loan)))">
                                                Deletar
                                            </button>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {{$loans->links()}}
        </div>
    </div>
</x-app-layout>