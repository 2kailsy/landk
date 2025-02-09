/**
 * 获取星座
 * @param {number} month 阳历月份
 * @param {number} day 阳历日
 * @returns 星座
*/
export function getConstellation(month,day){
    if(month==parseInt(month)&&day==parseInt(day)){
        month=parseInt(month),day=parseInt(day);
        let res=null;
        let lastDay=(day<=30),FebDay=(day<=29);
        if(day>=1||day<=31){
            switch(month){
                case 1: if(day<= 19){res='摩羯座';}else if(day>=20){res='水瓶座';}break;
                case 2: if(day<= 18){res='水瓶座';}else if(day>=18&&FebDay){res='双鱼座';}break;
                case 3: if(day<= 20){res='双鱼座';}else if(day>=21){res='白羊座';}break;
                case 4: if(day<= 19){res='白羊座';}else if(day>=20&&lastDay){res='金牛座';}break;
                case 5: if(day<= 20){res='金牛座';}else if(day>=21){res='双子座';}break;
                case 6: if(day<= 21){res='双子座';}else if(day>=22&&lastDay){res='巨蟹座';}break;
                case 7: if(day<= 22){res='巨蟹座';}else if(day>=23){res='狮子座';}break;
                case 8: if(day<= 22){res='狮子座';}else if(day>=23){res='处女座';}break;
                case 9: if(day<= 22){res='处女座';}else if(day>=23&&lastDay){res='天秤座';}break;
                case 10:if(day<= 23){res='天秤座';}else if(day>=24){res='天蝎座';}break;
                case 11:if(day<= 22){res='天蝎座';}else if(day>=23&&lastDay){res='射手座';}break;
                case 12:if(day<= 21){res='射手座';}else if(day>=22){res='摩羯座';}break;
            }
        }
        return res?res:'日期无效';
    }else{return false;}
}
/**
 * 按条件过滤数据
 * @param {object} data 数据
 * @param {object} filter 过滤项目(字段与data保持一致)
 *{
 *  字段: {
 *      value(√): 值,
 *      strict(×): 全等(类型)/全等(内容)/包含=>true/'middle'/false,
 *      type(×): 'date'/'string'=>日期/日期字符串,
 *      early(×,type='date',value=''||value=['']): 早于/晚于=>true/false
 *  },
 *  or(×): [[字段1,字段2,...],[字段1,字段2,...]]=>其中一个字段满足条件
 *}
 * @returns 满足条件的数据
 */
export function filterData(data,filter){
    //数据合法性检测
    if(typeof filter!='object'||typeof data!='object'){return data;}
    //复制数据
    data=deepClone(data);
    filter=deepClone(filter);
    //提取数据
    let or=filter['or'];
    try{delete filter['or'];}catch(e){return data;}
    //初始化数据
    Object.keys(filter).forEach((key)=>{
        if(!(filter[key]['type'])){filter[key]['type']='string';}
        if(filter[key]['value']==undefined&&
            filter[key]['value']==null&&
            filter[key]['value']==false&&
            filter[key]['value']==''){
            filter[key]['value']='';
        }
        if(!(filter[key]['required'])){filter[key]['required']=false;}
    });
    let index=0,stop=false;
    //对or数据进行处理
    if(or&&((typeof or[0]=='object'&&or.length>=1)||(typeof or[0]!='object'&&or.length>=1))){
        stop=false;
        or.forEach((item)=>{
            if(typeof item == 'object'){
                let str,key;
                for(let v of item){
                    if(filter[v].value&&filter[v].value!=''&&filter[v].value!=' '&&filter[v].value!=null&&filter[v].value!=undefined&&filter[v]['or']!=true){
                        str=filter[v].value;
                        key=v;
                    }
                }
                if(str==undefined||key==undefined){return;}
                for(let v of item){
                    if(v==key){continue;}
                    if(typeof filter[v]['value']!='object'){filter[v]['value']={}}
                    filter[v]['value'][`value_${key}_${v}`]=str;
                    filter[v]['or']=true;
                }
            }else{
                //当他是字符串或数字
                if(or.length<=1||stop===true){return;}//小于等于1的时候不用处理||stop==true的时候返回
                let str,key;
                for(let v of or){
                    console.log(or);
                    if(filter[v].value&&filter[v].value!=''&&filter[v].value!=' '&&filter[v].value!=null&&filter[v].value!=undefined){
                        str=filter[v].value;
                        key=v;
                    }
                }
                if(str==undefined||key==undefined){return;}
                for(let v of or){
                    if(v==key){continue;}
                    if(typeof filter[v]['value']!='object'){filter[v]['value']={}}
                    filter[v]['value'][`value_${key}_${v}`]=str;
                    filter[v]['or']=true;
                }
                stop=true;
            }
        });
    }
    if(or&&((typeof or[0]=='object'&&or.length>=1)||(typeof or[0]!='object'&&or.length>=1))){
        or.forEach((item)=>{
            if(typeof item == 'object'){
                for(let v of item){
                    let i=0;
                    if((!filter[v]||!filter[v]['value']||filter[v]['value']==''||filter[v]['value']==' '||filter[v]['value']==null||filter[v]['value']==undefined)&&filter[v]['required']==false){
                        i++;
                        delete filter[v];
                    }
                    if(i!=0){or.splice(index,1);}
                }
            }else{
                if(or.length<=1||stop===true){return;}
                let index=0;
                for(let v of or){
                    let i=0;
                    if(!filter[v]){or.splice(index,1);return i++;}
                    if((!filter[v]||!filter[v]['value']||filter[v]['value']==''||filter[v]['value']==' '||filter[v]['value']==null||filter[v]['value']==undefined)&&filter[v]['required']==false){
                        i++;
                        delete filter[v];
                    }
                    if(i!=0){or.splice(index,1);}
                    index++;
                }
                stop=true;
            }
            index++;
        });
    }
    //删除非必填空数据
    for(let key in filter){
        if(filter[key]['required']==false){
            if(filter[key]['value']==undefined&&
                filter[key]['value']==null&&
                filter[key]['value']==false&&
                filter[key]['value']==''){
                delete filter[key];
            }
        }
    }
    if(JSON.stringify(filter)=='{}'){return data;}
    let _data={};
    //TODO 过滤数据
    const filterIt=(k,v,type,strict,early)=>{
        //data的k项的值与v比较
        switch(type){
            case 'string':case 'select':
                if(!strict||strict==undefined||strict==false){
                    // 不完全匹配(模糊搜索)
                    return data.filter((d)=>{return String(d[k]).indexOf(v)!=-1;});
                }else if(strict=='middle'){
                    // 完全匹配(精确查找)[字符相等]
                    return data.filter((d)=>{return d[k]==v;});
                }else if(strict==true){
                    // 完全匹配(精确查找)[字符，类型完全相等]
                    return data.filter((d)=>{return d[k]===v;});
                }
            break;
            case 'date':
                if(!early||early==undefined||early==false){
                    //大于这个时间
                    return data.filter((d)=>{return new Date(d[k])>new Date(v);});
                }else if(early==true){
                    //小于这个时间
                    return data.filter((d)=>{return new Date(d[k])<new Date(v);});
                }else if(early=='equal'){
                    //等于这个时间
                    return data.filter((d)=>{return new Date(d[k])===new Date(v);});
                }
            break;
            case 'daterange':
                //v是一个数组在数组中两项之间的数据['2023/08/20 11:44:20','2023/08/20']
                if(typeof v=='object'&&v.length==2){return data.filter((d)=>{return new Date(d[k])>new Date(v[0])&&new Date(d[k])<new Date(v[1]);});}
            break;
        }
    };
    Object.keys(filter).forEach((key)=>{
        if(typeof filter[key]['value']=='object'){
            let re=false;
            Object.keys(filter[key]['value']).forEach((k)=>{re=k.indexOf('value_')!=-1;return;});
            if(re){
                Object.keys(filter[key]['value']).forEach((k)=>{
                    let value=filter[key]['value'][k];
                    _data[k]=filterIt(k.split('_')[2],value,filter[key]['type'],filter[key]['strict'],filter[key]['early']);
                });
            }else{
                //数组
                let value=filter[key]['value'];
                _data[key]=filterIt(key,value,filter[key]['type'],filter[key]['strict'],filter[key]['early']);
            }
        }else{
            let value=filter[key]['value'];
            if(value==='all'){return _data[key]=data;}
            _data[key]=filterIt(key,value,filter[key]['type'],filter[key]['strict'],filter[key]['early']);
        }
    });
    //取或者(or)的并集
    Object.keys(_data).forEach((key)=>{
        if(key.indexOf('value_')!=-1){
            _data[key]=[..._data[key.split('_')[1]],..._data[key]];
        }
    });
    if(or&&((typeof or[0]=='object'&&or.length>=1)||(typeof or[0]!='object'&&or.length>=1))){
        or.forEach((key)=>{
            if(typeof key=='object'){
                for(let v of key){
                    delete _data[v];
                }
            }else{delete _data[key];}
        });
    }
    let _temp=[];
    let _k=[];
    for(let k in _data){_temp.push(_data[k]);}
    for(let k in _data){_k.push(k);}
    console.log(_temp,_k);
    return removeDuplicate(getIntersection(_temp));
}
/**
 * 获取两数据的对称差集
 * @param {object} data1 数据
 * @param {object} data2 对比数据
 * @returns 对称差集(diff),有无改变(差集)
 */
export function getSymmetricDifferenceSet(data1,data2){
    let differences={};
    Object.keys(data1).map((key)=>{
        if(typeof data1[key]=='object'&&typeof data2[key]=='object'){
            if(!(JSON.stringify(data1[key])==JSON.stringify(data2[key]))){differences[key]=data2[key];}
        }else{
            if(!(data1[key]==data2[key])){differences[key]=data2[key];}
        }
    });
    return {diff: differences,change: JSON.stringify(differences)=='{}'?false:true};
}
export function intersection(nums1,nums2){
    return [...new Set(nums1)].filter((item) => {
        return nums2.includes(item);
    });
}
export function sortBy(attr,rev=1){
    if(rev==undefined){rev=1}else{(rev)?1:-1;}
    return function(a,b){
        a=a[attr];
        b=b[attr];
        if(a<b){ return rev*-1}
        if(a>b){ return rev* 1 }
        return 0;
    }
}
export function removeDuplicate(arr){
    const newArr=[];
    const obj={};
    arr.forEach((item)=>{
        if(!obj[JSON.stringify(item)]){
            newArr.push(item);
            obj[JSON.stringify(item)]=true;
        }
    });
    return newArr;
}
export function getIntersection(arrs){
    if(arrs.length<=0){return [];}
    for(const key in arrs){
        if(Object.prototype.hasOwnProperty.call(arrs,key)){
            if(arrs[key]===undefined){delete arrs[key];}
        }
    }
    let _temp;
    arrs.forEach((arr)=>{
        if(!_temp){_temp=arr;return;}
        _temp=_temp.filter((item)=>{return arr.map((item)=>{return item.id}).includes(item.id)});
    });
    return _temp;
}
export function deepClone(obj, hash = new WeakMap()) {
    // 处理null、undefined和非对象类型
    if(obj===null||typeof obj!=='object'){return obj;}
    // 处理Date对象
    if(obj instanceof Date){return new Date(obj);}
    // 处理Array对象
    if(Array.isArray(obj)) {
        // 检查数组是否已经被拷贝过（处理循环引用）
        if(hash.has(obj)){return hash.get(obj);}
        const clone=[];
        hash.set(obj,clone);
        for(let i=0;i<obj.length;i++){clone[i]=deepClone(obj[i],hash);}
        return clone;
    }
    // 处理普通对象
    if(obj.constructor===Object){
        // 检查对象是否已经被拷贝过（处理循环引用）
        if(hash.has(obj)){return hash.get(obj);}
        const clone={};
        hash.set(obj,clone);
        for(const key in obj){if(obj.hasOwnProperty(key)){clone[key]=deepClone(obj[key],hash);}}
        return clone;
    }
    throw new Error('Unable to copy obj! Its type isn\'t supported.');
}
//去数组空项
export function removeEmptyItemsFromFirstLevel(arr) {
    // return arr.filter(item=>!(item===undefined||item===null||(Array.isArray(item)&&item.length===0)))
    return arr;
}