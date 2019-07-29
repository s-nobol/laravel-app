<template>
 <div>
        <h3>これはテストページです</h3>
        <!--<video src="/move2.mp4#t=5,10" style="max-height: 400px;" id="video" controls></video>-->
        
        <div style="width:400px; background-color: white ;">
        
            <!--シーダー-->
            <!--<div class="form-group p-0" style="width: 120px; ">-->
            <!--    <input type="range" class="custom-range" min="0"  :max="max" -->
            <!--    :value="Time" @change="onChangeRange" >-->
            <!--</div>-->
             
            <!--<button @click="onVideo">再生</button>-->
        
        </div>
        
        <button @click="onslider">onslider</button>
        
            
        <transition name="slide_down">
            <div v-if="slider"class="menu_slide_accordion" >
                <div>123131321321</div>
            </div>
        </transition>
</div>
</template>

<style type="text/css">
.cls_toggle_expand_collapse {
    margin  : 4px;
    padding : 8px;
    cursor  : pointer;
    background-color: aquamarine
}

/*
 * Slide / accordionメニューの設定
 */ 
.menu_slide_accordion {
    background-color: antiquewhite;
    height: 120px;
    overflow: hidden;
}

.slide_down-enter-active, .slide_down-leave-active {
    transition: all .5s;
}
.slide_down-enter, .slide_down-leave-to {
    height: 0;
}
</style>

<script>

export default {

    data(){
        return{
            play: false,
            max: 0,
            Time: 0, 
            slider: null
        }
    },
 
    methods:{
        // onVideo(){
        //     // console.log("this", this.play)
        //     if(this.play){
        //         this.pauseVideo()
        //     }else{
        //         this.playVideo()
        //     }
            
        // },
        // playVideo(){
        //     console.log("play")
        //     // 時間の読み込み
        //     const video = document.getElementById("video");
        //     video.addEventListener('timeupdate', () => {
        //             this.Time = video.currentTime
        //     });
        //     video.play()
        //     this.play = true
        // },
        // pauseVideo(){
        //     console.log("stopp")
        //     const video = document.getElementById("video");
        //     video.pause()
        //     this.play = false
        // },
        onslider(){
            this.slider = ! this.slider
            console.log("onslider")
        }
        
    },   
    created(){
        
    },
    mounted(){
        
            const video = document.getElementById("video");
            this.max = video.duration
            console.log("起動", this.max)
    }
    
}
</script>