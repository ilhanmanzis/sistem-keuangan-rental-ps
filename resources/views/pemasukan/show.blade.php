<x-layout>
    <x-slot name="selected">{{ $selected }}</x-slot>
    <x-slot name="page">{{ $page }}</x-slot>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="p-8">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-3 mx-5">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Edit Transaksi</h2>
        </div>
        <div class="mx-5 rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="px-5 py-4 sm:px-6 sm:py-5 flex justify-between">
                <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Data Transaksi</h3>
                @if (session('error'))
                    <div
                        class="rounded-xl border border-error-500 bg-error-50 p-4 dark:border-error-500/30 dark:bg-error-500/15 mb-5">
                        <div class="flex items-start gap-3">
                            <div class="-mt-0.5 text-error-500">
                                <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M20.3499 12.0004C20.3499 16.612 16.6115 20.3504 11.9999 20.3504C7.38832 20.3504 3.6499 16.612 3.6499 12.0004C3.6499 7.38881 7.38833 3.65039 11.9999 3.65039C16.6115 3.65039 20.3499 7.38881 20.3499 12.0004ZM11.9999 22.1504C17.6056 22.1504 22.1499 17.6061 22.1499 12.0004C22.1499 6.3947 17.6056 1.85039 11.9999 1.85039C6.39421 1.85039 1.8499 6.3947 1.8499 12.0004C1.8499 17.6061 6.39421 22.1504 11.9999 22.1504ZM13.0008 16.4753C13.0008 15.923 12.5531 15.4753 12.0008 15.4753L11.9998 15.4753C11.4475 15.4753 10.9998 15.923 10.9998 16.4753C10.9998 17.0276 11.4475 17.4753 11.9998 17.4753L12.0008 17.4753C12.5531 17.4753 13.0008 17.0276 13.0008 16.4753ZM11.9998 6.62898C12.414 6.62898 12.7498 6.96476 12.7498 7.37898L12.7498 13.0555C12.7498 13.4697 12.414 13.8055 11.9998 13.8055C11.5856 13.8055 11.2498 13.4697 11.2498 13.0555L11.2498 7.37898C11.2498 6.96476 11.5856 6.62898 11.9998 6.62898Z"
                                        fill="#F04438" />
                                </svg>
                            </div>

                            <div>
                                <h4 class="mb-1 text-sm font-semibold text-gray-800 dark:text-white/90">
                                    {{ session('error') }}
                                </h4>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="space-y-6 border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">
                <form action="{{ route('pemasukan.update', ['id' => $transaksi['id_transaksi']]) }}" method="post"
                    id="transaksiForm">
                    @csrf
                    @method('put')
                    <div id="bonusInputs">

                    </div>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <!-- Input Kode Member -->
                        <div class="col-span-2 sm:col-span-1">
                            <label for="kode_member"
                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Kode
                                Member</label>
                            <div class="flex gap-2">
                                <input type="text" id="kode_member" name="kode_member"
                                    value="{{ $transaksi->member->kode_member ?? '' }}"
                                    class=" shadow-theme-xs  focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border  bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden  dark:bg-gray-900 focus:dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 {{ $errors->has('kode_member') ? 'border-error-300 focus:border-error-300 dark:border-error-700 dark:focus:border-error-800' : 'border-gray-300 focus:border-brand-300 dark:border-gray-700' }}
                                    placeholder="Masukkan
                                    kode member">
                                <button type="button" id="searchMember"
                                    class="px-3 py-2 text-sm text-white bg-success-600 rounded-lg hover:bg-blue-700">Cari</button>
                            </div>
                            @error('kode_member')
                                <p class="text-theme-xs text-error-500 my-1.5">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>


                        {{-- tampil klaim bonus --}}
                        <div id="bonusContainer" class="space-y-2">
                            <!-- Bonus akan ditambahkan di sini lewat JavaScript -->
                        </div>
                        <!-- Input Nama -->
                        <div class="col-span-2 sm:col-span-1">
                            <label for="nama"
                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Nama</label>
                            <input type="text" id="nama" name="name" value="{{ $transaksi['name'] }}"
                                class="dark:bg-dark-900 shadow-theme-xs  focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border  bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden  dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 {{ $errors->has('name') ? 'border-error-300 focus:border-error-300 dark:border-error-700 dark:focus:border-error-800' : 'border-gray-300 focus:border-brand-300 dark:border-gray-700' }}">
                            @error('name')
                                <p class="text-theme-xs text-error-500 my-1.5">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Input Nomor Telepon -->
                        <div class="col-span-2 sm:col-span-1">
                            <label for="nomor_telepon"
                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Nomor
                                Telepon</label>
                            <input type="text" id="nomor_telepon" name="nomor_telepon"
                                value="{{ $transaksi['no_telpon'] }}"
                                class="dark:bg-dark-900 shadow-theme-xs  focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border  bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden  dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 {{ $errors->has('nomor_telepon') ? 'border-error-300 focus:border-error-300 dark:border-error-700 dark:focus:border-error-800' : 'border-gray-300 focus:border-brand-300 dark:border-gray-700' }}">
                            @error('nomor_telepon')
                                <p class="text-theme-xs text-error-500 my-1.5">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>



                        <!-- Device -->

                        <!-- Pilih Device -->
                        <div>
                            <label for="device"
                                class="my-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Device</label>
                            <div x-data="{ isOptionSelected: false }" class="relative z-20 bg-transparent">
                                <select name="device" id="device"
                                    class="form-select shadow-theme-xs focus:ring-brand-500/10 h-11 w-full appearance-none rounded-lg border bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 {{ $errors->has('role') ? 'border-error-300 focus:border-error-300 dark:border-error-700 dark:focus:border-error-800' : 'border-gray-300 focus:border-brand-300 dark:border-gray-700' }}"
                                    :class="isOptionSelected && 'text-gray-800 dark:text-white/90'"
                                    onchange="updateHarga()" @change="isOptionSelected = true">
                                    <option value="" disabled selected>Pilih device</option>
                                    @foreach ($devices as $device)
                                        <option value="{{ $device->id_device }}"
                                            data-harga="{{ $device->harga_perjam }}"
                                            {{ $device['id_device'] === $transaksi['id_device'] ? 'selected' : '' }}>
                                            {{ $device->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span
                                    class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                                    <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke=""
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                @error('device')
                                    <p class="text-theme-xs text-error-500 my-1.5">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Durasi Jam -->
                        <div>
                            <label for="durasi_jam"
                                class="my-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Durasi
                                (Jam)</label>
                            <input type="number" name="durasi_jam" id="durasi_jam" min="1"
                                value="{{ $transaksi['durasi_jam'] }}"
                                class="form-input shadow-theme-xs focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 {{ $errors->has('durasi_jam') ? 'border-error-300 focus:border-error-300 dark:border-error-700 dark:focus:border-error-800' : 'border-gray-300 focus:border-brand-300 dark:border-gray-700' }}"
                                oninput="updateHarga()" />
                        </div>

                        <!-- Klaim Bonus -->
                        <div class="col-span-2 sm:col-span-1">
                            <label class="my-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Bonus
                                Jam</label>
                            <div class="flex items-center gap-2">
                                <input type="text" id="bonus_jam" name="bonus_jam" disabled readonly
                                    value="{{ $transaksi['bonus_jam'] }}"
                                    class="form-input bg-[#e6e7e8] shadow-theme-xs focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 border-gray-300 dark:border-gray-700"
                                    oninput="updateHarga()">


                            </div>


                        </div>

                        <!-- Harga Total -->
                        <div>
                            <label for="harga_total"
                                class="my-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Harga
                                Device</label>
                            <input type="text" name="harga_total" id="harga_total" readonly
                                class="form-input bg-[#e6e7e8] shadow-theme-xs focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 border-gray-300 dark:border-gray-700" />
                        </div>


                        <!-- Script -->
                        <script>
                            function updateHarga() {
                                const deviceSelect = document.getElementById('device');
                                const durasiInput = document.getElementById('durasi_jam');
                                const hargaTotal = document.getElementById('harga_total');
                                const bonusJam = document.getElementById('bonus_jam');

                                const selectedOption = deviceSelect.options[deviceSelect.selectedIndex];
                                const hargaPerJam = selectedOption ? parseFloat(selectedOption.getAttribute('data-harga')) || 0 : 0;
                                const durasi = parseFloat(durasiInput.value) || 0;
                                const bonus = parseFloat(bonusJam.value) || 0;

                                const total = hargaPerJam * (durasi - bonus);
                                hargaTotal.value = total > 0 ? total : '0';
                                updateSubtotal();
                            }
                        </script>

                    </div>
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">


                        <!-- Makanan -->
                        <div class="mt-6">
                            <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-400">Makanan</h4>
                            <table class="w-full mt-2" id="makananTable">
                                <thead>
                                    <tr>
                                        <th class="dark:text-gray-400">Nama</th>
                                        <th class="dark:text-gray-400">Jumlah</th>
                                        <th class="dark:text-gray-400">Harga</th>
                                        <th class="dark:text-gray-400">Total</th>
                                        <th class="dark:text-gray-400"></th>
                                    </tr>
                                </thead>
                                <tbody id="makananTableBody">

                                    <!-- Baris makanan akan ditambahkan di sini -->
                                </tbody>

                            </table>
                            <button type="button" id="addMakanan"
                                class="px-3 py-2 text-sm mt-2 text-white bg-success-600 rounded hover:bg-blue-700">+</button>

                        </div>

                        <!-- Minuman -->
                        <div class="mt-6">
                            <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-400">Minuman</h4>
                            <table class="w-full mt-2" id="minumanTable">
                                <thead class="w-full">
                                    <tr>
                                        <th class="dark:text-gray-400">Nama</th>
                                        <th class="dark:text-gray-400">Jumlah</th>
                                        <th class="dark:text-gray-400">Harga</th>
                                        <th class="dark:text-gray-400">Total</th>
                                        <th class="dark:text-gray-400"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Baris minuman akan ditambahkan di sini -->
                                </tbody>
                            </table>
                            <button type="button" id="addMinuman"
                                class="px-3 py-2 text-sm mt-2 text-white bg-success-600 rounded hover:bg-blue-700">+</button>

                        </div>

                        <div class="mt-2">
                            <label for="total_makanan"
                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Total
                                Makanan</label>
                            <input type="number" name="total_makanan" id="total_makanan"
                                value="{{ $transaksi['total_minuman'] }}"
                                class="form-input my-1 bg-[#e6e7e8] shadow-theme-xs focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 border-gray-300 dark:border-gray-700"
                                readonly />
                        </div>
                        <div class="mt-2">
                            <label for="total_minuman"
                                class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Total
                                Minuman</label>
                            <input type="number" name="total_minuman" id="total_minuman"
                                value="{{ $transaksi['total_minuman'] }}"
                                class="form-input my-1 bg-[#e6e7e8] shadow-theme-xs focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 border-gray-300 dark:border-gray-700"
                                readonly />
                        </div>


                    </div>
                    <div class="mt-4">
                        <label for="total_semua"
                            class="my-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Total
                            Keseluruhan</label>
                        <input type="number" name="total_semua" id="total_semua" readonly
                            class="form-input bg-[#e6e7e8] shadow-theme-xs focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 border-gray-300 dark:border-gray-700" />
                    </div>

                    <button type="submit"
                        class="mt-5 inline-flex items-center gap-2 px-4 py-3 text-lg font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600 mb-5">Simpan</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Template Baris Makanan -->
    <template id="makananRowTemplate">
        <tr>
            <td class="text-center">
                <select name="makanan_id[]"
                    class="my-1 form-select  dark:text-gray-400 dark:bg-dark-900 shadow-theme-xs  focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 rounded-lg border w-36 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden  dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                    @foreach ($makanans as $makanan)
                        <option value="{{ $makanan->id_makanan }}" data-harga="{{ $makanan->harga }}">
                            {{ $makanan->name }}
                        </option>
                    @endforeach
                </select>
            </td>
            <td class="text-center"><input type="number" name="makanan_jumlah[]"
                    class="my-1 form-input  jumlah  w-20 dark:bg-dark-900 shadow-theme-xs  focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 rounded-lg border  bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden  dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 text-center mx-1"
                    value="" /></td>
            <td class="text-center"><input type="number" name="makanan_harga[]"
                    class="my-1 text-center form-input  harga w-24 bg-[#e6e7e8] shadow-theme-xs  focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 rounded-lg border  bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden  dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                    readonly />
            </td>
            <td class="text-center"><input type="number" name="makanan_total[]"
                    class="my-1  form-input  total  w-24 bg-[#e6e7e8] shadow-theme-xs  focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 rounded-lg border  bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden  dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 text-center mx-1"
                    readonly />
            </td>
            <td><button type="button" class="my-1 remove-row px-2 py-1 bg-error-500 text-white rounded"><svg
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                    </svg></button>
            </td>
        </tr>
    </template>


    <!-- Template Baris Minuman -->
    <template id="minumanRowTemplate">
        <tr>
            <td>
                <select name="minuman_id[]"
                    class="my-1 form-select dark:text-gray-400 dark:bg-dark-900 shadow-theme-xs  focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 rounded-lg border w-36 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden  dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                    @foreach ($minumans as $minuman)
                        <option value="{{ $minuman->id_minuman }}" data-harga="{{ $minuman->harga }}">
                            {{ $minuman->name }}
                        </option>
                    @endforeach
                </select>
            </td>
            <td><input type="number" name="minuman_jumlah[]"
                    class="my-1 form-input jumlah w-20 dark:bg-dark-900 shadow-theme-xs  focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 rounded-lg border  bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden  dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 text-center mx-1"
                    value="" />
            </td>
            <td><input type="number" name="minuman_harga[]"
                    class="my-1 form-input harga w-24 bg-[#e6e7e8] shadow-theme-xs  focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 rounded-lg border  bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden  dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 text-center"
                    readonly /></td>
            <td><input type="number" name="minuman_total[]"
                    class="my-1 form-input total w-24 bg-[#e6e7e8] shadow-theme-xs  focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 rounded-lg border  bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden  dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 mx-1 text-center"
                    readonly /></td>
            <td><button type="button" class="my-1 remove-row px-2 py-1 bg-red-500 text-white rounded"><svg
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                    </svg></button></td>
        </tr>
    </template>
    <script>
        let klaimBonusIds = [];
        let totalBonus = 0;

        function updateSubtotal() {
            const totalMakanan = parseInt(document.getElementById('total_makanan').value) || 0;
            const totalMinuman = parseInt(document.getElementById('total_minuman').value) || 0;
            const hargaDevice = parseInt(document.getElementById('harga_total').value) || 0;

            const totalSemua = totalMakanan + totalMinuman + hargaDevice;
            document.getElementById('total_semua').value = totalSemua;
        }

        // Jalankan saat semua input terkait berubah
        ['total_makanan', 'total_minuman', 'harga_total'].forEach(id => {
            document.getElementById(id).addEventListener('input', updateSubtotal);
        });

        // Inisialisasi saat load
        document.addEventListener('DOMContentLoaded', updateSubtotal);

        //

        document.addEventListener('DOMContentLoaded', function() {
            updateHarga();
            const makananTableBody = document.querySelector('#makananTable tbody');
            const minumanTableBody = document.querySelector('#minumanTable tbody');

            const dataTransaksiMakanans = @json($transaksiMakanans);
            const dataTransaksiMinumans = @json($transaksiMinumans);
            const dataBonusMember = @json($memberRewards);
            const bonusContainer = document.getElementById('bonusContainer');
            bonusContainer.innerHTML = '';
            totalBonus = 0; // reset total bonus saat cari baru
            updateBonusInput();
            if (dataBonusMember) {
                dataBonusMember.forEach(data => {
                    const bonusDiv = document.createElement('div');
                    const isClaimed = data.tanggal_klaim !== null;
                    bonusDiv.className = 'flex items-center justify-between p-2 border rounded';

                    // Buat tombol dan sesuaikan status awal
                    const klaimText = isClaimed ? 'Batal' : 'Klaim';
                    const klaimClass = isClaimed ? 'bg-red-600 hover:bg-red-700' :
                        'bg-green-600 hover:bg-green-700';

                    bonusDiv.innerHTML = `
                    <div>
                        <p class="dark:text-white"><strong>Bonus:</strong> ${data.durasi} jam</p>
                    </div>
                    <button 
                        type="button" 
                        class="klaim-toggle px-3 py-2 text-sm text-white rounded ${klaimClass}"
                        data-durasi="${data.durasi}"
                        data-id="${data.id_member_reward}">
                        ${klaimText}
                    </button>
                            `;

                    bonusContainer.appendChild(bonusDiv);

                    const button = bonusDiv.querySelector('.klaim-toggle');

                    // Jika sudah diklaim, set nilai awal
                    if (isClaimed) {
                        totalBonus += parseInt(data.durasi);
                        klaimBonusIds.push(data.id_member_reward.toString());
                        updateBonusInput();
                        updateHarga()
                    }

                    // Event handler untuk klaim/batal
                    button.addEventListener('click', function() {
                        const durasi = parseInt(this.dataset.durasi);
                        const id = this.dataset.id;
                        const isKlaim = this.classList.contains('bg-green-600');

                        if (isKlaim) {
                            // Klaim
                            totalBonus += durasi;
                            klaimBonusIds.push(id);
                            this.textContent = 'Batal';
                            this.classList.remove('bg-green-600', 'hover:bg-green-700');
                            this.classList.add('bg-red-600', 'hover:bg-red-700');
                        } else {
                            // Batal
                            totalBonus -= durasi;
                            klaimBonusIds = klaimBonusIds.filter(i => i !== id);
                            this.textContent = 'Klaim';
                            this.classList.remove('bg-red-600', 'hover:bg-red-700');
                            this.classList.add('bg-green-600', 'hover:bg-green-700');
                        }

                        updateBonusInput();
                        updateHarga();
                        updateSubtotal();
                    });
                });

            }


            dataTransaksiMakanans.forEach(data => {
                const template = document.getElementById('makananRowTemplate').content.cloneNode(true);
                const row = template.querySelector('tr');
                const select = row.querySelector('select');
                const jumlahInput = row.querySelector('.jumlah');
                const hargaInput = row.querySelector('.harga');
                const totalInput = row.querySelector('.total');
                // Set jumlah
                jumlahInput.value = data.jumlah;

                // Pilih makanan sesuai id
                Array.from(select.options).forEach(option => {
                    if (option.value == data.id_makanan) {
                        option.selected = true;
                        hargaInput.value = option.dataset.harga;
                        totalInput.value = data.jumlah * option.dataset.harga;
                    }
                });
                // Attach event setelah render semua
                document.querySelector('#makananTable tbody').appendChild(template);
                attachEventsToRows(document.querySelector('#makananTable tbody'), '#total_makanan');
            })

            dataTransaksiMinumans.forEach(data => {
                const template = document.getElementById('minumanRowTemplate').content.cloneNode(true);
                const row = template.querySelector('tr');
                const select = row.querySelector('select');
                const jumlahInput = row.querySelector('.jumlah');
                const hargaInput = row.querySelector('.harga');
                const totalInput = row.querySelector('.total');
                // Set jumlah
                jumlahInput.value = data.jumlah;

                // Pilih minuman sesuai id
                Array.from(select.options).forEach(option => {
                    if (option.value == data.id_minuman) {
                        option.selected = true;
                        hargaInput.value = option.dataset.harga;
                        totalInput.value = data.jumlah * option.dataset.harga;
                    }
                });
                // Attach event setelah render semua
                document.querySelector('#minumanTable tbody').appendChild(template);
                attachEventsToRows(document.querySelector('#minumanTable tbody'), '#total_minuman');
            })



            document.getElementById('addMakanan').addEventListener('click', function() {
                const template = document.getElementById('makananRowTemplate').content.cloneNode(true);
                makananTableBody.appendChild(template);
                attachEventsToRows(makananTableBody, '#total_makanan');
            });

            document.getElementById('addMinuman').addEventListener('click', function() {
                const template = document.getElementById('minumanRowTemplate').content.cloneNode(true);
                minumanTableBody.appendChild(template);
                attachEventsToRows(minumanTableBody, '#total_minuman');
            });

            function attachEventsToRows(tableBody, totalFieldId) {
                const rows = tableBody.querySelectorAll('tr');
                rows.forEach(row => {
                    const select = row.querySelector('select');
                    const jumlah = row.querySelector('.jumlah');
                    const harga = row.querySelector('.harga');
                    const total = row.querySelector('.total');
                    const removeBtn = row.querySelector('.remove-row');

                    // Set harga awal jika sudah dipilih
                    if (select && select.selectedIndex >= 0) {
                        const selectedOption = select.options[select.selectedIndex];
                        harga.value = selectedOption.dataset.harga || 0;
                        total.value = (jumlah.value || 0) * harga.value;
                    }

                    select?.addEventListener('change', () => {
                        const selectedOption = select.options[select.selectedIndex];
                        harga.value = selectedOption.dataset.harga || 0;
                        total.value = (jumlah.value || 0) * harga.value;
                        updateTotalKeseluruhan(tableBody, totalFieldId);
                    });

                    jumlah?.addEventListener('input', () => {
                        total.value = (jumlah.value || 0) * (harga.value || 0);
                        updateTotalKeseluruhan(tableBody, totalFieldId);
                    });

                    removeBtn?.addEventListener('click', () => {
                        row.remove();
                        updateTotalKeseluruhan(tableBody, totalFieldId);
                    });
                });

                updateTotalKeseluruhan(tableBody, totalFieldId);
            }

            // Tombol cari member


            document.getElementById('searchMember').addEventListener('click', function() {
                const kode = document.getElementById('kode_member').value;
                fetch(`/member/search/${kode}`)
                    .then(response => {
                        if (!response.ok) throw new Error('Member tidak ditemukan');
                        return response.json();
                    })
                    .then(data => {
                        document.getElementById('nama').value = data.name;
                        document.getElementById('nomor_telepon').value = data.nomor_telepon;

                        const bonusContainer = document.getElementById('bonusContainer');
                        bonusContainer.innerHTML = '';
                        totalBonus = 0; // reset total bonus saat cari baru
                        updateBonusInput();

                        if (data.bonus && data.bonus.length > 0) {
                            data.bonus.forEach((bonus) => {
                                const bonusDiv = document.createElement('div');
                                bonusDiv.className =
                                    'flex items-center justify-between p-2 border rounded';

                                bonusDiv.innerHTML = `
                        <div>
                            <p class="dark:text-white"><strong >Bonus:</strong> ${bonus.durasi} jam</p>
                            
                        </div>
                        <button 
                            type="button" 
                            class="klaim-toggle px-3 py-2 text-sm text-white bg-green-600 rounded hover:bg-green-700"
                            data-durasi="${bonus.durasi}"
                            data-id="${bonus.id_member_reward}">
                            Klaim
                        </button>
                    `;

                                bonusContainer.appendChild(bonusDiv);
                            });

                            // Tambahkan event listener ke tombol Klaim/Batal
                            document.querySelectorAll('.klaim-toggle').forEach(button => {
                                button.addEventListener('click', function() {
                                    const durasi = parseInt(this.dataset.durasi);
                                    const isKlaim = this.classList.contains(
                                        'bg-green-600');

                                    if (isKlaim) {
                                        // Klaim: tambah durasi bonus
                                        totalBonus += durasi;
                                        klaimBonusIds.push(this.dataset
                                            .id);
                                        this.textContent = 'Batal';
                                        this.classList.remove('bg-green-600',
                                            'hover:bg-green-700');
                                        this.classList.add('bg-red-600',
                                            'hover:bg-red-700');
                                        const bonusInputs = document.getElementById(
                                            'bonusInputs');

                                    } else {
                                        // Batal: kurangi durasi bonus
                                        totalBonus -= durasi;
                                        klaimBonusIds = klaimBonusIds.filter(id =>
                                            id !== this.dataset.id); // hapus dari array
                                        this.textContent = 'Klaim';
                                        this.classList.remove('bg-red-600',
                                            'hover:bg-red-700');
                                        this.classList.add('bg-green-600',
                                            'hover:bg-green-700');
                                    }
                                    console.log(klaimBonusIds)
                                    // Update hidden input sesuai array klaimBonusIds terbaru
                                    updateBonusInput();
                                    updateHarga();
                                    updateSubtotal()
                                });
                            });
                        } else {
                            bonusContainer.innerHTML =
                                '<p class = "text-gray-500 text-center mt-10" > Tidak ada bonus tersedia. </p>';
                        }
                    })
                    .catch(error => {
                        alert(error.message);
                    });
            });

            function updateBonusInput() {
                document.getElementById('bonus_jam').value = totalBonus;
                const bonusInputs = document.getElementById('bonusInputs');
                bonusInputs.innerHTML = ''; // reset dulu

                klaimBonusIds.forEach(id => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'id_member_rewards[]';
                    input.value = id;
                    bonusInputs.appendChild(input);
                });
            }



            function updateTotalKeseluruhan(tableBody, totalFieldId) {
                let total = 0;
                tableBody.querySelectorAll('.total').forEach(input => {
                    total += parseInt(input.value || 0);
                });
                document.querySelector(totalFieldId).value = total;
                updateSubtotal()
            }
        });
    </script>

</x-layout>
