<template>
  <div class="header">
    <div class="title">2kの后台管理系统</div>
    <div class="user">
      <div class="name">{{ user.nickname }}</div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'HeaderNav',
  props:['user']
}
</script>

<style lang="scss">
  .header{
    background: var(--common-bg-color);
    height: 55px;
    padding: 0 24px;
    box-sizing: border-box;
    display: flex;
    justify-content: space-between;
    width: 100%;
    overflow: hidden;
    line-height: 55px;
    user-select: none;
    transition: .3s;
    color: var(--common-font-color);
    border-bottom: 1px solid var(--border-color);
    .title{
      font-size: 22px;
      font-weight: bold;
      text-align: center;
    }
  }
</style>