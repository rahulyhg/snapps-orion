<?php
// $Source$
// $Id$

?>
<tr class="dgts" style="display:<?php echo $sf_params->get('commit', false) !== false ? '\'\'' : 'none' ?>;" id="<?php echo $searchContainerID ?>">
    <td><?php echo submit_tag('search', 'width="100%" height="100%"') ?></td>
    <td>&nbsp;</td>
    <td><?php echo input_tag('acct_code', $sf_params->get('acct_code'), 'size="15"') ?></td>
    <td><?php echo input_tag('description', $sf_params->get('description'), 'size="40"') ?></td>
    <td><?php echo input_tag('remarks', $sf_params->get('remarks'), 'size="20"') ?></td>    
    <td><?php echo input_tag('cpf', $sf_params->get('cpf'), 'size="20"') ?></td>
    <td><?php echo submit_tag('search', 'width="100%" height="100%"') ?></td>    
</tr> 