<div class='m-40-0 p20 app base-box-shadow bg-white'>
  <div class='flex jc-btween mb-20'>
    <el-button type="primary" @click='showDialog("create")'>Create User</el-button>
    <el-input
      class='form-search'
      placeholder="Group Name"
      prefix-icon="el-icon-search"
      v-model="index.search">
    </el-input>
  </div>
  <table class='table table-bordered'>
    <thead>
      <th>Email</th>
      <th>User Name</th>
      <th>Comment</th>
      <th>Operation</th>
    </thead>
    <tbody is='transition-group' name='list'>
      <tr v-for='(item, index) in handleList' :key='item'>
        <td>111</td>
        <td>222</td>
        <td>333</td>
        <td>
          <div class='flex jc-around'>
            <span class='icon el-icon-edit-outline' @click='showDialog("edit")'></span>
            <a class='sidebar-icon'>
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
  title="权限控制"
  :visible.sync="dialogVisible">
    <div class='flex column'>
      <el-form ref="ruleForm" :model="ruleForm" :rules="rules" label-position="right" label-width="150px">
        <el-form-item label="Email" prop='email'>
          <el-input auto-complete="off" v-model.trim="ruleForm.email" class='inputobj'></el-input>
        </el-form-item>
        <el-form-item label="User Name" prop='name'>
          <el-input v-model.trim="ruleForm.name" class='inputobj'></el-input>
        </el-form-item>
        <input class='dn' type="password"/>
        <el-form-item label="Password" prop='pass'>
          <el-input type='password' auto-complete="off" v-model="ruleForm.pass" class='inputobj'></el-input>
        </el-form-item>
        <el-form-item label="Check Password" prop='checkPass'>
          <el-input type='password' auto-complete="off" v-model="ruleForm.checkPass" class='inputobj'></el-input>
        </el-form-item>
        <el-form-item label="Role" prop='role'>
          <el-select v-model="ruleForm.role" class='inputobj' placeholder="请选择">
            <el-option
              v-for="item in ruleForm.roleOptions"
              :key="item.value"
              :label="item.label"
              :value="item.value">
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="Comment" prop='comment'>
          <el-input type="textarea" autosize v-model="ruleForm.comment" class='inputobj'></el-input>
        </el-form-item>
        <div class='flex jcsb'>
          <el-button @click="dialogVisible = false" @click="resetForm('ruleForm')">Cancel</el-button>
          <el-button type="primary" @click="updateForm('ruleForm', dialogBus.type)">Submit</el-button>
        </div>
      </el-form>
    </div>
  </el-dialog>
</div>
<script>
  new Vue({
    el: '.app',
    data () {
      var vm = this
      // 验证email
      var validateEmail = function (rule, value, callback) {
        vm.judeEmail(value, function (type, info) {
          if (type) {
            callback()
          } else {
            callback(new Error(info))
          }
        })
      }
      // 密码
      var validatePass = function (rule, value, callback) {
        if (value === '') {
          callback(new Error('请输入密码'))
        } else {
          if (value.length < 8) {
            callback(new Error('密码长度不得小于八位'))
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
          callback(new Error('请再次输入密码'))
        } else if (value !== vm.ruleForm.pass) {
          callback(new Error('两次输入密码不一致!'))
        } else {
          callback()
        }
      }
      return {
        dialogBus: {
          type: null
        },
        dialogVisible: false,
        csrf: null,
        index: {
          list: ["1"],
          search: ''
        },
        ruleForm: {
          email: '',
          name: '',
          pass: '',
          checkPass: '',
          role: '',
          roleOptions: [],
          comment: ''
        },
        rules: {
          email: [
            { required: true, message: '请输入邮箱地址', trigger: 'blur' },
            { type: 'email', message: '请输入正确的邮箱地址', trigger: ['blur', 'change'] },
            { required: true, validator: validateEmail, trigger: 'blur' }
          ],
          name: [
            { required: true, message: '请输入用户名', trigger: 'blur' }
          ],
          pass: [
            { required: true, validator: validatePass, trigger: 'blur' }
          ],
          checkPass: [
            { required: true, validator: validatePass2, trigger: 'blur' }
          ],
          role: [
            { required: true, message: 'role必填', trigger: 'blur' }
          ]
        }
      }
    },
    mounted () {
      var vm = this
      this.csrf = document.querySelector('#spp_security').value
      this.getRole()
    },
    computed: {
      handleList () {
        var vm = this
        return  this.index.list.filter(function (ele) {
          return ele.toLowerCase().indexOf(vm.index.search.toLowerCase()) !== -1
        })
      }
    },
    methods: {
      judeEmail (value, callback) {
        var vm = this
        var ajaxData = {
          email: value,
          dsp_security_param: vm.csrf
        }
        $.ajax({
          url: '/user/check-email',
          type: 'post',
          data: ajaxData,
          type: 'post',
          success: function (result) {
            if (result.status !== 1) {
              callback(false, result.info)
            } else {
              callback(true)
            }
          }
        })
      },
      getRole () {
        var vm = this
        $.ajax({
          url: '/user/get-role',
          type: 'get',
          success: function (result) {
            if (result.status === 1) {
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
      showDialog (type) {
        this.dialogVisible = true
        this.dialogBus.type = type
      },
      updateForm (formName, type) {
        var vm = this
        console.log(type)
        this.$refs[formName].validate(function (valid) {
          if (valid) {
            if (type === 'create') {
              // ruleForm: {
              //   email: '',
              //   name: '',
              //   pass: '',
              //   checkPass: '',
              //   role: '',
              //   roleOptions: [],
              //   comment: ''
              // }
              var ajaxData = {
                email: vm.ruleForm.email,
                username: vm.ruleForm.name,
                password: vm.ruleForm.pass,
                check_password: vm.ruleForm.checkPass,
                group_id: vm.ruleForm.role,
                comment: vm.ruleForm.comment
              }
              console.log(ajaxData)
              $.ajax({
                url: 'user/create',
                type: 'post',
                data: ajaxData,
                success: function (result) {
                  console.log(result)
                }
              })
            }
            if (type === 'edit') {

            }
          } else {
            console.log('error submit!!')
            return false;
          }
        });
      }
    },
    watch: {
      dialogVisible (newval) {
        if (newval = true) {
          this.resetForm('ruleForm')
        }
      }
    }
  })
</script>