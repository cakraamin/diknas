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

<!--<script type="text/javascript" src="<?=base_url()?>assets/template/fingers/js/jquery-1.4.3.min.js"></script>  
<script type="text/javascript" src="<?=base_url()?>assets/template/fingers/components/reveal/jquery.reveal.js"></script> 
<script type="text/javascript" src="<?=base_url()?>assets/template/fingers/components/ui/jquery.ui.min.js"></script> -->
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<style type="text/css">
  #tabs {
    width: 95%;
    margin-left: auto;
    margin-right: auto;
    margin-top: 10px;
}
</style>
<?php echo $map['js']; ?> 
</head>
<body >

<div class="container">

      <div class="masthead row">
        <div class="col-lg-8">
            <img src="<?=base_url()?>assets/logo/diknas.png" width="400" height="80"/>
        </div>
        <div class="col-lg-4">            
        </div>

     </div>
<div class="row">
        <div class="col-lg-8">
          <div class="row boxpeta">
            <div id="petaku" style="height:450px"><?php echo $map['html']; ?></div>
          </div>
          <div class="row boxpeta">
            <form action="<?=base_url()?>home/submit" method="POST" enctype="multipart/form-data">
            <span class="kosongs"><label class="tabeless" style="float:left; padding-top:4px; padding-right:10px;">Jenis Viewer</label><?php echo form_dropdown('jenis_view', $viewer,$viewene,'class="form-control" style="width:50%; float:left; margin-right:10px;"'); ?></span>                                                            
            <span class="kiri"> <?php echo form_submit('submit', 'Generate!','class="kiri tombole btn btn-default"'); ?></span>
            <?php $this->load->view($tabele); ?>
          </div>                    
        </div>

        <div class="col-lg-4 margintop-20">
          <div class="atas well">
            <h2>SIM PROFIL</h2>
            <p>Sistem Informasi Profil adalah Aplikasi yang terdiri dari data sekolah, data guru dan siswa Pada Dinas Pendidikan Kab. Rembang secara umum</p>
            <p><a class="btn btn-primary" href="<?php echo base_url()?>home/login" role="button">LOGIN PROFIL</a></p>
            <!--<h2>SIM PTK </h2>
            <p>Sistem Informasi PTK adalah aplikasi yang di dalamnya terdiri dari data sekolah pada Dinas Pendidikan kab. Rembang</p>
            <p><a class="btn btn-primary" href="<?php echo base_url()?>home/login_ptk" role="button">LOGIN PTK</a></p>
            <h2>SIM PAUD</h2>
            <p>Sistem Informasi Paud adalah Aplikasi yang di dalamnya terdiri dari data paud/ kelompok belajar dan kejar Paket</p>
            <p><a class="btn btn-primary" href="<?php echo base_url()?>home/login_paud" role="button">LOGIN PAUD</a></p> <br>
          </div>-->
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
          <a href="http://www.kemdikbud.go.id">Kementerian Pendidkan</a><br>
          <a href="http://www.rembangkab.go.id">Pemerintah Kabupaten Rembang</a><br>
          <a href="http://www.dinpendik.rembangkab.go.id">Kementerian Pendidkan</a><br>
          <a href="http://www.refs.data.kemdikbud.go.id">Data Referesinsi Pendidikan</a><br>
          <a href="http://www.nisn.data.kemdikbud.go.id">Kementerian Pendidkan</a><br>
          <a href="http://www.npsn.data.kemdikbud.go.id">Kementerian Pendidkan</a><br>
          <a href="http://www.padamu.siap.web.id">Padamu Negeri BPSDPMP </a>

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
