<template>
<div>
    <h1>Admin.vue</h1>
    
    <div class="row">
        
        <!--メニュ-->
        <div class="col-3 bg-white">
            <p :class="{ 'text-primary' : tab === 0}" @click="tab = 0">メニュー</p>
            <p :class="{ 'text-primary' : tab === 1}" @click="tab = 1">データベース</p>
            <p :class="{ 'text-primary' : tab === 2}" @click="tab = 2">設定</p>
        </div>
        
        <!--view-->
        <div class="col-9 bg-white">
        
            <!--タブ1-->
            <div v-if=" tab === 0">
                <h3>メニュー</h3>
            </div>
            
            <!--タブ2-->
            <div v-if=" tab === 1">
                <DataBase />
            </div>
            <!--タブ3-->
            <div v-if=" tab === 2">
            
            </div>
            
        </div>
    </div>
    

</div>
</template>

<script>

import DataBase from '../components/DataBase.vue'

export default {
    components:{ DataBase },
    data(){
        return{
            tab: 1,
            posts: null,
        }
    },
    methods:{
    
        async getPost(){
        },
        
    
    },
}
</script>