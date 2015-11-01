<script type="text/javascript">
function setStatusSkul()
{
  var nilai = $('#statuse').val();  
  if(nilai == 2){
    $('.swasta').show();
  }else{
    $('.swasta').hide();
  } 
}
</script>
<div class="topcolumn">
            <div class="logo"></div>
                            <ul  id="shortcut">
                                <li> <a href="<?=base_url()?>paud/sekolah/daftar" title="Back To home"> <img src="<?=base_url()?>assets/template/fingers/images/icon/shortcut/home.png" alt="home" width="40px"/><strong>Daftar</strong> </a> </li>
                            </ul>      
          </div>  
          <div class="clear"></div>          
                    <div class="clear"></div>
                        
                  <div class="onecolumn" >
                  <div class="header"><span ><span class="ico  gray user"></span><?=$ket?></span> </div><!-- End header --> 
                  <div class="clear"></div>
                  <div class="content" >                      
                    <div class="tab_container" >

                          <div id="tab1" class="tab_content"> 
                              <div class="load_page">                        
                                 
                                <div class="formEl_b">  
                                <form id="validation" action="<?=base_url()?>paud/sekolah/<?=$link?>" method="POST"> 
                                <fieldset >
                                <legend><?=$ket?> <span class="small s_color">( <?=$jenis?> )</span></legend>                                                                                                             
                                      <div class="section">
                                      <label> Nama Sekolah  <small>Nama</small></label>
                                      <div>
                                      <input type="text"  name="nama" id="nama"  class="validate[required] medium" value="<? if(isset($kueri->nama_paud)){ echo $kueri->nama_paud; } ?>"/>
                                      <span class="f_help"> Isikan Nama Sekolah. </span> 
                                      </div>                                                                            
                                      </div>
                                      <div class="section numericonly">
                                      <label> NPSN Sekolah  <small>NPSN</small></label>
                                      <div>
                                      <input type="text"  name="npsn" id="npsn"  class="validate[required,minSize[8],maxSize[8]] medium" value="<? if(isset($kueri->npns_paud)){ echo $kueri->npns_paud; } ?>"/>
                                      <span class="f_help"> Isikan Nama Sekolah. </span>                                       
                                      </div>
                                      </div>
                                      <div class="section">
                                      <label> Alamat Sekolah  <small>Alamat</small></label>
                                      <div>
                                      <textarea name="alamat" id="alamat" cols="50" rows="5"><? if(isset($kueri->alamat_paud)){ echo $kueri->alamat_paud; } ?></textarea>
                                      </div>
                                      <label> Kecamatan  </label>
                                      <div>
                                              <?
                                              $selekkec = (isset($kueri->id_kecamatan))?$kueri->id_kecamatan:"";                                              
                                              $jpkec = "data-placeholder='Kecamatan...' class='chzn-select'";
                                              echo form_dropdown('kecamatan', $kecamatan, $selekkec,$jpkec);
                                              ?>
                                      </div>
                                      </div>
                                      <div class="section">
                                      <label> Jenis Satuan </label>
                                      <div>
                                              <?                                              
                                              $selekjenis = (isset($kueri->jenis_paud))?$kueri->jenis_paud:"";
                                              $jjenis = 'class="large"';
                                              echo form_dropdown('jenis', $jenise, $selekjenis,$jjenis);
                                              ?>
                                      </div>                                                                            
                                      </div>   
                                      <div class="section">
                                      <label> Status Sekolah </label>
                                      <div>
                                              <?                                              
                                              $selekstat = (isset($kueri->status_paud))?$kueri->status_paud:"";
                                              $jpstat = 'class="large" onChange="setStatusSkul()" id="statuse"';
                                              echo form_dropdown('status', $status, $selekstat,$jpstat);
                                              ?>
                                      </div>                                                                            
                                      </div>   
                                      <?
                                      $status = (isset($kueri->status_paud) AND $kueri->status_paud == 2)?'':'style="display:none;"';                                      
                                      ?> 
                                      <div class="section alluppercase swasta" <?=$status?>>
                                      <label> Nama Yayasan  <small>Nama</small></label>
                                      <div>
                                      <input type="text"  name="nama_y" id="nama_y"  class="validate[required] large" value="<? if(isset($kueri->yayasan_paud)){ echo $kueri->yayasan_paud; } ?>"/>
                                      <span class="f_help"> Isikan Nama Yayasan. </span> 
                                      </div>
                                      </div>
                                      <div class="section">
                                      <label> Kepemilikan </label>
                                      <div>
                                              <?                                              
                                              $selekmilik = (isset($kueri->milik_paud))?$kueri->milik_paud:"";
                                              $jmilik = 'class="large"';
                                              echo form_dropdown('milik', $milik, $selekmilik,$jmilik);
                                              ?>
                                      </div>                                                                            
                                      </div>
                                      <div class="section">
                                      <label> Nama Kepala/Pengelola  <small>Nama</small></label>
                                      <div>
                                      <input type="text"  name="nama_p" id="nama_p"  class="validate[required] medium" value="<? if(isset($kueri->kepala_paud)){ echo $kueri->kepala_paud; } ?>"/>
                                      <span class="f_help"> Isikan Nama Kepala/Pengelola. </span> 
                                      </div>                                                                            
                                      </div>
                                      <div class="section">
                                      <label> Nomor Izin Pengelola  <small>Nomor Izin</small></label>
                                      <div>
                                      <input type="text"  name="nomor_izin" id="nomor_izin"  class="validate[required] medium" value="<? if(isset($kueri->ijin_paud)){ echo $kueri->ijin_paud; } ?>"/>
                                      <span class="f_help"> Isikan Nomor Izin Pengelola. </span> 
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