<template>
 <div>
        <h3>これはテストページです</h3>
        <video src="/video.mp4" controls></video>
 </div>
</template>

<script>

export default {

    data(){
        return{
            modal: false
        }
    },
 
    methods:{
        onCloseModal(){
            this.modal = false
        }
    },
    
}
</script>