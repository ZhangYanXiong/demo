<template>
  <div>
    <hm-tab :schema="schema['CcHmUser']"></hm-tab>
  </div>
</template>

<script>
  import HmTab from './HmTab.vue'
  import schema from '../../schemas/hm_org_schema'
  export default {
    name: 'HmTabIndex',
    // 继承其他组件
    extends: {},
    // 使用其它组件
    components: {
      'hm-tab': HmTab
    },
    data() {
      return {
        // 会议、通知通报、公文、会议请假、调班申请、议题征集申请
        //
      }
    },
    computed: {
    },
    filters: {
    },
    created() {
      this.schema = schema
    },
    methods: {}
  }
</script>
<style scoped>
</style>
