<h2>NEW USER</h2>
<div class='base-box-shadow bg-white flex column createUser p-20-0'>
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
          v-for="item in options"
          :key="item.value"
          :label="item.label"
          :value="item.value">
        </el-option>
      </el-select>
    </el-form-item>
    <el-form-item label="Comment" prop='comment'>
      <el-input v-model="ruleForm.comment" class='inputobj'></el-input>
    </el-form-item>
    <div class='flex jcsb'>
      <el-button>Cancel</el-button>
      <el-button type="primary">Submit</el-button>
    </div>
  </el-form>
</div>
<script>
  new Vue({
    el: '.createUser',
    data () {
      // 密码
      var validatePass = (rule, value, callback) => {
        if (value === '') {
          callback(new Error('请输入密码'))
        } else {
          if (this.ruleForm.checkPass !== '') {
            this.$refs.ruleForm.validateField('checkPass')
          }
          callback()
        }
      }
      var validatePass2 = (rule, value, callback) => {
        if (value === '') {
          callback(new Error('请再次输入密码'))
        } else if (value !== this.ruleForm.pass) {
          callback(new Error('两次输入密码不一致!'))
        } else {
          callback()
        }
      }
      return {
        options: [],
        ruleForm: {
          email: '',
          name: '',
          pass: '',
          checkPass: '',
          role: '',
          comment: ''
        },
        rules: {
          email: [
            { required: true, message: '请输入邮箱地址', trigger: 'blur' },
            { type: 'email', message: '请输入正确的邮箱地址', trigger: ['blur', 'change'] }
          ],
          name: [
            { required: true, message: '请输入用户名', trigger: 'blur' }
          ],
          pass: [
            { required: true, validator: validatePass, trigger: 'blur' }
          ],
          checkPass: [
            { required: true, validator: validatePass2, trigger: 'blur' }
          ]
        }
      }
    },
    methods: {}
  })
</script>