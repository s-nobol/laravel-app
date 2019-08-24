<template>
<div>
    <!--<h1>Admin.vue</h1>-->
    
        
    <!--メニュ-->
    <div class="">
        <!--<span :class="{ 'text-primary' : tab === 0}" @click="tab = 0">user</span>-->
        <!--<span :class="{ 'text-primary' : tab === 1}" @click="tab = 1">post</span>-->
        <!--<span :class="{ 'text-primary' : tab === 2}" @click="tab = 2">comment</span>-->
        <!--<span :class="{ 'text-primary' : tab === 3}" @click="tab = 3">like</span>-->
        <span v-for="table in tables"
            class ="m-2"
            :class="{ 't' : tab === 0}"
            @click="getDataBase(table.name)">{{ table.name }}</span>
    </div>
    
    <!--view-->
    <div class="">
        
        <div>
        
            <!--テーブル1-->
            <table class="table table-striped">
            
                <!--テーブルヘッダー-->
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        <!--<th scope="col">First</th>-->
                        <!--<th scope="col">Last</th>-->
                        <!--<th scope="col">Handle</th>-->
                    </tr>
                </thead>
                
                <!--テーブルボディ-->
                <tbody>
                    <tr v-for="item in items">
                        <th scope="row">{{ item.id }}</th>
                        <td v-if="item.name">{{ item.name }}</td>
                        <td v-if="item.email">{{ item.email }}</td>
                        <td v-if="item.title">{{ item.title }}</td>
                        <td v-if="item.description">{{ item.description }}</td>
                        <td v-if="item.post_id">{{ item.post_id }}</td>
                        <td v-if="item.user_id">{{ item.user_id }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
            
    </div>
    

</div>
</template>

<script>


export default {
    data(){
        return{
            tab: 0,
            tables:[
                { name: 'users' },
                { name: 'posts' },
                { name: 'comments' },
                { name: 'likes' },
                ], //テーブルのID
            items: null,
        }
    },
    methods:{
    
        async getDataBase(name){
            
            // const name = "users"
            // const name = "posts"
            const response = await axios.get(`/api/db/${name}`)
            console.log("記事を一覧受信",response)
            if (response.status === 200) {
                this.items = response.data
            }
        },
        
    
    },
    created(){
        
    }
    
}
</script>