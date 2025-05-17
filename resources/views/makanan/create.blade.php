<x-layout>
    <x-slot name="selected">{{ $selected }}</x-slot>
    <x-slot name="page">{{ $page }}</x-slot>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="p-8">

        <!-- Breadcrumb Start -->
        <div x-data="{ pageName: `Tambah Makanan` }">
            <div class="mb-6 flex flex-wrap items-center justify-between gap-3 mx-5">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90" x-text="pageName"></h2>
            </div>

        </div>
        <!-- Breadcrumb End -->
        <div class=" mx-5 rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">


            <div class="px-5 py-4 sm:px-6 sm:py-5 flex justify-between">
                <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                    Data Makanan
                </h3>
            </div>
            <div class="space-y-6 border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">
                <form action="{{ route('makanan.store') }}" method="post">
                    @csrf
                    <!-- Elements -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Nama
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="dark:bg-dark-900 shadow-theme-xs  focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border  bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden  dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 {{ $errors->has('name') ? 'border-error-300 focus:border-error-300 dark:border-error-700 dark:focus:border-error-800' : 'border-gray-300 focus:border-brand-300 dark:border-gray-700' }}"
                            required />
                    </div>
                    @error('name')
                        <p class="text-theme-xs text-error-500 my-1.5">
                            {{ $message }}
                        </p>
                    @enderror
                    <div>
                        <label class=" my-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Harga
                        </label>
                        <input type="number" name="harga" value="{{ old('harga') }}" required
                            class="dark:bg-dark-900 shadow-theme-xs  focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border  bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden  dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 {{ $errors->has('harga') ? 'border-error-300 focus:border-error-300 dark:border-error-700 dark:focus:border-error-800' : 'border-gray-300 focus:border-brand-300 dark:border-gray-700' }}" />
                    </div>
                    @error('harga')
                        <p class="text-theme-xs text-error-500 mt-1.5">
                            {{ $message }}
                        </p>
                    @enderror
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-3 text-sm font-medium mt-5 text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600 mb-5">
                        Simpan
                    </button>

                </form>

            </div>
        </div>



    </div>
</x-layout>
