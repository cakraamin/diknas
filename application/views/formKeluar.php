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
                                <form id="validation" action="<?=base_url()?>pembiayaan/<?=$link?>//<?php echo (isset($kueri->id_keluar))?$kueri->id_keluar:0; ?>" method="POST"> 
                                <fieldset >
                                <legend><?=$ket?> <span class="small s_color">( <?=$jenise?> )</span></legend>                                                                                                             
                                      <div class="section numericonly">
                                      <label> Pengeluaran Gaji Guru  </label>
                                      <div>
                                      <input type="text"  name="gaji_guru" id="gaji_guru"  class="validate[required] medium" value="<? if(isset($kueri->gaji_guru)){ echo $kueri->gaji_guru; } ?>"/>
                                      <span class="f_help"> Jumlah Pengeluaran Gaji Guru. </span> 
                                      </div>
                                      <label> Pengeluaran Gaji Karyawan  </label>
                                      <div>
                                      <input type="text"  name="gaji_karyawan" id="gaji_karyawan"  class="validate[required] medium" value="<? if(isset($kueri->gaji_karyawan)){ echo $kueri->gaji_karyawan; } ?>"/>
                                      <span class="f_help"> Jumlah Pengeluaran Gaji Karyawan. </span> 
                                      </div>
                                      <label> Pengeluaran Kegiatan Belajar Mengajar  </label>
                                      <div>
                                      <input type="text"  name="kbm" id="kbm"  class="validate[required] medium" value="<? if(isset($kueri->kbm)){ echo $kueri->kbm; } ?>"/>
                                      <span class="f_help"> Jumlah Pengeluaran Kegiatan Belajar Mengajar. </span> 
                                      </div>
                                      <label> Pengeluaran Sarana Prasarana  </label>
                                      <div>
                                      <input type="text"  name="sarpras" id="sarpras"  class="medium" value="<? if(isset($kueri->sarpras)){ echo $kueri->sarpras; } ?>"/>
                                      <span class="f_help"> Jumlah Pengeluaran Sarana Prasarana. </span> 
                                      </div>
                                      <label> Pengeluaran Rehabilitasi  </label>
                                      <div>
                                      <input type="text"  name="rehab" id="rehab"  class="medium" value="<? if(isset($kueri->rehab)){ echo $kueri->rehab; } ?>"/>
                                      <span class="f_help"> Jumlah Pengeluaran Rehabilitasi. </span> 
                                      </div>
                                      <label> Pengeluaran Pengadaan Sarpras  </label>
                                      <div>
                                      <input type="text"  name="pengadaan_sarpras" id="pengadaan_sarpras"  class="medium" value="<? if(isset($kueri->pengadaan_sarpras)){ echo $kueri->pengadaan_sarpras; } ?>"/>
                                      <span class="f_help"> Jumlah Pengeluaran Pengadaan Sarpras. </span> 
                                      </div>
                                      <label> Pengeluaran Ekstrakulikuler  </label>
                                      <div>
                                      <input type="text"  name="ekstra" id="ekstra"  class="medium" value="<? if(isset($kueri->ekstra)){ echo $kueri->ekstra; } ?>"/>
                                      <span class="f_help"> Jumlah Pengeluaran Ekstrakulikuler. </span> 
                                      </div>
                                      <label> Pengeluaran Jasa  </label>
                                      <div>
                                      <input type="text"  name="jasa" id="jasa"  class="medium" value="<? if(isset($kueri->jasa)){ echo $kueri->jasa; } ?>"/>
                                      <span class="f_help"> Jumlah Pengeluaran Jasa. </span> 
                                      </div>
                                      <label> Pengeluaran Tata Usaha  </label>
                                      <div>
                                      <input type="text"  name="tu" id="tu"  class="validate[required] medium" value="<? if(isset($kueri->tu)){ echo $kueri->tu; } ?>"/>
                                      <span class="f_help"> Jumlah Pengeluaran Tata Usaha. </span> 
                                      </div>
                                      <label> Pengeluaran Lain-lain  </label>
                                      <div>
                                      <input type="text"  name="lain" id="lain"  class="validate[required] medium" value="<? if(isset($kueri->lain)){ echo $kueri->lain; } ?>"/>
                                      <span class="f_help"> Jumlah Pengeluaran Lain-lain. </span> 
                                      </div>
                                      <label> Saldo Pengeluaran  </label>
                                      <div>
                                      <input type="text"  name="saldo" id="saldo"  class="validate[required] medium" value="<? if(isset($kueri->saldo)){ echo $kueri->saldo; } ?>"/>
                                      <span class="f_help"> Jumlah Saldo Pengeluaran. </span> 
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