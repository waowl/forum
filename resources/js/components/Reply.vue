<template>
    <div class="card mt-2" :id="'reply'+reply.id">
        <div class="card-header d-flex flex-row justify-content-between">
            <div>
                <a :href="'/profiles/'+reply.owner.name" v-text="reply.owner.name"> </a>
                said <span v-text="ago"></span>
            </div>
            <div v-if="signedIn">
                <favorite :reply="reply"></favorite>
            </div>
        </div>
        <div class="card-body">
            <div v-if="editing">
                <textarea name="" id="" cols="30" rows="10" class="form-control" v-model="body"></textarea>
                <div class="d-flex flex-row justify-content-start">
                    <button class="btn bg-primary text-white" @click="update">Save</button>
                    <button class="btn bg-danger text-white" @click="editing=false">Close</button>
                </div>
            </div>
            <div v-else v-text="this.body">
            </div>
            <hr>
            <div class="d-flex flex-row justify-content-end" v-if="canUpdate">

                <button class="btn btn-link  text-danger " @click="destroy"><i class="far fa-trash-alt"></i> Delete
                </button>
                <button @click="editing = !editing" class="btn btn-link text-success"><i class="far fa-edit"></i>Edit
                </button>
            </div>
        </div>
    </div>
</template>
<script>
    import moment from 'moment'
    import Favorite from './Favorite'

    export default {
        components: {
            Favorite
        },
        props: ['data'],
        data () {
            return {
                reply: this.data,
                body: this.data.body,
                editing: false,
            }
        },

        methods: {
            update () {
                if (this.body) {
                    axios.patch(`/reply/${this.data.id}`, {'body': this.body})
                        .then((res) => {
                            this.editing = false
                            flash(res.data.status)
                        }).catch(err => {
                        flash(err.response.data, 'danger')
                    })
                }
            },
            destroy () {
                axios.delete(`/reply/${this.data.id}`)
                    .then((res) => {
                        this.$emit('deleted', this.data.id)
                        flash(res.data.status)

                    })
            }
        },
        computed: {
            signedIn () {
                return window.App.signedIn
            },
            ago () {
                return moment(this.reply.created_at).fromNow()
            },
            canUpdate () {
                if (window.App.user) {
                    return this.data.owner.id == window.App.user.id
                }
                return false
            }
        }
    }
</script>
