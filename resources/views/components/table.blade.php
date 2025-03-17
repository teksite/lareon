@props(['headers'=>[]])
<div class="overflow-hidden">
    <table {!! $attributes->merge(['class' => 'min-w-full border border-zinc-300 overflow-x-scroll divide-y divide-zinc-300 rounded-lg tableData']) !!}>
        <thead class="rounded border border-zinc-300">
        <tr>
            @php
                if(request()->sort == 'asc'){$sort = 'desc';}else{$sort = 'asc';}
                $currentParams = request()->query();
            @endphp
            @foreach($headers as $column=>$title)
                <th scope="col" class="px-3 py-3 text-xs uppercase text-start font-semibold text-zinc-600">
                    @php
                        $additionalParams = ['order' =>$column,'sort'=>$sort];
                        $mergedParams = array_merge($currentParams, $additionalParams);
                        $queryString = http_build_query($mergedParams);
                    @endphp
                    @if(is_string($column))
                        <a href="{{ url()->current() }}?{{ $queryString }}" class="{{request()->order == $column ? 'font-bold text-black' : ''}}">
                            {{$title}}
                            {{request()->order == $column && $sort=='asc'  ? '↑' : (request()->order == $column && $sort=='desc' ? '↓' :'⇅')}}
                        </a>
                    @else
                        {{$title}}
                    @endif
                </th>
            @endforeach
        </tr>
        </thead>
        <tbody class="divide-y divide-zinc-300 *:hover:bg-blue-50">
        {!! $slot ?? ''!!}
        </tbody>
        @isset($foot)
            <tfoot>
            {!! $foot !!}
            </tfoot>
        @endisset
    </table>

</div>
