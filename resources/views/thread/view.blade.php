@extends('layouts.app')

@section('content')
   <thread inline-template  :initial_count="{{$thread->replies_count}}">
       <div class="row">
           <div class="col-md-8">
               <div class="card mb-2">
                   <div class="card-header d-flex flex-row justify-content-between">
                       <h4>
                           <a href="/profiles/{{$thread->creator->name}}">{{$thread->creator->name}}</a>
                           posted {{$thread->title}}
                       </h4>
                       @can('update', $thread)
                           <span>
                            <form action="{{$thread->path()}}" method="post">
                                @method('delete')
                                @csrf
                                <button type="submit" class="btn btn-link text-danger">Delete</button>
                            </form>
                        </span>
                       @endcan
                   </div>
                   <div class="card-body">
                       {{$thread->body}}
                   </div>
               </div>

               <replies @removed="repliesCount--" @added="repliesCount++" thread_path="{{$thread->path()}}"></replies>

           </div>
           <div class="col-md-4">
               <div class="card">
                   <div class="card-header">
                       Thread Info
                   </div>
                   <div class="card-body">
                       Thread was created {{$thread->created_at->diffForHumans()}} by <a
                           href="">{{$thread->creator->name}}</a>
                       and currently has <span v-text="repliesCount"></span> {{\Str::plural('replies', $thread->replies_count)}}
                   </div>
               </div>
           </div>
       </div>
   </thread>
@endsection
