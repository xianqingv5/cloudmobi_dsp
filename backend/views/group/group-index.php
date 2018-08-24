<div>
group
</div>
<script>
  var csrf = document.querySelector('#spp_security').value
  $.ajax({
    url: '/admin/group/index',
    type: 'post',
    data: {
      dsp_security_param: csrf
    },
    success: function (result) {
      console.log(result)
    }
  })
</script>