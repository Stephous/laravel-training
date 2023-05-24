        @extends('layouts.app')
        @section('content')
        <div>
            @foreach ($tools as $tool)
                <p>Tools name : {{$tool->name}}</p>
                <p>Tools price : {{$tool->price}}</p>
                <a href="{{route('tools.show',['tool' => $tool->id])}}">Voir plus</a>
            @endforeach
        </div>
        @stop