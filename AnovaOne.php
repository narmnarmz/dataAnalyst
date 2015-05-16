<?php include "header.php"; ?>

		<nav>
            <!-- http://codepen.io/himanshu/pen/syLAh -->
            <div class="progresss pull-right">
              <div class="circle done">
                <span class="label"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></span>
                <span class="title">Import</span>
              </div>
              <span class="bar done"></span>
              <div class="circle done">
                <span class="label"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></span>
                <span class="title">Calculate</span>
              </div>
              <span class="bar done"></span>
              <div class="circle active">
                <span class="label">3</span>
                <span class="title">Result</span>
              </div>

        </nav>
		<h3 class="text-muted">Data Analyst for Business</h3>
		</div>
		<h2>การวิเคราะห์ความแปรปรวนแบบจำแนกทางเดียว</h2>
		<?php 
			$file = fopen("uploads/data.csv", "r");
			$data = fgetcsv($file);
			$row = 1;
			$group = array();
			if (($handle = fopen("uploads/data.csv", "r")) !== FALSE) {
				$data = fgetcsv($handle, 1000, ",");
				
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $num = count($data);
                    $row++;
                    for ($c=0; $c < $num; $c++) {
                        array_push($group, $data[$c]);
                    }
                }
                fclose($handle);
            }
            // find count of data group ex lab6-1 = 5 group 
         	$keep = 0;
            for($i=0;$i<(count($group));$i=$i+2){
            	error_reporting(E_ALL ^ E_NOTICE);
            	if($group[$i+2] > $group[$i]){
            		$keep = $group[$i+2];
            	}
            }

            // add values to Array ex. 5 group = 5 Array
            for($k=1;$k<=$keep;$k++){
            	$$k = array();
            	for($l = 0 ; $l<count($group);$l=$l+2){
            		if($group[$l] == $k){
            			array_push($$k, $group[$l+1]);
            		}
            	}	

            }
           



            // --------------------------------------
            $sumEachValue = 0;
            for($m=1;$m<count($group);$m=$m+2){
            	
            	$eachVal = pow($group[$m], 2);
            	$sumEachValue = $sumEachValue + $eachVal;
            }
            echo $sumEachValue; 
            echo "<br>";
           	//keep sum of each array 

            // -----------------------------------------

           	$sumArray = array();
            for($n=1;$n<=$keep;$n++){

            	$sumArray[$n] = array_sum($$n)/count($$n); //ex 75 82
            	echo "<br>";
            }


            // -----------------------------------------

            $sumTN = 0;
            for($p =1 ; $p<=count($sumArray);$p++){
            	$powEachVal = pow(array_sum($$p),2)/count($$p);
            	echo "<br>";
            	$sumTN = $powEachVal + $sumTN;
            }
            echo $sumTN; // example 109828
            echo "<br>";
            //echo $sumTN;



			// -----------------------------------------
            $sumTPowN = 0;
           	for ($q=1; $q<=$keep ; $q++) { 
           		$sumTPowN = $sumTPowN + array_sum($$q);
           	}
           	echo $reTPowN = pow($sumTPowN,2)/(count($group)/2); // example 109512

           	// -----------------------------------------
           	echo "<br>";
           	echo $ssT = $sumEachValue - $reTPowN;

           	// -----------------------------------------
           	echo "<br>";
           	echo $ssB = $sumTN - $reTPowN;
           	// -----------------------------------------
           	echo "<br>";
           	echo $ssW = $ssT - $ssB;
           	// -----------------------------------------
           	echo "<br>";
           	echo $msB = $ssB/($keep-1);
           	// -----------------------------------------
           	echo "<br>";
           	echo $msW = $ssW / ((count($group)/2) - $keep);
           	// -----------------------------------------
           	echo "<br>";
           	echo $f = $msB / $msW;





            


            

     





		?>