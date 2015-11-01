<div class="topcolumn">
            <div class="logo"></div>
                            <ul  id="shortcut">
                                <li> <a href="<?=base_url()?>manajemen/users/<?=$id?>/<?=$nama?>" title="Back To home"> <img src="<?=base_url()?>assets/template/fingers/images/icon/shortcut/home.png" alt="home" width="40px"/><strong>Daftar</strong> </a> </li>
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
                                <form id="validation" action="<?=base_url()?>user/<?=$link?>" method="POST"> 
                                <fieldset >
                                <legend><?=$ket?> <span class="small s_color">( <?=$jenis?> )</span></legend>                                                                                                             
                                      <div class="section">
                                      <label> Login  Account  <small>Login</small></label>
                                      <input type="hidden" name="username" value="<? echo $kueri->user_email; ?>">
                                      <input type="hidden" name="re" value="<? echo $re; ?>">
                                      <div>
                                      <input type="password" class="validate[required] medium"  name="oldpassword" id="oldpassword"  /><label>Old Password</label>
                                            <span class="f_help"> Your password should be at least 6 characters.</span>
                                      </div>
                                      <div>
                                      <input type="password"  class="validate[required,minSize[3]] medium"  name="password" id="password"  /><label>New Password</label>
                                      </div>
                                      <div>
                                      <input type="password" class="validate[required,equals[password]] medium"  name="passwordCon" id="passwordCon"  /><label>Confirm New Password</label>
                                            <span class="f_help"> Your password should be at least 6 characters.</span>
                                      </div>
                                      </div>                                                        
                                      <div class="section last">
                                      <div>
                                        <a class="uibutton submit_form" >Update</a><a class="uibutton special"   onClick="ResetForm()" title="Reset  Form"   >Clear Form</a>
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