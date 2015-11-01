<div class="topcolumn">
            <div class="logo"></div>
                            &nbsp;
          </div>
                    <div class="clear"></div> 
                    <?=$this->message->display();?>
                    <div class="onecolumn" >
                        <div class="header"><span><span class="ico gray diskette"></span> Data Umur Siswa</span></div>
                        <div class="clear"></div>                        
                        <div class="content" >
   

    <!-- Smart Wizard -->      
      <div class="swMain">                                                     
                  <input type="hidden" name="jenis" id="jenis" value="simpan_agama">                                           
                    <div id="pesan"></div>
                    <h2>Data Siswa <?=$jenjang?> Berdasarkan Umur</h2>                  
                    <form method="POST" action="<?=base_url()?>siswa/simpan_asal" id="wizardsss">                                            
                      <div class="section numericonly">
                        <label> Siswa Asal Dalam Kota </label>
                        <div>
                        <input type="text"  placeholder="Jumlah" name="dalam_kota" id="dalam_kota"  class="small" value="<?php echo $kueri['dalam_kota']; ?>"/>                        
                        </div><br/>
                        <label> Siswa Asal Luar Kota </label>
                        <div>
                        <input type="text"  placeholder="Jumlah" name="luar_kota" id="luar_kota"  class="small" value="<?php echo $kueri['luar_kota']; ?>"/>                        
                        </div>
                        </div>
                      <div class="section last">
                      <div>
                        <a class="uibutton submit_form" >Simpan</a><a class="uibutton special"   onClick="ResetForm()" title="Reset  Form"   >Reset Form</a>
                      </div>
                      </div>
                    </form>                                          
      </div>
      </div>
    <!-- End SmartWizard Content -->       
                          <div class="clear"></div>
                        </div>
                      </div>                    