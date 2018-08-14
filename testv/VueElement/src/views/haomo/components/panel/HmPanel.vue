<template>
  <el-row type="flex">
    <el-col :span="options.panel_span" class="detail-content" :class="options.panel_class" style="margin:0 auto">
      <el-card class="box-card" :style="options.panel_style">
        <div slot="header" class="clearfix" :class="[options.title_class, options.canCollapse ? 'pointer' : '']" @click="toggle()">
          <slot name="title"></slot>
        </div>
        <div :style="options.content_height" :class="options.content_class" v-show="collapse">
          <slot name="content"></slot>
        </div>
      </el-card>
    </el-col>
  </el-row>
</template>

<script>
  /**
   * 毫末科技的面板组件.
   *
   *   demo地址: factory.haomo-studio.com/vue-element/#/haomo/components/panel
   * @author 高天阳 gty@haomo-studio.com
   */
  export default {
    name: 'HmPanel',
    // 继承其他组件
    extends: {},
    // 使用其它组件
    components: {},
    props: {
      /**
       * 在面板页传入面板对象
       * 完整示例为：{ panel_class: '面板类名', title_class: '标题类名', content_class: '内容类名', panel_style: '面板样式',
       * panel_span: '面板宽度比例', content_height: '内容高度', canCollapse: '是否可收起'}
       */
      options: {
        type: Object,
        required: true
      }
    },
    data() {
      return {
        collapse: true
      }
    },
    computed: {
    },
    filters: {
    },
    created() {
    },
    methods: {
      toggle() {
        if (this.options.canCollapse) {
          this.collapse = !this.collapse
          console.log('收起展开')
        } else {
          console.log('不可收起')
        }
      }
    }
  }
</script>
<style scoped>
  .weight{
    font-weight: 700;
  }
  .center{
    text-align: center;
  }
  .pointer{
    cursor:pointer;
  }
</style>
