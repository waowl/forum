@extends('layouts.app')

@section('content')
    <div class="card mb-2">
        <div class="card-header">
            <h4>
                Create a new thread.
            </h4>
        </div>
        @if(count($errors))
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </div>
        @endif
        <div class="card-body">
            <form action="{{route('thread.store')}}" method="post" class="form">
                {{csrf_field()}}
                <div class="form-group">
                    <select class="form-control" name="channel_id" id="catid">
                        <option value="0" disabled selected="selected">--Select a Channel--</option>
                        @foreach($channels as $channel)
                            <option value="{{$channel->id}}" {{(old('channel_id') == $channel->id) ? 'selected' : ''}}>{{$channel->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" value="{{old('title')}}" name="title" class="form-control"
                           placeholder="Thread title">
                </div>
                <div class="form-group">
                    <textarea name="body" id="body " cols="30" rows="6" class="form-control "
                              placeholder="{{old('body') ?? 'Thread body'}}"></textarea>
                </div>
                <button type="submit" class="btn btn-outline-primary">Save</button>
            </form>
        </div>
    </div>
@endsection
