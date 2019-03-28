<reply :attributes="{{$reply}}" inline-template v-cloak>
    <div class="card mt-2" id="reply{{$reply->id}}">
        <div class="card-header d-flex flex-row justify-content-between">
            <div>
                <a href="/profiles/ {{$reply->owner->name}}"> {{$reply->owner->name}}</a>
                said {{$reply->created_at->diffForHumans()}}s
            </div>
            <favorite :reply="{{$reply}}"></favorite>
        </div>
        <div class="card-body">
            <div v-if="editing">
                <textarea name="" id="" cols="30" rows="10" class="form-control" v-model="body"></textarea>
                <div class="d-flex flex-row justify-content-start">
                    <button class="btn bg-primary text-white" @click="update">Save</button>
                    <button class="btn bg-danger text-white" @click="editing=false">Close</button>
                </div>
            </div>
            <div v-else v-text="body">
            </div>
            <hr>
            <div class="d-flex flex-row justify-content-end">
                @can('update', $reply)

                    <button class="btn btn-link  text-danger "  @click="destroy"><i class="far fa-trash-alt"></i> Delete</button>
                    <button @click="editing = !editing" class="btn btn-link text-success"><i class="far fa-edit"></i>Edit
                    </button>
                @endcan
            </div>
        </div>
    </div>

</reply>
