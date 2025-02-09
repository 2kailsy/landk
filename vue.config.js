const { defineConfig } = require('@vue/cli-service')
module.exports = defineConfig({
  transpileDependencies: true,
  devServer: {
    open: true,
    host: '::',
		port: 3001,
    hot: true,
    proxy: {
      // '/api': {
      //   target: 'http://2klove.leeweak.cn',
      //   changeOrigin: true,
      //   pathRewrite: {
      //     '^/api': ''
      //   }
      // },
      // '/static': {
      //   target: 'http://2klove.leeweak.cn',
      //   changeOrigin: true
      // }
    }
  },
  outputDir: "dist", // 打包之后所在目录， 默认值 dist
  assetsDir: "./",
  indexPath: "./index.html",
  productionSourceMap: false,
  lintOnSave: false
})
