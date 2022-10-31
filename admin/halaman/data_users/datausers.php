<?php 

include '../../../function.php';

$i = 1;
$result = query("SELECT * FROM users ORDER BY `user_id` DESC");
foreach ($result as $data) :

?>
<tr>
  <td><?= $i; ?></td>
  <td><a href="../assets/img/<?= $data['foto_user']; ?>" class="perbesar"><img src="../assets/img/<?= $data['foto_user']; ?>" style="width: 100px;"></a></td>
  <td><?= $data['username']; ?></td>
  <td><?= $data['nama_lengkap']; ?></td>
  <td><?= $data['jk_user']; ?></td>
  <td>
    <button type="button" class="btn btn-warning btn-circle" onclick="tampiledit('<?= $data['user_id']; ?>')">
      <i class="fas fa-tags"></i>
    </button>

    <button type="button" class="btn btn-danger btn-circle" onclick="hapus('<?= $data['user_id']; ?>', '<?= $data['username']; ?>')">
      <i class="fas fa-trash"></i>
    </button>

    <button type="button" class="btn btn-success btn-circle" onclick="detail('<?= $data['user_id']; ?>')">
      <i class="fas fa-eye"></i>
    </button>
  </td>
</tr>
<?php
$i++;
endforeach; ?>
