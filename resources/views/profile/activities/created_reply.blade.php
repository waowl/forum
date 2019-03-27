<div class="card mb-2">
    <div class="card-header bg-primary text-white ">
        {{$user->name}}  <a href="{{$activity->subject->path()}}" class="text-white"> replied </a> thread
    </div>
    <div class="card-body">
        {{$activity->subject->body}}
    </div>
</div>
