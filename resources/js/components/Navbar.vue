<template>
    <nav class="navbar bg-white">
    
        <div class="container ">
            <RouterLink class="navbar__brand" to="/">
              Vuesplash
            </RouterLink>
            
            <div class="">
                <button v-if="isLogin"  class="btn btn-primary">
                    <i class=""></i>
                    Submit a photo
                </button>
                <span v-if="isLogin" class="navbar__item">{{ username }}</span>
                
                <div v-else class="">
                    <RouterLink class="text-primary" to="/login">
                    ログイン : 新規投稿
                    </RouterLink>
                </div>
            </div>
        
        </div>
    </nav>
</template>

<script>

export default {
    computed:{
        isLogin () {
            return this.$store.getters['auth/check']
        },
        username () {
            return this.$store.getters['auth/username']
        }
    }
}
</script>