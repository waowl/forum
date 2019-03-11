@extends('layouts.app')

@section('content')
    <h1>Threads</h1>
    <div class="card mb-2">
        <div class="card-header">
            <h4>
                {{$thread->title}}
            </h4>
        </div>
        <div class="card-body">
            {{$thread->body}}
        </div>
    </div>
    <h5>---- Replies -----</h5>
    @foreach($thread->replies as $reply)
        <div class="card mt-2">
            <div class="card-header">
                <a href=""> {{$reply->owner->name}}</a> said  {{$reply->created_at->diffForHumans()}}
            </div>
            <div class="card-body">
                {{$reply->body}}
            </div>
        </div>
    @endforeach
@endsection
