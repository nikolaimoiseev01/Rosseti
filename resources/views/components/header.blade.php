<header class="fixed z-40 w-full bg-white top-0 border-b border-black-100">

        <div class="flex container items-center justify-between text-sm text-white/90">
            <x-logo class="w-[100px]"/>

            <nav class="flex gap-3 text-base md:hidden text-black-400 text-nowrap">
                @foreach($navLinks as $link)
                    <a class="text-sm" href="{{ route('article.index', $link['slug'])}}">{{ $link['title'] }}</a>
                @endforeach
                    <a download="Приложения.pdf" href="/fixed/additionals.pdf" class="text-sm" >Приложения</a>
            </nav>

            <div class="flex items-center gap-4">
                <div x-data="{ lang: 'ru' }" class="flex items-center gap-1 p-1 bg-black-100 rounded-lg min-h-10">
                    <button @click="lang = 'ru'" :class="lang === 'ru' ? 'bg-white text-blue-500' : 'text-blue-900/50'" class="px-2 py-1 rounded">RU</button>
                    <button @click="lang = 'en'" :class="lang === 'en' ? 'bg-white text-blue-500' : 'text-blue-900/50'" class="px-2 py-1 rounded">EN</button>
                </div>
                <a download="Отчет SR 2025.pdf" href="/fixed/rosseti_SR2025_ru_compressed.pdf" class="p-2 w-10 h-10 bg-black-100 rounded-lg flex items-center justify-center">
                    <svg width="14" height="17" viewBox="0 0 14 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.28125 7.78125C4.4375 7.78125 4.60156 7.84375 4.71094 7.96875L5.92188 9.25781L6.36719 9.73438L6.3125 8.55469V0.601562C6.3125 0.273438 6.60156 0 6.9375 0C7.27344 0 7.55469 0.273438 7.55469 0.601562V8.55469L7.5 9.72656L7.94531 9.25781L9.15625 7.96875C9.26562 7.84375 9.42188 7.78125 9.57812 7.78125C9.89844 7.78125 10.1484 8.01562 10.1484 8.32812C10.1484 8.5 10.0781 8.625 9.96094 8.74219L7.38281 11.2266C7.22656 11.3828 7.09375 11.4375 6.9375 11.4375C6.77344 11.4375 6.64062 11.3828 6.48438 11.2266L3.90625 8.74219C3.78906 8.625 3.71875 8.5 3.71875 8.32812C3.71875 8.01562 3.95312 7.78125 4.28125 7.78125ZM3.26562 16.7031C1.16406 16.7031 0 15.5391 0 13.4375V7.42188C0 5.32812 1.16406 4.15625 3.26562 4.15625H4.84375V5.41406H3.26562C1.98438 5.41406 1.25781 6.14062 1.25781 7.42188V13.4375C1.25781 14.7266 1.98438 15.4453 3.26562 15.4453H10.5938C11.8828 15.4453 12.6094 14.7266 12.6094 13.4375V7.42188C12.6094 6.14062 11.8828 5.41406 10.5938 5.41406H9.01562V4.15625H10.5938C12.6953 4.15625 13.8672 5.32812 13.8672 7.42188V13.4375C13.8672 15.5391 12.6953 16.7031 10.5938 16.7031H3.26562Z" fill="#0E3A5C"/>
                    </svg>
                </a>
            </div>
        </div>
</header>
