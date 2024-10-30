<?php
defined('BASEPATH') or exit('No direct script access allowed!');
?>
<table border="1" style="width: 100%; font-size: 80%;">
    <thead>
        <tr>
            <td>No</td>
            <td>EISID</td>
            <td>EISName</td>
            <td>ItemCode</td>
            <td>CreatedAt</td>
            <td>CreatedBy</td>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($result as $r) : ?>
            <tr>
                <td><?php echo $no; ?></td>
                <td><?php echo $r['item_id'] ?></td>
                <td><?php echo $r['name'] ?></td>
                <td><?php echo $r['dtmitem_code'] ?></td>
                <td><?php echo date('Y-m-d H:i', strtotime($r['dtmitem_created_at'])) ?></td>
                <td><?php echo $r['user_name'] ?></td>
            </tr>
        <?php
            $no++;
        endforeach; ?>
    </tbody>
</table>
<hr>
<h4>Are you sure to continue save ?</h4>
<button type="submit" name="btnSubmit" id="idbtnSubmitWarning" onclick="confirmsubmit_warning()" class="btn btn-sm btn-info">
    <i class="fas fa-save"></i> Save
</button>