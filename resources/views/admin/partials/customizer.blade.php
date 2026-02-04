<div class="hidden right-12 bottom-6 fixed group-data-[navbar=hidden]:flex items-center h-header">
    <button data-drawer-target="customizerButton" data-drawer-show="customizerButton" data-drawer-placement="right"
        aria-controls="customizerButton" type="button"
        class="inline-flex justify-center items-center bg-sky-500 shadow-lg p-0 rounded-md w-12 h-12 text-sky-50 transition-all duration-200 ease-linear">
        <i data-lucide="settings" class="inline-block w-5 h-5"></i>
    </button>
</div>

<div id="customizerButton" drawer-end
    class="top-0 right-0 z-40 fixed bg-white dark:bg-gray-800 p-4 w-96 h-screen overflow-y-auto transition-transform translate-x-full"
    tabindex="-1" aria-labelledby="drawer-right-label">
    <div class="flex justify-between p-4 border-slate-200 dark:border-zink-500 border-b">
        <div class="grow">
            <h5 class="mb-1 text-16">Tailwick Theme Customizer</h5>
            <p class="font-normal text-slate-500 dark:text-zink-200">Choose your themes & layouts etc.</p>
        </div>
        <div class="shrink-0">
            <button data-drawer-close="customizerButton"
                class="text-slate-500 hover:text-slate-800 dark:hover:text-zink-50 dark:text-zink-200 transition-all duration-150 ease-linear"><i
                    data-lucide="x" class="w-4 h-4"></i></button>
        </div>
    </div>
    <div class="p-6 h-full overflow-y-auto">
        <div>
            <h5 class="mb-3 text-15 underline capitalize">Choose Layouts</h5>
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
                                    <span class="block bg-slate-100 dark:bg-zink-400 mb-2 p-1 px-2 rounded"></span>
                                    <span class="block bg-slate-100 dark:bg-zink-500 p-1 px-2 pb-0"></span>
                                    <span class="block bg-slate-100 dark:bg-zink-500 p-1 px-2 pb-0"></span>
                                    <span class="block bg-slate-100 dark:bg-zink-500 p-1 px-2 pb-0"></span>
                                </span>
                            </span>
                            <span class="grow">
                                <span class="flex flex-col h-full">
                                    <span class="block bg-slate-100 dark:bg-zink-500 h-3"></span>
                                    <span class="block bg-slate-100 dark:bg-zink-500 mt-auto h-3"></span>
                                </span>
                            </span>
                        </span>
                    </label>
                    <h5 class="mt-2 text-15 text-center">Vertical</h5>
                </div>

                <div class="relative">
                    <input id="layout-two" name="dataLayout"
                        class="top-2 ltr:right-2 rtl:left-2 absolute bg-slate-100 checked:bg-custom-500 dark:bg-zink-400 border border-slate-300 checked:border-custom-500 dark:border-zink-500 rounded-full w-4 h-4 appearance-none cursor-pointer vertical-menu-btn"
                        type="radio" value="horizontal">
                    <label
                        class="block p-0 border border-slate-200 dark:border-zink-500 rounded-lg w-full h-24 overflow-hidden cursor-pointer"
                        for="layout-two">
                        <span class="flex flex-col gap-1 h-full">
                            <span class="flex items-center gap-1 bg-slate-100 dark:bg-zink-500 p-1">
                                <span class="block bg-white dark:bg-zink-500 ml-1 p-1 rounded"></span>
                                <span class="block bg-white dark:bg-zink-500 ms-auto p-1 px-2 pb-0"></span>
                                <span class="block bg-white dark:bg-zink-500 p-1 px-2 pb-0"></span>
                            </span>
                            <span class="block bg-slate-100 dark:bg-zink-500 p-1"></span>
                            <span class="block bg-slate-100 dark:bg-zink-500 mt-auto p-1"></span>
                        </span>
                    </label>
                    <h5 class="mt-2 text-15 text-center">Horizontal</h5>
                </div>
            </div>

            <div id="semi-dark">
                <div class="flex items-center">
                    <div class="inline-block relative mr-2 w-10 align-middle transition duration-200 ease-in">
                        <input type="checkbox" name="customDefaultSwitch" value="dark" id="customDefaultSwitch"
                            class="peer/published block checked:right-0 absolute bg-white/80 checked:bg-white dark:bg-zink-500 dark:checked:bg-zink-400 checked:bg-none border-2 border-slate-200 checked:border-custom-500 dark:border-zink-500 rounded-full w-5 h-5 transition duration-300 ease-linear appearance-none cursor-pointer arrow-none">
                        <label for="customDefaultSwitch"
                            class="block bg-slate-200 dark:bg-zink-600 peer-checked/published:bg-custom-500 border border-slate-200 dark:border-zink-500 peer-checked/published:border-custom-500 rounded-full h-5 overflow-hidden transition duration-300 ease-linear cursor-pointer"></label>
                    </div>
                    <label for="customDefaultSwitch" class="inline-block font-medium text-base">Semi Dark (Sidebar &
                        Header)</label>
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
                                    <span class="block bg-slate-100 dark:bg-zink-400 mb-2 p-1 px-2 rounded"></span>
                                    <span class="block bg-slate-100 dark:bg-zink-500 p-1 px-2 pb-0"></span>
                                    <span class="block bg-slate-100 dark:bg-zink-500 p-1 px-2 pb-0"></span>
                                    <span class="block bg-slate-100 dark:bg-zink-500 p-1 px-2 pb-0"></span>
                                </span>
                            </span>
                            <span class="grow">
                                <span class="flex flex-col h-full">
                                    <span class="block bg-slate-100 dark:bg-zink-500 h-3"></span>
                                    <span class="block bg-slate-100 dark:bg-zink-500 mt-auto h-3"></span>
                                </span>
                            </span>
                        </span>
                    </label>
                    <h5 class="mt-2 text-15 text-center">Default</h5>
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
                                    <span class="block bg-slate-100 dark:bg-zink-400 mb-2 p-1 px-2 rounded"></span>
                                    <span class="block bg-slate-100 dark:bg-zink-500 p-1 px-2 pb-0"></span>
                                    <span class="block bg-slate-100 dark:bg-zink-500 p-1 px-2 pb-0"></span>
                                    <span class="block bg-slate-100 dark:bg-zink-500 p-1 px-2 pb-0"></span>
                                </span>
                            </span>
                            <span class="grow">
                                <span class="flex flex-col h-full">
                                    <span class="block border-slate-200 dark:border-zink-500 border-b h-3"></span>
                                    <span
                                        class="block mt-auto border-slate-200 dark:border-zink-500 border-t h-3"></span>
                                </span>
                            </span>
                        </span>
                    </label>
                    <h5 class="mt-2 text-15 text-center">Bordered</h5>
                </div>
            </div>
        </div>

        <div class="mt-6">
            <!-- data-mode="" -->
            <h5 class="mb-3 text-15 underline capitalize">Light & Dark</h5>
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
            <!-- dir="ltr" -->
            <h5 class="mb-3 text-15 underline capitalize">LTR & RTL</h5>
            <div class="flex flex-wrap gap-3">
                <button type="button" id="diractionOne" name="dir" value="ltr"
                    class="bg-white hover:bg-slate-50 [&.active]:bg-custom-50 dark:bg-zink-600 dark:hover:bg-zink-600 dark:[&.active]:bg-custom-500/10 border-slate-200 hover:border-slate-200 [&.active]:border-custom-200 dark:border-zink-400 dark:hover:border-zink-400 dark:[&.active]:border-custom-500/30 border-dashed text-slate-500 hover:text-slate-500 [&.active]:text-custom-500 dark:hover:text-zink-100 dark:[&.active]:text-custom-500 dark:text-zink-200 transition-all duration-200 ease-linear btn active">LTR
                    Mode</button>
                <button type="button" id="diractionTwo" name="dir" value="rtl"
                    class="bg-white hover:bg-slate-50 [&.active]:bg-custom-50 dark:bg-zink-600 dark:hover:bg-zink-600 dark:[&.active]:bg-custom-500/10 border-slate-200 hover:border-slate-200 [&.active]:border-custom-200 dark:border-zink-400 dark:hover:border-zink-400 dark:[&.active]:border-custom-500/30 border-dashed text-slate-500 hover:text-slate-500 [&.active]:text-custom-500 dark:hover:text-zink-100 dark:[&.active]:text-custom-500 dark:text-zink-200 transition-all duration-200 ease-linear btn">RTL
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
    <div class="flex justify-between items-center gap-3 p-4 border-slate-200 dark:border-zink-500 border-t">
        <button type="button" id="reset-layout"
            class="bg-slate-200 hover:bg-slate-300 focus:bg-slate-300 border-slate-200 hover:border-slate-300 focus:border-slate-300 focus:ring focus:ring-slate-100 w-full text-slate-500 hover:text-slate-600 focus:text-slate-600 transition-all duration-200 ease-linear btn">Reset</button>
        <a href="#!"
            class="bg-red-500 hover:bg-red-600 focus:bg-red-600 active:bg-red-600 border-red-500 hover:border-red-600 focus:border-red-600 active:border-red-600 focus:ring active:ring focus:ring-red-100 active:ring-red-100 w-full text-white hover:text-white focus:text-white active:text-white transition-all duration-200 ease-linear btn">Buy
            Now</a>
    </div>
</div>
