<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', 'Woodcraft')</title>
    <style>
        /* Reset styles */
        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        /* Container styles */
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Header styles */
        .header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 1px solid #eee;
        }

        .logo {
            max-width: 150px;
            height: auto;
        }

        /* Content styles */
        .content {
            padding: 30px 0;
        }

        /* Button styles */
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #4B2E1F;
            color: #ffffff;
            text-decoration: none;
            border-radius: 4px;
            font-weight: 500;
        }

        .button:hover {
            background-color: #3b2417;
        }

        /* Footer styles */
        .footer {
            text-align: center;
            padding: 20px 0;
            border-top: 1px solid #eee;
            font-size: 14px;
            color: #666;
        }

        /* Social media links */
        .social-links {
            margin: 20px 0;
        }

        .social-links a {
            display: inline-block;
            margin: 0 10px;
            color: #4B2E1F;
            text-decoration: none;
        }

        /* Responsive styles */
        @media screen and (max-width: 600px) {
            .container {
                padding: 10px;
            }

            .content {
                padding: 20px 0;
            }

            .button {
                display: block;
                text-align: center;
            }
        }

        /* Custom styles */
        .text-wood {
            color: #4B2E1F;
        }

        .bg-wood {
            background-color: #4B2E1F;
        }

        .border-wood {
            border-color: #4B2E1F;
        }
    </style>
</head>
<body>
    <div class="container">
        {{-- Header --}}
        <div class="header">
            <img src="{{ asset('img/logo.png') }}" alt="Woodcraft" class="logo">
        </div>

        {{-- Content --}}
        <div class="content">
            @yield('content')
        </div>

        {{-- Footer --}}
        <div class="footer">
            {{-- Social Media Links --}}
            <div class="social-links">
                <a href="{{ config('app.social_facebook') }}" target="_blank">
                    <img src="{{ asset('img/email/facebook.png') }}" alt="Facebook" width="24" height="24">
                </a>
                <a href="{{ config('app.social_instagram') }}" target="_blank">
                    <img src="{{ asset('img/email/instagram.png') }}" alt="Instagram" width="24" height="24">
                </a>
                <a href="{{ config('app.social_twitter') }}" target="_blank">
                    <img src="{{ asset('img/email/twitter.png') }}" alt="Twitter" width="24" height="24">
                </a>
            </div>

            {{-- Contact Information --}}
            <p>
                <strong>Woodcraft</strong><br>
                123 Wood Street, Craftville<br>
                Phone: +1 (555) 123-4567<br>
                Email: support@woodcraft.com
            </p>

            {{-- Legal Links --}}
            <p style="margin-top: 20px; font-size: 12px;">
                <a href="{{ route('privacy') }}" style="color: #666; text-decoration: none;">Privacy Policy</a> |
                <a href="{{ route('terms') }}" style="color: #666; text-decoration: none;">Terms of Service</a> |
                <a href="{{ route('unsubscribe') }}" style="color: #666; text-decoration: none;">Unsubscribe</a>
            </p>

            {{-- Copyright --}}
            <p style="margin-top: 10px; font-size: 12px;">
                &copy; {{ date('Y') }} Woodcraft. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html> 