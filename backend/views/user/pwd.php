<div class='app'>
  <div class='breadcrumbDocker w100 flex flex-row-flex-start-center'>
    <el-breadcrumb separator-class="el-icon-arrow-right">
      <el-breadcrumb-item>Account Management</el-breadcrumb-item>
    </el-breadcrumb>
  </div>
  <div class='content mt-30'>
    <div class='contentBox flex column'>
      <el-form :model="ruleForm" status-icon :rules="rules" ref="ruleForm" label-width="240px" label-position="right" class="demo-ruleForm">
        <el-form-item label="旧密码" prop="oldPass">
          <el-input class='form-one' type="password" v-model="ruleForm.oldPass" autocomplete="off"></el-input>
        </el-form-item>
        <el-form-item label="新密码" prop="newPass">
          <el-input class='form-one' type="password" v-model="ruleForm.newPass" autocomplete="off"></el-input>
        </el-form-item>
        <el-form-item label="确认密码" prop="checkNewPass">
          <el-input class='form-one' type="password" v-model="ruleForm.checkNewPass" autocomplete="off"></el-input>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="submitForm('ruleForm')">Save</el-button>
        </el-form-item>
      </el-form>
    </div>
  </div>
</div>
<script>
  new Vue({
    el: '.app',
    data () {
      var vm = this
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
            if (vm.ruleForm.checkNewPass !== '') {
              vm.$refs.ruleForm.validateField('checkNewPass')
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
        } else if (value !== vm.ruleForm.newPass) {
          // callback(new Error('两次输入密码不一致!'))
          callback(new Error('Your passwords did not match.'))
        } else {
          callback()
        }
      }
      return {
        ruleForm: {
          oldPass: '',
          newPass: '',
          checkNewPass: '',
        },
        rules: {
          oldPass: [
            { required: true, message: "This can't be empty", trigger: 'blur' }
          ],
          newPass: [
            { required: true, validator: validatePass, trigger: 'blur' }
          ],
          checkNewPass: [
            { required: true, validator: validatePass2, trigger: 'blur' }
          ]
        }
      }
    },
    methods: {
      submitForm (formName) {
        this.$refs[formName].validate(function (valid) {
          if (valid) {
            if (valid) {
              console.log('submit!')
            } else {
              console.log('error submit!!')
              return false
            }
          }
        })
      }
    }
  })
</script>