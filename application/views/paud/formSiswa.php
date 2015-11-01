<div class="topcolumn">
            <div class="logo"></div>
                            &nbsp;
          </div>
                    <div class="clear"></div> 
                    <?=$this->message->display();?>
                    <div class="onecolumn" >
                        <div class="header"><span><span class="ico gray diskette"></span> Data Siswa</span></div>
                        <div class="clear"></div>                        
                        <div class="content" >
                          <div class="tab_container" >

                          <div id="tab1" class="tab_content"> 
                              <div class="load_page">                                                         
                                <div class="formEl_b">  
                                <form id="validation" action="<?=base_url()?>paud/siswa/<?=$link?>" method="POST"> 
                                <fieldset >
                                <legend><?=$ket?> <span class="small s_color">( <?=$jenis?> )</span></legend>                                                                                                             
                                      <div class="section">
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
                                      <label> Jumlah Siswa  <small>Laki-laki</small></label>
                                      <div>
                                      <input type="text"  name="laki_paud" id="laki_paud"  class="validate[required] medium" value="<? if(isset($kueri->laki_paud)){ echo $kueri->laki_paud; } ?>"/>                                      
                                      </div><br/>
                                      <label> Jumlah Siswa  <small>Perempuan</small></label>
                                      <div>
                                      <input type="text"  name="perempuan_paud" id="perempuan_paud"  class="validate[required] medium" value="<? if(isset($kueri->perempuan_paud)){ echo $kueri->perempuan_paud; } ?>"/>                                      
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
                          <div class="clear"></div>
                        </div>
                      </div>                    