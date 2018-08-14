# 毫末科技VueElementTemplate

#### 作者：毫末科技

## 概述

本模板基于[vue-element-admin](https://github.com/PanJiaChen/vue-element-admin)，

官方说明见[官方中文说明](./README.zh-CN.md)

接口使用 http://api.haomo-studio.com/org/swagger-ui.html

毫末科技所有定制的模块，全部放到以下目录里：

    src/views/haomo

除了vue-element-admin，还引入了其他重要的模块：

* [Vue-Awesome](https://github.com/Justineo/vue-awesome)

## 使用

请使用node > 6.10

### 安装

    npm install

### 打包

    npm run build:prod

### 部署

    rsync -avz dist/* member@haomo-studio.com:/var/www/html/software_factory/vue-element/

## 开发

### 目录结构

```bash
# 克隆项目
git clone https://github.com/PanJiaChen/vue-element-admin.git

# 安装依赖
npm install
# 建议不要用cnpm安装 会有各种诡异的bug 可以通过如下操作解决 npm 下载速度慢的问题
npm install --registry=https://registry.npm.taobao.org

# 启动服务
npm run dev
```
浏览器访问 http://localhost:9527

### 发布
```bash
# 构建测试环境
npm run build:sit

# 构建生成环境
npm run build:prod
```

### 生成文档

```bash
# 实时预览文档
npm run styleguide

# 生成html
npm run styleguide:build
```

### 其它
```bash
# --report to build with bundle size analytics
npm run build:prod --report

# --preview to start a server in local to preview
npm run build:prod --preview

# lint code
npm run lint

# auto fix
npm run lint -- --fix
```

## 参考