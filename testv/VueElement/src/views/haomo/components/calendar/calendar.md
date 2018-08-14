### 基本使用
```jsx
<template>
  <div class="app-container calendar-list-container">
    <hm-full-calendar :schema="schema['HmUser']" :demoEvents="demoEvents"></hm-full-calendar>
  </div>
</template>

<script>
  import HmFullCalendar from './HmFullCalendar.vue'
  import schema from '../../schemas/hm_org_schema'

  export default {
    name: 'HmFullCalendar',
    // 继承其他组件
    extends: {},
    // 使用其它组件
    components: {
      'hm-full-calendar': HmFullCalendar
    },
    data() {
      return {}
    },
    filters: {

    },
    created() {
      this.schema = schema
      this.demoEvents = {
        title: '事件名',
        start: '起始时间',
        end: '结束时间'
      }
    },
    methods: {}
  }
</script>


```

