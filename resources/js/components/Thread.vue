<script>
    import Replies from './Replies'
    export default {
    components: {
        Replies
    },
        props: ['initial_count'],
        data () {
                return {
                    repliesCount: this.initial_count
                }
        }
    }
</script>
