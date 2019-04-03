<template>
    <li class="nav-item dropdown" v-if="notifications.length">
        <a class="nav-link " href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
           aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-bell text-success"></i>
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <li v-for="notification in notifications">
                <a class="dropdown-item" :href="notification.data.link" @click="markAsRead(notification)" v-text="notification.data.message"></a>
            </li>
        </ul>
    </li>
</template>

<script>
    export default {
        name: 'Notifications',
        data() {
            return {
                notifications: []
            }
        },
        methods: {
          markAsRead(notification) {
              axios.delete('/profiles/'+window.App.user.name+'/notifications/'+notification.id)
          }
        },
        created() {
            axios.get('/profiles/'+window.App.user.name+'/notifications')
                .then(res=> this.notifications = res.data)
        }
    }
</script>

<style scoped>

</style>
