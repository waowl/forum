<template>
    <button class="btn btn-link" type="submit" @click="toggle"><i
        :class="isFavorited ? 'fas fa-heart text-danger' : 'far fa-heart text-danger' "></i>  <span v-text="count"></span>
    </button>
</template>

<script>
    export default {
        props: ['reply'],
        data () {
            return {
                count: this.reply.favorites_count ? this.reply.favorites_count  : 0,
                isFavorited: this.reply.isFavorited
            }
        },
        methods: {
            favorite() {
                axios.post(`/reply/${this.reply.id}/favorite`)
                    .then(res => {
                        flash(res.data.status);
                        this.isFavorited = true;
                        this.count++;
                    })
            },
            unfavorite() {
                axios.delete(`/reply/${this.reply.id}/favorite`)
                    .then(res => {
                        flash(res.data.status);
                        this.isFavorited = false;
                        this.count--;
                    })
            },
            toggle () {
                if (!this.isFavorited) {
                  this.favorite()
                } else {
                    this.unfavorite()
                }

            }
        }
    }
</script>
<style>


</style>
