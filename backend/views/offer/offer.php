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
            <el-form-item label="App Store or Google Play URL" prop="storeUrl">
              <el-input class='form-one' v-model="ruleForm.storeUrl" placeholder=''></el-input>
            </el-form-item>
            <transition name='fade'>
              <div class='w100 center mb-30 of-h' v-if='messageVisible'>
              <span class='messageVisibleShow db'>APP Apple Store or Google Play URL may be wrong, please <a class='color_dangers' @click='spiderAgain'>fill in again</a> or <a class='color_dangers'@click='spiderUse'>use the current one</a>. </span>
            </div>
            </transition>
            <el-form-item label="Campaign Title" prop="title">
              <el-input class='form-one' v-model="ruleForm.title" placeholder=''></el-input>
            </el-form-item>
            <el-form-item label="Campaign Description" prop="desc">
              <el-input type='textarea' class='form-one' v-model="ruleForm.desc" placeholder=''></el-input>
            </el-form-item>
            <el-form-item label="Package Name" prop="name">
              <el-input class='form-one' v-model="ruleForm.name" placeholder=''></el-input>
            </el-form-item>
            <el-form-item label="Campaign Category" prop="category">
              <el-select class='form-one' :disabled='!judePlatform'
                v-model="ruleForm.category" clearable placeholder="">
                <el-option
                  v-for="item in options.category"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value">
                </el-option>
              </el-select>
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
            <template v-if='ruleForm.schedule === "1"'>
              <el-form-item  prop="deliveryDate">
                <el-date-picker
                  class='form-one'
                  v-model="ruleForm.deliveryDate"
                  type="daterange"
                  align="right"
                  unlink-panels
                  range-separator="至"
                  start-placeholder="开始日期"
                  end-placeholder="结束日期"
                  value-format="yyyy-MM-dd"
                  >
                </el-date-picker>
              </el-form-item>
              <el-form-item label="Comment" prop="deliveryWeek">
                <el-checkbox-group class='form-one checkbox-docker' v-model="ruleForm.deliveryWeek">
                  <el-checkbox label="item.value" :key=item.value v-for='item in options.deliveryWeek'>{{item.label}}</el-checkbox>
                </el-checkbox-group>
              </el-form-item>
              <el-form-item label="Comment" prop="deliveryHour">
                <el-checkbox-group class='form-one checkbox-docker' v-model="ruleForm.deliveryHour">
                  <el-checkbox label="item" :key='item' v-for='item in options.deliveryHour'>{{item}}</el-checkbox>
                </el-checkbox-group>
              </el-form-item>
            </template>
            <el-form-item label="Comment" prop="comment">
              <el-input class='form-one mt-20' type='textarea' v-model="ruleForm.comment" placeholder=''></el-input>
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
              <el-input class='form-one' v-model.number="ruleForm.priceWay" placeholder=''></el-input>
            </el-form-item>
            <el-form-item label="Daily Cap" prop="dailyCap">
              <el-input class='form-one' v-model.trim.number="ruleForm.dailyCap" placeholder=''></el-input>
            </el-form-item>
            <el-form-item label="Total Cap" prop="totalCap">
              <el-input class='form-one' v-model.trim.number="ruleForm.totalCap" placeholder=''></el-input>
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
            <el-form-item label="Device Type" prop="deviceType">
              <el-select class='form-one' :disabled='!judePlatform'
                v-model="ruleForm.deviceType" clearable placeholder="">
                <el-option
                  v-for="item in options.deviceType"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value">
                </el-option>
              </el-select>
            </el-form-item>
            <el-form-item label="Specific Device" prop="specificDevice" v-if='judeDeviceType'>
              <el-select class='form-one' multiple filterable :disabled='ruleForm.deviceType === ""'
                v-model="ruleForm.specificDevice" clearable placeholder="">
                <el-option
                  v-for="item in options.specificDevice"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value">
                </el-option>
              </el-select>
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
            <el-form-item label="Targeting Countries" prop="countryType">
              <el-select class='form-one'
                v-model="ruleForm.countryType" clearable placeholder="">
                <el-option
                  v-for="item in options.countryType"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value">
                </el-option>
              </el-select>
            </el-form-item>
            <el-form-item v-if='ruleForm.countryType !== "1" && ruleForm.countryType' label="select Country" prop="country">
              <el-select class='form-one' multiple filterable 
                v-model="ruleForm.country" clearable placeholder="">
                <el-option
                  v-for="item in options.country"
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
                  <el-button type="primary" @click='previewAddFile("icon")'>Preview</el-button>
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
                  <el-button type="primary" @click='previewAddFile("image")'>Preview</el-button>
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
                  <el-button type="primary" @click='previewAddFile("video")'>Preview</el-button>
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
  // 上传图片和视频的尺寸规范
  var minRatio = 1.7
  var maxRatio = 2.1
  var baseRatio = 1.9 / 1
  var maxImageSize = 500
  var maxVideoSize = 2 * 1024
  var ruleLanguagePackage = {
    required: '此项必填',
    shouldNumber: '必须为数字',
    notWWW: '不是正确的网址',
    notStore: 'APP Apple Store or Google Play URL may be wrong.',
    shouldInputPlatform: '请先填写平台后再试',
    uploadImageError: '图片上传失败',
    uploadVideoError: '视频上传失败',
    fileTypeError: '文件类型不符',
    uploadImageSizeMax: '图片大小应小于500KB',
    uploadVideoSizeMax: '视频大小应小于2M',
    uploadIconSizeError: '图片尺寸不是1：1',
    uploadImageSizeError: '图片尺寸不符',
    uploadVideoSizeError: '视频尺寸不符',
    s3UploadFile: '图片上传成功',
    s3DeleteFile: '图片删除失败',
    shouldChoiceOne: '至少选择一项'
  }
  // 初始化vue对象
  new Vue({
    el: '.app',
    data () {
      var vm = this
      var validatorStoreUrl = function (rule, value, callback) {
        // 正则
        var reg = new RegExp('(https?|ftp|file)://[-A-Za-z0-9+&@#/%?=~_|!:,.;]+[-A-Za-z0-9+&@#/%=~_|]')
        var iOSReg = new RegExp('https://itunes.apple.com/')
        var androidReg = new RegExp('https://play.google.com/')
        var platform = null
        if (reg.test(value)) {
          if (iOSReg.test(value)) {
            // ios
            platform = 'ios'
          } else if (androidReg.test(value)) {
            // android
            platform = 'android'
          } else {
            vm.messageVisible = true
            callback()
          }
          if (platform) {
            if (vm.ruleForm.platform) {
              vm.judeHref(platform, value, function (flag) {
                if (flag) {
                  callback()
                } else {
                  callback(new Error(ruleLanguagePackage.notStore))
                  // 弹出框
                }
                vm.dialogVisible = true
              })
            } else {
              callback(new Error(ruleLanguagePackage.shouldInputPlatform))
            }
          }
        } else {
          callback(new Error(ruleLanguagePackage.notWWW))
        }
      }
      var validatorDailyCap = function (rule, value, callback) {
        if (value) {
          if (Number(value) !== value) {
            callback(new Error(ruleLanguagePackage.shouldNumber))
          } else {
            callback()
          }
        } else {
          callback()
        }
      }
      var validatorTotalCap = function (rule, value, callback) {
        if (value) {
          if (Number(value) !== value) {
            callback(new Error(ruleLanguagePackage.shouldNumber))
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
        messageVisible: false,
        csrf: '',
        options: {
          campaignOwner: [],
          advertiser: [],
          attributeProvider: [],
          platform: [
            {
              value: '1',
              label: 'Android'
            },
            {
              value: '2',
              label: 'iOS'
            }
          ],
          deviceType: [],
          deviceTypeBase: {
            ios: ['phone', 'ipad', 'unlimited'],
            android: ['phone', 'tablet', 'unlimited']
          },
          minOSvsersionBase: {},
          minOSvsersion: [],
          countryType: [
            {
              value: '1',
              label: 'select all countries'
            },
            {
              value: '2',
              label: 'select countries to add'
            },
            {
              value: '3',
              label: 'select countries to exclude'
            }
          ],
          country: [],
          category: [],
          categoryBase: {},
          specificDevice: [],
          specificDeviceBase: {},
          deliveryWeek: [
            {value: 0, label: 'Sun'},
            {value: 1, label: 'Mon'},
            {value: 2, label: 'Tues'},
            {value: 3, label: 'Weds'},
            {value: 4, label: 'Thu'},
            {value: 5, label: 'Fri'},
            {value: 6, label: 'Sat'},
          ],
          deliveryHour: ['00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23']
        },
        ruleForm: {
          // 1
          campaignOwner: '',
          advertiser: '',
          attributeProvider: '',
          // 2
          storeUrl: '',
          platform: '',
          title: '',
          desc: '',
          name: '',
          category: '',
          trackingUrl: '',
          schedule: '',
          deliveryDate: '',
          deliveryWeek: [],
          deliveryHour: [],
          comment: '',
          // 3
          priceWay: '',
          dailyCap: '',
          totalCap: '',
          // 4
          deviceType: '',
          specificDevice: [],
          minOSvsersion: '',
          networkStatus: '',
          countryType: '',
          country: [],
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
            { required: true, message: ruleLanguagePackage.required, trigger: 'blur' }
          ],
          advertiser: [
            { required: true, message: ruleLanguagePackage.required, trigger: 'blur' }
          ],
          attributeProvider: [
            { required: true, message: ruleLanguagePackage.required, trigger: 'blur' }
          ],
          // 2
          storeUrl: [
            { required: true, message: ruleLanguagePackage.required, trigger: 'blur' },
            { validator: validatorStoreUrl, trigger: 'blur' }
          ],
          platform: [
            { required: true, message: ruleLanguagePackage.required, trigger: 'blur' }
          ],
          title: [
            { required: true, message: ruleLanguagePackage.required, trigger: 'blur' }
          ],
          desc: [
            { required: true, message: ruleLanguagePackage.required, trigger: 'blur' }
          ],
          name: [
            { required: true, message: ruleLanguagePackage.required, trigger: 'blur' }
          ],
          category: [
            { required: true, message: ruleLanguagePackage.required, trigger: 'blur' }
          ],
          trackingUrl: [
            { required: true, message: ruleLanguagePackage.required, trigger: 'blur' }
          ],
          schedule: [
            { required: true, message: ruleLanguagePackage.shouldChoiceOne, trigger: 'blur' }
          ],
          // 3
          priceWay: [
            { required: true, message: ruleLanguagePackage.required, trigger: 'blur' },
            { type: 'number', message: ruleLanguagePackage.shouldNumber , trigger: 'blur' }
          ],
          dailyCap: [
            { required: false, validator: validatorDailyCap, trigger: 'blur' }
          ],
          totalCap: [
            { required: false, validator: validatorTotalCap, trigger: 'blur' }
          ],
          // 4
          deviceType: [
            { required: true, message: ruleLanguagePackage.required, trigger: 'blur' }
          ],
          minOSvsersion: [
            { required: true, message: ruleLanguagePackage.required, trigger: 'blur' }
          ],
          networkStatus: [
            { required: true, message: ruleLanguagePackage.required, trigger: 'blur' }
          ],
          countryType: [
            { required: true, message: ruleLanguagePackage.required, trigger: 'blur' }
          ],
          country: [
            { required: true, message: ruleLanguagePackage.required, trigger: 'blur' }
          ],
        }
      }
    },
    computed: {
      judeOne () {
        return true
        if (this.ruleForm.campaignOwner !== '' && this.ruleForm.advertiser !== '' && this.ruleForm.attributeProvider !== '') {
          return true
        }
        return false
      },
      judeDeviceType () {
        var that = this
        // 置空
        that.options.specificDevice.splice(0)
        // 
        if (this.ruleForm.platform === '1') {
          // android
          return false
        }
        if (this.ruleForm.platform === '2') {
          // ios
          if (this.ruleForm.deviceType === 'phone') {
            this.options.specificDeviceBase.ios.phone.map(function (ele) {
              that.options.specificDevice.push({
                value: ele,
                label: ele
              })
            })
          }
          if (this.ruleForm.deviceType === 'ipad') {
            this.options.specificDeviceBase.ios.tablet.map(function (ele) {
              that.options.specificDevice.push({
                value: ele,
                label: ele
              })
            })
          }
          if (this.ruleForm.deviceType === 'unlimited') {
            this.options.specificDeviceBase.ios.other.map(function (ele) {
              that.options.specificDevice.push({
                value: ele,
                label: ele
              })
            })
          }
          that.ruleForm.specificDevice = []
          return true
        }
      },
      judePlatform () {
        var that = this
        var flag = false
        // 置空
        that.options.deviceType.splice(0)
        that.options.category.splice(0)
        that.options.minOSvsersion.splice(0)
        that.ruleForm.deviceType = ''
        that.ruleForm.category = ''
        that.ruleForm.minOSvsersion = ''
        // 
        if (this.ruleForm.platform === '') {
          flag = false
        }
        if (this.ruleForm.platform === '1') {
          flag = true
          // android
          this.options.deviceTypeBase.android.map(function (ele) {
            that.options.deviceType.push({
              value: ele,
              label: ele
            })
          })
          this.options.categoryBase.android.map(function (ele) {
            that.options.category.push({
              value: ele.id,
              label: ele.name
            })
          })
          this.options.minOSvsersionBase.android.map(function (ele) {
            that.options.minOSvsersion.push({
              value: ele,
              label: ele
            })
          })
        }
        if (this.ruleForm.platform === '2') {
          flag = true
          // ios
          this.options.deviceTypeBase.ios.map(function (ele) {
            that.options.deviceType.push({
              value: ele,
              label: ele
            })
          })
          this.options.categoryBase.ios.map(function (ele) {
            that.options.category.push({
              value: ele.id,
              label: ele.name
            })
          })
          this.options.minOSvsersionBase.ios.map(function (ele) {
            that.options.minOSvsersion.push({
              value: ele,
              label: ele
            })
          })
        }
        return flag
      }
    },
    mounted () {
      var that = this
      this.csrf = document.querySelector('#spp_security').value
      this.$watch('ruleForm.dailyCap', function (newVal, oldVal) {
        // 每次改变都会验证totalCap
        this.$refs['ruleForm'].validateField('totalCap')
      }, {
        deep: true
      })
      this.$watch('ruleForm.countryType', function (newVal, oldVal) {
        // 每次改变都会验证countryType
        that.ruleForm.country.splice(0)
        if (newVal === '1') {
          that.ruleForm.country = JSON.parse(JSON.stringify(that.options.country))
        }
      }, {
        deep: true
      })
      // initData
      this.initData()
    },
    methods: {
      spiderAgain () {
        // 再次爬虫
        console.log(1)
      },
      spiderUse () {
        // 手动添加name和category
        console.log(2)
      },
      // 验证商店地址
      judeHref (platform, url, callback) {
        var that = this
        var ajaxData = {
          url: url,
          country: null,
          platform: platform,
          dsp_security_param: this.csrf
        }
        $.ajax({
          url: '/offer/get-url-info',
          data: ajaxData,
          type: 'post',
          success: function (result) {
            var result = JSON.parse(result)
            if (result.status === 1) {
              that.ruleForm.title = result.data.offer_title
              that.ruleForm.name = result.data.pkg_name
              var category_id = result.data.category_id
              that.options.category.map(function (ele) {
                if (result.data.category_id === ele.value) {
                  that.ruleForm.category = category_id
                }
              })
              callback(true)
            } else {
              callback(false)
            }
          }
        })
      },
      // 初始化页面
      initData () {
        var that = this
        var ajaxData = {
          dsp_security_param: this.csrf
        }
        $.ajax({
          url: '/offer/get-offer-config',
          type: 'post',
          data: ajaxData,
          success: function (result) {
            // Campaign Owner
            result.data.user.map(function (ele) {
              that.options.campaignOwner.push({
                value: ele.id,
                label: ele.email
              })
            })
            // advertiser
            result.data.ads.map(function (ele) {
              that.options.advertiser.push({
                value: ele.id,
                label: ele.ads
              })
            })
            // attributeProvider
            result.data.tpm.map(function (ele) {
              that.options.attributeProvider.push({
                channel: ele.channel,
                value: ele.id,
                label: ele.tpm
              })
            })
            // country
            var country = []
            result.data.country.map(function (ele) {
              country.push({
                value: ele.id,
                label: ele.full_name
              })
            })
            // specificDevice
            that.options.specificDeviceBase = result.data.mobile
            // country
            that.options.country = country
            // version
            that.options.minOSvsersionBase = result.data.version
            // category
            that.options.categoryBase = result.data.category
          }
        })
      },
      // 判断totalCap
      judeTotalCap () {
        if (this.ruleForm.totalCap >= this.ruleForm.dailyCap) {
          return true
        } else {
          return false
        }
      },
      // 上传文件
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
            var fileData = {
              file: file,
              fileName: file.name,
              size: file.size,
              type: file.type,
              width: null,
              height: null
            }
            that.judeUploadFile(fileData, type, function () {
              // 上传函数
              that.uploadFun(fileData, type, function (err, result) {
                // 总是清空input file
                filesInput.value = ''
                if (err) {
                  console.log(err)
                  that.$message.error(ruleLanguagePackage.uploadImageError)
                  return
                } else {
                  console.log(result)
                  var downData = {
                    url: result.Location,
                    width: fileData.width,
                    height: fileData.height,
                    size: fileData.size,
                    type: type,
                    key: result.key,
                    ratio: fileData.ratio
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
      // 判断上传文件
      judeUploadFile (fileData, type, callback) {
        var that = this
        if (type === 'video') {
          if (fileData.type.indexOf(type) !== -1) {
            that.getOnlineFile(fileData, type, function (bob) {
              var w = bob.videoWidth
              var h = bob.videoHeight
              var ratio = w / h
              fileData.width = w
              fileData.height = h
              fileData.ratio = ratio
              if (fileData.size <= maxVideoSize) {
                callback()
              } else {
                that.$message.error(ruleLanguagePackage.uploadVideoSizeMax)
              }
            })
          } else {
            that.$message.error(ruleLanguagePackage.fileTypeError)
          }
        } else {
          if (fileData.type.indexOf('image') !== -1) {
            that.getOnlineFile(fileData, type, function (bob) {
              var w = bob.width
              var h = bob.height
              var ratio = w / h
              fileData.width = w
              fileData.height = h
              fileData.ratio = ratio
              if (fileData.size <= maxImageSize) {
                if (type === 'icon') {
                  if (w === h) {
                    callback()
                  } else {
                    that.$message.error(ruleLanguagePackage.uploadIconSizeError)
                  }
                } else {
                  callback()
                }
                if (type === 'image') {
                  var ratioFlag = (ratio >= minRatio && ratio <= maxRatio)
                  if (ratioFlag || ratio === baseRatio || ratio === 1 / baseRatio) {
                    that.$message.error(ruleLanguagePackage.uploadImageSizeError)
                  } else {
                    callback()
                  }
                }
              } else {
                that.$message.error(ruleLanguagePackage.uploadImageSizeMax)
              }
            })
          } else {
            that.$message.error(ruleLanguagePackage.fileTypeError)
          }
        }
      },
      // 上传s3函数
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
      // 删除s3函数
      deleteFun (data, index, list) {
        var that = this
        var photoKey = data.key
        if (photoKey) {
          s3.deleteObject({ Key: photoKey }, function (err, result) {
            if (err) {
              console.log(err)
              that.$message.error(ruleLanguagePackage.s3DeleteFile)
            } else {
              console.log(result)
              list.splice(index, 1)
            }
          })
        } else {
          list.splice(index, 1)
        }
      },
      // 上传s3成功之后的回调
      uploadCallback (data, type) {
        var flag = this.duplicateRemoval(this.ruleForm[type + 'List'], data)
        if (type === 'icon' && this.ruleForm[type + 'List'].length !== 1) {
          var icon0 = this.ruleForm[type + 'List'][0]
          this.deleteFun(icon0, 0, this.ruleForm[type + 'List'])
        }
        // clear
        this.ruleForm[type] = ''
      },
      // 去重函数
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
      // 验证本地文件
      getOnlineFile (data, type, callback) {
        var that = this
        var reader = new FileReader()
        reader.onload = function (theFile) {
          var url = theFile.target.result
          that.getOnline(type, url, callback)
        }
        reader.readAsDataURL(data.file)
      },
      // 预处理文件地址信息
      getOnline (type, src, callback, errorcallback) {
        if (type !== 'video') {
          var media = new Image()
          media.src = src
          media.onload = function () {
            callback(this)
          }
          media.error = function () {
            errorcallback(this)
          }
        } else {
          var videoDom = document.createElement('video')
          videoDom.classList.add('testVideo', 'dn')
          videoDom.src = src
          document.body.appendChild(videoDom)
          videoDom.onloadeddata = function () {
            callback(this)
          }
          videoDom.error = function () {
            errorcallback(this)
          }
        }
      },
      // 点击preview按钮
      previewAddFile (type) {
        var that = this
        var ajaxData = {
          width: null,
          height: null,
          key: null,
          size: null,
          type: type,
          url: null
        }
        if (type === 'icon') {
          var src = this.ruleForm.icon
          this.getOnline(type, src, function (obj) {
            var w = obj.width
            var h = obj.height
            var ratio = w / h
            if (w === h) {
              ajaxData = {
                width: w,
                height: h,
                key: null,
                size: null,
                type: type,
                url: src,
                ratio: ratio
              }
              that.uploadCallback(ajaxData, type)
            } else {
              that.$message.error(ruleLanguagePackage.uploadIconSizeError)
            }
          })
        }
        if (type === 'image') {
          var src = this.ruleForm.image
          this.getOnline(type, src, function (obj) {
            var w = obj.width
            var h = obj.height
            var ratio = w / h
            ajaxData = {
              width: w,
              height: h,
              key: null,
              size: null,
              type: type,
              url: src,
              ratio: ratio
            }
            var ratioFlag = (ratio >= minRatio && ratio <= maxRatio)
            if (ratioFlag || ratio === baseRatio || ratio === 1 / baseRatio) {
              that.$message.error(ruleLanguagePackage.uploadImageSizeError)
            } else {
              that.uploadCallback(ajaxData, type)
            }
          })
        }
        if (type === 'video') {
          var src = this.ruleForm.video
          this.getOnline(type, src, function (obj) {
            var w = obj.videoWidth
            var h = obj.videoHeight
            var ratio = w / h
            ajaxData = {
              width: w,
              height: h,
              key: null,
              size: null,
              type: type,
              url: src,
              ratio: ratio
            }
            that.uploadCallback(ajaxData, type)
          })
        }
      },
      // 表单提交
      submitForm (formName) {
        var that = this
        this.$refs[formName].validate(function (valid) {
          if (valid) {
            console.log('submit!')
            that.submitAjax()
          } else {
            console.log('error submit!!')
            return false
          }
        })
      },
      // 重置表单
      resetForm(formName) {
        this.$refs[formName].resetFields()
        window.scrollTo(0, 0)
      },
      submitAjax () {
        
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
    width: 400px !important;
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
  .messageVisibleShow{
    background: #efefef;
    padding: 10px 20px;
  }
  .el-checkbox{
    margin-left: 30px;
  }
  .checkbox-docker {
    margin-top: 20px;
    padding: 20px 0;
    border: 1px solid #dcdfe6;
  }
</style>