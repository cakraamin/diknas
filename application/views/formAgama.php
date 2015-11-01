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
   

    <!-- Smart Wizard -->      
      <div id="wizard" class="swMain">        
        <ul>
          <?
          for($i=1;$i<=$kelas;$i++)
          {
              ?>
                <li><a href="#step-<?=$i?>">
                    <label class="stepNumber"><?=$i?></label>
                    <span class="stepDesc">Kelas <?=$i?><br />
                       <small><?=$jenjang?> Kelas <?=$i?></small>
                    </span>
                </a></li>
              <?
          }
          ?>          
        </ul>
        <?          
          for($i=1;$i<=$kelas;$i++)
          {             
              ?>                
                <div id="step-<?=$i?>">     
                  <input type="hidden" name="jenis" id="jenis" value="simpan_agama">
                  <p>Silahkan isikan seluruh form inputan sesuai dengan petunjuk yang telah disediakan sesuai dengan kelas masing-masing</p>
                    <div id="pesan"></div>
                    <h2>Data Siswa <?=$jenjang?> kelas <?=$i?></h2>                  
                    <form method="POST" action="<?=base_url()?>siswa/simpan_agama" id="wizardsss<?=$i?>">                      
                      <div class="section numericonly">
                      <label> Agama Islam  <small>Jumlah</small></label>
                      <div>
                      <input type="text"  placeholder="Jumlah Siswa Agama Islam" name="islam_<?=$i?>" id="islam_<?=$i?>"  class="validate[required,] large utama<?=$i?>" value="<? if(isset($kueri[$i]['islam'])){ echo $kueri[$i]['islam']; } ?>"  />
                      <span class="f_help"> Jumlah Siswa Agama Islam </span> 
                      </div>                    
                      <label> Agama Kristen  <small>Jumlah</small></label>
                      <div>
                      <input type="text"  placeholder="Jumlah Siswa Agama Kristen" name="kristen_<?=$i?>" id="kristen_<?=$i?>"  class="validate[required,] large utama<?=$i?>" value="<? if(isset($kueri[$i]['kristen'])){ echo $kueri[$i]['kristen']; } ?>"  />
                      <span class="f_help"> Jumlah Siswa Agama Kristen</span> 
                      </div>                    
                      <label> Agama Katholik  <small>Jumlah</small></label>
                      <div>
                      <input type="text"  placeholder="Jumlah Siswa Agama Katholik" name="katholik_<?=$i?>" id="katholik_<?=$i?>"  class="validate[required,] large utama<?=$i?>" value="<? if(isset($kueri[$i]['katholik'])){ echo $kueri[$i]['katholik']; } ?>"  />
                      <span class="f_help"> Jumlah Siswa Agama Katholik</span> 
                      </div>                    
                      <label> Agama Budha  <small>Jumlah</small></label>
                      <div>
                      <input type="text"  placeholder="Jumlah Siswa Agama Budha" name="budha_<?=$i?>" id="budha_<?=$i?>"  class="validate[required,] large utama<?=$i?>" value="<? if(isset($kueri[$i]['budha'])){ echo $kueri[$i]['budha']; } ?>"  />
                      <span class="f_help"> Jumlah Siswa Agama Budha</span> 
                      </div>                    
                      <label> Agama Hindu  <small>Jumlah</small></label>
                      <div>
                      <input type="text"  placeholder="Jumlah Siswa Agama Hindu" name="hindu_<?=$i?>" id="hindu_<?=$i?>"  class="validate[required,] large utama<?=$i?>" value="<? if(isset($kueri[$i]['hindu'])){ echo $kueri[$i]['hindu']; } ?>"  />
                      <span class="f_help"> Jumlah Siswa Agama Hindu</span> 
                      </div>                    
                      <label> Agama Konghuchu  <small>Jumlah</small></label>
                      <div>
                      <input type="text"  placeholder="Jumlah Siswa Agama Konghuchu" name="konghuchu_<?=$i?>" id="konghuchu_<?=$i?>"  class="validate[required,] large utama<?=$i?>" value="<? if(isset($kueri[$i]['konghuchu'])){ echo $kueri[$i]['konghuchu']; } ?>"  />
                      <span class="f_help"> Jumlah Siswa Agama Konghuchu</span> 
                      </div>                    
                      </div>                      
                      <input type="hidden" name="jumlah" value="<?=$i?>">
                      <input type="hidden" name="kelassss" value="<?=$kelas?>">
                    </form>
                </div>                
              <?
          }
          ?>        
      </div>
      </div>
    <!-- End SmartWizard Content -->       
                          <div class="clear"></div>
                        </div>
                      </div>                    