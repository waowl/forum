<template>
    <div>
        <div v-if="loggedIn">
            <h5>---- Replies -----</h5>
            <div class="form-group">
                                <textarea name="body" id="body " cols="30" rows="6" class="form-control "
                                          placeholder="Leave your comment here ..." v-model="reply"></textarea>
            </div>
            <button type="submit" class="btn btn-outline-primary" @click="addReply" :disabled="sending">Save</button>
        </div>
        <div class="text-center" v-else>
            Please, <a href="/login">sing in</a> to participate in forum.
        </div>
    </div>
</template>

<script>
    export default {
        props: ['thread_path'],
        data () {
            return {
                reply: '',
                path: this.thread_path + '/reply',
                sending: false
            }
        },
        methods: {
            addReply () {
                if (!!this.reply) {
                    this.sending = true
                    axios.post(this.path, {'body': this.reply})
                        .then(({data}) => {
                            this.reply = ''
                            this.$emit('added', data)
                            flash('Reply was added!')
                            this.sending = false
                        }).catch(err => {
                        flash(err.response.data, 'danger')
                        this.sending = false
                    })
                }
            }
        },
        computed: {
            loggedIn () {
                return !!window.App.user
            }
        }
    }
</script>
