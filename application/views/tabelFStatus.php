<script type="text/javascript">
  function jumlahTotal(id){
    var sum = 0;
    $('.'+id).each(function(){
        sum += parseFloat($(this).text());  //Or this.innerHTML, this.innerText
    });
    $('.'+id+'hasil').html(sum);
  }
</script>
<div id="tabs">
<table class="tabels">

                                <thead>

                                  <tr>

                                    <td width="35" rowspan="2" class="juduls">NO</td>

                                    <td align="left" rowspan="2" class="juduls">Name</td>

                                    <td colspan="2" class="juduls">GTT/PTT/Honorer</td>

                                    <td colspan="2" class="juduls">GTY/PTY</td>

                                    <td colspan="2" class="juduls">PNS</td>

                                    <td colspan="2" class="juduls">Jumlah</td>
                                  </tr>

                                  <tr>                        

                                    <td class="juduls" width="75">L</td>

                                    <td class="juduls" width="75">P</td> 

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

                                    <td  align="left"><a href="<?php echo base_url(); ?>home/detail/<?php echo $viewene; ?>/<?php echo $pecah_kec[1]; ?>"><?php echo $pecah_kec[0]; ?></a></td>

                                    <?php
                                    $jlaki = 0;
                                    $jperemp = 0;

                                    foreach($dt_kueri as $key => $detail_kueri)
                                    {
                                      /*echo "<td class='".$jum.$key."laki'>".$detail_kueri['laki']."</td>"; 
                                      echo "<td class='".$jum.$key."peremp'>".$detail_kueri['peremp']."</td>";*/
                                      echo "<td class='".$jum.$key."laki'>".$detail_kueri['laki']."</td>"; 
                                      echo "<td class='".$jum.$key."peremp'>".$detail_kueri['peremp']."</td>"; 
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
                                      foreach($dt_kueri as $key => $detail_kueri)
                                      {                                                
                                        echo "<td class='".$jum.$key."lakihasil'><script type='text/javascript'> jumlahTotal('".$jum.$key."laki'); </script></td>"; 
                                        echo "<td class='".$jum.$key."peremphasil'><script type='text/javascript'> jumlahTotal('".$jum.$key."peremp'); </script></td>";                                         
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