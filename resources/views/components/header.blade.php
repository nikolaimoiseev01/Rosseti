<header class="fixed z-20 w-full bg-white top-0">

        <div class="flex container items-center justify-between text-sm text-white/90">
            <x-logo class="w-[100px]"/>

            <nav class="flex gap-3 text-base md:hidden text-black-400 text-nowrap">
                @foreach($navLinks as $link)
                    <a href="{{ $link['href'] }}">{{ $link['title'] }}</a>
                @endforeach
            </nav>

            <div class="flex items-center gap-6">
                <div x-data="{ lang: 'ru' }" class="flex items-center gap-1 p-1 bg-white/20 rounded-xl">
                    <button @click="lang = 'ru'" :class="lang === 'ru' ? 'bg-white text-blue-500' : 'text-white/40'" class="px-2 py-1 rounded-lg font-bold">RU</button>
                    <button @click="lang = 'en'" :class="lang === 'en' ? 'bg-white text-blue-500' : 'text-white/40'" class="px-2 py-1 rounded-lg font-bold">EN</button>
                </div>
                <a href="#" class="p-2 bg-white/20 rounded-xl">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 16V8" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M9 11L12 8L15 11" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M20 13V18C20 18.5304 19.7893 19.0391 19.4142 19.4142C19.0391 19.7893 18.5304 20 18 20H6C5.46957 20 4.96086 19.7893 4.58579 19.4142C4.21071 19.0391 4 18.5304 4 18V13" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </div>
        </div>
</header>
