<template>
  <el-row type="flex">
    <el-col :span="24" class="detail-content">
      <el-form :data="detail" label-width="110px" status-icon style="width:80%;margin:0 auto">
        <el-form-item v-for="(column,index) in showColumns" :key="index" :label="column.name">
          <div>{{detail[column.codeCamel]}}</div>
        </el-form-item>
      </el-form>
    </el-col>
  </el-row>
</template>

<script>
  import _ from 'lodash'
  import request from '@/utils/request'

  /**
   * 毫末科技的详情组件.
   *
   * demo地址: factory.haomo-studio.com/vue-element/#/haomo/components/detail
   * @author 赵帅 zhaoshuai@haomo-studio.com
   */

  export default {
    name: 'HmComplexDetail',
    // 继承其他组件
    extends: {},
    // 使用其它组件
    components: {},
    props: {
      /**
       * 组件所使用的表定义schema。表定义schema，请使用 model2codejs 从pdm文件生成schema。
       * 对于所有毫末科技的组件，必须传schema，以完成数据的交互
       */
      schema: {
        type: Object,
        required: true
      },
      /**
       * 指定要显示的列。默认为根据schema得到的所有列。完整示例为：
       *  [
       *    {
       *      "name": "姓名",
       *      "code": "username",
       *      "render": function(value){
       *        return "<a href='value'></a>"
       *      }
       *    },
       *    "mobile",
       *    "sexual"
       *  ]
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
      },
      /**
       * 在详情页需要传入用户的id用来带出用户信息
       */
      tableId: {
        type: String,
        required: true
      }
    },
    data() {
      return {
        list: null,
        detail: null,
        showColumns: [] // 要显示的列数据,
      }
    },
    computed: {
    },
    filters: {
    },
    created() {
      this.getList()
      this.init()
    },
    methods: {
      validate() {
        const self = this
        // this.columns数组元素本身必须是string或者object. 且必须是schema中定义的列
        // 由于vue中不允许通过其他的props来验证当前props，只能在created里进行调用
        _.each(self.columns, function(item) {
          if (!item) {
            return 0
          }

          if (typeof item !== 'string' && typeof item !== 'object') {
            console.error(`传入的columns不符合要求，数组元素必须是字符串或对象`)
          }
          if (typeof item === 'string' && !_.keyBy(self.schema['columns'], 'code')[item.toUpperCase()]) {
            console.error(`传入的columns不符合要求，字符串元素[${item}]必须是schema中定义的列[code]`)
          }
          if (typeof item === 'object' && !_.keyBy(self.schema['columns'], 'code')[item['code'].toUpperCase()]) {
            console.error(`传入的columns不符合要求，元素的code属性[${item['code']}]必须是schema中定义的列[code]`)
          }
        })
      },
      init() {
        const self = this
        // 处理要显示的列
        if (!self.columns || !self.columns.length) {
          _.each(self.schema['columns'], function(column) {
            const tmp = JSON.parse(JSON.stringify(column))
            self.showColumns.push(tmp)
          })
        } else {
          self.showColumns = []
          // 将字符串对象进行替换处理
          _.each(self.columns, function(item) {
            _.each(self.schema['columns'], function(column) {
              if (item === column.codeCamel) {
                console.log(item)
                const tmp = JSON.parse(JSON.stringify(column))
                self.showColumns.push(tmp)
              }
            })
          })
        }
        if (!request.defaults.baseURL) {
          request.defaults.baseURL = '/org/api'
        }
        console.log(request.defaults)
        console.log(`request.defaults.baseURL: ${request.defaults.baseURL}`)
      },
      getList: function() {
        const self = this
        self.listLoading = true
        const params = {}
        // 拿到所有的用户
        request(self.schema.modelUnderscorePlural, {
          params: params
        }).then(resp => {
          self.list = resp.data
          // 匹配需要展示的用户
          _.each(self.list, function(item) {
            if (item.id === self.tableId) {
              self.detail = item
            }
          })
        })
      }
    }
  }
</script>
<style scoped>
  .title{
    text-align: center;
  }
</style>
