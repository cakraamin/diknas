<div class="tab_content">
<table class="tabels">
  <thead>
    <tr>
      <td width="35" class="juduls">NO</td>
      <td width="35" class="juduls">NIP/NIK</td>
      <td width="35" class="juduls">NUPTK</td>
      <td align="left" class="juduls">Nama</td>
      <td class="juduls">Sekolah</td>
      <!--<td class="juduls">Jenis Kelamin</td>
      <td class="juduls">Pendidikan</td>-->
    </tr>
  </thead>
  <tbody>
      <?php
        $no = 1;
        foreach($kueri as $key => $detail_kueri)
        {
          echo "<tr>";
          echo "<td>".$no."</td>";
          echo "<td align='left'>".$detail_kueri->nik_guru."</td>";
          echo "<td align='left'>".$detail_kueri->nuptk_guru."</td>";
          echo "<td align='left'>".$detail_kueri->nama_guru."</td>";
          echo "<td align='left'>".$detail_kueri->nama_school."</td>";
          //echo "<td></td>";
          //echo "<td></td>";
          echo "</tr>";
          $no++;
        }
      ?>
  </tbody>
</table>
</div>