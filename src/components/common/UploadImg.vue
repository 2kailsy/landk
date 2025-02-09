<template>
    <el-upload
        class="avatar-uploader"
        :action="uploadUrl"
        :headers="{'Authorization': token}"
        :show-file-list="false"
        :on-success="handleAvatarSuccess"
        :before-upload="beforeAvatarUpload">
        <img v-if="url" :src="imgUrl" class="avatar" alt="图片加载失败">
        <i v-else class="el-icon-plus avatar-uploader-icon"></i>
    </el-upload>
</template>

<script>
export default {
    props: ['uploadUrl','token','url'],
    data(){
        return{
            imgUrl: ''
        }
    },
    watch: {
        url(e){
            this.imgUrl=e;
        }
    },
    created(){
        if(this.url&&this.url.length>0){this.imgUrl=this.url;}
    },
    methods: {
        handleAvatarSuccess(res){
            if(res.status==403||res.status==406){return this.$router.push('/login').catch(()=>{});}
            this.imgUrl=res.path;
            this.$emit('updateUrl',res.path);
        },
        beforeAvatarUpload(file) {
            const isPic=file.type.indexOf('image/')!=-1;
            const isLt12M=file.size/1024/1024<12;
            if(!isPic){this.$message.error('上传头像只能是图片格式');}else
            if(!isLt12M){this.$message.error('上传头像图片大小不能超过12MB!');}
            return isPic&&isLt12M;
        },
    }
}
</script>

<style lang="scss">
    .avatar-uploader .el-upload {
        border: 1px dashed var(--border-color);
        border-radius: 6px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }
    .avatar-uploader .el-upload:hover {
        border-color: #409EFF;
    }
    .avatar-uploader-icon {
        font-size: 28px;
        color: #8c939d;
        width: 178px;
        height: 178px;
        line-height: 178px;
        text-align: center;
    }
    .avatar {
        width: 178px;
        display: block;
    }
</style>