<div class="card mb-2">
    <div class="card-header bg-light ">
        {{$user->name}} published <a href="{{$activity->subject->path()}}"> {{$activity->subject->title}} </a>
    </div>
    <div class="card-body">
        {{$activity->subject->body}}
    </div>
</div>
