<!DOCTYPE html>
<html lang="{{app()->getLocale()}}" dir="{{(app()->getLocale() == 'ar') ? 'rtl' : 'ltr'}}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $setting->title }}</title>

    <link rel="icon" href="{{ asset('website_assets/images/favicon.svg') }}">
    <!-- Font imports -->
    <link href="https://fonts.googleapis.com/css2?family=Advent+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* Custom CSS for ZOY maintenance page */
        :root {
            --primary: #392639;
            --secondary: #CEAA7A;
            --tertiary: #8D9595;
            --light: #F7F5F2;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @font-face {
            font-family: 'GE SS Two';
            src: url('https://cdn.jsdelivr.net/gh/alfont/alfont/fonts/ge-ss-two-medium.woff2') format('woff2');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }

        body {
            font-family: 'Advent Pro', sans-serif;
            background-color: var(--light);
            color: var(--primary);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 20px;
            overflow-x: hidden;
            overflow-y: auto;
        }


        .container {
            max-width: 600px;
            margin: 0 auto;
        }

        .logo {
            margin-bottom: 40px;
            text-align: center;
        }

        .logo img {
            max-width: 200px;
            height: auto;
        }

        .message {
            margin-bottom: 40px;
        }

        .message h1 {
            font-size: 32px;
            margin-bottom: 20px;
            color: var(--primary);
            font-weight: 600;
        }

        .message p {
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 15px;
            color: var(--tertiary);
        }

        .message-ar {
            font-family: 'GE SS Two', Arial, sans-serif;
            direction: rtl;
            margin-top: 30px;
            color: var(--tertiary);
        }

        /* SVG container */
        .maintenance-scene {
            position: relative;
            width: 280px;
            height: 180px;
            margin: 20px auto 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Floating progress dots */
        .progress-dots {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .dot {
            width: 10px;
            height: 10px;
            margin: 0 6px;
            border-radius: 50%;
            background-color: var(--secondary);
            opacity: 0.5;
        }

        .dot:nth-child(1) {
            animation: fade 1.5s ease-in-out infinite;
        }

        .dot:nth-child(2) {
            animation: fade 1.5s ease-in-out infinite 0.5s;
        }

        .dot:nth-child(3) {
            animation: fade 1.5s ease-in-out infinite 1s;
        }

        /* Keyframes for animations */
        @keyframes fade {
            0%, 100% {
                opacity: 0.3;
            }
            50% {
                opacity: 1;
            }
        }

        .highlight {
            color: var(--secondary);
        }

        @media (max-width: 768px) {
            .logo img {
                max-width: 150px;
            }

            .message h1 {
                font-size: 28px;
            }

            .message p {
                font-size: 16px;
            }

            .maintenance-scene {
                transform: scale(0.9);
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="logo">
        <img src="{{ $setting->logo }}" alt="{{ $setting->title }}">
    </div>

    <div class="message">
        <h1>@lang('website.Site') <span class="highlight">@lang('website.Maintenance')</span></h1>
        <p>@lang('website.The site is under maintenance. We apologize for the inconvenience').</p>
        <p>@lang('website.We are currently making some improvements to our site').</p>


    </div>

    <div class="maintenance-scene">
        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="280"
             height="180" viewBox="0 0 64 64" style="enable-background:new 0 0 512 512" xml:space="preserve">
            <g>
                <path fill="var(--secondary)"
                      d="M25.42 62H4v-8.29c0-2.95 1.2-5.63 3.14-7.57.84-.84 1.82-1.54 2.9-2.06a10.614 10.614 0 0 1 5.96-1c2.82.34 5.34 1.78 7.05 3.92 1.18 1.46 1.98 3.23 2.26 5.2L26 57l.03.08 4.81-2.19 1.98 4.46-4.38 2c-.95.43-1.98.65-3.02.65z"
                      opacity="1"></path>
                <path fill="var(--tertiary)"
                      d="M37.42 56.99c.55-1.15.58-1.35.58-1.56 0-1.34-1.09-2.43-2.43-2.43h-.04c-.35 0-.69.07-1.01.22l-1.2.54A5.765 5.765 0 0 1 38.24 51H40c.73 0 1.41.2 2 .54.3.17.58.39.83.63C43.55 52.9 44 53.9 44 55s-.9 2-2 2h-4.57z"
                      opacity="1"></path>
                <path fill="var(--primary)"
                      d="m33.32 53.76-.01.01-1.31.59V47h10v4.54a3.99 3.99 0 0 0-2-.54h-1.76c-2.01 0-3.88 1.05-4.92 2.76z"
                      opacity="1"></path>
                <path fill="var(--light)"
                      d="M62 39v4c0 2.21-1.79 4-4 4H23.05A10.662 10.662 0 0 0 16 43.08V40h-.32c.85 0 1.66-.34 2.25-.93L18 39z"
                      opacity="1"></path>
                <path fill="var(--secondary)"
                      d="M58 13H21.94c-.33 3.46-2.44 6.4-5.4 7.91.89.74 1.46 1.85 1.46 3.09h3a2 2 0 0 1 2 2c0 .55-.22 1.05-.59 1.41-.36.37-.86.59-1.41.59h-3l.85 8.5c.01.1.01.21.01.31 0 .81-.3 1.59-.86 2.19h44V17c0-2.21-1.79-4-4-4z"
                      opacity="1"></path>
                <circle cx="48" cy="13" r="10" fill="var(--light)" opacity="1"></circle>
                <path fill="var(--primary)" d="M27 29h8v6h-8z" opacity="1"></path>
                <path fill="var(--tertiary)"
                      d="M21.94 13c-.33 3.46-2.44 6.4-5.4 7.91-.69-.57-1.58-.91-2.54-.91h-4c-1.04 0-2.02.26-2.87.73A9.995 9.995 0 0 1 2 12C2 6.48 6.48 2 12 2s10 4.48 10 10c0 .34-.02.67-.06 1z"
                      opacity="1"></path>
                <path fill="var(--primary)" d="M10 35v5c-3.58-1.19-6-4.55-6-8.33V28h6l-.94.94a3.618 3.618 0 0 0 0 5.12z"
                      opacity="1"></path>
                <path fill="var(--secondary)"
                      d="M18 24h-2.76c-.76 0-1.45.43-1.79 1.1L12 28H4v-2c0-2.27 1.27-4.25 3.13-5.27.85-.47 1.83-.73 2.87-.73h4c.96 0 1.85.34 2.54.91.89.74 1.46 1.85 1.46 3.09z"
                      opacity="1"></path>
                <path fill="var(--tertiary)"
                      d="M21 24a2 2 0 0 1 2 2c0 .55-.22 1.05-.59 1.41-.36.37-.86.59-1.41.59h-9l1.45-2.9c.34-.67 1.03-1.1 1.79-1.1H18z"
                      opacity="1"></path>
                <path fill="var(--light)"
                      d="M35.57 53c1.34 0 2.43 1.09 2.43 2.43 0 .21-.03.41-.58 1.56-.22.28-.51.5-.85.66l-3.75 1.7-1.98-4.46 1.16-.53 1.31-.59.01-.01 1.2-.54c.32-.15.66-.22 1.01-.22zM10 40v-5l-.94-.94a3.618 3.618 0 0 1 0-5.12L10 28h8l.85 8.5c.01.1.01.21.01.31 0 .81-.3 1.59-.86 2.19l-.07.07c-.59.59-1.4.93-2.25.93H16v3.08a10.614 10.614 0 0 0-5.96 1L10 44z"
                      opacity="1"></path>
                <path fill="var(--primary)"
                      d="M13 10.162 14.279 14H19v-2h-3.279L13 3.838l-3.186 9.556L8.618 11H5v2h2.382l2.804 5.606z"
                      opacity="1"></path>
                <path fill="var(--primary)"
                      d="M58 48c2.757 0 5-2.243 5-5V17a5.006 5.006 0 0 0-4.046-4.904C58.492 6.453 53.76 2 48 2c-5.728 0-10.442 4.402-10.949 10H23c0-6.065-4.935-11-11-11S1 5.935 1 12c0 3.468 1.642 6.707 4.364 8.77A6.977 6.977 0 0 0 3 26V31.675a9.758 9.758 0 0 0 6 9.014v2.808c-3.575 2.007-6 5.831-6 10.214V63h22.856v-.023a8.222 8.222 0 0 0 2.994-.72l8.136-3.698c.317-.144.603-.334.856-.559H42a2.996 2.996 0 0 0 2.816-2H60c1.654 0 3-1.346 3-3s-1.346-3-3-3h-6a1 1 0 0 1-1-1v-1zm0-2H23.488A11.783 11.783 0 0 0 17 42.235v-1.47A4.178 4.178 0 0 0 18.364 40H61v3c0 1.654-1.346 3-3 3zm-18 4h-1.764c-2.049 0-3.998.95-5.236 2.476V48h8v2.101A4.995 4.995 0 0 0 40 50zm-13.186 5.623-.51-3.568A11.585 11.585 0 0 0 24.921 48H31v5.72zM13.618 26.999l.724-1.447a.994.994 0 0 1 .895-.553H21a1.001 1.001 0 0 1 0 2zM48 4c4.963 0 9 4.038 9 9s-4.037 9-9 9-9-4.038-9-9 4.037-9 9-9zM37.051 14c.507 5.598 5.221 10 10.949 10 5.672 0 10.353-4.316 10.937-9.835A2.993 2.993 0 0 1 61 17v21H19.676a4.146 4.146 0 0 0 .168-1.602l-.74-7.399H21c1.654 0 3-1.346 3-3s-1.346-3-3-3h-2.101a4.965 4.965 0 0 0-.815-1.851A10.917 10.917 0 0 0 22.796 14zM3 12c0-4.962 4.037-9 9-9s9 4.038 9 9c0 3.207-1.689 6.106-4.422 7.726A4.953 4.953 0 0 0 14.001 19H10c-.997 0-1.944.213-2.803.59C4.604 17.945 3 15.09 3 12zm2 14c0-2.757 2.243-5 5-5h4.001c1.304 0 2.415.835 2.827 1.999h-1.592a2.984 2.984 0 0 0-2.684 1.658l-1.171 2.342H5zm0 5.675v-2.676h2.741A4.583 4.583 0 0 0 7 31.5c0 1.216.493 2.407 1.354 3.268l.646.646v3.043a7.756 7.756 0 0 1-4-6.782zm4.768 1.679A2.64 2.64 0 0 1 9 31.5c0-.7.272-1.358.768-1.854l.647-.647h6.68l.76 7.6a2.175 2.175 0 0 1-.629 1.762c-.406.406-.97.64-1.545.64H13v2h2v1.013c-.097-.003-.192-.014-.289-.014-1.298 0-2.543.221-3.711.613v-8.027zm18.254 27.083a6.23 6.23 0 0 1-2.6.563 6.247 6.247 0 0 1-6.021-4.48l-1.442-4.807-1.916.574 1.442 4.807A8.244 8.244 0 0 0 20.044 61H5v-7.289C5 48.356 9.356 44 14.711 44c4.801 0 8.934 3.584 9.612 8.338l.593 4.147-1.33.605.828 1.82 5.921-2.692 1.171 2.634zm8.137-3.699-2.831 1.287-1.171-2.635 2.778-1.263c.184-.083.388-.127.631-.127.79 0 1.434.644 1.434 1.434 0 .56-.33 1.072-.841 1.304zM42 56h-3.052c.032-.186.052-.374.052-.566a3.42 3.42 0 0 0-2.216-3.194c.466-.151.953-.24 1.452-.24H40c1.654 0 3 1.346 3 3a1 1 0 0 1-1 1zm12-4h6a1 1 0 0 1 0 2H44.899A4.988 4.988 0 0 0 43 51.026V48h8v1c0 1.654 1.346 3 3 3z"
                      opacity="1"></path>
                <path fill="var(--secondary)"
                      d="M57 42h2v2h-2zM53 42h2v2h-2zM49 42h2v2h-2zM42 8h2v2h-2zM46 8h8v2h-8zM42 12h2v2h-2zM46 12h8v2h-8zM42 16h2v2h-2zM46 16h8v2h-8zM36 28H26v8h10zm-2 6h-6v-4h6zM26 24h10v2H26zM26 20h10v2H26zM26 16h10v2H26zM38 34h2v2h-2zM42 34h17v2H42zM38 30h21v2H38zM38 26h21v2H38z"
                      opacity="1"></path>
            </g>
        </svg>
    </div>

    <div class="progress-dots">
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
    </div>
</div>
</body>
</html>
