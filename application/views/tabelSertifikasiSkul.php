<script type="text/javascript">
  function jumlahTotal(id){
    var sum = 0;
    $('.'+id).each(function(){
        sum += parseFloat($(this).text());  //Or this.innerHTML, this.innerText
    });
    $('.'+id+'hasil').html(sum);
  }
</script>                                                                           
                              <div class="tab_content">                                 
                                <table class="tabels">
                                    <tr>
                                        <td rowspan="2" class="juduls">NO</td><td rowspan="2" class="juduls">NAMA</td><td colspan="9">TAHUN SERTIFIKASI</td>
                                    </tr>
                                    <tr>
                                        <td>2006</td><td>2007</td><td>2008</td><td>2009</td><td>2010</td><td>2011</td><td>2012</td><td>2013</td><td>2014</td>
                                    </tr>
                                    <?php
                                    $n = 1;
                                    $jum = "jum";  
                                    foreach($kueri as $kunci => $detail)
                                    {
                                      $pecah_kec = explode("-", $kunci);
                                      ?>
                                      <tr>
                                          <td><?php echo $n; ?></td><td align="left"><?php echo $pecah_kec[0]; ?></td>
                                          <?php
                                          foreach($detail as $key => $detail_tingkat)
                                          {
                                            $key = str_replace(" ", "_", $key);                                                                                                                                    
                                            //echo "<td class='".$jum.$key."laki'>".$detail_tingkat['jumlah']."</td>";                                            
                                            echo "<td class='".$jum.$key."laki'><a href='".base_url()."viewer/daftar/".$viewene."/".$pecah_kec[1]."/".$id."/1/1/".$key."'>".$detail_tingkat['jumlah']."</a></td>";
                                          }
                                          if($n == count($kueri))
                                          {
                                            echo "</tr><tr><td colspan='2' align='right'>Jumlah</td>";
                                            foreach($detail as $key => $detail_kueris)
                                            {                                  
                                              $key = str_replace(" ", "_", $key);                                                  
                                              echo "<td class='".$jum.$key."lakihasil'><script type='text/javascript'> jumlahTotal('".$jum.$key."laki'); </script></td>";                                               
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