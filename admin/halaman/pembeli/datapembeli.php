<?php 

include '../../../function.php';

$i = 1;
$result = query("SELECT * FROM pembeli ORDER BY `id_pembeli` DESC");
foreach ($result as $data) :

?>
  <tr>
      <td><?= $i; ?>.</td>
      <td><a href="../assets/img/<?= $data['foto_pembeli']; ?>" class="perbesar"><img src="../assets/img/<?= $data['foto_pembeli']; ?>" style="width: 100px;"></a></td>
      <td><?= $data['username_pembeli']; ?></td>
      <td><?= $data['nama_pembeli']; ?></td>
      <td><?= $data['jk_pembeli']; ?></td>
      <td>
        <button type="button" class="btn btn-danger btn-circle" onclick="hapus('<?= $data['id_pembeli']; ?>','<?= $data['username_pembeli']; ?>')">
          <i class="fas fa-trash"></i>
        </button>
        <button type="button" class="btn btn-success btn-circle" onclick="detail('<?= $data['id_pembeli']; ?>')">
          <i class="fas fa-eye"></i>
        </button>
      </td>
  </tr>
<?php
$i++;
endforeach; ?>
