@props(['name'])

@switch($name)
    @case('duration-icon')
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
            <path fill-rule="evenodd"
                d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-13a.75.75 0 0 0-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 0 0 0-1.5h-3.25V5Z"
                clip-rule="evenodd" />
        </svg>
    @break

    @case('start-time-icon')
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-5">
            <path
                d="M5.75 7.5a.75.75 0 1 0 0 1.5.75.75 0 0 0 0-1.5ZM5 10.25a.75.75 0 1 1 1.5 0 .75.75 0 0 1-1.5 0ZM10.25 7.5a.75.75 0 1 0 0 1.5.75.75 0 0 0 0-1.5ZM7.25 8.25a.75.75 0 1 1 1.5 0 .75.75 0 0 1-1.5 0ZM8 9.5A.75.75 0 1 0 8 11a.75.75 0 0 0 0-1.5Z" />
            <path fill-rule="evenodd"
                d="M4.75 1a.75.75 0 0 0-.75.75V3a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2V1.75a.75.75 0 0 0-1.5 0V3h-5V1.75A.75.75 0 0 0 4.75 1ZM3.5 7a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v4.5a1 1 0 0 1-1 1h-7a1 1 0 0 1-1-1V7Z"
                clip-rule="evenodd" />
        </svg>
    @break

    @case('end-time-icon')
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-5">
            <path
                d="M5.75 7.5a.75.75 0 1 0 0 1.5.75.75 0 0 0 0-1.5ZM5 10.25a.75.75 0 1 1 1.5 0 .75.75 0 0 1-1.5 0ZM10.25 7.5a.75.75 0 1 0 0 1.5.75.75 0 0 0 0-1.5ZM7.25 8.25a.75.75 0 1 1 1.5 0 .75.75 0 0 1-1.5 0ZM8 9.5A.75.75 0 1 0 8 11a.75.75 0 0 0 0-1.5Z" />
            <path fill-rule="evenodd"
                d="M4.75 1a.75.75 0 0 0-.75.75V3a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2V1.75a.75.75 0 0 0-1.5 0V3h-5V1.75A.75.75 0 0 0 4.75 1ZM3.5 7a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v4.5a1 1 0 0 1-1 1h-7a1 1 0 0 1-1-1V7Z"
                clip-rule="evenodd" />
        </svg>
    @break

    @case('questions-icon')
        <svg {{ $attributes->merge(['class' => 'w-5 h-5']) }} viewBox="0 0 26 26" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
            <g id="Group_706" data-name="Group 706" transform="translate(-250.1 -150)">
                <path id="Path_1495" data-name="Path 1495"
                    d="M264,171h-2v-2h2Zm-5-11a3.886,3.886,0,0,1,4-4c2.7,0,4,1.5,4,4,0,2.1-1,4.5-3,5v3h-2v-4a.945.945,0,0,1,1-1c1.3,0,2-1.7,2-3a2,2,0,0,0-4,0,1,1,0,1,1-2,0Zm4,16a12.654,12.654,0,0,1-6.9-2c-.5-.4-1.9-1.3-1.2-2.3.5-.7,1.5.1,1.5.1A11,11,0,1,0,252,163a15.153,15.153,0,0,0,1.5,5.7c.1.3.6.9-.1,1.5-.4.3-1.2-.1-1.5-.7a11.2,11.2,0,0,1-1.8-6.5A13,13,0,1,1,263,176Z" />
            </g>
        </svg>
    @break

    @case('score-icon')
        <svg class="w-5 h-5" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <style>
                    .a {
                        stroke-linecap: round;
                        stroke-linejoin: round;
                    }
                </style>
            </defs>
            <path class="fill-none stroke-gray-800 dark:stroke-gray-300 a"
                d="M39.5,30.8668V6.5a2,2,0,0,0-2-2h-27a2,2,0,0,0-2,2v35a2,2,0,0,0,2,2h27a2,2,0,0,0,2-2V40.0311" />
            <path class="fill-none stroke-gray-800 dark:stroke-gray-300 a"
                d="M37.1342,37.66,21.2877,21.7746V17.25H25.92L41.7049,33.0776" />
            <path class="fill-none stroke-gray-800 dark:stroke-gray-300 a"
                d="M44.3148,37.9846a1.6234,1.6234,0,0,0,0-2.2906l-2.61-2.6164L37.1342,37.66l2.61,2.6164a1.6136,1.6136,0,0,0,2.2849,0Z" />
            <line class="fill-none stroke-gray-800 dark:stroke-gray-300 a" x1="13" y1="10.5" x2="35"
                y2="10.5" />
            <line class="fill-none stroke-gray-800 dark:stroke-gray-300 a" x1="13" y1="17.25" x2="21.2877"
                y2="17.25" />
            <line class="fill-none stroke-gray-800 dark:stroke-gray-300 a" x1="32.6516" y1="24" x2="35"
                y2="24" />
            <line class="fill-none stroke-gray-800 dark:stroke-gray-300 a" x1="13" y1="24" x2="23.5077"
                y2="24" />
            <line class="fill-none stroke-gray-800 dark:stroke-gray-300 a" x1="13" y1="30.75" x2="29.989"
                y2="30.75" />
            <line class="fill-none stroke-gray-800 dark:stroke-gray-300 a" x1="13" y1="37.5" x2="35"
                y2="37.5" />
        </svg>
    @break

    @case('dashboard-icon')
        <svg {{ $attributes->merge(['class' => 'w-4 h-4']) }} aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
            fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9.143 4H4.857A.857.857 0 0 0 4 4.857v4.286c0 .473.384.857.857.857h4.286A.857.857 0 0 0 10 9.143V4.857A.857.857 0 0 0 9.143 4Zm10 0h-4.286a.857.857 0 0 0-.857.857v4.286c0 .473.384.857.857.857h4.286A.857.857 0 0 0 20 9.143V4.857A.857.857 0 0 0 19.143 4Zm-10 10H4.857a.857.857 0 0 0-.857.857v4.286c0 .473.384.857.857.857h4.286a.857.857 0 0 0 .857-.857v-4.286A.857.857 0 0 0 9.143 14Zm10 0h-4.286a.857.857 0 0 0-.857.857v4.286c0 .473.384.857.857.857h4.286a.857.857 0 0 0 .857-.857v-4.286a.857.857 0 0 0-.857-.857Z" />
        </svg>
    @break

    @case('profile-icon')
        <svg {{ $attributes->merge(['class' => 'w-4 h-4']) }} aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
            fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Zm0 0a8.949 8.949 0 0 0 4.951-1.488A3.987 3.987 0 0 0 13 16h-2a3.987 3.987 0 0 0-3.951 3.512A8.948 8.948 0 0 0 12 21Zm3-11a3 3 0 1 1-6 0A3,3,0,0,1,15,10Z" />
        </svg>
    @break
@endswitch
