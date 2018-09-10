<div class='app' data-type="<?php echo $type; ?>">
  <div class='breadcrumbDocker w100 flex flex-row-flex-start-center'>
    <el-breadcrumb separator-class="el-icon-arrow-right">
      <el-breadcrumb-item :to="{ path: '/user/user-index' }">User</el-breadcrumb-item>
      <el-breadcrumb-item>Index</el-breadcrumb-item>
    </el-breadcrumb>
  </div>
  <div class='flex jcsb p30'>
    <h3 v-if='pageType === "create"'>New Campaign</h3>
    <h3 v-if='pageType === "update"'>Edit Campaign</h3>
    <div>
      <!-- <el-button  @click='resetForm("ruleForm")'>Reset</el-button> -->
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
              <el-select class='form-one' @change='judeChannel'
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
              <el-select class='form-one' @change='changePlatform'
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
              <el-input class='form-one' @focus='storeUrlFocus' type='textarea' v-model.trim="ruleForm.storeUrl" placeholder=''></el-input>
            </el-form-item>
            <el-form-item label="">
              <div class='judeUrl-box form-one' v-if='spaceShowStoreUrlFlag'>
                <span class='judeUrl-span' v-html='spaceShowStoreUrl'></span>
              </div>
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
              <el-input class='form-one' type='textarea' v-model.trim="ruleForm.trackingUrl" placeholder=''></el-input>
            </el-form-item>
            <el-form-item label="">
              <div class='judeUrl-box form-one' v-if='spaceShowTrackingUrlFlag'>
                <span class='judeUrl-span' v-html='spaceShowTrackingUrl'></span>
              </div>
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
              <el-form-item prop="deliveryWeek">
                <el-checkbox-group class='form-one checkbox-docker' v-model="ruleForm.deliveryWeek">
                  <el-checkbox :label="item.value" :key=item.value v-for='item in options.deliveryWeek'>{{item.label}}</el-checkbox>
                </el-checkbox-group>
              </el-form-item>
              <el-form-item prop="deliveryHour">
                <el-checkbox-group class='form-one checkbox-docker' v-model="ruleForm.deliveryHour">
                  <el-checkbox :label="item" :key='item' v-for='item in options.deliveryHour'>{{item}}</el-checkbox>
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
            <el-form-item label="Price($)" prop="payout">
              <el-input class='form-one' v-model.number="ruleForm.payout" placeholder=''></el-input>
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
                v-model="ruleForm.deviceType" @change='changeDeviceType' clearable placeholder="">
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
            <el-form-item label="Min OS Version" prop="minOSversion">
              <el-select class='form-one'
                v-model="ruleForm.minOSversion" :disabled='!judePlatform' clearable placeholder="">
                <el-option
                  v-for="item in options.minOSversion"
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
                v-model="ruleForm.countryType" @change='changeCountryType' clearable placeholder="">
                <el-option
                  v-for="item in options.countryType"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value">
                </el-option>
              </el-select>
            </el-form-item>
            <el-form-item v-if='showCountry' label="select Country" prop="country">
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
          <!-- <el-button  @click='resetForm("ruleForm")'>Reset</el-button> -->
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
  var maxImageSize = 500 * 1024
  var maxVideoSize = 2 * 1024 * 1024
  // 正则
  var regHref = new RegExp('(https?|ftp|file)://[-A-Za-z0-9+&@#/%?=~_|!:,.;]+[-A-Za-z0-9+&@#/%=~_|]')
  var iOSReg = new RegExp('https://itunes.apple.com/')
  var androidReg = new RegExp('https://play.google.com/')
  var spaceReg = new RegExp('\\s', 'g')
  // 
  var ruleLanguagePackage = {
    required: '此项必填',
    shouldNumber: '必须为数字',
    notWWW: '不是正确的网址',
    notSpace: '网址有空格',
    notStore: 'APP Apple Store or Google Play URL may be wrong.',
    notEqualToPlatform: '所填链接与所选平台不符',
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
        if (vm.storeUrlFlag) {
          vm.storeUrlFlag = false
          var platform = null
          var vmPlatform = null
          if (spaceReg.test(value)) {
            // 有空格
            vm.messageVisible = false
            callback(new Error(ruleLanguagePackage.notSpace))
          } else if (regHref.test(value)) {
            if (iOSReg.test(value)) {
              // ios
              platform = 'ios'
              vmPlatform = '2'
            } else if (androidReg.test(value)) {
              // android
              platform = 'android'
              vmPlatform = '1'
            } else {
              vm.messageVisible = true
              callback()
            }
            if (vm.ruleForm.platform) {
              if (vmPlatform === vm.ruleForm.platform) {
                if (platform) {
                  vm.judeHref(platform, value, function (flag) {
                    if (flag) {
                      callback()
                    } else {
                      // 没有查询到商店
                      callback(new Error(ruleLanguagePackage.notStore))
                    }
                    vm.dialogVisible = true
                  })
                }
              } else {
                // 与所填平台不符
                callback(new Error(ruleLanguagePackage.notEqualToPlatform))
              }
            } else {
              // 应该填写平台
              callback(new Error(ruleLanguagePackage.shouldInputPlatform))
            }
          } else {
            // 不是网址
            callback(new Error(ruleLanguagePackage.notWWW))
          }
        } else {
          callback()
        }
      }
      var validatorTrackingUrl = function (rule, value, callback) {
        if (spaceReg.test(value)) {
          callback(new Error(ruleLanguagePackage.notSpace))
        } else if (!regHref.test(value)) {
          callback(new Error(ruleLanguagePackage.notWWW))
        } else {
          callback()
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
        offerID: "<?php echo $offer_id; ?>",
        pageType: "<?php echo $type; ?>",
        channel: null,
        messageVisible: false,
        csrf: '',
        storeUrlFlag: false,
        showCountry: true,
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
          minOSversionBase: {},
          minOSversion: [],
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
            {value: '0', label: 'Sun'},
            {value: '1', label: 'Mon'},
            {value: '2', label: 'Tues'},
            {value: '3', label: 'Weds'},
            {value: '4', label: 'Thu'},
            {value: '5', label: 'Fri'},
            {value: '6', label: 'Sat'},
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
          deliveryDate: [],
          deliveryWeek: [],
          deliveryHour: [],
          comment: '',
          // 3
          payout: '',
          dailyCap: '',
          totalCap: '',
          // 4
          deviceType: '',
          specificDevice: [],
          minOSversion: '',
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
            { required: true, message: ruleLanguagePackage.required, trigger: 'blur' },
            { validator: validatorTrackingUrl, trigger: 'blur' }
          ],
          schedule: [
            { required: true, message: ruleLanguagePackage.shouldChoiceOne, trigger: 'blur' }
          ],
          // 3
          payout: [
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
          minOSversion: [
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
      spaceShowTrackingUrlFlag () {
        if (this.ruleForm.trackingUrl.indexOf(' ') !== -1) return true
        return false
      },
      spaceShowTrackingUrl () {
        if (this.spaceShowTrackingUrlFlag) {
          var str = this.ruleForm.trackingUrl
          return str.replace(spaceReg, '<span class="judeUrl-font">&nbsp;</span>')
        }
      },
      spaceShowStoreUrl () {
        if (this.spaceShowStoreUrlFlag) {
          var str = this.ruleForm.storeUrl
          return str.replace(spaceReg, '<span class="judeUrl-font">&nbsp;</span>')
        }
      },
      spaceShowStoreUrlFlag () {
        if (this.ruleForm.storeUrl.indexOf(' ') !== -1) return true
        return false
      },
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
          return true
        }
      },
      judePlatform () {
        var that = this
        var flag = false
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
          this.options.minOSversionBase.android.map(function (ele) {
            that.options.minOSversion.push({
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
          this.options.minOSversionBase.ios.map(function (ele) {
            that.options.minOSversion.push({
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
      this.$watch('ruleForm.platform', function (newVal, oldVal) {
        this.$refs['ruleForm'].validateField('storeUrl')
      }, {
        deep: false
      })
      this.$watch('ruleForm.dailyCap', function (newVal, oldVal) {
        // 每次改变都会验证totalCap
        this.$refs['ruleForm'].validateField('totalCap')
      }, {
        deep: false
      })
      this.$watch('ruleForm.countryType', function (newVal, oldVal) {
        if (newVal === '1') {
          that.options.country.map(function (ele) {
            that.ruleForm.country.push(ele.value)
          })
        }
      }, {
        deep: false
      })
      // initData
      this.initData()
    },
    methods: {
      // 获取已经保存的信息
      getUpdateInfo () {
        var that = this
        if (this.pageType === 'update') {
          var ajaxData = {
            offer_id: this.offerID,
            dsp_security_param: this.csrf
          }
          $.ajax({
            url: '/offer/offer-update-info',
            data: ajaxData,
            type: 'post',
            success: function (result) {
              that.channel = result.data.channel
              // 1
              that.ruleForm.campaignOwner = result.data.campaign_owner
              that.ruleForm.advertiser = result.data.sponsor
              that.ruleForm.attributeProvider = result.data.att_pro
              // 2
              that.ruleForm.platform = result.data.platform
              that.ruleForm.storeUrl = result.data.final_url
              that.ruleForm.title = result.data.title
              that.ruleForm.desc = result.data.desc
              that.ruleForm.name = result.data.pkg_name
              that.ruleForm.category = result.data.category_id
              that.ruleForm.trackingUrl = result.data.tracking_url
              that.ruleForm.schedule = result.data.delivery_status
              var deliveryDate = []
              deliveryDate.push(result.data.delivery_start_day)
              deliveryDate.push(result.data.delivery_end_day)
              that.ruleForm.deliveryDate = deliveryDate
              that.ruleForm.deliveryWeek = JSON.parse(result.data.delivery_week)
              that.ruleForm.deliveryHour = JSON.parse(result.data.delivery_hour)
              that.ruleForm.comment = result.data.comment
              // 3
              that.ruleForm.payout = Number(result.data.payout)
              that.ruleForm.dailyCap = Number(result.data.daily_cap)
              that.ruleForm.totalCap = Number(result.data.total_cap)
              // 4
              that.ruleForm.deviceType = result.data.device_target
              that.ruleForm.specificDevice = JSON.parse(result.data.specific_device)
              that.ruleForm.minOSversion = result.data.min_os_version
              that.ruleForm.networkStatus = result.data.network_environment
              that.ruleForm.countryType = result.data.country_type
              that.ruleForm.country = result.data.country
              // 5
              that.ruleForm.iconList.push(result.data.icon)
              that.ruleForm.imageList = result.data.image
              that.ruleForm.videoList = result.data.video
              // 
              that.showCountryFun()
            }
          })
        }
      },
      showCountryFun () {
        this.showCountry = false
        if (this.ruleForm.countryType !== '') {
          if (this.ruleForm.countryType !== '1') {
            this.showCountry = true
          }
        }
      },
      changeDeviceType () {
        this.ruleForm.specificDevice.splice(0)
      },
      changePlatform () {
        // 置空
        var that = this
        that.options.deviceType.splice(0)
        that.options.category.splice(0)
        that.options.minOSversion.splice(0)
        that.ruleForm.deviceType = ''
        that.ruleForm.category = ''
        that.ruleForm.minOSversion = ''
      },
      changeCountryType () {
        this.ruleForm.country.splice(0)
        this.showCountryFun()
      },
      judeChannel (newval) {
        var that = this
        this.options.attributeProvider.map(function (ele) {
          if (newval.toString() === ele.value) {
            that.channel = ele.channel
          }
        })
      },
      storeUrlFocus () {
        this.storeUrlFlag = true
      },
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
            that.options.minOSversionBase = result.data.version
            // category
            that.options.categoryBase = result.data.category
            // 
            that.getUpdateInfo()
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
                    type: null,
                    mime_type: type,
                    key: result.key,
                    ratio: fileData.ratio
                  }
                  if (type === 'icon') {
                    downData.type = '1'
                  }
                  if (type === 'image') {
                    downData.type = '2'
                  }
                  if (type === 'video') {
                    downData.type = '3'
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
        // 权宜之策，暂时不删除s3文件
        photoKey = null
        if (photoKey) {
          s3.deleteObject({ Key: photoKey }, function (err, result) {
            if (err) {
              // console.log(err)
              that.$message.error(ruleLanguagePackage.s3DeleteFile)
            } else {
              // console.log(result)
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
                type: '1',
                mime_type: type,
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
              type: '2',
              mime_type: type,
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
              type: '3',
              mime_type: type,
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
        var that = this
        var ajaxData = {
          offer_id: that.offerID,
          channel: that.channel,
          dsp_security_param: that.csrf,
          // 1
          campaign_owner: that.ruleForm.campaignOwner,
          sponsor: that.ruleForm.advertiser,
          att_pro: that.ruleForm.attributeProvider,
          // 2
          platform: that.ruleForm.platform,
          final_url: that.ruleForm.storeUrl,
          title: that.ruleForm.title,
          desc: that.ruleForm.desc,
          pkg_name: that.ruleForm.name,
          category_id: that.ruleForm.category,
          tracking_url: that.ruleForm.trackingUrl,
          delivery_status: that.ruleForm.schedule,
          delivery_start_data: that.ruleForm.deliveryDate[0],
          delivery_end_data: that.ruleForm.deliveryDate[1],
          delivery_week: that.ruleForm.deliveryWeek,
          delivery_hour: that.ruleForm.deliveryHour,
          comment: that.ruleForm.comment,
          // 3
          payout: that.ruleForm.payout,
          daily_cap: that.ruleForm.dailyCap,
          total_cap: that.ruleForm.totalCap,
          // 4
          device_target: that.ruleForm.deviceType,
          specific_device: that.ruleForm.specificDevice,
          min_os_version: that.ruleForm.minOSversion,
          network_environment: that.ruleForm.networkStatus,
          country_type: that.ruleForm.countryType,
          country: that.ruleForm.country,
          // 5
          icon: that.ruleForm.iconList,
          image: that.ruleForm.imageList,
          video: that.ruleForm.videoList
        }
        if (that.ruleForm.countryType === '1') {
          ajaxData.country.splice(0)
        }
        console.log(ajaxData)
        if (that.pageType === 'create') {
          $.ajax({
            url: '/offer/offer-create',
            type: 'post',
            data: ajaxData,
            success: function (result) {
              if (result.status === 1) {
                window.location.href = '/offer/offer-index'
              } else {
                that.$message.error(result.info)
              }
            },
            error: function (result) {
              console.log(result)
            }
          })
        }
        if (that.pageType === 'update') {
          $.ajax({
            url: '/offer/offer-update',
            type: 'post',
            data: ajaxData,
            success: function (result) {
              if (result.status === 1) {
                window.location.href = '/offer/offer-index'
              } else {
                that.$message.error(result.info)
              }
            },
            error: function (result) {
              console.log(result)
            }
          })
        }
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
    background: #fff;
    opacity: 1;
    border-radius: 50%;
    font-size: 14px;
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
    border-radius: 4px;
  }
  .judeUrl-box{
    margin-bottom: 20px;
    padding: 10px;
    border: 1px solid #dcdfe6;
    border-radius: 4px;
    word-wrap: break-word;
  }
  .judeUrl-font{
    border: 1px solid red;
  }
</style>