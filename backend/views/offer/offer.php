<div class='app'>
  <div class='breadcrumbDocker w100 flex flex-row-flex-start-center'>
    <el-breadcrumb separator-class="el-icon-arrow-right">
      <el-breadcrumb-item :to="{ path: '/user/user-index' }">User</el-breadcrumb-item>
      <el-breadcrumb-item>Index</el-breadcrumb-item>
    </el-breadcrumb>
  </div>
  <div class='flex jcsb p30'>
    <h3>NEW CAMPAIGN</h3>
    <el-button type="primary">Save</el-button>
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
                <el-radio value='2' label="OFF"></el-radio>
                <el-radio value='1' label="ON"></el-radio>
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
              <el-input class='form-one' v-model="ruleForm.dailyCap" placeholder=''></el-input>
            </el-form-item>
            <el-form-item label="Total Cap" prop="totalCap">
              <el-input class='form-one' v-model="ruleForm.totalCap" placeholder=''></el-input>
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
                v-model="ruleForm.minOSvsersion" clearable placeholder="">
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
                <el-radio value='1' label="WIFI & 4G"></el-radio>
                <el-radio value='2' label="WIFI"></el-radio>
                <el-radio value='3' label="4G"></el-radio>
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
        <div class='flex p30'>
          <el-button type="primary">Save</el-button>
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
          campaignOwner: [
            {required: true}
          ],
          advertiser: [
            {required: true}
          ],
          attributeProvider: [
            {required: true}
          ],
        }
      }
    },
    methods: {
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
              type: file.type
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
                    width: data.w,
                    height: data.h,
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
            callback()
          } else {
            that.$message.error('文件类型不符')
          }
        } else {
          if (data.type.indexOf('image') !== -1) {
            var reader = new FileReader()
            reader.onload = function (theFile) {
              var media = new Image()
              media.src = theFile.target.result
              media.onload = function () {
                var w = this.width
                var h = this.height
                data.w = w
                data.h = h
                if (type === 'icon') {
                  if (w === h) {
                    callback()
                  } else {
                    that.$message.error('图片尺寸非1:1,请重新上传')
                  }
                } else {
                  callback()
                }
              }
            }
            reader.readAsDataURL(data.file)
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
        }
        if (type === 'video') {
          var videoDom = document.createElement('video')
          videoDom.classList.add('testVideo', 'dn')
          videoDom.src = data.url
          document.body.appendChild(videoDom)
          videoDom.oncanplay = function () {
            var w = this.videoWidth
            var h = this.videoHeight
            data.w = w
            data.h = h
            console.log(data)
            // 此处执行备份到php
          }
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
      getSize () {

      }
    }
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