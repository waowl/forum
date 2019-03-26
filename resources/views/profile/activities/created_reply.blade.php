<div class="card mb-2">
    <div class="card-header bg-light ">
        {{$user->name}}  <a href="{{$activity->subject->thread->path()}}#reply{{$activity->subject->id}}"> replied </a> thread
    </div>
    <div class="card-body">
        {{$activity->subject->body}}
    </div>
</div>
