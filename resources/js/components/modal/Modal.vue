<template>
<div>
    
    <!--モーダルも作成-->
    <div class="modal modal-overlay" @click.self="$emit('close')">
 
        <!--モーダルの中身-->
        <div class="modal-window w-25">
            <div class="modal-content p-3">
                
                    <!--ログイン-->
                    <div v-if="modal === 1">
                        <form class="form" @submit.prevent="login">
                        
                            <h3>ログイン</h3>
                            
                            <!--エラーメッセージ-->
                            <!--<div v-if="loginErrors" class="errors text-danger mt-2">{{ loginErrors }}-->
                            <!--    <ul v-if="loginErrors.email">-->
                            <!--        <li v-for="msg in loginErrors.email" :key="msg">{{ msg }}</li>-->
                            <!--    </ul>-->
                            <!--    <ul v-if="loginErrors.password">-->
                            <!--        <li v-for="msg in loginErrors.password" :key="msg">{{ msg }}</li>-->
                            <!--    </ul>-->
                            <!--</div>-->
                            
                            <!--エラーなし-->
                            <div v-if="! loginErrors" > 
                                <div  class="mt-2">
                                    <label for="login-email">メールアドレス</label></br>
                                    <input type="text"  v-model="loginForm.email" 
                                    class="w-100 border p-2">
                                </div>
                    
                                <div class="mt-2">
                                    <label for="login-password">パスワード</label>
                                    <small class="text-primary" @click="onResetPassword">パスワードを忘れた</small>
                                    <input type="password"  v-model="loginForm.password"  
                                    class="w-100 border p-2">
                                </div>
                            </div>
                           
                            
                            <!--エラーあり-->
                            <div v-if="loginErrors" class=" mt-2">
                                <div class="mt-3">
                                    <div v-if="loginErrors.email">
                                        <span v-for="msg in loginErrors.email" :key="msg" class="text-danger">{{ msg }}</span>
                                    </div>
                                    <label v-if="! loginErrors.email">メールアドレス</label>
                                    <input type="text"  v-model="loginForm.email"  class="w-100 border p-2"
                                    :class="{ 'border border-danger' : loginErrors.email }">
                                </div>
                                
                                
                                <div class="mt-3">
                                    <div v-if="loginErrors.password">
                                        <span v-for="msg in loginErrors.password" :key="msg" class="text-danger">{{ msg }}</span>
                                    </div>
                                    <label v-if="! loginErrors.password">パスワード
                                    <small class="text-primary" @click="onResetPassword">パスワードを忘れた</small>
                                    </label>
                                    <input type="password"  v-model="loginForm.password" class="w-100 border p-2"
                                    :class="{ 'border border-danger' : loginErrors.password }">
                                </div>
                                
                            </div>
                            
                            <div class="mt-2 text-right">
                                <button type="submit"  class="btn btn-primary">login</button>
                            </div>
                            
                            <!--新規登録へボタン-->
                            <!--<div class="text-center">-->
                                <!--<p >またわ</p>-->
                                <!--<button class="btn btn-primary " @click="modal = 2">新規登録</button>-->
                            <!--</div>-->
                      </form>
                    </div>
                    
                    
                                        
                    <!--新規登録-->
                    <div v-if="modal === 2">
                    
                        <h3>新規登録</h3>
                        <form class="form" @submit.prevent="register">
                    
                            <!--エラーメッセージ-->
                            <!--<div v-if="registerErrors" class="errors mt-2 text-danger">{{ registerErrors }}-->
                                <!--<ul v-if="registerErrors.name">-->
                                <!--    <li v-for="msg in registerErrors.name" :key="msg">{{ msg }}</li>-->
                                <!--</ul>-->
                                <!--<ul v-if="registerErrors.email">-->
                                <!--    <li v-for="msg in registerErrors.email" :key="msg">{{ msg }}</li>-->
                                <!--</ul>-->
                                <!--<ul v-if="registerErrors.password">-->
                                <!--    <li v-for="msg in registerErrors.password" :key="msg">{{ msg }}</li>-->
                                <!--</ul>-->
                            <!--</div>-->
                        
                            <!--エラーなし-->
                            <div  v-if="! registerErrors" >
                                <div class="mt-2">
                                    <label for="username">名前</label></br>
                                    <input type="text"  v-model="registerForm.name" class="w-100 p-2">
                                </div>
                                
                                <div class="mt-2">
                                    <label for="email">メールアドレス</label></br>
                                    <input type="text" v-model="registerForm.email" class="w-100 p-2">
                                </div>
                                
                                <div class="mt-2">
                                    <label for="password">パスワード</label></br>
                                    <input type="password" v-model="registerForm.password" class="w-100 p-2">
                                </div>
                                
                                <div class="mt-2">
                                    <label for="password-confirmation">パスワード(再確認)</label></br>
                                    <input type="password" v-model="registerForm.password_confirmation" class="w-100 p-2">
                                </div>
                            </div>
                            
                            
                            <!--エラーあり-->
                            <div  v-if="registerErrors" >
                            
                                <!--名前-->
                                <div class="mt-3">
                                    <div v-if="registerErrors.name">
                                        <span v-for="msg in registerErrors.name" :key="msg" class="text-danger">{{ msg }}</span>
                                    </div>
                                    <label v-if="! registerErrors.name">名前</label>
                                    <input type="text"  v-model="registerForm.name"  class="w-100 border p-2"
                                    :class="{ 'border border-danger' : registerErrors.name }">
                                </div> 
                                
                                
                                <!--メール-->
                                <div class="mt-3">
                                    <div v-if="registerErrors.email">
                                        <span v-for="msg in registerErrors.email" :key="msg" class="text-danger">{{ msg }}</span>
                                    </div>
                                    <label v-if="! registerErrors.email">メールアドレス</label>
                                    <input type="text"  v-model="registerForm.email"  class="w-100 border p-2"
                                    :class="{ 'border border-danger' : registerErrors.email }">
                                </div>
                                
                                <!--パスワード-->
                                <div class="mt-3">
                                    <div v-if="registerErrors.password">
                                        <span v-for="msg in registerErrors.password" :key="msg" class="text-danger">{{ msg }}</span>
                                    </div>
                                    <label v-if="! registerErrors.password">パスワード</label>
                                    <input type="password"  v-model="registerForm.password" class="w-100 border p-2"
                                    :class="{ 'border border-danger' : registerErrors.password }">
                                </div>
                                
                                <!--パスワード再確認-->
                                <div class="mt-3">
                                    <label v-if="! registerErrors.password">パスワード(再確認)</label>
                                    <input type="password"  v-model="registerForm.password_confirmation" class="w-100 border p-2"
                                    :class="{ 'border border-danger' : registerErrors.password }">
                                </div>
                            </div>
                            
                            <div class="mt-2 text-right">
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
                password: '123123123',
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
            this.clearError()
            // authストアのloginアクションを呼び出す
            await this.$store.dispatch('auth/login', this.loginForm)
            
            if (this.apiStatus) {
                console.log("close")
                this.$emit('close')
                // メッセージ登録
                this.$store.commit('message/setContent', {
                        content: 'ログインしました！',
                        type: 'info',
                        timeout: 5000
                })
            }
        },
        async register () {
            this.clearError()
            // authストアのresigterアクションを呼び出す
            await this.$store.dispatch('auth/register', this.registerForm)
            
            if (this.apiStatus) {
                console.log("close")
                this.$emit('close')
                // メッセージ登録
                this.$store.commit('message/setContent', {
                        content: 'ユーザーが登録されました！',
                        type: 'info',
                        timeout: 5000
                })
            }
        },
        
        onResetPassword(){
            this.$emit('close')
            this.$router.push('/password_reset')
        },
        clearError () {
            this.$store.commit('auth/setLoginErrorMessages', null)
        }
    },
    created () {
        this.clearError()
    },
    destroyed(){
        this.$emit('close')
    }
}
</script>