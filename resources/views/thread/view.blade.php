@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-2">
                <div class="card-header d-flex flex-row justify-content-between">
                    <h4>
                        <a href="/profiles/{{$thread->creator->name}}">{{$thread->creator->name}}</a> posted {{$thread->title}}
                    </h4>
                    <span>
                        <form action="{{$thread->path()}}" method="post">
                            @method('delete')
                            @csrf
                            <button type="submit" class="btn btn-link text-danger">Delete</button>
                        </form>
                    </span>
                </div>
                <div class="card-body">
                    {{$thread->body}}
                </div>
            </div>
            <h5>---- Replies -----</h5>
            @if(auth()->check())
                <form action="{{$thread->path()}}/reply" method="post" class="form">
                    {{csrf_field()}}
                    <div class="form-group">
                        <textarea name="body" id="body " cols="30" rows="6" class="form-control "
                                  placeholder="Leave your comment here ..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-outline-primary">Save</button>
                </form>
            @else
                <div class="text-center">
                    Please, <a href="/login">sing in</a> to participate in forum.
                </div>
            @endif
            @foreach($replies as $reply)
                @include('thread.reply')
            @endforeach
            {{$replies->links()}}
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Thread Info
                </div>
                <div class="card-body">
                    Thread was created {{$thread->created_at->diffForHumans()}} by <a
                        href="">{{$thread->creator->name}}</a>
                    and currently has {{$thread->replies_count}} {{\Str::plural('replies', $thread->replies_count)}}
                </div>
            </div>
        </div>
    </div>
@endsection
