<form action="<?=base_url()?>viewer/submit/1" method="POST" enctype="multipart/form-data">

<div class="topcolumn">

            <div class="logo"></div>

                            <ul  id="shortcut">
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
                              <span class="kosongs"><label class="tabeless">Jenis Viewer</label><?php echo form_dropdown('jenis_view', $viewer,$viewene); ?></span>                              
                              <!--<span id="kac" <?php echo ($jenise == 1)?"style=display:none;":""; ?>><label>Kecamatan</label><?php echo form_dropdown('kecamatan', $kecamatan,$kece); ?></span>
                              <span><label>Status Guru</label><?php echo form_dropdown('status_view', $status,$statuse); ?></span>
                              <span><label>Jenjang Sekolah</label><?php echo form_dropdown('jenjang_view', $jenjang,$jenjange); ?></span>-->
                              <span class="kiri"><?php echo form_submit('submit', 'Generate!','class="kiri tombole uibutton submit_form"'); ?></span>
                              <?php
                              if($this->uri->segment(2) != 'guru')
                              {
                                ?><span><a href="<?php echo base_url(); ?>viewer/guru/<?php echo $viewene; ?>" class="kembali uibutton submit_form">Kembali</a></span><?php
                              }
                              ?><br/>
                              <?php $this->load->view($tabele); ?>
</form>
          </div>
</div>