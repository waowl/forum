<template>
    <button :class="classes" v-text="status" @click="toggle"></button>
</template>
<script>
    export default {
        props: ['active'],
        data() {
            return {
                isActive: this.active
            }
        },
        computed: {
            classes() {
                return [
                    'btn',
                    this.isActive ? 'btn-primary' : 'btn-warning'
                ]
            },
            status() {
                return this.isActive ? 'Unsubscribe' : 'Subscribe'
            }
        },
        methods: {
            toggle() {
                this.isActive ? this.unsubscribe() : this.subscribe()
            },
            subscribe() {
                axios.post(location.pathname + '/subscription')
                    .then(res => {
                        this.isActive = true
                        flash('You subscribed successfully!')
                    })
            },
            unsubscribe() {
                axios.delete(location.pathname + '/subscription')
                    .then(res => {
                        this.isActive = false
                        flash('You unsubscribed successfully!')
                    })
            }
        }
    }
</script>
