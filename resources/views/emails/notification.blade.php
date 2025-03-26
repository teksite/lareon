<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $subject }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            padding: 20px;
            background-color: #007bff;
            color: #ffffff;
            border-radius: 8px 8px 0 0;
        }

        .header img {
            max-width: 150px;
        }

        .content {
            padding: 20px;
            color: #333333;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        .footer {
            text-align: center;
            padding: 10px;
            font-size: 12px;
            color: #777777;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <img src="{{ asset('images/logo.png') }}" alt="Logo">
        <h1>{{ $subject }}</h1>
    </div>
    <div class="content">
        @foreach ($introduction as $line)
            <p>{{ $line }}</p>
        @endforeach

        @if ($actionUrl && $actionText)
            <a href="{{ $actionUrl }}" class="button">{{ $actionText }}</a>
        @endif
        @foreach ($content as $line)
            <p>{{ $line }}</p>
        @endforeach
    </div>
    <div class="footer">
        @if ($actionUrl && $actionText)
            <p>
                اگر با لینک فوق مشکل دارید می توایند از این لینک استفده کنید.
            </p>
            <a href="{{ $actionUrl }}" class="">{{ $actionUrl }}</a>
            <hr>
        @endif
        <p>© {{ date('Y') }} {{ config('app.name') }}. همه حقوق محفوظه.</p>
        <p>برای لغو اشتراک، <a href="{{ url('/unsubscribe') }}">اینجا کلیک کنید</a>.</p>
    </div>
</div>
</body>
</html>
