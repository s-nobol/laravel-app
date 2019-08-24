<template>
<div class=" m-auto " id="edit-form">

    
        <form  v-if="! token" class="form mt-5 card p-3 " @submit.prevent="sendaEmail">        
            <h4>パスワード再設定</h4>
            
            
          
            
            <!--メールアドレス-->
            <div class="mt-2">
                <label  v-if="! emailErrors" for="login-email">メールアドレス</label></br>
                
                <!--エラーメッセージ-->
                <div v-if="emailErrors" class="errors text-danger mt-2">
                    <span class="text-gander">{{ emailErrors }}</span>
                </div>
            
                <input type="email"  v-model="sendEmailForm.email" 
                class="w-100 border p-2" :class="{ 'border border-danger': emailErrors }">
            </div>
            
            
            <!--送信ボタン-->
            <div class="mt-2 text-right">
                <button type="submit"  class="btn btn-primary">送信</button>
            </div>
        </form>
        
        
        
        
        <form v-if="token" class="form mt-5 card p-3 "  @submit.prevent="passwordReset">
            <h3>パスワード</h3>
            
            <!--エラーなし-->
            <div v-if="! Errors">
                <!--メールアドレス-->
                <div class="mt-2">
                    <label>メールアドレス</label></br>
                    <input type="email"  v-model="passwordResetForm.email"class="form-control w-100"   >
                </div>
                
                <!--パスワード-->
                <div class="mt-2">
                    <label>パスワード</label></br>
                    <input type="text" name="password"class="form-control w-100"  
                    v-model="passwordResetForm.password" >
                </div>
                
                
                <!--パスワード確認-->
                <div class="mt-2">
                    <label>パスワード（再確認）</label></br>
                    <input type="password"  v-model="passwordResetForm.password_confirmation" 
                    class="form-control w-100"  >
                </div>
            </div>
            
            <!--エラーあり-->
            <div v-if="Errors">
                <!--メールアドレス-->
                <div class="mt-2">
                    <label>メールアドレス</label></br>
                     <div v-if="Errors.email" class="errors text-danger mt-2">
                        <span v-for="msg in Error.email"  :key="msg" class="text-danger">{{ msg }}</span>
                    </div>
                    
                    <input type="email"  v-model="passwordResetForm.email" 
                    class="form-control w-100"  :class="{ 'border border-danger': Errors.email }">
                </div>
                
                <!--パスワード-->
                <div class="mt-2">
                    <label>パスワード</label></br>
                     <div v-if="Errors.password" class="errors text-danger mt-2">
                        <span v-for="msg in Errors.password"  :key="msg" class="text-danger">{{ msg }}</span>
                    </div>
                    <input type="text" name="password" v-model="passwordResetForm.password" 
                    class="form-control w-100"  :class="{ 'border border-danger': Errors.password  }">
                </div>
                
                
                <!--パスワード確認-->
                <div class="mt-2">
                    <label>パスワード（再確認）</label></br>
                    <input type="password"  v-model="passwordResetForm.password_confirmation" 
                    class="form-control w-100"   :class="{ 'border border-danger': Errors.password   }">
                </div>
            </div>
            
            
            <!--送信ボタン-->
            <div class="mt-2 text-right">
                <button type="submit"  class="btn btn-primary">送信</button>
            </div>
        </form>
</div>
</template>

<script>

// import Modal from '../components/modal/Modal.vue'


export default {
    // components:{Modal},
    props: {
        token: {
             type: String,
             required: false
        }
    },
    data(){
        return{
            sendEmailForm:{
                email: '',
            },
            passwordResetForm:{
                token: '',
                email: '',
                password: '',
                password_confirmation: '',
            },
            emailErrors: '',
            Errors: null,
        }
    },

    methods:{
        async sendaEmail(){
            
            // コントローラーにEmail送信
            console.log("パスワード送信" , this.sendEmailForm)
            
            const response = await axios.post('/api/password/email', this.sendEmailForm)
            console.log("パスワード送信",response)
            
            if(response.status === 200 ){
                //フラッシュを作成（info）
                this.$store.commit('message/setContent', {
                        content: 'メールが送信されました確認してください',
                        type: 'info',
                        timeout: 3000
                })
                this.$router.push('/')
            }
            
            // バリテーションエラー
            if(response.status === 422 ){
                this.emailErrors = response.data
                return false
            }
            if(response.status !== 200 ){
                //フラッシュを作成（info）
                this.$store.commit('message/setContent', {
                        content: 'メールの送信ができません',
                        type: 'danger',
                        timeout: 3000
                })
            }
        },
        async passwordReset(){
            
            // トークンを取得
            this.passwordResetForm.token = this.token
            // this.passwordResetForm.email = this.$route.query.email
            const response = await axios.post('/api/password/reset', this.passwordResetForm)
            console.log("パスワード送信",response)
            
            if(response.status === 200 ){
                //フラッシュを作成（success）
                this.$store.commit('message/setContent', {
                        content: 'パスワードを更新しました',
                        type: 'success',
                        timeout: 3000
                })
                
                // この後ログインする
                this.$store.dispatch('auth/currentUser')
                this.$router.push('/')
                window.location.reload();
            }
            
            // バリテーションエラー
            if(response.status === 422 ){
                this.Errors = response.data.errors
            }
            if(response.status === 403 ){
                
                //フラッシュを作成（success）
                this.$store.commit('message/setContent', {
                        content: 'パスワードを更新できませんでした',
                        type: 'danger',
                        timeout: 3000
                })
                
                // この後ログインする
                this.$router.push('/')
            }
        },
    }, 
    created(){
        console.log("トークン",this.token)
        
    }
    // ウォッチャーを使って変更する
}
</script>