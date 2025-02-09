<template>
  <div class="bread">
    <el-card style="background-color: var(--common-bg-color);border: 1px solid var(--border-color);">
        <el-breadcrumb separator-class="el-icon-arrow-right" style="color: var(--common-font-color);">
            <el-breadcrumb-item class="is-link" @click.native="goHome()">首页</el-breadcrumb-item>
            <el-breadcrumb-item v-for="(item,index) in $route.matched" :key="index">{{ item.name }}</el-breadcrumb-item>
        </el-breadcrumb>
    </el-card>
  </div>
</template>
<script>
export default{
    methods:{
        goHome(){
            this.$router.push('/home').catch(()=>{});
        }
    }
}
</script>
<style>
    .bread{
        margin: 8px;
    }
    .el-breadcrumb__inner,.el-breadcrumb__item:last-child .el-breadcrumb__inner{
        color: var(--common-font-color);
        cursor: pointer;
        user-select: none;
        transition: .3s;
    }
    .el-breadcrumb{
        display: flex;
        align-items: center;
    }
    .el-breadcrumb__item:last-child .el-breadcrumb__inner:hover{
        color: var(--common-font-color);
    }
    .is-link>span{
        font-weight: 700;
        text-decoration: none;
        transition: color .2s cubic-bezier(.645,.045,.355,1);
        color: var(--common-font-color);
    }
    .is-link:hover>span{color: var(--hover-color) !important;}
</style>