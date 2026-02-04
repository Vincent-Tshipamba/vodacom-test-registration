<section class="relative">
    <div class="mx-auto px-4 md:px-5 lg:px-5 w-full max-w-7xl">
        <div
            class="inline-flex flex-col justify-end items-center gap-10 md:gap-16 lg:gap-28 bg-gray-900 px-10 md:px-16 pt-10 md:pt-16 pb-10 rounded-2xl w-full">
            <div class="flex flex-col justify-end items-center gap-10 lg:gap-16">
                <img src="{{ asset('img/vodacom-seeklogo.png') }}" alt="Vodacom logo" class="w-36">
                <div class="flex flex-col justify-center items-center gap-10">
                    <div class="flex flex-col justify-start items-center gap-2.5">
                        <h2
                            class="font-manrope font-bold text-emerald-400 text-5xl md:text-6xl text-center leading-normal">
                            Coming Soon</h2>
                        <p class="font-normal text-gray-500 text-base text-center leading-relaxed">
                            Just 20 days remaining until the big reveal
                            of our new product!</p>
                    </div>
                    <div class="flex justify-center items-start gap-2 w-full count-down-main">
                        <div class="flex flex-col gap-0.5 timer">
                            <div class="">
                                <h3 data-type="days"
                                    class="font-manrope font-bold text-white text-2xl text-center leading-9 days countdown-element">
                                </h3>
                            </div>
                            <p class="w-full font-normal text-gray-500 text-xs text-center leading-normal">
                                DAYS</p>
                        </div>
                        <h3 class="w-3 font-manrope font-medium text-gray-500 text-2xl text-center leading-9">
                            :</h3>
                        <div class="flex flex-col gap-0.5 timer">
                            <div class="">
                                <h3 data-type="hours"
                                    class="font-manrope font-bold text-white text-2xl text-center leading-9 hours countdown-element">
                                </h3>
                            </div>
                            <p class="w-full font-normal text-gray-500 text-xs text-center leading-normal">
                                HRS</p>
                        </div>
                        <h3 class="w-3 font-manrope font-medium text-gray-500 text-2xl text-center leading-9">
                            :</h3>
                        <div class="flex flex-col gap-0.5 timer">
                            <div class="">
                                <h3 data-type="minutes"
                                    class="font-manrope font-bold text-white text-2xl text-center leading-9 minutes countdown-element">
                                </h3>
                            </div>
                            <p class="w-full font-normal text-gray-500 text-xs text-center leading-normal">
                                MINS</p>
                        </div>
                        <h3 class="w-3 font-manrope font-medium text-gray-500 text-2xl text-center leading-9">
                            :</h3>
                        <div class="flex flex-col gap-0.5 timer">
                            <div class="">
                                <h3 data-type="seconds"
                                    class="font-manrope font-bold text-white text-2xl text-center leading-9 seconds countdown-element">
                                </h3>
                            </div>
                            <p class="w-full font-normal text-gray-500 text-xs text-center leading-normal">
                                SECS</p>
                        </div>
                    </div>
                    <div class="flex flex-col justify-center items-center gap-5 w-full">
                        <h6 class="font-semibold text-emerald-400 text-base text-center leading-relaxed">
                            Launched Date: March 31, 2026</h6>
                        <div class="flex sm:flex-row flex-col justify-center items-center gap-2.5">
                            <input type="text"
                                class="inline-flex justify-start items-center gap-1.5 bg-white shadow-[0px_1px_2px_0px_rgba(16,_24,_40,_0.05)] px-3.5 py-2 border border-gray-200 rounded-lg focus:outline-none w-80 h-10 font-normal text-gray-900 text-sm leading-relaxed placeholder-gray-400"
                                placeholder="Type your mail...">
                            <button
                                class="flex justify-center items-center bg-emerald-400 hover:bg-emerald-600 shadow-[0px_1px_2px_0px_rgba(16,_24,_40,_0.05)] px-3.5 py-2 rounded-lg w-full sm:w-fit transition-all duration-700 ease-in-out">
                                <span
                                    class="px-1.5 font-medium text-gray-900 text-sm leading-6 whitespace-nowrap">Notify
                                    Me</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Javascript-->
<script>
    // count-down timer
    let dest = new Date("mar 31, 2026 23:59:59").getTime();
    let x = setInterval(function() {
        let now = new Date().getTime();
        let diff = dest - now;
        // Check if the countdown has reached zero or negative
        if (diff <= 0) {
            // Set the destination date to the same day next month
            let nextMonthDate = new Date();
            nextMonthDate.setMonth(nextMonthDate.getMonth() + 1);

            // If the current month is December, set the destination date to the same day next year
            if (nextMonthDate.getMonth() === 0) {
                nextMonthDate.setFullYear(nextMonthDate.getFullYear() + 1);
            }

            dest = nextMonthDate.getTime();
            return; // Exit the function
        }

        let days = Math.floor(diff / (1000 * 60 * 60 * 24));
        let hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        let minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        let seconds = Math.floor((diff % (1000 * 60)) / 1000);

        if (days < 10) {
            days = `0${days}`;
        }

        if (hours < 10) {
            hours = `0${hours}`;
        }
        if (minutes < 10) {
            minutes = `0${minutes}`;
        }
        if (seconds < 10) {
            seconds = `0${seconds}`;
        }

        // Get elements by class name
        let countdownElements = document.getElementsByClassName("countdown-element");

        // Loop through the elements and update their content
        for (let i = 0; i < countdownElements.length; i++) {
            let type = countdownElements[i].getAttribute('data-type'); // Get the first class name
            switch (type) {
                case "days":
                    countdownElements[i].innerHTML = days;
                    break;
                case "hours":
                    countdownElements[i].innerHTML = hours;
                    break;
                case "minutes":
                    countdownElements[i].innerHTML = minutes;
                    break;
                case "seconds":
                    countdownElements[i].innerHTML = seconds;
                    break;
                default:
                    break;
            }
        }
    }, 10);
</script>
