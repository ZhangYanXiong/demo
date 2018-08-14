<!--
  <hm-transfer
    :schema="schema['HmUser']"                    数据库操作对象 Object
    :filterable="true"                            是否显示搜索框 Boolean （必须项）
    :title="['左侧列表', '右侧列表']"               列表标题 Array  （可选项）
    :buttonTexts="['左移', '右移']"                按钮名称 Array  （可选项）
  ></hm-transfer>
-->

<template>
  <hm-transfer
    :schema="schema['HmUser']"
    :filterable="canSearch"
    :title="listTitle"
    :buttonTexts="buttonTexts"
  ></hm-transfer>
</template>

<script>
  import HmTransfer from './HmTransfer'
  import schema from '../../schemas/hm_org_schema'
  export default {
    name: 'HmTransferIndex',
    // 继承其他组件
    extends: {},
    // 使用其它组件
    components: {
      'hm-transfer': HmTransfer
    },
    data() {
      return {}
    },
    computed: {},
    filters: {},
    created() {
      this.schema = schema
      this.canSearch = true
      this.listTitle = ['左侧列表', '右侧列表']
      this.buttonTexts = ['左移', '右移']
    },
    methods: {}
  }
</script>

<style scoped>

</style>
