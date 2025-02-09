<template>
    <div class="table">
        <el-form :inline="true" :model="finds" style="display: flex;flex-wrap: wrap;" v-if="!(JSON.stringify(finds)=='{}')">
            <div v-for="(find,i) in finds" :key="i">
                <el-form-item :label="find.label" v-if="find.hide==false">
                    <el-input v-model="find.value" @input="andInput(find.value,find.n)" :placeholder="find.placeholder" v-if="(!find.type||find.type=='string')&&find.o==true"></el-input>
                    <el-input v-model="find.value" @input="andInput(find.value,find.n)" :placeholder="find.placeholder" v-if="(!find.type||find.type=='string')&&find.o==false"></el-input>
                    <el-select v-model="find.value" @change="andInput(find.value,find.n)" :style="{'width': find.width||'100%'}" :placeholder="find.placeholder" v-if="find.type=='select'">
                        <el-option :label="option.label" :value="option.value" v-for="(option,i) in find.selects" :key="i"></el-option>
                    </el-select>
                    <el-date-picker
                        v-model="find.value"
                        type="daterange"
                        value-format="yyyy-MM-dd"
                        format="yyyy年MM月dd日"
                        range-separator="至"
                        start-placeholder="开始日期"
                        end-placeholder="结束日期"
                        @change="andInput(find.value,find.n)" v-if="find.type=='daterange'">
                    </el-date-picker>
                </el-form-item>
            </div>
            <el-form-item>
                <el-button type="primary" @click="getData(true);">查询</el-button>
                <el-button type="primary" @click="reset">重置</el-button>
                <el-button type="primary" icon="el-icon-plus" circle @click="editAndAdd('add')" title="添加用户"></el-button>
            </el-form-item>
        </el-form>
        <el-table :data="comData" border style="width: calc(100% - 8px);border-radius: var(--border-radius);box-shadow: var(--common-shadow-color);flex: 1;" height="100%" ref="addClass">
            <template v-for="(item,i) in props">
                <el-table-column :fixed="item.fixed" :resizable="false" :prop="item.prop" :label="item.label" align="center" v-if="!item.type||item.type=='string'" :key="i">
                    <template slot-scope="scope"><div :style="`color:${item.color} !important;`">{{ scope.row[item.prop] }}</div></template>
                </el-table-column>
                <el-table-column :fixed="item.fixed" :resizable="false" :prop="item.prop" :label="item.label" align="center" v-if="item.type=='status'" :key="i">
                    <template slot-scope="scope">
                        <template v-for="(it, ii) in item.status">
                            <el-tag :style="{ color: getStatusColor(scope.row[item.prop],item.status),backgroundColor: getStatusBgColor(scope.row[item.prop],item.status)}" :key="ii" v-if="it.code == scope.row[[item.prop]]">
                                {{ it.output }}
                            </el-tag>
                        </template>
                    </template>
                </el-table-column>
                <el-table-column :fixed="item.fixed" :resizable="false" :prop="item.prop" :label="item.label" align="center" v-if="item.type=='split'" :key="i">
                    <template slot-scope="scope" v-if="scope.row[item.prop]!=null">
                        <template v-for="(it,ii) in scope.row[item.prop].split(item.str)">
                            <el-tag :key="ii" v-if="it.length>0" type="info">{{ it }}</el-tag>
                            <br :key="`br_${ii}`" v-if="it.length>0" style="margin: 12px 0;"/>
                        </template>
                    </template>
                </el-table-column>
                <el-table-column :fixed="item.fixed" :resizable="false" :prop="item.prop" :label="item.label" align="center" v-if="item.type=='img'" :key="i">
                    <template slot-scope="scope">
                        <div style="display: flex;flex-direction: column;">
                            <el-image :src="scope.row[item.prop]" style="border-radius: 4px;" v-if="scope.row[item.prop]!=null" :preview-src-list="[scope.row[item.prop]]">
                                <div slot="error" class="image-slot">
                                    <i class="el-icon-picture-outline" style="font-size: 28px;text-align: center;width: 100%;"></i>
                                </div>
                            </el-image>
                            <i style="padding-top: 12px;" v-if="scope.row[item.mask_prop]">{{ scope.row[item.mask_prop] }}</i>
                            <i v-if="!scope.row[item.prop]">无</i>
                        </div>
                    </template>
                </el-table-column>
            </template>
            <el-table-column :resizable="false" label="操作" align="center">
                <template slot-scope="scope">
                    <el-button type="primary" size="mini" icon="el-icon-edit" @click="editAndAdd('edit',scope.row)"></el-button>
                    <el-button type="danger" size="mini" icon="el-icon-delete" @click="del(scope.row.id)"></el-button>
                </template>
            </el-table-column>
        </el-table>
        <el-pagination
            @size-change="handleSizeChange"
            @current-change="handleCurrentChange"
            :current-page="currentPage"
            :page-sizes="[5,10,20,25]"
            :page-size="pageSize"
            layout="total, sizes, prev, pager, next, jumper"
            :total="total" v-if="backPaging===true">
        </el-pagination>
        <el-dialog :title="localEditOrAdd=='add'?`添加${name}`:localEditOrAdd=='edit'?`修改${name}`:'???'" :visible.sync="isShow" center>
            <el-form :model="AddAndEditForm" :rules="rules" hide-required-asterisk ref="form">
                <template v-for="(item,i) in AddAndEditForm">
                    <el-form-item :label="item.label" :prop="`${item.prop}.value`" :label-width="formLabelWidth" :key="i" v-if="item.hide!='all'&&item.hide!=localEditOrAdd&&item.label">
                        <el-input v-model="item.value" autocomplete="off" v-if="!item.type||item.type=='input'" :disabled="item.disabled||false"></el-input>
                        <upload-img :uploadUrl="item.uploadUrl" :token="item.token" @updateUrl="(e)=>{item.value=e;}" :url="item.value" v-if="item.type=='upload'"></upload-img>
                        <el-switch style="display: flex;height: 40px;user-select: none;"
                            v-model="item.value"
                            :active-color="item.activeColor||'#13ce66'"
                            :inactive-color="item.inactiveColor||'#ff4949'"
                            :active-text="item.activeText||'展示'"
                            :inactive-text="item.inactiveText||'隐藏'"
                            :active-value="item.activeValue||0"
                            :inactive-value="item.inactiveValue||1" v-if="item.type=='switch'">
                        </el-switch>
                        <el-date-picker
                            v-model="item.value"
                            type="datetime"
                            :value-format="item.valueFormat||'yyyy-MM-dd HH:mm:ss'"
                            placeholder="选择照片拍摄日期" v-if="item.type=='datetime'">
                        </el-date-picker>
                        <el-input v-model="item.value" autocomplete="off" type="textarea" :rows="8" resize="vertical" v-if="item.type=='textarea'"></el-input>
                        <el-input v-model="item.value" autocomplete="off" type="password" v-if="item.type=='password'"></el-input>
                        <el-input
                            type="textarea"
                            :placeholder="item.placeholder"
                            v-model="item.value"
                            :maxlength="item.max||50"
                            autocomplete="off"
                            resize="none"
                            :rows="item.rows||3"
                            show-word-limit v-if="item.type==='textarea_max'">
                        </el-input>
                        <el-date-picker
                            v-model="item.value"
                            type="date"
                            :popper-class="item.popperClass||''"
                            :value-format="item.valueFormat||'yyyy-MM-dd'"
                            :format="item.format||'yyyy-MM-dd'"
                            :placeholder="item.placeholder" v-if="item.type==='date'">
                        </el-date-picker>
                        <el-input-number v-model="item.value" :step="item.step||1" :step-strictly="item.stepStrictly||false" v-if="item.type=='numberInput'"></el-input-number>
                        <template v-if="item.type=='radio'">
                            <el-radio v-model="item.value" :label="radio.value" :border="item.border||false" v-for="(radio,i) in item.radios" :key="i">{{ radio.label }}</el-radio>
                        </template>
                        <el-select v-model="item.value" :style="{'width': item.width||'100%'}" :placeholder="item.placeholder" v-if="item.type=='select'">
                            <el-option :label="option.label" :value="option.value" v-for="(option,i) in item.selects" :key="i"></el-option>
                        </el-select>
                        <template v-if="item.type=='template'">
                            <div style="display: flex;flex-wrap: wrap;" v-if="localEditOrAdd=='edit'&&item.value&&item.value.length>0">
                                <el-button v-for="(temp,index) in item.value" :key="index" @click="AddAndEditForm[item.model].value+='\n'+temp.value" class="bg margin-right">{{temp.name}}</el-button>
                                <el-button @click="showTemp=!showTemp" icon="el-icon-edit" class="addTemplate bg margin-right"></el-button>
                            </div>
                            <div style="display: flex;flex-wrap: wrap;" v-if="(!item.value||item.value.length<=0)&&localEditOrAdd!='add'">
                                <el-button @click="showTemp=!showTemp;addDelTemplate(item,true)" icon="el-icon-plus" class="addTemplate bg margin-right"></el-button>
                            </div>
                            <template v-for="(temp,index) in item.value">
                                <div style="display: flex;margin-bottom: 8px;" :key="index" v-if="showTemp===true">
                                    <el-input v-model="temp.value" class="z-indextop radius-right-none"></el-input>
                                    <el-input v-model="temp.name" class="z-indextop radius-right-none radius-left-none left-border-none" style="width: 120px;margin-right: -1px;" maxlength="4"></el-input>
                                    <el-button type="danger" icon="el-icon-close" style="border-top-left-radius: 0;border-bottom-left-radius: 0;" @click="addDelTemplate(item,temp)"></el-button>
                                </div>
                            </template>
                            <el-form-item v-if="localEditOrAdd=='add'||showTemp===true">
                                <el-button @click="addDelTemplate(item,true)" class="addTemplate" style="width: 100%;">添加模板</el-button>
                            </el-form-item>
                        </template>
                    </el-form-item>
                </template>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="isShow=false;" class="bg">取消</el-button>
                <el-button type="primary" @click="ok(localEditOrAdd)" :loading="loading">确定</el-button>
            </div>
        </el-dialog>
    </div>
</template>
<script>
import {filterData,getSymmetricDifferenceSet,sortBy,deepClone} from '@/utils/utils';
import uploadImg from './UploadImg.vue';
export default {
    props: {rule:{type: Object},datas:{type: Array},find:{type: Object},getDatas:{type: Function},props:{type: Array},delData:{type: Function},name:{type: String},AddAndEditForm:{type: Object},editData: {type: Function},addData: {type: Function},getInfo: {type: Function},backPaging: {type: Boolean},editOrAdd: {type: String}},
    components: {uploadImg},
    data(){
        return {
            dataes: [],
            showTemp: false,
            currentPage: 1,
            total: 0,
            pageSize: 10,
            isShow: false,
            localEditOrAdd: this.editOrAdd,
            formLabelWidth: '80px',
            $finds: {},
            finds: {},
            photo: {
                title: '',
                content: '',
                imageUrl: '',
                hide: '0',
                time: ''
            },
            dataa: {},
            rules: {},
            re: {},
            loading: false,
            $temp: {},
            isSearching: false,
            change: {},
            original: {}
        }
    },
    watch:{
        _AddAndEditForm: {
            handler: function(n,o){
                let change=getSymmetricDifferenceSet(o,n);
                if(change.change==true){
                    let temp={};
                    Object.keys(change.diff).forEach((key)=>{
                        if(change.diff[key]['valueFormats']==='json'){
                            temp[`${key}_json`]='';
                            temp[`${key}_json`]=JSON.stringify(change.diff[key]['value']);
                        }
                    });
                    this.$temp=temp;
                }
                let data={};
                Object.keys(this.AddAndEditForm).forEach((key)=>{
                    if(this.AddAndEditForm[key]['value']!=null&& // 检查不是null或undefined
                    this.AddAndEditForm[key]['value']!==false&& // 检查不是false
                    this.AddAndEditForm[key]['value']!==''){
                        if(this.AddAndEditForm[key]['valueFormats']==='json'){
                            data[key]=this.$temp[`${key}_json`];
                        }else{
                            data[key]=this.AddAndEditForm[key]['value'];
                        }
                    }
                });
                this.change={...getSymmetricDifferenceSet(this.dataa,data),id: data.id};
            },
            deep: true
        },
        localEditOrAdd(n){this.$emit('update:editOrAdd',n);}
    },
    mounted(){
        if(this.datas){this.dataes=JSON.parse(JSON.stringify(this.datas));}
        if(this.find){this.finds=JSON.parse(JSON.stringify({...this.find,or: undefined}));this.$finds=JSON.parse(JSON.stringify(this.find));}
        //返回那些字段需要显示，什么类型
        this.init();
        this.re=JSON.parse(JSON.stringify(this.AddAndEditForm));
        this.original=deepClone(this.find);
        this.reset();
        this.getData();
    },
    computed:{
        comData(){
            if(this.backPaging==true&&this.isSearching==false){
                return this.dataes.slice(0,this.pageSize);
            }else{
                return this.dataes.slice((this.currentPage-1)*this.pageSize,this.currentPage*this.pageSize);
            }
        },
        _AddAndEditForm(){return JSON.parse(JSON.stringify(this.AddAndEditForm));}
    },
    methods:{
        init(){
            Object.keys(this.finds).forEach((key)=>{
                this.finds[key].hide=false;
                this.finds[key].n=key;
                this.finds[key].o=false;
            });
            let stop=false;
            if(this.$finds.or&&this.$finds.or.length>=1){
                this.$finds.or.forEach((item)=>{
                    if(typeof item == 'object'){
                        for(let v of item){
                            if(!(this.finds[v].label)){
                                this.finds[v].hide=true;
                            }else{this.finds[v].hide=false;}
                            this.finds[v].o=true;
                        }
                    }else{
                        if(this.$finds.or.length<=1||stop===true){return;}//小于等于1的时候不用处理||stop==true的时候返回
                        for(let v of this.$finds.or){
                            if(!(this.finds[v].label)){
                                this.finds[v].hide=true;
                            }else{this.finds[v].hide=false;}
                            this.finds[v].o=true;
                        }
                        stop=true;
                    }
                });
            }
            this.props.sort(sortBy('order'));
            if(this.rule){
                let rule={};
                Object.keys(this.rule).forEach((key)=>{rule[key+'.value']=this.rule[key];});
                this.rules=rule;
            }
            Object.keys(this.AddAndEditForm).forEach((key)=>{
                if(!this.AddAndEditForm[key].prop){
                    this.AddAndEditForm[key].prop=key;
                }
            });
        },
        getStatusBgColor(code,statuses){return statuses.find(status=>status.code===code).bgcolor;},
        getStatusColor(code,statuses){return statuses.find(status=>status.code===code).color||'#fff';},
        andInput(e,k){this.$finds[k].value=e;},
        reset(){
            this.$finds=deepClone(this.original);
            this.finds=deepClone(JSON.parse(JSON.stringify({...this.original,or: undefined})));
            this.init();
            this.isSearching=false;
            this.getData();
        },
        getData(filter=false){
            let size=this.pageSize,current=this.currentPage;
            if(filter==true&&this.backPaging===true){size=this._total;current=1;this.isSearching=true;}
            this.getDatas(size||5,current||1).then((res)=>{
                if(res.status==200){
                    this.dataes=res.data;
                    this.$refs['addClass'].$el.classList.add('hclass');
                    this.$refs['addClass'].$forceUpdate();
                    if(filter===true){this.dataes=filterData(this.dataes,this.$finds);this.currentPage=1;}
                    if(res.total&&filter==false){this.total=res.total;this._total=res.total;}else{this.total=this.dataes.length;}
                }
            }).catch((e)=>{
                this.loading = false;
                this.$notify.warning({
                    title: '查询',
                    message: `查询失败!!${e}`
                });
            });
        },
        handleSizeChange(val){
            this.pageSize=val;
            if(this.backPaging===true&&this.isSearching==false){
                this.getData();
            }
        },
        handleCurrentChange(val){
            this.currentPage=val;
            if(this.backPaging===true&&this.isSearching==false){
                this.getData();
            }
        },
        del(id){
            this.$confirm(`确定要删除该${this.name}？[ID: ${id}]`,'删除',{
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                confirmButtonClass: 'el-button--danger',
                type: 'warning'
            }).then(()=>{
                this.delData(id).then((res)=>{
                    if(res.status==200){
                        this.$notify({
                            type: 'success',
                            title: '删除',
                            message: '删除成功!'
                        });
                        this.getData();
                    }else{
                        this.$notify.error({
                            title: '删除',
                            message: '删除失败!'
                        });
                    }
                }).catch(()=>{
                    this.loading = false;
                    this.$notify.warning({
                        title: '删除',
                        message: '删除失败!'
                    });
                });
            }).catch(()=>{});
        },
        editAndAdd(type,info){
            this.isShow=true;
            this.localEditOrAdd=type;
            switch(type){
                case 'edit':
                    this.dataa=JSON.parse(JSON.stringify(info));
                    Object.keys(this.AddAndEditForm).forEach((key)=>{
                        this.$set(this.AddAndEditForm[key],'value',info[key]);
                    });
                    if(this.getInfo){
                        this.getInfo(this.dataa.id).then((res)=>{
                            if(!res){return;}
                            Object.keys(res).forEach((key)=>{
                                if(!this.AddAndEditForm[key]){
                                    this.AddAndEditForm[key]={};
                                }
                                this.$set(this.AddAndEditForm[key],'value',res[key]);
                                this.dataa[key]=res[key];
                            });
                        });
                    }
                    Object.keys(this.AddAndEditForm).forEach((key)=>{
                        if(this.AddAndEditForm[key]['valueFormats']==='json'){
                            this.dataa[key]=JSON.stringify(this.AddAndEditForm[key]['value']);
                        }
                    });
                    this.showTemp=false;
                break;
                default:
                    Object.keys(this.re).forEach((key)=>{
                        if(this.AddAndEditForm[key]){
                            this.$set(this.AddAndEditForm[key],'value',this.re[key].value);
                        }else{
                            this.$set(this.AddAndEditForm[key],'value','');
                        }
                    });
                    this.showTemp=true;
                break;
            }
        },
        ok(type){
            this.loading=true;
            switch(type){
                case 'edit': this.editDatas();break;
                default: this.addDatas();break;
            }
        },
        editDatas(){
            this.$refs['form'].validate((res)=>{
                if(res===true){
                    if(this.change.change==false){
                        this.loading=false;
                        return this.$notify({
                            type: 'warning',
                            title: '修改',
                            message: '未更改'
                        });
                    }
                    this.editData(this.change.id,this.change.diff).then((res)=>{
                        if(res.status==200){
                            this.$notify({
                                type: 'success',
                                title: '修改',
                                message: '修改成功!'
                            });
                            this.getData();
                            this.isShow=false;
                        }
                        this.loading=false;
                    }).catch(()=>{
                        this.loading = false;
                        this.$notify.warning({
                            title: '修改',
                            message: '无更改'
                        });
                    });
                }else{
                    this.loading=false;
                }
            });
        },
        addDatas(){
            this.loading=false;
            this.$refs['form'].validate((res)=>{
                if(res===true){
                    let data={};
                    Object.keys(this.AddAndEditForm).forEach((key)=>{
                        if(this.AddAndEditForm[key]['valueFormats']==='json'){
                            data[key]=this.$temp[`${key}_json`];
                        }else{
                            data[key]=this.AddAndEditForm[key]['value'];
                        }
                    });
                    this.addData(data).then((res)=>{
                        if(res.status&&res.status==200){
                            this.$notify({
                                type: 'success',
                                title: '添加',
                                message: '添加成功!'
                            });
                            this.getData();
                            this.isShow=false;
                        }
                        this.loading=false;
                    }).catch(()=>{
                        this.loading=false;
                        this.$notify({
                            type: 'error',
                            title: '错误',
                            message: '添加失败'
                        });
                    });
                }else{
                    this.loading=false;
                }
            });
        },
        addDelTemplate(items,add=true){
            if(add===true){
                if(!items.value||!items.value.length===0){items.value=[];}
                items.value.push({value: '',name: `模板${items.value.length+1}`});
            }else{
                if(items.value.indexOf(add)!==-1){
                    items.value.splice(items.value.indexOf(add),1);
                }
            }
        }
    }
}
</script>
<style lang="scss" scoped>
    .addTemplate{
        border: 1px dashed var(--border-color);
        border-radius: 4px;
        background-color: var(--common-bg-color);
        &:hover{
            border-color: #C0C4CC;
        }
    }
    .addTemplate.el-button:focus,.addTemplate.el-button:hover{background-color: var(--common-bg-color);}
    .table{display: flex;flex-direction: column;height: 100%;}
</style>
<style lang="scss">
    .el-table__body .el-table__row.hover-row td{background-color: var(--hover-bg) !important;}
    .el-table__fixed::before{display: none;}
</style>