<template>
  <div>
    <el-calendar class="calendar">
      <template slot-scope="{date}" slot="dateCell">
        <p :class="{ 'is-selected': isSelectedDate(date) }">
          {{ formatDate(date) }}
        </p>
        <div class="day">
          {{ isSelectedDate(date) ? '✔️' : '🤢' }}
        </div>
      </template>
    </el-calendar>
  </div>
</template>
<script>
import {getSign} from '@/api/api';
export default {
  name: 'SignPage',
  data(){return{specialDates: [],month: 1,year: 2025}},
  mounted(){
    let now=new Date();
    getSign(now.getFullYear(),(now.getMonth()+1<10?`0${now.getMonth()+1}`:now.getMonth()+1)).then((res)=>{
      this.specialDates=[];
      this.month=res.data.month;
      this.year=res.data.year;
      for(const cal of res.data.data){this.specialDates.push({day: cal.day, month: res.data.month, year: res.data.year});}
    });
    const calendarHeader=this.$el.querySelector('.el-calendar__header');
    if(calendarHeader){calendarHeader.addEventListener('click',this.handleMonthChange);}
  },
  beforeDestroy(){
    const calendarHeader=this.$el.querySelector('.el-calendar__header');
    if(calendarHeader){calendarHeader.removeEventListener('click',this.handleMonthChange);}
  },
  methods: {
    isSelectedDate(cellDate){
      const cellDateObj = new Date(cellDate);
      return this.specialDates.some(date =>
        date.year==cellDateObj.getFullYear()&&
        date.month==(cellDateObj.getMonth()+1<10?`0${cellDateObj.getMonth()+1}`:cellDateObj.getMonth()+1)&&
        date.day==(cellDateObj.getDate()<10?`0${cellDateObj.getDate()}`:cellDateObj.getDate())
      );
    },
    formatDate(date) {
      const dateObj = new Date(date);
      // return `${dateObj.getMonth()+1<10?`0${dateObj.getMonth()+1}`:dateObj.getMonth()+1}-${dateObj.getDate()<10?`0${dateObj.getDate()}`:dateObj.getDate()}`;
      return `${dateObj.getDate()<10?`0${dateObj.getDate()}`:dateObj.getDate()}`;
    },
    handleMonthChange(event){
      const target = event.target;
      if(target.innerHTML.indexOf("el-calendar__title")==-1&&(target.innerHTML.indexOf("下")==-1||target.innerHTML.indexOf("上")==-1||target.innerHTML.indexOf("今")==-1)){
        if(target.innerHTML.indexOf("下")!=-1){
          if(this.month==12){this.year+=1;this.month=1;}
          else{this.month=parseInt(this.month)+1;}
        }else if(target.innerHTML.indexOf("上")!=-1){
          if(this.month==1){this.year-=1;this.month=12;}
          else{this.month=parseInt(this.month)-1;}
        }else{
          let now=new Date();
          this.month=now.getMonth()+1;
          this.year=now.getFullYear();
        }
        getSign(this.year,(this.month<10?`0${this.month}`:this.month)).then((res)=>{
          this.specialDates=[];
          for(const cal of res.data.data){this.specialDates.push({day: cal.day, month: res.data.month, year: res.data.year});}
        });
      }
      }
    }
};
</script>
<style>
  .calendar .el-calendar-table__row .current{position: relative;}
  .calendar .el-calendar-table__row .prev{position: relative;}
  .calendar .el-calendar-table__row .next{position: relative;}
  .calendar .day{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%,-50%);
    font-size: 2.5em;
    opacity: 0.2;
    user-select: none;
  }
  .calendar .el-calendar__title{
    font-size: 20px;
  }
  .calendar .el-calendar-day{
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 20px;
    font-weight: bolder;
    user-select: none;
  }
  .is-selected {
    color: #1989FA;
  }
</style>