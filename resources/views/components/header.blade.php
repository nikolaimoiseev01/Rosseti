<header class="fixed z-40 w-full bg-white top-0 border-b border-black-100" x-data="{ mobileMenuOpen: false }">

        <div class="flex container items-center justify-between text-sm text-white/90">
            <x-logo class="w-[100px]"/>

            <!-- Desktop Navigation (hidden on mobile) -->
            <nav class="flex md:hidden gap-3 text-base text-black-400 text-nowrap">
                @php
                    $currentLang = session('locale', 'ru');
                @endphp
                @foreach($navLinks as $link)
                    @php
                        $linkTitle = !empty($link->title_languages) && isset($link->title_languages[$currentLang])
                            ? $link->title_languages[$currentLang]
                            : $link->title;
                    @endphp
                    <a wire:navigate class="text-sm {{ request()->route('slug') === $link['slug'] ? 'text-blue-500 font-medium' : '' }}" href="{{ route('article.index', $link['slug'])}}">{{ $linkTitle }}</a>
                @endforeach
{{--                    <a download="Приложения.pdf" href="/fixed/additionals.pdf" class="text-sm" >{{ $currentLang === 'ru' ? 'Приложения' : 'Appendices' }}</a>--}}
            </nav>

            <div class="flex items-center gap-4">
                <div class="flex items-center gap-1 p-1 bg-black-100 rounded-lg min-h-10">
                    <a href="{{ route('language.switch', 'ru') }}" class="{{ session('locale', 'ru') === 'ru' ? 'bg-white leading-3 text-blue-500' : 'text-blue-900/50' }} p-2 rounded">RU</a>
                    <a href="{{ route('language.switch', 'en') }}" class="{{ session('locale', 'ru') === 'en' ? 'bg-white !leading-[11px] text-blue-500' : 'text-blue-900/50' }} p-2 rounded">EN</a>
                </div>
                <a download="Отчет SR 2025.pdf" href="/fixed/rosseti_SR2025_ru_compressed.pdf" class="p-2 w-10 h-10 bg-black-100 rounded-lg flex items-center justify-center">
                    <svg width="14" height="17" viewBox="0 0 14 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.28125 7.78125C4.4375 7.78125 4.60156 7.84375 4.71094 7.96875L5.92188 9.25781L6.36719 9.73438L6.3125 8.55469V0.601562C6.3125 0.273438 6.60156 0 6.9375 0C7.27344 0 7.55469 0.273438 7.55469 0.601562V8.55469L7.5 9.72656L7.94531 9.25781L9.15625 7.96875C9.26562 7.84375 9.42188 7.78125 9.57812 7.78125C9.89844 7.78125 10.1484 8.01562 10.1484 8.32812C10.1484 8.5 10.0781 8.625 9.96094 8.74219L7.38281 11.2266C7.22656 11.3828 7.09375 11.4375 6.9375 11.4375C6.77344 11.4375 6.64062 11.3828 6.48438 11.2266L3.90625 8.74219C3.78906 8.625 3.71875 8.5 3.71875 8.32812C3.71875 8.01562 3.95312 7.78125 4.28125 7.78125ZM3.26562 16.7031C1.16406 16.7031 0 15.5391 0 13.4375V7.42188C0 5.32812 1.16406 4.15625 3.26562 4.15625H4.84375V5.41406H3.26562C1.98438 5.41406 1.25781 6.14062 1.25781 7.42188V13.4375C1.25781 14.7266 1.98438 15.4453 3.26562 15.4453H10.5938C11.8828 15.4453 12.6094 14.7266 12.6094 13.4375V7.42188C12.6094 6.14062 11.8828 5.41406 10.5938 5.41406H9.01562V4.15625H10.5938C12.6953 4.15625 13.8672 5.32812 13.8672 7.42188V13.4375C13.8672 15.5391 12.6953 16.7031 10.5938 16.7031H3.26562Z" fill="#0E3A5C"/>
                    </svg>
                </a>

                <!-- Mobile Menu Button (visible on mobile) -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="hidden md:!flex p-2 w-10 h-10 bg-black-100 rounded-lg items-center justify-center">
                    <svg x-show="!mobileMenuOpen" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.5 5H17.5" stroke="#0E3A5C" stroke-width="2" stroke-linecap="round"/>
                        <path d="M2.5 10H17.5" stroke="#0E3A5C" stroke-width="2" stroke-linecap="round"/>
                        <path d="M2.5 15H17.5" stroke="#0E3A5C" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <svg x-show="mobileMenuOpen" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="display: none;">
                        <path d="M15 5L5 15" stroke="#0E3A5C" stroke-width="2" stroke-linecap="round"/>
                        <path d="M5 5L15 15" stroke="#0E3A5C" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu Overlay -->
        <div x-show="mobileMenuOpen"
             x-transition:enter="transition-opacity ease-in-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-in-out duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="mobileMenuOpen = false"
             class="md:flex hidden fixed inset-0 bg-black/50 z-50"
             style="display: none;"></div>

        <!-- Mobile Menu (slide-in from right) -->
        <div x-show="mobileMenuOpen"
             x-transition:enter="transition-transform ease-in-out duration-300"
             x-transition:enter-start="translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition-transform ease-in-out duration-300"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="translate-x-full"
             class="md:flex hidden fixed inset-y-0 right-0 w-full max-w-md bg-white z-50 shadow-2xl"
             style="display: none;">
            <div class="flex flex-col h-full p-6">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-2xl font-bold text-black-500">{{ $currentLang === 'ru' ? 'Меню' : 'Menu' }}</h2>
                    <button @click="mobileMenuOpen = false" class="p-2 bg-black-100 rounded-lg">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15 5L5 15" stroke="#0E3A5C" stroke-width="2" stroke-linecap="round"/>
                            <path d="M5 5L15 15" stroke="#0E3A5C" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </button>
                </div>
                <nav class="flex flex-col gap-6 text-lg text-black-400">
                    @foreach($navLinks as $link)
                        @php
                            $linkTitle = !empty($link->title_languages) && isset($link->title_languages[$currentLang])
                                ? $link->title_languages[$currentLang]
                                : $link->title;
                        @endphp
                        <a wire:navigate @click="mobileMenuOpen = false" class="text-xl {{ request()->route('slug') === $link['slug'] ? 'text-blue-500 font-bold' : 'hover:text-blue-500' }}" href="{{ route('article.index', $link['slug'])}}">{{ $linkTitle }}</a>
                    @endforeach
{{--                    <a @click="mobileMenuOpen = false" download="Приложения.pdf" href="/fixed/additionals.pdf" class="text-xl hover:text-blue-500">{{ $currentLang === 'ru' ? 'Приложения' : 'Appendices' }}</a>--}}
                </nav>
            </div>
        </div>
</header>
