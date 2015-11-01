<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
<title>Aplikasi Pendataan Dinas Pendidikan Rembang </title>
        <!--[if lt IE 9]>
          <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

<link href="<?=base_url()?>assets/template/v2/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?=base_url()?>assets/template/v2/css/justified-nav.css" rel="stylesheet" type="text/css" />
<link href="<?=base_url()?>assets/template/v2/css/style.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?=base_url()?>assets/template/fingers/js/jquery-1.4.3.min.js"></script>  
<script type="text/javascript" src="<?=base_url()?>assets/template/fingers/components/reveal/jquery.reveal.js"></script>   
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

<script type="text/javascript">
//google maps GIS 1.1.b by desrizal
//dibuat tanggal 8 Jan 2011
var peta;
var pertama = 0;
//var jenis = "restoran";
var judulx = new Array();
var desx = new Array();
var i;
var url;
var gambar_tanda;

function peta_awal(){
    var rembang = new google.maps.LatLng(-6.708609147163017, 111.33379555307329);
    var petaoption = {
        zoom: 14,
        center: rembang,
        mapTypeId: google.maps.MapTypeId.ROADMAP
        };
    peta = new google.maps.Map(document.getElementById("petaku"),petaoption);    
    ambildatabase('<?=$this->session->userdata("id_school");?>');
}
function kasihtanda(lokasi){
    //set_icon(jenis);
    tanda = new google.maps.Marker({
            position: lokasi,
            map: peta,
            icon: gambar_tanda
    });
    $("#lintang").val(lokasi.lat());
    $("#bujur").val(lokasi.lng());
}
function set_icon(jenisnya){
    switch(jenisnya){
        case "restoran":
            gambar_tanda = '<?=base_url()?>assets/template/fingers/images/icon/peta/embassy.png';
            break;
        case "airport":
            gambar_tanda = '<?=base_url()?>assets/template/fingers/images/icon/peta/embassy.png';
            break;
        case  "sekolah":
            gambar_tanda = '<?=base_url()?>assets/template/fingers/images/icon/peta/embassy.png';
            break;
    }
}

function setjenis(jns){
    jenis = jns;
}

function setinfo(petak, nomor){
    google.maps.event.addListener(petak, 'click', function() {    
        $('#myModal').html('<h1>'+judulx[nomor]+'</h1><p>'+desx[nomor]+'</p><a class="close-reveal-modal">&#215;</a>');     
        $("#kliks").click();
    });
}

function ambildatabase(id){
    $.ajax({
        type: "POST",
        url: "<?=base_url()?>peta/getPeta/",
        dataType: 'json',
        cache: false,
        success: function(msg){
            for(i=0;i<msg.wilayah.petak.length;i++){
                judulx[i] = msg.wilayah.petak[i].judul;
                desx[i] = msg.wilayah.petak[i].deskripsi;

                set_icon(msg.wilayah.petak[i].jenis);
                var point = new google.maps.LatLng(
                    parseFloat(msg.wilayah.petak[i].x),
                    parseFloat(msg.wilayah.petak[i].y));
                tanda = new google.maps.Marker({
                    position: point,
                    map: peta,
                    icon: gambar_tanda
                });
                setinfo(tanda,i);

            }
        }
    });
}
$(document).ready(function(){
  peta_awal();  
});
</script>
 <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body >

<div class="container">

      <div class="masthead row">
        <div class="col-lg-8">
            <img src="<?=base_url()?>assets/logo/diknas.png" width="400" height="80"/>
        </div>
        <div class="col-lg-4">
               <!--<div class="">Kontak Kami <br>
                Telephone : 0295-6917172 <br>
                Email : admin@dinpendik.rembangkab.go.id
              </div>-->
        </div>

     </div>
<div class="row">
        <div class="col-lg-8 boxpeta">
          <div id="petaku" style="height:450px">ini peta</div>
          <!--<form action="<?=base_url()?>home/submit" method="POST" enctype="multipart/form-data">
          <span class="kosongs"><label class="tabeless">Jenis Viewer</label><?php echo form_dropdown('jenis_view', $viewer,$viewene); ?></span>                                                            
          <span class="kiri"><?php echo form_submit('submit', 'Generate!','class="kiri tombole uibutton submit_form"'); ?></span>
          <?php $this->load->view($tabele); ?>-->
        </div>

        <div class="col-lg-4 margintop-20">
          <div class="atas well">
            <h2>SIM PROFIL PENDIDIKAN</h2>
            <p>Sistem Informasi Profil Pendidikan adalah Aplikasi yang terdiri dari data Satuan Pendidikan, data PTK, Siswa dan Sarpras Pada Dinas Pendidikan Kab. Rembang secara umum</p>
            <p><a class="btn btn-primary" href="<?php echo base_url()?>home/login" role="button">LOGIN PROFIL</a></p>
            <h2>SIM PTK </h2>
            <p>Sistem Informasi PTK adalah Aplikasi yang di dalamnya terdiri dari PTK pada Dinas Pendidikan Kab. Rembang</p>
            <p><a class="btn btn-primary" href="<?php echo base_url()?>home/login_ptk" role="button">LOGIN PTK</a></p>
            <h2>SIM PAUD</h2>
            <p>Sistem Informasi Pendidikan Non Formal adalah Aplikasi yang di dalamnya terdiri dari data PAUD dan Kejar Paket Kab. Rembang</p>
            <p><a class="btn btn-primary" href="<?php echo base_url()?>home/login_paud" role="button">LOGIN PAUD</a></p> <br>
          </div>
          <div class="bawah well">
            <h2>UPDATE TERAKHIR</h2><br/>
            <?php
              echo "<ol>";
              foreach($usere as $dt_usere)
              {
                echo "<li><b>".$dt_usere->nama_school." </b>[".$dt_usere->date_token."]</li>";
              }
              echo "</ol>";
            ?>
          </div>	        
        </div>	
      </div>	
</div>

<footer class="footer">
<div class="container">
<div class="row">
    <div class="col-lg-12">
      <div class="col-md-3">
        <ul class="nav nav-pills nav-stacked">
          <li><a href="#">Hubungi Kami</a><br>
            Dinas Pendidikan Rembang <br>
            Alamat : Jl. Rembang - Blora Km . 02 <br>
            Telphone : 0295 - 691324, <br>
            FAX : 0295 - 691324 <br>
            website : dinpendik.rembangkab.go.id<br>
            Email : dinpendik@rembangkab.go.id

          </li>
          <!--<li><a href="#">Blog</a></li> -->
        </ul>
      </div>
      <!--<div class="col-md-3">
        <ul class="nav nav-pills nav-stacked">
          

          <li><a href="#">Product for Windows</a></li>
        </ul>
      </div>-->
      <div class="col-md-3">
        <ul class="nav nav-pills nav-stacked">
          
          <!--<li><a href="#">Presentations</a></li>-->          
        </ul>
      </div>
      <div class="col-md-3">
        <ul class="nav nav-pills nav-stacked">
          <li><a href="#">Website Terkait</a></li><br>
          <a href="http://www.kemdikbud.go.id">Kemdikbud</a><br>
          <a href="http://www.pdkjateng.go.id">PDK Jateng</a><br>
          <a href="http://www.rembangkab.go.id">Pemerintah Kab. Rembang</a><br>
          <a href="http://www.dinpendik.rembangkab.go.id">Dinpendik Kab Rembang</a><br>
          <a href="http://www.refs.data.kemdikbud.go.id">Data Referensi Pendidikan</a><br>
          <a href="http://www.nisn.data.kemdikbud.go.id">NISN Kemdikbud </a><br>
         
          
        </ul>
      </div>  
    </div>	
</div>

        <p class="credit">&copy; Copyright 2014  All Rights Reserved <b>Dinas Pendidikan Kabupaten Rembang</b> supported <span class="tip"><a  href="#" title="Ionlinesoft" >Ionlinesoft</a> </span><span><b>[<a class="login" href="<?=base_url()?>home/login">Login</a>]</b></span></p>
</div>
</footer>

<!--        
<div id="logo"><img src="<?=base_url()?>assets/logo/diknas.png" width="800px"/></div><br/>
<a href="#" data-reveal-id="myModal" data-animation="fadeAndPop" data-animationspeed="300" data-closeonbackgroundclick="true" data-dismissmodalclass="close-reveal-modal" id="kliks" style="display:none;">Click for a modal</a>
  <div id="petaku" style="width:800px; height:450px">ini peta</div>
  <div id="myModal" class="reveal-modal">
            <h1>Reveal Modal Goodness</h1>
            <p>This is a default modal in all its glory, but any of the styles here can easily be changed in the CSS.</p>
            <a class="close-reveal-modal">&#215;</a>
        </div>

<div class="clear"></div>
<div id="versionBar" >
  <div class="copyright" > &copy; Copyright 2014  All Rights Reserved <b>Dinas Pendidikan Kabupaten Rembang</b> supported <span class="tip"><a  href="#" title="Ionlinesoft" >Ionlinesoft</a> </span><span><b>[<a class="login" href="<?=base_url()?>home/login">Login</a>]</b></span> </div>

</div>
-->
</body>
</html>
