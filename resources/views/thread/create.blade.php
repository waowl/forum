@extends('layouts.app')

@section('content')
        <div class="card mb-2">
            <div class="card-header">
                <h4>
                    Create a new thread.
                </h4>
            </div>
            <div class="card-body">
                <form action="{{route('thread.store')}}" method="post" class="form">
                    {{csrf_field()}}
                    <div class="form-group">
                        <input type="text" name="title" class="form-control" placeholder="Thread title">
                    </div>
                    <div class="form-group">
                        <textarea name="body" id="body "cols="30" rows="6" class="form-control " placeholder="Thread body"></textarea>
                    </div>
                    <button type="submit" class="btn btn-outline-primary">Save</button>
                </form>
            </div>
        </div>
@endsection
