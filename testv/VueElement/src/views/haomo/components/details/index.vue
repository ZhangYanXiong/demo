<template>
  <div>
    <hm-complex-detail :schema="schema['HmUser']" :tableId="tableId">
    </hm-complex-detail>
    <hm-complex-detail :schema="schema['HmUser']" :tableId="tableId" :columns="showUserColumns">
    </hm-complex-detail>
  </div>
</template>

<script>
  import HmComplexDetail from './HmComplexDetail.vue'
  import schema from '../../schemas/hm_org_schema'

  export default {
    name: 'HmComplexDetail',
    // 继承其他组件
    extends: {},
    // 使用其它组件
    components: {
      'hm-complex-detail': HmComplexDetail
    },
    data() {
      return {
        showUserColumns: ['mobile', 'loginid']
      }
    },
    computed: {
    },
    filters: {
    },
    created() {
      this.schema = schema
      this.tableId = '0e26566e953449a7a7500c34be39fd26'
    },
    methods: {}
  }
</script>
<style scoped>
</style>
