<template>
    <div>
        <new-reply :thread_path="this.thread_path" @added="addNew"></new-reply>
        <div v-for="(reply, index) in items" :key="reply.id">
            <reply :data="reply" @deleted="remove(index)" ></reply>
        </div>
        <paginator :dataSet="dataSet" @updated="fetch"></paginator>
    </div>
</template>

<script>
    import collection from '../mixins/collection'
    import Reply from './Reply'
    import NewReply from './NewReply'
    export  default {
        mixins: [collection],
        components: {
            Reply,
            NewReply
        },
        props: ['thread_path'],
        data () {
            return {
                dataSet: [],
                path: this.thread_path
            }
        },
        methods: {

            fetch(page) {
                axios.get(this.url(page))
                    .then(res => {
                        this.dataSet = res.data;
                        this.items = res.data.data;
                    })
            },
            url(page = 1) {
                return this.path + '/reply?page=' + page
            }
        },
        created() {
            this.fetch()
        }

    }
</script>
