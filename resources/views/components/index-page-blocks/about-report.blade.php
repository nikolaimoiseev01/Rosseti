<section class="page-block page-block--about-report mb-12 rounded-2xl overflow-hidden p-12 lg:p-4 flex flex-col gap-28 lg:gap-12 container relative bg-cover bg-center bg-no-repeat" style="background-image: url('/fixed/bg-nature.jpg')">
    <div class="absolute inset-0 w-full h-full bg-black-900/10"></div>
    <div class="z-10 flex lg:flex-col justify-between w-full">
        <div class="flex flex-col lg:mb-8" x-data="revealOnScroll()">
            <h2 class="text-white">ОБ ОТЧЕТЕ</h2>
            <p class="text-white text-[24px] max-w-[436px]">Наша цель: Максимально полно представлять информацию о деятельности Компании для широкого круга заинтересованных сторон.</p>
        </div>
        <div x-data="revealOnScroll()" class="ml-auto flex flex-col rounded-[10px]
            bg-gradient-to-br from-white/25 to-white/[0.03]
            backdrop-blur-2xl
            border border-white/15
            p-5 text-white">
            <p class="text-white mb-5 text-2xl font-normal">Принципы подготовки нефинансовой отчетности ПАО «Россети»</p>
            @php
                $items = ['Существенность', 'Сравнимость', 'Прозрачность', 'Учет мнений заинтересованных сторон', 'Актуальность', 'Достоверность']
            @endphp
            <div class="grid grid-cols-[max-content_max-content_max-content] lg:flex lg:flex-wrap gap-x-12 gap-y-6">
                @foreach($items as $item)
                    <div class="flex flex-col gap-2">
                        <svg width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="11.5" cy="11.5" r="11.5" fill="white" fill-opacity="0.2"/>
                            <path d="M11.5 3C6.81291 3 3 6.81291 3 11.5C3 16.1871 6.81291 20 11.5 20C16.1871 20 20 16.1871 20 11.5C20 6.81291 16.1871 3 11.5 3Z" fill="white"/>
                            <path d="M15.808 9.70151L11.2037 14.3056C11.0656 14.4437 10.8843 14.5132 10.703 14.5132C10.5217 14.5132 10.3403 14.4437 10.2022 14.3056L7.90016 12.0035C7.62312 11.7266 7.62312 11.2789 7.90016 11.002C8.17707 10.725 8.62466 10.725 8.9017 11.002L10.703 12.8033L14.8064 8.69997C15.0833 8.42293 15.5309 8.42293 15.808 8.69997C16.0849 8.97688 16.0849 9.42447 15.808 9.70151Z" fill="#2196F3"/>
                        </svg>
                        <span class="whitespace-nowrap text-white">{{ $item }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div x-data="revealOnScroll()" class="flex flex-col">
        <p class="text-2xl text-white mb-6">Стандарты и рекомендации, на которые мы опирались при подготовке Отчета</p>
        <div class="grid grid-cols-2 lg:grid-cols-1 gap-2">
            <div class="ml-auto flex flex-col rounded-[10px]
            bg-gradient-to-br from-white/25 to-white/[0.03]
            backdrop-blur-2xl
            border border-white/15
            p-5 text-white">
                <p class="text-white">Российские</p>
                <ul class="list-disc list-outside pl-6">
                    <li class="text-white text-lg">Рекомендации Банка России по раскрытию публичными акционерными обществами нефинансовой информации, связанной с деятельностью таких обществ</li>
                    <li class="text-white text-lg">Рекомендации ПАО Московская Биржа об утверждении Дополнительных правил, требований и рекомендаций по раскрытию информации эмитентами, акции которых включены в Первый или Второй уровень</li>
                    <li class="text-white text-lg">Методологии российских рейтинговых агентств по присвоению ESG-рейтингов нефинансовым компаниям</li>
                </ul>
            </div>
            <div class="ml-auto flex flex-col rounded-[10px]
            bg-gradient-to-br from-white/25 to-white/[0.03]
            backdrop-blur-2xl
            border border-white/15
            p-5 text-white">
                <p class="text-white">Международные</p>
                <ul class="list-disc list-outside pl-6">
                    <li class="text-white text-lg">Стандарты Глобальной инициативы по отчетности в области устойчивого развития 2021 (Global Reporting Initiative (GRI) Standards, GRI) </li>
                    <li class="text-white text-lg">Стандарт по взаимодействию со стейкхолдерами АА1000SES</li>
                    <li class="text-white text-lg">Отраслевое приложение GRI для электроэнергетической отрасли, The Electric Utilities Sector Disclosures</li>
                </ul>
            </div>
        </div>
    </div>

</section>
