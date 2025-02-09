<template>
  <div>
    <div class="headers">
      <div class="hed">
        <el-card shadow="hover">
          <div slot="header" style="text-align: center;">
            <span>搜索总数</span>
          </div>
          <div class="card-flex">
            <div class="text">{{ systemInfo.article_total }}</div>
            <div class="icon">
              <img :src="srcs['paintRoller_light']" v-show="lightOrDark=='light'">
              <img :src="srcs['paintRoller_dark']" v-show="lightOrDark=='dark'">
            </div>
          </div>
        </el-card>
        <el-card shadow="hover">
          <div slot="header" style="text-align: center;">
            <span>相册总数</span>
          </div>
          <div class="card-flex">
            <div class="text">{{ systemInfo.images_total }}</div>
            <div class="icon">
              <img :src="srcs['house_light']" v-show="lightOrDark=='light'">
              <img :src="srcs['house_dark']" v-show="lightOrDark=='dark'">
            </div>
          </div>
        </el-card>
        <el-card shadow="hover">
          <div slot="header" style="text-align: center;">
            <span>留言总数</span>
          </div>
          <div class="card-flex">
            <div class="text">{{ systemInfo.sayme_total }}</div>
            <div class="icon">
              <img :src="srcs['bulb_light']" v-show="lightOrDark=='light'">
              <img :src="srcs['bulb_dark']" v-show="lightOrDark=='dark'">
            </div>
          </div>
        </el-card>
        <el-card shadow="hover">
          <div slot="header" style="text-align: center;">
            <span>运行时间</span>
          </div>
          <div class="card-flex">
            <div class="text">{{ systemInfo.run_time }}</div>
            <div class="icon">
              <img :src="srcs['clock_light']" v-show="lightOrDark=='light'">
              <img :src="srcs['clock_dark']" v-show="lightOrDark=='dark'">
            </div>
          </div>
        </el-card>
      </div>
      <div class="bdy">
        <div class="left" style="flex: 1;">
          <el-card style="margin: 0;">
            <div slot="header" style="display: flex;align-items: center;"><span class="text">🥂动态</span></div>
            <el-timeline>
              <el-timeline-item
                v-for="(activity,index) in activities"
                :key="index"
                :icon="activity.icon"
                :type="activity.type"
                :color="activity.color"
                :timestamp="activity.timestamp" placement="top">
                <el-card>
                  <h4>{{activity.content}}</h4>
                </el-card>
              </el-timeline-item>
            </el-timeline>
          </el-card>
        </div>
        <div class="mid" style="flex: 1;">
          <el-card style="margin: 0;">
            <div slot="header" style="display: flex;align-items: center;">
              <svg class="icon" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" width="18" height="18">
                  <path d="M864.801 895.471h-33.56v-96.859c0-126.081-73.017-235.093-179.062-287.102 106.046-52.01 179.062-161.022 179.062-287.102v-96.859h33.56c17.301 0 31.325-14.327 31.325-32 0-17.673-14.024-32-31.325-32H159.018c-17.3 0-31.325 14.327-31.325 32 0 17.673 14.025 32 31.325 32h33.02v96.859c0 126.08 73.016 235.092 179.061 287.102-106.046 52.009-179.062 161.02-179.062 287.101v96.859h-33.02c-17.3 0-31.325 14.326-31.325 32s14.025 32 31.325 32H864.8c17.301 0 31.325-14.326 31.325-32s-14.023-31.999-31.324-31.999zM256.05 222.427v-94.878h513.046v94.878c0 141.674-114.85 256.522-256.523 256.522-141.674 0-256.523-114.848-256.523-256.522zm513.046 673.044H256.05v-94.879c0-141.674 114.849-256.521 256.523-256.521 141.673 0 256.523 114.848 256.523 256.521v94.879z"></path>
                  <path d="M544.141 384c0-17.69-14.341-32.031-32.031-32.031-71.694 0-127.854-56.161-127.854-127.855 0-17.69-14.341-32.032-32.031-32.032s-32.032 14.341-32.032 32.032c0 107.617 84.3 191.918 191.917 191.918 17.69 0 32.031-14.342 32.031-32.032z"></path>
                </svg>
                <span class="text">人生倒计时</span>
            </div>
            <div v-for="(item,index) in items" :key="index" class="timelife">
              <div class="contain">
                <div class="item">
                  <div class="title">
                    {{ item.title }}
                    <span class="text">{{ item.num }}</span>
                    {{ item.endTitle }}
                  </div>
                  <div class="progress">
                    <div class="progress-bar">
                      <div
                        :class="`progress-bar-inner progress-bar-inner-${index}`"
                        :style="{ width: item.percent }"
                      ></div>
                    </div>
                    <div class="progress-percentage">{{ item.percent }}</div>
                  </div>
                </div>
              </div>
            </div>
          </el-card>
        </div>
        <div class="right">
          <el-card style="margin: 0;">
            <div slot="header" style="text-align: center;">
              <span>系统信息</span>
            </div>
            <div class="card-flex sys">
              <template>
                <el-table :data="systemInfo.system" border :show-header="false">
                  <el-table-column prop="label"></el-table-column>
                  <el-table-column prop="value"></el-table-column>
                </el-table>
              </template>
            </div>
          </el-card>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {getSystemInfo} from '@/api/api';
export default {
  name: 'WebAdminPage',
  data(){
    return {
      lightOrDark: 'light',
      systemInfo: {},
      activities: [{
        content: '移动端适配',
        timestamp: '2025-02-07 13:08:47',
        color: '#02cd1d'
      },{
        content: '增加`人生倒计时`模块',
        timestamp: '2025-02-06 13:56:20',
        color: '#02cd1d'
      },{
        content: 'Do something else...',
        timestamp: '2025-02-06 13:14:20',
        type: 'primary',
        icon: 'el-icon-more'
      },{
        content: '编写完成',
        timestamp: '2025-02-06 13:12:55',
        color: '#02cd1d'
      },{
        content: '开始编写后台管理系统',
        timestamp: '2025/01/31 21:29:20',
        color: '#d955a7'
      }],
      items: [{
        title: "今日已经过去",
        endTitle: "小时",
        num: 0,
        percent: "0%",
      },{
        title: "这周已经过去",
        endTitle: "天",
        num: 0,
        percent: "0%",
      },{
        title: "本月已经过去",
        endTitle: "天",
        num: 0,
        percent: "0%",
      },{
        title: "今年已经过去",
        endTitle: "个月",
        num: 0,
        percent: "0%",
      }]
    }
  },
  created(){
    getSystemInfo().then((res)=>{this.systemInfo=res;});
    this.lightOrDark=localStorage.getItem('cache_dark')=='true'?'dark':'light';
  },
  mounted(){
    window.addEventListener('setItemEvent',(event)=>{
      if(event.key==='cache_dark'){
        this.lightOrDark=event.newValue=='true'||event.newValue==true?'dark':'light';
      }
    });
    this.getLifeTime();
  },
  methods:{
    getLifeTime(){
      // 更新本日进度
      const now = new Date();
      const startOfDay = new Date(now.toLocaleDateString()).getTime();
      const hoursPassed = (now - startOfDay) / 1000 / 60 / 60;
      const dayProgress = (hoursPassed / 24) * 100;
      this.items[0].num = parseInt(hoursPassed);
      this.items[0].percent = `${parseInt(dayProgress)}%`;
      // 更新本周进度
      const weekDayMap = { 0: 7, 1: 1, 2: 2, 3: 3, 4: 4, 5: 5, 6: 6 };
      const weekDay = weekDayMap[now.getDay()];
      const weekProgress = (weekDay / 7) * 100;
      this.items[1].num = weekDay;
      this.items[1].percent = `${parseInt(weekProgress)}%`;
      // 更新本月进度
      const year = now.getFullYear();
      const month = now.getMonth() + 1;
      const dayOfMonth = now.getDate();
      const daysInMonth = new Date(year, month, 0).getDate();
      const monthProgress = (dayOfMonth / daysInMonth) * 100;
      this.items[2].num = dayOfMonth;
      this.items[2].percent = `${parseInt(monthProgress)}%`;
      // 更新今年进度
      const yearProgress = (month / 12) * 100;
      this.items[3].num = month;
      this.items[3].percent = `${parseInt(yearProgress)}%`;
    },
  },
  computed:{
    srcs(){
      return {
        bulb_light: require(`../../assets/img/bulb_light.svg`),
        bulb_dark: require(`../../assets/img/bulb_dark.svg`),
        house_light: require(`../../assets/img/house_light.svg`),
        house_dark: require(`../../assets/img/house_dark.svg`),
        clock_light: require(`../../assets/img/clock_light.svg`),
        clock_dark: require(`../../assets/img/clock_dark.svg`),
        paintRoller_light: require(`../../assets/img/paintRoller_light.svg`),
        paintRoller_dark: require(`../../assets/img/paintRoller_dark.svg`),
      }
    }
  }
}
</script>

<style lang="scss" scoped>
  .headers{
    display: flex;
    flex-direction: column;
    .hed{
      display: flex;
      width: 100%;
      margin-bottom: 8px;
    }
    .bdy{
      display: flex;
      .left,.mid{
        margin-right: 8px;
      }
      .right{min-width: 430.5px;}
    }
    .el-card{
      flex: 1;
      margin-right: 8px;
    }
    .el-card:last-child{
      margin: 0;
    }
    .card-flex{
      display: flex;
      justify-content: space-between;
      align-items: center;
      .text{
        color: var(--common-font-color);
        font-weight: bolder;
        font-size: 32px;
        text-align: center;
        flex: 1;
      }
      .icon{
        transition: .3s;
        img{
          height: 80px;
          transition: .3s;
        }
      }
    }
  }
  .el-table--border,.el-table--group{border-right: none;border-bottom: none;}
  .icon path{fill: var(--common-font-color)}
  .timelife .item {margin: 20px 0 15px 0;}
  .timelife .item:last-child{margin-bottom: 0}
  .timelife .item .title {
    font-size: 12px;
    color: var(--common-font-color);
    margin-bottom: 5px;
    display: flex;
    align-items: center
  }
  .timelife .item .title .text{
    color: var(--common-font-color);
    font-weight: 500;
    font-size: 14px;
    margin: 0 5px
  }
  .timelife .item .progress{
    display: flex;
    align-items: center;
  }
  .timelife .item .progress-bar {
    height: 14px;
    border-radius: 8px;
    overflow: hidden;
    width: 0;
    min-width: 0;
    flex: 1;
    margin-right: 5px;
    background-color: var(--hover-bg);
  }
  .timelife .item .progress-bar-inner {
    width: 0;
    height: 100%;
    border-radius: 5px;
    transition: width 0.35s;
    -webkit-animation: progress 750ms linear infinite;
    animation: progress 750ms linear infinite
  }
  .timelife .item .progress-bar-inner-0 {
    background: #bde6ff;
    background-image: linear-gradient(135deg, #50bfff 25%, transparent 25%, transparent 50%, #50bfff 50%, #50bfff 75%, transparent 75%, transparent 100%);
    background-size: 30px 30px
  }
  .timelife .item .progress-bar-inner-1 {
    background: #ffd980;
    background-image: linear-gradient(135deg, #f7ba2a 25%, transparent 25%, transparent 50%, #f7ba2a 50%, #f7ba2a 75%, transparent 75%, transparent 100%);
    background-size: 30px 30px
  }
  .timelife .item .progress-bar-inner-2 {
    background: #ffa9a9;
    background-image: linear-gradient(135deg, #ff4949 25%, transparent 25%, transparent 50%, #ff4949 50%, #ff4949 75%, transparent 75%, transparent 100%);
    background-size: 30px 30px;
  }
  .timelife .item .progress-bar-inner-3{
    background: #8bc46f;
    background-image: linear-gradient(135deg,#4f9e28 25%,transparent 25%, transparent 50%, #4f9e28 50%,#4f9e28 75%,transparent 75%,transparent 100%);
    background-size: 30px 30px;
  }
  .el-card__body, .el-main{padding: 8px !important;}
</style>
<style lang="scss" scoped>
@media screen and (max-width: 950px){
  .headers{
    display: flex;
    flex-direction: column;
    .hed{flex-direction: column;}
    .bdy{
      flex-direction: column;
      .left,.mid{
        margin-right: 0;
        margin-bottom: 8px;
      }
      .right{min-width: 0;}
    }
    .el-card{
      flex: 1;
      margin-right: 0;
      margin-bottom: 8px;
    }
    .card-flex{
      display: flex;
      justify-content: space-between;
      align-items: center;
      .text{
        color: var(--common-font-color);
        font-weight: bolder;
        font-size: 32px;
        text-align: center;
        flex: 1;
      }
      .icon{
        transition: .3s;
        img{
          height: 80px;
          transition: .3s;
        }
      }
    }
  }
}
</style>