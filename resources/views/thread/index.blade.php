@extends('layouts.app')

@section('content')
    <h1>Threads</h1>
    @foreach($threads as $thread)
        <div class="card mb-2">
            <div class="card-header">
                <h4>
                    <a href="{{$thread->path()}}">{{$thread->title}}</a>
                </h4>
            </div>
            <div class="card-body">
                {{$thread->body}}
            </div>
        </div>
    @endforeach
@endsection
