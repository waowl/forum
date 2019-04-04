@extends('layouts.app')

@section('content')
    <h1>Threads</h1>
    @foreach($threads as $thread)
        <div class="card mb-2">
            <div class="card-header d-flex flex-row justify-content-between">
                @if($thread->hasUpdatedFor())
                    <h4>
                        <strong><a href="{{$thread->path()}}">{{$thread->title}}</a></strong>
                    </h4>
                @else
                    <h4>
                        <a href="{{$thread->path()}}">{{$thread->title}}</a>
                    </h4>
                @endif
                <p>
                    {{$thread->replies_count}} {{  \Str::plural('reply', $thread->replies_count) }}
                </p>
            </div>
            <div class="card-body">
                {{$thread->body}}
            </div>
        </div>
    @endforeach
@endsection
