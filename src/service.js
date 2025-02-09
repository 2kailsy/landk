import axios from 'axios';
import main from "@/main";

const service = axios.create({
    baseURL: '/',
    timeout: 3000,
    withCredentials: true
});
//请求拦截器
service.interceptors.request.use((config)=>{
    // config.headers.Authorization=getToken('token');
    return config;
},(e)=>{return Promise.reject(e)})
//响应拦截器
service.interceptors.response.use((res)=>{
    let {status}=res.data;
    if(status!==200) return main.$router.push('/login').catch(()=>{});
    return res;
},(e)=>{return Promise.reject(e)});

export default service