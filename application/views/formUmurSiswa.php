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
                    <form method="POST" action="<?=base_url()?>siswa/simpan_umur" id="wizardsss">                                            
                      <?                             
                      if(isset($kueri) AND count($kueri) > 0)                      
                      {                        
                        foreach($kueri as $detil)
                        {
                        ?>
                        <div class="section numericonly">
                        <label> <?=$detil['batas']?>(Laki-laki) </label>
                        <div>
                        <input type="text"  placeholder="Jumlah" name="detill_<?=$detil['id_detail_umur']?>" id="detill_<?=$detil['id_detail_umur']?>"  class="large anak" value="<?=$detil['laki']?>"/>
                        <input type="hidden" name="detilss[]" value="<?=$detil['id_detail_umur']?>">
                        </div><br/>
                        <label> <?=$detil['batas']?>(Perempuan) </label>
                        <div>
                        <input type="text"  placeholder="Jumlah" name="detilp_<?=$detil['id_detail_umur']?>" id="detilp_<?=$detil['id_detail_umur']?>"  class="large anak" value="<?=$detil['pr']?>"/>
                        <input type="hidden" name="detilss[]" value="<?=$detil['id_detail_umur']?>">
                        </div>
                        </div>
                        <?
                        }
                      }?>
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