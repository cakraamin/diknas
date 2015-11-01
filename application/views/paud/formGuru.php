<script type="text/javascript">
function pilih(){
  var status = $('#status').val();
  if(status == 2){
    $('#status_peg').show();
  }else{
    $('#status_peg').hide();
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
</script>
<div class="topcolumn">
            <div class="logo"></div>
                            <ul  id="shortcut">
                                <li> <a href="<?=base_url()?>paud/guru/daftar" title="Back To home"> <img src="<?=base_url()?>assets/template/fingers/images/icon/shortcut/home.png" alt="home" width="40px"/><strong>Daftar</strong> </a> </li>
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
                                <form id="validation" action="<?=base_url()?>paud/guru/<?=$link?>" method="POST"> 
                                <fieldset >
                                <legend><?=$ket?> <span class="small s_color">( <?=$jenis?> )</span></legend>                                                                                                             
                                      <div class="section">
                                      <?
                                      $pel = (isset($kueri->jarak))?$kueri->jarak:"0-0";
                                      $pecah = explode("-", $pel);
                                      $pendik = (isset($pecah[0]))?$pecah[0]:0;
                                      $pela = (isset($pecah[1]))?$pecah[1]:0;

                                      $pelatih = ($pela == 1)?TRUE:FALSE;
                                      $pendidik = ($pendik == 1)?TRUE:FALSE;
                                      ?>
                                      <label> Nama Sekolah  <small>Nama Sekolah</small></label>
                                      <div>
                                              <?
                                              $seleksek = (isset($kueri->id_school))?$kueri->id_school:"";
                                              $jsek = " data-placeholder='Kecamatan...' class='chzn-select' ";
                                              echo form_dropdown('sekolah', $skuls, $seleksek,$jsek);
                                              ?>
                                      <span class="f_help"> Pilih salah satu. </span> 
                                      </div>                                                                            
                                      </div>
                                      <div class="section numericonly">
                                      <label> NUPTK Guru  <small>NUPTK</small></label>
                                      <div>
                                      <input type="text"  name="nuptk" id="nuptk"  class="validate[required] medium" value="<? if(isset($kueri->nuptk_guru)){ echo $kueri->nuptk_guru; } ?>"/>
                                      <span class="f_help"> Isikan NUPTK Sekolah. </span> 
                                      </div>
                                      </div>                                      
                                      <div class="section textonly">
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
                                              $selekbln = (isset($tmt['2']) && $tmt['2'] != '00')?$tmt['2']:"";
                                              $jpbln = "data-placeholder='Pilih Status Pegawai...' class='small'";
                                              echo form_dropdown('buland', $bulan, $selekbln,$jpbln);
                                              $selekthn = (isset($tmt['2']) && $tmt['2'] != '00')?$tmt['2']:"";
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
                                      <label> Kependidikan </label>
                                      <div>                                            
                                              <?=form_checkbox('pendidik', '1', $pelatih);?>
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
                                      <div class="section" id="status_peg" style="display:none;">
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
                                      <div class="section">
                                      <label> Pelatihan Pendidikan PAUD </label>
                                      <div>                                            
                                              <?=form_checkbox('pelatihan', '1', $pendidik);?>
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