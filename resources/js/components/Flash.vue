<template>
    <div :class="classes" v-show="show">
        {{body}}
    </div>
</template>

<script>
    export default {
        props: ['message'],
        data () {
            return {
                body: '',
                status: '',
                show: false
            }
        },
        computed: {
            classes() {
                return [
                    'alert',
                    'alert-'+this.status
                ]
            }
        },
        methods: {
            flash (data) {
                this.body = data.message
                this.show = true
                this.status = data.status
                this.hide()

            },
            hide () {
                setTimeout(() => {
                    this.show = false
                }, 3000)
            }
        },
        created () {
            if (this.message) {
                this.flash(this.message)
            }

            window.events.$on('flash', data => {
                this.flash(data)
            })
        }
    }
</script>
<style>
    .alert {
        position: fixed;
        right: 20px;
        bottom: 10px;
    }

</style>
