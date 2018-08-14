<template xmlns="http://www.w3.org/1999/html">
  <div class="app-container calendar-list-container">
    <!-- 过滤 -->
    <div class="filter-container">
      <el-form :inline="true">
        <!-- 过滤条件 -->
        <span v-for="filter in filters" class="hm-complex-table__filter-span">
          <el-input @keyup.enter.native="handleFilter"
                    style="width: 200px;"
                    class="filter-item"
                    clearable
                    :placeholder="filter.placeholder"
                    v-if="filter.isShow && isShowFilter(filter)"
                    v-model="listQuery.filters[schema['modelUnderscore']][getFilterColumn(filter)][getFilterOper(filter)]">
          </el-input>

          <el-input @keyup.enter.native="handleFilter"
                    style="width: 200px;"
                    class="filter-item"
                    clearable
                    :placeholder="filter.placeholder[0]"
                    v-if="filter.isShow && !isShowFilter(filter) && !isDatetimeFilter(filter)"
                    v-model="listQuery.filters[schema['modelUnderscore']][getFilterColumn(filter)][getFilterOper(filter)]">
          </el-input>
          <el-input @keyup.enter.native="handleFilter"
                    style="width: 200px;"
                    class="filter-item"
                    clearable
                    :placeholder="filter.placeholder[1]"
                    v-if="filter.isShow && !isShowFilter(filter) && !isDatetimeFilter(filter)"
                    v-model="listQuery.filters[schema['modelUnderscore']][getFilterColumn(filter)][getFilterOperTwin(filter)]">
          </el-input>

          <el-date-picker type="datetime"
                          align="right"
                          class="filter-item hm-complex-table__filter-span"
                          @keyup.enter.native="handleFilter"
                          value-format="yyyy-MM-dd HH:mm:ss"
                          :placeholder="filter.placeholder[0]"
                          v-if="filter.isShow && !isShowFilter(filter) && isDatetimeFilter(filter)"
                          v-model="listQuery.filters[schema['modelUnderscore']][getFilterColumn(filter)][getFilterOper(filter)]">
          </el-date-picker>
          <el-date-picker type="datetime"
                          align="right"
                          class="filter-item"
                          @keyup.enter.native="handleFilter"
                          value-format="yyyy-MM-dd HH:mm:ss"
                          :placeholder="filter.placeholder[1]"
                          v-if="filter.isShow && !isShowFilter(filter) && isDatetimeFilter(filter)"
                          v-model="listQuery.filters[schema['modelUnderscore']][getFilterColumn(filter)][getFilterOperTwin(filter)]">
          </el-date-picker>
        </span>
        <!-- end 过滤条件 -->
        <!--自定义-->
        <span v-if="definedOperate.length" v-for="operate in definedOperate">
          <!--自定义按钮-->
          <el-button v-if="operate.type == 'button'" :style="operate.style" class="filter-item" type="primary" v-waves :icon="operate.icon" @click="operate.func">{{operate.label}}</el-button>
          <!--自定义下拉选择-->
          <el-form-item v-if="operate.type == 'select'" :label="operate.label">
            <el-select v-model="operate.value" :placeholder="operate.placeholder" @change="selectChange(operate.func, operate.value)" clearable>
              <el-option v-for="o in operate.options" :label="o.label" :value="o.code"></el-option>
            </el-select>
          </el-form-item>
          <!--自定义输入框-->
          <el-form-item v-if="operate.type == 'input'" :label="operate.label">
            <el-input @keyup.enter.native="handleFilter"
                      style="width: 200px;"
                      clearable
                      class="filter-item"
                      :placeholder="operate.placeholder"
                      v-model="operate.value">
            </el-input>
          </el-form-item>
          <!--自定义时间选择-->
          <el-form-item v-if="operate.type == 'datetime' || operate.type == 'date'" :label="operate.label">
            <el-date-picker :type="operate.type || 'datetime'"
                            class="filter-item"
                            @keyup.enter.native="handleFilter"
                            :value-format="operate.valueFormate || 'yyyy-MM-dd HH:mm:ss'"
                            :placeholder="operate.placeholder"
                            v-model="operate.value">
            </el-date-picker>
          </el-form-item>
        </span>

        <!--预定义按钮-->
        <el-button-group v-if="buttonGroup">
          <el-button class="filter-item" :style="titleButtonStyle" type="primary" v-waves icon="el-icon-search" v-if="isShowSearch" @click="handleFilter">搜索</el-button>
          <el-button class="filter-item" :style="titleButtonStyle" type="primary" :loading="downloadLoading" v-waves icon="el-icon-download" v-if="isShowExport" @click="handleDownload">导出</el-button>
          <el-button class="filter-item" :style="titleButtonStyle" type="primary" v-waves icon="el-icon-plus" v-if="isShowNewButton" @click="openDialog('newData')">新建</el-button>
          <el-button class="filter-item" :style="titleButtonStyle" type="primary" v-waves icon="el-icon-refresh" v-if="isShowRefresh" @click="refreshList">刷新</el-button>
          <el-button class="filter-item" :style="titleButtonStyle" type="primary" v-waves icon="el-icon-close" v-if="multipleSelection.length" @click="BatchRemove">批量删除</el-button>
        </el-button-group>

        <span v-if="!buttonGroup">
          <el-button class="filter-item" :style="titleButtonStyle" type="primary" v-waves icon="el-icon-search" v-if="isShowSearch" @click="handleFilter">搜索</el-button>
          <el-button class="filter-item" :style="titleButtonStyle" type="primary" :loading="downloadLoading" v-waves icon="el-icon-download" v-if="isShowExport" @click="handleDownload">导出</el-button>
          <el-button class="filter-item" :style="titleButtonStyle" type="primary" v-waves icon="el-icon-plus" v-if="isShowNewButton" @click="openDialog('newData')">新建</el-button>
          <el-button class="filter-item" :style="titleButtonStyle" type="primary" v-waves icon="el-icon-refresh" v-if="isShowRefresh" @click="refreshList">刷新</el-button>
          <el-button class="filter-item" :style="titleButtonStyle" type="primary" v-waves icon="el-icon-close" v-if="multipleSelection.length" @click="BatchRemove">批量删除</el-button>
        </span>
        <hm-full-calendar style="display: inline;margin-left: 10px;" :schema="HmFullCalendar.calendarSchema" :demoEvents="HmFullCalendar.demoEvents" v-if="HmFullCalendar.calendarSchema"></hm-full-calendar>
      </el-form>
    </div>
    <!-- end 过滤 -->

    <!-- 表格 -->
    <el-table :data="list" v-loading="listLoading" element-loading-text="给我一点时间" border fit highlight-current-row :cell-style="cellStyle" ref="multipleTable"
              :style="tableStyle" @selection-change="handleSelectionChange" @sort-change="sortChange" @current-change="tableCurrentChange">
      <el-table-column type="index" :index="indexMethod" label="序号" width="50px"></el-table-column>
      <el-table-column type="selection" width="55" v-if="isShowSelection"></el-table-column>
      <el-table-column v-for="(column,index) in showColumns" :key="index" align="center" :label="column.name"
                       :prop="column.codeCamel" :sortable="column.isSort" :width="column.width" :show-overflow-tooltip="showOverflowTooltip">
        <template slot-scope="scope">
          <span v-if="(scope.row[column.codeCamel] !== false && scope.row[column.codeCamel] !== true )&& !column.render">{{ scope.row[column.codeCamel] }}</span>
          <el-checkbox v-if="(scope.row[column.codeCamel] === false || scope.row[column.codeCamel] === true) && !column.render" v-model="scope.row[column.codeCamel]" @change="column.checkbox(scope)"></el-checkbox>
          <span v-if='column.render' v-html="column.render(scope)"></span>
        </template>
      </el-table-column>
      <el-table-column fixed="right" label="操作" :width="operationWidth" v-if="isShowEditDataButton || isShowDeleteButton || definedOperation.length || isShowDetail">
        <template slot-scope="scope">
          <el-button @click="openDialog('editData',scope.row)" v-if="isShowEditDataButton" type="text" size="small">编辑</el-button>
          <el-button @click="deleteData(scope.row)" type="text" v-if="isShowDeleteButton" size="small">删除</el-button>
          <el-button @click="openDialog('detail',scope.row)" type="text" v-if="isShowDetail" size="small">详情</el-button>
          <el-button @click="operation.func(scope.row)" type="text" v-if="definedOperation.length" size="small"
                     v-for="operation in definedOperation">{{statusFunc(scope.row, operation)}}
          </el-button>
        </template>
      </el-table-column>
    </el-table>
    <!-- end 表格 -->

    <!-- 翻页 -->
    <div class="pagination-container" v-if="isShowPagination">
      <el-pagination background @size-change="handleSizeChange" @current-change="handleCurrentChange" :current-page.sync="listQuery.pageNo"
                     :page-sizes="[10,20,50]" :page-size="listQuery.pageSize" layout="total, sizes, prev, pager, next, jumper" :total="total">
      </el-pagination>
    </div>
    <!-- end翻页 -->

    <!-- 弹窗 -->
    <!-- @TODO 补充详情弹窗 -->
    <el-dialog :title="dialogName"
               :visible.sync="dialogFormVisible"
               :close-on-click-modal="closeOnClickModal" width="45%"
               v-if="dialogFormVisible" :before-close="options.handClose">
      <hm-complex-form :schema="HmComplexForm.formSchema"
                       :columns="HmComplexForm.showUserColumns"
                       :buttons="HmComplexForm.showUserButtons"
                       :layout="HmComplexForm.layout"
                       :tableId="HmComplexForm.tableId"
                       :tips="HmComplexForm.formTips"
                       :formStyle="HmComplexForm.formStyle"
                       :funObject="HmComplexForm.funObject"
                       :refers="HmComplexForm.formRefers"
                       :includes="HmComplexForm.formIncludes"
                       :foreignFormFields="HmComplexForm.foreignFormFields"
                       :relates="HmComplexForm.formRelates"
                       ref="hmComplexForm"
                       :rules="HmComplexForm.rules">
      </hm-complex-form>
    </el-dialog>

    <!-- end 弹窗 -->

  </div>
</template>

<script>
  import _ from 'lodash'
  import request from '@/utils/request'
  import waves from '@/directive/waves' // 水波纹指令
  import { parseTime, param } from '@/utils'
  import * as excel from '@/vendor/Export2Excel'
  import { Button, Table, TableColumn, Pagination, Loading } from 'element-ui'
  import HmComplexForm from '../forms/HmComplexForm.vue'
  import HmFullCalendar from '../calendar/HmFullCalendar.vue'

  /**
   * 毫末科技的表格组件.
   *
   *   demo地址: factory.haomo-studio.com/vue-element/#/haomo/components/table
   * @author 胡小根 hxg@haomo-studio.com
   */
  export default {
    name: 'HmComplexTable',
    // 集成其他组件
    extends: {
    },
    // 使用其它组件
    components: {
      'el-button': Button,
      'el-table': Table,
      'el-table-column': TableColumn,
      'el-pagination': Pagination,
      'hm-complex-form': HmComplexForm,
      'hm-full-calendar': HmFullCalendar
    },
    // 混入公共对象
    mixins: [],
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
       * 搜索过滤选项。默认没有过滤功能。完整的示例为：
       *  {
       *    "column1": {
       *      like: '%abc%',                 模糊查询,包含字符”abc”
       *      notLike: ''                    模糊查询,不包含字符
       *      between: [1, 10],              取值在[1,10]之间,包含1与10
       *      notBetween: [1, 10],           取值小于1大于10
       *      isNull: true,     // 只能为true 判断字段是否为空
       *      isNotNull: true,  // 只能为true 判断字段是否不为空
       *      equalTo: "abc",                相等于
       *      notEqualTo: "abc",             不等于
       *      greaterThan: 10,               大于
       *      greaterThanOrEqualTo: Í10,      大于等于
       *      lessThan: 10,                  小于
       *      lessThanOrEqualTo: 10,         小于等于
       *      in: [],                        包含[]中字段
       *      notIn: []                      不包含[]中字段
       *    }
       *  }
       */
      filters: {
        type: Array,
        required: false
      },
      /**
       * 用来将本表的外链字段(table_id类似的字段)指向的外链表相关联, 格式为:
       *  {
       *    "hm_user": {    //外链表 表名 本表所对应的主键表）
       *      includes:['user_id'] // 与主表所对应的外键
       *    }
       *  }
       *
       */
      includes: {
        type: Object,
        required: false
      },
      /**
       * 用来将其他表的外链字段指向本表关联，同时返回数据, 格式为:
       *  {
       *    'auth_token': {          //主键id所对应的外键表 表名1 （本表所对应的外键表）
       *      includes: ['user_id']   //外键表的外键字段
       *    }
       *  }
       */
      refers: {
        type: Object,
        required: false
      },
      /**
       * 指定要显示的列。默认为根据schema得到的所有列。完整示例为：
       *  [
       *    {
       *      "name": "姓名",
       *      "codeCamel": "username",
       *      "isSort": false, //是否排序，默认false
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
       * 修改行数据的Hook函数。参数为行数据 rowData
       */
      rowHook: {
        type: Function,
        required: false
      },
      /**
       * 表格的选项，包括：pageSize、showExport、sortItem、sortOrder、showRefresh、showDeleteButton、isShowPagination、isShowSearch、 showSelection
       * buttonGroup、showDetail、dataProcessing、promiseProcessing、changeValue、newData、editData、cellStyle, tableStyle完整的示例为：
       *  {
       *    "pageSize": 10, // 默认为10条数据/页
       *    "showExport": false,  // 默认为不显示导出按钮
       *    "sortItem": "create_time", // 默认为create_time字段的desc排序
       *    "sortOrder": "desc",
       *    "isShowPagination": true, //默认显示分页
       *    "showSelection" : false // 默认不显示多选框(显示多选框后可调用toggleSelection()方法赋值选择)
       *    "isShowSearch": true, //默认显示搜索按钮
       *    "showRefresh": false, //默认不显示刷新按钮
       *    "showDeleteButton": false,  //默认不显示删除按钮
       *    "buttonGroup": false  //默认不以按钮组的方式呈现button
       *    tableCurrentChange(value){} // 设置点击某行所执行方法
       *    dataProcessing(value, params, definedOperate){}  // 对接口返回数据进行处理（必须有返回值,返回值需为 [{}] 的形式，支持放回Promise对象）
       *    promiseProcessing(value, params, definedOperate){}  // 对接口返回数据进行处理（必须有返回值,返回Promise对象）
       *    "changeValue": {      // 数据库字段转化显示，例如(0=否,1=是)
       *      username: {1: '是', 0: '否'},
       *      type: { 1: 'Hm-isChecked', 0: 'Hm-noChecked' } // 以多选框的形式展示Hm-isChecked(选择状态)、Hm-noChecked(未选择状态)
       *    },
       *    "newData": {  // 新建按钮的配置（详细配置参考form表单）
       *      isShow: false,  // 默认不显示新建按钮
       *      showUserColumns: [], // 新建表单的Columns配置,详情参考Form组件
       *      formSchema: {}, // 新建表单的schema配置
       *      layout: {} // 布局方式
       *    },
       *    "editData": { // 编辑按钮的配置（详细配置参考form表单）
       *      isShow: false,  // 默认不显示编辑按钮
       *      showUserColumns: [], // 编辑表单的Columns配置,详情参考Form组件
       *      formSchema: {}, // 编辑表单的schema配置
       *      layout: {} // 布局方式
       *    },
       *    showDetail: { // 详情的的配置（详细配置参考form表单）
       *      isShow: false,      // 默认不显示详情
       *    },
       *    cellStyle:{} // 自定义单元格的样式
       *    tableStyle:{} // 自定义表格的样式
       *  }
       *
       */
      options: {
        type: Object,
        required: false
      },
      /**
       * 自定义表格选项，包括：definedParams、definedOperate、definedOperation、definedEdit、definedNew、definedDetail、BatchRemove、pretreatment完整的示例为：
       *  {
       *    definedParams(params, operate){return params} // 自定义查询数据时的Params
       *    definedOperate: [         // 自定义table顶部的操作，如果要根据下拉选择、输入框、时间选择器的值查询，需在自定义definedParams()方法中添加
       *      { type: 'select', label:'', placeholder: '', options:[{label: '', code: ''}], value:''}, // 自定义多选框
       *      { type: 'input', label:'', placeholder: '', code:'', value:''}, // 自定义输入框
       *      { type: 'datetime', label:'', placeholder: '', code:'', value:''},  // 自定义时间选择器
       *      { type: 'button', label:'', icon:'', func: this.dropDown, style:{}] // 自定义按钮
       *    }
       *    definedOperation: [] // 自定义操作
       *    definedEdit(){} // 自定义操作中编辑
       *    definedNew(){} // 自定义新建
       *    definedDetail(){} // 自定义操作中详情
       *    BatchRemove(){} // 自定义批量删除
       *    pretreatment(){} // table组件init()前操作
       */
      userDefined: {
        type: Object,
        required: false
      }
    },
    directives: {
      waves,
      Loading
    },
    data() {
      return {
        list: null,
        total: null,
        listLoading: true,
        listQuery: {
          pageNo: 1,
          pageSize: 10,
          sortItem: 'create_time',
          sortOrder: 'desc',
          filters: {}
        },
        downloadLoading: false,
        dialogFormVisible: false, // 是否显示弹窗
        dialogForm: [], // 弹窗数据
        showColumns: [], // 要显示的列数据
        formLabelWidth: '120px',
        closeOnClickModal: false,
        multipleSelection: [], // 选择的数组
        dialogName: '',
        tableStyle: { width: '100%' }, // table的样式
        isShowSelection: false, // 是否显示多选
        isShowNewButton: false, // 是否显示新建
        isShowEditDataButton: false, // 是否显示编辑
        isShowDeleteButton: false, // 是否显示删除
        isShowExport: false, // 是否显示导出按钮
        isShowPagination: true, // 是否显示分页
        isShowSearch: true, // 是否显示搜索按钮
        cellStyle: {}, // 自定义表格单元格的样式
        titleButtonStyle: {}, // 头部按钮样式
        HmComplexForm: { // 设置form组件
          formSchema: {}, // form弹窗的Schema定义
          showUserColumns: [], // form弹窗的Columns定义
          showUserButtons: [], // from弹窗显示按钮,
          layout: { left: 0, middle: 24, right: 0 }, // form弹窗的布局方式
          tableId: '',
          formTips: {},
          formStyle: {},
          funObject: {},
          formRefers: {},
          formIncludes: {},
          foreignFormFields: [],
          formRelates: [],
          rules: {
  
          }
        },
        showOverflowTooltip: false, // 设置当内容过长被隐藏时显示 tooltip
        HmFullCalendar: {}, //
  
        isShowRefresh: false,
        buttonGroup: false,
        operationWidth: 20, // 操作栏的宽度
        isShowDetail: false, // 是否显示详情按钮
  
        definedOperate: [], // 自定义操作
        definedOperation: []
      }
    },
    computed: {
      filterParams: function() {
        const self = this
        const ret = JSON.parse(JSON.stringify(self.listQuery.filters))
        if (!ret) {
          return ret
        }
  
        if (!ret[self.schema['modelUnderscore']]) {
          return ret
        }
  
        _.map(ret, function(item) {
          _.forEach(item, function(value, key) {
            if (value.lessThanOrEqualTo !== undefined && value.greaterThanOrEqualTo !== undefined &&
              (value.greaterThanOrEqualTo === '' || value.greaterThanOrEqualTo === null) && (value.lessThanOrEqualTo === '' || value.lessThanOrEqualTo === null)) {
              delete item[key]
            }
            if (value.greaterThanOrEqualTo !== undefined && (value.greaterThanOrEqualTo === '' || value.greaterThanOrEqualTo === null) && value.lessThanOrEqualTo) {
              delete item[key].greaterThanOrEqualTo
            }
            if (value.lessThanOrEqualTo !== undefined && (value.lessThanOrEqualTo === '' || value.lessThanOrEqualTo === null) && value.greaterThanOrEqualTo) {
              delete item[key].lessThanOrEqualTo
            }
          })
        })
        _.each(Object.keys(ret[self.schema['modelUnderscore']]), function(column) {
          const operValue = ret[self.schema['modelUnderscore']][column]
          if (Object.keys(operValue)[0] === 'like') {
            ret[self.schema['modelUnderscore']][column]['like'] = '%' + ret[self.schema['modelUnderscore']][column]['like'] + '%'
          }
        })
        return ret
      }
    },
    created() {
      // this.validate()
      const self = this
      if (this.userDefined && this.userDefined.pretreatment) {
        self.init()
        self.userDefined.pretreatment().then(function() {
          self.init()
          self.getList()
        })
        console.log('IS-[object Promise]')
      } else {
        self.init()
        self.getList()
      }
    },
    methods: {
      indexMethod(index) {
        return this.listQuery.pageSize * (this.listQuery.pageNo - 1) + index + 1
      },
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
        self.operationWidth = 20
        // 处理要显示的列
        if (!self.columns || !self.columns.length) {
          _.each(self.schema['columns'], function(column) {
            const tmp = JSON.parse(JSON.stringify(column))
            self.$set(tmp, 'code', tmp.code.toLowerCase())
            self.showColumns.push(tmp)
          })
        } else {
          self.showColumns = _.cloneDeep(self.columns)
          // 将字符串对象进行替换处理
          _.each(self.showColumns, function(column, index) {
            if (typeof column === 'string') {
              // const tmp = _.keyBy(self.schema['columns'], 'code')[column.toUpperCase()]
              // 王康 修改 2018年02月25日22:58:23
              const tmp = _.keyBy(self.schema['columns'], 'codeCamel')[column]
              self.$set(tmp, 'code', tmp.code.toLowerCase())
              self.$set(self.showColumns, index, tmp)
            }
          })
        }
        if (self.showColumns) {
          _.map(self.showColumns, function(item, index) {
            item.isSort = item.isSort === undefined ? false : item.isSort === true ? 'custom' : false
          })
        }

        // 处理过滤条件
        if (self.filters) {
          const tableName = self.schema['modelUnderscore']
          const filters = {}
          filters[tableName] = {}
          _.each(_.cloneDeep(self.filters), function(filter, index) {
            if (filter.isShow === undefined) {
              self.filters[index].isShow = true
            }
            filters[tableName] = Object.assign(filters[tableName], filter)
          })
          delete filters[tableName]['placeholder']
          delete filters[tableName]['isShow']
          self.$set(self.listQuery, 'filters', filters)
        }
        if (!request.defaults.baseURL) {
          request.defaults.baseURL = '/org/api'
        }
        if (self.options) {
          self.setOptions()
        }
        if (self.userDefined) {
          self.setDefinedOperate()
        }

        console.log(request.defaults)
        console.log(`request.defaults.baseURL: ${request.defaults.baseURL}`)
      },
      // 设置自定义组件
      setDefinedOperate() {
        const self = this
        if (self.userDefined.definedOperate) {
          self.definedOperate = self.userDefined.definedOperate
        }
        if (self.userDefined.definedOperation) {
          _.each(self.userDefined.definedOperation, function(item, index) {
            _.each(item.label, function(value) {
              if (!isNaN(Number(value))) {
                self.operationWidth += 8 // 如果是数字+8
              } else {
                self.operationWidth += 13 // 如果是汉字加13
              }
            })
            if (self.userDefined.definedOperation.length > 1 && index > 0) {
              self.operationWidth += 13 // 每添加一条需加上margin
            } else {
              self.operationWidth += 5
            }
          })
          self.definedOperation = self.userDefined.definedOperation
        }
      },
      // 自定义下拉选择执行函数
      selectChange(func, value) {
        if (typeof (func) === 'function') {
          return func(value)
        }
      },
      // 排序
      sortChange(row) {
        this.listQuery.sortItem = row.prop.replace(/([A-Z])/g, '_$1').toLowerCase()
        this.listQuery.sortOrder = row.order === 'descending' ? 'desc' : 'asc'
        this.getList()
      },
      getList() {
        const self = this
        self.listLoading = true
        // 处理过滤条件
        let params = JSON.parse(JSON.stringify(self.listQuery))
        params.filters = self.filterParams
        params.filters = this.deleteFilter(params.filters)
        if (self.includes) {
          params.includes = self.includes
        }
        if (self.refers) {
          params.refers = self.refers
        }
        if (self.userDefined && self.userDefined.definedParams) {
          params = self.userDefined.definedParams(params, self.definedOperate)
        }
        request(self.schema.modelUnderscorePlural, {
          params: params
        }).then(resp => {
          let respList = []
          if (resp.data.length !== 0 && resp.data[0].superior !== undefined && resp.data[0].includes !== undefined &&
            resp.data[0].refers !== undefined && resp.data[0].relates !== undefined) {
            respList = []
            _.each(resp.data, function(item, index) {
              respList.push(item.superior)
            })
          } else {
            respList = _.cloneDeep(resp.data)
          }
          self.total = parseInt(resp.headers.total)
          // 数据处理
          if (self.options && self.options.dataProcessing) {
            console.log('NO-[object Promise]')
            respList = self.options.dataProcessing(resp.data, params, self.definedOperate)
          }
          if (self.options && self.options.promiseProcessing) {
            self.options.promiseProcessing(resp.data, params, self.definedOperate).then(function(dataList) {
              if (self.options && self.options.changeValue) {
                respList = self.changeValue(respList)
              }
              self.list = dataList
              self.listLoading = false
            })
            return false
          }
          // 数据库字段转化显示
          if (self.options && self.options.changeValue) {
            respList = self.changeValue(respList)
          }
          self.list = respList
          self.listLoading = false
        })
      },
      tableCurrentChange(value) {
        const self = this
        if (self.options && self.options.tableCurrentChange) {
          console.log('value', value)
          self.options.tableCurrentChange(value)
        }
      },
      // 数据库字段转化显示，例如(0=否,1=是)
      changeValue(data) {
        const self = this
        _.map(data, function(item, index) {
          _.forEach(item, function(listValue, listKey) {
            if (self.options.changeValue[listKey] && self.options.changeValue[listKey][listValue]) {
              item[listKey] = self.options.changeValue[listKey][listValue] === 'Hm-isChecked' ? true : self.options.changeValue[listKey][listValue] === 'Hm-noChecked' ? false : self.options.changeValue[listKey][listValue]
            }
          })
        })
        return data
      },
      isShowFilter(filter) {
        return Array.prototype.isPrototypeOf(filter.placeholder) === false
      },
      isDatetimeFilter(filter) {
        const self = this
        let BooleanValue = false
        _.each(self.schema.columns, function(date) {
          if (date.code === self.getFilterColumn(filter) && date.dataType === 'datetime') {
            BooleanValue = true
          }
        })
        return BooleanValue
      },
      // 添加一条数据
      openDialog(type, data) {
        const self = this
        if (type === 'editData' && self.userDefined && self.userDefined.definedEdit) {
          self.userDefined.definedEdit(true, data)
          return false
        }
        if (type === 'newData' && self.userDefined && self.userDefined.definedNew) {
          self.userDefined.definedNew(true)
          return false
        }
        if (type === 'detail' && self.userDefined && self.userDefined.definedDetail) {
          self.userDefined.definedDetail(true, data)
          return false
        }
        self.HmComplexForm = {
          formSchema: {},
          showUserColumns: [],
          showUserButtons: [],
          layout: { left: 0, middle: 24, right: 0 },
          tableId: '',
          formTips: {},
          formStyle: {},
          funObject: {},
          formRefers: {},
          formIncludes: {},
          foreignFormFields: [],
          formRelates: []
        }
        self.HmComplexForm.tableId = ''
        if (type === 'editData') {
          self.dialogName = '编辑'
          if (self.options.editData.showUserButtons) {
            self.HmComplexForm.showUserButtons = self.options.editData.showUserButtons
          }
          self.HmComplexForm.tableId = data.id
          self.HmComplexForm.showUserColumns = self.options.editData.showUserColumns
          self.HmComplexForm.formSchema = self.options.editData.formSchema
          self.HmComplexForm.layout = self.options.editData.layout
          self.options.editData.tips ? self.HmComplexForm.formTips = self.options.editData.tips : ''
          self.options.editData.formStyle ? self.HmComplexForm.formStyle = self.options.editData.formStyle : ''
          self.options.editData.funObject ? self.HmComplexForm.funObject = self.options.editData.funObject : ''
          self.options.editData.formRefers ? self.HmComplexForm.formRefers = self.options.editData.formRefers : ''
          self.options.editData.formIncludes ? self.HmComplexForm.formIncludes = self.options.editData.formIncludes : ''
          self.options.editData.foreignFormFields ? self.HmComplexForm.foreignFormFields = self.options.editData.foreignFormFields : ''
          self.options.editData.formRelates ? self.HmComplexForm.formRelates = self.options.editData.formRelates : ''
        }
        if (type === 'newData') {
          self.dialogName = '新建'
          if (self.options.newData.showUserButtons) {
            self.HmComplexForm.showUserButtons = self.options.newData.showUserButtons
          }
          self.HmComplexForm.showUserColumns = self.options.newData.showUserColumns
          self.HmComplexForm.formSchema = self.options.newData.formSchema
          self.HmComplexForm.layout = self.options.newData.layout
          self.options.newData.tips ? self.HmComplexForm.formTips = self.options.newData.tips : ''
          self.options.newData.formStyle ? self.HmComplexForm.formStyle = self.options.newData.formStyle : ''
          self.options.newData.funObject ? self.HmComplexForm.funObject = self.options.newData.funObject : ''
          self.options.newData.formRefers ? self.HmComplexForm.formRefers = self.options.newData.formRefers : ''
          self.options.newData.formIncludes ? self.HmComplexForm.formIncludes = self.options.newData.formIncludes : ''
          self.options.newData.foreignFormFields ? self.HmComplexForm.foreignFormFields = self.options.newData.foreignFormFields : ''
          self.options.newData.formRelates ? self.HmComplexForm.formRelates = self.options.newData.formRelates : ''
        }
        if (type === 'detail') {
          self.dialogName = '详情'
          if (self.options.showDetail.showUserButtons) {
            self.HmComplexForm.showUserButtons = self.options.showDetail.showUserButtons
          }
          self.HmComplexForm.showUserColumns = self.options.showDetail.showUserColumns
          self.HmComplexForm.formSchema = self.options.showDetail.formSchema
          self.HmComplexForm.layout = self.options.showDetail.layout
          self.options.showDetail.tips ? self.HmComplexForm.formTips = self.options.showDetail.tips : ''
          self.options.showDetail.formStyle ? self.HmComplexForm.formStyle = self.options.showDetail.formStyle : ''
          self.options.showDetail.funObject ? self.HmComplexForm.funObject = self.options.showDetail.funObject : ''
          self.options.showDetail.formRefers ? self.HmComplexForm.formRefers = self.options.showDetail.formRefers : ''
          self.options.showDetail.formIncludes ? self.HmComplexForm.formIncludes = self.options.showDetail.formIncludes : ''
          self.options.showDetail.foreignFormFields ? self.HmComplexForm.foreignFormFields = self.options.showDetail.foreignFormFields : ''
          self.options.showDetail.formRelates ? self.HmComplexForm.formRelates = self.options.showDetail.formRelates : ''
          self.HmComplexForm.tableId = data.id
          // wk 2018年05月09日11:57:06
          if (self.options.showDetail.funCallback) {
            self.options.showDetail.funCallback(data)
          }
        }
        self.dialogFormVisible = true
      },
      statusFunc(row, operation) {
        if (operation.statusFunc) {
          return operation.statusFunc(row)
        } else {
          return operation.label
        }
      },
      // 表单的提交
      formConfirm() {
        this.dialogFormVisible = false
        this.getList()
      },
      // 表单的取消
      formCancel() {
        this.dialogFormVisible = false
      },
      // 删除过滤条件为空的filter
      deleteFilter(filters) {
        const newFilters = filters
        _.forEach(newFilters, function(columns, columnsKey) {
          _.forEach(newFilters[columnsKey], function(column, columnKey) {
            if (columns[columnKey][Object.keys(column)] === '%%' || columns[columnKey][Object.keys(column)] === '' ||
              columns[columnKey][Object.keys(column)] === null || (columns[columnKey][Object.keys(column)[0]] === '' && columns[columnKey][Object.keys(column)[1]]) === '') {
              delete (columns[columnKey])
            }
          })
        })
        return JSON.stringify(newFilters[Object.keys(newFilters)]) === '{}' ? null : newFilters
      },
      // 删除一条数据
      deleteData(data) {
        const self = this
        const params = { ids: [data.id] }
        params.ids = JSON.stringify(params.ids)
        self.deleteDataRequest(params)
      },
      refreshList() {
        this.listQuery = {
          pageNo: 1,
          pageSize: 10,
          sortItem: 'create_time',
          sortOrder: 'desc',
          filters: {}
        }
        this.init()
        this.getList()
      },
      // 批量删除
      BatchRemove() {
        const self = this
        const datas = { ids: [] }
        if (!self.multipleSelection) return false
        if (self.userDefined.BatchRemove) {
          self.userDefined.BatchRemove(self.multipleSelection)
          return false
        }
        _.each(self.multipleSelection, function(item, index) {
          datas.ids.push(item.id)
        })
        datas.ids = JSON.stringify(datas.ids)
        self.deleteDataRequest(datas)
      },
      deleteDataRequest(data) {
        const self = this
        self.$confirm('此操作将永久删除数据, 是否继续?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          request(self.schema.modelUnderscorePlural + '/delete/batch', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8' },
            data: data,
            transformRequest: param
          }).then(resp => {
            if (resp.data.message === 'delete success') {
              self.$message({
                message: '删除成功',
                type: 'success'
              })
              self.getList()
            }
          })
        }).catch(() => {
          self.$message({
            message: '已取消删除',
            type: 'success'
          })
        })
      },
      setOptions() {
        const self = this
        self.options.pageSize ? this.listQuery.pageSize = self.options.pageSize : this.listQuery.pageSize // 配置pageSize
        self.options.sortItem ? this.listQuery.sortItem = self.options.sortItem : this.listQuery.sortItem // sortItem
        self.options.sortOrder ? this.listQuery.sortOrder = self.options.sortOrder : this.listQuery.sortOrder // sortOrder
        if (self.options.newData && self.options.newData.isShow !== undefined) { // 判断是否显示新建按钮
          self.isShowNewButton = self.options.newData.isShow
        }
        if (self.options.editData && self.options.editData.isShow !== undefined) { // 判断是否显示编辑按钮
          self.isShowEditDataButton = self.options.editData.isShow
          self.operationWidth += 40
        }
        if (self.options.showRefresh !== undefined) { // 判断是否显示刷新按钮
          self.isShowRefresh = self.options.showRefresh
        }
        if (self.options.showExport !== undefined) { // 判断是否显示导出按钮
          self.isShowExport = self.options.showExport
        }
        if (self.options.isShowSearch !== undefined) { // 判断是否显示刷新
          self.isShowSearch = self.options.isShowSearch
        }
        if (self.options.cellStyle) { // 自定义表格单元格的样式
          self.cellStyle = self.options.cellStyle
        }
        if (self.options.isShowPagination !== undefined) { // 判断是否显示分页
          self.isShowPagination = self.options.isShowPagination
        }
        if (self.options.showDeleteButton !== undefined) { // 判断是否显示删除按钮
          self.isShowDeleteButton = self.options.showDeleteButton
          self.operationWidth += 40
        }
        if (self.options.buttonGroup !== undefined) { // 设置按钮是否以按钮组呈现
          self.buttonGroup = self.options.buttonGroup
        }
        if (self.options.showDetail && self.options.showDetail.isShow !== undefined) { // 设置按钮是否以按钮组呈现
          self.isShowDetail = self.options.showDetail.isShow
          self.operationWidth += 40
        }
        if (self.options.showSelection !== undefined) { // 设置是否显示多选
          self.isShowSelection = self.options.showSelection
        }
        if (self.options.tableStyle) { // 自定义table样式
          self.tableStyle = self.options.tableStyle
        }
        if (self.options.showOverflowTooltip !== undefined) { // 当内容过长被隐藏时显示 tooltip
          self.showOverflowTooltip = self.options.showOverflowTooltip
        }
        if (self.options.HmFullCalendar) { // 当内容过长被隐藏时显示 tooltip
          self.HmFullCalendar = self.options.HmFullCalendar
        }
        if (self.options.titleButtonStyle) { // 自定义表格顶部按钮样式
          self.titleButtonStyle = self.options.titleButtonStyle
        }
      },
      toggleSelection(value) {
        const self = this
        _.forEach(value, function(row) {
          self.$refs.multipleTable.toggleRowSelection(row)
        })
      },
      handleSelectionChange(val) {
        this.multipleSelection = val
      },
      handleFilter() {
        this.getList()
      },
      handleSizeChange(val) {
        this.listQuery.pageSize = val
        this.getList()
      },
      handleCurrentChange(val) {
        this.listQuery.pageNo = val
        this.getList()
      },
      handleDelete(row) {
        this.$notify({
          title: '成功',
          message: '删除成功',
          type: 'success',
          duration: 2000
        })
        const index = this.list.indexOf(row)
        this.list.splice(index, 1)
      },
      handleDownload() {
        this.downloadLoading = true
        // @TODO 修改下载excel的功能，请求所有的数据
        const tHeader = this.columns
        const filterVal = this.columns
        const data = this.formatJson(filterVal, this.list)
        excel.export_json_to_excel(tHeader, data, 'table-list')
        this.downloadLoading = false
      },
      formatJson(filterVal, jsonData) {
        return jsonData.map(v => filterVal.map(j => {
          if (j === 'timestamp') {
            return parseTime(v[j])
          } else {
            return v[j]
          }
        }))
      },
      getFilterColumn(filter) {
        const keys = Object.keys(filter)
        let column = null
        _.each(keys, function(key) {
          if (key !== 'placeholder' && key !== 'isShow') {
            column = key
            return 0
          }
        })
        return column.toLowerCase()
      },
      getFilterOper(filter) {
        return Object.keys(filter[this.getFilterColumn(filter)])[0]
      },
      getFilterOperTwin(filter) {
        return Object.keys(filter[this.getFilterColumn(filter)])[1]
      },
      dialogClose() {
        this.dialogFormVisible = false
        this.getList()
      }
    }
  }
</script>

<style>
  .hm-complex-table__filter-span {
    margin-right: 5px;
  }
  .el-table__body tr.current-row>td{
    background-color: #ecf5ff;
  }
</style>
