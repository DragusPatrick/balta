<div class="container" style="width:90%!important;">
	<div class="row">
		<div class="col s12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="panel-title"><span class="fa fa-group"></span> Lista Rezervari</div>
				</div>
				<div class="panel-body pn">

                    <div class="form-group" style="margin-top: 25px;">

                        <?php echo form_open('newDashboard/index'); ?>

                        <?php echo form_label('Selecteaza data.'); ?>

                        <?php echo form_input(array('type' => 'date', 'id' => 'date', 'name' => 'date')); ?>
                        <?php echo form_submit(array('id' => 'submit', 'value' => 'Submit')); ?>

                        <?php echo form_close(); ?>
                    </div>


                    <table border=1 cellpadding=5 cellspaceing=5>
                        <tr colspan="6">
                            <th>LOCATIE</th>
                            <th>NUME/PRENUME</th>
                            <th>ORA SOSIRE</th>
                            <th>ORA PLECARE</th>
                            <th>TELEFON</th>
                        </tr>
                        <?php foreach ($rezervare as $rez) { ?>
                            <tr>

                                <td> <?php echo "Locul " . $rez['id_loc']; ?> </td>
                                <td> <?php echo $rez['nume']; ?> </td>

                                <?php if($rez['partial'] == 1) { ?>
                                <td> <?php echo "06:00" ?> </td>
                                <?php } elseif($rez['partial'] == 2) { ?>
                                <td> <?php echo "18:00"; ?> </td>
                                <?php } elseif($rez['partial'] == 0) { ?>
                                <td> <?php echo "06:00"; ?> </td>
                                <?php } ?>

                                <?php if($rez['partial'] == 1) { ?>
                                    <td> <?php echo "06:00" ?> </td>
                                <?php } elseif($rez['partial'] == 2) { ?>
                                    <td> <?php echo "18:00"; ?> </td>
                                <?php } elseif($rez['partial'] == 0) { ?>
                                    <td> <?php echo "06:00"; ?> </td>
                                <?php } ?>

                                <td> <?php echo $rez['telefon']; ?> </td>
                                <td><a href="newDashboard/remove/' . $rez['id_rez'] .'" class="remove btn"><i class="material-icons">delete_forever</i></a></td>
                            </tr>
                        <?php } ?>
                    </table>
				</div>
			</div>
		</div>
	</div>
</div>


