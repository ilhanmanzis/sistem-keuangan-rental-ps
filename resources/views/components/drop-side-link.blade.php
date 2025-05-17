@props(['page'])

<li>
    <a {{ $attributes }} class="menu-dropdown-item group"
        :class="page === '{{ $page }}' ? 'menu-dropdown-item-active' :
            'menu-dropdown-item-inactive'">
        {{ $slot }}
    </a>
</li>
