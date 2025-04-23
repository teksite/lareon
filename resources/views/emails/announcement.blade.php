<!doctype html>
<html lang="en" dir="{{is_rtl() ? 'rtl': 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{config('app.name')}} - {{$content['subject'] ?? __('new email')}}</title>
</head>
<body style="background-color: #e5e7ebcc; box-sizing: border-box">
<div style="display: flex;justify-content: center;align-items: center">
    <div style="padding: 1rem;background-color: #fff;border-radius: 16px; width: min(80% ,1536px );margin: 1.5rem auto">
        @isset($content['heading'])
            <h1>{{$content['heading']}}</h1>
        @endisset

        @isset($content['introduction'])
            @if(is_string($content['introduction']))
                <p>
                    {!! $content['introduction'] !!}
                </p>
            @elseif(is_array($content['introduction']))
                @foreach($content['introduction'] as $line)
                    <p>
                        {{ $line }}
                    </p>
                @endforeach
            @endif
        @endisset

        @if(isset($content['action']['title'],$content['action']['url']) || isset($content['action'][0],$content['action'][1]))
            <div style="display: flex; justify-content: center; margin: 1rem auto;">
                <a href="{{$content['action']['url'] ?? $content['action'][1]}}" target="_blank"
                   style="background-color: #007bff ; padding: 8px 16px ; border-radius: 8px; color: #eeeeec ; font-weight: bold;text-decoration: none">
                    {{$content['action']['title'] ?? $content['action'][1]}}
                </a>
            </div>
        @endif

        @isset($content['explanation'])
            @if(is_string($content['explanation']))
                <p>
                    {!! $content['explanation'] !!}
                </p>
            @elseif(is_array($content['explanation']))
                @foreach($content['explanation'] as $line)
                    {!! $line !!}
                @endforeach
            @endif
        @endisset

        <div style="display: flex; justify-content: end">
            <div>
                <p>@lang('sincerely')</p>
                <p style="font-weight: bold;">@lang(config('app.name'))</p>
            </div>
        </div>

        @if(isset($content['action']['title'],$content['action']['url']) || isset($content['action'][0],$content['action'][1]))
            <hr style="margin: 2rem auto;">
            <p style="color: #4a5568; font-size: 12px;font-weight: 600">
                ** {!!  __('if you have problem to open the above link you can use :link' ,
                    ['link'=>'<a href="'.$content['action']['url'].'" target="_blank" style="color:#007bff">'.$content['action']['url'].'</a>']) !!}
            </p>
        @endif
    </div>
</div>
</body>
</html>
