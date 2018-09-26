// vue插件系统
Vue.component("big-datepicker", {
    props: ["propsList"],
    data: function () {
        return {
            list: [],
            num: null
        };
    },
    beforeCreate: function () {
        console.log("beforeCreate");
    },
    created: function () {
        console.log("created");
    },
    beforeMount: function () {
        console.log("beforeMount");
    },
    mounted: function () {
        var _this = this;
        console.log("mounted");
        this.num = 2;
        this.num = 3;
        this.num = 4;
        setTimeout(function () {
            _this.num = 5;
        });
    },
    beforeUpdate: function () {
        console.log("beforeUpdate");
    },
    updated: function () {
        console.log("updated");
    },
    beforeDestroy: function () {
        console.log("beforeDestroy");
    },
    destroyed: function () {
        console.log("destroyed");
    },
    render: function (h, context) {
        return h('div', {
            "class": {
                aa: true
            }
        }, Array.apply(null, { length: 8 }).map(function (ele, i) {
            return h('div', {
                "class": {
                    bb: true
                }
            }, Array.apply(null, { length: 25 }).map(function (ele1, j) {
                return h('div', {
                    "class": {
                        cc: true
                    }
                }, j);
            }));
        }));
    }
});
