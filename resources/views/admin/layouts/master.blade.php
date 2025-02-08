<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title' ,__('dashboard')) | {{strtoupper(config('app.name'))}}</title>
    <script> window.dataLayer = window.dataLayer || [];dataLayer.push({ 'pageType': 'protected' }) </script>
    @vite(['Lareon/CMS/resources/css/app.css', 'Lareon/CMS/resources/js/app.js'])

@stack('headerScripts')
</head>
<body class="bg-slate-100" x-data="{sidebar:true ,togglesSidebar() { this.sidebar = !this.sidebar }}">

<main class="p-3">
    @include('lareon::admin.layouts.partials.aside')
    <div class="ms-auto me-0 p-3 transition-all duration-100 xl:w-5/6" :class="{'xl:w-5/6' : sidebar }">
        @include('lareon::admin.layouts.partials.upper-header')
        @include('lareon::admin.layouts.partials.header')
        {!! $slot !!}
    </div>
</main>
<div>
    <form action="" method="POST" id="logoutForm">
        @csrf
        @method('DELETE')
    </form>
</div>
@stack('footerScripts')
</body>
</html>
