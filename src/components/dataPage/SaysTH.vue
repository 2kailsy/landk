<template>
  <tableData :rule="rule" :find="find" :getDatas="getData" :delData="delData" :name="'对她说'" :props="[
    {prop: 'id',label: 'ID',fixed: 'left'},
    {prop: 'content',label: '内容'},
    {prop: 'time',label: '时间'}
  ]" :AddAndEditForm="AddAndEditForm" :editData="editData" :addData="addData" :backPaging="true"/>
</template>
<script>
import {get,add,del,edit} from '@/api/api';
import tableData from "@/components/common/TableData.vue";
export default {
  name: 'SaysTHPage',
  components: {tableData},
  data(){
    return {
      rule: {
        content: [
          {required: true,message: '请输入',trigger: 'blur'},
          {min: 2,message: '最少2个字符',trigger: 'blue'}
        ]
      },
      find: {
        id: {strict: 'middle'},
        content: {strict: false,label: '搜索',placeholder: '搜索内容或ID'},
        time: {label: '时间',type: 'daterange'},
        or: [['id','content']]
      },
      AddAndEditForm: {
        id: {act: 'all'},
        content: {label: '对她说'}
      }
    }
  },
  methods: {
    getData(p,n){
      return get('saysth',p,n);
    },
    delData(id){
      return del('saysth',id);
    },
    editData(id,data){
      return edit('saysth',id,data);
    },
    addData(data){
      return add('saysth',data);
    }
  }
}
</script>
<style>
</style>