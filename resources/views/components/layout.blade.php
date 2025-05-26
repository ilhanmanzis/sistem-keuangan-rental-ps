<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>
        {{ $title }}
    </title>
    <link rel="icon" href="{{ asset('storage/logo/' . $profile['logo']) }}">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">


    @vite('resources/css/style.css')

    <link rel="stylesheet" href="{{ asset('build/assets/style-tAOd6dsc.css') }}">
    <link rel="stylesheet" href="{{ url('/') }}/css/style.css">
    <style>
        /* Untuk Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Untuk Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.41.0"></script>

    {{-- <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> --}}

</head>

<body x-data="{ page: '{{ $page }}', 'loaded': true, 'darkMode': false, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }" x-init="darkMode = JSON.parse(localStorage.getItem('darkMode'));
$watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))" :class="{ 'dark bg-gray-900': darkMode === true }">
    <!-- ===== Preloader Start ===== -->
    <div x-show="loaded" x-init="window.addEventListener('DOMContentLoaded', () => { setTimeout(() => loaded = false, 500) })"
        class="fixed left-0 top-0 z-999999 flex h-screen w-screen items-center justify-center bg-white dark:bg-black">
        <div class="h-16 w-16 animate-spin rounded-full border-4 border-solid border-brand-500 border-t-transparent">
        </div>
    </div>

    <!-- ===== Preloader End ===== -->

    <!-- ===== Page Wrapper Start ===== -->
    <div class="flex h-screen overflow-hidden">
        <!-- ===== Sidebar Start ===== -->
        <aside :class="sidebarToggle ? 'translate-x-0 lg:w-[90px]' : '-translate-x-full'"
            class="sidebar fixed left-0 top-0 z-9999 flex h-screen w-[290px] flex-col overflow-y-hidden border-r border-gray-200 bg-white px-5 dark:border-gray-800 dark:bg-black lg:static lg:translate-x-0">
            <!-- SIDEBAR HEADER -->
            <x-header></x-header>
            <!-- SIDEBAR HEADER -->

            <div class="flex flex-col overflow-y-auto duration-300 ease-linear no-scrollbar">
                <!-- Sidebar Menu -->
                <x-sidebar>
                    <x-slot:page>{{ $page }}</x-slot:page>
                    <x-slot:selected>{{ $selected }}</x-slot:selected>
                </x-sidebar>
                <!-- Sidebar Menu -->


            </div>
        </aside>

        <!-- ===== Sidebar End ===== -->

        <!-- ===== Content Area Start ===== -->
        <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">
            <!-- Small Device Overlay Start -->
            <div @click="sidebarToggle = false" :class="sidebarToggle ? 'block lg:hidden' : 'hidden'"
                class="fixed w-full h-screen z-9 bg-gray-900/50"></div>
            <!-- Small Device Overlay End -->

            <!-- ===== Header Start ===== -->
            <x-navbar></x-navbar>
            <!-- ===== Header End ===== -->
            <!-- ===== Main Content Start ===== -->
            {{ $slot }}
            <!-- ===== Main Content End ===== -->

        </div>
        <!-- ===== Content Area End ===== -->
    </div>
    <!-- ===== Page Wrapper End ===== -->

    <script src="{{ url('/') }}/js/bundle.js"></script>
</body>

</html>
