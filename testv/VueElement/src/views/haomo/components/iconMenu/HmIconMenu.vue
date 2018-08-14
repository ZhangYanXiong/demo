<template>
  <div class="app-container documentation-container">
    <el-collapse v-model="activeNames" @change="handleChange">
      <el-collapse-item title="" name="1" style="width: 90%;margin:0 auto">
        <el-row :gutter="20">
          <el-col :span="4" v-for="(item,key) in icons" :key="key" style="margin-bottom: 20px;">
            <i :class="item.className" style="margin-left: 5px;"></i>
            <p>
              <i class="hm-icon-menu_i" :style="{backgroundColor: item.color}"></i>
              <span>{{item.text}}</span>
            </p>
          </el-col>
        </el-row>

      </el-collapse-item>
    </el-collapse>
  </div>
</template>

<script>
  import _ from 'lodash'
  import request from '@/utils/request'

  /**
   * 毫末科技的组件.
   *
   *   demo地址: factory.haomo-studio.com/vue-element/#/haomo/components/forms
   * @author 王康
   */
  export default {
    name: 'HmIconMenu',
    // 集成其他组件
    extends: {},
    // 使用其它组件
    components: {
    },
    // 混入公共对象
    mixins: [],
    props: {
      /**
       * 必传，组件所使用的表定义schema。表定义schema，请使用 model2codejs 从pdm文件生成schema。
       * 对于所有毫末科技的组件，必传schema，以完成数据的交互
       */
      schema: {
        type: Object,
        required: false
      },
      /**
       * 必传，指定要显示的表单字段及类型。数组的每个元素须有name和widgetType两个字段，name表示要显示的表单字段，widgetType表示该字段要显示的表单类型(普通输入框、文本域、富文本、下拉框...)，取值1-7(1表示普通输入框,2表示下拉框,3表示复选框,4表示文本域,5表示富文本,6表示日期格式，7表示单选框)，若表单类型为下拉框/复选框/单选框，还需传入options字段，值为数组(数组元素是下拉框/复选框/单选框的选项），对于复选框，如果只有一个备选项则不必传options
       * 示例：[
       *        { name: 'username', widgetType: 1 },
       *        { name: 'securityLevel', widgetType: 5 },
       *        { name: 'type', widgetType: 2, options: ['企业', '代理商'] },
       *        { name: 'avatar', widgetType: 3 }, { name: 'departmentId', widgetType: 4 },
       *        { name: 'createTime', widgetType: 6 }
       *      ]
       */
      columns: {
        type: Array,
        required: false,
        validator: function(value) {
          if (typeof value !== 'object') {
            console.warn(`传入的columns不符合要求，必须是数组`)
            return false
          }

          return true
        }
      }
    },
    data() {
      return {
        activeNames: '1',
        icons: [
          { className: 'icon-公文审批', text: '公文审批', color: '#f7b55d' },
          { className: 'icon-微平台', text: '微平台', color: '#4ea8ec' },
          { className: 'icon-综合OA', text: '综合OA', color: '#f7b55d' },
          { className: 'icon-议题征集', text: '议题征集', color: '#00bf8b' },
          { className: 'icon-通讯录导出', text: '通讯录导出', color: '#f7b55d' },
          { className: 'icon-检察课堂', text: '检察课堂', color: '#4ea8ec' },
          { className: 'icon-检察官网', text: '检察官网', color: '#4ea8ec' },
          { className: 'icon-总值电话', text: '总值电话', color: '#00bf8b' },
          { className: 'icon-数据统计', text: '数据统计', color: '#f7b55d' },
          { className: 'icon-内部公告', text: '内部公告', color: '#00bf8b' },
          { className: 'icon-应用下载', text: '应用下载', color: '#4ea8ec' }
        ]
      }
    },
    created() {
      // this.init()
    },
    methods: {
      handleChange(val) {
        console.log(val)
      },
      init() {
        const self = this
        // 如果没有传columns，则全部显示
        // if (!self.columns || !self.columns.length) {
        //   _.each(self.schema['columns'], function(column) {
        //     const tmp = JSON.parse(JSON.stringify(column))
        //     self.$set(tmp, 'code', tmp.code.toLowerCase())
        //     self.showUserColumns.push(tmp)
        //   })
        // } else
        if (self.columns && self.columns.length) {
          self.showUserColumns = JSON.parse(JSON.stringify(self.columns))
          // console.log(self.showUserColumns)
          // 将字符串对象进行替换处理
          _.each(self.showUserColumns, function(column, index) {
            if (typeof column === 'object') {
              // 生成一个新对象
              const tmp = _.keyBy(self.schema['columns'], 'codeCamel')[column.name]
              // console.log(tmp)
              self.$set(tmp, 'code', tmp.code.toLowerCase())
              self.$set(tmp, 'widgetType', column.widgetType || 1)
              column.options && self.$set(tmp, 'options', column.options)
              self.$set(self.showUserColumns, index, tmp) // 顺序
              // console.log(self.showUserColumns)
            }
          })
          console.log(self.showUserColumns)
          // 提取v-model绑定的变量
          _.each(self.showUserColumns, function(item) {
            if (item.widgetType === 3 && item.options && item.options.length > 0) {
              self.$set(self.formModel, item.codeCamel, [])
            } else {
              self.$set(self.formModel, item.codeCamel, '')
            }
          })

          if (!request.defaults.baseURL) {
            request.defaults.baseURL = '/org/api'
          }
        } else {
          console.log('columns为必传字段!!')
        }
      }
    }

  }
</script>
<style scoped>
  @import './iconfont.css';

  .hm-icon-menu_i{
    display: inline-block;
    width: 7px;
    height: 7px;
    border-radius: 50%;
    margin-right: 5px;
  }
</style>
