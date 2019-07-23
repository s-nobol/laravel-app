<template>
<div>
    
    <!--モーダルも作成-->
     <div class="modal modal-overlay" @click.self="$emit('close')">
 
        <!--モーダルの中身-->
        <div class="modal-window">
            <div class="modal-content p-3">
                
                    <!--ログイン-->
                    <div v-if="modal === 1">
                    
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
                                        
                    <!--新規登録-->
                    <div v-if="modal === 2">
                    
                        <h3>新規登録</h3>
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
        </div>
    </div>

</div>
</template>



<style type="text/css">

.modal {
    display: flex;
    align-items: center;
    justify-content: center;
    position: fixed;
    z-index: 30;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
  }
</style>

<script>
export default{
    props: {
        modal: {
            type: Number,
            required: true
        }
    },
     data () {
        return {
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
        console.log("モーダル開始状態",this.modal)
    },
    destroyed(){
        this.$emit('close')
    }
}
</script>