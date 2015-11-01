<script type="text/javascript">
$(document).ready(function(){
  var nilai = 0;
  $( "select" ).change(function() {
    nilai = $(this).val();
    changeTab(nilai);
  });
  changeTab(nilai);
});
  function changeTab(tabIndex) {
    $( "#tabs" ).tabs({
      active: tabIndex
    });
  }

  function jumlahTotal(id){
    var sum = 0;
    $('.'+id).each(function(){
        sum += parseFloat($(this).text());  //Or this.innerHTML, this.innerText
    });
    $('.'+id+'hasil').html(sum);
  }
</script>
<div id="tabs">  
  <ul style="display:none">
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
  <?php
    echo "<select class='form-control ' style='width:30%'>";
      foreach($kueri as $key => $dt_kueri)
      {
        $pecah_jenj = explode("-", $key);        
        $no = $pecah_jenj[1] - 1;
        $selek = ($no == 0)?"selected='selected'":"";
        echo "<option value='".$no."' ".$selek.">".$pecah_jenj[0]."</option>";
      }
      echo "</select>";

    $no = 1;
    $jum = "jum";
    foreach($kueri as $mbuh => $dt_kueri)
    {       
      $pecah_jenj = explode("-", $mbuh);
      ?>      
      <div id="<?php echo $no; ?>">                                 
      <table class="tabels">
        <tr>
          <td rowspan="2" class="juduls">NO</td><td rowspan="2" class="juduls">NAMA</td><td colspan="2">Gol I</td><td colspan="2">Gol II</td><td colspan="2">Gol III</td><td colspan="2">Gol IV</td>
        </tr>
        <tr>
          <td>L</td><td>P</td><td>L</td><td>P</td><td>L</td><td>P</td><td>L</td><td>P</td>
        </tr>
        <?php
        $n = 1;
        foreach($dt_kueri as $kunci => $detail)
        {
          $pecah_kec = explode("-", $kunci);
          ?>
          <tr>
            <td><?php echo $n; ?></td><td align="left"><a href="<?php echo base_url(); ?>home/detail/<?php echo $viewene; ?>/<?php echo $pecah_kec[1]; ?>/<?php echo $pecah_jenj[1]; ?>"><?php echo $pecah_kec[0]; ?></a></td>
          <?php
          foreach($detail as $key => $detail_tingkat)
          {
            $key = str_replace(" ", "_", $key);
            $mbuh = str_replace("/", "_", $mbuh);
            $pecah_jenj = explode("-", $mbuh);
            $pecah_gol = explode("-", $key);            
            echo "<td class='".$jum.$key.$mbuh."laki'>".$detail_tingkat['laki']."</td>";
            echo "<td class='".$jum.$key.$mbuh."peremp'>".$detail_tingkat['peremp']."</td>";
          }                                          
          if($n == count($dt_kueri))
          {
            echo "</tr><tr><td colspan='2' align='right'>Jumlah</td>";
            foreach($detail as $key => $detail_kueris)
            {                                  
              $key = str_replace(" ", "_", $key); 
              $mbuh = str_replace("/", "_", $mbuh);             
              echo "<td class='".$jum.$key.$mbuh."lakihasil'><script type='text/javascript'> jumlahTotal('".$jum.$key.$mbuh."laki'); </script></td>"; 
              echo "<td class='".$jum.$key.$mbuh."peremphasil'><script type='text/javascript'> jumlahTotal('".$jum.$key.$mbuh."peremp'); </script></td>";                                         
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