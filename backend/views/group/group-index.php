<div class='m-40-0 p20 app base-box-shadow bg-white'>
  <div class='flex jcsb mb-20'>
    <el-button type="primary" @click='showDialog("create")'>Create Group</el-button>
    <el-input
      class='form-search'
      placeholder="Group Name"
      prefix-icon="el-icon-search"
      v-model="form.search">
    </el-input>
  </div>
  <table class='table table-bordered'>
    <thead>
      <th>Group ID</th>
      <th>Group Name</th>
      <th>Operation</th>
    </thead>
    <tbody is='transition-group' name='list'>
      <tr v-for='(item, index) in handleList' :key='item.id'>
        <td v-text='item.id'></td>
        <td v-text='item.group_name'></td>
        <td>
          <div class='flex jc-around'>
            <el-button type="primary" icon="el-icon-setting" @click='showDialog("edit", item)' circle></el-button>
            <el-switch
              v-model="item.status">
            </el-switch>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
  <!-- dialog -->
  <el-dialog
  title="权限控制"
  :visible.sync="dialogVisible">
    <div class='flex column'>
      <template v-if='dialogType === "create"'>
        <el-input class='transfer-input mb-20' v-model="create.name" placeholder="Group Name"></el-input>
        <el-select class='transfer-input mb-20' v-model="create.available" placeholder="请选择">
          <el-option
            v-for="item in create.options"
            :key="item.value"
            :label="item.label"
            :value="item.value">
          </el-option>
        </el-select>
      </template>
      <div class='flex'>
        <el-transfer
          filterable
          :filter-method="filterMethod"
          filter-placeholder="请输入权限名称"
          v-model="dialogData.choiceList"
          :data="dialogData.list">
        </el-transfer>
      </div>
    </div>
    <span slot="footer" class="dialog-footer">
      <el-button @click="dialogVisible = false">取 消</el-button>
      <el-button type="primary" @click="updateForm">提 交</el-button>
    </span>
  </el-dialog>
</div>
<script>
  new Vue({
    el: '.app',
    data: {
      create: {
        name: '',
        available: '',
        options: [
          {
            label: '123',
            value: 1
          }
        ]
      },
      dialogType: null,
      dialogVisible: false,
      dialogData: {
        list: [{
          label: 'qwe',
          key: 1

        }],
        choiceList: []
      },
      form: {
        search: '',
        list: []
      }
    },
    mounted () {
      var that = this
      var csrf = document.querySelector('#spp_security').value
      $.ajax({
        url: '/admin/group/index',
        type: 'post',
        data: {
          dsp_security_param: csrf
        },
        success: function (result) {
          console.log(result)
          that.form.list = result
        }
      })
    },
    computed: {
      handleList () {
        var vm = this
        return  this.form.list.filter(function (ele) {
          return ele.group_name.toLowerCase().indexOf(vm.form.search.toLowerCase()) !== -1
        })
      }
    },
    methods: {
      showDialog (type, item) {
        this.dialogVisible = true
        this.dialogType = type
      },
      filterMethod (query, item) {
        return item.label.indexOf(query) > -1;
      },
      updateForm () {
        if (this.dialogType === 'create') {
          if (this.create.name && this.create.available) {
            this.dialogVisible = false
            this.$message({
              message: 'create success',
              type: 'success'
            })
          } else {
            this.$message.error('create error')
          }
        }
        if (this.dialogType === 'edit') {
          this.dialogVisible = false
        }
      }
    }
  })
</script>