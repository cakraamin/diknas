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
                                <form id="validation" action="<?=base_url()?>laporan/generate_spm" method="POST"> 
                                <fieldset >
                                <legend>Generate Laporan <span class="small s_color">( <?=$ket?> )</span></legend>                                      
                                      <div class="section" id="spm">
                                      <label> Tahun SPM  <small>Tahun</small></label>
                                      <div>
                                              <?
                                              $js = "  class='chzn-select' multiple ";
                                              echo form_dropdown('tahun[]', $tahun,'',$js);
                                              ?>
                                      <span class="f_help"> Pilih Tahun. </span> 
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