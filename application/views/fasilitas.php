<form action="<?=base_url()?>masters/all_fasilitas" method="POST" enctype="multipart/form-data">

<div class="topcolumn">

            <div class="logo"></div>

                            <ul  id="shortcut">

                                <li> <a href="<?=base_url()?>masters/tambah_fasilitas" title="Back To home"> <img src="<?=base_url()?>assets/template/fingers/images/icon/shortcut/add.png" alt="home" width="40px"/><strong>Tambah</strong> </a> </li>

                                <li><button type="submit" name="tombol" value="hapus"><img src="<?=base_url()?>assets/template/fingers/images/icon/shortcut/Delete.png" alt="Hapus" width="55px" style="margin-top:5px;"></button><br/><strong>Hapus</strong></li>

                            </ul>

          </div>           

          <div class="clear"></div> 

          <?=$this->message->display();?>

<div class="onecolumn" >

                    <div class="header">

                    <span ><span class="ico  gray spreadsheet"></span> Daftar Fasilitas Sekolah </span>

                    </div><!-- End header --> 

                    <div class=" clear"></div>

                    <div class="content" >                      

                              <?

                              $selek = (isset($jenjang))?$jenjang:0;

                              $jp = "data-placeholder='Jenjang Sekolah...' onchange='this.form.submit()'";

                              echo form_dropdown('jenjang', $jenj, $selek,$jp);

                              ?>

                              <table class="display static " id="static">

                                <thead>

                                  <tr>

                                    <th width="35" ><input type="checkbox" id="checkAll1"  class="checkAll"/></th>

                                    <th>Name Fasilitas</th>

                                    <th>Jenjang Fasilitas</th>

                                    <th>Jenis Fasilitas</th>                                    

                                    <th width="150">Jumlah Fasilitas</th>

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

                                    <td  width="35" ><input type="checkbox" name="check[]" class="chkbox"  id="check<?=$no?>" value="<?=$dt_kueri['id_fasilitas']?>"/></td>

                                    <td  align="left"><?=$dt_kueri['nama_fasilitas']?></td>

                                    <td  align="left"><?

                                    $i = 1;

                                    foreach ($dt_kueri['detil'] as $detail) 

                                    {

                                        $hub = ($i == count($dt_kueri['detil']))?"":", ";

                                        echo $this->arey->getJenjang($detail->jenjang_school).$hub;

                                        $i++;

                                    }

                                    ?></td>

                                    <td  align="left"><?php echo $this->arey->getJenis($dt_kueri['jenis_fasilitas']); ?></td>

                                    <td  align="left"><?=$dt_kueri['jumlah_min_fasilitas']?></td>

                                    <td >          

                                      <span class="tip" >

                                          <a  title="Edit Fasilitas" href="<?=base_url()?>masters/edit_fasilitas/<?=$dt_kueri['id_fasilitas']?>" >

                                              <img src="<?=base_url()?>assets/template/fingers/images/icon/icon_edit.png" >

                                          </a>

                                      </span> 

                                      <span class="tip" >

                                          <a id="<?=$no?>" name="Band ring" title="Delete Fasilitas" href="<?=base_url()?>masters/hapus_fasilitas/<?=$dt_kueri['id_fasilitas']?>" onclick="return confirmSubmit()">

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