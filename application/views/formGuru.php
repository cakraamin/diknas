<script type="text/javascript">
function pilih(){
  var status = $('#status').val();  
  if(status == 1 || status == 2){
    $('#status_peg').show();
    $('.gurune').show();
    $('#tenaga').hide();
  }else if(status == 4 || status == 5){
    $('.gurune').hide();
    $('#tenaga').show();
    if(status == 4 || status == 5){
      $('#status_peg').hide();
    }else{
      $('#status_peg').show();
    }
  }else{
    $('#status_peg').hide();
    $('.gurune').show();
    $('#tenaga').hide();
  }
}
function piliht(){
  var tunjangan = $('#tunjangan').val();
  if(tunjangan == 1){
    $('#sertif').show();
  }else{
    $('#sertif').hide();
  }
}
function gantiInduk()
{
  var nilai = $('#induke').val();
  if(nilai == 1){
    $('#skulInduk').hide();
  }else{
    $('#skulInduk').show();
  }  
}
</script>
<div class="topcolumn">
            <div class="logo"></div>
                            <ul  id="shortcut">
                                <li> <a href="<?=base_url()?>guru/daftar" title="Back To home"> <img src="<?=base_url()?>assets/template/fingers/images/icon/shortcut/home.png" alt="home" width="40px"/><strong>Daftar</strong> </a> </li>
                            </ul>      
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
                                <form id="validation" action="<?=base_url()?>guru/<?=$link?>" method="POST"> 
                                <fieldset >
                                <legend><?=$ket?> <span class="small s_color">( <?=$jenis?> )</span></legend>                                                                                                             
                                      <div class="section numericonly">
                                      <label> NUPTK/Peg ID Guru  <small>NUPTK</small></label>
                                      <div>
                                      <input type="text"  name="nuptk" id="nuptk"  class="validate[required,minSize[14],maxSize[16]] medium" value="<? if(isset($kueri->nuptk_guru)){ echo $kueri->nuptk_guru; } ?>"/>
                                      <span class="f_help"> Isikan NUPTK Sekolah. </span> 
                                      </div>
                                      </div>
                                      <div class="section numericonly">
                                      <label> NIK/NIP Guru  <small>NIK/NIP</small></label>
                                      <div>
                                      <input type="text"  name="nik" id="nik"  class="validate[minSize[16],maxSize[18]] medium" value="<? if(isset($kueri->nik_guru)){ echo $kueri->nik_guru; } ?>"/>
                                      <span class="f_help"> Isikan NIK/NIP Sekolah. </span> 
                                      </div>
                                      </div>
                                      <div class="section alluppercase">
                                      <label> Nama Guru  <small>Nama</small></label>
                                      <div>
                                      <input type="text"  name="nama" id="nama"  class="validate[required] medium" value="<? if(isset($kueri->nama_guru)){ echo $kueri->nama_guru; } ?>"/>
                                      <span class="f_help"> Isikan Nama Sekolah. </span> 
                                      </div>                                                                            
                                      </div>
                                      <div class="section alluppercase textonly">
                                      <label> Tempat Lahir  <small>Tempat lahir</small></label>
                                      <div>
                                      <input type="text"  name="tempat_lahir" id="tempat_lahir"  class="validate[required] medium" value="<? if(isset($kueri->tempat_lahir)){ echo $kueri->tempat_lahir; } ?>"/>
                                      <span class="f_help"> Isikan Tempat Lahir. </span> 
                                      </div>                                                                            
                                      </div>
                                      <div class="section">
                                      <label> Status Induk  <small>Status</small></label>
                                      <div>
                                              <?                                                                                       
                                              $selekinduk = (isset($kueri->status_induk))?$kueri->status_induk:"";
                                              $jinduk = "data-placeholder='Pilih Status Induk...' class='medium' onChange='gantiInduk()' id='induke'";
                                              echo form_dropdown('induk', $induk, $selekinduk,$jinduk);
                                              ?> 
                                      </div>                                                                            
                                      </div>
                                      <? $jenisInduk = (isset($kueri->status_induk) && $kueri->status_induk == 2)?"":"style='display:none;'"; ?>
                                      <div class="section" <?=$jenisInduk?> id="skulInduk">
                                      <label> Sekolah Induk  <small>Sekolah</small></label>
                                      <div>
                                              <?                                                                                       
                                              $selekSekinduk = (isset($kueri->id_school))?$kueri->id_school:"";                                                                                                                                          
                                              $jSekinduk = "data-placeholder='Pilih Status Sekolah Induk...' class='chzn-select'";
                                              echo form_dropdown('Sekinduk', $sekLiyane, $selekSekinduk,$jSekinduk);
                                              ?> 
                                      </div>                                                                            
                                      </div>
                                      <div class="section">
                                      <label> Tanggal Lahir  <small>Tanggal</small></label>
                                      <div>
                                              <?
                                              $tgl_lahir = (isset($kueri->tgl_lahir))?$kueri->tgl_lahir:"";
                                              $tanggal_lahir = explode("-", $tgl_lahir);
                                              $selektgl = (isset($tanggal_lahir['2']) && $tanggal_lahir['2'] != '00')?$tanggal_lahir['2']:"";
                                              $jptgl = "data-placeholder='Pilih Status Pegawai...' class='small'";
                                              echo form_dropdown('tanggal', $tanggal, $selektgl,$jptgl);
                                              $selekbln = (isset($tanggal_lahir['1']) && $tanggal_lahir['1'] != '00')?$tanggal_lahir['1']:"";
                                              $jpbln = "data-placeholder='Pilih Status Pegawai...' class='small'";
                                              echo form_dropdown('bulan', $bulan, $selekbln,$jpbln);
                                              $selekthn = (isset($tanggal_lahir['0']) && $tanggal_lahir['0'] != '0000')?$tanggal_lahir['0']:"";
                                              $jpthn = "data-placeholder='Pilih Status Pegawai...' class='small'";
                                              echo form_dropdown('tahun', $tahun, $selekthn,$jpthn);
                                              ?> 
                                      </div>                                                                            
                                      </div>
                                      <div class="section">
                                      <label> TMT  <small>TMT</small></label>
                                      <div>
                                              <?
                                              $tmt_guru = (isset($kueri->tmt_guru))?$kueri->tmt_guru:"";
                                              $tmt = explode("-", $tmt_guru);
                                              $selektgl = (isset($tmt['2']) && $tmt['2'] != '00')?$tmt['2']:"";
                                              $jptgl = "data-placeholder='Pilih Status Pegawai...' class='small'";
                                              echo form_dropdown('tanggald', $tanggal, $selektgl,$jptgl);
                                              $selekbln = (isset($tmt['1']) && $tmt['1'] != '00')?$tmt['1']:"";
                                              $jpbln = "data-placeholder='Pilih Status Pegawai...' class='small'";
                                              echo form_dropdown('buland', $bulan, $selekbln,$jpbln);
                                              $selekthn = (isset($tmt['0']) && $tmt['0'] != '00')?$tmt['0']:"";
                                              $jpthn = "data-placeholder='Pilih Status Pegawai...' class='small'";
                                              echo form_dropdown('tahund', $tahun, $selekthn,$jpthn);
                                              ?> 
                                      </div>                                                                            
                                      </div>
                                      <div class="section">
                                      <label> Jenis Kelamin  <small>Jenis Kelamin</small></label>
                                      <div>
                                              <?
                                              $selekje = (isset($kueri->jenis_kel))?$kueri->jenis_kel:"";                                              
                                              echo form_dropdown('jenisKel', $jenisKel, $selekje);
                                              ?>
                                      <span class="f_help"> Pilih salah satu. </span> 
                                      </div>                                                                            
                                      </div>
                                      <div class="section">
                                      <label> Pendidikan Terakhir  <small>Pendidikan</small></label>
                                      <div>
                                              <?
                                              $selekpend = (isset($kueri->pend_guru))?$kueri->pend_guru:"";                                              
                                              echo form_dropdown('pend_guru', $pendidikan, $selekpend);
                                              ?>
                                      <span class="f_help"> Pilih salah satu. </span> 
                                      </div>                                                                            
                                      </div>
                                      <div class="section">
                                      <label> Status Pekerjaan  <small>Status</small></label>
                                      <div>
                                              <?
                                              $selek = (isset($kueri->status_guru))?$kueri->status_guru:"";
                                              $jp = "data-placeholder='Pilih Status Pegawai...' onchange='pilih()' id='status'";
                                              echo form_dropdown('status', $status, $selek,$jp);
                                              ?>
                                      <span class="f_help"> Pilih salah satu. </span> 
                                      </div>                                                                            
                                      </div>
                                      <? $jenisTen = (isset($kueri->status_guru) && ($kueri->status_guru == 2 || $kueri->status_guru == 3))?"style='display:none;'":""; ?>
                                      <div class="section" id="tenaga" <?=$jenisTen?>>
                                      <label> Jenis Ketenagaan  <small>Jenis</small></label>
                                      <div>
                                              <?
                                              $selekke = (isset($kueri->jenis_tenaga))?$kueri->jenis_tenaga:"";
                                              $jpke = "data-placeholder='Pilih Jenis Ketenagaan...'";
                                              echo form_dropdown('tenaga', $tenaga, $selekke,$jpke);
                                              ?>
                                      <span class="f_help"> Pilih salah satu. </span> 
                                      </div>                                                                            
                                      </div>                                      
                                      <? $statPeg = (isset($kueri->status_guru) && ($kueri->status_guru == 1 OR $kueri->status_guru == 2 OR $kueri->status_guru == 5) OR $this->uri->segment(2)=='tambah_guru')?'':'style="display:none;"' ?>                                      
                                      <div class="section" id="status_peg" <?=$statPeg?>>
                                      <label> Status Pegawai  <small>Status</small></label>
                                      <div>
                                              <?
                                              $selekstat = (isset($kueri->status_peg))?$kueri->status_peg:"";
                                              $jpstat = "data-placeholder='Pilih Status Pegawai...'";
                                              echo form_dropdown('statuspeg', $statuspeg, $selekstat,$jpstat);
                                              ?>
                                      <span class="f_help"> Pilih salah satu. </span> 
                                      </div>                                                                            
                                      </div>
                                      <? $jenisJab = (isset($kueri->status_guru) && ($kueri->status_guru == 2 || $kueri->status_guru == 3))?"":"style='display:none;'"; ?>
                                      <div class="section gurune" <?=$jenisJab?>>
                                      <label> Jabatan Guru <small>Jabatan Guru</small></label>
                                      <div>
                                              <?
                                              $selekj = (isset($kueri->id_jabatan))?$kueri->id_jabatan:"";
                                              $jpj = "data-placeholder='Pilih Jabatan Guru...'";
                                              echo form_dropdown('jabatan', $jabatan, $selekj,$jpj);
                                              ?>
                                      <span class="f_help"> Isikan Jabatan Guru. </span> 
                                      </div>                                                                            
                                      </div>
                                      <? $jenisTunj = (isset($kueri->status_guru) && ($kueri->status_guru == 2 || $kueri->status_guru == 3))?"":"style='display:none;'"; ?>
                                      <div class="section gurune" <?=$jenisTunj?>>
                                      <label> Tunjangan Guru  <small>Tunjangan</small></label>
                                      <div>
                                              <?
                                              $selektunj = (isset($kueri->tunjangan_guru))?$kueri->tunjangan_guru:"";
                                              $jtunj = "data-placeholder='Pilih Status Tunjangan...' onchange='piliht()' id='tunjangan'";
                                              echo form_dropdown('tunjangan', $tunjangan, $selektunj,$jtunj);
                                              ?>
                                      <span class="f_help"> Pilih salah satu. </span> 
                                      </div>                                                                            
                                      </div>
                                      <div class="section" style="display:none;" id="sertif">
                                      <label> Tahun Sertifikasi  <small>Tahun Sertifikasi</small></label>
                                      <div>
                                              <?
                                              $selektuntj = (isset($kueri->tahun_tunjangan))?$kueri->tahun_tunjangan:"";
                                              $jtuntj = "data-placeholder='Pilih Tahun Sertifikasi...'";
                                              echo form_dropdown('sertif', $sertif, $selektuntj,$jtuntj);
                                              ?>
                                      <span class="f_help"> Pilih salah satu. </span> 
                                      </div>                                                                            
                                      </div>
                                      <div class="section">
                                      <label> Jenis Kendaraan  <small>Jenis</small></label>
                                      <div>
                                              <?
                                              $seleke = (isset($kueri->jenis_kendaraan))?$kueri->jenis_kendaraan:"";
                                              $jpe = "data-placeholder='Pilih Jenis Kendaraan...'";
                                              echo form_dropdown('kendaraan', $kendaraan, $seleke,$jpe);
                                              ?>
                                      <span class="f_help"> Pilih salah satu(Kendaraan ke Sekolah). </span> 
                                      </div>                                                                            
                                      </div> 
                                      <div class="section numericonly">
                                      <label> Jarak Rumah dan Sekolah  <small>Jarak</small></label>
                                      <div>
                                      <input type="text"  name="jarak" id="jarak"  class="validate[required] medium" value="<? if(isset($kueri->jarak)){ echo $kueri->jarak; } ?>"/>
                                      <span class="f_help"> Jarak rumah dan sekolah(kilometer). </span> 
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