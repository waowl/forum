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
@endsection
