<div class="topcolumn">

            <div class="logo"></div>

                            <ul  id="shortcut">

                                <li> <a href="<?=base_url()?>manajemen/permissions" title="Back To home"> <img src="<?=base_url()?>assets/template/fingers/images/icon/shortcut/home.png" alt="home" width="40px"/><strong>Daftar</strong> </a> </li>

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

                                <form id="validation" action="<?=base_url()?>manajemen/<?=$link?>" method="POST"> 

                                <fieldset >

                                <legend><?=$ket?> <span class="small s_color">( <?=$jenis?> )</span></legend>                                                                                                             

                                      <div class="section">

                                      <label> Nama Akses User  <small>Nama Akses User</small></label>

                                      <div>

                                      <input type="text"  name="perm" id="perm"  class="validate[required] medium" value="<? if(isset($kueri->permName)){ echo $kueri->permName; } ?>" value="<? if(isset($kueri->permName)){ echo $kueri->permName; } ?>"/>

                                      <span class="f_help"> Nama Akses User. <br />Isikan Nama Akses User</span> 

                                      </div>                                      

                                      </div>                                      

                                      <div class="section">

                                      <label> Nama Controller  <small>Nama Controller</small></label>

                                      <div>

                                      <input type="text"  name="contr" id="contr"  class="validate[required] medium" value="<? if(isset($kueri->controllerName)){ echo $kueri->controllerName; } ?>" value="<? if(isset($kueri->controllerName)){ echo $kueri->controllerName; } ?>"/>

                                      <span class="f_help"> Nama Controller. <br />Isikan Nama Controller</span> 

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