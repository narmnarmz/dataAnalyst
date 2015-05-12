<?php include "header.php"; ?>
	    <nav>
	        <!-- http://codepen.io/himanshu/pen/syLAh -->
	        <div class="progresss pull-right">
	          <div class="circle done">
	            <span class="label"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></span>
	            <span class="title">Import</span>
	          </div>
	          <span class="bar done"></span>
	          <div class="circle active">
	            <span class="label">2</span>
	            <span class="title">Calculate</span>
	          </div>
	          <span class="bar half"></span>
	          <div class="circle">
	            <span class="label">3</span>
	            <span class="title">Result</span>
	          </div>
	    </nav>
	    <h3 class="text-muted">Data Analyst for Business</h3>
	</div>

		<div class='alert alert-success' role='alert'><span class='glyphicon glyphicon-ok-circle' aria-hidden='true'></span> Uploading Success.</div>

		<!-- Button trigger modal -->
		<button type="button" class="btn btn-success" data-toggle="modal" data-target="#intervalEstimate">
		  Estimate (µ)
		</button>
		<button type="button" class="btn btn-success" data-toggle="modal" data-target="#estimateDif">
		  Estimate (µ1-µ2)
		</button> <br><br>

		<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#estimateP">
		  Estimate (P)
		</button>

		<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#estimatePDiff">
		  Estimate (P1-P2)
		</button>

		<?php
			$uploaddir = "uploads/";
			$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

			if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
				rename('uploads/'.$_FILES['userfile']['name'], 'uploads/data.csv');
			} else {
			    echo "Failure.\n";
			}

			// echo 'Here is some more debugging info:';
			// print_r($_FILES);

			$row = 1;
			$group = array();
			if (($handle = fopen("uploads/data.csv", "r")) !== FALSE) {
				echo "<h3>Your Data.</h3>";
				echo "<table class='table table-bordered'>";
			    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			        $num = count($data);
			        //echo "<p> $num fields in line $row: <br /></p>\n";
			        echo "<tr>";
			        $row++;
			        for ($c=0; $c < $num; $c++) {
			            //echo $data[$c] . "<br />\n";
			            echo "<td>".$data[$c]."</td>";

			            if (array_key_exists($data[$c], $group)) {
			            	$group[$data[$c]] = $group[$data[$c]]+1;
			            } 
			            else
			            {
			            	$group[$data[$c]] = 1;
			            }
			        }
			        echo "</tr>";
			    }
			    echo "</table>";
			    //echo print_r($group);
			    fclose($handle);
			}

		?>

		<!-- Modal -->
		<form action="intervalEstimate.php" method="POST">
			<div class="modal fade bs-example-modal-sm" id="intervalEstimate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-dialog modal-sm">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title" id="myModalLabel">Interval Estimate (µ)</h4>
			      </div>
			      <div class="modal-body">
			        Input Reliability
			        <select name="sig" class="form-control">
			        	<option value="0">90%</option>
			        	<option value="1">95%</option>
			        </select>

			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        <input type="submit" value="Submit" class="btn btn-primary">
			      </div>
			    </div>
			  </div>
			</div>
		</form>

		<!-- Modal -->
		<form action="estimateDif.php" method="POST">
			<div class="modal fade bs-example-modal-sm" id="estimateDif" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-dialog modal-sm">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title" id="myModalLabel">Estimate (µ1-µ2)</h4>
			      </div>
			      <div class="modal-body">
			        Input Reliability
			        <select name="sig" class="form-control">
			        	<option value="0">90%</option>
			        	<option value="1">95%</option>
			        </select>

			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        <input type="submit" value="Submit" class="btn btn-primary">
			      </div>
			    </div>
			  </div>
			</div>
		</form>
		<form action="estimateP.php" method="POST" class="form-horizontal">
			<div class="modal" id="estimateP" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title" id="myModalLabel">IntervalEstimate (P)</h4>
			      </div>
			      <div class="modal-body">

					Group Setting<br>
					<?php
					$loop=0;
					foreach (array_keys($group) as $paramName) {
						$loop++;
						if ($loop>2) {
							break;
						}
						echo "<div class='form-group'>";
						echo    "<label for='inputEmail3' class='col-sm-2 control-label'>Case: ".$paramName."</label>";
						echo 	"<div class='col-sm-10'>";
						echo    	"<input name='groupName".$paramName."' type='text' class='form-control' id='exampleInputEmail1' placeholder='Category Name' required>";
						echo 	"</div>";
						echo "</div>";
					}	
					?>
					<hr>
			        Input Reliability
			        <select name="sig" class="form-control">
			        	<option value="0">90%</option>
			        	<option value="1">95%</option>
			        	<option value="2">99%</option>
			        </select>

			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        <input type="submit" value="Submit" class="btn btn-primary">
			      </div>
			    </div>
			  </div>
			</div>
		</form>
		<form action="estimatePDiff.php" method="POST" class="form-horizontal">
			<div class="modal" id="estimatePDiff" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title" id="myModalLabel">IntervalEstimate (P1-P2)</h4>
			      </div>
			      <div class="modal-body">

					Group Setting<br>
					<div class='form-group'>
						<label for='inputEmail3' class='col-sm-2 control-label'>Column 1</label>
						<div class='col-sm-10'>
							<input name='colName1' type='text' class='form-control' id='exampleInputEmail1' placeholder='Column Label' required>
						</div>
					</div>
					<div class='form-group'>
						<label for='inputEmail3' class='col-sm-2 control-label'>Column 2</label>
						<div class='col-sm-10'>
							<input name='colName2' type='text' class='form-control' id='exampleInputEmail1' placeholder='Column Label' required>
						</div>
					</div>
					<hr>
					<?php
					$loop=0;
					foreach (array_keys($group) as $paramName) {
						$loop++;
						if ($loop>2) {
							break;
						}
						echo "<div class='form-group'>";
						echo    "<label for='inputEmail3' class='col-sm-2 control-label'>Case: ".$paramName."</label>";
						echo 	"<div class='col-sm-10'>";
						echo    	"<input name='groupName".$paramName."' type='text' class='form-control' id='exampleInputEmail1' placeholder='Case Name' required>";
						echo 	"</div>";
						echo "</div>";
					}	
					?>
					<hr>
			        Input Reliability
			        <select name="sig" class="form-control">
			        	<option value="0">90%</option>
			        	<option value="1">95%</option>
			        	<option value="2">99%</option>
			        </select>

			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        <input type="submit" value="Submit" class="btn btn-primary">
			      </div>
			    </div>
			  </div>
			</div>
		</form>
<?php include "footer.php"; ?>


