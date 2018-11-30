<DOCTYPE html>
<html>
	<head>
		<!--<link rel="stylesheet" type="text/css" href="bootstrap.css">-->
		<link rel="stylesheet" type="text/css" href="/assets/vendor/bootstrap.min.css">
		<!--<link rel="stylesheet" type="text/css" href="bootstrap-extra.css">-->
		<link rel="stylesheet" type="text/css" href="/assets/vendor/bootstrap-extra.min.css">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<style type="text/css">
		.factura_details p{margin:0 0 0 0!important;
		}
		.factura{
		border-collapse: collapse; 
		width: 100%; 
		border-top:1px solid #DDDDDD; 
		border-left:1px solid #DDDDDD; 
		margin-bottom:20px;
		margin-bottom:0px;
		}
		.factura thead tr td{
			font-size: 12px; 
			border-right: 1px solid #DDDDDD; 
			border-bottom: 1px solid #DDDDDD;
			font-weight:bold; 
			text-align:center; 
			padding: 7px; 
			color: #222222;
		}
		.factura tbody tr td{
			font-size: 12px; 
			border-right: 1px solid #DDDDDD; 
			border-bottom: 1px solid #DDDDDD; 
			font-weight: bold;
			padding: 7px; 
			color: #222222;
		}
		#termen{
			font-size: 12px;
			border-right: 1px solid #DDDDDD; 
			border-bottom: 1px solid #DDDDDD;
			border-top:1px solid #DDDDDD; 
			font-weight: bold; 
			text-align: left; 
			padding: 2px;
			padding-left:10px; 
			color: #222222;
		}
		.factura tbody tr:last-child td{
			font-size: 12px;
			border-right: 1px solid #DDDDDD; 
			border-bottom: 1px solid #DDDDDD;
			border-top:1px solid #DDDDDD; 
			font-weight: bold;
			padding: 7px; 
			color: #222222;
		}
		#company_footer{
			margin:0;
		}

		.factura #stanga{
			text-align:left; 
		}
		.factura #dreapta{
			text-align:right; 
		}
		.factura #centru{
			text-align:center; 
		}
		body{
			background-color: #fbfbfb;
		}
	</style>
	</head>
	<body>

		<div class="container" style="width:680px;margin-top:50px;">
			<div class="row">
				<div class="col-lg-4" style="padding:0; text-align: center">
					<img style="max-width: 140px;margin-top: -20px;background: #1b5784;border-radius: 50px;" src="/wp-content/uploads/2016/06/logo.png">
				</div>
					<div class="col-lg-8" style="border-top:1px solid #000000;margin-top:30px;padding:0;">
						<div style="float:right;">
							<p style="margin-top:-35px;font-size:25px;text-align:right;"> Proforma #00<?php echo $detalii->id ?> </p>
							<p style="text-align:right;margin-top:30px;"> Seria PFDYN nr. <?php echo $detalii->id ?> <br> Data (zi/luna/an): <?php echo $detalii->dataemitere ?> </p>
						</div>
					</div>
			</div>
			<div class="factura_details" style="width:662.5px;margin-top:-15px;border-top:1px solid #000000">
						<div class="row" style="margin-top:10px;">
							<div class="col-lg-6">
								<p style="font-weight:bold;font-size:17px;">DYNAMIC INVESTMENT SRL</p>
								<p>Reg. com.: J51/88/2007</p>
								<p>CIF:RO21062472</p>
								<p>Adresa: Str. Alexandru Ioan Cuza , nr 21, Fundulea, Jud. Calarasi</p>
								<p>IBAN:RO66RNCB0292069908940001</p>
								<p>Banca:BANCA COMERCIALA ROMANA</p>
								<p>Capital social: 10000 </p>
							</div>
							<div class="col-lg-6">
								<p>Client: <?php echo $detalii->nume ?> </p>
								<p>Telefon: <?php echo $detalii->telefon ?> </p>
								<p>Email: <?php echo $detalii->email ?> </p>
							</div>
						</div>
			</div>
			<div style="width:670px;margin-bottom:50px;margin-top:10px;">
				<table class="factura">
					<thead>
						<tr>
							<td>Nr. crt</td>
							<td>Denumirea produselor si a serviciilor</td>
							<td> U.M.</td>
							<td> Cant. </td>
							<td> Pret unitar <br> - Lei - </td>
							<td> Valoarea <br> - Lei - </td>
						</tr>
					</thead>
					<tbody>
						<tr>
		        			<td id="centru">0</td>
		        			<td id="centru">1</td>
		        			<td id="centru">2</td>
		        			<td id="centru">3</td>
		        			<td id="centru">4</td>
		        			<td id="centru">5(3x4)</td>
		      			</tr>

		      			<?php $i = 1; ?>

		      			<?php if($detalii->costcazare): ?>
			      			<tr style="height:40px">
			        			<td id="centru"><?php echo $i ?></td>
			        			<td id="stanga">Servicii cazare Total - Loc <?php echo $date_loc->id_loc ?> - <?php echo $date_loc->descriere ?>  </td>
			        			<td id="centru">buc.</td>
			        			<td id="dreapta">1</td>
			        			<td id="dreapta"> <?php echo $detalii->costcazare ?> </td>
			        			<td id="dreapta"> <?php echo $detalii->costcazare ?></td>
	      					</tr>
	      					<?php $i = $i+1; ?>
	      				<?php endif ?>
		      			
		      			<?php if($detalii->nrcr): ?>
			      			<tr style="height:40px">
			        			<td id="centru"><?php echo $i ?></td>
			        			<td id="stanga">Pachete Pescuit Catch and Release</td>
			        			<td id="centru">buc.</td>
			        			<td id="dreapta"><?php echo $detalii->nrcr ?> </td>
			        			<td id="dreapta"> <?php echo $detalii->costcr ?> </td>
			        			<td id="dreapta"> <?php echo $detalii->nrcr * $detalii->costcr ?></td>
	      					</tr>
	      					<?php $i = $i+1; ?>
	      				<?php endif ?>

	      				<?php if($detalii->nrrc): ?>
			      			<tr style="height:40px">
			        			<td id="centru"><?php echo $i ?></td>
			        			<td id="stanga">Pachete Pescuit Retinere</td>
			        			<td id="centru">buc.</td>
			        			<td id="dreapta"><?php echo $detalii->nrrc ?> </td>
			        			<td id="dreapta"> <?php echo $detalii->costrc ?> </td>
			        			<td id="dreapta"> <?php echo $detalii->nrrc * $detalii->costrc ?></td>
	      					</tr>
	      					<?php $i = $i+1; ?>
	      				<?php endif ?>

		      			<tr>
		        			<td id="termen" colspan="6"><p style="margin: 5 0 2;">Termen plata: 15 zile</p>
		        			</td>
		        		</tr>
		      			<tr>
		        			<td id="stanga" rowspan="2" colspan="1"><p style="width:55px;margin-top:-35px;">Semnatura si stampila furnizorului</p></td>
		        			<td id="centru" rowspan="2" colspan="2"><p style="position:absolute;margin-top:-50px;    text-align: left;">Intocmit de:<br/>DYNAMIC INVESTMENT SRL</p></td>
		        			<td id="stanga" colspan="1"><p>Total</p></td>		      					
		        			<td id="centru" colspan="2" style="height: 70px;"><p><?php echo $detalii->total ?></p></td>
		      			</tr>
		      			<tr>			
		        			<td id="stanga" colspan="3" style="height: 50px;"><p>Semnatura de primire</p></td>		      					
		        		</tr>
					</tbody>
				</table>

				<p style="margin-top:10px;font-weight: bold;" id="company_footer">DYNAMIC INVESTMENT SRL</p>
				<p id="company_footer">Email: contact@baltasolacolu.ro; Adresa web: www.baltasolacolu.ro</p>
			</div>
		</div>
	</body>
</html>