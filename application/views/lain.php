<form action="<?=base_url()?>manajemen/all_lain" method="POST" enctype="multipart/form-data">

<div class="topcolumn">

            <input type="hidden" name="links" value="paud"/>

            <div class="logo"></div>

                            <ul  id="shortcut">

                                <li> <a href="<?=base_url()?>manajemen/tambah_lain" title="Back To home"> <img src="<?=base_url()?>assets/template/fingers/images/icon/shortcut/add.png" alt="home" width="40px"/><strong>Tambah Data</strong> </a> </li>                                

                                <li> <input type="image" src="<?=base_url()?>assets/template/fingers/images/icon/shortcut/Delete.png" name="image" width="40" height="40" style="margin-top:9.5px; margin-left:17px;"><br/><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hapus</strong></li>

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

                              <table class="display static " id="static">

                                <thead>

                                  <tr>

                                    <th width="35" ><input type="checkbox" id="checkAll1"  class="checkAll"/></th>

                                    <th width="202" align="left">Name</th>

                                    <th>Level</th>       

                                    <th></th>                    

                                    <th width="199" >Management</th>

                                  </tr>

                                </thead>

                                <tbody>                                

                                <?

                                $no = 1;

                                foreach($kueri as $dt_kueri)

                                {                      

                                ?>

                                  <tr>

                                    <td  width="35" ><input type="checkbox" name="check[]" class="chkbox"  id="check<?=$no?>" value="<?=$dt_kueri->user_id?>"/></td>

                                    <td  align="left"><?=$dt_kueri->user_email?></td>                                    

                                    <td >
                                      <?
                                      $level = ($dt_kueri->id_school == 1000000)?'Kabid PTK':'Lainnya';
                                      echo $level;
                                      ?>
                                    </td>

                                    <td  align="left"></td>

                                    <td >          

                                      <span class="tip" >

                                          <a  title="Edit" href="<?=base_url()?>manajemen/edit_lain/<?=$dt_kueri->user_id?>" >

                                              <img src="<?=base_url()?>assets/template/fingers/images/icon/icon_edit.png" >

                                          </a>

                                      </span> 

                                      <span class="tip" >

                                          <a id="<?=$no?>" class="Delete"  name="Band ring" title="Delete" href="<?=base_url()?>manajemen/hapus_lain/<?=$dt_kueri->user_id?>"  >

                                              <img src="<?=base_url()?>assets/template/fingers/images/icon/icon_delete.png" >

                                          </a>

                                      </span> 

                                        </td>

                                  </tr>                                  

                                  <? 

                                  $no++;

                                  } 

                                  ?>

                                </tbody>

                              </table>

</form>

<?=$paging?>

          </div>

</div>