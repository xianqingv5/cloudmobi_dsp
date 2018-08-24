<h2>NEW USER</h2>
<div class='base-box-shadow bg-white flex column createUser p-20-0'>
  <el-form ref="ruleForm" :model="ruleForm" :rules="rules" label-position="right" label-width="150px">
    <el-form-item label="Email" prop='email'>
      <el-input v-model.trim="ruleForm.email" class='inputobj'></el-input>
    </el-form-item>
    <el-form-item label="User Name" prop='name'>
      <el-input v-model.trim="ruleForm.name" class='inputobj'></el-input>
    </el-form-item>
    <el-form-item label="Password" prop='password'>
      <el-input v-model="ruleForm.password" class='inputobj'></el-input>
    </el-form-item>
    <el-form-item label="Check Password" prop='checkPass'>
      <el-input v-model="ruleForm.checkPass" class='inputobj'></el-input>
    </el-form-item>
    <el-form-item label="Role" prop='role'>
      <el-input v-model="ruleForm.role" class='inputobj'></el-input>
    </el-form-item>
    <el-form-item label="Comment" prop='comment'>
      <el-input v-model="ruleForm.comment" class='inputobj'></el-input>
    </el-form-item>
  </el-form>
</div>
<script>
  new Vue({
    el: '.createUser',
    data: {
      ruleForm: {
        email: '',
        name: '',
        password: '',
        checkPass: '',
        role: '',
        comment: ''
      },
      rules: {
        email: [
          { required: true, message: '请输入邮箱地址', trigger: 'blur' },
          { type: 'email', message: '请输入正确的邮箱地址', trigger: ['blur', 'change'] }
        ]
      }
    }
  })
</script>