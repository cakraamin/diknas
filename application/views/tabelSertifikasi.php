<script type="text/javascript">
  function jumlahTotal(id){
    var sum = 0;
    $('.'+id).each(function(){
        sum += parseFloat($(this).text());  //Or this.innerHTML, this.innerText
    });
    $('.'+id+'hasil').html(sum);
  }
</script>
<div id="uploadTab">
                      <div class="userOnline">
                      <ul class="tabs" >
                          <?php
                          $no = 1;
                          foreach($kueri as $key => $dt_kueri)
                          {
                              $pecah_jenj = explode("-", $key);
                              echo '<li ><a href="#'.$no.'" class="statusOnline">'.$pecah_jenj[0].'</a></li>';
                              $no++;
                          }
                          ?>
                      </ul>
                      </div>  
                      <div class="tab_container" >                                                  
                          <?php
                          $no = 1;
                          $jum = "jum";
                          foreach($kueri as $mbuh => $dt_kueri)
                          {          
                              $pecah_jenj = explode("-", $mbuh);                    
                              ?>
                              <div id="<?php echo $no; ?>" class="tab_content">                                 
                                <table class="tabels">
                                    <tr>
                                        <td rowspan="2" class="juduls">NO</td><td rowspan="2" class="juduls">NAMA</td><td colspan="9">TAHUN SERTIFIKASI</td>
                                    </tr>
                                    <tr>
                                        <td>2006</td><td>2007</td><td>2008</td><td>2009</td><td>2010</td><td>2011</td><td>2012</td><td>2013</td><td>2014</td>
                                    </tr>
                                    <?php
                                    $n = 1;
                                    foreach($dt_kueri as $kunci => $detail)
                                    {
                                      $pecah_kec = explode("-", $kunci);
                                      ?>
                                      <tr>
                                          <td><?php echo $n; ?></td><td align="left"><a href="<?php echo base_url(); ?>viewer/detail/<?php echo $viewene; ?>/<?php echo $pecah_kec[1]; ?>/<?php echo $pecah_jenj[1]; ?>"><?php echo $pecah_kec[0]; ?></a></td>
                                          <?php
                                          foreach($detail as $key => $detail_tingkat)
                                          {
                                            $key = str_replace(" ", "_", $key);
                                            $mbuh = str_replace("/", "_", $mbuh);
                                            $pecah_jenj = explode("-", $mbuh);                                            
                                            //echo "<td class='".$jum.$key.$mbuh."laki'>".$detail_tingkat['jumlah']."</td>";                                            
                                            echo "<td class='".$jum.$key.$mbuh."laki'><a href='".base_url()."viewer/daftar/".$viewene."/".$pecah_kec[1]."/".$pecah_jenj[1]."/1/0/".$key."'>".$detail_tingkat['jumlah']."</a></td>";                                            
                                          }
                                          if($n == count($dt_kueri))
                                          {
                                            echo "</tr><tr><td colspan='2' align='right'>Jumlah</td>";
                                            foreach($detail as $key => $detail_kueris)
                                            {                                  
                                              $key = str_replace(" ", "_", $key);    
                                              $mbuh = str_replace("/", "_", $mbuh);          
                                              echo "<td class='".$jum.$key.$mbuh."lakihasil'><script type='text/javascript'> jumlahTotal('".$jum.$key.$mbuh."laki'); </script></td>";                                               
                                            }
                                          }
                                          ?>                                          
                                      </tr>
                                      <?php
                                      $n++;
                                    }
                                    ?>
                                </table> 
                              </div>
                              <?php
                              $no++;
                          }
                          ?>                                            
</div>
</div>