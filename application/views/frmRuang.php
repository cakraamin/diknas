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
                                <form id="validation" action="<?=base_url()?>fasilitas/<?=$link?>" method="POST"> 
                                <fieldset >
                                <legend><?=$ket?> <span class="small s_color">( <?=$jenis?> )</span></legend>                                                                            
                                      <div class="section numericonly">
                                          <label>Jumlah Hak Milik (Kondisi Baik)</label>
                                          <div>
                                              <input type="text" placeholder="Jumlah Baik"  name="j_baik" id="j_baik"  class="small" value="<? if(isset($kueri->j_baik)){ echo $kueri->j_baik; } ?>"/>
                                          </div>                                                                                    
                                          <label>Luas Hak Milik (Kondisi Baik)</label>
                                          <div>
                                              <input type="text" placeholder="Luas Baik"  name="l_baik" id="l_baik"  class="small" value="<? if(isset($kueri->l_baik)){ echo $kueri->l_baik; } ?>"/>
                                          </div>
                                      </div>                                      
                                      <div class="section numericonly">
                                          <label>Jumlah Hak Milik (Kondisi Rusak Ringan)</label>
                                          <div>
                                              <input type="text" placeholder="Jumlah Rusak Ringan"  name="j_ringan" id="j_ringan"  class="small" value="<? if(isset($kueri->j_rusak_ringan)){ echo $kueri->j_rusak_ringan; } ?>"/>
                                          </div>                                                                                    
                                          <label>Luas Hak Milik (Kondisi Rusak Ringan)</label>
                                          <div>
                                              <input type="text" placeholder="Luas Rusak Ringan"  name="l_ringan" id="l_ringan"  class="small" value="<? if(isset($kueri->l_rusak_ringan)){ echo $kueri->l_rusak_ringan; } ?>"/>
                                          </div> 
                                      </div>                                      
                                      <div class="section numericonly">
                                          <label>Jumlah Hak Milik (Kondisi Rusak Berat)</label>
                                          <div>
                                              <input type="text" placeholder="Jumlah Rusak Berat"  name="j_berat" id="j_berat"  class="small" value="<? if(isset($kueri->j_rusak_berat)){ echo $kueri->j_rusak_berat; } ?>"/>
                                          </div>                                                                                    
                                          <label>Luas Hak Milik (Kondisi Rusak Berat)</label>
                                          <div>
                                              <input type="text" placeholder="Luas Rusak Berat"  name="l_berat" id="l_berat"  class="small" value="<? if(isset($kueri->l_rusak_berat)){ echo $kueri->l_rusak_berat; } ?>"/>
                                          </div>
                                      </div>                                      
                                      <div class="section numericonly">
                                          <label>Jumlah Bukan Hak Milik</label>
                                          <div>
                                              <input type="text" placeholder="Jumlah Bukan Hak Milik"  name="j_bukan" id="j_bukan"  class="small" value="<? if(isset($kueri->j_bukan_milik)){ echo $kueri->j_bukan_milik; } ?>"/>
                                          </div>                                                                                    
                                          <label>Luas Bukan Hak Milik</label>
                                          <div>
                                              <input type="text" placeholder="Luas Bukan Hak Milik"  name="l_bukan" id="l_bukan"  class="small" value="<? if(isset($kueri->l_bukan_milik)){ echo $kueri->l_bukan_milik; } ?>"/>
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