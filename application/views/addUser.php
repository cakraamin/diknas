<div class="topcolumn">

            <div class="logo"></div>

                            <ul  id="shortcut">

                                <li> <a href="<?=base_url()?>manajemen/users/<?=$id?>/<?=url_title($nama,"underscore")?>" title="Back To home"> <img src="<?=base_url()?>assets/template/fingers/images/icon/shortcut/home.png" alt="home" width="40px"/><strong>Daftar</strong> </a> </li>

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

                                      <label> Login  Account  <small>Text custom</small></label>

                                      <div>

                                      <input type="text"  name="username" id="username"  class="validate[required,minSize[3],maxSize[20],] medium"  /><label>Username</label>

                                      <span class="f_help"> Username login or register. <br />Should be between 3 and not more than 20 characters.</span> 

                                      </div>

                                      <div>

                                      <input type="password"  class="validate[required,minSize[3]] medium"  name="password" id="password"  /><label>Password</label>

                                      </div>

                                      <div>

                                      <input type="password" class="validate[required,equals[password]] medium"  name="passwordCon" id="passwordCon"  /><label>Confirm Password</label>

                                            <span class="f_help"> Your password should be at least 6 characters.</span>

                                      </div>

                                      </div>

                                      <div class="section">

                                            <label>Level User <small>Pilih salah satu</small></label>   

                                            <div>                      

                                              <?                                             
                                              echo form_dropdown('level[]', $level, '','');
                                              ?>

                                      </div>                    

                                      </div>

                                      <div class="section">

                                            <label>Nama Sekolah <small>Pilih salah satu</small></label>   

                                            <div>                      

                                              <?

                                              $jp = "data-placeholder='Pilih Sekolah...' class='chzn-select'";

                                              echo form_dropdown('sekolah', $skul, '',$jp);

                                              ?>

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