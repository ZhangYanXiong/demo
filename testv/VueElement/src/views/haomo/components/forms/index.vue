<template>
  <div>
    <hm-complex-form :schema="schema['HmUser']"
                     :columns="showUserColumns"
                     :buttons="showUserButtons"
                     :layout="layout"
                     :tips="tips"
                     :funObject="funObject"
    >
      <!-- foreignFormFields 主查外的外表显示字段  和userRefers连用-->
      <!-- :relates="userRelates" 中间表和间接关联表-->
      <!--  :refers="userRefers" 主查外的外表和外键字段 和foreignFormFields；连用-->
    </hm-complex-form>
  </div>
</template>

<script>
  import HmComplexForm from './HmComplexForm.vue'
  import schema from '../../schemas/hm_org_schema'

  export default {
    name: 'HmComplexFormIndex',
    // 继承其他组件
    extends: {},
    // 使用其它组件
    components: {
      'hm-complex-form': HmComplexForm
    },
    data() {
      return {
        // widgetType值 1：普通input 2：下拉框 (如果是下拉框 再传一个options表示下拉框选项)3：复选框 4：文本域 5：富文本 6：日期 7：单选框 8: 文件上传
        showUserColumns: [
          // 1普通input
          { name: '选择类型', codeCamel: 'type', widgetType: 9, ref: 'type', options: []
            // rule: { required: true, message: '用户名不能为空', trigger: 'blur' }
            //  hide: true
            //  default: '默认值',
          },
          // { name: '选择类型', codeCamel: 'type', widgetType: 1, disabled: false,
          //   change: this.inputChange
          //   // rule: { required: true, message: '用户名不能为空', trigger: 'blur' }
          //   //  hide: true
          //   //  default: '默认值',
          // },
          // 5富文本
          { name: '电子邮件', codeCamel: 'email', widgetType: 5, disabled: false,
            change: this.inputChange, hide: false
            // rule: [
            //   { required: true, message: '请输入邮箱地址', trigger: 'blur' },
            //   { type: 'email', message: '请输入正确的邮箱地址', trigger: 'blur,change' }
            // ]
          },
          // 2下拉框
          { name: '用户名称', codeCamel: 'username', widgetType: 2, multiple: false,
            change: this.selectChange, // default: [1], 如果开启多选，默认选中项用数组[1]、[1,2,3]
            allowCreate: true,
            options: [
              { value: '1', label: '企业' }, // 下拉框的label是选项文字，value是选中值
              { value: '2', label: '代理商' },
              { value: '3', label: '会员' },
              { value: '4', label: '访客' }
            ]
          },
          // 3多选 不支持默认值
          { name: '部门ID', codeCamel: 'departmentId', widgetType: 3, options: ['美女', '帅哥'], change: this.inputChange },
          // 4密码
          { name: '密码', codeCamel: 'password', widgetType: 4, change: this.inputChange },
          // 'password',
          // 6日期
          { name: '新建时间', codeCamel: 'createTime', widgetType: 6, dateType: 'datetime',
            dateFormate: 'yyyy-MM-dd HH:mm:ss', change: this.inputChange
            // default: '2018-01-01 00:07:08'
          },
          // 7单选
          { name: '登陆id', codeCamel: 'loginid', widgetType: 7,
            options: [
              { label: 1, value: '会员' }, // 单选的value是选项文字，label是选中值
              { label: 2, value: '访客' } // 如果数据库中存的数据类型是number，label值写number如1，如果为string，label值写string ,如'1'
            ], // default: 1
            change: this.inputChange
          },
          // 8文件 change: this.uploadChange
          { name: '选择头像', codeCamel: 'avatar', widgetType: 8, url: '/api/upload', param: 'picture'
            // fileList: [{ name: '', url: '' }]
            // request.defaults.baseURL + '/upload_memorabilia_file'
          } // url是后台接口地址
        ],
        // CcSubject示例
        showUserColumns2: [
          { name: '题目', codeCamel: 'subject' },
          { name: '题目类型', codeCamel: 'subjectType', default: 3 },
          { name: 'A选项', codeCamel: 'description0', code: 'description', serialNumber: 'A', widgetType: 1, isForeign: true },
          { name: 'B选项', codeCamel: 'description1', code: 'description', serialNumber: 'B', widgetType: 1, isForeign: true },
          { name: '正确选项', codeCamel: 'correct', widgetType: 1, isForeign: true, partProp: true },
          { name: '试题详解', codeCamel: 'commentary', widgetType: 1 }
        ],
        // schema['CcMenuResource'] + userRelates + showUserColumns3 理论学习示例
        showUserColumns3: [
          { name: '标题', codeCamel: 'title', widgetType: 1 },
          { name: '封面图片', codeCamel: 'thumbnail', widgetType: 8 },
          { name: '视频', codeCamel: 'videoName', widgetType: 8 },
          { name: '简介', codeCamel: 'lntroduction', widgetType: 1 },
          { name: '内容', codeCamel: 'content', widgetType: 4 },
          { name: '发布人', codeCamel: 'publisher', widgetType: 1 }
        ],

        // schema['CcSubject']+foreignFormFields+userRefers+showUserColumns2 判断题示例
        // 第一个值为外键字段(codeCamel)
        foreignFormFields: ['ccSubjectId', 'description', 'correct', 'serialNumber'],
        // 主查外表  外键字段
        userRefers: {
          'cc_option': {
            includes: ['ccSubjectId']
          }
        },
        // 外查主
        userIncludes: {
          'hm_user': {
            includes: ['user_id']
          }
        },
        // 要显示按钮
        showUserButtons: [
          { text: '确定', type: 1, method: this.method1, beforeSubmit: this.processData },
          { text: '重置', type: 2, method: this.method2 },
          { text: '生成', method: this.method4 },
          // { text: '预览', method: this.method5 },
          // { text: '预览2', method: this.method5 },
          { text: '取消', type: 3, method: this.method3 }
        ],
        funObject: {
          beforeRender: this.beforeRender,
          uploadFun: this.uploadFun
        },
        // showUserButtons: []
        // 布局方式
        layout: { left: 2, middle: 20, right: 2 },
        // 自定义提示消息
        tips: {
          hidde: false, // 是否显示提示，默认false显示
          newSuccess: { text: '发布成功' }, // 新建成功的提示
          newError: { text: '发布失败' }, // 新建失败的提示
          editSuccess: { text: '编辑成功' }, // 编辑成功的提示
          editError: { text: '编辑失败' }, // 编辑失败的提示
          otherError: { text: '填写有误，不可以提交' } // processData中取消提交的提示
        },
        // 各类型表单样式设置
        formStyle: {
          formOptions: {
            labelWidth: '170px',
            labelPosition: 'right'
          },
          datePicker: { style: { width: '60%' }},
          input: { style: { width: '60%' }},
          select: { style: { width: '60%' }},
          cascader: { style: { width: '60%' }},
          elTree: { style: { width: '60%' }},
          textarea: {
            style: { width: '60%' },
            resize: 'none',
            autosize: { minRows: 3, maxRows: 5 },
            rows: 3
          },
          quillEditor: { style: { width: '65%' }}
        },

        // 关联表 本表即页面显示的要创建的表'CcMenuResource' 中间表'cc_menu_resource_associations'
        // 间接关联表'cc_secondary_menu_dictionaries'
        userRelates: [
          // 间接关联表
          { indirectTable: 'cc_secondary_menu_dictionaries', // 下划线复数
            // 过滤查询的条件
            filters: { 'cc_secondary_menu_dictionary': { 'name': { equalTo: '理论学习' }}}
          },
          // 中间表
          { relateTable: 'cc_menu_resource_associations',
            relateKeys: ['resourceId', 'menuId'] // 中间表与主表(本表)字段  与间接关联表对应字段
          }
        ]
      }
    },
    computed: {
    },
    filters: {
    },
    created() {
      this.schema = schema
      // console.log(this.schema)
      // this.tableId = '1efff63125954583b0ac5a9c252b9041'
      this.tableId = 'b08d2220d2574bf2ac09ec4f470ed999'
    },
    methods: {
      inputChange(val, formModel) {
        console.log(val)
        console.log(formModel)
        // formModel.email = val.length
      },
      selectChange(val, formModel) {
        console.log('下拉框change', val, formModel)
      },
      processData(object, isCancel) {
        isCancel.cancelSubmit = false // 如果要取消提交，设为true
        console.log(125, object)
        return object // 将数据返回
      },
      method1(formModel) {
        console.log('formModel')
      },
      method2() {
        console.log('method2')
      },
      method3() {
        console.log('method3')
      },
      method4(formModel) {
        console.log(formModel)
        console.log('method4')
      },
      method5(formModel) {
        console.log(formModel)
        console.log('method4')
      },
      beforeRender(data, formModel) {
        // 数据处理
        // do something...
        // console.log(111, data)
        // console.log(112, formModel)
        return formModel
      },
      uploadFun: function(response, formModel) {
        console.log(215, response)
        console.log(216, formModel)
        // 修改其他表单的值
        formModel.email = response.visitName
      }
    }
  }
</script>
<style scoped>
</style>
