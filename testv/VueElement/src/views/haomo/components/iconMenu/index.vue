<template>
  <div class="app-container calendar-list-container">
    <hm-icon-menu>
    </hm-icon-menu>
  </div>
</template>

<script>
  import HmIconMenu from './HmIconMenu.vue'
  import schema from '../../schemas/hm_org_schema'

  export default {
    name: 'HmIconMenuIndex',
    // 继承其他组件
    extends: {},
    // 使用其它组件
    components: {
      'hm-icon-menu': HmIconMenu
    },
    data() {
      return {
        showUserColumns: [{ name: 'username', widgetType: 1 }, { name: 'securityLevel', widgetType: 5 }, { name: 'type', widgetType: 2, options: ['选项1', '选项2'] }, { name: 'avatar', widgetType: 3, options: ['美女', '帅哥'] }, { name: 'departmentId', widgetType: 4 }, { name: 'createTime', widgetType: 6 }, { name: 'loginid', widgetType: 7, options: ['会员', '访客'] }],
        // 要显示按钮 暂只支持确定、保存、取消、提交、重置
        showUserButtons: ['确定', '取消']
        // showUserButtons: []
      }
    },
    computed: {
    },
    filters: {
    },
    created() {
      this.schema = schema
      // console.log(this.schema)
      this.tableId = '0e26566e953449a7a7500c34be39fd26'
    },
    methods: {
      confirm() {
        console.log('确定')
      },
      cancel() {
        console.log('取消')
      }
    }
  }
</script>
<style scoped>
</style>
