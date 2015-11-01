<form action="<?=base_url()?>paud/sekolah/all_paud" method="POST" enctype="multipart/form-data">

<div class="topcolumn">

            <div class="logo"></div>

                            <ul  id="shortcut">

                                <li> <a href="<?=base_url()?>paud/sekolah/tambah_paud" title="Back To home"> <img src="<?=base_url()?>assets/template/fingers/images/icon/shortcut/add.png" alt="home" width="40px"/><strong>Tambah </strong> </a> </li>

                                <li> <a href="<?=base_url()?>paud/sekolah/import_paud" title="Import Data Sekolah"> <img src="<?=base_url()?>assets/template/fingers/images/icon/shortcut/imports.png" alt="import" width="40px"/><strong>Import </strong> </a> </li>

                                <li> <input type="image" src="<?=base_url()?>assets/template/fingers/images/icon/shortcut/Delete.png" name="image" width="40" height="40" style="margin-top:9.5px; margin-left:17px;"><br/><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hapus</strong></li>

                            </ul>

          </div>           

          <div class="clear"></div> 

          <?=$this->message->display();?>

<div class="onecolumn" >

                    <div class="header">

                    <span ><span class="ico  gray spreadsheet"></span> Daftar Sekolah </span>

                    </div><!-- End header --> 

                    <div class=" clear"></div>

                    <div class="content" >                                       

                              <?

                              $selek = (isset($kec))?$kec:0;

                              $jp = "data-placeholder='Pilih Kecamatan...' onchange='this.form.submit()'";

                              echo form_dropdown('kecamatan', $kecamatan, $selek,$jp);

                              ?>

                              <table class="display static " id="static">

                                <thead>

                                  <tr>

                                    <th width="35" ><input type="checkbox" id="checkAll1"  class="checkAll"/></th>

                                    <th align="left">Name</th>

                                    <th align="left">NSPN</th>

                                    <th align="left">Status PAUD</th>

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

                                    <td  width="35" ><input type="checkbox" name="check[]" class="chkbox"  id="check<?=$no?>" value="<?=$dt_kueri->id_pauds?>"/></td>

                                    <td  align="left"><?=$dt_kueri->nama_paud?></td>

                                    <td  align="left"><?=$dt_kueri->npns_paud?></td>

                                    <td  align="left"><?=$this->arey->getStatus($dt_kueri->status_paud)?></td>

                                    <td >          

                                      <span class="tip" >

                                          <a  title="Edit PAUDS" href="<?=base_url()?>paud/sekolah/edit_paud/<?=$dt_kueri->id_pauds?>" >

                                              <img src="<?=base_url()?>assets/template/fingers/images/icon/icon_edit.png" >

                                          </a>

                                      </span> 

                                      <span class="tip" >

                                          <a id="<?=$no?>" class="Delete"  name="Band ring" title="Delete PAUD" href="<?=base_url()?>paud/sekolah/hapus_paud/<?=$dt_kueri->id_pauds?>"  >

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