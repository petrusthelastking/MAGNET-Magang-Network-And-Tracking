<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
    <style>
        .scrolling-wrapper {
            display: flex;
            gap: 1rem;
            width: max-content;
            animation: scroll-horizontal 10s linear infinite;
        }

        .scrolling-wrapper.reverse {
            animation: scroll-horizontal-reverse 10s linear infinite;
        }

        @keyframes scroll-horizontal {
            0% {
                transform: translateX(-50%);
            }

            100% {
                transform: translateX(0%);
            }
        }

        @keyframes scroll-horizontal-reverse {
            0% {
                transform: translateX(0%);
            }

            100% {
                transform: translateX(-50%);
            }
        }
    </style>
</head>

<body class="bg-magnet-frost-mist text-black">
    {{ $slot }}

    @fluxScripts
</body>

</html>