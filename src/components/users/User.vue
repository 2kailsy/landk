<template>
    <div>
        <el-tree
            :data="menus"
            show-checkbox
            node-key="name"
            :props="props">
        </el-tree>
        <el-card style="margin-top: 20px;">没错，这玩意没啥用</el-card>
    </div>
</template>
<script>
export default {
    name: 'UserPage',
    data(){
        return {
            menus: [],
            props: {
                label: 'name',
                children: 'children'
            }
        }
    },
    created(){
        this.menus=this.$router.options.routes;
    }
}
</script>

<style>

</style>