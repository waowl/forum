<script>
    import Replies from './Replies'
    import  SubscribeButton from './SubscribeButton'
    export default {
    components: {
        Replies,
        SubscribeButton
    },
        props: ['initial_count'],
        data () {
                return {
                    repliesCount: this.initial_count
                }
        }
    }
</script>
