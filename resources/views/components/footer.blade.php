<footer class="pt-32 pb-16 bg-cover bg-right" style="background-image: url({{ '/fixed/footer-bg.png' }})">
    <div class="container flex gap-16 md:flex-col md:items-center md:text-center">
        <x-logo class="w-44" color="white"/>
        <div class="flex flex-col">
            @foreach($navLinks as $link)
                <a style="color: white !important;" class="!text-white leading-8" wire:navigate href="{{ route('article.index', $link['slug'])}}">{{ $link->title }}</a>
            @endforeach
            <p class="mt-14 text-white/75">© 2025 ПАО «Россети»</p>
        </div>
        <div class="flex flex-col ml-auto mr-10 md:mx-auto md:text-center md:items-center">
{{--            <p class="text-white border-b border-white w-fit mb-4">+7 (495) 995-53-33 (доб. 35-29)</p>--}}
{{--            <p class="text-white border-b border-white w-fit mb-4">info@rosseti.ru</p>--}}
            <a href="https://ch35708.tw1.ru/prilozeniia#8-1461" class="text-white border-b border-white w-fit mb-4">Контактная информация</a>
            <!-- Yandex.Metrika informer -->
            <a href="https://metrika.yandex.ru/stat/?id=110978392&amp;from=informer" target="_blank" rel="nofollow">
                <img src="https://informer.yandex.ru/informer/110978392/3_1_FFFFFFFF_EFEFEFFF_0_pageviews"
                     style="width:88px; height:31px; border:0;"
                     alt="Яндекс.Метрика"
                     title="Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)"
                     class="ym-advanced-informer" data-cid="110978392" data-lang="ru"/>
            </a>
            <!-- /Yandex.Metrika informer -->
            <div class="flex gap-4 mt-auto">
                <a href="https://vk.ru/rosseti?ysclid=m8owdxatqf708480530">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="24" height="24" rx="12" fill="white"/>
                        <path d="M12.5894 16.1969C8.07948 16.1969 5.50709 13.0437 5.3999 7.79688H7.65899C7.73319 11.6479 9.39865 13.2792 10.7178 13.6155V7.79688H12.845V11.1182C14.1477 10.9753 15.5163 9.46174 15.978 7.79688H18.1052C17.9312 8.66032 17.5844 9.47787 17.0865 10.1984C16.5885 10.9189 15.9501 11.5269 15.2113 11.9843C16.036 12.4022 16.7645 12.9938 17.3486 13.7199C17.9327 14.4461 18.3592 15.2903 18.5999 16.1969H16.2584C16.0423 15.4094 15.6031 14.7046 14.9959 14.1706C14.3887 13.6366 13.6405 13.2972 12.845 13.1951V16.1969H12.5894Z" fill="#224217"/>
                    </svg>
                </a>
                <a href="https://max.ru/rosseti_official">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="24" height="24" rx="12" fill="white"/>
                        <g clip-path="url(#clip0_2702_2357)">
                            <path d="M11.8402 5.79727C8.36353 5.97894 6.06853 8.7056 6.21353 12.1439C6.27686 13.6489 6.88186 14.9439 7.02519 16.3723C7.06186 16.7423 6.95519 17.1989 7.38186 17.3606C7.90686 17.5589 8.71186 17.2256 9.15186 16.9206C9.30186 16.8189 9.44519 16.7006 9.55519 16.5539C10.0102 16.8556 10.4419 17.1473 10.9835 17.2773C13.3685 17.8489 15.9819 16.5406 17.1435 14.4389C19.3269 10.4906 16.3752 5.5606 11.8402 5.79727ZM10.4902 14.0373C10.3019 14.1839 10.1202 14.3839 9.91186 14.4989C9.61019 14.6606 9.51686 14.4923 9.40353 14.2256C9.04686 13.3773 9.00353 11.9323 9.21186 11.0439C9.49186 9.8356 10.4269 8.77227 11.7119 8.65894C13.0119 8.54394 14.2185 9.20394 14.7635 10.3956C15.9702 13.0473 12.8819 15.6656 10.4902 14.0389V14.0373Z" fill="#203B15"/>
                        </g>
                        <defs>
                            <clipPath id="clip0_2702_2357">
                                <rect width="12" height="12" fill="white" transform="translate(6 5.64062)"/>
                            </clipPath>
                        </defs>
                    </svg>
                </a>
                <a href="https://t.me/rosseti_official">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="24" height="24" rx="12" fill="white"/>
                        <path d="M16.7999 7.56446L14.9966 16.9785C14.9966 16.9785 14.7443 17.6312 14.0512 17.3182L9.89065 14.0147L9.87135 14.0049C10.4334 13.4824 14.7913 9.42472 14.9818 9.2408C15.2767 8.95594 15.0936 8.78636 14.7513 9.00154L8.31398 13.2349L5.83049 12.3696C5.83049 12.3696 5.43966 12.2256 5.40206 11.9126C5.36396 11.599 5.84335 11.4295 5.84335 11.4295L15.9678 7.31649C15.9678 7.31649 16.7999 6.93788 16.7999 7.56446Z" fill="#224217"/>
                    </svg>
                </a>
                <a href="https://rutube.ru/channel/24249867/videos/">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="24" height="24" rx="12" fill="white"/>
                        <g clip-path="url(#clip0_2658_2023)">
                            <path d="M18.5472 7.86744C19.2389 7.86744 19.7995 7.31473 19.7995 6.63294C19.7995 5.95114 19.2389 5.39844 18.5472 5.39844C17.8556 5.39844 17.2949 5.95114 17.2949 6.63294C17.2949 7.31473 17.8556 7.86744 18.5472 7.86744Z" fill="#224217"/>
                            <path d="M17.5425 12.8952C17.2636 13.7126 16.5737 14.0933 15.6919 14.243L18.0473 17.3954L15.3051 17.399L13.1647 14.2551L8.45692 14.2558L8.45426 17.3974L6.00049 17.3997L6.00182 7.73438L15.0129 7.737C15.4254 7.737 15.788 7.79728 16.1672 7.89819C16.9343 8.14325 17.487 8.73822 17.6492 9.51536C17.709 9.80203 17.7515 10.0746 17.7512 10.3682L17.7499 11.6502C17.7492 12.0807 17.6804 12.4909 17.5425 12.8948V12.8952ZM15.2954 11.5437L15.2968 10.4648C15.2968 10.2866 15.2223 10.0949 15.0744 9.99631C14.9116 9.88754 14.7331 9.88623 14.5343 9.86297L8.45525 9.861L8.4526 12.1226L14.5473 12.1216C14.7374 12.1085 14.9026 12.1049 15.0595 12.0138C15.2163 11.9228 15.2948 11.7354 15.2951 11.5437H15.2954Z" fill="#224217"/>
                        </g>
                        <defs>
                            <clipPath id="clip0_2658_2023">
                                <rect width="13.8" height="12" fill="white" transform="translate(6 5.39844)"/>
                            </clipPath>
                        </defs>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</footer>
