<form action="<?=base_url()?>guru/all_guru" method="POST" enctype="multipart/form-data">

<div class="topcolumn">

            <div class="logo"></div>

                            <ul  id="shortcut">

                                <li> <a href="<?=base_url()?>guru/tambah_guru" title="Back To home"> <img src="<?=base_url()?>assets/template/fingers/images/icon/shortcut/add.png" alt="home" width="40px"/><strong>Tambah</strong> </a> </li>

                                <li> <input type="image" src="<?=base_url()?>assets/template/fingers/images/icon/shortcut/Delete.png" name="image" width="40" height="40" style="margin-top:9.5px; margin-left:17px;"><br/><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hapus</strong></li>

                            </ul>

          </div>           

          <div class="clear"></div> 

          <?=$this->message->display();?>

<div class="onecolumn" >

                    <div class="header">

                    <span ><span class="ico  gray spreadsheet"></span> Daftar Guru </span>

                    </div><!-- End header --> 

                    <div class=" clear"></div>

                    <div class="content" >                      

                              <table class="display static " id="static">

                                <thead>

                                  <tr>

                                    <th width="35" ><input type="checkbox" id="checkAll1"  class="checkAll"/></th>

                                    <th align="left">Name</th>

                                    <th align="left">NUPTK</th>

                                    <th align="left">Jabatan</th>                                    

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

                                    <td  width="35" ><input type="checkbox" name="check[]" class="chkbox"  id="check<?=$no?>" value="<?=$dt_kueri->id_guru?>"/></td>

                                    <td  align="left"><?=$dt_kueri->nama_guru?></td>

                                    <td  align="left"><?=$dt_kueri->nuptk_guru?></td>

                                    <td  align="left"><?=$this->arey->getStatusGuru($dt_kueri->status_guru)?></td>                                    

                                    <td >          

                                      <span class="tip" >

                                          <a  title="Edit Guru" href="<?=base_url()?>guru/edit_guru/<?=$dt_kueri->id_guru?>" >

                                              <img src="<?=base_url()?>assets/template/fingers/images/icon/icon_edit.png" >

                                          </a>

                                      </span> 

                                      <span class="tip" >

                                          <a id="<?=$no?>" name="Band ring" title="Delete Guru" href="<?=base_url()?>guru/hapus_guru/<?=$dt_kueri->id_guru?>" onclick="return confirmSubmit()">

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