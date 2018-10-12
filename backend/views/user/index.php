<div class='app'>
  <div class='breadcrumbDocker w100 flex flex-row-flex-start-center'>
    <el-breadcrumb separator-class="el-icon-arrow-right">
      <el-breadcrumb-item>Account Management</el-breadcrumb-item>
    </el-breadcrumb>
  </div>
  <div class='flex jc-end p30'>
    <el-button type="primary" @click='showDialog("create")'>Create User</el-button>
  </div>
  <div class='content'>
    <div class='contentBox'>
      <div class='flex jc-end mb-20'>
        <el-select filterable
          v-if='power.search_role.show'
          @change='searchFun'
          class='form-search mr-20'
          v-model="search.role" clearable placeholder="Role">
          <el-option
            v-for="item in ruleForm.roleOptions"
            :key="item.value"
            :label="item.label"
            :value="item.value">
          </el-option>
        </el-select>
        <el-input
          @change='searchFun'
          class='form-search'
          placeholder="Email / User Name"
          prefix-icon="el-icon-search"
          v-model="search.name">
        </el-input>
      </div>
      <table class='table table-bordered'>
        <thead>
          <th>Email</th>
          <th>User Name</th>
          <th>Comment</th>
          <th>Short Name</th>
          <th>Status</th>
          <th>Operation</th>
        </thead>
        <tbody is='transition-group' name='list'>
          <tr v-for='(item, index) in handleList' :key='item.id'>
            <td v-text='item.email'></td>
            <td v-text='item.username'></td>
            <td v-text='item.comment'></td>
            <td v-text='item.short_name'></td>
            <td>
              <el-switch
                v-model="item.status"
                active-value="1"
                inactive-value="2"
                @change='updateStatus($event, item)'
                >
              </el-switch>
            </td>
            <td>
              <div class='flex jc-start'>
                <span class='m-0-20' @click='resetPass(item)'>
                  <svg class="icon" aria-hidden="true">
                    <use xlink:href="#icon-zhongzhimima"></use>
                  </svg>
                </span>
                <span class='icon el-icon-edit-outline m-0-20' @click='showDialog("edit", item)'></span>
                <a v-if='item.group_id === "3"' class='m-0-20' :href='"/offer-report/offer-report-index?campaigns_owner=" + item.id'>
                  <svg class="icon" aria-hidden="true">
                    <use xlink:href="#icon-chakanbaobiao"></use>
                  </svg>
                </a>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
      <!-- dialog -->
      <el-dialog
      :close-on-click-modal='false'
      :title='dialogBus.title'
      :visible.sync="dialogVisible">
        <div class='flex column'>
          <el-form ref="ruleForm" :model="ruleForm" :rules="rules" label-position="right" label-width="200px">
            <el-form-item label="Account Short Name" prop='account'>
              <el-input :disabled='dialogBus.type === "edit"' auto-complete="off" v-model.trim="ruleForm.account" class='inputobj'></el-input>
            </el-form-item>
            <el-form-item label="Email" prop='email'>
              <el-input :disabled='dialogBus.type === "edit"' auto-complete="off" v-model.trim="ruleForm.email" class='inputobj'></el-input>
            </el-form-item>
            <el-form-item label="User Name" prop='name'>
              <el-input v-model.trim="ruleForm.name" class='inputobj'></el-input>
            </el-form-item>
            <input class='dn' type="password"/>
            <el-form-item v-if='dialogBus.type !== "edit"' label="Password" prop='pass'>
              <el-input type='password' auto-complete="off" v-model="ruleForm.pass" class='inputobj'></el-input>
            </el-form-item>
            <el-form-item v-if='dialogBus.type !== "edit"' label="Check Password" prop='checkPass'>
              <el-input type='password' auto-complete="off" v-model="ruleForm.checkPass" class='inputobj'></el-input>
            </el-form-item>
            <el-form-item label="Role" prop='role'>
              <el-select :disabled='dialogBus.type === "edit"' v-model="ruleForm.role" class='inputobj' placeholder="Choice">
                <el-option
                  v-for="item in ruleForm.roleOptions"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value">
                </el-option>
              </el-select>
            </el-form-item>
            <el-form-item label="Comment" prop='comment'>
              <el-input type="textarea" autosize v-model.trim="ruleForm.comment" class='inputobj'></el-input>
            </el-form-item>
            <div class='flex jc-end'>
              <el-button type="primary" @click="updateForm('ruleForm', dialogBus.type)">Submit</el-button>
            </div>
          </el-form>
        </div>
      </el-dialog>
      <!-- edit pass dialog -->
      <el-dialog
      :close-on-click-modal='false'
      title='重置密码'
      :visible.sync="editPassDialogVisible">
        <div class='flex column'>
          <el-form ref="ruleForm2" :model="ruleForm2" :rules="rules2" label-position="right" label-width="50px">
            <el-form-item label="Pass" prop='pass'>
              <el-input disabled auto-complete="off" v-model.trim="ruleForm2.pass" class='inputobj'></el-input>
            </el-form-item>
            <div class='flex jc-end'>
              <el-button type="primary" @click="updateForm2('ruleForm2')">Submit</el-button>
            </div>
          </el-form>
        </div>
      </el-dialog>
    </div>
  </div>
</div>
<script>
var power = JSON.parse('<?= $this->params['view_group'] ?>')
console.log(power)
  new Vue({
    el: '.app',
    data () {
      var vm = this
      // 验证email
      // 中文正则
      var reg = new RegExp('[\u4e00-\u9fa5]')
      var validateEmail = function (rule, value, callback) {
        if (value.indexOf(' ') !== -1) {
          // callback(new Error('不得输入空格'))
          callback(new Error('Please enter a valid email address.'))
        } else if (reg.test(value)) {
          // callback(new Error('不得输入中文'))
          callback(new Error('Please enter a valid email address.'))
        } else {
          vm.judeEmail(value, function (type, info) {
            if (type) {
              callback()
            } else {
              callback(new Error(info))
            }
          })
        }
      }
      // 密码
      var validatePass = function (rule, value, callback) {
        if (value === '') {
          // callback(new Error("密码不能为空"))
          callback(new Error("Password can't be empty."))
        } else if (value.indexOf(' ') !== -1) {
          // callback(new Error('不得输入空格'))
          callback(new Error("please don't enter space."))
        } else {
          if (value.length < 8) {
            // callback(new Error('密码长度不得小于八位'))
            callback(new Error('Passwords must be at least 8 characters.'))
          } else {
            if (vm.ruleForm.checkPass !== '') {
              vm.$refs.ruleForm.validateField('checkPass')
            }
            callback()
          }
        }
      }
      // 再次输入密码
      var validatePass2 = function (rule, value, callback) {
        if (value === '') {
          // callback(new Error('请再次输入密码'))
          callback(new Error('Please enter the password again.'))
        } else if (value.indexOf(' ') !== -1) {
          // callback(new Error('不得输入空格'))
          callback(new Error("please don't enter space."))
        } else if (value !== vm.ruleForm.pass) {
          // callback(new Error('两次输入密码不一致!'))
          callback(new Error('Your passwords did not match.'))
        } else {
          callback()
        }
      }
      // 验证简写
      var validateAccount = function (rule, value, callback) {
        var reg = new RegExp('^[a-zA-Z0-9]{3}$')
        if (reg.test(value)) {
          // ajax验证是否重复
          vm.judeAccount(value, function (type, info) {
            if (type) {
              callback()
            } else {
              callback(new Error(info))
            }
          })
        } else {
          callback(new Error('Use 3 characters with a mix of letters & numbers.'))
        }
      }
      return {
        power: power,
        dialogBus: {
          title: null,
          type: null,
          json: {}
        },
        dialogVisible: false,
        editPassDialogVisible: false,
        editPassDialogBus: {
          json: {}
        },
        csrf: null,
        search: {
          name: '',
          role: ''
        },
        index: {
          list: []
        },
        ruleForm2: {
          pass: ''
        },
        rules2: {
          pass: [
            { required: true, validator: validatePass, trigger: 'blur' }
          ],
        },
        ruleForm: {
          account: '',
          email: '',
          name: '',
          pass: '',
          checkPass: '',
          role: '',
          roleOptions: [],
          comment: ''
        },
        rules: {
          account: [
            { required: true, message: "This can't be empty", trigger: 'blur' },
            { required: true, validator: validateAccount, trigger: ['blur', 'change'] }
          ],
          email: [
            { required: true, message: "This can't be empty", trigger: 'blur' },
            { type: 'email', message: 'Please enter a valid email address', trigger: ['blur', 'change'] },
            { required: true, validator: validateEmail, trigger: ['blur', 'change'] }
          ],
          name: [
            { required: true, message: "User Name can't be empty.", trigger: 'blur' }

          ],
          pass: [
            { required: true, validator: validatePass, trigger: 'blur' }
          ],
          checkPass: [
            { required: true, validator: validatePass2, trigger: 'blur' }
          ],
          role: [
            { required: true, message: "Role can't be empty.", trigger: 'blur' }
          ]
        }
      }
    },
    created () {
      this.getRole()
    },
    mounted () {
      var vm = this
      this.csrf = document.querySelector('#spp_security').value
      this.getList()
    },
    computed: {
      handleList () {
        var vm = this
        return  this.index.list.filter(function (ele) {
          var str = ele.email + ele.username
          if (vm.search.role) {
            if (vm.search.role === ele.group_id) {
              return str.toLowerCase().indexOf(vm.search.name.toLowerCase()) !== -1
            }
          } else {
            return str.toLowerCase().indexOf(vm.search.name.toLowerCase()) !== -1
          }
        })
      }
    },
    methods: {
      searchFun () {
        console.log('search')
      },
      // 验证简称
      judeAccount (value, callback) {
        var vm = this
        return callback(true)
        if (this.dialogBus.type === 'create') {
          var ajaxData = {
            email: value,
            dsp_security_param: vm.csrf
          }
          $.ajax({
            url: '/user/check-email',
            type: 'post',
            data: ajaxData,
            success: function (result) {
              if (result.status !== 1) {
                callback(false, result.info)
              } else {
                callback(true)
              }
            }
          })
        } else {
          callback(true)
        }
      },
      // 重置密码
      resetPass (item) {
        var that = this
        // console.log('重置密码')
        this.editPassDialogVisible = true
        this.editPassDialogBus.json = item
        // ajax
        $.ajax({
          url: '/user/get-code',
          type: 'get',
          success: function (result) {
            if (result.status === 1) {
              that.ruleForm2.pass = result.data.code
            }
          }
        })

      },
      updateStatus (e, item) {
        var vm = this
        var ajaxData = {
          id: item.id,
          status: e,
          dsp_security_param: vm.csrf
        }
        $.ajax({
          url: '/user/update-user-status',
          type: 'post',
          data: ajaxData,
          success: function (result) {
            if (result.status === 1) {
              vm.$message({
                message: result.info,
                type: 'success'
              })
            } else {
              vm.$message.error(result.info)
            }
          }
        })
      },
      getList () {
        var vm = this
        var ajaxData = {
          dsp_security_param: vm.csrf
        }
        $.ajax({
          url: '/user/user-index',
          type: 'post',
          data: ajaxData,
          success: function (result) {
            vm.index.list = result
          }
        })
      },
      judeEmail (value, callback) {
        var vm = this
        if (this.dialogBus.type === 'create') {
          var ajaxData = {
            email: value,
            dsp_security_param: vm.csrf
          }
          $.ajax({
            url: '/user/check-email',
            type: 'post',
            data: ajaxData,
            success: function (result) {
              if (result.status !== 1) {
                callback(false, result.info)
              } else {
                callback(true)
              }
            }
          })
        } else {
          callback(true)
        }
      },
      getRole () {
        var vm = this
        $.ajax({
          url: '/user/get-role',
          type: 'get',
          success: function (result) {
            if (result.status === 1) {
              vm.ruleForm.roleOptionsBase = result.data
              result.data.map(function (ele) {
                vm.ruleForm.roleOptions.push({
                  label: ele.group_name,
                  value: ele.id
                })
              })
              if (result.data.length === 1) {
                vm.ruleForm.role = result.data[0].id
              }
            }
          }
        })
      },
      resetForm(formName) {
        if (this.$refs[formName] !== undefined) {
          this.$refs[formName].resetFields()
        }
      },
      clearValidate (formName) {
        if (this.$refs[formName] !== undefined) {
          this.$refs[formName].clearValidate()
        }
      },
      showDialog (type,  item) {
        this.dialogVisible = true
        this.dialogBus.type = type
        if (type === 'create') {
          this.dialogBus.title = 'Create User'
          this.dialogBus.json = {}
          this.ruleForm.email = ''
          this.ruleForm.name = ''
          this.ruleForm.pass = ''
          this.ruleForm.checkPass = ''
          this.ruleForm.role = ''
          this.ruleForm.comment = ''
        }
        if (type === 'edit') {
          this.dialogBus.title = 'Edit User'
          this.dialogBus.json = item
          this.ruleForm.account = this.dialogBus.json.short_name
          this.ruleForm.email = this.dialogBus.json.email
          this.ruleForm.name = this.dialogBus.json.username
          this.ruleForm.pass = this.dialogBus.json.password
          this.ruleForm.checkPass = this.dialogBus.json.password
          this.ruleForm.role = this.dialogBus.json.group_id
          this.ruleForm.comment = this.dialogBus.json.comment
        }
      },
      updateForm2 (formName) {
        var that = this
        this.$refs[formName].validate(function (valid) {
          if (valid) {
            console.log('updateForm2 submit success')
            // ajax
            var ajaxData = {
              dsp_security_param: that.csrf,
              id: that.editPassDialogBus.json.id,
              new_pwd: that.ruleForm2.pass
            }
            $.ajax({
              url: '/user/update-user-pwd',
              type: 'post',
              data: ajaxData,
              success: function (result) {
                if (result.status === 1) {
                  that.editPassDialogVisible = false
                  that.$message({
                    message: result.info,
                    type: 'success'
                  })
                } else {
                  that.$message.error(result.info)
                }
              }
            })
          } else {
            console.log('updateForm2 submit error')
          }
        })
      },
      updateForm (formName, type) {
        var vm = this
        console.log(type)
        this.$refs[formName].validate(function (valid) {
          if (valid) {
            if (type === 'create') {
              var ajaxData = {
                short_name: vm.ruleForm.account,
                email: vm.ruleForm.email,
                username: vm.ruleForm.name,
                password: vm.ruleForm.pass,
                check_password: vm.ruleForm.checkPass,
                group_id: vm.ruleForm.role,
                comment: vm.ruleForm.comment,
                dsp_security_param: vm.csrf
              }
              $.ajax({
                url: '/user/create',
                type: 'post',
                data: ajaxData,
                success: function (result) {
                  if (result.status === 1) {
                    vm.dialogVisible = false
                    vm.getList()
                    vm.$message({
                      message: 'success',
                      type: 'success'
                    })
                  } else {
                    vm.$message.error(result.info)
                  }
                }
              })
            }
            if (type === 'edit') {
              var ajaxData = {
                username: vm.ruleForm.name,
                comment: vm.ruleForm.comment,
                id: vm.dialogBus.json.id,
                dsp_security_param: vm.csrf
              }
              $.ajax({
                url: '/user/update',
                type: 'post',
                data: ajaxData,
                success: function (result) {
                  if (result.status === 1) {
                    vm.dialogVisible = false
                    vm.getList()
                    vm.$message({
                      message: 'success',
                      type: 'success'
                    })
                  } else {
                    vm.$message.error(result.info)
                  }
                }
              })
            }
          } else {
            console.log('error submit!!')
            return false;
          }
        });
      }
    },
    watch: {
      dialogVisible () {
        this.clearValidate('ruleForm')
      }
    }
  })
</script>