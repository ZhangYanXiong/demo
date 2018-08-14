<template>
  <div class="app-container calendar-list-container">
    <hm-complex-table :schema="schema['HmUser']"
                      :columns="showUserColumns"
                      :filters="userFilters"
                      :includes="userIncludes"
                      :refers="userRefers"
                      :options="userOptions"
                      :userDefined="userDefined"></hm-complex-table>
  </div>
</template>

<script>
  import HmComplexTable from './HmComplexTable.vue'
  import schema from '../../schemas/hm_org_schema'

  export default {
    name: 'HmComplexTableIndex',
    // 继承其他组件
    extends: {},
    // 使用其它组件
    components: {
      'hm-complex-table': HmComplexTable
    },
    data() {
      return {
        showUserColumns: [
          { name: '手机号', codeCamel: 'mobile', isSort: true },
          { name: '登录ID', codeCamel: 'loginid', isSort: true },
          'username', 'email', { name: '创建时间', codeCamel: 'createTime', isSort: true, width: '130px' }
        ],
        userFilters: [
          { placeholder: '过滤手机号', 'mobile': { 'like': '' }, isShow: true },
          { placeholder: '过滤用户名', 'username': { 'equalTo': '' }, isShow: true },
          { placeholder: ['安全级别大于', '安全级别小于'], 'security_level': { 'greaterThanOrEqualTo': '', 'lessThanOrEqualTo': '' }, isShow: true }
        ],
        userIncludes: {
          'hm_user': {
            includes: ['user_id']
          }
        },
        userRefers: {
          'auth_token': {
            includes: ['userId']
          }
        }
      }
    },
    filters: {
    },
    created() {
      this.schema = schema
      this.userOptions = {
        pageSize: 10,
        sortItem: 'create_time',
        sortOrder: 'desc',
        changeValue: {
          username: { 1: 'Hm-isChecked', 0: 'Hm-noChecked' }
        },
        newData: {
          isShow: true,
          showUserColumns: [
            { name: '姓名', codeCamel: 'username', widgetType: 1 },
            { name: '登录ID', codeCamel: 'loginid', widgetType: 1 },
            { name: '类型', codeCamel: 'type', widgetType: 1 }
          ],
          showUserButtons: [],
          formSchema: schema['HmUser'],
          layout: { left: 0, middle: 24, right: 0 },
          tips: {},
          formStyle: {},
          formRefers: {},
          foreignFormFields: [],
          formRelates: []
        },
        editData: {
          isShow: true,
          showUserColumns: [{ name: '姓名', codeCamel: 'username', widgetType: 1 }],
          showUserButtons: [],
          formSchema: schema['HmUser'],
          layout: { left: 0, middle: 24, right: 0 },
          tips: {},
          formStyle: {},
          formRefers: {},
          foreignFormFields: [],
          formRelates: []
        },
        showDetail: {
          isShow: true
        },
        // HmFullCalendar: {
        // calendarSchema: schema['HmUser'],
        // demoEvents: {
        // title: 'username',
        // start: 'createTime',
        // end: 'lastUpdateTime'
        // }
        // },
        cellStyle: {},
        titleButtonStyle: {},
        tableStyle: { width: '100%' },
        isShowPagination: true,
        isShowSearch: true,
        showRefresh: true,
        showExport: true,
        showDeleteButton: true,
        buttonGroup: false,
        showSelection: true,
        showOverflowTooltip: true,
        tableCurrentChange(value) {}
        // dataProcessing(value, params, definedOperate) {}, // 处理返回后的数据,必须return 处理后的数据
        // promiseProcessing(value, params, definedOperate) {} // 处理返回后的数据,必须return Promise对象
      }
      this.userDefined = {
        definedParams(params, operate) {
          return params
        },
        definedOperate: [
          { type: 'select', label: '', placeholder: '类型', options: [{ label: '姓名', code: 'username' }, { label: '登录ID', code: 'loginid' }], value: '' },
          { type: 'input', label: '', placeholder: '邮箱', code: 'email', value: '' },
          { type: 'datetime', label: '', placeholder: '创建时间', code: 'createTime', value: '' }
        ],
        definedOperation: [{ label: '测试', func: this.dropDown }],
        definedEdit() {

        },
        definedNew() {

        },
        definedDetail() {

        },
        BatchRemove() {
          console.log('BatchRemove')
        }
        // pretreatment() {}
      }
    },
    methods: {
      method1() {
        this.dialogFormVisible = false
        console.log('method1')
      },
      dropDown(value) {
        console.log('输出一些东西', value)
      },
      statusFunc() {
  
      }
    }
  }
</script>
