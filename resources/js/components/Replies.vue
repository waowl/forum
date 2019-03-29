<template>
    <div>
        <new-reply :thread_path="this.thread_path" @added="addNew"></new-reply>
        <div v-for="(reply, index) in items" :key="reply.id">
            <reply :data="reply" @deleted="remove(index)" ></reply>
        </div>
    </div>
</template>

<script>
    import Reply from './Reply'
    import NewReply from './NewReply'
    export  default {
        components: {
            Reply,
            NewReply
        },
        props: ['data', 'thread_path'],
        data () {
            return {
                items: this.data,
                path: this.thread_path
            }
        },
        methods: {
            remove(index){
                this.items.splice(index, 1);
                this.$emit('removed');
            },
            addNew(reply) {
                this.items.push(reply)
            }
        }
    }
</script>
