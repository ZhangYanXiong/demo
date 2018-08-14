/**
 * @desc styleguide配置文件
 * @author hm20160509
 * @date 2018/2/8
 */

const path = require('path')
const utils = require('./build/utils')
// const baseWebpackConfig = require('./build/webpack.base.conf')

function resolve(dir) {
  return path.join(__dirname, dir)
}

const sections = [
  {
    name: '概述',
    sections: [
      {
        name: '开发新组件',
        content: './docs/styleguide/develop.md'
      }
    ]
  },
  {
    name: '组件',
    components: function() {
      return [
        './src/views/haomo/components/tables/HmComplexTable.vue',
        './src/views/haomo/components/forms/HmComplexForm.vue',
        './src/views/haomo/components/details/HmComplexDetail.vue',
        './src/views/haomo/components/panel/HmPanel.vue'
      ]
    }
  },
  {
    name: '页面',
    sections: [
      {
        name: '登录'
      },
      {
        name: '重置密码'
      },
      {
        name: '忘记密码'
      }
    ]
  }
]

module.exports = {
  styleguideDir: './dist-styleguide',
  components: 'src/views/haomo/components/**/[A-Z]*.vue',
  ignore: [
    '**/index.vue'
  ],
  showUsage: true,
  defaultExample: true,
  showCode: true,
  sections: sections,
  assetsDir: resolve('src/assets/'),
  require: [
    resolve('./src/main.js')
  ],
  webpackConfig: Object.assign({
    resolve: {
      extensions: ['.js', '.vue', '.json'],
      alias: {
        'vue$': 'vue/dist/vue.esm.js',
        '@': resolve('src')
      }
    },
    module: {
      rules: [
        {
          test: /\.vue$/,
          loader: 'vue-loader'
        },
        {
          test: /\.js$/,
          loader: 'babel-loader?cacheDirectory',
          include: [resolve('src'), resolve('test'), resolve('node_modules/webpack-dev-server/client')]
        },
        {
          test: /\.svg$/,
          loader: 'svg-sprite-loader',
          include: [resolve('src/icons')],
          options: {
            symbolId: 'icon-[name]'
          }
        },
        {
          test: /\.(png|jpe?g|gif|svg)(\?.*)?$/,
          loader: 'url-loader',
          exclude: [resolve('src/icons')],
          options: {
            limit: 10000,
            name: utils.assetsPath('img/[name].[hash:7].[ext]')
          }
        },
        {
          test: /\.(mp4|webm|ogg|mp3|wav|flac|aac)(\?.*)?$/,
          loader: 'url-loader',
          options: {
            limit: 10000,
            name: utils.assetsPath('media/[name].[hash:7].[ext]')
          }
        },
        {
          test: /\.css$/,
          use: ['style-loader', 'css-loader', 'sass-loader']
        },
        {
          test: /\.scss$/,
          use: ['style-loader', 'css-loader', 'sass-loader']
        },
        {
          test: /\.(woff2?|eot|ttf|otf)(\?.*)?$/,
          loader: 'url-loader',
          options: {
            limit: 10000,
            name: utils.assetsPath('fonts/[name].[hash:7].[ext]')
          }
        }
      ]
    }
  })
}
