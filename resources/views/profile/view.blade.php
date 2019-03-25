@extends('layouts.app');

@section('content');
<div class="page-header">
    <h1>
        {{$user->name}}
    </h1>
    <span>Since {{$user->created_at->diffForHumans()}}</span>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pills-threads-tab" data-toggle="pill" href="#pills-threads" role="tab"
                   aria-controls="pills-home" aria-selected="true">Threads</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab"
                   aria-controls="pills-profile" aria-selected="false">Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab"
                   aria-controls="pills-contact" aria-selected="false">Contact</a>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-threads" role="tabpanel" aria-labelledby="pills-home-tab">
                @foreach($threads as $thread)
                    <div class="card mb-2">
                        <div class="card-header d-flex flex-row justify-content-between">
                                 <h4>
                                    {{$user->name}} posted:  <a href="/thread/{{$thread->channel->slug}}/{{$thread->id}}">
                                         {{$thread->title}}
                                     </a>
                                 </h4>
                            <span>
                                {{$thread->created_at->diffForHumans()}}
                            </span>
                        </div>
                        <div class="card-body">
                            {{$thread->body}}
                        </div>
                    </div>
                @endforeach
                {{$threads->links()}}
            </div>
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">2</div>
            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">3</div>
        </div>
    </div>
</div>
@endsection
