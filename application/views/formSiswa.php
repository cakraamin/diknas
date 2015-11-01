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
          <?php
          for($i=1;$i<=$kelas;$i++)
          {
              ?>
                <li><a href="#step-<?=$i?>">
                    <label class="stepNumber"><?=$i?></label>
                    <span class="stepDesc">Kelas <?=$i?><br />
                       <small><?=$jenjang?> Kelas <?=$i?></small>
                    </span>
                </a></li>
              <?php
          }
          ?>          
        </ul>
        <?php
          for($i=1;$i<=$kelas;$i++)
          {
              //print_r($prodi);
              //echo $this->session->userdata('id_school');
              ?>                
                <div id="step-<?=$i?>">  
                  <input type="hidden" name="jenis" id="jenis" value="simpan_siswa">                         
                  <p>Silahkan isikan seluruh form inputan sesuai dengan petunjuk yang telah disediakan sesuai dengan kelas masing-masing</p>
                    <div id="pesan"></div>
                    <h2>Data Siswa <?=$jenjang?> kelas <?=$i?> </h2>                  
                    <form method="POST" action="<?=base_url()?>siswa/simpan_siswa" id="wizardsss<?=$i?>">
                      <?php
                      if($i == 1)
                      {
                        $keter = $this->arey->getNamaSebelumnya($tingkat);
                        ?>
                        <div class="section numericonly">
                        <label> <?php echo $keter['1']; ?>  </label>
                        <div>
                        <input type="text"  placeholder="Jumlah" name="daftar_tk_lk_<?=$i?>" id="daftar_tk_lk_<?=$i?>"  class="validate[required,] large daftar<?=$i?>" value="<?php if(isset($kueri[$i]['daftar']['daftar_tk_lk'])){ echo $kueri[$i]['daftar']['daftar_tk_lk']; } ?>"  />                        
                        </div>
                        <label> <?php echo $keter['2']; ?>  </label>
                        <div>
                        <input type="text"  placeholder="Jumlah" name="daftar_tk_pr_<?=$i?>" id="daftar_tk_pr_<?=$i?>"  class="validate[required,] large daftar<?=$i?>" value="<?php if(isset($kueri[$i]['daftar']['daftar_tk_pr'])){ echo $kueri[$i]['daftar']['daftar_tk_pr']; } ?>"  />                        
                        </div>
                        </div>
                        <div class="section numericonly">
                        <label> <?php echo $keter['3']; ?>  </label>
                        <div>
                        <input type="text"  placeholder="Jumlah" name="daftar_no_tk_lk_<?=$i?>" id="daftar_no_tk_lk_<?=$i?>"  class="validate[required,] large daftar<?=$i?>" value="<?php if(isset($kueri[$i]['daftar']['daftar_no_tk_lk'])){ echo $kueri[$i]['daftar']['daftar_no_tk_lk']; } ?>"  />                        
                        </div>
                        <label> <?php echo $keter['4']; ?>  </label>
                        <div>
                        <input type="text"  placeholder="Jumlah" name="daftar_no_tk_pr_<?=$i?>" id="daftar_no_tk_pr_<?=$i?>"  class="validate[required,] large daftar<?=$i?>" value="<?php if(isset($kueri[$i]['daftar']['daftar_no_tk_pr'])){ echo $kueri[$i]['daftar']['daftar_no_tk_pr']; } ?>"  />                        
                        </div>
                        </div>
                        <div class="section numericonly">
                        <label> <?php echo $keter['5']; ?>  </label>
                        <div>
                        <input type="text"  placeholder="Jumlah" name="siswa_tk_lk_<?=$i?>" id="siswa_tk_lk_<?=$i?>"  class="validate[required,] large peserta<?=$i?>" value="<?php if(isset($kueri[$i]['daftar']['peserta_tk_lk'])){ echo $kueri[$i]['daftar']['peserta_tk_lk']; } ?>"  />                        
                        </div>
                        <label> <?php echo $keter['6']; ?>  </label>
                        <div>
                        <input type="text"  placeholder="Jumlah" name="siswa_tk_pr_<?=$i?>" id="siswa_tk_pr_<?=$i?>"  class="validate[required,] large peserta<?=$i?>" value="<?php if(isset($kueri[$i]['daftar']['peserta_tk_pr'])){ echo $kueri[$i]['daftar']['peserta_tk_pr']; } ?>"  />                        
                        </div>
                        </div>
                        <div class="section numericonly">
                        <label> <?php echo $keter['7']; ?>  </label>
                        <div>
                        <input type="text"  placeholder="Jumlah" name="siswa_no_tk_lk_<?=$i?>" id="siswa_no_tk_lk_<?=$i?>"  class="validate[required,] large peserta<?=$i?>" value="<?php if(isset($kueri[$i]['daftar']['peserta_no_tk_lk'])){ echo $kueri[$i]['daftar']['peserta_no_tk_lk']; } ?>"  />                        
                        </div>
                        <label> <?php echo $keter['8']; ?>  </label>
                        <div>
                        <input type="text"  placeholder="Jumlah" name="siswa_no_tk_pr_<?=$i?>" id="siswa_no_tk_pr_<?=$i?>"  class="validate[required,] large peserta<?=$i?>" value="<?php if(isset($kueri[$i]['daftar']['peserta_no_tk_pr'])){ echo $kueri[$i]['daftar']['peserta_no_tk_pr']; } ?>"  />                        
                        </div>
                        </div>
                        <?php
                      }
                      ?>
                      <div class="section numericonly">
                      <label> Jumlah Siswa Laki-laki  <small>Jumlah</small></label>
                      <div>
                      <input type="text"  placeholder="Jumlah Laki-laki" name="laki_<?=$i?>" id="laki_<?=$i?>"  class="validate[required,] large utama<?=$i?>" value="<?php if(isset($kueri[$i]['laki'])){ echo $kueri[$i]['laki']; } ?>"  />
                      <span class="f_help"> Jumlah Siswa Laki-laki</span> 
                      </div>                    
                      </div>
                      <div class="section numericonly">
                      <label> Jumlah Siswa Perempuan  <small>Jumlah</small></label>
                      <div>
                      <input type="text"  placeholder="Jumlah Perempuan" name="pr_<?=$i?>" id="pr_<?=$i?>"  class="validate[required,] large utama<?=$i?>" value="<?php if(isset($kueri[$i]['pr'])){ echo $kueri[$i]['pr']; } ?>"  />
                      <span class="f_help"> Jumlah Siswa Perempuan</span> 
                      </div> 
                      </div>
                      <?php
                      if(isset($kueri[$i]['umur']) AND count($kueri[$i]['umur']) > 0)                      
                      {
                        //foreach($nilai[$i] as $detil)
                        foreach($kueri[$i]['umur'] as $detil)
                        {
                        ?>
                        <div class="section numericonly">
                        <label> <?=$detil['batas']?>(Laki-laki) </label>
                        <div>
                        <input type="text"  placeholder="Jumlah" name="detill_<?=$detil['id_detail_umur']?>" id="detill_<?=$detil['id_detail_umur']?>"  class="large anak<?=$i?>" value="<?=$detil['laki']?>"/>
                        <input type="hidden" name="detilss[]" value="<?=$detil['id_detail_umur']?>">
                        </div><br/>
                        <label> <?=$detil['batas']?>(Perempuan) </label>
                        <div>
                        <input type="text"  placeholder="Jumlah" name="detilp_<?=$detil['id_detail_umur']?>" id="detilp_<?=$detil['id_detail_umur']?>"  class="large anak<?=$i?>" value="<?=$detil['pr']?>"/>
                        <input type="hidden" name="detilss[]" value="<?=$detil['id_detail_umur']?>">
                        </div>
                        </div>
                        <?php
                        }
                      }                                   
                      if(isset($kueri[$i]['prodi']) AND count($kueri[$i]['prodi']) > 0)
                      {                        
                        foreach($kueri[$i]['prodi'] as $dt_prodi)
                        {
                        $peserta = ($i == $kelas)?'[Peserta]':'';
                        $lulusan = ($i == $kelas)?'[Lulusan]':'';
                        ?>
                        <div class="section numericonly">
                        <label> <?=$dt_prodi['nama_prodi']?> <?=$peserta?>  <small>Jumlah</small></label>
                        <div>
                        <!--<input type="text"  placeholder="Jumlah" name="detilp_<?=$dt_prodi['id_detail_prodi']?>" id="detilp_<?=$dt_prodi['id_detail_prodi']?>"  class="large prodi<?=$i?>" value="<?=$dt_prodi['peserta']?>"/>
                        </div>-->
                        <input type="text"  placeholder="Jumlah" name="detilp_<?=$dt_prodi['id_detail_prodi']?>" id="detilp_<?=$dt_prodi['id_detail_prodi']?>"  class="large prodi<?=$i?>" value="<?=$dt_prodi['peserta']?>"/>
                        </div>
                        <input type="hidden" name="detilssp[]" value="<?=$dt_prodi['id_detail_prodi']?>">
                        <?php
                        if($i == $kelas)
                        {
                          ?>
                          <br/><label> <?=$dt_prodi['nama_prodi']?> <?=$lulusan?>  <small>Jumlah</small></label>
                          <div>
                          <input type="text"  placeholder="Jumlah" name="detilpl_<?=$dt_prodi['id_detail_prodi']?>" id="detilpl_<?=$dt_prodi['id_detail_prodi']?>"  class="large prodi<?=$i?>" value="<?=$dt_prodi['lulus']?>"/>
                          </div>
                          <input type="hidden" name="detilssp[]" value="<?=$dt_prodi['id_detail_prodi']?>">
                          <?php
                        }                        
                        ?>                        
                        </div>
                        <?php
                        }
                      }
                      else
                      {
                        if($i == $kelas)
                        {                          
                          ?>
                          <!--<div class="section numericonly">
                          <label> Jumlah [Peserta] UN Laki-laki  <small>Jumlah</small></label>
                          <div>
                          <input type="text"  placeholder="Jumlah" name="detilp1_0" id="detilp1_0"  class="large" value="<?=$nonprodi['peserta_l']?>"/>
                          </div><br/>
                          <label> Jumlah [Peserta] UN Perempuan  <small>Jumlah</small></label>
                          <div>
                          <input type="text"  placeholder="Jumlah" name="detilp2_0" id="detilp2_0"  class="large" value="<?=$nonprodi['peserta_p']?>"/>
                          </div><br/>
                          <label> Jumlah [Lulusan] UN Laki-laki <small>Jumlah</small></label>
                          <div>
                          <input type="text"  placeholder="Jumlah" name="detilpl1_0" id="detilpl1_0"  class="large" value="<?=$nonprodi['lulus_l']?>"/>
                          </div><br/>
                          <label> Jumlah [Lulusan] UN Perempuan<small>Jumlah</small></label>
                          <div>
                          <input type="text"  placeholder="Jumlah" name="detilpl2_0" id="detilpl2_0"  class="large" value="<?=$nonprodi['lulus_p']?>"/>
                          </div></div>
                          <input type="hidden" name="detilssp" value="<?=$nonprodi['id_detail_prodi']?>">-->
                          <?php
                        }
                      }
                      if(count($kueri[$i]['jurusn']) > 0)
                      {
                        if($i == $kelas)                       
                        {
                          ?>
                          <div class="section numericonly">
                          <label> Jumlah Siswa IPA[Peserta]  <small>Jumlah</small></label>
                          <div>
                          <input type="text"  placeholder="Jumlah" name="detilp_<?=$kueri[$i]['jurusn'][0]['ipa'][0]['id_detail_prodi']?>" id="detilp_<?=$kueri[$i]['jurusn'][0]['ipa'][0]['id_detail_prodi']?>"  class="large" value="<?=$kueri[$i]['jurusn'][0]['ipa'][0]['peserta']?>"/>
                          <input type="hidden" name="detilssp[]" value="1001">
                          </div>
                          <label> Jumlah Siswa IPA[Lulusan]  <small>Jumlah</small></label>
                          <div>
                          <input type="text"  placeholder="Jumlah" name="detilpl_<?=$kueri[$i]['jurusn'][0]['ipa'][0]['id_detail_prodi']?>" id="detilpl_<?=$kueri[$i]['jurusn'][0]['ipa'][0]['id_detail_prodi']?>"  class="large" value="<?=$kueri[$i]['jurusn'][0]['ipa'][0]['lulus']?>"/>
                          <input type="hidden" name="detilssp[]" value="1001">
                          </div>
                          <label> Jumlah Siswa IPS[Peserta]  <small>Jumlah</small></label>
                          <div>
                          <input type="text"  placeholder="Jumlah" name="detilp_<?=$kueri[$i]['jurusn'][0]['ips'][0]['id_detail_prodi']?>" id="detilp_<?=$kueri[$i]['jurusn'][0]['ips'][0]['id_detail_prodi']?>"  class="large" value="<?=$kueri[$i]['jurusn'][0]['ips'][0]['peserta']?>"/>
                          <input type="hidden" name="detilssp[]" value="1002">
                          </div>
                          <label> Jumlah Siswa IPS[Lulus]  <small>Jumlah</small></label>
                          <div>
                          <input type="text"  placeholder="Jumlah" name="detilpl_<?=$kueri[$i]['jurusn'][0]['ips'][0]['id_detail_prodi']?>" id="detilpl_<?=$kueri[$i]['jurusn'][0]['ips'][0]['id_detail_prodi']?>"  class="large" value="<?=$kueri[$i]['jurusn'][0]['ips'][0]['lulus']?>"/>
                          <input type="hidden" name="detilssp[]" value="1002">
                          </div>
                          <?php
                          if($jenis == 1)
                          {
                            ?>
                            <label> Jumlah Siswa Bahasa[Peserta]  <small>Jumlah</small></label>
                            <div>
                            <input type="text"  placeholder="Jumlah" name="detilp_<?=$kueri[$i]['jurusn'][1]['bahasa'][0]['id_detail_prodi']?>" id="detilp_<?=$kueri[$i]['jurusn'][1]['bahasa'][0]['id_detail_prodi']?>"  class="large" value="<?=$kueri[$i]['jurusn'][1]['bahasa'][0]['peserta']?>"/>
                            <input type="hidden" name="detilssp[]" value="1003">
                            </div><br/>
                            <label> Jumlah Siswa Bahasa[Lulus]  <small>Jumlah</small></label>
                            <div>
                            <input type="text"  placeholder="Jumlah" name="detilpl_<?=$kueri[$i]['jurusn'][1]['bahasa'][0]['id_detail_prodi']?>" id="detilpl_<?=$kueri[$i]['jurusn'][1]['bahasa'][0]['id_detail_prodi']?>"  class="large" value="<?=$kueri[$i]['jurusn'][1]['bahasa'][0]['lulus']?>"/>
                            <input type="hidden" name="detilssp[]" value="1003">
                            </div>
                            <?php
                          }
                          else
                          {
                            ?>
                            <label> Jumlah Siswa Keagamaan[Peserta]  <small>Jumlah</small></label>
                            <div>
                            <input type="text"  placeholder="Jumlah" name="detilp_<?=$kueri[$i]['jurusn'][1]['keagamaan'][0]['id_detail_prodi']?>" id="detilp_<?=$kueri[$i]['jurusn'][1]['keagamaan'][0]['id_detail_prodi']?>"  class="large" value="<?=$kueri[$i]['jurusn'][1]['keagamaan'][0]['peserta']?>"/>
                            <input type="hidden" name="detilssp[]" value="1004">
                            </div><br/>
                            <label> Jumlah Siswa Keagamaan[Lulus]  <small>Jumlah</small></label>
                            <div>
                            <input type="text"  placeholder="Jumlah" name="detilpl_<?=$kueri[$i]['jurusn'][1]['keagamaan'][0]['id_detail_prodi']?>" id="detilpl_<?=$kueri[$i]['jurusn'][1]['keagamaan'][0]['id_detail_prodi']?>"  class="large" value="<?=$kueri[$i]['jurusn'][1]['keagamaan'][0]['lulus']?>"/>
                            <input type="hidden" name="detilssp[]" value="1004">
                            </div>
                            <?php
                          }
                          ?>
                          </div>
                        <?php
                        }
                        else
                        {
                        ?>
                          <div class="section numericonly">
                          <label> Jumlah Siswa IPA  <small>Jumlah</small></label>
                          <div>
                          <input type="text"  placeholder="Jumlah" name="detilp_<?=$kueri[$i]['jurusn'][0]['ipa'][0]['id_detail_prodi']?>" id="detilp_<?=$kueri[$i]['jurusn'][0]['ipa'][0]['id_detail_prodi']?>"  class="large" value="<?=$kueri[$i]['jurusn'][0]['ipa'][0]['peserta']?>"/>
                          <input type="hidden" name="detilssp[]" value="1001">
                          </div>
                          <label> Jumlah Siswa IPS  <small>Jumlah</small></label>
                          <div>
                          <input type="text"  placeholder="Jumlah" name="detilp_<?=$kueri[$i]['jurusn'][0]['ips'][0]['id_detail_prodi']?>" id="detilp_<?=$kueri[$i]['jurusn'][0]['ips'][0]['id_detail_prodi']?>"  class="large" value="<?=$kueri[$i]['jurusn'][0]['ips'][0]['peserta']?>"/>
                          <input type="hidden" name="detilssp[]" value="1002">
                          </div>
                          <?php
                          if($jenis == 1)
                          {
                            ?>
                            <label> Jumlah Siswa Bahasa  <small>Jumlah</small></label>
                            <div>
                            <input type="text"  placeholder="Jumlah" name="detilp_<?=$kueri[$i]['jurusn'][1]['bahasa'][0]['id_detail_prodi']?>" id="detilp_<?=$kueri[$i]['jurusn'][1]['bahasa'][0]['id_detail_prodi']?>"  class="large" value="<?=$kueri[$i]['jurusn'][1]['bahasa'][0]['peserta']?>"/>
                            <input type="hidden" name="detilssp[]" value="1003">
                            </div>
                            <?php
                          }
                          else
                          {
                            ?>
                            <label> Jumlah Siswa Keagamaan  <small>Jumlah</small></label>
                            <div>
                            <input type="text"  placeholder="Jumlah" name="detilp_<?=$kueri[$i]['jurusn'][1]['keagamaan'][0]['id_detail_prodi']?>" id="detilp_<?=$kueri[$i]['jurusn'][1]['keagamaan'][0]['id_detail_prodi']?>"  class="large" value="<?=$kueri[$i]['jurusn'][1]['keagamaan'][0]['peserta']?>"/>
                            <input type="hidden" name="detilssp[]" value="1004">
                            </div>
                            <?php
                          }
                          ?>
                          </div>
                        <?php
                        }
                      }
                      ?> 
                      <div class="section numericonly">
                        <label> Siswa Mengulang(Laki-Laki) </label>
                        <div>
                        <input type="text" placeholder="Jumlah Siswa Mengulang Laki-laki" name="mengulang_lk_<?=$i?>" id="mengulang_lk_<?=$i?>"  class="large" value="<?php if(isset($kueri[$i]['ulang_lk'])){ echo $kueri[$i]['ulang_lk']; } ?>"/>
                        </div>  
                        <label> Siswa Mengulang(Perempuan) </label>
                        <div>
                        <input type="text" placeholder="Jumlah Siswa Mengulang Perempuan" name="mengulang_pr_<?=$i?>" id="mengulang_pr_<?=$i?>"  class="large" value="<?php if(isset($kueri[$i]['ulang_pr'])){ echo $kueri[$i]['ulang_pr']; } ?>"/>
                        </div>                          
                      </div>
                      <div class="section numericonly">                        
                        <label> Siswa Putus Sekolah(Laki-laki) </label>
                        <div>
                        <input type="text" placeholder="Jumlah Siswa Putus Sekolah Laki-laki" name="kel_lk_<?=$i?>" id="kel_lk_<?=$i?>"  class="large" value="<?php if(isset($kueri[$i]['kel_lk'])){ echo $kueri[$i]['kel_lk']; } ?>"/>
                        </div>                          
                        <label> Siswa Putus Sekolah(Perempuan) </label>
                        <div>
                        <input type="text" placeholder="Jumlah Siswa Putus Sekolah Perempuan" name="kel_pr_<?=$i?>" id="kel_pr_<?=$i?>"  class="large" value="<?php if(isset($kueri[$i]['kel_pr'])){ echo $kueri[$i]['kel_pr']; } ?>"/>
                        </div>                          
                      </div>              
                      <div class="section numericonly">                        
                        <label> Siswa Pindah Masuk </label>
                        <div>
                        <input type="text" placeholder="Jumlah Siswa Pindah Masuk" name="masuk_<?=$i?>" id="masuk_<?=$i?>"  class="large" value="<?php if(isset($kueri[$i]['masuk'])){ echo $kueri[$i]['masuk']; } ?>"/>
                        </div>
                        <label> Siswa Pindah Keluar </label>
                        <div>
                        <input type="text" placeholder="Jumlah Siswa Pindah Keluar" name="keluar_<?=$i?>" id="keluar_<?=$i?>"  class="large" value="<?php if(isset($kueri[$i]['keluar'])){ echo $kueri[$i]['keluar']; } ?>"/>
                        </div>  
                      </div>
                      <div class="section numericonly">
                        <label> Jumlah Rombel </label>
                        <div>
                        <input type="text" placeholder="Jumlah Rombel" name="rombel_<?=$i?>" id="rombel_<?=$i?>"  class="large" value="<?php if(isset($kueri[$i]['rombel'])){ echo $kueri[$i]['rombel']; } ?>"/>
                        </div>  
                      </div>
                      <input type="hidden" name="jumlah" value="<?=$i?>">
                      <input type="hidden" name="kelassss" value="<?=$kelas?>">
                    </form>
                </div>                
              <?php
          }
          ?>        
      </div>
      </div>
    <!-- End SmartWizard Content -->       
                          <div class="clear"></div>
                        </div>
                      </div>                    