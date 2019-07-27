<template>
    <footer class="footer bg-white p-3">
        <div class="container">
        
            <!--<button v-if="isLogin" class="btn" @click="logout">Logout</button>-->
            <!--<RouterLink v-else class="text-primary" to="/login">ログイン : 新規投稿-->
            <!--</RouterLink>-->
            
            <div class="text-center">
                <RouterLink  to="/about">このサイトについて
                </RouterLink>
            </div>
        </div>
    </footer>
  
</template>


<script>

export default {
    computed: {
        apiStatus () {
            return this.$store.state.auth.apiStatus
        },
        isLogin () {
            return this.$store.getters['auth/check']
        }
    },
    methods: {
        async logout () {
            await this.$store.dispatch('auth/logout')
            if (this.apiStatus) {
                // this.$router.push('/login')
            }
        }
    }
}
</script>