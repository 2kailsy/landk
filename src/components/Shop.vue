<template>
    <tableData :rule="rule" :find="find" :getDatas="getData" :delData="delData" :name="'商店'" :props="[
        {label: 'ID',prop: 'id',fixed: 'left'},
        {label: '商品',prop: 'img',type: 'img',mask_prop: 'name'},
        {label: '商品简介',prop: 'explanation'},
        {label: '价格',prop: 'price'},
        {label: '发布时间',prop: 'time'}
    ]" :AddAndEditForm="AddAndEditForm" :editData="editData" :addData="addData" :backPaging="true"/>
</template>
<script>
import tableData from "./common/TableData.vue";
import {get,add,del,edit} from "@/api/api.js";
export default {
    name: 'ShopPage',
    components: {tableData},
    data() {
        return {
            rule: {
                name: [
                    {required: true,message: '请输入商品名',trigger: 'blur'},
                    {min: 2,max: 20,message: '商品名应在在2到20个字符之间',trigger: 'blur'}
                ],
                img: [{required: true,message: '请上传商品图片',trigger: 'blur'}],
                price: [
                    {required: true,message: '请输入商品价格',trigger: 'blur'},
                ],
                explanation: [
                    {required: true,message: '请输入商品简介',trigger: 'blur'},
                    {min: 6,message: '请补充',trigger: 'blur'}
                ]
            },
            find: {
                id: {value: '',strict: 'middle'},
                name: {value: '',label: '搜索商品',placeholder: '搜索商品名或ID'},
                or: [['id','name']]
            },
            AddAndEditForm: {
                id: {hide: 'all'},
                img: {label: '商品图片',type: 'upload',uploadUrl: '/api/upload/shops',value: ''},
                name: {label: '商品名'},
                price: {label: '价格',type: 'numberInput',value: 1,step: 1,stepStrictly: true},
                explanation: {label: '商品简介',type: 'textarea'},
                time: {hide: 'all'}
            }
        };
    },
    methods: {
        getData(p,n){return get('shop',p,n);},
        delData(id){return del('shop',id);},
        editData(id,data){return edit('shop',id,data);},
        addData(data){return add('shop',data);}
    }
}
</script>