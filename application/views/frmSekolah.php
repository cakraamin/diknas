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

function getJenjang()
{
  var nilai = $('#jenjang').val();
  var pecah = nilai.split("-");
  if(pecah[0] == 4){
    $('.smk').show();
  }else{
    $('.smk').hide();
  }
}

function setStatusSkul()
{
  var nilai = $('#statuse').val();  
  if(nilai == 2){
    $('.swasta').show();
  }else{
    $('.swasta').hide();
  } 
}

function peta_awal(){
    var rembang = new google.maps.LatLng(-6.708609147163017, 111.33379555307329);
    var petaoption = {
        zoom: 14,
        center: rembang,
        mapTypeId: google.maps.MapTypeId.ROADMAP
        };
    peta = new google.maps.Map(document.getElementById("petakun"),petaoption);
    google.maps.event.addListener(peta,'click',function(event){
        kasihtanda(event.latLng);
    });
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
    $("#lintange").val(lokasi.lat());
    $("#bujur").val(lokasi.lng());
    $("#bujure").val(lokasi.lng());
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
        $("#jendelainfo").fadeIn();
        $("#teksjudul").html(judulx[nomor]);
        $("#teksdes").html(desx[nomor]);
    });
}

function ambildatabase(id){
    $.ajax({
        type: "POST",
        url: site+"peta/getPeta/"+id,
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
<div class="topcolumn">
            <div class="logo"></div>                          
          </div>  
          <div class="clear"></div>          
                    <div class="clear"></div>                    
                  <?=$this->message->display();?>
                  <div class="onecolumn" >
                  <div class="header"><span ><span class="ico  gray user"></span><?=$ket?></span> </div><!-- End header --> 
                  <div class="clear"></div>
                  <div class="content" >                      
                    <div class="tab_container" >

                          <div id="tab1" class="tab_content"> 
                              <div class="load_page">                        
                                 
                                <div class="formEl_b">  
                                <form id="validation" action="<?=base_url()?>sekolah/<?=$link?>" method="POST"> 
                                <fieldset >
                                <legend><?=$ket?> <span class="small s_color">( <?=$jenis?> )</span></legend>                                      
                                      <div class="section">
                                      <label> Jenjang Sekolah  <small>Jenjang</small></label>
                                      <div>
                                              <?php
                                              $jenjang = $this->arey->getSelekJenjang($kueri->jenjang_school);
                                              $lengkap = $kueri->jenjang_school."-".$kueri->tingkat_school;
                                              $selekj = (isset($lengkap))?$lengkap:"";
                                              $jpj = "data-placeholder='Jenjang Sekolah...' class='chzn-select' onChange='getJenjang()' id='jenjang'";
                                              echo form_dropdown('jenjang', $jenjang, $selekj,$jpj);
                                              ?>
                                      </div>                                      
                                      <label> Nama Kepala Sekolah  <small>Nama</small></label>
                                      <div>
                                              <?php
                                              $selekk = (isset($kueri->id_guru))?$kueri->id_guru:"";
                                              $jpk = "data-placeholder='Nama Guru...' class='chzn-select'";
                                              echo form_dropdown('kepala', $kepala, $selekk,$jpk);
                                              ?>
                                      <span class="f_help"> Isikan Nama Kepala Sekolah. </span> 
                                      </div>                                                                              
                                      </div>                                                                            
                                      <div class="section">
                                      <label> Nama Sekolah  <small>Nama</small></label>
                                      <div class="alluppercase">
                                      <input type="text"  name="nama" id="nama"  class="validate[required] large" value="<?php if(isset($kueri->nama_school)){ echo $kueri->nama_school; } ?>" disabled="disabled"/>
                                      <span class="f_help"> Isikan Nama Sekolah. </span> 
                                      </div>
                                      <label> NPSN Sekolah  <small>NPSN</small></label>
                                      <div class="numericonly">
                                      <input type="text"  name="npsn" id="npsn"  class="validate[required,minSize[8],maxSize[8]] medium" value="<?php if(isset($kueri->npsn_school)){ echo $kueri->npsn_school; } ?>" disabled="disabled"/>
                                      <span class="f_help"> Isikan Nama Sekolah. </span>                                       
                                      </div>
                                      <label> NSS Sekolah  <small>NSS</small></label>
                                      <div class="numericonly">
                                      <input type="text"  name="nss" id="nss"  class="validate[required] medium" value="<?php if(isset($kueri->nss_school)){ echo $kueri->nss_school; } ?>"/>
                                      <span class="f_help"> Isikan Nama Sekolah. </span> 
                                      </div>
                                      <label> ISO Sekolah  <small>ISO</small></label>
                                      <div>
                                              <?php
                                              $selekis = (isset($kueri->iso_school))?$kueri->iso_school:"";                                          
                                              echo form_dropdown('iso', $iso, $selekis);
                                              ?>
                                      </div>
                                      </div>
                                      <div class="section">
                                      <label> Gugus Sekolah  <small>Gugus</small></label>
                                      <div>
                                              <?php
                                              $selekgu = (isset($kueri->gugus_school))?$kueri->gugus_school:"";
                                              $jpgu = 'class="large"';
                                              echo form_dropdown('gugus_school', $gugus, $selekgu,$jpgu);
                                              ?>
                                      </div>                                      
                                      </div> 
                                      <div class="section">
                                      <label> Melaksanakan MBS  </label>
                                      <div>
                                              <?php
                                              $selekmbs = (isset($kueri->mbs_school))?$kueri->mbs_school:"";
                                              $jpmbs = 'class="large"';
                                              echo form_dropdown('mbs_school', $inklusi, $selekmbs,$jpmbs);
                                              ?>
                                      </div>                                      
                                      </div> 
                                      <div class="section">
                                      <label> Kurikulum yang Digunakan  <small>Kurikulum</small></label>
                                      <div>
                                              <?php
                                              $selekkur = (isset($kueri->kurikulum_school))?$kueri->kurikulum_school:"";
                                              $jpkur = 'class="large"';
                                              echo form_dropdown('kurikulum_school', $kurikulum, $selekkur,$jpkur);
                                              ?>
                                      </div>                                      
                                      </div> 
                                      <?php
                                      $smk = ($kueri->jenjang_school == 4)?'':'style="display:none;"';                                      
                                      ?>
                                      <div class="section smk" <?=$smk?>>
                                      <label> Kelompok  <small>Khusus SMK</small></label>
                                      <div>
                                              <?php
                                              $pecah = explode("-", $kueri->kelompok_school);                                              
                                              foreach($kelompok as $key => $dt_kelompok)
                                              {
                                                $ketemu = array_search($key, $pecah);
                                                $ktmu = ($ketemu != "")?"checked='checked'":"";                                                
                                                ?>
                                                <input type="checkbox" name="kelompok[]" id="checkNormal<?=$key?>"  value="<?=$key?>" class="ck" <?=$ktmu?>/><label for="checkNormal<?=$key?>"><?=$dt_kelompok?></label><br/>
                                                <?php
                                              }
                                              /*$selekk = (isset($kueri->kelompok_school))?$kueri->kelompok_school:"";
                                              $jpk = 'class="large"';
                                              echo form_dropdown('kelompok', $kelompok, $selekk,$jpk);*/                                              
                                              ?>
                                      </div>                                      
                                      </div>                                      
                                      <div class="section">
                                      <label> Alamat Sekolah  <small>Alamat</small></label>
                                      <div>
                                      <textarea name="alamat" id="alamat" cols="50" rows="5"><?php if(isset($kueri->alamat_school)){ echo $kueri->alamat_school; } ?></textarea>
                                      </div>
                                      <label> Kecamatan  </label>
                                      <div>
                                              <?php
                                              $selekkec = (isset($kueri->id_kecamatan))?$kueri->id_kecamatan:"";                                              
                                              $jpkec = "data-placeholder='Kecamatan...' class='chzn-select'";
                                              echo form_dropdown('kecamatan', $kecamatan, $selekkec,$jpkec);
                                              ?>
                                      </div>
                                      </div>
                                      <div class="section">
                                      <label> Desa/Kelurahan Sekolah  <small>Desa</small></label>
                                      <div>
                                      <input type="text"  name="desa" id="desa"  class="validate[required] full" value="<?php if(isset($kueri->desa_school)){ echo $kueri->desa_school; } ?>"/>
                                      <span class="f_help"> Isikan Desa Sekolah. </span> 
                                      </div>                                      
                                      <div>
                                          <?php                                                         
                                          $pilih = ($kueri->desa_pil == 1)?'checked="checked"':'';
                                          $pilih1 = ($kueri->desa_pil == 2)?'checked="checked"':'';                                          
                                          ?>
                                          <div>
                                              <input type="radio" name="desa_pil" id="desa_pil-1" value="1"  class="ck" <?=$pilih?>/>
                                              <label for="desa_pil-1">Desa</label>
                                          </div>
                                          <div>
                                              <input type="radio" name="desa_pil" id="desa_pil-2" value="2"  class="ck" <?=$pilih1?>/>
                                              <label for="desa_pil-2" >Kelurahan</label>
                                          </div>                                          
                                      </div>
                                      <label>Klasifikasi Geografis <small>Pilih salah satu</small></label>   
                                      <div>                      
                                        <?php
                                        $selekklas = (isset($kueri->klasifikasi_school))?$kueri->klasifikasi_school:"";                                        
                                        echo form_dropdown('klasifikasi', $klasifikasi, $selekklas);
                                        ?>
                                      </div><br/>
                                      <label> Kode POS <small>Kode POS</small></label>
                                      <div class="numericonly">
                                      <input type="text"  name="kode_pos" id="kode_pos"  class="validate[required] medium" value="<?php if(isset($kueri->kode_pos)){ echo $kueri->kode_pos; } ?>"/>
                                      </div>
                                      <label> Kode Area/Telp <small>Kode Area/Telp</small></label>
                                      <div class="numericonly">
                                      <input type="text"  name="kode_area_tlp" id="kode_area_tlp"  class="medium" value="<?php if(isset($kueri->kode_area_tlp)){ echo $kueri->kode_area_tlp; } ?>"/>
                                      </div>
                                      <label> Kode Area/Fax <small>Kode Area/Fax</small></label>
                                      <div class="numericonly">
                                      <input type="text"  name="kode_area_fax" id="kode_area_fax"  class="medium" value="<?php if(isset($kueri->kode_area_fax)){ echo $kueri->kode_area_fax; } ?>"/>
                                      </div>
                                      <label> Akses Internet  <small>Akses Internet</small></label>                                      
                                      <div>
                                          <?php                                          
                                          $pilihs = ($kueri->akses_inet == 1)?'checked="checked"':'';
                                          $pilihs1 = ($kueri->akses_inet == 2)?'checked="checked"':'';                                        
                                          ?>
                                          <div>
                                              <input type="radio" name="akses_inet" id="inet-1" value="1"  class="ck" <?=$pilihs?>/>
                                              <label for="inet-1">Ada</label>
                                          </div>
                                          <div>
                                              <input type="radio" name="akses_inet" id="inet-2" value="2"  class="ck" <?=$pilihs1?>/>
                                              <label for="inet-2" >Tidak Ada</label>
                                          </div>                                          
                                      </div>
                                      <div>
                                              <?php
                                              $selekprov = (isset($kueri->provider))?$kueri->provider:"";
                                              $jpprov = 'class="large"';
                                              echo form_dropdown('provider', $provider, $selekprov,$jpprov);
                                              ?>
                                      </div>
                                      </div>
                                      <div class="section">
                                      <label> E-mail <small>E-mail</small></label>
                                      <div>
                                      <input type="text"  name="email" id="email"  class="validate[custom[email],maxSize[30]] medium" value="<?php if(isset($kueri->email)){ echo $kueri->email; } ?>"/>
                                      </div>
                                      <label> Website <small>Website</small></label>
                                      <div>
                                      <input type="text"  name="website" id="website"  class="validate[custom[url]] medium" value="<?php if(isset($kueri->website)){ echo $kueri->website; } ?>"/>
                                      </div>
                                      <label> Jarak Sekolah Sejenis <small>Jarak Sekolah Sejenis dalam KM</small></label>
                                      <div class="numericonly">
                                      <input type="text"  name="jarak_school" id="jarak_school"  class="validate[required] medium" value="<?php if(isset($kueri->jarak_school)){ echo $kueri->jarak_school; } ?>"/>
                                      </div>
                                      </div>   
                                      <div class="section">
                                      <label> Status Sekolah </label>
                                      <div>
                                              <?php                                              
                                              $selekstat = (isset($kueri->status_school))?$kueri->status_school:"";
                                              $jpstat = 'class="large" onChange="setStatusSkul()" id="statuse"';
                                              echo form_dropdown('status', $status, $selekstat,$jpstat);
                                              ?>
                                      </div>                                                                            
                                      </div>   
                                      <?php
                                      $status = ($kueri->status_school == 2)?'':'style="display:none;"';                                      
                                      ?> 
                                      <div class="section alluppercase swasta" <?=$status?>>
                                      <label> Nama Yayasan  <small>Nama</small></label>
                                      <div>
                                      <input type="text"  name="nama_y" id="nama_y"  class="validate[required] large" value="<?php if(isset($kueri->nama_y)){ echo $kueri->nama_y; } ?>"/>
                                      <span class="f_help"> Isikan Nama Yayasan. </span> 
                                      </div>
                                      <label> Alamat Yayasan  <small>Alamat</small></label>
                                      <div>
                                      <textarea name="alamat_y" id="alamat_y" cols="50" rows="5"><?php if(isset($kueri->alamat_y)){ echo $kueri->alamat_y; } ?></textarea>
                                      </div>
                                      <label> Kecamatan  </label>
                                      <div>
                                              <?php
                                              $selekkec = (isset($kueri->id_kecamatan_y))?$kueri->id_kecamatan_y:"";
                                              $jpkec = 'class="large"';
                                              echo form_dropdown('kecamatan_y', $kecamatan, $selekkec,$jpkec);
                                              ?>
                                      </div>
                                      <label> Desa/Kelurahan Yayasan  <small>Desa</small></label>
                                      <div class="alluppercase">
                                      <input type="text"  name="desa_y" id="desa_y"  class="validate[required] full" value="<?php if(isset($kueri->desa_y)){ echo $kueri->desa_y; } ?>"/>
                                      <span class="f_help"> Isikan Desa Yayasan. </span> 
                                      </div>                                                                            
                                      <label> No. Telp <small>No. Telp</small></label>
                                      <div class="numericonly">
                                      <input type="text"  name="telp_y" id="telp_y"  class="validate[required] medium" value="<?php if(isset($kueri->telp_y)){ echo $kueri->telp_y; } ?>"/>
                                      </div>                                                                                                                
                                      <label> Akte Pendirian <small>Akte Pendirian</small></label>
                                      <div>
                                      No. <input type="text"  name="no_akte" id="no_akte"  class="validate[required] medium" value="<?php if(isset($kueri->jarak_school)){ echo $kueri->jarak_school; } ?>"/><br/><br/>
                                      Tgl/Bln/Thn <input type="text"  name="tgl_akte" id="tgl_akte"  class="validate[required] medium" value="<?php if(isset($kueri->jarak_school)){ echo $kueri->jarak_school; } ?>"/>
                                      </div>
                                      <label> Kelompok Yayasan  </label>
                                      <div>
                                              <?php
                                              $selekkel = (isset($kueri->kelompok_y))?$kueri->kelompok_y:"";
                                              $jpkel = 'class="large"';
                                              echo form_dropdown('kelompok_y', $kelompoky, $selekkel,$jpkel);
                                              ?>
                                      </div>
                                      </div>
                                      <div class="section">
                                      <label> Tahun Pendirian </label>
                                      <div>
                                              <?php                                              
                                              $selekthn = (isset($kueri->tahun_diri))?$kueri->tahun_diri:""; 
                                              $jpthn = "data-placeholder='Tahun Pendirian...' class='chzn-select' medium";                                            
                                              echo form_dropdown('tahun', $tahun, $selekthn,$jpthn);
                                              ?>
                                      </div>                                                                            
                                      </div>   
                                      <div class="section">
                                      <label> Tahun Terakhir Renovasi </label>
                                      <div>
                                              <?php                                              
                                              $selekthnr = (isset($kueri->tahun_renov))?$kueri->tahun_renov:"";
                                              $jprenov = "data-placeholder='Tahun Renovasi...' class='chzn-select'";
                                              echo form_dropdown('tahun_renov', $tahun, $selekthnr,$jprenov);
                                              ?>
                                      </div>                                                                            
                                      </div>   
                                      <div class="section">
                                      <label> Akreditas Sekolah </label>
                                      <div>
                                              <?php                                              
                                              $selekakre = (isset($kueri->akre_school))?$kueri->akre_school:"";
                                              echo form_dropdown('akre_school', $akreditasi, $selekakre);
                                              ?>
                                      </div>
                                      <label> SK Akreditrasi <small>SK Akreditrasi</small></label>
                                      <div>
                                      <?php
                                      $akreditas = (isset($kueri->akte_akre))?$kueri->akte_akre:"";
                                      if($akreditas == "")
                                      {
                                        $sk_akre = "";
                                        $tgl_akre = "";
                                      }
                                      else
                                      {
                                        $pakre = explode("&", $akreditas);
                                        $sk_akre = $pakre[0];
                                        $tgl_akre = $pakre[1];
                                      }
                                      ?>                                        
                                      No. <input type="text"  name="sk_akre" id="sk_akre"  class="medium" value="<?=$sk_akre?>"/><br/><br/>
                                      Tgl/Bln/Thn <input type="text"  name="tgl_akre" id="tgl_akre"  class="medium" value="<?=$tgl_akre?>"/>
                                      </div>
                                      </div>                                         
                                      <div class="section">
                                      <label> Status Mutu </label>
                                      <div>
                                              <?php                                              
                                              $selekmutu = (isset($kueri->status_mutu))?$kueri->status_mutu:"";
                                              echo form_dropdown('status_mutu', $status_mutu, $selekmutu);
                                              ?>
                                      </div>                                      
                                      </div>   
                                      <?php
                                      if($kueri->jenjang_school == 2)
                                      {
                                        ?>
                                        <div class="section">
                                        <label> Kategori Sekolah(Khusus SMP) </label>
                                        <div>
                                                <?php                                              
                                                $selekkat = (isset($kueri->kategori_school))?$kueri->kategori_school:"";
                                                echo form_dropdown('kategori_school', $kategori, $selekkat);
                                                ?>
                                        </div>                                      
                                        </div>   
                                        <?php
                                      }
                                      ?>                                      
                                      <div class="section">
                                      <label> Waktu Penyelenggaraan </label>
                                      <div>
                                              <?php                                              
                                              $selekwaktu = (isset($kueri->waktu_school))?$kueri->waktu_school:"";
                                              echo form_dropdown('waktu_school', $waktu, $selekwaktu);
                                              ?>
                                      </div>                                      
                                      </div>   
                                      <?php
                                      if($kueri->jenjang_school == 4)
                                      {
                                        ?>
                                        <div class="section">
                                        <label> Tempat Penyelenggaraan Praktik(Khusus SMK) </label>
                                        <div>
                                                <?php                                              
                                                $selekwp = (isset($kueri->waktu_wp))?$kueri->waktu_wp:"";
                                                echo form_dropdown('waktu_wp', $waktuwp, $selekwp);
                                                ?>
                                        </div>                                      
                                        </div>   
                                        <?php
                                      }
                                      ?>
                                      <?php
                                      if($kueri->jenjang_school == 4)
                                      {
                                        ?>
                                        <div class="section">
                                        <label> Tempat Penyelenggaraan Prakerin(Khusus SMK) </label>
                                        <div>
                                                <?php                                              
                                                $selekwpr = (isset($kueri->waktu_pra))?$kueri->waktu_pra:"";
                                                echo form_dropdown('waktu_pra', $waktupra, $selekwpr);
                                                ?>
                                        </div>                                      
                                        </div>   
                                        <?php
                                      }
                                      ?>
                                      <!--baru-->
                                      <div class="section">
                                      <label> SK Terakhir Status Sekolah <small>SK Terakhir</small></label>
                                      <div>
                                      <?php
                                      $sk_status = (isset($kueri->sk_status))?$kueri->sk_status:"";
                                      if($sk_status == "")
                                      {
                                        $no_akte_ter = "";
                                        $tgl_akte_ter = "";
                                      }
                                      else
                                      {
                                        $pakskst = explode("&", $sk_status);
                                        $no_akte_ter = $pakskst[0];
                                        $tgl_akte_ter = $pakskst[1];
                                      }
                                      ?>
                                      No. <input type="text"  name="no_akte_ter" id="no_akte_ter"  class="medium" value="<?=$no_akte_ter?>"/><br/><br/>
                                      Tgl/Bln/Thn <input type="text"  name="tgl_akte_ter" id="tgl_akte_ter"  class="medium" value="<?=$tgl_akte_ter?>"/>
                                      </div>
                                      <label> Keterangan SK  </label>
                                      <div>
                                              <?php
                                              $selekket = (isset($kueri->ket_sk_status))?$kueri->ket_sk_status:"";
                                              $jpket = 'class="large"';
                                              echo form_dropdown('ket_sk', $ket_sk, $selekket,$jpket);
                                              ?>
                                      </div>
                                      </div>
                                      <div class="section">
                                      <label> Mengadakan Program Inklusi  </label>
                                      <div>
                                              <?php
                                              $selekink = (isset($kueri->inklusi))?$kueri->inklusi:"";
                                              $jpkink = 'class="large"';
                                              echo form_dropdown('inklusi', $inklusi, $selekink,$jpkink);
                                              ?>
                                      </div>
                                      <label> Mengadakan Program Inklusi <small>Inklusi</small></label>
                                      <div>
                                      <?php
                                      $sk_inklu = (isset($kueri->sk_inklusi))?$kueri->sk_inklusi:"";
                                      if($sk_inklu == "")
                                      {
                                        $no_akte_ink = "";
                                        $tgl_akte_ink = "";
                                      }
                                      else
                                      {
                                        $pakskink = explode("&", $sk_inklu);
                                        $no_akte_ink = $pakskink[0];
                                        $tgl_akte_ink = $pakskink[1];
                                      }
                                      ?>
                                      No. <input type="text"  name="no_akte_ink" id="no_akte_ink"  class="medium" value="<?=$no_akte_ink?>"/><br/><br/>
                                      Tgl/Bln/Thn <input type="text"  name="tgl_akte_ink" id="tgl_akte_ink"  class="medium" value="<?=$tgl_akte_ink?>"/>
                                      </div>                                      
                                      </div>
                                      <div class="section">
                                      <label> SK Pendirian Sekolah <small>SK Pendirian</small></label>
                                      <div>
                                      <?php
                                      $sk_pendi = (isset($kueri->sk_pendirian))?$kueri->sk_pendirian:"";
                                      if($sk_pendi == "")
                                      {
                                        $no_akte_pen = "";
                                        $tgl_akte_pen = "";
                                      }
                                      else
                                      {
                                        $pakspend = explode("&", $sk_pendi);
                                        $no_akte_pen = $pakspend[0];
                                        $tgl_akte_pen = $pakspend[1];
                                      }
                                      ?>
                                      No. <input type="text"  name="no_akte_pen" id="no_akte_pen"  class="validate[required] medium" value="<?=$no_akte_pen?>"/><br/><br/>
                                      Tgl/Bln/Thn <input type="text"  name="tgl_akte_pen" id="tgl_akte_pen"  class="validate[required] medium" value="<?=$tgl_akte_pen?>"/>
                                      </div>                                      
                                      </div>
                                      <!--      -->
                                      <div class="section">
                                      <label>&nbsp;</label>
                                      <div>
                                      <div id="petakun" style="width:400px; height:300px"></div>
                                      </div>                                                                            
                                      </div>
                                      <div class="section">
                                      <label> Titik Lintang  <small>Lintang</small></label>
                                      <div>
                                      <input type="hidden"  name="lintang" id="lintang" class="validate[required] medium" value="<?php if(isset($kueri->lintang_school)){ echo $kueri->lintang_school; } ?>"/>
                                      <input type="text"  name="lintange" id="lintange" class="validate[required] medium" value="<?php if(isset($kueri->lintang_school)){ echo $kueri->lintang_school; } ?>" disabled="disabled"/>
                                      <span class="f_help"> Isikan Titik Lintang Sekolah. </span> 
                                      </div>                                                                            
                                      </div>
                                      <div class="section">
                                      <label> Titik Bujur  <small>Bujur</small></label>
                                      <div>
                                      <input type="hidden"  name="bujur" id="bujur" class="validate[required] medium" value="<?php if(isset($kueri->bujur_school)){ echo $kueri->bujur_school; } ?>"/>
                                      <input type="text"  name="bujure" id="bujure" class="validate[required] medium" value="<?php if(isset($kueri->bujur_school)){ echo $kueri->bujur_school; } ?>" disabled="disabled"/>
                                      <span class="f_help"> Isikan Titik Bujur Sekolah. </span> 
                                      </div>                                                                            
                                      </div>
                                      <div class="section last">
                                      <div>
                                        <a class="uibutton submit_form" >Simpan</a><a class="uibutton special"   onClick="ResetForm()" title="Reset  Form"   >Reset Form</a>                                        
                                     </div>
                                     </div>
                                </fieldset>
                                </form>
                                </div>
                              </div>  
                          </div><!--tab1-->                                                                                                      
                  </div>                  
                  <div class="clear"/></div>                  
                  </div>
                  </div>