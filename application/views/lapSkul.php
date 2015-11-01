<script type="text/javascript">
function ubah(){
  var jenis = $('#jenis').val();
  if(jenis == 1){
    $('#kec').hide();
  }else{
    $('#kec').show();
  }
}
</script>
<div class="topcolumn">
            <div class="logo"></div>
                            &nbsp;     
          </div>  
          <div class="clear"></div>          
                    <div class="clear"></div>
                  <?=$this->message->display();?>
                  <div class="onecolumn" >
                  <div class="header"><span ><span class="ico  gray spreadsheet"></span>Rekap Laporan</span> </div><!-- End header --> 
                  <div class="clear"></div>
                  <div class="content" >                                      
                              <div class="load_page">                        
                                 
                                <div class="formEl_b">  
                                <form id="validation" action="<?=base_url()?>laporan/<?=$kode?>" method="POST"> 
                                <fieldset >
                                <legend>Generate Laporan <span class="small s_color">( <?=$ket?> )</span></legend>
                                      <div class="section">
                                      <label> Jenis Laporan  </label>
                                      <div>
                                              <?
                                              $js = "  onChange='ubah()' id='jenis'";
                                              echo form_dropdown('jenis', $jenis, '', $js);
                                              ?>
                                      <span class="f_help"> Pilih Jenis Laporan. </span> 
                                      </div>                                                                            
                                      </div>                                      
                                      <div class="section">
                                      <label> Jenjang Sekolah  </label>
                                      <div>
                                              <?                                              
                                              echo form_dropdown('jenjang', $jenjang);
                                              ?>
                                      <span class="f_help"> Pilih Jenjang Sekolah. </span> 
                                      </div>                                                                            
                                      </div>
                                      <div class="section" id="kec" style="display:none;">
                                      <label> Kecamatan  </label>
                                      <div>
                                              <?                                              
                                              echo form_dropdown('kecamatan', $kecamatan);
                                              ?>
                                      <span class="f_help"> Pilih Nama Kecamatan. </span> 
                                      </div>                                                                            
                                      </div>
                                      <div class="section last">
                                      <div>
                                        <a class="uibutton submit_form" >Generate Report</a>
                                     </div>
                                     </div>                                     
                                </fieldset>
                                </form>
                                </div>                                                                                                    
                  </div>                  
                  <div class="clear"/></div>                  
                  </div>
                  </div>