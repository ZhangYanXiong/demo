<template>
  <!--1class="app-container documentation-container"-->
  <div>
    <!--v-loading="Loading"-->
    <el-row type="flex" class="hm-form" style="margin-top: 12px" >
      <el-col :span="layout ? layout.left : 1">
        <div></div>
      </el-col>
      <el-col :span="layout ? layout.middle : 23">
        <!--表单部分-->
        <el-form ref="form"
                 :label-position="formStyle && formStyle.formOptions && formStyle.formOptions.labelPosition || 'right'"
                 element-loading-text="加载中"
                 :label-width="formStyle && formStyle.formOptions && formStyle.formOptions.labelWidth || '163px'"
                 :model="formModel"
                 :rules="rules || myRules"
                 :style=" formStyle && formStyle.formOptions && formStyle.formOptions.style || {width:'100%'}">
          <el-form-item v-for="column in showUserColumns"
                        v-show="!column.hide"
                        :key="column.id"
                        :label="column.name"
                        :rules="column.rule?column.rule:null"
                        :prop="column.codeCamel">
            <!-- 1 日期选择 -->
            <!-- -->
            <el-date-picker v-if="column.widgetType === 6 || column.type === 'datetime' || column.type === 'date'"
                            v-model="formModel[column.codeCamel]"
                            :style="formStyle && formStyle.datePicker && formStyle.datePicker.style || {width: '70%'}"
                            :ref="column.ref || ''"
                            :placeholder="column.placeholder || ''"
                            :readonly="column.readonly"
                            :type="column.dateType || 'date'"
                            align="right" :disabled="column.disabled"
                            @change="column.change && column.change($event, formModel)"
                            :value-format="column.dateFormate || 'yyyy-MM-dd'"
                            :picker-options="column.pickerOptions || pickerOptions">
            </el-date-picker>
            <!-- 2 下拉框 -->
            <el-select v-else-if="column.widgetType === 2"
                       :ref="column.ref || ''"
                       v-model="formModel[column.codeCamel]"
                       @change="column.change && column.change($event, formModel)"
                       @focus="column.focus && column.focus($event, formModel)"
                       :style="formStyle && formStyle.select && formStyle.select.style || {width: '70%'}"
                       :multiple="column.multiple"
                       :disabled="column.disabled"
                       filterable
                       :allowCreate="column.allowCreate"
                       style="width: 50%"
                       clearable>
              <el-option v-for="(item,key) in column.options"
                         :key="key"
                         :label="item.label"
                         :value="item.value">
              </el-option>
            </el-select>
            <!-- 3 文本域 -->
            <el-input v-else-if="column.widgetType === 4"
                      :ref="column.ref || ''"
                      :readonly="column.readonly"
                      :style="formStyle && formStyle.textarea && formStyle.textarea.style || {width: '70%'}"
                      v-model="formModel[column.codeCamel]"
                      type="textarea" :disabled="column.disabled"
                      :resize="formStyle && formStyle.textarea && formStyle.textarea.resize || 'vertical'"
                      :autosize="formStyle && formStyle.textarea && formStyle.textarea.autosize || { minRows: 4, maxRows: 8}"
                      :rows="formStyle && formStyle.textarea && formStyle.textarea.rows || 4" @change="column.change && column.change($event)">
            </el-input>
            <!-- 4 复选框 -->
            <el-checkbox v-else-if="column.widgetType === 3 && !column.options"
                         v-model="formModel[column.codeCamel]"
                         :ref="column.ref || ''"
                         :disabled="column.disabled"
                         @change="column.change && column.change($event)"
                         true-label="1" false-label="0">
            </el-checkbox>
            <el-checkbox-group v-else-if="column.widgetType === 3 && column.options"
                               v-model="formModel[column.codeCamel]"
                               :ref="column.ref || ''"
                               :disabled="column.disabled"
                               @change="column.change && column.change($event)">
              <el-checkbox v-for="option in column.options"
                           :label="option" :key="option">{{option}}</el-checkbox>
            </el-checkbox-group>
            <!-- 5 富文本 -->
            <quill-editor v-else-if="column.widgetType === 5"
                          :ref="column.ref || ''" :disabled="column.disabled"
                          v-model="formModel[column.codeCamel]"
                          :style="formStyle && formStyle.quillEditor && formStyle.quillEditor.style || {width:'70%'}"
                          :options="column.options || editorOption"
                          @blur="onEditorBlur($event)"
                          @focus="onEditorFocus($event)"
                          @change="column.change && column.change($event)"
                          @ready="onEditorReady($event)">
            </quill-editor>
            <!-- 6 单选框 -->
            <el-radio-group v-else-if="column.widgetType === 7"
                            :disabled="column.disabled"
                            :readonly="column.readonly"
                            @change="column.change && column.change($event, formModel)"
                            v-model="formModel[column.codeCamel]">
              <el-radio v-for="option in column.options"
                        :key="option.label" :label="option.label">{{option.value}}</el-radio>
            </el-radio-group>
            <!-- 7 文件 :multiple="column.multiple || false"-->
            <el-upload v-else-if="column.widgetType === 8"
                       :accept="column.accept || '*/*'"
                       :name="column.param || 'picture'"
                       :action="column.url || '/api/upload'"
                       :on-remove="handleRemove"
                       class="a"
                       :limit="column.limit || 3"
                       :on-change="column.change || handleChange"
                       :file-list="column.fileList"
                       ref="upload"
                       :before-upload="column.beforeUpload || beforeUpload"
                       :on-success="(res, file, fileList)=>{ return uploadSuccess(res, file, fileList, column.codeCamel, column.fileData)}">
              <el-button slot="trigger" size="small" type="primary" class="b"
                         :disabled="column.disabled">选取文件</el-button>
            </el-upload>
            <!-- 8树形图 -->
            <!--:default-expanded-keys="[2, 3]"-->
            <!--:default-checked-keys="[5]"-->
            <div class="hm-form_form_div" v-else-if="column.widgetType === 9" :style="formStyle && formStyle.elTree && formStyle.elTree.style || {width: '70%'}">
              <el-tree :data="column.options"
                       :ref="column.ref || 'tree'"
                       :show-checkbox="column.checkBox || false"
                       node-key="id"
                       :accordion="column.accordion || false"
                       :draggable="column.draggable || false"
                       :check-strictly="column.checkStrictly || false"
                       @node-click="handleNodeChange"
                       @check-change="(data, checked, indeterminate)=>{ return handleCheckChange(data, checked, indeterminate, column.codeCamel, column.checkStrictly)}"
                       :default-checked-keys="formModel[column.codeCamel]"
                       :props="column.props || treeProps">
              </el-tree>
            </div>
            <!-- 9 级联下拉框v-model="formModel[column.codeCamel]"-->
            <el-cascader v-else-if="column.widgetType === 10"
                         expand-trigger="hover"
                         placeholder="搜索"
                         :options="column.options"
                         filterable clearable
                         :show-all-levels="false"
                         v-model="formModel[column.codeCamel]"
                         :props="column.props || cascaderProps"
                         :style="formStyle && formStyle.cascader && formStyle.cascader.style || {width: '70%'}"
                         @change="column.change && column.change($event, formModel)">
            </el-cascader>
            <!--10 密码框-->
            <el-input v-else-if="column.widgetType === 11" type="password"
                      @change="column.change && column.change($event,formModel)"
                      :style="formStyle && formStyle.input && formStyle.input.style || {width:'70%'}"
                      :disabled="column.disabled"
                      :readonly="column.readonly"
                      v-model="formModel[column.codeCamel]">

            </el-input>
            <!-- 11 普通input  || {width:'65%'}-->
            <el-input v-else-if="column.widgetType === 1 && column.rule && column.rule.type && column.rule.type === 'number'"
                      :style="formStyle && formStyle.input && formStyle.input.style || {width:'70%'}"
                      v-model.number="formModel[column.codeCamel]"
                      :disabled="column.disabled"
                      :readonly="column.readonly"
                      :ref="column.ref || ''"
                      @change="column.change && column.change($event,formModel)">
            </el-input>
            <el-input v-else
                      :style="formStyle && formStyle.input && formStyle.input.style || {width:'70%'}"
                      v-model="formModel[column.codeCamel]"
                      :disabled="column.disabled"
                      :readonly="column.readonly"
                      :ref="column.ref || ''"
                      @change="column.change && column.change($event,formModel)">
            </el-input>
          </el-form-item>
          <!--按钮-->
          <el-form-item v-if="buttons && buttons.length > 0" class="hm-form_btn" style="margin-top: 40px">
            <el-col :span="24/buttons.length" v-for="(btn,key) in buttons" :key="key">
              <el-button v-if="btn.type === 1"
                         type="primary"
                         @click="onSubmit(btn.method,btn.beforeSubmit)">{{btn.text}}</el-button>
              <el-button v-if="btn.type === 2"
                         type="primary"
                         @click="resetForm(btn.method)">{{btn.text}}</el-button>
              <el-button v-if="btn.type === 3"
                         type="primary"
                         @click="cancel(btn.method)">{{btn.text}}</el-button>
              <el-button v-if="!btn.type"
                         type="primary"
                         @click="cancel(btn.method)">{{btn.text}}</el-button>
            </el-col>
          </el-form-item>
        </el-form>
      </el-col>
      <el-col :span="layout ? layout.right : 0">
        <div></div>
      </el-col>
    </el-row>
  </div>
</template>

<script>
  import _ from 'lodash'
  import request from '@/utils/request'
  import { paramEncode } from '@/utils'
  // import commonApi from '@/api/commonApi'

  /**
   * 毫末科技的表单组件.
   *
   *   demo地址: factory.haomo-studio.com/vue-element/#/haomo/components/forms
   * @author 王康 wk@lingdao-tech.com
   */
  export default {
    name: 'HmComplexForm',
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
        required: true
      },
      /**
       * 必传，指定要显示的表单字段及类型。数组的元素为对象类型，对象的属性有name、codeCamel、widgetType、disabled、
       * options、multiple、dateType等，不同的表单类型需配置的属性不同，
       * codeCamel属性，表示要显示的表单字段, 如果其他字段都不需要传，可以只写codeCamel的值，比如['username','departmentId']
       * name属性可选，表示自定义的字段名，如果不传，默认为数据库中的字段名，
       * change属性可选，值为函数类型，表示input的change事件的执行方法，参数即为input输入内容
       * default属性可选(复选框不支持)，设置默认值，取值规范参考form/videoconferencing.vue
       * hide属性可选，设置该表单字段是否显示,值为boolean
       * ref属性树形控件(值必须与codeCamel相同)必传，其他可选，用来获取当前表单dom节点
       * param属性可选，当表单类型为文件类型时，可传入param字段，值为后台规定必传参数，默认值为picture
       * accept属性可选,当表单类型为文件类型时，可传入accept字段，限制限制上传文件类型，取值规范参考w3c
       * fileData属性可选，当表单类型为文件类型时，取值为all(表示返回路径+文件名)，取值为filePath(表示只返回路径)，取值fileName(表示只返回文件名),如果不传，默认只返回路径
       * accordion属性可选，当表单类型为树形控件时，可传入accordion，值为boolean, 表示是否采用手风琴样式展开树形结构，默认为false
       * checkBox属性可选，当表单类型为树形控件时，可传入checkBox，值为boolean, 表示是否显示勾选框，默认false
       * checkStrictly属性可选，当表单类型为树形控件时，可传入checkStrictly，值为boolean, 表示在显示复选框的情况下，是否严格的遵循父子不互相关联的做法，默认为 false
       * ref属性，树形控件必传，且值必须与codeCamel相同
       * widgetType属性可选，表示该字段要显示的表单类型(普通输入框、文本域、富文本、下拉框...)，不传默认为1,普通input
       * 取值1-11(1表示普通输入框,2表示普通下拉框,3表示复选框,4表示文本域,5表示富文本,6表示日期，7表示单选框，8表示文件上传,
       * 9表示树状控件，10表示级联下拉框，11b表示密码框)，
       * 若表单类型为下拉框/复选框/单选框，还需传入options字段，值为数组(数组元素是下拉框/复选框/单选框的选项），
       * 若表单类型为复选框，如果只有一个备选项则不必传options,
       * 若表单类型为下拉框，还可传入multiple字段，取值boolean类型，true/false，表示是否多选，默认false
       * 若表单类型为时间日期，可传入dateType字段，值为'date'（只显示日期）或'datetime'（显示日期和时间），如果不传，
       * 默认只显示日期; 可传入dateFormate字段，为日期格式，取值遵循elementUI DatePicker组件中的日期格式，
       * 比如 只显示日期取值'yyyy-MM-dd'，显示日期和时间取值'yyyy-MM-ddHH:mm:ss'，
       * 如果不传默认为只显示日期取值'yyyy-MM-dd'，date字段和dateFormate字段取值须对应
       * disabled属性可选，取值boolean类型,true/false，表示是否禁用，默认不禁用
       * rule属性可选，进行自定义验证规则，rule取值规范参照elementUI，下面有简单示例
       * 示例：[
       { name: '用户名称', codeCamel: 'username', widgetType: 1, disabled: true,
         rule: { required: true, message: '用户名不能为空', trigger: 'blur' }
       },
       { name: '电子邮件', codeCamel: 'email', widgetType: 5, disabled: false,
         rule: [
           { required: true, message: '请输入邮箱地址', trigger: 'blur' },
           { type: 'email', message: '请输入正确的邮箱地址', trigger: 'blur,change' }
         ]
       },
       { name: '选择类型', codeCamel: 'type', widgetType: 2, multiple: false,
         options: [
                     { value: 0, label: '选项1' },
                     { value: 1, label: '选项2' },
                     { value: 2, label: '选项3' },
                     { value: 3, label: '选项4' },
                     { value: 4, label: '选项5' }
                   ]
       },
       { name: '部门ID', codeCamel: 'departmentId', widgetType: 3, options: ['美女', '帅哥'] },
       { codeCamel: 'password', widgetType: 4 },
       { name: '新建时间', codeCamel: 'createTime', widgetType: 6, dateType: 'datetime', dateFormate: 'yyyy-MM-dd HH:mm:ss' },
       { name: '登陆id', codeCamel: 'loginid', widgetType: 7, options: ['会员', '访客'] },
       { name: '人员', codeCamel: 'people', widgetType: 9,
         options:[
           { value: 'zhinan',label: '指南',
             children: [
               {
                 value: 'shejiyuanze',label: '设计原则',
                 children: [
                   {value: 'yizhi',label: '一致'},
                   {value: 'fankui',label: '反馈'},
                   {value: 'xiaolv',label: '效率'},
                   {value: 'kekong',label: '可控'}
                 ]
               }
             ]
           },
           { value: 'zhinan',label: '指南',
             children: [
               {
                 value: 'shejiyuanze',label: '设计原则',
                 children: [
                   {value: 'yizhi',label: '一致'},
                   {value: 'fankui',label: '反馈'},
                   {value: 'xiaolv',label: '效率'},
                   {value: 'kekong',label: '可控'}
                 ]
               }
             ]
           }
         ]
       },
       { name: '选择头像', codeCamel: 'avatar', widgetType: 8 }
       ]
       */
      columns: {
        type: Array,
        required: true,
        validator: function(value) {
          if (typeof value !== 'object') {
            console.warn(`传入的columns不符合要求，必须是数组`)
            return false
          }
          return true
        }
      },
      /**
       * 非必传，指定要显示的按钮及类型，默认不显示。
       * 类型（type）关系到按钮要执行的方法，type=1，执行组件的提交方法，还可以传入了method字段，值为函数，
       * 该函数会作为提交方法的回调函数执行，函数接受一个参数为新建或修改的数据,
       * 同时还可以传入beforeSubmit字段，值为函数，函数接受两个参数(value,isCancel)
       * value为包含表单数据的对象，{username: 'name', loginid: 'id'},其中键为调用者传入的codeCamel
       * 该函数可以在提交之前对表单数据进行处理，并返回数据；对象isCancel包含一个值为false的属性cancelSubmit
       * 如果需要取消提交，将cancelSubmit值改为true
       * type=2，执行组件的重置方法,如果用户传入了method，会作为重置方法的回调函数执行
       * type=3，取消，直接执行用户传入的方法
       * 如果要自定义按钮执行方法，可以不传type
       * 示例：[
       *        {text: '确定', type: 1, method: method1, beforeSubmit: this.processData},
       *        {text: '重置', type: 2, method: method2},
       *        {text: '取消', type: 3, method: method3},
       *        {text: '自定义',  method: method3}
       *      ]
       */
      buttons: {
        type: Array,
        required: false
      },
      /**
       * 非必传，传入用户的id用来修改用户信息
       */
      tableId: {
        type: String,
        required: false
      },
      /**
       * 非必传，布局方式，form组件布局分三栏，左右为留白，中间是form，
       * 通过传参可以控制各部分所占份数，遵循elementUi24分栏，默认居中布局(left：6，middle：12，right：6)
       * 示例：{ left: 0, middle: 12, right: 12 }
       */
      layout: {
        type: Object,
        required: false
      },
      /**
       * 外查主 用来将本表的外链字段(table_id类似的字段)指向的外链表相关联, 格式为:
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
       * 主查外 用来将其他表的外链字段指向本表关联，同时返回数据, 格式为:
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
       * 要写入或修改的外表字段codeCamel值, 第一个元素为外键字段，格式为:
       *  [ ccSubjectId, description, correct, serialNumber]
       */
      foreignFormFields: {
        type: Array,
        required: false
      },
      /**
       * 用来将其他有间接关系的表(所谓间接关系, 一定是跟本表的某个字段名一致, 且指向同一张表),
       * 两张表中非主键的两个字段相等 格式为:
       *  {
       *    'relate_table1': ['column1', 'column2'], //’关联的另一张表名’:[‘一致的字段名’]
       *    'relate_table1': ['column3', 'column4']
       *    }
       *  }
       */
      relates: {
        type: Array,
        required: false
      },
      /**
       * 函数对象 键为固定值，值为函数
       * 属性beforeRender,编辑/修改数据时，请求数据后表单渲染前执行，可对数据进行处理,beforeRender函数接受两个参数
       * 第一个参数为请求的数据，第二个参数为表单的绑定对象formModel，该函数需要将请求的数据绑定到formModel，并返回formModel
       * 属性uploadFun,上传文件的回调函数，第一个参数为文件上传成功的返回值response，第二个参数为表单的绑定对象formModel,
       * 第三个参数为当前删除的文件的详细信息
       * 属性removeFun,删除文件的回调函数，第一个参数为当前删除文件的信息file，第二个参数为表单的绑定对象formModel
       * 格式为: 属性beforeRender为固定键
       *  {
       *    beforeRender: function(resp.data, formModel) {
       *      do something
       *      return formModel
       *    }，
       *    uploadFun: function(response, formModel, file) {
       *      do something
       *    },
       *    removeFun: function(file, formModel) {
       *      do something
       *    }
       *  }
       */
      funObject: {
        type: Object,
        required: false
      },
      /**
       * 请求成功或失败时的提示信息,格式为:
       *  tips: {
       *     hidde: false, // 是否显示提示，默认false显示
       *     newSuccess: { text: '发布成功' }, // 新建成功的提示
       *     newError: { text: '发布失败' }, // 新建失败的提示
       *     editSuccess: { text: '编辑成功' }, // 编辑成功的提示
       *     editError: { text: '编辑失败' } // 编辑失败的提示
       *     otherError: { text: '没有传ID，不可以提交' }
       *  }
       */
      tips: {
        type: Object,
        required: false
      },
      /**
       * 表单样式设置,格式为:
       *  formStyle: {
       *   formOptions: { labelWidth: '170px', labelPosition: 'right' },
       *   datePicker: { style: { width: '100px' }},
       *   input: { style: { width: '60%' }},
       *   select: { style: { width: '100px' }},
       *   textarea: {
       *      style: { width: '100px' },
       *      resize: 'none',
       *      autosize: { minRows: 3, maxRows: 5 },
       *      rows: 3
       *   },
       *  quillEditor: { style: { width: '65%' }}
       * },
       */
      formStyle: {
        type: Object,
        required: false
      },
      /**
       * 自定义验证规则的第二种方式（第一种是在column数组的对象中传rule）
       * 格式为:
       *  userRules: {
       *     pass: [
       *       { validator: validatePass, trigger: 'blur' }
       *     ],
       *     checkPass: [
       *       { validator: validatePass2, trigger: 'blur' }
       *     ],
       *     age: [
       *       { validator: checkAge, trigger: 'blur' }
       *     ]
       *   }
       */
      rules: {
        type: Object,
        required: false
      }
    },
    data() {
      // var validateUsername = (rule, value, callback) => {
      //   // console.log(value.length)
      //   if (!value) {
      //     callback(new Error('请输入用户名'))
      //   } else if ((value.length < 2 || value.length > 10)) {
      //     callback(new Error('用户名长度在 2 到 10 个字符'))
      //   } else {
      //     callback()
      //   }
      // }
      // var validatePassword = (rule, value, callback) => {
      //   if (value.length > 0 && !(/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,20}$/.test(value))) {
      //     callback(new Error('密码必须同时包含数字和字母 6-20位'))
      //   } else {
      //     callback()
      //   }
      // }
      // var validateMobile = (rule, value, callback) => {
      //   if (value.length > 0 && !(/^((0\d{2,3}-\d{7,8})|(1[3584]\d{9}))$/.test(value))) {
      //     callback(new Error('请输入正确的电话号码或手机号'))
      //   } else {
      //     callback()
      //   }
      // }
      // var validateEmail = (rule, value, callback) => {
      //   if (value.length > 0) {
      //     if (!(/^[A-Za-z0-9\u4e00-\u9fa5]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/.test(value))) {
      //       callback(new Error('请输入正确的邮箱'))
      //     } else {
      //       callback()
      //     }
      //   }
      // }
      return {
        i: 0,
        currentFile: '', // 上传文件时当前选中的codeCamel值
        currentTree: '', // 当前选中的树形菜单的codeCamel值
        treeComponent: '', // 当前的树形菜单组件
        foreignArray: [], // 批量创建或删除的多条外表数据
        nativeFormModel: {}, // 有外表时 本表数据  从formModel中提取
        foreighId: '', // 外表id即 与本表某个id对应
        foreignFormModel: {}, // 字段相同的多条外表数据/外表数据 从formModel中提取
        foreignForm: {}, // 单条外表数据 只包含键，值为空 从foreignFormFields中提取
        partPropModel: {}, // 外表中从属于foreignFormModel的属性 从formModel中提取
        indirectData: '', // 间接关联表数据
        relateData: {}, // 中间表数据
        Loading: true, // 加载等待
        form: null,
        formModel: {}, // 双向绑定的数据对象
        formModelDeal: {}, // 新建或编辑时，提交之前用户对formModel处理之后的数据对象。原因：以级联表单为例，
        // 级联表单v-model绑定的是数组，而往数据库中存储的是数组中的某一个字符串，如果把v-model的值经processData处理之后(数组--->字符串)，仍然用formModel接收，Vue监听会报错(expected Array，got string)，此时需要用formModealDeal接收并提交，不改变表单绑定的数据对象formModel
        showUserColumns: [], // 要显示的字段
        myRules: {
          // username: [
          //   { validator: validateUsername, trigger: 'change' }
          // { required: true, message: '请输入用户名', trigger: 'blur' },
          // { min: 2, max: 10, message: '长度在 2 到 10 个字符', trigger: 'blur' }
          // ],
          // loginid: [
          // { required: true, message: '请输入登陆ID', trigger: 'blur' }
          // ],
          // password: [
          //   { validator: validatePassword, trigger: 'change' }
          // { pattern: /^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,20}$/, message: '密码必须同时包含数字和字母 6-20位', trigger: 'change' }
          // ],
          // mobile: [
          //   { validator: validateMobile, trigger: 'change' }
          // { pattern: /^((0\d{2,3}-\d{7,8})|(1[3584]\d{9}))$/, message: '请输入正确的电话号码', trigger: 'change' }
          // ]
          // email: [
          // { validator: validateEmail, trigger: 'change' }
          // { type: 'email', message: '请输入正确的邮箱', trigger: 'change' }
          // ]
        },
        editorOption: { // 富文本选项配置
          placeholder: '',
          modules: {
            toolbar: [
              ['bold', 'italic', 'underline', 'strike'],
              [{ 'list': 'ordered' }, { 'list': 'bullet' }],
              [{ 'color': [] }, { 'background': [] }],
              ['image']
            ]
          }
        },
        // 树形选项配置
        treeProps: {
          label: 'label',
          // value: 'value',
          children: 'children'
        },
        // 级联下拉选项配置
        cascaderProps: {
          label: 'label',
          value: 'value',
          children: 'children'
        },
        data2: [
          {
            id: 1,
            label: '公诉处',
            children: [
              {
                id: 4,
                label: '刘云山'
              }
            ]
          },
          {
            id: 2,
            label: '监察部',
            children: [
              { id: 5, label: '毛晓东' },
              { id: 6, label: '方建国' }
            ]
          },
          {
            id: 3,
            label: '办公室',
            children: [
              { id: 7, label: '司马南' },
              { id: 8, label: '褚随山' }
            ]
          }
        ],
        defaultProps: {
          children: 'children',
          label: 'label'
        },
        cascaderData: [
          {
            value: 1000,
            label: '接通',
            children: [{
              label: '已报价',
              value: 1100,
              children: [],
              multiple: true // 可忽略项，当为true时该项为多选
            }]
          }
        ],
        // 日期选项配置
        pickerOptions: {
          // disabledDate(time) {
          //   return time.getTime() > Date.now()
          // },
          shortcuts: [{
            text: '今天',
            onClick(picker) {
              picker.$emit('pick', new Date())
            }
          }, {
            text: '昨天',
            onClick(picker) {
              const date = new Date()
              date.setTime(date.getTime() - 3600 * 1000 * 24)
              picker.$emit('pick', date)
            }
          }, {
            text: '一周前',
            onClick(picker) {
              const date = new Date()
              date.setTime(date.getTime() - 3600 * 1000 * 24 * 7)
              picker.$emit('pick', date)
            }
          }]
        },
        fileList: [], // 上传文件列表
        fileCode: '', // 上传组件对应的数据库字段
        isCancel: { cancelSubmit: false } // 主动取消提交（processData中）
      }
    },
    created() {
      this.init()
      this.getData()
      this.getList()
    },
    methods: {
      // 文件上传前的函数
      beforeUpload(file) {
        // console.log('组件中的文件上传前', file)
        // return false // 如果return false 则文件上传取消
      },
      // 删除服务器的文件
      deleteUploadFile(filePath) {
        // 删除服务器上封面图片的文件
        request('delete_file?file_path=' + filePath, {
          headers: { 'Content-Type': 'application/json;charset=UTF-8' }
        }).then(resp => {
          console.log('服务器上的文件删除了', resp)
        })
      },
      // 上传文件成功的回调函数
      uploadSuccess(response, file, fileList, code, fileData) {
        const self = this
        console.log('上传成功', code, fileData, response, file, fileList)
        console.log('formModel', self.formModel)
        if (response.visitName && response.saveName) {
          // 如果fileData值为all 则存路径+名称
          if (fileData === 'all') {
            self.formModel[code].push(response.visitName + '' + response.fileName + '_' + response.saveName)
          } else if (fileData === 'fileName') {
            self.formModel[code].push(response.saveName)
          } else {
            self.formModel[code].push(response.visitName + '' + response.fileName)
          }
        } else if (response.message) {
          self.formModel[code].push(response.message + '_' + file.name)
        }
        // for (var i = 0, len = self.showUserColumns.length; i < len; i++) {
        //   if (self.showUserColumns[i].widgetType === 8) {
        //     for (var key in self.formModel) {
        //       if (key === self.currentFile && self.showUserColumns[i].codeCamel === self.currentFile) {
        //         if (response.visitName && response.saveName) {
        //           // 如果fileData值为all 则存路径+名称
        //           if (self.showUserColumns[i].fileData === 'all') {
        //             self.formModel[key].push(response.visitName + '' + response.fileName + '_' + response.saveName)
        //           } else if (self.showUserColumns[i].fileData === 'fileName') {
        //             self.formModel[key].push(response.saveName)
        //           } else {
        //             self.formModel[key].push(response.visitName + '' + response.fileName)
        //           }
        //         } else if (response.message) {
        //           self.formModel[key].push(response.message + '_' + file.name)
        //         }
        //         break
        //       }
        //     }
        //   }
        // }
        // 执行用户的方法
        if (self.funObject && self.funObject.uploadFun) {
          self.funObject.uploadFun(response, self.formModel, file)
        }
      },
      uploadClick1() {
        console.log('upload点解十家')
      },
      uploadClick(codeCamel) {
        console.log('触发了点击事件')
        this.currentFile = codeCamel
        console.log(this.currentFile)
      },
      // 删除文件时的回调函数
      handleRemove(file, fileList) {
        const self = this
        console.log('文件删除', file, fileList)
        console.log('删除前', self.currentFile, self.formModel)

        // 新建时删除服务器中的文件(通知通报的上传接口)
        if (!self.tableId) {
          if (file && file.response && file.response.message) {
            self.deleteUploadFile(file.response.message)
          } else if (file && file.response && file.response.fileName) {
            // 新建时删除服务器中的文件(会议等其他上传接口)
            const path = file.response.visitName + file.response.fileName
            self.deleteUploadFile(path)
          }
        }

        // 新建时 删除文件 (通知通报的上传接口)
        if (file.response && file.response.message) {
          _.each(self.formModel[self.currentFile], function(item, index) {
            if (_.endsWith(item, file.response.message)) {
              self.$delete(self.formModel[self.currentFile], index)
            }
          })
        } else if (file.response && file.response.fileName) {
          // (会议等其他上传接口)
          _.each(self.formModel[self.currentFile], function(item, index) {
            if (_.endsWith(item, file.response.fileName)) {
              self.$delete(self.formModel[self.currentFile], index)
            } else if (_.endsWith(item, file.response.saveName)) {
              self.$delete(self.formModel[self.currentFile], index)
            }
          })
        }

        // 编辑时 删除文件
        if (file.status === 'success') {
          _.each(self.formModel[self.currentFile], function(item, index) {
            if (_.endsWith(item, file.name) || _.endsWith(item, file.url)) {
              self.$delete(self.formModel[self.currentFile], index)
            }
          })
        }
        // 删除文件时 执行用户的方法
        if (self.funObject && self.funObject.removeFun) {
          self.funObject.removeFun(file, self.formModel)
        }

        // self.formModel[self.currentFile] = ''
        console.log('删除后', self.formModel)
      },
      // 文件状态改变时的回调函数
      handleChange(file, fileList) {
        // console.log('文件状态改变', file, fileList)
        // console.log('自己的')
      },
      // 树形选择器
      handleCheckChange(data, checked, indeterminate, code, checkStrictly) {
        const self = this
        console.log('handleCheckChange函数')
        // console.log(data)
        // console.log(checked)
        // console.log(indeterminate)
        // console.log(this.$refs.tree[0].getCheckedNodes(true))
        // console.log('当前选择的codecamel:', self.currentTree)
        // console.log('当前选择的tree组件', self.treeComponent)
        self.formModel[code] = self.$refs[code][0].getCheckedKeys(true)

        // for (var i = 0, len = self.showUserColumns.length; i < len; i++) {
        //   // && !self.showUserColumns[i].edited
        //   if (self.showUserColumns[i].widgetType === 9) {
        //     // self.$set(self.showUserColumns[i], 'edited', true)
        //     for (var key in self.formModel) {
        //       if (key === self.currentTree && self.showUserColumns[i].codeCamel === self.currentTree) {
        //         // self.formModel[key] = response.message || response.visitName
        //         // 张家口
        //         // self.formModel[key] = response.visitName + response.fileName
        //         // org
        //         self.formModel[key] = self.$refs[self.treeComponent][0].getCheckedKeys(true)
        //         break
        //       }
        //     }
        //     // break
        //   }
        // }
        // 处理单选
        if (checkStrictly) {
          self.i++
          if (self.i % 2 === 0) {
            if (checked) {
              self.$refs[code][0].setCheckedNodes([])
              self.$refs[code][0].setCheckedNodes([data])
              // 交叉点击节点
            } else {
              self.$refs[code][0].setCheckedNodes([])
              // 点击已经选中的节点，置空
            }
          }
        }
        console.log(self.$refs[code][0].getCheckedKeys(true), self.formModel)
      },
      // 树形选择器
      handleNodeChange(data, node, com) {
        // console.log(com)
      },
      treeCheck(data1, data2) {
        console.log(this.currentTree)
      },
      // inputChange(val) {
      //   // console.log(event)
      //   // console.log(val)
      // },
      // checkboxChange(val) {
      //   console.log(val)
      // },
      // checkboxsChange(val) {
      //   console.log(val)
      // },
      // selectChange(val) {
      //   console.log(val)
      // },
      // radioChange(val) {
      //   console.log(val)
      // },
      // logTimeChange(val) {
      //   console.log(val)
      // },
      // textareaChange(val) {
      //   console.log(val)
      // },
      // onEditorChange({ quill, html, text }) {
      //   console.log(quill)
      //   console.log(html)
      //   console.log(text)
      //   // this.content = html
      // },
      onEditorBlur(val) {
        // console.log(val)
      },
      onEditorFocus(val) {
        // console.log('editor focus!')
      },
      onEditorReady(val) {
        // console.log('editor ready!')
      },
      cascaderChange(value) {
        console.log(value)
      },
      // 判断是否一个对象的所有属性都为空
      // 可判断空对象或者属性值为null、空数组、空字符串，属性值为空对象无法判断
      isEmpty(obj) {
        for (var key in obj) {
          if (obj[key] && _.trim(obj[key])) {
            return false
          }
        }
        return true
      },
      // 判断一个对象是否为空对象，没有属性
      isEmptyObject(e) {
        var t
        for (t in e) {
          return !1
        }
        return !0
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
      // 获取间接关联表数据
      getData() {
        const self = this
        if (!self.relates || !self.relates.length || !self.relates[0].indirectTable) return
        // console.log(534, self.relates)
        var params = {}
        params.filters = self.relates[0].filters || { }
        // console.log('url', typeof (self.relates[0].indirectTable))
        request(self.relates[0].indirectTable, {
          params: params
        }).then(resp => {
          // 设置中间表与间接关联表对应字段
          if (resp.data && resp.data.length) {
            // console.log(resp.data)
            self.$set(self.relateData, self.relates[1].relateKeys[1], resp.data[0].id)
          }
          // console.log(548, self.relateData)
        })
      },
      // 创建中间表数据
      newRelateData() {
        const self = this
        if (self.tableId || !self.relates || !self.relates.length || !self.relates[1].relateTable) return
        var data = self.relateData
        if (self.isEmpty(data)) {
          console.error('不能创建空数据')
          return
        }
        request(self.relates[1].relateTable + '/new', {
          method: 'post',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8' },
          data: data,
          transformRequest:
            function(obj) {
              var str = []
              for (var p in obj) {
                str.push(encodeURIComponent(p) + '=' + encodeURIComponent(obj[p]))
              }
              return str.join('&')
            }
        }).then(resp => {
          console.log('创建中间表成功')
          // console.log(resp.data)
        })
      },
      // 批量创建的参数处理
      transformRequest(arr) {
        var str = []
        _.each(arr, function(obj, i) {
          for (var k in obj) {
            str.push(encodeURIComponent(k) + '=' + encodeURIComponent(obj[k]))
          }
        })
        // console.log(str.join('&'))
        return str.join('&')
      },
      // 存在tableId，编辑数据前先获取数据
      getList() {
        const self = this
        if (!self.tableId) return
        const filters = {}
        const params = {}
        filters[self.schema.modelUnderscore] = { 'id': { 'equalTo': self.tableId }}
        // self.$set(filters, self.schema.modelUnderscore, { 'id': { 'equalTo': self.tableId }})
        params.filters = filters
        // 主查外
        if (self.refers && !self.isEmptyObject(self.refers)) {
          params.refers = self.refers
        }
        // 外查主
        if (self.includes && !self.isEmptyObject(self.includes)) {
          params.includes = self.includes
        }
        console.log('params', params)
        // 获取数据  + '/' + self.tableId
        request(self.schema.modelUnderscorePlural, {
          params: params
        }).then(resp => {
          self.Loading = false
          // console.log(self.formModel)
          // console.log('获取成功', resp.data)
          // 如果是既有外查主又有主查外
          if (resp.data.length > 0 && resp.data[0].superior !== undefined && !self.isEmptyObject(resp.data[0].superior) && resp.data[0].refers !== undefined && !self.isEmptyObject(resp.data[0].refers) && resp.data[0].includes !== undefined && !self.isEmptyObject(resp.data[0].includes)) {
            console.log('主外联查', resp.data)
            // 渲染之前执行用户的beforeRender方法对数据进行处理
            if (self.funObject && !self.isEmptyObject(self.funObject)) {
              self.formModel = self.funObject.beforeRender(resp.data, self.formModel)
            }
            // 如果是外查主
          } else if (resp.data.length > 0 && resp.data[0].superior !== undefined && !self.isEmptyObject(resp.data[0].superior) && resp.data[0].includes !== undefined && !self.isEmptyObject(resp.data[0].includes)) {
            console.log('外查主', resp.data)
            self.foreighId = resp.data[0].includes[_.keys(self.includes)[0]].id
            // 渲染之前执行用户的beforeRender方法对数据进行处理
            if (self.funObject && !self.isEmptyObject(self.funObject)) {
              self.formModel = self.funObject.beforeRender(resp.data, self.formModel)
            }
            // 如果是主查外
          } else if (resp.data.length > 0 && resp.data[0].superior !== undefined && !self.isEmptyObject(resp.data[0].superior) && resp.data[0].refers !== undefined && !self.isEmptyObject(resp.data[0].refers)) {
            console.log('主查外', resp.data)
            // 渲染之前执行用户的beforeRender方法对数据进行处理
            if (self.funObject && !self.isEmptyObject(self.funObject)) {
              self.formModel = self.funObject.beforeRender(resp.data, self.formModel)
            }
            // 如果只是单表
          } else if (resp.data.length > 0) {
            console.log('单表查询', resp.data)
            var formArray = _.keys(self.formModel) // 提取formModel的属性到数组
            if (resp.data[0].superior && !self.isEmptyObject(resp.data[0].superior)) {
              self.formModel = _.pick(resp.data[0].superior, formArray) // 根据数组中的属性提取出data中对应的数据
            } else {
              self.formModel = _.pick(resp.data[0], formArray)
            }
            // 渲染之前执行用户的beforeRender方法对数据进行处理
            if (self.funObject && typeof (self.funObject.beforeRender) === 'function') {
              self.formModel = self.funObject.beforeRender(resp.data, self.formModel)
            }
            // console.log('获取到数据', self.formModel)
            // 处理返回来的数据
            console.log('getList处理多选前', self.formModel)

            _.each(self.columns, function(item, index) {
              // 下拉框多选时将字符串转为数组 column.widgetType === 3 && !column.options
              if (item.widgetType === 2 && item.multiple === true) {
                _.forEach(self.formModel, function(value, key) {
                  if (item.codeCamel === key) {
                    self.formModel[key] = self.formModel[key].split(',')
                  }
                })
              }
              // 下拉框单选时将数字转为字符串 column.widgetType === 3 && !column.options
              if (item.widgetType === 2 && !item.multiple) {
                _.forEach(self.formModel, function(value, key) {
                  if (item.codeCamel === key) {
                    if (typeof self.formModel[key] === 'number') {
                      self.formModel[key] = self.formModel[key] + ''
                    }
                    // self.formModel[key] = self.formModel[key].split(',')
                  }
                })
              }
              // 单个复选框时，将请求回来的1和0转为'1'和'0'
              if (item.widgetType === 3 && !item.options) {
                _.forEach(self.formModel, function(value, key) {
                  if (item.codeCamel === key) {
                    // console.log(11111, self.formModel[key])
                    self.formModel[key] = self.formModel[key] + ''
                  }
                })
              }
              // 文件上传、级联菜单将请求回来的字符串放数组中
              if (item.widgetType === 8 || item.widgetType === 10) {
                _.forEach(self.formModel, function(value, key) {
                  if (item.codeCamel === key) {
                    // console.log(11111, self.formModel[key])
                    if (value === null || value === '') {
                      self.formModel[key] = []
                    } else {
                      self.formModel[key] = self.formModel[key].split(',')
                    }
                  }
                })
              }
              // 树形控件、文件上传，将请求回来的字符串放数组中
              if (item.widgetType === 9) {
                _.forEach(self.formModel, function(value, key) {
                  if (item.codeCamel === key) {
                    // console.log(11111, self.formModel[key])
                    if (value === null || value === '') {
                      self.formModel[key] = []
                    } else {
                      self.formModel[key] = self.formModel[key].split(',')
                      self.$refs[key][0].setCheckedKeys(self.formModel[key])
                    }
                  }
                })
              }
            })
          }
          console.log('getList', self.formModel)
        }).catch(error => {
          console.error(error)
        })
      },
      // 初始化
      init() {
        const self = this
        if (self.columns && self.columns.length) {
          // self.showUserColumns = _.cloneDeep(self.columns)
          self.showUserColumns = self.columns
          // 处理传来的表单字段
          _.each(self.showUserColumns, function(column, index) {
            if (typeof column === 'string') {
              // 生成一个新对象
              const tmp = _.keyBy(self.schema['columns'], 'codeCamel')[column]
              /* self.$set(tmp, 'code', tmp.code.toLowerCase())
              column.name && self.$set(tmp, 'name', column.name) // 自定义字段名
              column.rule && self.$set(tmp, 'rule', column.rule) // 设置表单校验规则
              column.disabled && self.$set(tmp, 'disabled', column.disabled) // 设置是否禁用
              column.options && self.$set(tmp, 'options', column.options) // 设置下拉框或者多选的选项
              column.multiple && self.$set(tmp, 'multiple', column.multiple) // 设置下拉框是否多选
              column.dateType && self.$set(tmp, 'dateType', column.dateType) // 设置日期表单显示类型
              column.dateFormate && self.$set(tmp, 'dateFormate', column.dateFormate) // 设置日期格式
              column.change && self.$set(tmp, 'change', column.change) // 设置change函数
              column.url && self.$set(tmp, 'url', column.url) // 设置文件上传地址 */
              self.$set(tmp, 'widgetType', 1) // 设置表单类型
              self.$set(self.showUserColumns, index, tmp) // 顺序
            }
          })
          // console.log('self.showUserColumns', self.showUserColumns)
          // 提取v-model绑定的变量
          _.each(self.showUserColumns, function(item) {
            // 设置值为数组
            if (item.widgetType === 8 || item.widgetType === 10 || item.widgetType === 9 || (item.widgetType === 3 && item.options && item.options.length > 0)) {
              self.$set(self.formModel, item.codeCamel, [])
            } else {
              // 设置默认值
              item.default ? self.$set(self.formModel, item.codeCamel, item.default) : self.$set(self.formModel, item.codeCamel, '')
            }
          })
          console.log('初始化self.formModel', self.formModel)
          if (!request.defaults.baseURL) {
            request.defaults.baseURL = '/org/api'
          }
          // console.log(request.defaults.baseURL)
          // 加载等待
          if (self.tableId) {
            self.Loading = true
          } else {
            self.Loading = false
          }
        } else {
          console.log('columns为必传字段!!')
        }
      },
      // 提交
      /**
       * 确定提交函数。
       *
       * 所有选项输入并验证通过，正确提交
       * 验证失败，禁止提交并给出提示
       */
      onSubmit(callback, processData) {
        const self = this
        // 提交上传文件到服务器
        // console.log(self.$refs.upload[0])
        // self.$refs.upload[0].submit()
        console.log('点击了提交函数', self.formModel)
        // 如果所有值都为空 禁止提交
        if (self.isEmpty(self.formModel)) {
          self.$message({
            message: '不能都为空',
            type: 'error'
          })
          return
        }
        // 提交之前对表单数据进行处理
        self.formModelDeal = processData ? processData(self.formModel, self.isCancel) : self.formModel
        console.log('表单数据经过了处理', self.formModelDeal)
        // 如果在processData中禁止提交了，显示提示信息
        if (self.isCancel.cancelSubmit) {
          console.log('取消提交')
          if (self.tips && !self.isEmptyObject(self.tips) && !self.tips.hidde && self.tips.otherError && !self.isEmptyObject(self.tips.otherError)) {
            self.$message({
              message: self.tips.otherError.text,
              type: 'error'
            })
          }
          self.isCancel.cancelSubmit = false
          return
        }
        // 验证、提交
        self.$refs.form.validate((valid) => {
          if (valid) {
            // console.log('valid通过!')
            // 存在tableId 则修改信息
            if (self.tableId) {
              // 外查主 从formModel中分离本表、外表数据
              if (self.includes && !self.isEmptyObject(self.includes)) {
                _.each(self.formModel, function(val, idx) {
                  // 后缀带O是非本表 连带查出来的表 并非就是指外表
                  // if (idx.slice(-1) === 'O') {
                  //   idx = idx.slice(0, idx.length - 1)
                  //   self.foreignFormModel[idx] = val
                  // } else {
                  //   // 不带后缀是本表
                  //   idx = idx.slice(0, idx.length - 1)
                  //   self.nativeFormModel[idx] = val
                  // }
                  if (idx.slice(-1) === 'C') {
                    idx = idx.slice(0, idx.length - 1)
                    self.nativeFormModel[idx] = val
                  } else {
                    idx = idx.slice(0, idx.length - 1)
                    self.foreignFormModel[idx] = val
                  }
                })
              }
              console.log(879, self.nativeFormModel)
              console.log(880, self.foreignFormModel)
              // 修改本表数据
              request(self.schema.modelUnderscorePlural + '/' + self.tableId + '/edit', {
                method: 'post',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8' },
                data: self.isEmptyObject(self.nativeFormModel) ? self.formModelDeal : self.nativeFormModel,
                transformRequest:
                  function(obj) {
                    var str = []
                    // 删除空值的属性
                    obj = _.omitBy(obj, function(value) {
                      return value === null // 删除value=null的属性，剩下的返回给新对象
                    })
                    for (var p in obj) {
                      str.push(encodeURIComponent(p) + '=' + encodeURIComponent(obj[p]))
                    }
                    return str.join('&')
                  }
              }).then(resp => {
                console.log('修改本表成功', resp)
                // self.resetForm()
                if (self.tips && !self.isEmptyObject(self.tips) && !self.tips.hidde) {
                  self.$message({
                    message: self.tips.editSuccess.text,
                    type: 'success'
                  })
                }

                // 修改成功执行用户回调
                if (typeof (callback) === 'function') {
                  callback(resp.data, self.formModelDeal)
                }
              }).catch(err => {
                console.error(err)
                if (self.tips && !self.isEmptyObject(self.tips) && !self.tips.hidde) {
                  self.$message({
                    message: self.tips.editError.text,
                    type: 'error'
                  })
                }
              })

              // 修改本表完成后拿到id再修改外表数据
              if (self.includes && !self.isEmptyObject(self.includes) && !self.isEmptyObject(self.foreignFormModel)) {
                request(_.keys(self.includes)[0] + 's/' + self.foreighId + '/edit', {
                  method: 'post',
                  headers: { 'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8' },
                  data: self.foreignFormModel,
                  transformRequest:
                    function(obj) {
                      var str = []
                      // 删除空值的属性
                      obj = _.omitBy(obj, function(value) {
                        return value === null // 删除value=null的属性，剩下的返回给新对象
                      })
                      for (var p in obj) {
                        str.push(encodeURIComponent(p) + '=' + encodeURIComponent(obj[p]))
                      }
                      return str.join('&')
                    }
                }).then(resp => {
                  console.log('修改外表成功', resp)
                })
              }
            } else {
              // 不存在tableId 则创建一条数据
              // console.log(self.formModel)
              if (self.refers && self.foreignForm) {
                // 遍历foreignFormFields 生成外表数据对象
                _.each(self.foreignFormFields, function(val, key) {
                  self.$set(self.foreignForm, val, '')
                })
                console.log('self.foreignForm', self.foreignForm)
                _.each(self.showUserColumns, function(item, index) {
                  // 提取本表数据以提交
                  if (!item.isForeign) {
                    for (const key in self.formModel) {
                      if (item.codeCamel === key) {
                        self.nativeFormModel[key] = self.formModel[key]
                        break
                      }
                    }
                  }
                  // 提取字段相同的多条外表数据 到foreignFormModel
                  if (item.isForeign && !item.partProp) {
                    for (const key in self.formModel) {
                      if (item.codeCamel === key) {
                        self.foreignFormModel[key] = self.formModel[key]
                        break
                      }
                    }
                  }
                  // 提取外表中从属于foreignFormModel的属性到partPropModel
                  if (item.partProp) {
                    for (const key in self.formModel) {
                      if (item.codeCamel === key) {
                        self.partPropModel[key] = self.formModel[key]
                        break
                      }
                    }
                  }
                })
                // 处理多选时 部分属性值为数组，转成字符串
                // _.each(self.partPropModel, function(value, key) {
                //   if (typeof value === Object && value.length && value.length > 0) {
                //     self.partPropModel[key] = value.join('')
                //   }
                // })
                // console.log('本表', self.nativeFormModel)
                // console.log('外表', self.foreignFormModel)
                // console.log('部分属性', self.partPropModel)
              }
              // 发送新建请求
              console.log('请求之前', self.formModelDeal)
              request(self.schema.modelUnderscorePlural + '/new', {
                method: 'post',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8' },
                data: self.isEmptyObject(self.refers) ? self.formModelDeal : self.nativeFormModel,
                transformRequest:
                  function(obj) {
                    var str = []
                    for (var p in obj) {
                      str.push(encodeURIComponent(p) + '=' + encodeURIComponent(obj[p]))
                    }
                    return str.join('&')
                  }
              }).then(resp => {
                console.log('创建成功', resp.data)
                // 创建中间表数据
                if (resp.data && self.relates && self.relates.length && self.relates[1].relateTable) {
                  self.$set(self.relateData, self.relates[1].relateKeys[0], resp.data.id)
                  self.newRelateData()
                  // console.log(self.relateData)
                }
                // 将返回的id写入foreignForm
                if (!self.isEmptyObject(self.foreignForm)) {
                  self.$set(self.foreignForm, self.foreignFormFields[0], resp.data.id)
                }
                // 从foreignFormModel和单条外表foreignForm中提取多条数据到foreignArray
                if (!self.isEmptyObject(self.foreignFormModel)) {
                  _.each(self.foreignFormModel, function(val, key) {
                    var temp = _.cloneDeep(self.foreignForm)
                    var idx = key.slice(0, -1)
                    temp[idx] = val
                    // temp = Object.assign(temp, self.partProp)
                    self.foreignArray.push(temp)
                  })
                }

                // 提取serialNumber: 'A'之类，属于外表写入/修改的数据
                if (!self.isEmptyObject(self.foreignForm)) {
                  _.each(self.showUserColumns, function(item, index) {
                    if (item.isForeign && !item.partProp) {
                      _.each(item, function(val, key) {
                        if (_.has(self.foreignForm, key)) {
                          for (let i = 0, len = self.foreignArray.length; i < len; i++) {
                            if (!self.foreignArray[i][key]) {
                              self.foreignArray[i][key] = val
                              break
                            }
                          }
                        }
                      })
                    }
                  })
                }
                // console.log('外表公共属性partProp', self.partPropModel)
                // 把外表公共属性partProp的值写入foreignArray的每条数据对象
                if (self.foreignArray.length > 0) {
                  _.each(self.foreignArray, function(item, key) {
                    var tem = _.cloneDeep(self.partPropModel)
                    var tem2 = _.values(self.partPropModel)[0]
                    if (typeof tem2 !== 'object') {
                      if (_.includes(item, tem2)) {
                        tem[_.keys(self.partPropModel)[0]] = 1 // 可能出问题
                      } else {
                        tem[_.keys(self.partPropModel)[0]] = 0 // 可能出问题
                      }
                    } else {
                      _.each(tem2, function(value, k) { // ['A','B']
                        _.each(item, function(v, i) { // {ccSubjectId:'aaa',description: 'aaa, correct: '', serialNumber: 'A'}
                          if (value === v && tem[_.keys(self.partPropModel)[0]] !== 1) {
                            tem[_.keys(self.partPropModel)[0]] = 1
                          }
                          if ((value !== v && tem[_.keys(self.partPropModel)[0]] !== 1)) {
                            tem[_.keys(self.partPropModel)[0]] = 0
                          }
                        })
                      })
                      console.log('多选--数组')
                    }
                    item = Object.assign(item, tem)
                  })
                  // console.log('外表数据', self.foreignArray)
                  // 批量创建信息
                  const url = _.keys(self.refers)[0] + 's' + '/create/batch'
                  // const string = self.transformRequest(self.foreignArray)
                  const string = JSON.stringify(self.foreignArray)
                  request(url, {
                    method: 'POST',
                    data: { params: string },
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8' },
                    transformRequest: paramEncode
                  }).then(resp => {
                    console.log('批量创建成功', resp.data)
                  }).catch(error => {
                    console.log('批量创建失败', error)
                  })
                  // request.post(url + '?params=' + string, {
                  //   headers: { 'Content-Type': 'application/json;charset=UTF-8' }
                  // }).then(resp => {
                  //   console.log('批量创建成功', resp.data)
                  // }).catch(error => {
                  //   console.log('批量创建失败', error)
                  // })
                }
                // 提示信息
                if (self.tips && !self.isEmptyObject(self.tips) && !self.tips.hidde) {
                  self.$message({
                    message: self.tips.newSuccess.text,
                    type: 'success'
                  })
                }
                // 新建成功执行用户回调
                if (typeof (callback) === 'function') {
                  callback(resp.data, self.formModelDeal)
                }
                // 清空上传文件和树形菜单的codeComel
                self.currentFile = ''
                self.currentTree = ''
              }).catch(err => {
                console.error(err)
                if (self.tips && !self.isEmptyObject(self.tips) && !self.tips.hidde) {
                  self.$message({
                    message: self.tips.newError.text,
                    type: 'error'
                  })
                }
              })
            }
            // self.close()
          } else {
            console.log('提交失败!!')
            self.$message({
              message: '验证未通过',
              type: 'error'
            })
            return false
          }
        })
        // paramsSerializer: function(data) {
        //   const keys = Object.keys(data)
        //   return encodeURI(keys.map(name => `${name}=${data[name]}`).join('&'))
        // }
      },
      // 重置
      /**
       * 表单重置函数。
       *
       * 清空所有输入及提示信息。
       */
      resetForm(callback) {
        // const self = this
        console.log('重置')
        this.$refs.form.resetFields()
        // console.log(self.formModel)
        // // 清空
        // _.each(self.formModel, function(value, index) {
        //   self.formModel[index] = ''
        // })
        // 执行回调
        if (typeof (callback) === 'function') {
          callback()
        }
        // this.close()
      },
      // 取消的回调函数
      cancel(callback) {
        const self = this
        if (typeof (callback) === 'function') {
          callback(self.formModel, self.formModelDeal)
        }
        console.log(self.formModel, self.formModelDeal)
        // console.log('id', self.tableId)
        // 如果是新建时点了取消 删除服务器上的文件
        if (!self.tableId) {
          _.each(self.showUserColumns, function(item, key) {
            if (item.widgetType === 8) {
              _.each(self.formModel[item.codeCamel], function(str, k) {
                const i = str.indexOf('_')
                let path = ''
                if (i > 0) {
                  path = str.slice(0, i)
                  self.deleteUploadFile(path)
                }
              })
            }
          })
        }
        // self.close()
      },
      close() {
        this.$emit('formVisible')
      }
    }

  }
</script>
<style>
  .hm-form .el-form-item__content{
    margin-left: 173px !important;
  }
  .hm-form .ql-toolbar.ql-snow .ql-formats{
    margin-right: 3px;
  }
  .hm-form .ql-toolbar.ql-snow + .ql-container.ql-snow {
    height: 150px;
  }
  .hm-form .ql-toolbar.ql-snow{
    padding: 7px;
  }
  .hm-form .el-input__inner:hover{
    border-color: rgba(153, 153, 153, 0.6);
  }
  .hm-form .hm-form_form_div{
    border-radius: 4px;
    border: 1px solid #dcdfe6;
    max-height: 134px;
    overflow-y: scroll;
  }
  .hm-form .hm-form_form_div:hover{
    border-color: rgba(153, 153, 153, 0.6);
  }
  .hm-form .hm-form_form_div::-webkit-scrollbar{
    display: none;
  }
  /*.hm-form .el-tree{*/
  /*border-radius: 4px;*/
  /*border: 1px solid red;*/
  /*height: 150px;*/
  /*overflow-y: auto;*/
  /*}*/
</style>
