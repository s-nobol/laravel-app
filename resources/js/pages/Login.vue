<template>
  <div class="">
      <div>
          <span @click="tab = 1" :class="{ 'text-primary' :  tab === 1 }">ログイン</span>
          <span @click="tab = 2" :class="{ 'text-primary' :  tab === 2 }">新規登録</span>
      </div>
    
        
        <!--ログインフォーム-->
        <div class="panel" v-show="tab === 1">
            <form class="form" @submit.prevent="login">
            
            <!--エラーメッセージ-->
            <div v-if="loginErrors" class="errors text-danger mt-2">
                <ul v-if="loginErrors.email">
                    <li v-for="msg in loginErrors.email" :key="msg">{{ msg }}</li>
                </ul>
                <ul v-if="loginErrors.password">
                    <li v-for="msg in loginErrors.password" :key="msg">{{ msg }}</li>
                </ul>
            </div>
            
                <div class="mt-2">
                    <label for="login-email">メールアドレス</label></br>
                    <input type="text"  v-model="loginForm.email">
                </div>

                <div class="mt-2">
                    <label for="login-password">Password</label></br>
                    <input type="password"  v-model="loginForm.password">
                </div>
                
                <div class="mt-2">
                    <button type="submit"  class="btn btn-primary">login</button>
                </div>
            </form>
        </div>
        
        
        <!--新規登録フォーム-->
        <div class="panel" v-show="tab === 2">
            <form class="form" @submit.prevent="register">
            
                <!--エラーメッセージ-->
                <div v-if="registerErrors" class="errors mt-2 text-danger">
                    <ul v-if="registerErrors.name">
                        <li v-for="msg in registerErrors.name" :key="msg">{{ msg }}</li>
                    </ul>
                    <ul v-if="registerErrors.email">
                        <li v-for="msg in registerErrors.email" :key="msg">{{ msg }}</li>
                    </ul>
                    <ul v-if="registerErrors.password">
                        <li v-for="msg in registerErrors.password" :key="msg">{{ msg }}</li>
                    </ul>
                </div>
            
                <div class="mt-2">
                    <label for="username">名前</label></br>
                    <input type="text"  v-model="registerForm.name">
                </div>
                
                <div class="mt-2">
                    <label for="email">メールアドレス</label></br>
                    <input type="text" v-model="registerForm.email">
                </div>
                
                <div class="mt-2">
                    <label for="password">Password</label></br>
                    <input type="password" v-model="registerForm.password">
                </div>
                
                <div class="mt-2">
                    <label for="password-confirmation">Password (再確認)</label></br>
                    <input type="password" v-model="registerForm.password_confirmation">
                </div>
                
                <div class="mt-2">
                    <button type="submit" class="btn btn-primary">登録</button>
                </div>
            </form>
        </div>
    
    </div>
</template>


<script>

export default {
    data () {
        return {
            tab: 1,
            loginForm: {
                email: '123@example.com',
                password: '123123123'
            },      
            registerForm: {
                name: '123',
                email: '123@example.com',
                password: '123123123',
                password_confirmation: '123123123'
            }
        }
    },
    computed: {
        apiStatus () {
            return this.$store.state.auth.apiStatus
        },
        loginErrors () {
            return this.$store.state.auth.loginErrorMessages
        },
        registerErrors () {
            return this.$store.state.auth.registerErrorMessages
        }
    },
    methods: {
        async login () {
            // authストアのloginアクションを呼び出す
            await this.$store.dispatch('auth/login', this.loginForm)
            
            if (this.apiStatus) {
                this.$router.push('/')
            }
        },
        async register () {
            // authストアのresigterアクションを呼び出す
            await this.$store.dispatch('auth/register', this.registerForm)
            
            if (this.apiStatus) {
                this.$router.push('/')
            }
        },
        clearError () {
            this.$store.commit('auth/setLoginErrorMessages', null)
        }
    },
    created () {
        this.clearError()
    }
}
</script>