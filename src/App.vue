<template>
  <div id="app">
    <Router-view/>
  </div>
</template>

<script>
export default {
  name: 'App',
  components: {
  }
}
</script>
<style>
  [theme='light']:root{
    --border-radius: 8px;
    --main-background-color: rgb(33, 173, 255);
    --border-color: rgba(0, 0, 0, .1);
    --hover-color: #409EFF;
    --hover-bg: rgba(48, 48, 48, 0.1);
    --common-bg-color: rgb(255,255,255);
    --common-font-color: #000;
    --common-light-bg-color: rgb(242,243,245);
    --main-color:rgba(252,253,214,0.5);
    --second-color:rgba(254,254,229,0.5);
    --common-shadow-color: rgba(28,28,36,0.2);
    --scrollbar-color: rgba(120, 255, 62, 0.6);
  }
  [theme='dark']:root{
    --border-radius: 8px;
    --main-background-color: rgb(33, 173, 255);
    --border-color: rgba(255,255,255,.1);
    --hover-color: #409EFF;
    --hover-bg: rgba(207,207,207,0.1);
    --common-bg-color: rgba(28, 28, 36, 1);
    --common-font-color: #fff;
    --common-light-bg-color: rgb(20,20,30);
    --main-color:rgba(252,253,214,0.5);
    --second-color:rgba(254,254,229,0.5);
    --common-shadow-color: rgba(0,0,0,0.2);
    --scrollbar-color: rgba(120,255,62,0.9);
  }
</style>
