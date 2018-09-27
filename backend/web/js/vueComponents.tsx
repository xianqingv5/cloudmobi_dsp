// vue插件系统
Vue.component('big-datepicker', {
  props: ['propsList'],
  data() {
    return {
      list: [],
      num: null
    };
  },
  beforeCreate() {
    console.log('beforeCreate')
  },
  created() {
    console.log('created')
  },
  beforeMount() {
    console.log('beforeMount')
  },
  mounted() {
    console.log('mounted')
    this.num = 2;
    this.num = 3;
    this.num = 4;
    setTimeout(() => {
      this.num = 5
    });
  },
  beforeUpdate() {
    console.log('beforeUpdate')
  },
  updated() {
    console.log('updated')
  },
  beforeDestroy() {
    console.log('beforeDestroy')
  },
  destroyed() {
    console.log('destroyed')
  },
  render(h, context) {
    return h('div',
      {
        class: {
          aa: true
        }
      },
      Array.apply(null, { length: 8 }).map(function (ele, i) {
        return h('div', {
          class: {
            bb: true
          }
        },Array.apply(null, { length: 25 }).map(function (ele1, j) {
            return h('div', {
              class: {
                cc: true
              }
            }, j)
        }))
      })
    )
  }
})
