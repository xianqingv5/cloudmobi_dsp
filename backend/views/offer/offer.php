<div class='app'>
  <div class='breadcrumbDocker w100 flex flex-row-flex-start-center'>
    <el-breadcrumb separator-class="el-icon-arrow-right">
      <el-breadcrumb-item :to="{ path: '/user/user-index' }">User</el-breadcrumb-item>
      <el-breadcrumb-item>Index</el-breadcrumb-item>
    </el-breadcrumb>
  </div>
  <div class='flex jcsb p30'>
    <h3>New Campaign</h3>
    <div>
      <el-button  @click='resetForm("ruleForm")'>Reset</el-button>
      <el-button type="primary" @click='submitForm("ruleForm")'>Save</el-button>
    </div>
  </div>
  <div class='content'>
    <div class='contentBox'>
      <el-form enctype="multipart/form-data" ref='ruleForm' :rules='rules' :model='ruleForm' label-width="240px" label-position="right">
        <!-- 1 -->
        <div class='content-li'>
          <div class='flex jc-start content-li-title'>
            <div class='num-circle'>1</div>
            <h5>Campaign Basic Info</h5>
          </div>
          <div class='content-con flex column'>
            <el-form-item label="Campaign Owner" prop="campaignOwner">
              <el-select class='form-one'
                v-model="ruleForm.campaignOwner" clearable placeholder="">
                <el-option
                  v-for="item in options.campaignOwner"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value">
                </el-option>
              </el-select>
            </el-form-item>
            <el-form-item label="Advertiser" prop="advertiser">
              <el-select class='form-one'
                v-model="ruleForm.advertiser" clearable placeholder="">
                <el-option
                  v-for="item in options.advertiser"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value">
                </el-option>
              </el-select>
            </el-form-item>
            <el-form-item label="Attribute Provider" prop="attributeProvider">
              <el-select class='form-one'
                v-model="ruleForm.attributeProvider" clearable placeholder="">
                <el-option
                  v-for="item in options.attributeProvider"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value">
                </el-option>
              </el-select>
            </el-form-item>
          </div>
        </div>
<template v-if='judeOne'>
        <!-- 2 -->
        <div class='content-li'>
          <div class='flex jc-start content-li-title'>
            <div class='num-circle'>2</div>
            <h5>Campaign Detail Info</h5>
          </div>
          <div class='content-con flex column'>
            <el-form-item label="App Store or Google Play URL" prop="storeUrl">
              <el-input class='form-one' v-model="ruleForm.storeUrl" placeholder=''></el-input>
            </el-form-item>
            <el-form-item label="Campaign Title" prop="title">
              <el-input class='form-one' v-model="ruleForm.title" placeholder=''></el-input>
            </el-form-item>
            <el-form-item label="Campaign Description" prop="desc">
              <el-input class='form-one' v-model="ruleForm.desc" placeholder=''></el-input>
            </el-form-item>
            <el-form-item label="Tracking Link" prop="trackingUrl">
              <el-input class='form-one' v-model="ruleForm.trackingUrl" placeholder=''></el-input>
            </el-form-item>
            <el-form-item label="Schedule" prop="schedule">
              <el-radio-group class='form-one' v-model="ruleForm.schedule">
                <el-radio label="0">OFF</el-radio>
                <el-radio label="1">ON</el-radio>
              </el-radio-group>
            </el-form-item>
            <el-form-item label="Comment" prop="comment">
              <el-input class='form-one' type='textarea' v-model="ruleForm.comment" placeholder=''></el-input>
            </el-form-item>
          </div>
        </div>
        <!-- 3 -->
        <div class='content-li'>
          <div class='flex jc-start content-li-title'>
            <div class='num-circle'>3</div>
            <h5>Budget Info</h5>
          </div>
          <div class='content-con flex column'>
            <el-form-item label="Price($)" prop="priceWay">
              <el-input class='form-one' v-model="ruleForm.priceWay" placeholder=''></el-input>
            </el-form-item>
            <el-form-item label="Daily Cap" prop="dailyCap">
              <el-input class='form-one' v-model.trim="ruleForm.dailyCap" placeholder=''></el-input>
            </el-form-item>
            <el-form-item label="Total Cap" prop="totalCap">
              <el-input class='form-one' v-model.trim="ruleForm.totalCap" placeholder=''></el-input>
            </el-form-item>
          </div>
        </div>
        <!-- 4 -->
        <div class='content-li'>
          <div class='flex jc-start content-li-title'>
            <div class='num-circle'>4</div>
            <h5>Targeting Info</h5>
          </div>
          <div class='content-con flex column'>
            <el-form-item label="Targeting Platform" prop="platform">
              <el-select class='form-one'
                v-model="ruleForm.platform" clearable placeholder="">
                <el-option
                  v-for="item in options.platform"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value">
                </el-option>
              </el-select>
            </el-form-item>
            <el-form-item label="Device Type" prop="deviceType">
              <el-select class='form-one'
                v-model="ruleForm.deviceType" clearable placeholder="">
                <el-option
                  v-for="item in options.deviceType"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value">
                </el-option>
              </el-select>
            </el-form-item>
            <el-form-item label="Specific Device" prop="specificDevice">
              <el-input class='form-one' v-model="ruleForm.specificDevice" placeholder=''></el-input>
            </el-form-item>
            <el-form-item label="Min OS Vsersion" prop="minOSvsersion">
              <el-select class='form-one'
                v-model="ruleForm.minOSvsersion" :disabled='!judePlatform' clearable placeholder="">
                <el-option
                  v-for="item in options.minOSvsersion"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value">
                </el-option>
              </el-select>
            </el-form-item>
            <el-form-item label="Network Status" prop="networkStatus">
              <el-radio-group class='form-one' v-model="ruleForm.networkStatus">
                <el-radio label="1">WIFI & 4G</el-radio>
                <el-radio label="2">WIFI</el-radio>
                <el-radio label="3">4G</el-radio>
              </el-radio-group>
            </el-form-item>
            <el-form-item label="select Country" prop="city">
              <el-select class='form-one' multiple filterable 
                v-model="ruleForm.city" clearable placeholder="">
                <el-option
                  v-for="item in options.city"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value">
                </el-option>
              </el-select>
            </el-form-item>
          </div>
        </div>
        <!-- 5 -->
        <div class='content-li'>
          <div class='flex jc-start content-li-title'>
            <div class='num-circle'>5</div>
            <h5>Creatives</h5>
          </div>
          <div class='content-con flex column'>
            <!-- icon -->
            <el-form-item label="icon" prop="icon" class='imgDocker'>
              <div class='flex'>
                <div class='flex flex-start mr-20'>
                  <el-input class='form-one' v-model="ruleForm.icon" placeholder=''></el-input>
                  <el-button type="primary">Preview</el-button>
                </div>
                <el-button type="primary" @click='uploadFile("icon")'/>upload creatives</el-button>
                <input class='iconfile dn' type="file" name="iconfile">
              </div>
            </el-form-item>
            <div class='flex flex-wrap'>
              <div class='imgBox showImgBox' v-for='(item, index) in ruleForm.iconList'>
                <div class='close icon el-icon-close' @click='deleteFun(item, index, ruleForm.iconList)'></div>
                <div class='showImg flex'>
                  <img src="" alt="" :src='item.url'>
                </div>
                <!-- <div class='showImgTitle' v-text='item'></div> -->
              </div>
            </div>
            <!-- image -->
            <el-form-item label="image" prop="image" class='imgDocker'>
              <div class='flex'>
                <div class='flex flex-start mr-20'>
                  <el-input class='form-one' v-model="ruleForm.image" placeholder=''></el-input>
                  <el-button type="primary">Preview</el-button>
                </div>
                <el-button type="primary" @click='uploadFile("image")'>upload creatives</el-button>
                <input class='imagefile dn' type="file" name="imagefile">
              </div>
            </el-form-item>
            <div class='flex flex-wrap'>
              <div class='imgBox showImgBox' v-for='(item, index) in ruleForm.imageList'>
                <div class='close icon el-icon-close' @click='deleteFun(item, index, ruleForm.imageList)'></div>
                <div class='showImg flex'>
                  <img src="" alt="" :src='item.url'>
                </div>
                <!-- <div class='showImgTitle' v-text='item'></div> -->
              </div>
            </div>
            <!-- video -->
            <el-form-item label="video" prop="video" class='imgDocker'>
              <div class='flex'>
                <div class='flex flex-start mr-20'>
                  <el-input class='form-one' v-model="ruleForm.video" placeholder=''></el-input>
                  <el-button type="primary">Preview</el-button>
                </div>
                <el-button type="primary" @click='uploadFile("video")'>upload creatives</el-button>
                <input class='videofile dn' type="file" name="videofile">
              </div>
            </el-form-item>
            <div class='flex flex-wrap'>
              <div class='imgBox showImgBox' v-for='(item, index) in ruleForm.videoList'>
                <div class='close icon el-icon-close' @click='deleteFun(item, index, ruleForm.videoList)'></div>
                <div class='showImg flex'>
                  <video src="" controls='controls' :src='item.url'></video>
                </div>
                <!-- <div class='showImgTitle' v-text='item'></div> -->
              </div>
            </div>
          </div>
        </div>
</template>
        <div class='flex p30'>
          <el-button  @click='resetForm("ruleForm")'>Reset</el-button>
          <el-button type="primary" @click='submitForm("ruleForm")'>Save</el-button>
        </div>
      </el-form>
    </div>
  </div>
</div>
<script>
  var albumBucketName = 'cloudmobi-resource'
  var bucketRegion = 'ap-southeast-1'
  var IdentityPoolId = 'ap-southeast-1:c0fbf555-2ba8-4dab-8ad2-733d41ef2ae7'
  var s3 = new AWS.S3({
    params: {
      Bucket: albumBucketName
    }
  })
  new Vue({
    el: '.app',
    data () {
      var vm = this
      var validatorDailyCap = function (rule, value, callback) {
        if (value && Number(value).toString() !== value) {
          callback(new Error('必须为数字'))
        } else {
          callback()
        }
      }
      var validatorTotalCap = function (rule, value, callback) {
        if (value) {
          if (Number(value).toString() !== value) {
            callback(new Error('必须为数字'))
          } else if (!vm.judeTotalCap()) {
            callback(new Error('Total Cap >= Daily Cap'))
          } else {
            callback()
          }
        } else {
          callback()
        }
        
      }
      return {
        options: {
          campaignOwner: [],
          advertiser: [],
          attributeProvider: [],
          platform: [],
          deviceType: [],
          minOSvsersion: [],
          city: []
        },
        ruleForm: {
          // 1
          campaignOwner: '',
          advertiser: '',
          attributeProvider: '',
          // 2
          storeUrl: '',
          title: '',
          desc: '',
          trackingUrl: '',
          schedule: '',
          comment: '',
          // 3
          priceWay: '',
          dailyCap: '',
          totalCap: '',
          // 4
          platform: '',
          deviceType: '',
          specificDevice: '',
          minOSvsersion: '',
          networkStatus: '',
          city: [],
          // 5
          icon: '',
          iconList: [],
          image: '',
          imageList: [],
          video: '',
          videoList: []
        },
        rules: {
          // 1
          campaignOwner: [
            { required: true, message: '此项必填', trigger: 'blur' }
          ],
          advertiser: [
            { required: true, message: '此项必填', trigger: 'blur' }
          ],
          attributeProvider: [
            { required: true, message: '此项必填', trigger: 'blur' }
          ],
          // 2
          storeUrl: [
            { required: true, message: '此项必填', trigger: 'blur' }
          ],
          title: [
            { required: true, message: '此项必填', trigger: 'blur' }
          ],
          desc: [
            { required: true, message: '此项必填', trigger: 'blur' }
          ],
          trackingUrl: [
            { required: true, message: '此项必填', trigger: 'blur' }
          ],
          schedule: [
            { required: true, message: '至少选择一项', trigger: 'blur' }
          ],
          // 3
          priceWay: [
            { required: true, message: '此项必填', trigger: 'blur' }
          ],
          dailyCap: [
            { required: false, validator: validatorDailyCap, trigger: 'blur' }
          ],
          totalCap: [
            { required: false, validator: validatorTotalCap, trigger: 'blur' }
          ]
        }
      }
    },
    computed: {
      judeOne () {return true
        if (this.ruleForm.campaignOwner !== '' && this.ruleForm.advertiser !== '' && this.ruleForm.attributeProvider !== '') {
          return true
        }
        return false
      },
      judePlatform () {
        if (this.ruleForm.platform === '') {
          return false
        }
        return true
      }
    },
    mounted () {
      this.$watch('ruleForm.dailyCap', function (newVal, oldVal) {
        // 每次改变都会验证totalCap
        this.$refs['ruleForm'].validateField('totalCap')
      }, {
        deep: true
      })
    },
    methods: {
      judeTotalCap () {
        if (this.ruleForm.totalCap >= this.ruleForm.dailyCap) {
          return true
        } else {
          return false
        }
      },
      uploadFile (type) {
        var that = this
        var str = '.' + type + 'file'
        var filesInput = document.querySelector(str)
        filesInput.click()
        var addEventListenerFun = function () {
          // 那么开始上传
          var files = filesInput.files
          var file = files[0]
          if (files.length !== 0) {
            var data = {
              file: file,
              fileName: file.name,
              size: file.size,
              type: file.type,
              width: null,
              height: null
            }
            that.judeUploadFile(data, type, function () {
              that.uploadFun(data, type, function (err, result) {
                // 总是清空input file
                filesInput.value = ''
                if (err) {
                  console.log(err)
                  that.$message.error('图片上传失败')
                } else {
                  console.log(result)
                  var downData = {
                    url: result.Location,
                    width: data.width,
                    height: data.height,
                    size: data.size,
                    type: type,
                    key: result.key
                  }
                  that.uploadCallback(downData, type)
                }
                filesInput.removeEventListener('change', addEventListenerFun, true)
              })
            })
          }
        }
        filesInput.addEventListener('change', addEventListenerFun, true)
      },
      judeUploadFile (data, type, callback) {
        var that = this
        if (type === 'video') {
          if (data.type.indexOf(type) !== -1) {
            that.getSize(data, type, function (bob) {
              var w = bob.videoWidth
              var h = bob.videoHeight
              data.width = w
              data.height = h
              if (w / h < 1.7 && w / h > 2.1) {
                that.$message.error('视频尺寸不符,请重新上传')
              } else {
                callback()
              }
            })
          } else {
            that.$message.error('文件类型不符')
          }
        } else {
          if (data.type.indexOf('image') !== -1) {
            that.getSize(data, type, function (bob) {
              var w = bob.width
              var h = bob.height
              data.width = w
              data.height = h
              if (type === 'icon') {
                if (w === h) {
                  callback()
                } else {
                  that.$message.error('图片尺寸非1:1,请重新上传')
                }
              } else {
                callback()
              }
              if (type === 'image') {
                if (w / h < 1.7 && w / h > 2.1) {
                  that.$message.error('图片尺寸不符,请重新上传')
                } else {
                  callback()
                }
              }
            })
          } else {
            that.$message.error('文件类型不符')
          }
        }
      },
      uploadFun (data, type, callback) {
        console.log('开始上传')
        var that = this
        // 上传状态
        s3.upload({
          Key: data.fileName,
          Body: data.file,
          ACL: 'public-read'
        }, function (err, result) {
          callback(err, result)
        })
      },
      deleteFun (data, index, list) {
        var that = this
        var photoKey = data.key
        s3.deleteObject({ Key: photoKey }, function (err, result) {
          if (err) {
            console.log(err)
            that.$message.error('图片删除失败')
          } else {
            console.log(result)
            list.splice(index, 1)
          }
        })
      },
      uploadCallback (data, type) {
        var flag = this.duplicateRemoval(this.ruleForm[type + 'List'], data)
        if (type === 'icon' && this.ruleForm[type + 'List'].length !== 1) {
          var icon0 = this.ruleForm[type + 'List'][0]
          this.deleteFun(icon0, 0, this.ruleForm[type + 'List'])
          // this.getSize(data, type)
        }
      },
      duplicateRemoval (list, data) {
        var flag = true
        list.map(function (ele) {
          if (ele.url === data.url) {
            flag = false
          }
        })
        if (flag) {
          list.push(data)
        }
        return flag
      },
      getSize (data, type, callback) {
        var reader = new FileReader()
        reader.onload = function (theFile) {
          if (type !== 'video') {
            var media = new Image()
            media.src = theFile.target.result
            media.onload = function () {
              callback(this)
            }
          } else {
            var videoDom = document.createElement('video')
            videoDom.classList.add('testVideo', 'dn')
            videoDom.src = theFile.target.result
            document.body.appendChild(videoDom)
            videoDom.onloadeddata = function () {
              callback(this)
            }
          }
        }
        reader.readAsDataURL(data.file)
      },
      submitForm (formName) {
        this.$refs[formName].validate(function (valid) {
          if (valid) {
            console.log('submit!')
          } else {
            console.log('error submit!!')
            return false
          }
        })
      },
      resetForm(formName) {
        this.$refs[formName].resetFields()
        window.scrollTo(0, 0)
      }
    },
    watch: {}
  })
</script>
<style>
  .contentBox{
    padding: 0 20px;
  }
  .content-li{
    border-bottom: 1px solid #ccc;
    overflow: hidden;
  }
  .content-li:last-child{
    border: 0;
  }
  .content-li-title{
    font-weight: bold;
    margin-top: 20px;
  }
  .num-circle{
    width: 20px;
    height: 20px;
    color: #1a8eff;
    border: 2px solid #1a8eff;
    border-radius: 50%;
    text-align: center;
    line-height: 17px; 
    margin-right: 20px;
  }
  .content-con{
    padding: 20px 0;
  }
  .form-one{
    width: 400px;
  }
  .imgDocker{
    margin-top: 20px;
  }
  .showImgBox{
    width: 200px;
    height: 200px;
    overflow: hidden;
    border: 1px solid #ccc;
    margin: 10px;
    background: #efedef;
    box-shadow: 5px 5px 10px 0 #ccc;
    box-sizing: content-box;
    border-radius: 10px;
    position: relative;
  }
  .showImg{
    width: 200px;
    height: 200px;
    padding: 10px;
  }
  .showImgTitle{
    padding: 10px;
    word-break: break-all;
  }
  .showImg img,video{
    max-width: 100%;
    max-height: 100%;
    width: auto;
    height: auto;
    background: #fff;

  }
  .close{
    position: absolute;
    right: 0;
    top: 0;
  }
</style>