<script type="text/javascript">
  function jumlahTotal(id){
    var sum = 0;
    $('.'+id).each(function(){
        sum += parseFloat($(this).text());
    });
    $('.'+id+'hasil').html(sum);
  }
</script>                     
<div class="tab_content" >                                                  
                          <?php                          
                          $jum = "jum";                                                          
                              ?>                              
                                <table class="tabels">
                                    <tr>
                                        <td rowspan="2" class="juduls">NO</td><td rowspan="2" class="juduls">NAMA</td><td colspan="2">Gol I</td><td colspan="2">Gol II</td><td colspan="2">Gol III</td><td colspan="2">Gol IV</td>
                                    </tr>
                                    <tr>
                                        <td>L</td><td>P</td><td>L</td><td>P</td><td>L</td><td>P</td><td>L</td><td>P</td>
                                    </tr>
                                    <?php
                                    $n = 1;
                                    foreach($kueri as $kunci => $detail)
                                    {
                                      $pecah_nama = explode("-", $kunci);
                                      ?>
                                      <tr>
                                          <td><?php echo $n; ?></td><td align="left"><?php echo $pecah_nama[0] ?></td>
                                          <?php
                                          foreach($detail as $key => $detail_tingkat)
                                          {
                                            $key = str_replace(" ", "_", $key); 
                                            $pecah_gol = explode("-", $key);
                                            echo "<td class='".$jum.$key."laki'><a href='".base_url()."viewer/daftar/".$viewene."/".$pecah_nama[1]."/".$id."/1/1/".$pecah_gol[1]."'>".$detail_tingkat['laki']."</a></td>";
                                            echo "<td class='".$jum.$key."peremp'><a href='".base_url()."viewer/daftar/".$viewene."/".$pecah_nama[1]."/".$id."/2/1/".$pecah_gol[1]."'>".$detail_tingkat['peremp']."</a></td>";
                                          }                                          
                                          if($n == count($kueri))
                                          {
                                            echo "</tr><tr><td colspan='2' align='right'>Jumlah</td>";
                                            foreach($detail as $key => $detail_kueris)
                                            {                                  
                                              $key = str_replace(" ", "_", $key);                                               
                                              echo "<td class='".$jum.$key."lakihasil'><script type='text/javascript'> jumlahTotal('".$jum.$key."laki'); </script></td>"; 
                                              echo "<td class='".$jum.$key."peremphasil'><script type='text/javascript'> jumlahTotal('".$jum.$key."peremp'); </script></td>";                                         
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