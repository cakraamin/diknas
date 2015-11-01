<form action="<?=base_url()?>manajemen/all_users" method="POST" enctype="multipart/form-data">

<div class="topcolumn">

            <input type="hidden" name="links" value="<?=$id?>/<?=$nama?>"/>

            <div class="logo"></div>

                            <ul  id="shortcut">

                                <li> <a href="<?=base_url()?>manajemen/tambah_user/<?=$id?>/<?=$nama?>" title="Back To home"> <img src="<?=base_url()?>assets/template/fingers/images/icon/shortcut/add.png" alt="home" width="40px"/><strong>Tambah <?=$nama?></strong> </a> </li>                                

                                <li><button type="submit" name="tombol" value="hapus"><img src="<?=base_url()?>assets/template/fingers/images/icon/shortcut/Delete.png" alt="Hapus" width="55px" style="margin-top:5px;"></button><br/><strong>Hapus</strong></li>

                                <li><button type="submit" name="tombol" value="generate"><img src="<?=base_url()?>assets/template/fingers/images/icon/shortcut/generate.png" alt="GeneratePassword" width="55px"></button><br/><strong>Generate <br/>Password</strong></li>

                            </ul>

          </div>           

          <div class="clear"></div> 

          <?=$this->message->display();?>

<div class="onecolumn" >

                    <div class="header">

                    <span ><span class="ico  gray spreadsheet"></span> Daftar User </span>

                    </div><!-- End header --> 

                    <div class=" clear"></div>

                    <div class="content" >    

                              <?php

                              $selek = (isset($kec))?$kec:0;

                              $jp = "data-placeholder='Pilih Kecamatan...' onchange='this.form.submit()'";

                              echo form_dropdown('kecamatan', $kecamatan, $selek,$jp);

                              $kunci = ($kunci != "")?str_replace("-", " ", $kunci):"";

                              ?>
                              <br/><br/><input type="text" name="kunci" class="small" data-placeholder="Nama Sekolah" value="<?php echo $kunci; ?>">

                              <table class="display static " id="static">

                                <thead>

                                  <tr>

                                    <th width="35" >#</th>

                                    <th align="left">Nama Sekolah</th>

                                    <th width="160">Manajemen</th>

                                    <th width="160">Username</th>

                                    <th width="199" >Management</th>

                                  </tr>

                                </thead>

                                <tbody>                                

                                <?php

                                $no = 1;

                                foreach($kueri as $dt_kueri)

                                {                      

                                ?>

                                  <tr>

                                    <td  width="35" ><input type="checkbox" name="check[]" class="chkbox"  id="check<?=$no?>" value="<?=$dt_kueri['id_school']?>"/></td>

                                    <td  align="left"><?=$dt_kueri['nama_school']?></td>

                                    <td align="center">
                                      <?php
                                      if($dt_kueri['kode'] != 0){ echo '<a href="'.base_url().'manajemen/set_role/'.$dt_kueri['kode'].'">Roles</a> | <a href="'.base_url().'manajemen/set_permission/'.$dt_kueri['kode'].'">Permissions</a>'; }
                                      ?>
                                    </td>

                                    <td  align="center"><?=$dt_kueri['status']?></td>

                                    <td >          
                                      <?php
                                      if($dt_kueri['kode'] != 0)
                                      {
                                        ?>
                                        <span class="tip" >

                                          <a  title="Edit" href="<?=base_url()?>manajemen/edit_user/<?=$id?>/<?=url_title($nama)?>/<?=$dt_kueri['kode']?>" >

                                              <img src="<?=base_url()?>assets/template/fingers/images/icon/icon_edit.png" >

                                          </a>

                                      </span> 

                                      <span class="tip" >

                                          <a id="<?=$no?>" name="Band ring" title="Delete" href="<?=base_url()?>manajemen/hapus_user/<?=$dt_kueri['kode']?>/<?=$id?>/<?=url_title($nama)?>" onclick="return confirmSubmit()">

                                              <img src="<?=base_url()?>assets/template/fingers/images/icon/icon_delete.png" >

                                          </a>

                                      </span> 
                                        <?php
                                      }
                                      ?>                                      
                                        </td>

                                  </tr>                                  

                                  <?php 

                                  $no++;

                                  } 

                                  ?>

                                </tbody>

                              </table>

</form>

<?=$paging?>

          </div>

</div>