<x-app-layout>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="bg-white dark:bg-gray-800 shadow mb-4 p-4 border-2 border-gray-400 rounded-lg text-red-800 dark:text-red-400 text-sm text-center"
                role="alert">

                <span class="font-medium">{{ $error }}</span>

            </div>
        @endforeach
    @endif
    <!-- Hero Section -->
    @include('home.hero-section')

    <!-- Statistics -->
    @include('home.stats-section')

    <div class="wave-divider dark:bg-slate-900">
        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path
                d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"
                class="fill-blue-100 dark:fill-blue-900"></path>
        </svg>
    </div>

    <!-- Qu'est-ce que la bourse ? -->
    @include('home.what-is-it-section')

    <div class="wave-divider dark:bg-slate-900">
        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path
                d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"
                class="fill-blue-100 dark:fill-blue-900"></path>
        </svg>
    </div>

    <!-- Conditions d'eligibiite-->
    @include('home.conditions-section')

    <div class="wave-divider dark:bg-slate-900">
        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path
                d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"
                class="fill-blue-100 dark:fill-blue-900"></path>
        </svg>
    </div>

    <!-- Comment postuler ? -->
    @include('home.process-section')

    <div class="wave-divider dark:bg-slate-900">
        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path
                d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"
                class="fill-blue-100 dark:fill-blue-900"></path>
        </svg>
    </div>

    <!-- CTA -->
    @include('home.cta-section')

    <div class="wave-divider dark:bg-slate-900">
        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path
                d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"
                class="fill-blue-100 dark:fill-blue-900"></path>
        </svg>
    </div>

    @include('home.testimonials')

    @section('script')
        <script>
            const cardsData = [
                {
                    image: 'https://images.unsplash.com/photo-1633332755192-727a05c4013d?q=80&w=200',
                    name: 'Briar Martin',
                    handle: '@neilstellar',
                    date: 'April 20, 2025'
                },
                {
                    image: 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?q=80&w=200',
                    name: 'Avery Johnson',
                    handle: '@averywrites',
                    date: 'May 10, 2025'
                },
                {
                    image: 'https://images.unsplash.com/photo-1527980965255-d3b416303d12?w=200&auto=format&fit=crop&q=60',
                    name: 'Jordan Lee',
                    handle: '@jordantalks',
                    date: 'June 5, 2025'
                },
                {
                    image: 'https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?w=200&auto=format&fit=crop&q=60',
                    name: 'Avery Johnson',
                    handle: '@averywrites',
                    date: 'May 10, 2025'
                },
            ];

            const row1 = document.getElementById('row1');
            const row2 = document.getElementById('row2');

            const createCard = (card) => `
                                                        <div class="p-4 rounded-lg mx-4 shadow hover:shadow-lg dark:shadow-slate-700 transition-all duration-200 w-72 shrink-0">
                                                            <div class="flex gap-2">
                                                                <img class="size-11 rounded-full" src="${card.image}" alt="User Image">
                                                                <div class="flex flex-col">
                                                                    <div class="flex items-center gap-1">
                                                                        <p class="text-slate-800 dark:text-slate-400">${card.name}</p>
                                                                        <svg class="mt-0.5" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.555.72a4 4 0 0 1-.297.24c-.179.12-.38.202-.59.244a4 4 0 0 1-.38.041c-.48.039-.721.058-.922.129a1.63 1.63 0 0 0-.992.992c-.071.2-.09.441-.129.922a4 4 0 0 1-.041.38 1.6 1.6 0 0 1-.245.59 3 3 0 0 1-.239.297c-.313.368-.47.551-.56.743-.213.444-.213.96 0 1.404.09.192.247.375.56.743.125.146.187.219.24.297.12.179.202.38.244.59.018.093.026.189.041.38.039.48.058.721.129.922.163.464.528.829.992.992.2.071.441.09.922.129.191.015.287.023.38.041.21.042.411.125.59.245.078.052.151.114.297.239.368.313.551.47.743.56.444.213.96.213 1.404 0 .192-.09.375-.247.743-.56.146-.125.219-.187.297-.24.179-.12.38-.202.59-.244a4 4 0 0 1 .38-.041c.48-.039.721-.058.922-.129.464-.163.829-.528.992-.992.071-.2.09-.441.129-.922a4 4 0 0 1 .041-.38c.042-.21.125-.411.245-.59.052-.078.114-.151.239-.297.313-.368.47-.551.56-.743.213-.444.213-.96 0-1.404-.09-.192-.247-.375-.56-.743a4 4 0 0 1-.24-.297 1.6 1.6 0 0 1-.244-.59 3 3 0 0 1-.041-.38c-.039-.48-.058-.721-.129-.922a1.63 1.63 0 0 0-.992-.992c-.2-.071-.441-.09-.922-.129a4 4 0 0 1-.38-.041 1.6 1.6 0 0 1-.59-.245A3 3 0 0 1 7.445.72C7.077.407 6.894.25 6.702.16a1.63 1.63 0 0 0-1.404 0c-.192.09-.375.247-.743.56m4.07 3.998a.488.488 0 0 0-.691-.69l-2.91 2.91-.958-.957a.488.488 0 0 0-.69.69l1.302 1.302c.19.191.5.191.69 0z" fill="#2196F3" />
                                                                        </svg>
                                                                    </div>
                                                                    <span class="text-xs text-slate-500">${card.handle}</span>
                                                                </div>
                                                            </div>
                                                            <p class="text-sm pt-4 text-gray-800 dark:text-slate-400">Radiant made undercutting all of our competitors an absolute breeze.</p>
                                                        </div>
                                                    `;

            const renderCards = (target) => {
                const doubled = [...cardsData, ...cardsData];
                doubled.forEach(card => target.insertAdjacentHTML('beforeend', createCard(card)));
            };

            renderCards(row1);
            renderCards(row2);
        </script>
        <script>
            const makeSlider = (container) => {
                let isDown = false;
                let startX;
                let scrollLeft;

                // Pause animation on interaction
                const pauseAnimation = () => container.style.animationPlayState = 'paused';
                const resumeAnimation = () => container.style.animationPlayState = 'running';

                container.addEventListener('mousedown', (e) => {
                    isDown = true;
                    container.classList.add('cursor-grabbing');
                    pauseAnimation();

                    startX = e.pageX - container.offsetLeft;
                    scrollLeft = container.scrollLeft;
                });

                container.addEventListener('mouseleave', () => {
                    if (isDown) resumeAnimation();
                    isDown = false;
                });

                container.addEventListener('mouseup', () => {
                    isDown = false;
                    resumeAnimation();
                });

                container.addEventListener('mousemove', (e) => {
                    if (!isDown) return;
                    e.preventDefault();
                    const x = e.pageX - container.offsetLeft;
                    const walk = (x - startX) * 1.5; // speed
                    container.scrollLeft = scrollLeft - walk;
                });

                // Mobile touch support
                container.addEventListener('touchstart', (e) => {
                    isDown = true;
                    pauseAnimation();
                    startX = e.touches[0].pageX - container.offsetLeft;
                    scrollLeft = container.scrollLeft;
                });

                container.addEventListener('touchend', () => {
                    isDown = false;
                    resumeAnimation();
                });

                container.addEventListener('touchmove', (e) => {
                    if (!isDown) return;
                    const x = e.touches[0].pageX - container.offsetLeft;
                    const walk = (x - startX) * 1.4;
                    container.scrollLeft = scrollLeft - walk;
                });
            };

            // Apply to both rows
            makeSlider(document.getElementById('row1'));
            makeSlider(document.getElementById('row2'));
        </script>
    @endsection
</x-app-layout>