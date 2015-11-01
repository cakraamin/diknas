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

                                <thead>

                                  <tr>

                                    <td width="35" rowspan="2" class="juduls">NO</td>

                                    <td align="left" rowspan="2" class="juduls">Name</td>

                                    <td colspan="2" class="juduls">SD</td>

                                    <td colspan="2" class="juduls">SMP</td>                                    

                                    <td colspan="2" class="juduls">SMA</td>

                                    <td colspan="2" class="juduls">SMK</td>

                                    <td colspan="2" class="juduls">Jumlah</td>

                                  </tr>

                                  <tr>                        

                                    <td class="juduls">L</td>

                                    <td class="juduls">P</td> 

                                    <td class="juduls">L</td>

                                    <td class="juduls">P</td> 

                                    <td class="juduls">L</td>

                                    <td class="juduls">P</td> 

                                    <td class="juduls">L</td>

                                    <td class="juduls">P</td> 

                                    <td class="juduls">L</td>

                                    <td class="juduls">P</td>                                                          

                                  </tr>

                                </thead>

                                <tbody>                                

                                <?php

                                $no = 1;
                                $jum = "jum";

                                foreach($kueri as $key => $dt_kueri)

                                {                      
                                  $pecah_kec = explode("-", $key);
                                ?>

                                  <tr>

                                    <td  width="35" ><?php echo $no; ?></td>

                                    <td  align="left"><?php echo $pecah_kec[0]; ?></td>

                                    <?php
                                    $jlaki = 0;
                                    $jperemp = 0;

                                    foreach($dt_kueri as $kunci => $detail_kueri)
                                    {                                              
                                      /*echo "<td class='".$jum.$key."laki'>".$detail_kueri['laki']."</td>"; 
                                      echo "<td class='".$jum.$key."peremp'>".$detail_kueri['peremp']."</td>"; */
                                      echo "<td class='".$jum.$kunci."laki'><a href='".base_url()."viewer/daftar/".$viewene."/".$pecah_kec[1]."/".$kunci."/1'>".$detail_kueri['laki']."</a></td>"; 
                                      echo "<td class='".$jum.$kunci."peremp'><a href='".base_url()."viewer/daftar/".$viewene."/".$pecah_kec[1]."/".$kunci."/2'>".$detail_kueri['peremp']."</a></td>"; 
                                      $jlaki = $jlaki + $detail_kueri['laki'];
                                      $jperemp = $jperemp + $detail_kueri['peremp'];
                                    }
                                    ?>
                                    <td class='totallaki'><?php echo $jlaki; ?></td>
                                    <td class='totalperemp'><?php echo $jperemp; ?></td>
                                    <?php
                                    if($no == count($kueri))
                                    {
                                      echo "</tr><tr><td colspan='2' align='right'>Jumlah</td>";
                                      foreach($dt_kueri as $kunci => $detail_kueri)
                                      {                                                
                                        echo "<td class='".$jum.$kunci."lakihasil'><script type='text/javascript'> jumlahTotal('".$jum.$kunci."laki'); </script></td>"; 
                                        echo "<td class='".$jum.$kunci."peremphasil'><script type='text/javascript'> jumlahTotal('".$jum.$kunci."peremp'); </script></td>";                                         
                                      }?>                                      
                                      <td class='totallakihasil'><script type="text/javascript"> jumlahTotal('totallaki'); </script></td>
                                      <td class='totalperemphasil'><script type="text/javascript"> jumlahTotal('totalperemp'); </script></td><?php
                                    }
                                    ?>
                                  </tr>

                                  <?                                   
                                  $no++;

                                  } 

                                  ?>

                                </tbody>

                              </table>
</div>