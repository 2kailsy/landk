<template>
    <div class="login">
        <el-card class="login_card">
            <div slot="header">
                <span>2kの后台管理系统</span>
            </div>
            <el-form label-width="80px" :model="loginInfo" ref="loginForm" :rules="loginRules">
                <el-form-item label="用户名" prop="username">
                    <el-input v-model="loginInfo.username"></el-input>
                </el-form-item>
                <el-form-item label="密码" prop="password" @keyup.enter.native="login('loginForm')">
                    <el-input v-model="loginInfo.password" type="password"></el-input>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" class="login_btn" @click="login('loginForm')">登录</el-button>
                </el-form-item>
            </el-form>
        </el-card>
    </div>
</template>
<script>
import {usernameRule,passwordRule} from '../utils/validate';
import {login,check} from '@/api/api.js';
export default {
    name: 'LoginPage',
    data(){
        return {
            loginInfo:{
                username: '',
                password: ''
            },
            loginRules:{
                username: [{validator: usernameRule,trigger: 'blur'}],
                password: [{validator: passwordRule,trigger: 'blur'}]
            }
        }
    },
    methods:{
        login(from){
            this.$refs[from].validate((valid)=>{
                if(!valid){return this.$message.error('登录失败');}
                login({usr: this.loginInfo.username,pwd: this.loginInfo.password}).then((res)=>{
                    if(!(res.status===200)){return this.$message.error('登录失败');}
                    this.checkLogin();
                }).catch(()=>{this.$message.error('登录失败');});
            })
        },
        checkLogin(){check().then((res)=>{if(res.status===200&&res.isAdmin===true){this.$message.success('登录成功');this.$router.push('/home').catch(()=>{});}}).catch(()=>{this.$message.warning('您还不是管理员哦~');});}
    },
    created(){this.checkLogin();}
}
</script>

<style lang="scss">
.login{
    width: 100%;
    height: 100%;
    background-color: #409EFF;
    position: absolute;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    .login_card{
        max-width: 450px;
        width: 90%;
        .el-card__header{font-size: 24px;}
        .login_btn{width: 100%;}
    }
}
</style>