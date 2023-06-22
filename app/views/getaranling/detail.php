<div id="appCapsule">
   <div class="row">
      <div class="col-12">
         <div class="card">
            <div class="modal-header">
               <h6 class="modal-title" id="myModalLabel">Detail Data Lapangan</h6>
               <a href="<?= base_url;?>/getaranling/data" class="item">
                  <div class="icon-box bg-danger">
                     <i class="fa-solid fa-xmark"></i>
                  </div>
               </a>
            </div>
            <?= $data['template'] ?>
         </div>
      </div>
   </div>
</div>
<div class="btnBottom">
   <div class="btnTengah" onclick="location.href='<?= base_url;?>/getaranling/add_data'"></a></div>
   <div class="btnMenu">
      <ul>
         <li style="--i:0.1s;"><a href="<?= base_url;?>/home"><i class="fa-solid fa-gauge"></i></a></li>
         <li style="--i:0.2s;"><a href="<?= base_url;?>/getaranling"><i class="fa-solid fa-house"></i></a></li>
         <li></li>
         <li style="--i:0.2s;"><a href="<?= base_url;?>/getaranling/data"><i class="fa-solid fa-file-lines"></i></a>
         </li>
         <li style="--i:0.1s;"><a href="<?= base_url;?>/profile"><i class="fa-solid fa-user"></i></a></li>
      </ul>
   </div>
</div>
<script>
$('#cahaya').empty();

var id_kat = '<?= $data['id_kat'] ?>'

var e = '<?= $data['pengukuran'] ?>'
if (id_kat !== 14 || id_kat !== 19) {
   $('#getaran').empty();
   var html = "-";
   if (e != null) {
      var text = JSON.parse(e.replace(/;/g, ' : '));
      var html = '<div class="row">'

      $.each(text, function(key, value) {
         html += '<div class="col-12 border">'
         html += '<span class="text-nowrap">' + key + " = " + value + '</span>'
         html += '</div>'
      });
      html += '</div>'
   }
   $('#getaran').html(html);
} else {
   $('#getaran').empty();
}

$.each(text, function(key, value) {
   html += '<div class="col-sm-6 border">'
   $.each(value, function(k, v) {
      html += '<span>' + k + " = " + v + ', ' + '</span>'
   })
   html += '</div>'
});
html += '</div>'
$('#cahaya').html(html);

// function fotoD(file) {
//    var path = 'http://localhost/eng/backend/public/dokumentasi/'
//    var filename = file.getAttribute("value");

//    var file_path = path + filename;
//    var a = document.createElement('a');
//    a.href = file_path;
//    a.download = file_path.substr(file_path.lastIndexOf('/') + 1);
//    document.body.appendChild(a);
//    a.click();
//    document.body.removeChild(a);
// }
</script>