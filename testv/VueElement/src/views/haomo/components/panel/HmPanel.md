### 基本使用

```jsx
    <hm-panel :options="{
        'panel_class': 'center',
        'title_class': 'weight',
        'content_class': 'center',
        'panel_style': {
          width: '100%',
          margin: '20px auto'
        },
        'panel_span': 22,
        'content_height': {
          height: '600px'
        },
        'canCollapse': true
      }">
      <div slot="title">面板标题</div>
      <div slot="content">面板内容</div>
    </hm-panel>
```
### 不可收起的panel

```vue
<template>
  <div>
    <hm-panel :options="options">
      <div slot="title">测试面板</div>
      <div slot="content">面板内容</div>
    </hm-panel>
  </div>
</template>

<script>
  export default {
    name: 'HmPanel',
    data() {
      return {
      }
    },
    created() {
      this.options = {
        panel_class: 'center',
        title_class: 'center',
        content_class: 'center',
        panel_style: {
          width: '80%',
          background: '#42b983',
          margin: '0 auto'
        },
        panel_span: 20,
        canCollapse: false
      }
      this.schema = schema
      this.showFields = ['username', 'loginid', 'password', 'mobile', 'email']
    }
  }
</script>
```