<template>
    <div class="menu" :style="{width: isOpen==true?'240px':'70px'}" ref="menu">
        <div class="nav flex-center">
            <ul v-for="(nav,i) in navs" style="width: 80%;" :key="i">
                <div v-if="!(nav.hidden==true)">
                    <li :class="`nav-item-title flex-center nav-item ${nav.show==true?'active':''}`" @click="selectIt(nav.id)">
                        <i :class="nav.icon" :style="{marginRight: isOpen?'8px':'0px'}" v-if="nav.icon!=undefined"></i>
                        <span class="text-overflow" :style="{display: isShow==false&&nav.icon?'none':'block'}" style="display: inline-block;width: 50%;text-align: left;text-align-last: left;">{{ isOpen?nav.name:nav.name[0] }}</span>
                        <!-- <span class="text-overflow" :style="{display: isShow==false&&nav.icon?'none':'block'}">{{ isOpen?nav.name:nav.name[0] }}</span> -->
                        <i :class="`right ${nav.open===true?'el-icon-arrow-up':'el-icon-arrow-down'}`" v-if="nav.children!=undefined&&nav.children.length>1&&isShow"></i>
                    </li>
                    <ul v-if="nav.children!=undefined&&nav.children.length>1" class="nav-item-close" :style="{maxHeight: nav.open&&nav.open===true?`${nav.children.length*50}px`:'0px'}" ref="nav-sub">
                        <li v-for="(nav,i) in nav.children" :class="`nav-item-title flex-center nav-item ${nav.show==true?'active':''}`" @click="selectIt(nav.id)" :key="i">
                            <span class="text-overflow" :style="{textIndent: isOpen==false?`0`:'14px'}">
                                <i :style="{display: isOpen?'inline-block':'none',paddingRight: '4px'}" :class="nav.icon" v-if="nav.icon!=undefined"></i>
                                <span style="display: inline-block;width: 50%;text-align: left;text-align-last: left;font-size: 14px;">{{ isOpen?nav.name:nav.name[0] }}</span>
                                <!-- <span style="font-size: 14px;">{{ isOpen?nav.name:nav.name[0] }}</span> -->
                            </span>
                        </li>
                    </ul>
                </div>
            </ul>
        </div>
        <div class="dark">
            <el-switch v-model="isDark" inactive-color="#5A5656"></el-switch>
            <label v-if="isShow" class="text-overflow" style="color: #9195A1;margin-left: 8px;user-select: none;transform: scale(0.9);">暗色模式</label>
        </div>
        <div class="btn_box" @click="isOpen=!isOpen">
            <div class="control">
                <div :class="`pause${isOpen?' active':''}`"></div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'MenuBar',
    props:['sort'],
    mounted(){
        this.isOpen=localStorage.getItem("cache_menu")?JSON.parse(localStorage.getItem("cache_menu")):true;
        this.isShow=this.isOpen;
        this.isDark=localStorage.getItem("cache_dark")?JSON.parse(localStorage.getItem("cache_dark")):false;
        document.documentElement.setAttribute('theme',this.isDark==true?'dark':'light');
        this.$refs['menu'].addEventListener("transitionend",()=>{this.isShow=this.isOpen;});
        this.navs=this.$router.options.routes;
        if(this.sort===true){this.sortNav();}
        let index=0;
        for(let v of this.navs){
            v.id=String(index);
            if(v.children&&v.children.length>1){
                v.open=false;
                let index_index=0;
                v.children.forEach((u)=>{
                    //设置ID
                    u.id=index+'-'+index_index;
                    index_index++;
                });
            }else{if(this.$route.path===v.path){v.show=true;}}
            index++;
        }
        this.showItem();
    },
    watch:{
        isOpen(v){
            this.isShow=v;
            localStorage.setItem("cache_menu",v);
        },
        isDark(v){
            localStorage.setItem("cache_dark",v);
            document.documentElement.setAttribute('theme',v==true?'dark':'light');
        },
        '$route.path'(){
            this.showItem();
        }
    },
    data(){
        return{
            isDark: false,
            isOpen: true,
            currentId: '000',
            isShow: true,
            navs: []
        }
    },
    methods:{
        clear(id){
            this.navs.forEach((nav)=>{
                nav.show=false;
                if(!(id===this.currentId)){
                    nav.open=false;
                }
                if(nav.children&&nav.children.length>0){
                    nav.children.forEach((child)=>{child.show=false;});
                }
            });
        },
        selectIt(id){
            if(this.currentId==id){return;}
            let info=this.navs.filter((x)=>{return x.id===id.split('-')[0]})[0];
            if(!info){return;}
            let _info;
            if(!(info.id===id)){
                if(info.children&&info.children.length>0){
                    _info=info.children.filter((x)=>{return x.id===id})[0];
                    if(!_info){return;}
                }else{
                    return;
                }
            }else{
                if(info.children&&info.children.length==1){
                    _info=info.children[0];
                }
            }
            if(info.children!=undefined&&info.children.length>1){
                if(!_info){
                    if(info.open===true){
                        info.open=false;
                    }else{
                        info.open=true;
                    }
                    this.$forceUpdate();
                    return;
                }
            }
            this.currentId=info.id+'-'+_info.id||info.id;
            this.clear(info.id+'-'+_info.id);
            if(!(info.children&&info.children.length>1)){
                this.$router.push(info.path||'').catch(()=>{});
                info.show=true;
            }else{
                this.$router.push(_info.path||'').catch(()=>{});
                _info.show=true;
            }
            this.$forceUpdate();
        },
        showItem(){
            this.sortNav();
            this.navs.forEach((v)=>{
                let path=this.$route.path;
                if(v.path==path){
                    this.clear();
                    setTimeout(()=>{
                        v.show=true;
                        this.$forceUpdate();
                    },0);
                }else{
                    if(v.children&&v.children.length>1){
                        v.children.forEach((u)=>{
                            this.clear();
                            if(path===u.path){
                                v.open=false;
                                setTimeout(()=>{
                                    v.open=true;
                                    u.show=true;
                                    this.$forceUpdate();
                                },0);
                            }
                        });
                    }
                }
            })
        },
        sortNav(){
            let navList=this.navs.filter((nav)=>{return nav.children&&nav.children.length>1;});
            let nav=this.navs.filter((nav)=>{return nav.children&&nav.children.length<=1;});
            this.navs=[...navList,...nav];
        }
    }
};
</script>
<style scoped>
    .menu{
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-between;
        transition: .3s;
        background-color: var(--common-bg-color);
        border-right: 1px solid var(--border-color);
        flex-shrink: 0;
    }
    .flex-center{
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .nav{
        flex: 1;
        width: 100%;
        flex-direction: column;
        justify-content: flex-start;
        padding: 12px;
    }
    .nav-item{
        display: flex;
        /* background-color: #000; */
        /* margin: 4px 0; */
        width: 80%;
        padding: 16px 0;
        border-radius: var(--border-radius);
        justify-content: center;
        transition: .3s;
        user-select: none;
        cursor: pointer;
        color: var(--common-font-color);
    }
    .nav-item-title{
        position: relative;
        width: 100%;
    }
    .nav-item:hover{
        color: var(--hover-color);
        background-color: var(--hover-bg);
    }
    .right{
        position: absolute;
        right: 20px;
    }
    .nav-item.active{
        background-color: var(--main-background-color);
        color: #fff;
    }
    @keyframes pullHeight{
        0%{height: 0px !important;}
        100%{height: 500px !important;}
    }
    .nav-item-close{
        /* max-height: 0px; */
        overflow: hidden;
        transition: all ease 0.3s;
    }
    .icon_close::before{
        color: var(--common-font-color);
    }
    .text-overflow{
        overflow: hidden;
        text-align: center;
        text-overflow: ellipsis;
        white-space: nowrap;
        width: 100%;
    }
    .dark{
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }
    .btn_box{
        text-align: center;
        border-top: 1px solid var(--border-color);
        padding: 16px 0;
        cursor: pointer;
        font-size: 22px;
        line-height: initial !important;
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .control .pause{
        width: 8px;
        height: 28px;
        border-radius: 4px;
        position: relative;
    }
    .control .pause::after{
        content: '';
        position: absolute;
        width: 8px;
        height: 32px;
        background-color: var(--common-font-color);
        border-radius: 4px;
        top: -1px;
        left: -8px;
        transition: all .3s;
    }
    .control .pause::before{
        content: '';
        position: absolute;
        width: 8px;
        height: 32px;
        background-color: #49ff2d;
        border-radius: 4px;
        top: -1px;
        right: -8px;
        transition: all .3s;
    }
    .control .pause.active::after{
        transform-origin: center;
        background-color: #ff3d3d;
        transform: rotate(45deg) translate(6px,-6px);
    }
    .control .pause.active::before{
        transform-origin: center;
        background-color: var(--common-font-color);
        transform: rotate(-45deg) translate(-5px,-5px);
    }
</style>