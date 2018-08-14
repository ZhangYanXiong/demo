### 基本使用

```jsx
    <hm-complex-table :schema="{
                                   'model': 'Role',
                                   'modelPlural': 'Roles',
                                   'modelCamel': 'role',
                                   'modelCamelPlural': 'roles',
                                   'modelUnderscore': 'role',
                                   'modelUnderscorePlural': 'roles',
                                   'columns': [
                                     {
                                       'id': 'o121',
                                       'objectId': 'E9AC3A9C-D43B-4384-A7EE-05E60BF711A7',
                                       'name': '姓名',
                                       'code': 'NAME',
                                       'creationDate': '1498990741',
                                       'creator': 'hm20160509',
                                       'modificationDate': '1498997012',
                                       'modifier': 'xjq',
                                       'dataType': 'VARCHAR2(128CHAR)',
                                       'length': '128',
                                       'codeCamel': 'name',
                                       'codeCamelPlural': 'names',
                                       'codeUnderscore': 'name',
                                       'codeUnderscorePlural': 'names',
                                       'type': 'string'
                                     },
                                     {
                                       'id': 'o122',
                                       'objectId': 'A99D5EAB-FE49-4D56-94EE-0CAB2FEC3788',
                                       'name': '描述',
                                       'code': 'DESCRIPTION',
                                       'creationDate': '1498990741',
                                       'creator': 'hm20160509',
                                       'modificationDate': '1498997012',
                                       'modifier': 'xjq',
                                       'dataType': 'CLOB',
                                       'codeCamel': 'description',
                                       'codeCamelPlural': 'descriptions',
                                       'codeUnderscore': 'description',
                                       'codeUnderscorePlural': 'descriptions',
                                       'type': 'string'
                                     },
                                     {
                                       'id': 'o123',
                                       'objectId': '4B3D418C-C2C3-4785-A68A-C54918DE9160',
                                       'name': '创建时间',
                                       'code': 'CREATE_TIME',
                                       'creationDate': '1498990741',
                                       'creator': 'hm20160509',
                                       'modificationDate': '1498997012',
                                       'modifier': 'xjq',
                                       'dataType': 'DATE',
                                       'codeCamel': 'createTime',
                                       'codeCamelPlural': 'createTimes',
                                       'codeUnderscore': 'create_time',
                                       'codeUnderscorePlural': 'create_times',
                                       'type': 'datetime'
                                     },
                                     {
                                       'id': 'o124',
                                       'objectId': '06523D0E-DAF6-4172-AF06-B3B6240EB8CB',
                                       'name': '等级',
                                       'code': 'RANK',
                                       'creationDate': '1498990741',
                                       'creator': 'hm20160509',
                                       'modificationDate': '1498997012',
                                       'modifier': 'xjq',
                                       'dataType': 'NUMBER',
                                       'codeCamel': 'rank',
                                       'codeCamelPlural': 'ranks',
                                       'codeUnderscore': 'rank',
                                       'codeUnderscorePlural': 'ranks',
                                       'type': 'number'
                                     }
                                   ]
                                 }"></hm-complex-table>
```

### 指定列表显示的列及搜索条件

```vue
<template>
  <div class="app-container calendar-list-container">
    <hm-complex-table :schema="schema['HmUser']"
                      :columns="showUserColumns"
                      :filters="userFilters"
                      :options="userOptions"></hm-complex-table>
  </div>
</template>

<script>
  export default {
    name: 'HmComplexTableIndex',
    data() {
      return {
        schema: {
            'HmUser': {
                'model': 'HmUser',
                'modelPlural': 'HmUsers',
                'modelCamel': 'hmUser',
                'modelCamelPlural': 'hmUsers',
                'modelUnderscore': 'hm_user',
                'modelUnderscorePlural': 'hm_users',
                'columns': [
                  {
                    'id': 'o50',
                    'objectId': '170A4473-36CC-47E1-96C3-F238F8132AA4',
                    'name': '用户名字',
                    'code': 'USERNAME',
                    'creationDate': '1498990741',
                    'creator': 'hm20160509',
                    'modificationDate': '1517859502',
                    'modifier': 'hm20160509',
                    'dataType': 'VARCHAR2(256CHAR)',
                    'length': '256',
                    'codeCamel': 'username',
                    'codeCamelPlural': 'usernames',
                    'codeUnderscore': 'username',
                    'codeUnderscorePlural': 'usernames',
                    'type': 'string'
                  },
                  {
                    'id': 'o51',
                    'objectId': '70EC38C6-4AE4-4E79-BA72-29DA2FE50782',
                    'name': '登录ID',
                    'code': 'LOGINID',
                    'creationDate': '1498990741',
                    'creator': 'hm20160509',
                    'modificationDate': '1498995491',
                    'modifier': 'xjq',
                    'dataType': 'VARCHAR2(256CHAR)',
                    'length': '256',
                    'columnMandatory': '1',
                    'codeCamel': 'loginid',
                    'codeCamelPlural': 'loginids',
                    'codeUnderscore': 'loginid',
                    'codeUnderscorePlural': 'loginids',
                    'type': 'string'
                  },
                  {
                    'id': 'o52',
                    'objectId': '4FCE7185-D489-4DED-AA5F-093A4DBC1112',
                    'name': '密码',
                    'code': 'PASSWORD',
                    'creationDate': '1498990741',
                    'creator': 'hm20160509',
                    'modificationDate': '1498995491',
                    'modifier': 'xjq',
                    'dataType': 'VARCHAR2(256CHAR)',
                    'length': '256',
                    'codeCamel': 'password',
                    'codeCamelPlural': 'passwords',
                    'codeUnderscore': 'password',
                    'codeUnderscorePlural': 'passwords',
                    'type': 'string'
                  },
                  {
                    'id': 'o53',
                    'objectId': '3A897125-CB02-40F5-9BB1-62A9B06553E0',
                    'name': '联系电话',
                    'code': 'MOBILE',
                    'creationDate': '1498990741',
                    'creator': 'hm20160509',
                    'modificationDate': '1498995491',
                    'modifier': 'xjq',
                    'dataType': 'VARCHAR2(16CHAR)',
                    'length': '16',
                    'codeCamel': 'mobile',
                    'codeCamelPlural': 'mobiles',
                    'codeUnderscore': 'mobile',
                    'codeUnderscorePlural': 'mobiles',
                    'type': 'string'
                  },
                  {
                    'id': 'o54',
                    'objectId': '48B9C079-3CCA-4886-9543-3AE764998E9A',
                    'name': '邮箱',
                    'code': 'EMAIL',
                    'creationDate': '1498990741',
                    'creator': 'hm20160509',
                    'modificationDate': '1498995491',
                    'modifier': 'xjq',
                    'dataType': 'VARCHAR2(256CHAR)',
                    'length': '256',
                    'codeCamel': 'email',
                    'codeCamelPlural': 'emails',
                    'codeUnderscore': 'email',
                    'codeUnderscorePlural': 'emails',
                    'type': 'string'
                  },
                  {
                    'id': 'o55',
                    'objectId': '533AB6E8-A3D0-473D-9DE6-0D0CABA6731C',
                    'name': '头像',
                    'code': 'AVATAR',
                    'creationDate': '1498990741',
                    'creator': 'hm20160509',
                    'modificationDate': '1498995491',
                    'modifier': 'xjq',
                    'dataType': 'VARCHAR2(1024CHAR)',
                    'length': '1024',
                    'codeCamel': 'avatar',
                    'codeCamelPlural': 'avatars',
                    'codeUnderscore': 'avatar',
                    'codeUnderscorePlural': 'avatars',
                    'type': 'string'
                  },
                  {
                    'id': 'o56',
                    'objectId': 'EF44AF1F-F6B9-412F-9FF7-AAECD6B5521A',
                    'name': '创建时间',
                    'code': 'CREATE_TIME',
                    'creationDate': '1498990741',
                    'creator': 'hm20160509',
                    'modificationDate': '1498995491',
                    'modifier': 'xjq',
                    'dataType': 'DATE',
                    'codeCamel': 'createTime',
                    'codeCamelPlural': 'createTimes',
                    'codeUnderscore': 'create_time',
                    'codeUnderscorePlural': 'create_times',
                    'type': 'datetime'
                  },
                  {
                    'id': 'o57',
                    'objectId': 'CD1BC772-356B-4D14-A40E-28F115F95EEC',
                    'name': '更新时间',
                    'code': 'LAST_UPDATE_TIME',
                    'creationDate': '1498990741',
                    'creator': 'hm20160509',
                    'modificationDate': '1498995491',
                    'modifier': 'xjq',
                    'dataType': 'DATE',
                    'codeCamel': 'lastUpdateTime',
                    'codeCamelPlural': 'lastUpdateTimes',
                    'codeUnderscore': 'last_update_time',
                    'codeUnderscorePlural': 'last_update_times',
                    'type': 'datetime'
                  },
                  {
                    'id': 'o58',
                    'objectId': '297D03AE-459D-4991-A459-3449FE893EEB',
                    'name': '最后登录时间',
                    'code': 'LAST_LOGIN_TIME',
                    'creationDate': '1498990741',
                    'creator': 'hm20160509',
                    'modificationDate': '1498995491',
                    'modifier': 'xjq',
                    'dataType': 'DATE',
                    'codeCamel': 'lastLoginTime',
                    'codeCamelPlural': 'lastLoginTimes',
                    'codeUnderscore': 'last_login_time',
                    'codeUnderscorePlural': 'last_login_times',
                    'type': 'datetime'
                  },
                  {
                    'id': 'o59',
                    'objectId': '6767F0FE-6C49-46F3-919E-D854C21FCA52',
                    'name': '安全级别',
                    'code': 'SECURITY_LEVEL',
                    'creationDate': '1498990741',
                    'creator': 'hm20160509',
                    'modificationDate': '1498995491',
                    'modifier': 'xjq',
                    'dataType': 'NUMBER(11,0)',
                    'length': '11',
                    'codeCamel': 'securityLevel',
                    'codeCamelPlural': 'securityLevels',
                    'codeUnderscore': 'security_level',
                    'codeUnderscorePlural': 'security_levels',
                    'type': 'number'
                  },
                  {
                    'id': 'o60',
                    'objectId': 'C4BF570D-C8FC-4B72-919C-78DB3D790171',
                    'name': '类型',
                    'code': 'TYPE',
                    'creationDate': '1498990741',
                    'creator': 'hm20160509',
                    'modificationDate': '1498995491',
                    'modifier': 'xjq',
                    'comment': '1:企业，2：代理商',
                    'dataType': 'NUMBER(11,0)',
                    'length': '11',
                    'codeCamel': 'type',
                    'codeCamelPlural': 'types',
                    'codeUnderscore': 'type',
                    'codeUnderscorePlural': 'types',
                    'type': 'number'
                  }
                ]
              }
        },
        showUserColumns: ['mobile', 'loginid', 'username', 'email'],
        userFilters: [
          { placeholder: '过滤手机号', 'mobile': { 'like': '' }},
          { placeholder: '过滤用户名', 'username': { 'equalTo': '' }}
        ]
      }
    },
    created() {
      this.schema = schema
      this.userOptions = {
              changeValue: {
                username: { 1: '是', 0: '否' }
              },
              newData: {
                isShow: true,
                showUserColumns: [{ name: 'username', widgetType: 1 }, { name: 'loginid', widgetType: 1 }, { name: 'type', widgetType: 1 }],
                formSchema: schema['HmUser'],
                showUserButtons: ['提交', '取消'],
                formConfirm() {
                  console.log('提交')
                },
                formCancel() {
                  console.log('取消')
                }
              },
              editData: {
                isShow: true,
                showUserColumns: [{ name: 'username', widgetType: 1 }],
                formSchema: schema['HmUser'],
                showUserButtons: ['提交', '取消'],
                formConfirm() {
                  console.log('提交')
                },
                formCancel() {
                  console.log('取消')
                }
              },
              showRefresh: true,
              showExport: true,
              showDeleteButton: true,
              buttonGroup: false,
              showDetail: {
                isShow: true,
                showColumns: ['mobile', 'loginid', 'username', 'email']
              }
            }
    }
  }
</script>


```