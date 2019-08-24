<template>
<div>
    
    <!--モーダルも作成-->
    <div class="modal modal-overlay" @click.self="$emit('close')">
 
        <!--モーダルの中身-->
        <div class="modal-window w-50">
            <div class="modal-content p-3">
                 <form class="form text-left" @submit.prevent="report">
                        
                            <h3><i class="fas fa-exclamation-triangle text-danger mr-2"></i>通報する</h3>
                    
                            
                            <!--セレクトボックス-->
                            <div  class="mt-2">
                                <label for="login-email">カテゴリー</label></br>
                                <select class="p-1" v-model="reportForm.category">
                                    <option value="不適切な写真">不適切な写真</option>
                                    <option value="個人情報を含む">個人情報を含む</option>
                                    <option value="特定の宗教、団体を誹謗中傷している">特定の宗教、団体を誹謗中傷している</option>
                                    <option value="ガイドラインに違反する年齢である">ガイドラインに違反する年齢である</option>
                                    <option value="その他">その他</option>
                                </select>
                            </div>
                            
                            <!--エラーなし-->
                            <div v-if="! reportErrors" >
                                <div  class="mt-2">
                                    <label for="login-email">件名</label></br>
                                    <input type="text" v-model="reportForm.title" 
                                    class="form-control border p-1">
                                </div>
                    
                                <div class="mt-2">
                                    <label for="login-password">内容</label>
                                    <textarea class="form-control border p-1" 
                                    rows="4"  v-model="reportForm.description"></textarea>
                                </div>
                            </div>
                           
                            
                            <!--エラーあり-->
                            <div v-if="reportErrors" class=" mt-2">
                            
                            
                                <div class="mt-3">
                                    <div v-if="reportErrors.title">
                                        <span v-for="msg in reportErrors.title" :key="msg" class="text-danger">{{ msg }}</span>
                                    </div>
                                    <div  class="">
                                        <label v-if="! reportErrors.title" for="login-email">件名</label>
                                        <input type="text" v-model="reportForm.title" 
                                        class="form-control border p-1" :class="{ 'border border-danger' : reportErrors.title }" >
                                    </div>
                                </div>
                                
                                
                                <div class="mt-3">
                                    <div v-if="reportErrors.description">
                                        <span v-for="msg in reportErrors.description" :key="msg" class="text-danger">{{ msg }}</span>
                                    </div>
                                     <div  class="">
                                        <label v-if="! reportErrors.description"  for="login-email">説明</label>
                                        <textarea rows="4" v-model="reportForm.description" 
                                         class="form-control border p-1"  :class="{ 'border border-danger' : reportErrors.description }"></textarea>
                                    </div>
                                </div>
                            
                            </div>
                            
                            <div class="mt-2 text-right">
                                <button type="submit"  class="btn btn-danger">通報する</button>
                            </div>
                    </form>
                    
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
        id: {
            type: String,
            required: true
        }
    },
    data () {
        return {
            reportForm: {
                post_id: '',
                category: '不適切な写真',
                title: '',
                description: ''
            }, 
            reportErrors: null
            
        }
    },
    methods: {
        async report () {
            
            
            var result = confirm("本当に通報しますか？")
            if(! result){
                this.$emit('close')
                return false
            }
            
            this.reportForm.post_id = this.id
            const  response = await axios.post(`/api/reports`, this.reportForm)
            
            console.log("通報する", response)
            // バリテーションエラー
            if (response.status === 422 ) {
                this.reportErrors = response.data.errors
            }
            if (response.status === 200 ) {
                 this.$store.commit('message/setContent', {
                        content: '通報しました！',
                        type: 'danger',
                        timeout: 3000
                })
                this.$emit('close')
            }
        },
        
        clearError () {
            // this.$store.commit('auth/setreportErrorMessages', null)
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