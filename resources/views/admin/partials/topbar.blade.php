<header id="page-topbar"
    class="group/topbar group-data-[navbar=hidden]:hidden print:hidden right-0 rtl:md:right-vertical-menu group-data-[layout=horizontal]:rtl:right-0 group-data-[sidebar-size=sm]:rtl:md:right-vertical-menu-sm group-data-[sidebar-size=md]:rtl:md:right-vertical-menu-md left-0 ltr:md:left-vertical-menu group-data-[layout=horizontal]:ltr:left-0 group-data-[sidebar-size=sm]:ltr:md:left-vertical-menu-sm group-data-[sidebar-size=md]:ltr:md:left-vertical-menu-md z-[1000] group-data-[layout=horizontal]:z-[1004] fixed group-data-[navbar=scroll]:absolute group-data-[navbar=bordered]:m-4 group-data-[navbar=bordered]:[&.is-sticky]:mt-0 transition-all duration-300 ease-linear">
    <div class="layout-width">
        <div
            class="flex items-center bg-topbar group-data-[topbar=brand]:bg-topbar-brand group-data-[topbar=dark]:bg-topbar-dark group-data-[topbar=dark]:dark:bg-zink-700 shadow-md shadow-slate-200/50 dark:shadow-none group-data-[layout=horizontal]:dark:group-[.is-sticky]/topbar:shadow-none group-data-[layout=horizontal]:shadow-none group-data-[navbar=bordered]:shadow-none group-data-[topbar=dark]:group-[.is-sticky]/topbar:dark:shadow-md group-data-[topbar=dark]:group-[.is-sticky]/topbar:dark:shadow-zink-500 mx-auto px-4 border-topbar group-data-[topbar=brand]:border-topbar-brand group-data-[topbar=dark]:border-topbar-dark group-data-[topbar=dark]:dark:border-zink-700 border-b-2 group-data-[navbar=bordered]:rounded-md group-data-[navbar=bordered]:group-[.is-sticky]/topbar:rounded-t-none group-data-[layout=horizontal]:group-data-[navbar=bordered]:rounded-b-none h-header">
            <div
                class="flex items-center group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:ltr:xl:pr-3 group-data-[layout=horizontal]:rtl:xl:pl-3 w-full group-data-[layout=horizontal]:max-w-screen-2xl navbar-header">
                <!-- LOGO -->
                <div
                    class="hidden group-data-[layout=horizontal]:md:flex justify-center items-center px-5 group-data-[layout=horizontal]:rtl:pr-0 group-data-[layout=horizontal]:ltr::pl-0 h-header text-center">
                    <a href="{{ route('admin.dashboard', app()->getLocale()) }}">
                        <span class="hidden">
                            <img src="{{ asset('img/vodacom-seeklogo.png') }}" alt="" class="mx-auto h-6">
                        </span>
                        <span class="group-data-[topbar=brand]:hidden group-data-[topbar=dark]:hidden">
                            <img src="{{ asset('img/vodacom-seeklogo.png') }}" alt="" class="mx-auto h-6">
                        </span>
                    </a>
                    <a href="{{ route('admin.dashboard', app()->getLocale()) }}"
                        class="hidden group-data-[topbar=brand]:block group-data-[topbar=dark]:block">
                        <span class="group-data-[topbar=brand]:hidden group-data-[topbar=dark]:hidden">
                            <img src="{{ asset('img/vodacom-seeklogo.png') }}" alt="" class="mx-auto h-6">
                        </span>
                        <span class="group-data-[topbar=brand]:block group-data-[topbar=dark]:block">
                            <img src="{{ asset('img/vodacom-seeklogo.png') }}" alt="" class="mx-auto h-6">
                        </span>
                    </a>
                </div>

                <button type="button"
                    class="group-data-[layout=horizontal]:md:hidden inline-flex relative group-data-[layout=horizontal]:flex justify-center items-center bg-topbar hover:bg-slate-100 group-data-[topbar=brand]:bg-topbar-brand group-data-[topbar=brand]:hover:bg-topbar-item-bg-hover-brand group-data-[topbar=dark]:hover:bg-topbar-item-bg-hover-dark group-data-[topbar=dark]:bg-topbar-dark group-data-[topbar=dark]:dark:bg-zink-700 group-data-[topbar=dark]:dark:hover:bg-zink-600 p-0 group-data-[topbar=brand]:border-topbar-brand group-data-[topbar=dark]:border-topbar-dark group-data-[topbar=dark]:dark:border-zink-700 rounded-md w-[37.5px] h-[37.5px] text-topbar-item group-data-[topbar=brand]:hover:text-topbar-item-hover-brand group-data-[topbar=brand]:text-topbar-item-brand group-data-[topbar=dark]:hover:text-topbar-item-hover-dark group-data-[topbar=dark]:dark:hover:text-zink-50 group-data-[topbar=dark]:dark:text-zink-200 group-data-[topbar=dark]:text-topbar-item-dark transition-all duration-75 ease-linear btn hamburger-icon"
                    id="topnav-hamburger-icon">
                    <i data-lucide="chevrons-left" class="group-data-[sidebar-size=sm]:hidden w-5 h-5"></i>
                    <i data-lucide="chevrons-right" class="hidden group-data-[sidebar-size=sm]:block w-5 h-5"></i>
                </button>

                <div
                    class="hidden group-data-[layout=horizontal]:hidden lg:block group-data-[layout=horizontal]:lg:block relative rtl:mr-3 ltr:ml-3">
                    <input type="text"
                        class="bg-topbar group-data-[topbar=brand]:bg-topbar-brand group-data-[topbar=dark]:bg-topbar-dark group-data-[topbar=dark]:dark:bg-zink-700 py-2 pr-4 pl-8 border border-topbar-border focus:border-blue-400 group-data-[topbar=brand]:border-topbar-border-brand group-data-[topbar=dark]:border-topbar-border-dark group-data-[topbar=dark]:dark:border-zink-500 rounded focus-visible:outline-0 min-w-[300px] text-topbar-item placeholder:text-slate-400 group-data-[topbar=dark]:text-topbar-item-dark group-data-[topbar=brand]:placeholder:text-blue-300 group-data-[topbar=brand]:text-topbar-item-brand group-data-[topbar=dark]:dark:text-zink-100 group-data-[topbar=dark]:placeholder:text-slate-500 text-sm form-control"
                        placeholder="Search for ..." autocomplete="off">
                    <i data-lucide="search"
                        class="inline-block top-2.5 left-2.5 absolute fill-slate-100 group-data-[topbar=brand]:fill-topbar-item-bg-hover-brand group-data-[topbar=dark]:fill-topbar-item-bg-hover-dark group-data-[topbar=dark]:dark:fill-zink-600 size-4 text-topbar-item group-data-[topbar=brand]:text-topbar-item-brand group-data-[topbar=dark]:dark:text-zink-200 group-data-[topbar=dark]:text-topbar-item-dark"></i>
                </div>

                <div class="flex gap-3 ms-auto">
                    <div class="relative flex items-center h-header dropdown">
                        <button type="button" data-dropdown-toggle="language-dropdown-menu"
                            class="box-border flex items-center bg-transparent hover:bg-neutral-secondary-medium px-3 py-2 border border-transparent rounded-base focus:outline-none focus:ring-4 focus:ring-neutral-tertiary font-medium text-heading dark:text-slate-300 text-sm leading-5">
                            <img src="{{ $current['flag'] }}" alt="flag" class="xs:me-2 w-6 h-6">
                            <span class="hidden xs:block">{{ $current['label'] }}</span>
                        </button>
                        <div class="hidden z-50 bg-neutral-primary-medium bg-slate-200 dark:bg-slate-900 shadow-lg border border-default-medium rounded-base w-44"
                            id="language-dropdown-menu">
                            <ul class="p-2 font-medium text-body dark:text-slate-200 text-sm" role="none">
                                @foreach ($languages as $code => $language)
                                    <li>
                                        <a href="{{ url()->current() === url('/') ? '/' . $code : str_replace('/' . $locale, '/' . $code, url()->full()) }}"
                                            class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded {{ $code === $locale ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                                            role="menuitem">
                                            <div class="inline-flex items-center">
                                                <img src="{{ $language['flag'] }}" alt="{{ $language['label'] }}"
                                                    class="me-2 w-6 h-6">
                                                <span class="text-sm">{{ $language['label'] }}</span>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="relative flex items-center h-header">
                        <button type="button"
                            class="inline-flex relative justify-center items-center bg-topbar hover:bg-topbar-item-bg-hover group-data-[topbar=brand]:bg-topbar-brand group-data-[topbar=brand]:hover:bg-topbar-item-bg-hover-brand group-data-[topbar=dark]:hover:bg-topbar-item-bg-hover-dark group-data-[topbar=dark]:bg-topbar-dark group-data-[topbar=dark]:dark:bg-zink-700 group-data-[topbar=dark]:dark:hover:bg-zink-600 p-0 rounded-md w-[37.5px] h-[37.5px] text-topbar-item hover:text-topbar-item-hover group-data-[topbar=brand]:hover:text-topbar-item-hover-brand group-data-[topbar=brand]:text-topbar-item-brand group-data-[topbar=dark]:hover:text-topbar-item-hover-dark group-data-[topbar=dark]:dark:hover:text-zink-50 group-data-[topbar=dark]:dark:text-zink-200 group-data-[topbar=dark]:text-topbar-item-dark transition-all duration-200 ease-linear btn"
                            id="light-dark-mode">
                            <i data-lucide="sun"
                                class="inline-block fill-slate-100 group-data-[topbar=brand]:fill-topbar-item-bg-hover-brand group-data-[topbar=dark]:fill-topbar-item-bg-hover-dark stroke-1 w-5 h-5"></i>
                        </button>
                    </div>

                    <div class="relative flex items-center h-header dropdown">
                        <button type="button"
                            class="inline-flex relative justify-center items-center bg-topbar hover:bg-topbar-item-bg-hover group-data-[topbar=brand]:bg-topbar-brand group-data-[topbar=brand]:hover:bg-topbar-item-bg-hover-brand group-data-[topbar=dark]:hover:bg-topbar-item-bg-hover-dark group-data-[topbar=dark]:bg-topbar-dark group-data-[topbar=dark]:dark:bg-zink-700 group-data-[topbar=dark]:dark:hover:bg-zink-600 p-0 rounded-md w-[37.5px] h-[37.5px] text-topbar-item hover:text-topbar-item-hover group-data-[topbar=brand]:hover:text-topbar-item-hover-brand group-data-[topbar=brand]:text-topbar-item-brand group-data-[topbar=dark]:hover:text-topbar-item-hover-dark group-data-[topbar=dark]:dark:hover:text-zink-50 group-data-[topbar=dark]:dark:text-zink-200 group-data-[topbar=dark]:text-topbar-item-dark transition-all duration-200 ease-linear dropdown-toggle btn"
                            id="notificationDropdown" data-bs-toggle="dropdown">
                            <i data-lucide="bell-ring"
                                class="inline-block fill-slate-100 group-data-[topbar=brand]:fill-topbar-item-bg-hover-brand group-data-[topbar=dark]:fill-topbar-item-bg-hover-dark stroke-1 w-5 h-5"></i>
                            <span class="top-0 right-0 absolute flex w-1.5 h-1.5">
                                <span
                                    class="inline-flex absolute bg-sky-400 opacity-75 rounded-full w-full h-full animate-ping"></span>
                                <span class="inline-flex relative bg-sky-500 rounded-full w-1.5 h-1.5"></span>
                            </span>
                        </button>
                        <div class="hidden !top-4 z-50 absolute bg-white dark:bg-zink-600 shadow-md rounded-md min-w-[20rem] lg:min-w-[26rem] ltr:text-left rtl:text-right dropdown-menu"
                            aria-labelledby="notificationDropdown">
                            <div class="p-4">
                                <h6 class="mb-4 text-16">Notifications <span
                                        class="inline-flex justify-center items-center bg-orange-500 ml-1 border border-orange-500 rounded-full w-5 h-5 font-medium text-[11px] text-white">15</span>
                                </h6>
                                <ul class="flex flex-wrap bg-slate-100 dark:bg-zink-500 filter-btns mb-2 p-1 rounded-md w-full font-medium text-slate-500 dark:text-zink-200 text-sm text-center nav-tabs"
                                    data-filter-target="notification-list">
                                    <li class="grow">
                                        <a href="javascript:void(0);" data-filter="all"
                                            class="inline-block [&.active]:bg-white dark:[&.active]:bg-zink-600 -mb-[1px] px-1.5 py-1 border border-transparent rounded-md w-full text-slate-500 hover:text-custom-500 [&.active]:text-custom-500 active:text-custom-500 dark:hover:text-custom-500 dark:text-zink-200 text-xs transition-all duration-300 ease-linear nav-link active">View
                                            All</a>
                                    </li>
                                    <li class="grow">
                                        <a href="javascript:void(0);" data-filter="mention"
                                            class="inline-block [&.active]:bg-white dark:[&.active]:bg-zink-600 -mb-[1px] px-1.5 py-1 border border-transparent rounded-md w-full text-slate-500 hover:text-custom-500 [&.active]:text-custom-500 active:text-custom-500 dark:hover:text-custom-500 dark:text-zink-200 text-xs transition-all duration-300 ease-linear nav-link">Mentions</a>
                                    </li>
                                    <li class="grow">
                                        <a href="javascript:void(0);" data-filter="follower"
                                            class="inline-block [&.active]:bg-white dark:[&.active]:bg-zink-600 -mb-[1px] px-1.5 py-1 border border-transparent rounded-md w-full text-slate-500 hover:text-custom-500 [&.active]:text-custom-500 active:text-custom-500 dark:hover:text-custom-500 dark:text-zink-200 text-xs transition-all duration-300 ease-linear nav-link">Followers</a>
                                    </li>
                                    <li class="grow">
                                        <a href="javascript:void(0);" data-filter="invite"
                                            class="inline-block [&.active]:bg-white dark:[&.active]:bg-zink-600 -mb-[1px] px-1.5 py-1 border border-transparent rounded-md w-full text-slate-500 hover:text-custom-500 [&.active]:text-custom-500 active:text-custom-500 dark:hover:text-custom-500 dark:text-zink-200 text-xs transition-all duration-300 ease-linear nav-link">Invites</a>
                                    </li>
                                </ul>

                            </div>
                            <div data-simplebar class="max-h-[350px]">
                                <div class="flex flex-col gap-1" id="notification-list">
                                    <a href="#!"
                                        class="flex gap-3 hover:bg-slate-50 dark:hover:bg-zink-500 p-4 product-item follower">
                                        <div class="bg-slate-100 rounded-md w-10 h-10 shrink-0">
                                            <img src="{{ asset('assets/images/users/avatar-3.png') }}" alt=""
                                                class="rounded-md">
                                        </div>
                                        <div class="grow">
                                            <h6 class="mb-1 font-medium"><b>@willie_passem</b> followed you</h6>
                                            <p class="mb-0 text-slate-500 dark:text-zink-300 text-sm"><i
                                                    data-lucide="clock" class="inline-block mr-1 w-3.5 h-3.5"></i>
                                                <span class="align-middle">Wednesday 03:42 PM</span>
                                            </p>
                                        </div>
                                        <div
                                            class="flex items-center self-start gap-2 text-slate-500 dark:text-zink-300 text-xs shrink-0">
                                            <div class="bg-custom-500 rounded-full w-1.5 h-1.5"></div> 4 sec
                                        </div>
                                    </a>
                                    <a href="#!"
                                        class="flex gap-3 hover:bg-slate-50 dark:hover:bg-zink-500 p-4 product-item mention">
                                        <div class="bg-yellow-100 rounded-md w-10 h-10 shrink-0">
                                            <img src="{{ asset('assets/images/users/avatar-5.png') }}" alt=""
                                                class="rounded-md">
                                        </div>
                                        <div class="grow">
                                            <h6 class="mb-1 font-medium"><b>@caroline_jessica</b> commented on your
                                                post</h6>
                                            <p class="mb-3 text-slate-500 dark:text-zink-300 text-sm"><i
                                                    data-lucide="clock" class="inline-block mr-1 w-3.5 h-3.5"></i>
                                                <span class="align-middle">Wednesday 03:42 PM</span>
                                            </p>
                                            <div
                                                class="bg-slate-100 dark:bg-zink-500 p-2 rounded text-slate-500 dark:text-zink-300">
                                                Amazing! Fast, to the point, professional and really amazing to work
                                                with them!!!</div>
                                        </div>
                                        <div
                                            class="flex items-center self-start gap-2 text-slate-500 dark:text-zink-300 text-xs shrink-0">
                                            <div class="bg-custom-500 rounded-full w-1.5 h-1.5"></div> 15 min
                                        </div>
                                    </a>
                                    <a href="#!"
                                        class="flex gap-3 hover:bg-slate-50 dark:hover:bg-zink-500 p-4 product-item invite">
                                        <div
                                            class="flex justify-center items-center bg-red-100 rounded-md w-10 h-10 shrink-0">
                                            <i data-lucide="shopping-bag"
                                                class="fill-red-200 w-5 h-5 text-red-500"></i>
                                        </div>
                                        <div class="grow">
                                            <h6 class="mb-1 font-medium">Successfully purchased a business plan for
                                                <span class="text-red-500">$199.99</span>
                                            </h6>
                                            <p class="mb-0 text-slate-500 dark:text-zink-300 text-sm"><i
                                                    data-lucide="clock" class="inline-block mr-1 w-3.5 h-3.5"></i>
                                                <span class="align-middle">Monday 11:26 AM</span>
                                            </p>
                                        </div>
                                        <div
                                            class="flex items-center self-start gap-2 text-slate-500 dark:text-zink-300 text-xs shrink-0">
                                            <div class="bg-custom-500 rounded-full w-1.5 h-1.5"></div> Yesterday
                                        </div>
                                    </a>
                                    <a href="#!"
                                        class="flex gap-3 hover:bg-slate-50 dark:hover:bg-zink-500 p-4 product-item mention">
                                        <div class="relative shrink-0">
                                            <div class="bg-pink-100 rounded-md w-10 h-10">
                                                <img src="{{ asset('assets/images/users/avatar-7.png') }}"
                                                    alt="" class="rounded-md">
                                            </div>
                                            <div class="-right-0.5 -bottom-0.5 absolute text-16 text-orange-500">
                                                <i class="ri-heart-fill"></i>
                                            </div>
                                        </div>
                                        <div class="grow">
                                            <h6 class="mb-1 font-medium"><b>@scott</b> liked your post</h6>
                                            <p class="mb-0 text-slate-500 dark:text-zink-300 text-sm"><i
                                                    data-lucide="clock" class="inline-block mr-1 w-3.5 h-3.5"></i>
                                                <span class="align-middle">Thursday 06:59 AM</span>
                                            </p>
                                        </div>
                                        <div
                                            class="flex items-center self-start gap-2 text-slate-500 dark:text-zink-300 text-xs shrink-0">
                                            <div class="bg-custom-500 rounded-full w-1.5 h-1.5"></div> 1 Week
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 p-4 border-slate-200 dark:border-zink-500 border-t">
                                <div class="grow">
                                    <a href="#!">Manage Notification</a>
                                </div>
                                <div class="shrink-0">
                                    <button type="button"
                                        class="bg-custom-500 hover:bg-custom-600 focus:bg-custom-600 active:bg-custom-600 px-2 py-1.5 border-custom-500 hover:border-custom-600 focus:border-custom-600 active:border-custom-600 focus:ring active:ring focus:ring-custom-100 active:ring-custom-100 text-white hover:text-white focus:text-white active:text-white text-xs transition-all duration-200 ease-linear btn">View
                                        All Notification <i data-lucide="move-right"
                                            class="inline-block ml-1 w-3.5 h-3.5"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="hidden relative md:flex items-center h-header">
                        <button type="button" data-drawer-target="drawer-right-example"
                            data-drawer-show="drawer-right-example" data-drawer-placement="right"
                            aria-controls="drawer-right-example"
                            class="inline-flex justify-center items-center bg-topbar hover:bg-topbar-item-bg-hover group-data-[topbar=brand]:bg-topbar-brand group-data-[topbar=brand]:hover:bg-topbar-item-bg-hover-brand group-data-[topbar=dark]:hover:bg-topbar-item-bg-hover-dark group-data-[topbar=dark]:bg-topbar-dark group-data-[topbar=dark]:dark:bg-zink-700 group-data-[topbar=dark]:dark:hover:bg-zink-600 p-0 rounded-md w-[37.5px] h-[37.5px] text-topbar-item hover:text-topbar-item-hover group-data-[topbar=brand]:hover:text-topbar-item-hover-brand group-data-[topbar=brand]:text-topbar-item-brand group-data-[topbar=dark]:hover:text-topbar-item-hover-dark group-data-[topbar=dark]:dark:hover:text-zink-50 group-data-[topbar=dark]:dark:text-zink-200 group-data-[topbar=dark]:text-topbar-item-dark transition-all duration-200 ease-linear btn">
                            <i data-lucide="settings"
                                class="inline-block fill-slate-100 group-data-[topbar=brand]:fill-topbar-item-bg-hover-brand group-data-[topbar=dark]:fill-topbar-item-bg-hover-dark stroke-1 w-5 h-5"></i>
                        </button>
                    </div>

                    <!-- drawer component -->
                    <div id="drawer-right-example"
                        class="top-0 right-0 z-40 fixed bg-white dark:bg-gray-800 p-4 w-96 h-screen overflow-y-auto transition-transform translate-x-full"
                        tabindex="-1" aria-labelledby="drawer-right-label">
                        <div class="flex items-center mb-5 pb-4 border-default border-b">
                            <div class="grow">
                                <h5 id="drawer-right-example"
                                    class="inline-flex items-center font-medium text-gray-800 dark:text-gray-300 text-lg">
                                    <svg class="me-1.5 w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M10 11h2v5m-2 0h4m-2.592-8.5h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    Settings
                                </h5>
                                <p class="font-normal text-slate-700 dark:text-zink-200">Choose your themes & layouts
                                    etc.</p>
                            </div>
                            <div class="shrink-0">
                                <button type="button" data-drawer-hide="drawer-right-example"
                                    aria-controls="drawer-right-example"
                                    class="top-2.5 absolute flex justify-center items-center bg-transparent hover:bg-neutral-tertiary rounded-base w-9 h-9 text-body hover:text-heading end-2.5">
                                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" />
                                    </svg>
                                    <span class="sr-only">Close menu</span>
                                </button>
                            </div>
                        </div>
                        <div class="p-6 h-full overflow-y-auto">
                            <div>
                                <h5 class="mb-3 text-15 text-gray-700 dark:text-gray-400 underline capitalize">Choose
                                    Layouts</h5>
                                <div class="gap-7 grid grid-cols-1 sm:grid-cols-2 mb-5">
                                    <div class="relative">
                                        <input id="layout-one" name="dataLayout"
                                            class="top-2 ltr:right-2 rtl:left-2 absolute bg-slate-100 checked:bg-custom-500 dark:bg-zink-400 border border-slate-300 checked:border-custom-500 dark:border-zink-500 rounded-full w-4 h-4 appearance-none cursor-pointer vertical-menu-btn"
                                            type="radio" value="vertical" checked>
                                        <label
                                            class="block p-0 border border-slate-200 dark:border-zink-500 rounded-lg w-full h-24 overflow-hidden cursor-pointer"
                                            for="layout-one">
                                            <span class="flex gap-0 h-full">
                                                <span class="shrink-0">
                                                    <span
                                                        class="flex flex-col gap-1 p-1 border-slate-200 dark:border-zink-500 ltr:border-r rtl:border-l h-full">
                                                        <span
                                                            class="block bg-slate-100 dark:bg-zink-400 mb-2 p-1 px-2 rounded"></span>
                                                        <span
                                                            class="block bg-slate-100 dark:bg-zink-500 p-1 px-2 pb-0"></span>
                                                        <span
                                                            class="block bg-slate-100 dark:bg-zink-500 p-1 px-2 pb-0"></span>
                                                        <span
                                                            class="block bg-slate-100 dark:bg-zink-500 p-1 px-2 pb-0"></span>
                                                    </span>
                                                </span>
                                                <span class="grow">
                                                    <span class="flex flex-col h-full">
                                                        <span class="block bg-slate-100 dark:bg-zink-500 h-3"></span>
                                                        <span
                                                            class="block bg-slate-100 dark:bg-zink-500 mt-auto h-3"></span>
                                                    </span>
                                                </span>
                                            </span>
                                        </label>
                                        <h5 class="mt-2 text-15 text-gray-700 dark:text-gray-400 text-center">Vertical
                                        </h5>
                                    </div>

                                    <div class="relative">
                                        <input id="layout-two" name="dataLayout"
                                            class="top-2 ltr:right-2 rtl:left-2 absolute bg-slate-100 checked:bg-custom-500 dark:bg-zink-400 border border-slate-300 checked:border-custom-500 dark:border-zink-500 rounded-full w-4 h-4 appearance-none cursor-pointer vertical-menu-btn"
                                            type="radio" value="horizontal">
                                        <label
                                            class="block p-0 border border-slate-200 dark:border-zink-500 rounded-lg w-full h-24 overflow-hidden cursor-pointer"
                                            for="layout-two">
                                            <span class="flex flex-col gap-1 h-full">
                                                <span
                                                    class="flex items-center gap-1 bg-slate-100 dark:bg-zink-500 p-1">
                                                    <span
                                                        class="block bg-white dark:bg-zink-500 ml-1 p-1 rounded"></span>
                                                    <span
                                                        class="block bg-white dark:bg-zink-500 ms-auto p-1 px-2 pb-0"></span>
                                                    <span class="block bg-white dark:bg-zink-500 p-1 px-2 pb-0"></span>
                                                </span>
                                                <span class="block bg-slate-100 dark:bg-zink-500 p-1"></span>
                                                <span class="block bg-slate-100 dark:bg-zink-500 mt-auto p-1"></span>
                                            </span>
                                        </label>
                                        <h5 class="mt-2 text-15 text-gray-700 dark:text-gray-400 text-center">
                                            Horizontal</h5>
                                    </div>
                                </div>

                                <div id="semi-dark">
                                    <div class="flex items-center">
                                        <div
                                            class="inline-block relative mr-2 w-10 align-middle transition duration-200 ease-in">
                                            <input type="checkbox" name="customDefaultSwitch" value="dark"
                                                id="customDefaultSwitch"
                                                class="peer/published block checked:right-0 absolute bg-white/80 checked:bg-white dark:bg-zink-500 dark:checked:bg-zink-400 checked:bg-none border-2 border-slate-200 checked:border-custom-500 dark:border-zink-500 rounded-full w-5 h-5 transition duration-300 ease-linear appearance-none cursor-pointer arrow-none">
                                            <label for="customDefaultSwitch"
                                                class="block bg-slate-200 dark:bg-zink-600 peer-checked/published:bg-custom-500 border border-slate-200 dark:border-zink-500 peer-checked/published:border-custom-500 rounded-full h-5 overflow-hidden transition duration-300 ease-linear cursor-pointer"></label>
                                        </div>
                                        <label for="customDefaultSwitch"
                                            class="inline-block font-medium text-gray-700 dark:text-gray-400 text-base">Semi
                                            Dark (Sidebar
                                            & Header)</label>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6">
                                <!-- data-skin="" -->
                                <h5 class="mb-3 text-15 underline capitalize">Skin Layouts</h5>
                                <div class="gap-7 grid grid-cols-1 sm:grid-cols-2 mb-5">
                                    <div class="relative">
                                        <input id="layoutSkitOne" name="dataLayoutSkin"
                                            class="top-2 ltr:right-2 rtl:left-2 absolute bg-slate-100 checked:bg-custom-500 dark:bg-zink-400 border border-slate-300 checked:border-custom-500 dark:border-zink-500 rounded-full w-4 h-4 appearance-none cursor-pointer vertical-menu-btn"
                                            type="radio" value="default">
                                        <label
                                            class="block bg-slate-50 dark:bg-zink-600 p-0 border border-slate-200 dark:border-zink-500 rounded-lg w-full h-24 overflow-hidden cursor-pointer"
                                            for="layoutSkitOne">
                                            <span class="flex gap-0 h-full">
                                                <span class="shrink-0">
                                                    <span
                                                        class="flex flex-col gap-1 p-1 border-slate-200 dark:border-zink-500 ltr:border-r rtl:border-l h-full">
                                                        <span
                                                            class="block bg-slate-100 dark:bg-zink-400 mb-2 p-1 px-2 rounded"></span>
                                                        <span
                                                            class="block bg-slate-100 dark:bg-zink-500 p-1 px-2 pb-0"></span>
                                                        <span
                                                            class="block bg-slate-100 dark:bg-zink-500 p-1 px-2 pb-0"></span>
                                                        <span
                                                            class="block bg-slate-100 dark:bg-zink-500 p-1 px-2 pb-0"></span>
                                                    </span>
                                                </span>
                                                <span class="grow">
                                                    <span class="flex flex-col h-full">
                                                        <span class="block bg-slate-100 dark:bg-zink-500 h-3"></span>
                                                        <span
                                                            class="block bg-slate-100 dark:bg-zink-500 mt-auto h-3"></span>
                                                    </span>
                                                </span>
                                            </span>
                                        </label>
                                        <h5 class="mt-2 text-15 text-gray-700 dark:text-gray-400 text-center">Default
                                        </h5>
                                    </div>

                                    <div class="relative">
                                        <input id="layoutSkitTwo" name="dataLayoutSkin"
                                            class="top-2 ltr:right-2 rtl:left-2 absolute bg-slate-100 checked:bg-custom-500 dark:bg-zink-400 border border-slate-300 checked:border-custom-500 dark:border-zink-500 rounded-full w-4 h-4 appearance-none cursor-pointer vertical-menu-btn"
                                            type="radio" value="bordered" checked>
                                        <label
                                            class="block p-0 border border-slate-200 dark:border-zink-500 rounded-lg w-full h-24 overflow-hidden cursor-pointer"
                                            for="layoutSkitTwo">
                                            <span class="flex gap-0 h-full">
                                                <span class="shrink-0">
                                                    <span
                                                        class="flex flex-col gap-1 p-1 border-slate-200 dark:border-zink-500 ltr:border-r rtl:border-l h-full">
                                                        <span
                                                            class="block bg-slate-100 dark:bg-zink-400 mb-2 p-1 px-2 rounded"></span>
                                                        <span
                                                            class="block bg-slate-100 dark:bg-zink-500 p-1 px-2 pb-0"></span>
                                                        <span
                                                            class="block bg-slate-100 dark:bg-zink-500 p-1 px-2 pb-0"></span>
                                                        <span
                                                            class="block bg-slate-100 dark:bg-zink-500 p-1 px-2 pb-0"></span>
                                                    </span>
                                                </span>
                                                <span class="grow">
                                                    <span class="flex flex-col h-full">
                                                        <span
                                                            class="block border-slate-200 dark:border-zink-500 border-b h-3"></span>
                                                        <span
                                                            class="block mt-auto border-slate-200 dark:border-zink-500 border-t h-3"></span>
                                                    </span>
                                                </span>
                                            </span>
                                        </label>
                                        <h5 class="mt-2 text-15 text-gray-700 dark:text-gray-400 text-center">Bordered
                                        </h5>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6">
                                <!-- data-mode="" -->
                                <h5 class="mb-3 text-15 text-gray-700 dark:text-gray-400 underline capitalize">Light &
                                    Dark</h5>
                                <div class="flex gap-3">
                                    <button type="button" id="dataModeOne" name="dataMode" value="light"
                                        class="bg-white hover:bg-slate-50 [&.active]:bg-custom-50 dark:bg-zink-600 dark:hover:bg-zink-600 dark:[&.active]:bg-custom-500/10 border-slate-200 hover:border-slate-200 [&.active]:border-custom-200 dark:border-zink-400 dark:hover:border-zink-400 dark:[&.active]:border-custom-500/30 border-dashed text-slate-500 hover:text-slate-500 [&.active]:text-custom-500 dark:hover:text-zink-100 dark:[&.active]:text-custom-500 dark:text-zink-200 transition-all duration-200 ease-linear btn active">Light
                                        Mode</button>
                                    <button type="button" id="dataModeTwo" name="dataMode" value="dark"
                                        class="bg-white hover:bg-slate-50 [&.active]:bg-custom-50 dark:bg-zink-600 dark:hover:bg-zink-600 dark:[&.active]:bg-custom-500/10 border-slate-200 hover:border-slate-200 [&.active]:border-custom-200 dark:border-zink-400 dark:hover:border-zink-400 dark:[&.active]:border-custom-500/30 border-dashed text-slate-500 hover:text-slate-500 [&.active]:text-custom-500 dark:hover:text-zink-100 dark:[&.active]:text-custom-500 dark:text-zink-200 transition-all duration-200 ease-linear btn">Dark
                                        Mode</button>
                                </div>
                            </div>

                            <div class="mt-6">
                                <!-- data-content -->
                                <h5 class="mb-3 text-15 underline capitalize">Content Width</h5>
                                <div class="flex gap-3">
                                    <button type="button" id="datawidthOne" name="datawidth" value="fluid"
                                        class="bg-white hover:bg-slate-50 [&.active]:bg-custom-50 dark:bg-zink-600 dark:hover:bg-zink-600 dark:[&.active]:bg-custom-500/10 border-slate-200 hover:border-slate-200 [&.active]:border-custom-200 dark:border-zink-400 dark:hover:border-zink-400 dark:[&.active]:border-custom-500/30 border-dashed text-slate-500 hover:text-slate-500 [&.active]:text-custom-500 dark:hover:text-zink-100 dark:[&.active]:text-custom-500 dark:text-zink-200 transition-all duration-200 ease-linear btn active">Fluid</button>
                                    <button type="button" id="datawidthTwo" name="datawidth" value="boxed"
                                        class="bg-white hover:bg-slate-50 [&.active]:bg-custom-50 dark:bg-zink-600 dark:hover:bg-zink-600 dark:[&.active]:bg-custom-500/10 border-slate-200 hover:border-slate-200 [&.active]:border-custom-200 dark:border-zink-400 dark:hover:border-zink-400 dark:[&.active]:border-custom-500/30 border-dashed text-slate-500 hover:text-slate-500 [&.active]:text-custom-500 dark:hover:text-zink-100 dark:[&.active]:text-custom-500 dark:text-zink-200 transition-all duration-200 ease-linear btn">Boxed</button>
                                </div>
                            </div>

                            <div class="mt-6" id="sidebar-size">
                                <!-- data-sidebar-size="" -->
                                <h5 class="mb-3 text-15 underline capitalize">Sidebar Size</h5>
                                <div class="flex flex-wrap gap-3">
                                    <button type="button" id="sidebarSizeOne" name="sidebarSize" value="lg"
                                        class="bg-white hover:bg-slate-50 [&.active]:bg-custom-50 dark:bg-zink-600 dark:hover:bg-zink-600 dark:[&.active]:bg-custom-500/10 border-slate-200 hover:border-slate-200 [&.active]:border-custom-200 dark:border-zink-400 dark:hover:border-zink-400 dark:[&.active]:border-custom-500/30 border-dashed text-slate-500 hover:text-slate-500 [&.active]:text-custom-500 dark:hover:text-zink-100 dark:[&.active]:text-custom-500 dark:text-zink-200 transition-all duration-200 ease-linear btn active">Default</button>
                                    <button type="button" id="sidebarSizeTwo" name="sidebarSize" value="md"
                                        class="bg-white hover:bg-slate-50 [&.active]:bg-custom-50 dark:bg-zink-600 dark:hover:bg-zink-600 dark:[&.active]:bg-custom-500/10 border-slate-200 hover:border-slate-200 [&.active]:border-custom-200 dark:border-zink-400 dark:hover:border-zink-400 dark:[&.active]:border-custom-500/30 border-dashed text-slate-500 hover:text-slate-500 [&.active]:text-custom-500 dark:hover:text-zink-100 dark:[&.active]:text-custom-500 dark:text-zink-200 transition-all duration-200 ease-linear btn">Compact</button>
                                    <button type="button" id="sidebarSizeThree" name="sidebarSize" value="sm"
                                        class="bg-white hover:bg-slate-50 [&.active]:bg-custom-50 dark:bg-zink-600 dark:hover:bg-zink-600 dark:[&.active]:bg-custom-500/10 border-slate-200 hover:border-slate-200 [&.active]:border-custom-200 dark:border-zink-400 dark:hover:border-zink-400 dark:[&.active]:border-custom-500/30 border-dashed text-slate-500 hover:text-slate-500 [&.active]:text-custom-500 dark:hover:text-zink-100 dark:[&.active]:text-custom-500 dark:text-zink-200 transition-all duration-200 ease-linear btn">Small
                                        (Icon)</button>
                                </div>
                            </div>

                            <div class="mt-6" id="navigation-type">
                                <!-- data-navbar="" -->
                                <h5 class="mb-3 text-15 underline capitalize">Navigation Type</h5>
                                <div class="flex flex-wrap gap-3">
                                    <button type="button" id="navbarTwo" name="navbar" value="sticky"
                                        class="bg-white hover:bg-slate-50 [&.active]:bg-custom-50 dark:bg-zink-600 dark:hover:bg-zink-600 dark:[&.active]:bg-custom-500/10 border-slate-200 hover:border-slate-200 [&.active]:border-custom-200 dark:border-zink-400 dark:hover:border-zink-400 dark:[&.active]:border-custom-500/30 border-dashed text-slate-500 hover:text-slate-500 [&.active]:text-custom-500 dark:hover:text-zink-100 dark:[&.active]:text-custom-500 dark:text-zink-200 transition-all duration-200 ease-linear btn active">Sticky</button>
                                    <button type="button" id="navbarOne" name="navbar" value="scroll"
                                        class="bg-white hover:bg-slate-50 [&.active]:bg-custom-50 dark:bg-zink-600 dark:hover:bg-zink-600 dark:[&.active]:bg-custom-500/10 border-slate-200 hover:border-slate-200 [&.active]:border-custom-200 dark:border-zink-400 dark:hover:border-zink-400 dark:[&.active]:border-custom-500/30 border-dashed text-slate-500 hover:text-slate-500 [&.active]:text-custom-500 dark:hover:text-zink-100 dark:[&.active]:text-custom-500 dark:text-zink-200 transition-all duration-200 ease-linear btn">Scroll</button>
                                    <button type="button" id="navbarThree" name="navbar" value="bordered"
                                        class="bg-white hover:bg-slate-50 [&.active]:bg-custom-50 dark:bg-zink-600 dark:hover:bg-zink-600 dark:[&.active]:bg-custom-500/10 border-slate-200 hover:border-slate-200 [&.active]:border-custom-200 dark:border-zink-400 dark:hover:border-zink-400 dark:[&.active]:border-custom-500/30 border-dashed text-slate-500 hover:text-slate-500 [&.active]:text-custom-500 dark:hover:text-zink-100 dark:[&.active]:text-custom-500 dark:text-zink-200 transition-all duration-200 ease-linear btn">Bordered</button>
                                    <button type="button" id="navbarFour" name="navbar" value="hidden"
                                        class="bg-white hover:bg-slate-50 [&.active]:bg-custom-50 dark:bg-zink-600 dark:hover:bg-zink-600 dark:[&.active]:bg-custom-500/10 border-slate-200 hover:border-slate-200 [&.active]:border-custom-200 dark:border-zink-400 dark:hover:border-zink-400 dark:[&.active]:border-custom-500/30 border-dashed text-slate-500 hover:text-slate-500 [&.active]:text-custom-500 dark:hover:text-zink-100 dark:[&.active]:text-custom-500 dark:text-zink-200 transition-all duration-200 ease-linear btn">Hidden</button>
                                </div>
                            </div>

                            <div class="mt-6" id="sidebar-color">
                                <!-- data-sidebar="" light, dark, brand, modern-->
                                <h5 class="mb-3 text-15 underline capitalize">Sizebar Colors</h5>
                                <div class="flex flex-wrap gap-3">
                                    <button type="button" id="sidebarColorOne" name="sidebarColor" value="light"
                                        class="group flex justify-center items-center bg-white border border-slate-200 rounded-md w-10 h-10 active"><i
                                            data-lucide="check"
                                            class="hidden group-[.active]:inline-block w-5 h-5 text-slate-600"></i></button>
                                    <button type="button" id="sidebarColorTwo" name="sidebarColor" value="dark"
                                        class="group flex justify-center items-center bg-zink-900 border border-zink-900 rounded-md w-10 h-10"><i
                                            data-lucide="check"
                                            class="hidden group-[.active]:inline-block w-5 h-5 text-white"></i></button>
                                    <button type="button" id="sidebarColorThree" name="sidebarColor" value="brand"
                                        class="group flex justify-center items-center bg-custom-800 border border-custom-800 rounded-md w-10 h-10"><i
                                            data-lucide="check"
                                            class="hidden group-[.active]:inline-block w-5 h-5 text-white"></i></button>
                                    <button type="button" id="sidebarColorFour" name="sidebarColor" value="modern"
                                        class="group flex justify-center items-center bg-gradient-to-t from-red-400 to-purple-500 border border-purple-950 rounded-md w-10 h-10"><i
                                            data-lucide="check"
                                            class="hidden group-[.active]:inline-block w-5 h-5 text-white"></i></button>
                                </div>
                            </div>

                            <div class="mt-6">
                                <!-- data-topbar="" light, dark, brand, modern-->
                                <h5 class="mb-3 text-15 underline capitalize">Topbar Colors</h5>
                                <div class="flex flex-wrap gap-3">
                                    <button type="button" id="topbarColorOne" name="topbarColor" value="light"
                                        class="group flex justify-center items-center bg-white border border-slate-200 rounded-md w-10 h-10 active"><i
                                            data-lucide="check"
                                            class="hidden group-[.active]:inline-block w-5 h-5 text-slate-600"></i></button>
                                    <button type="button" id="topbarColorTwo" name="topbarColor" value="dark"
                                        class="group flex justify-center items-center bg-zink-900 border border-zink-900 rounded-md w-10 h-10"><i
                                            data-lucide="check"
                                            class="hidden group-[.active]:inline-block w-5 h-5 text-white"></i></button>
                                    <button type="button" id="topbarColorThree" name="topbarColor" value="brand"
                                        class="group flex justify-center items-center bg-custom-800 border border-custom-800 rounded-md w-10 h-10"><i
                                            data-lucide="check"
                                            class="hidden group-[.active]:inline-block w-5 h-5 text-white"></i></button>
                                </div>
                            </div>

                        </div>
                        <div
                            class="flex justify-between items-center gap-3 p-4 border-slate-200 dark:border-zink-500 border-t">
                            {{-- TODO: Find how to reset the user preferences --}}
                            <button type="button" id="reset-layout"
                                class="bg-slate-200 hover:bg-slate-300 focus:bg-slate-300 border-slate-200 hover:border-slate-300 focus:border-slate-300 focus:ring focus:ring-slate-100 w-full text-slate-500 hover:text-slate-600 focus:text-slate-600 transition-all duration-200 ease-linear btn">
                                Reset
                            </button>
                        </div>
                    </div>

                    <div class="relative flex items-center h-header dropdown">
                        <button type="button"
                            class="inline-block bg-topbar hover:bg-topbar-item-bg-hover group-data-[topbar=brand]:bg-topbar-brand group-data-[topbar=brand]:hover:bg-topbar-item-bg-hover-brand group-data-[topbar=dark]:hover:bg-topbar-item-bg-hover-dark group-data-[topbar=dark]:bg-topbar-dark group-data-[topbar=dark]:dark:bg-zink-700 group-data-[topbar=dark]:dark:hover:bg-zink-600 p-0 rounded-full text-topbar-item hover:text-topbar-item-hover group-data-[topbar=brand]:hover:text-topbar-item-hover-brand group-data-[topbar=brand]:text-topbar-item-brand group-data-[topbar=dark]:hover:text-topbar-item-hover-dark group-data-[topbar=dark]:dark:hover:text-zink-50 group-data-[topbar=dark]:dark:text-zink-200 group-data-[topbar=dark]:text-topbar-item-dark transition-all duration-200 ease-linear dropdown-toggle btn"
                            id="dropdownMenuButton" data-dropdown-toggle="userDropdown">
                            <div class="bg-pink-100 rounded-full">
                                <img src="{{ asset('assets/images/users/user-profile.png') }}" alt=""
                                    class="rounded-full w-[37.5px] h-[37.5px]">
                            </div>
                        </button>
                        <div class="hidden !top-4 z-40 absolute bg-white dark:bg-zink-600 shadow-md p-4 rounded-md min-w-[14rem] ltr:text-left rtl:text-right dropdown-menu"
                            id="userDropdown" aria-labelledby="dropdownMenuButton">
                            <a href="#!" class="flex gap-3 mb-3">
                                <div class="inline-block relative shrink-0">
                                    <div class="bg-slate-100 dark:bg-zink-500 rounded">
                                        <img src="{{ asset('assets/images/users/user-profile.png') }}" alt=""
                                            class="rounded w-12 h-12">
                                    </div>
                                    <span
                                        class="-top-1 ltr:-right-1 rtl:-left-1 absolute bg-green-400 border-2 border-white dark:border-zink-600 rounded-full w-2.5 h-2.5"></span>
                                </div>
                                <div>
                                    <h6 class="mb-1 text-15">{{ Auth::user()->full_name }}</h6>
                                    {{-- TODO: A redefinir apres la mise en place des roles et permissions --}}
                                    <p class="text-slate-500 dark:text-zink-300">CEO & Founder</p>
                                </div>
                            </a>
                            <ul>
                                <li>
                                    <a class="block py-1.5 ltr:pr-4 rtl:pl-4 font-medium text-slate-600 hover:text-custom-500 focus:text-custom-500 dark:hover:text-custom-500 dark:focus:text-custom-500 dark:text-zink-200 text-base transition-all duration-200 ease-linear dropdown-item"
                                        href="{{ route('profile.edit', app()->getLocale()) }}"><i
                                            data-lucide="user-2" class="inline-block ltr:mr-2 rtl:ml-2 size-4"></i>
                                        Profile</a>
                                </li>
                                {{-- TODO: Ajouter un lien vers une page de gestions des utilisateurs --}}
                                <li>
                                    <a class="block py-1.5 ltr:pr-4 rtl:pl-4 font-medium text-slate-600 hover:text-custom-500 focus:text-custom-500 dark:hover:text-custom-500 dark:focus:text-custom-500 dark:text-zink-200 text-base transition-all duration-200 ease-linear dropdown-item"
                                        href="#"><i data-lucide="mail"
                                            class="inline-block ltr:mr-2 rtl:ml-2 size-4"></i> Inbox <span
                                            class="inline-flex justify-center items-center bg-red-500 rtl:mr-2 ltr:ml-2 border border-red-500 rounded-full w-5 h-5 font-medium text-[11px] text-white">15</span></a>
                                </li>
                                <li>
                                    <a class="block py-1.5 ltr:pr-4 rtl:pl-4 font-medium text-slate-600 hover:text-custom-500 focus:text-custom-500 dark:hover:text-custom-500 dark:focus:text-custom-500 dark:text-zink-200 text-base transition-all duration-200 ease-linear dropdown-item"
                                        href="{{ route('admin.chats.index', app()->getLocale()) }}"><i
                                            data-lucide="messages-square"
                                            class="inline-block ltr:mr-2 rtl:ml-2 size-4"></i> Chat</a>
                                </li>
                                <li class="mt-2 pt-2 border-slate-200 dark:border-zink-500 border-t">
                                    <a class="block py-1.5 ltr:pr-4 rtl:pl-4 font-medium text-slate-600 hover:text-custom-500 focus:text-custom-500 dark:hover:text-custom-500 dark:focus:text-custom-500 dark:text-zink-200 text-base transition-all duration-200 ease-linear dropdown-item"
                                        href="#" x-data=""
                                        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-logout')"><i
                                            data-lucide="log-out" class="inline-block ltr:mr-2 rtl:ml-2 size-4"></i>
                                        Sign Out</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-modal name="confirm-user-logout" focusable>
        <form method="post" action="{{ route('logout', app()->getLocale()) }}" class="p-6">
            @csrf

            <h2 class="font-medium text-gray-900 text-lg">
                {{ __('Are you certain you want to logout ?') }}
            </h2>

            <div class="flex justify-end mt-6">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('actions.log_out') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</header>
