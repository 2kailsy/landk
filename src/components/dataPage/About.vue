<template>
  <tableData :rule="rule" :find="find" :getDatas="getData" :delData="delData" :name="'搜索'" :props="[
    {prop: 'id',label: 'ID',fixed: 'left'},
    {prop: 'img',label: '图片',type: 'img',mask_prop: 'name'},
    {prop: 'title',label: '标题'},
    {prop: 'content',label: '内容'},
    {prop: 'author',label: '作者'},
    {prop: 'time',label: '时间'}
  ]" :AddAndEditForm="AddAndEditForm" :editData="editData" :addData="addData" :backPaging="true"/>
</template>
<script>
import {get,add,del,edit} from '@/api/api';
import tableData from "@/components/common/TableData.vue";
export default {
  name: 'AboutPage',
  components: {tableData},
  data(){
    return {
      rule: {
        title: [
          {required: true,message: '请输入',trigger: 'blur'},
          {min: 2,message: '最少2个字符',trigger: 'blue'}
        ],
        content: [
          {required: true,message: '请输入',trigger: 'blur'},
          {min: 2,message: '最少2个字符',trigger: 'blue'}
        ],
        author: [
          {required: true, message: '请输入', trigger: 'blur'},
          {min: 2, message: '最少2个字符', trigger: 'blue'}
        ]
      },
      find: {
        title: {strict: false,},
        content: {strict: false,label: '搜索',placeholder: '搜索标题或内容'},
        time: {label: '时间',type: 'daterange'},
        or: [['title','content']]
      },
      AddAndEditForm: {
        id: {act: 'all'},
        img: {label: '图片',type: 'upload',uploadUrl: '/api/upload/about',value: ''},
        title: {label: '标题'},
        content: {label: '内容',type: 'textarea'},
        author: {label: '作者'}
      }
    }
  },
  methods: {
    getData(p,n){
      return get('search',p,n);
    },
    delData(id){
      return del('search',id);
    },
    editData(id,data){
      return edit('search',id,data);
    },
    addData(data){
      return add('search',data);
    }
  }
}
</script>
<style>
</style>