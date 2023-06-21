        @extends('layouts.app')
        @section('content')
        @livewireStyles
        <!--<div>
            @foreach ($tools as $tool)
                <p>Tools name : {{$tool->name}}</p>
                <p>Tools price : {{$tool->price->toArray()['price']}}</p>
                <a href="{{route('tools.show',['tool' => $tool->id])}}">Voir plus</a>
            @endforeach
        </div> -->
        @livewire('tools')
        @livewireScripts
        @stop