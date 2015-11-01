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

                          <!--<div id="tab1" class="tab_content">-->
                              <div class="load_page">                        
                                 
                                <div class="formEl_b">  
                                <form id="validation" action="<?=base_url()?>pembiayaan/<?php echo $link; ?>/<?php echo (isset($kueri->id_kmasuk))?$kueri->id_kmasuk:0; ?>" method="POST"> 
                                <fieldset >
                                <legend><?=$ket?> <span class="small s_color">( <?=$jenise?> )</span></legend>                                                                                                             
                                      <div class="section numericonly">
                                      <label> Saldo Awal  </label>
                                      <div>
                                      <input type="text"  name="saldo_awal" id="saldo_awal"  class="validate[required] medium" value="<? if(isset($kueri->saldo_awal)){ echo $kueri->saldo_awal; } ?>"/>
                                      <span class="f_help"> Jumlah Saldo Awal. </span> 
                                      </div>
                                      <label> APBN(BOS)  </label>
                                      <div>
                                      <input type="text"  name="bos" id="bos"  class="medium" value="<? if(isset($kueri->bos)){ echo $kueri->bos; } ?>"/>
                                      <span class="f_help"> Jumlah APBN(BOS). </span> 
                                      </div>
                                      <label> APBD Provinsi  </label>
                                      <div>
                                      <input type="text"  name="prov" id="prov"  class="medium" value="<? if(isset($kueri->prov)){ echo $kueri->prov; } ?>"/>
                                      <span class="f_help"> Jumlah APBD Provinsi. </span> 
                                      </div>
                                      <label> APBD Kabupaten  </label>
                                      <div>
                                      <input type="text"  name="pemda" id="pemda"  class="medium" value="<? if(isset($kueri->pemda)){ echo $kueri->pemda; } ?>"/>
                                      <span class="f_help"> Jumlah APBD Kabupaten. </span> 
                                      </div>
                                      <label> BOS Buku  </label>
                                      <div>
                                      <input type="text"  name="bos_buku" id="bos_buku"  class="medium" value="<? if(isset($kueri->bos_buku)){ echo $kueri->bos_buku; } ?>"/>
                                      <span class="f_help"> Jumlah BOS Buku. </span> 
                                      </div>
                                      <label> BOMM  </label>
                                      <div>
                                      <input type="text"  name="bomm" id="bomm"  class="medium" value="<? if(isset($kueri->bomm)){ echo $kueri->bomm; } ?>"/>
                                      <span class="f_help"> Jumlah BOMM. </span> 
                                      </div>
                                      <label> BKM  </label>
                                      <div>
                                      <input type="text"  name="bkm" id="bkm"  class="medium" value="<? if(isset($kueri->bkm)){ echo $kueri->bkm; } ?>"/>
                                      <span class="f_help"> Jumlah BKM. </span> 
                                      </div>
                                      <label> BOP  </label>
                                      <div>
                                      <input type="text"  name="bop" id="bop"  class="medium" value="<? if(isset($kueri->bop)){ echo $kueri->bop; } ?>"/>
                                      <span class="f_help"> Jumlah BOP. </span> 
                                      </div>
                                      <label> Dana Yayasan  </label>
                                      <div>
                                      <input type="text"  name="yayasan" id="yayasan"  class="medium" value="<? if(isset($kueri->yayasan)){ echo $kueri->yayasan; } ?>"/>
                                      <span class="f_help"> Jumlah Dana Yayasan. </span> 
                                      </div>
                                      <label> Bantuan Lembaga Swasta  </label>
                                      <div>
                                      <input type="text"  name="lembaga_swasta" id="lembaga_swasta"  class="medium" value="<? if(isset($kueri->lembaga_swasta)){ echo $kueri->lembaga_swasta; } ?>"/>
                                      <span class="f_help"> Jumlah Bantuan Lembaga Swasta. </span> 
                                      </div>
                                      <label> Sumbangan Orang Tua  </label>
                                      <div>
                                      <input type="text"  name="orang_tua" id="orang_tua"  class="medium" value="<? if(isset($kueri->orang_tua)){ echo $kueri->orang_tua; } ?>"/>
                                      <span class="f_help"> Jumlah Sumbangan Orang Tua. </span> 
                                      </div>
                                      <label> Unit Produksi(Khusus SMK)  </label>
                                      <div>
                                      <input type="text"  name="up_smk" id="up_smk"  class="medium" value="<? if(isset($kueri->up_smk)){ echo $kueri->up_smk; } ?>"/>
                                      <span class="f_help"> Jumlah Unit Produksi(Khusus SMK). </span> 
                                      </div>
                                      <label> Lain-lain  </label>
                                      <div>
                                      <input type="text"  name="sumber_lain" id="sumber_lain"  class="medium" value="<? if(isset($kueri->sumber_lain)){ echo $kueri->sumber_lain; } ?>"/>
                                      <span class="f_help"> Jumlah Dan Lain-lain. </span> 
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
                          <!--</div>--><!--tab1-->                                                                                                         
                  </div>                  
                  <div class="clear"/></div>                  
                  </div>
                  </div>