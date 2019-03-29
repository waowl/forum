<script>
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
                        $(this.$el).fadeOut(200, () => {
                            flash(res.data.status)
                        })
                    })

            }
        }
    }
</script>
