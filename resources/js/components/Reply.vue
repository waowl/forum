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
            update() {
                if (this.body) {
                                    }
            },
            destroy(){
                axios.delete(`/reply/${this.attributes.id}`)
                    .then((res) => {
                        $(this.$el).fadeOut(200,()=>{
                            flash(res.data.status);
                        })
                    })

            }
        }
    }
</script>
