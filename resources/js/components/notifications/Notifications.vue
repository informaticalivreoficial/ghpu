<template>
    <div>
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-comments"></i>
                <span class="badge badge-danger navbar-badge">({{notifications.lenght}})</span>
            </a>

            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="#" class="dropdown-item" v-for="notification in notifications" :key="notification">                
                    <div class="media">
                        <img src="" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                            {{notification}}
                            </h3>
                            <p class="text-sm">Call me whenever you can...</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>                
                </a>

                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">Ver Todas as Mensagens</a>
            </div>
        </li>
    </div>
</template>

<script>
export default {
    created() {
        this.loadNotifications()
    },
    computed:{

        notifications () {
            return this.notifications
        },

        data () {
            return {
                notificationsItens: []
            }
        },

        methods: {
            loadNotifications () {
                axios.get('/admin/notifications').then(response => {
                    console.log(response)
                })
            }
        },
    }    
}
</script>