<script>
    import Favorite from  './Favorite'
    export default {
        props: ['attributes'],
        data () {
            return {
                body: this.attributes.body,
                editing: false
            }
        },

        methods: {
            update () {
                if (this.body) {
                    axios.patch(`/reply/${this.attributes.id}`, {'body': this.body})
                        .then((res) => {
                            this.editing = false
                            flash(res.data.status)

                        })
                }
            },
            destroy () {
                axios.delete(`/reply/${this.attributes.id}`)
                    .then((res) => {
                        this.$emit('deleted', this.data.id)
                        flash(res.data.status)

                    })
            }
        },
        computed: {
            signedIn(){
                return window.App.signedIn;
            },
            canUpdate(){
                if( window.App.user) {
                    return this.data.owner.id == window.App.user.id;
                }
                return false
            }
        }
    }
</script>
