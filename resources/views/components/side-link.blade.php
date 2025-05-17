@props(['label', 'selected', 'icon', 'href'])

<li>

    <a href="{{ $href }}"
        @click="selected = (selected === @js($selected) ? @js($selected) : @js($selected))"
        class="menu-item group"
        :class="(selected === @js($selected) && page === @js($label)) ? 'menu-item-active' :
        'menu-item-inactive'">


        <svg :class="(selected === @js($selected)) && (page === @js($label)) ?
        'menu-item-icon-active' :
        'menu-item-icon-inactive'"
            width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            {!! $icon !!}
        </svg>

        <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
            {{ $label }}
        </span>
    </a>

</li>
