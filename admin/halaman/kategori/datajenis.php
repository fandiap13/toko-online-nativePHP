<?php 

include '../../../function.php';

$i = 1;
$result = query("SELECT * FROM jenis ORDER BY `id_jenis` DESC");
foreach ($result as $data) :

?>
  <tr>
      <td><?= $i; ?>.</td>
      <td><?= $data['jenis']; ?></td>
      <td>
        <button type="button" class="btn btn-warning btn-circle" onclick="tampiledit('<?= $data['id_jenis']; ?>')">
          <i class="fas fa-tags"></i>
        </button>

        <button type="button" class="btn btn-danger btn-circle" onclick="hapus('<?= $data['id_jenis']; ?>', '<?= $data['jenis']; ?>')">
          <i class="fas fa-trash"></i>
        </button>

      </td>
  </tr>
<?php
$i++;
endforeach; ?>
