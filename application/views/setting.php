<div class="onecolumn" >
                        <div class="header"><span><span class="ico gray administrator"></span>Profile Setting</span></div>
                        <div class="clear"></div>
                        <div class="content" >
                    <div class="boxtitle min">Take a picture with Webcam</div>
                            <form id="validation_demo" action="#"> 
                            <div  class="grid1">
                                    <div class="profileSetting" >
                                            <div class="avartar"><img src="<?=base_url()?>assets/template/fingers/images/avartarB.jpg" width="200" height="200" alt="avatar" /></div>
                                           <div class="avartar">
                                           <input type="file" class="fileupload" />
                                           <p align="center"><span> OR </span>Take a picture with <a class="takeWebcam">Webcam</a></p>
                                           </div>
                                    </div>
                            </div>
                            <div  class="grid3">
                                    <div class="section webcam">
                                    <label> Take a picture<small>With  webcam</small></label>   
                                    <div> 
                                                  <div id="screen"></div>
                                                  <div class="buttonPane">
                                                      <a id="takeButton" class="uibutton">Take Me</a> <a id="closeButton" class="uibutton special">Close</a>
                                                  </div>
                                                  <div class="buttonPane hideme">
                                                      <a id="uploadAvatar" class="uibutton confirm">Upload Avartar</a> <a id="retakeButton" class="uibutton special">Retake</a> 
                                      </div>
                                    </div>
                                    </div>

                                    <div class="section ">
                                    <label> Full name<small>Text custom</small></label>   
                                    <div> 
                                    <input type="text" class="validate[required] large" name="f_required" id="f_required">
                                    </div>
                                    </div>
                                    <div class="section">
                                    <label> Login  Account  <small>Text custom</small></label>
                                    <div>
                                    <input type="text"  placeholder="Username" name="username" id="username"  class="validate[required,minSize[3],maxSize[20],] medium"  />
                                    <span class="f_help"> Username login or register. <br />Should be between 3 and not more than 20 characters.</span> 
                                    </div>
                                    <div>
                                    <input type="password" placeholder="Password" class="validate[required,minSize[3]] medium"  name="password" id="password"  />
                                    </div>
                                    </div>
                                    <div class="section ">
                                    <label>gender<small>Text custom</small></label>   
                                    <div> 
                                      <div>
                                          <input type="radio" name="opinions" id="radio-1" value="1"  class="ck"/>
                                          <label for="radio-1">Male</label>
                                      </div>
                                      <div>
                                          <input type="radio" name="opinions" id="radio-2" value="1"  class="ck"  checked="checked"/>
                                          <label for="radio-2" >Female</label>
                                      </div>
                                    </div>
                                    </div>
                                    <div class="section ">
                                    <label> Email<small>Text custom</small></label>   
                                    <div> 
                                    <input type="text" class="validate[required,custom[email]]  large" name="e_required" id="e_required">
                                    </div>
                                    </div>
                                    
                                   
                                    <div class="section last">
                                    <div>
                                      <a class="uibutton submit_form" >submitForm</a>
                                   </div>
                                   </div>
                              
                            </div>
                            </form>
                            <div class="clear"></div>


                        </div>
                    </div>
                    <!-- // End onecolumn -->