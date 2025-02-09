<template>
  <div class="home">
    <Header :user="[]"></Header>
    <el-container class="container">
      <Menu :sort="true"></Menu>
      <el-container>
        <Bread></Bread>
        <el-main class="main"><router-view></router-view></el-main>
        <el-footer class="footer"><Footer></Footer></el-footer>
      </el-container>
    </el-container>
  </div>
</template>
<script>
import Header from "@/components/common/Header";
import Menu from "@/components/common/Menu";
import Footer from "@/components/common/Footer";
import Bread from "@/components/common/Breadcrumb";
import {check} from '@/api/api.js';
export default {
  name: 'HomePage',
  components:{Header,Menu,Footer,Bread},
  data(){
    return{
      navs: [],
    }
  },
  created(){check().then((res)=>{if(!(res.status===200)){return this.$router.push('/login').catch(()=>{});}})}
}
</script>
<style lang="scss">
  .home{
    height: 100%;
    width: 100%;
    .container{
      position: absolute;
      width: 100%;
      top: 55px;
      bottom: 0;
      background-color: var(--common-bg-color);
      transition: 0.3s;
      color: var(--common-font-color);
      .main{padding: 8px;}
      .footer{padding: 2px;}
    }
  }
  .el-pagination{
    margin-top: 20px;
  }
  .el-table tr,.el-table th.el-table__cell{
    background-color: var(--common-bg-color);
    color: var(--common-font-color);
    transition: .3s;
  }
  .el-table tr:hover>td,.el-date-table td.in-range div,.el-date-table td.in-range div:hover, .el-date-table.is-week-mode .el-date-table__row.current div, .el-date-table.is-week-mode .el-date-table__row:hover div,.el-select-dropdown__item.hover,.el-select-dropdown__item:hover,.el-tree-node__content:hover, .el-upload-list__item:hover{
    background-color: var(--common-light-bg-color) !important;
  }
  .el-input__inner,.el-message-box{
    background-color: var(--common-bg-color);
    border: 1px solid var(--border-color);
    color: var(--common-font-color);
    transition: .3s;
  }
  .el-pagination__total,.el-message-box__title,.el-message-box__message p{
    color: var(--common-font-color);
    transition: .3s;
  }
  .el-pagination .btn-next,.el-pagination .btn-prev,.el-pager li,.el-pagination button:disabled,.el-range-input,.el-input-number__decrease,.el-input-number__increase,.el-radio.is-bordered,.el-card{
    background-color: var(--common-bg-color);
    color: var(--common-font-color);
    transition: .3s;
    border-color: var(--border-color);
  }
  .el-pagination .btn-next,.el-pagination .btn-prev{
    color: rgb(48, 49, 51);
  }
  .el-pagination .btn-next:hover,.el-pagination .btn-prev:hover{
    color: var(--hover-color);
  }
  .el-pagination button:disabled{
    color: rgb(48, 49, 51) !important;
  }
  .el-table td.el-table__cell, .el-table th.el-table__cell.is-leaf,.el-date-table th,.el-date-picker__header--bordered{
    border-bottom: 1px solid var(--border-color);
  }
  .el-table--border .el-table__cell, .el-table__body-wrapper .el-table--border.is-scrolling-left~.el-table__fixed,.el-date-range-picker__content.is-left{
    border-right: 1px solid var(--border-color);
  }
  .el-table--border, .el-table--group{
    border: 1px solid var(--border-color);
  }
  .el-table--border::after, .el-table--group::after, .el-table::before{
    background-color: transparent;
  }
  .el-table, .el-table__expanded-cell{
    background-color: transparent;
  }
  .el-dialog,.el-picker-panel,.el-select-dropdown,.el-textarea__inner,.el-textarea .el-input__count,.el-input.is-disabled .el-input__inner,.el-tree,.el-picker-panel__footer{
    background: var(--common-bg-color);
    color: var(--common-font-color);
    border-color: var(--border-color);
  }
  .el-dialog__title,.el-form-item__label,.el-date-editor .el-range-separator{
    color: var(--common-font-color);
  }
  .el-popper[x-placement^=bottom] .popper__arrow::after{
    border-bottom-color: var(--common-bg-color);
  }
  .el-popper[x-placement^=bottom] .popper__arrow,.el-date-picker__time-header{
    border-bottom-color: var(--border-color);
  }
  .el-picker-panel{
    border: 1px solid var(--border-color);
  }
  .el-select-dropdown__item>span{
    color: var(--common-font-color);
  }
  .el-input.is-disabled .el-input__inner{
    opacity: .4;
  }
  .el-tree-node__content,.el-tree-node:focus>.el-tree-node__content{
    border-radius: var(--border-radius);
    background-color: var(--common-bg-color);
  }
  .el-dialog{
    width: 80%;
    max-width: 520px;
  }
  .el-radio{
    margin-right: 0;
  }
  .picker-date {
    .el-date-picker__header {
      span:nth-child(3) {
        display: none;
      }
      button:nth-child(1) {
        display: none;
      }
      button:nth-child(5) {
        display: none;
      }
    }
  }
  .el-textarea .el-input__count{
    height: 20px;
    line-height: 20px;
  }
  .el-dialog__wrapper{
    display: flex;
  }
  .el-dialog{
    margin: auto !important;
  }
  .radius-right-none{
    .el-input__inner{
      border-top-right-radius: 0;
      border-bottom-right-radius: 0;
    }
  }
  .radius-left-none{
    .el-input__inner{
      border-top-left-radius: 0;
      border-bottom-left-radius: 0;
    }
  }
  .el-popper[x-placement^=top] .popper__arrow::after{
    border-top-color: var(--common-bg-color);
  }
  .el-popper[x-placement^=top] .popper__arrow{
    border-top-color: var(--border-color);
  }
  // .el-button{
    // }
  .el-button.el-button--default{
    background-color: var(--common-bg-color);
    border-color: var(--border-color);
  }
  .bg.el-button.el-button--default:hover{
    background-color: var(--common-light-bg-color);
    border-color: #8c939d;
  }
  .left-border-none{
    .el-input__inner{
      margin-left: -1px;
    }
  }
  .z-indextop .el-input__inner:hover{
    position: relative;
    z-index: 4;
  }
  .el-button--danger{
    background-color: #F56C6C !important;
  }
  .margin-right{
    margin-left: 0px !important;
    margin-right: 4px;
    margin-bottom: 4px;
  }
  // .el-picker-panel__link-btn{
    // border: none;
  // }
  .el-button.is-plain:focus, .el-button.is-plain:hover{
    background-color: var(--common-light-bg-color);
  }
  .el-picker-panel.el-date-picker.el-popper.has-time .el-picker-panel__footer{
    display: flex;
    justify-content: flex-end;
  }
  .el-time-panel{
    background-color: var(--common-bg-color);
    border: 1px solid var(--border-color);
  }
  .el-time-panel__footer{
    border-top: 1px solid var(--border-color);
  }
  .el-time-spinner__item.active:not(.disabled){
    color: var(--common-font-color);
  }
  .el-time-panel__content::after,.el-time-panel__content::before,.el-card__header{
    border-color: var(--border-color);
  }
  .el-time-spinner__item:hover:not(.disabled):not(.active){
    background-color: var(--common-light-bg-color);
  }
  .el-form-item.is-no-asterisk:last-child{
    margin-bottom: 0;
  }
  *::-webkit-scrollbar{
    background-color: transparent;
    display: none;
  }
  *::-webkit-scrollbar-thumb{
    border-radius: 12px;
    border: 4px solid rgba(0,0,0,0);
    box-shadow: 8px 0 0 rgb(94, 94, 94) inset;
    width: 12px;
    // background-color: #000;
  }
  *::-webkit-scrollbar-thumb:hover{
    box-shadow: 8px 0 0 rgb(202, 202, 202) inset;
  }
  /deep/.el-table__body-wrapper{
        overflow-y: scroll;  /*y轴溢出显示滚动条*/
        &::-webkit-scrollbar{/* 取消滚动条宽度 */
            width: 0;
        }
    }
    .el-notification,
    .el-calendar,
    .el-calendar__header,
    .el-calendar-table__row .prev,
    .el-calendar-table__row .current,
    .el-calendar-table__row .next{
      background: var(--common-bg-color) !important;
      border-color: var(--border-color) !important;
    }
    .el-notification__title,.el-notification__content,.el-calendar__title{
      color: var(--common-font-color) !important;
    }
    .el-calendar-day:hover{
      background: var(--hover-bg) !important;
    }
    .el-calendar-table__row .prev,
    .el-calendar-table__row .next{color:rgb(145, 149, 161)!important;}
    .el-calendar__button-group .el-button-group button{
      background-color: var(--common-bg-color)!important;
      border-color: var(--border-color) !important;
      color: var(--common-font-color) !important;
    }
    .el-calendar__button-group .el-button-group button:hover{
      color: var(--common-font-color) !important;
      background: var(--hover-bg) !important;
      color: var(--hover-color) !important;
    }
</style>
