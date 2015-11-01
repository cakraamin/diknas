<script type="text/javascript" src="<?php echo base_url(); ?>assets/template/fingers/js/highcharts.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/template/fingers/js/jquery.highchartTable.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('table.highchart').highchartTable();
    });
</script>
<style type="text/css">
    table.highchart{
        display: none;
    }
</style>
<div class="topcolumn">
            <div class="logo"></div>
                &nbsp;
          </div> 
           <div class="clear"></div> 
           <?=$this->message->display();?>
<div class="onecolumn" >
                        <div class="header"> <span ><span class="ico gray home"></span> Home</span> </div>
                        <div class="clear"></div>
                        <div class="content" >                                                   
                            <center><h1>Selamat Datang Di Aplikasi Dinas Pendidikan</h1></center>
				<?php				
				if(is_array($graphic))
				{
					?>
				<table class="highchart" data-graph-container-before="1" data-graph-type="column">
                              <thead>
                                  <tr>
                                      <th>Jumlah</th>
                                      <th>SMK</th>
					<th>SMA/MA</th>
					<th>SMP/MTs</th>
					<th>SD/MI</th>
                                  </tr>
                               </thead>
                               <tbody>
                                    <?php
                                        foreach($graphic as $key => $dt_grafik)
                                        {
                                            echo "<tr>";
                                            echo "<td>".$key."</td>";                                            
                                            echo "<td>". $dt_grafik['smk']."</td>";
						echo "<td>". $dt_grafik['smama']."</td>";
				                echo "<td>". $dt_grafik['smpmts']."</td>";
						echo "<td>". $dt_grafik['sdmi']."</td>";
                                            echo "</tr>";
                                        }
                                    ?>                                  
                              </tbody>
                            </table> 
					<?php
				}
				?>
                            <div class="clear"></div>
                        </div>
                    </div>
