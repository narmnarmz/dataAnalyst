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
    	<h2>ผลการประมาณค่าเฉลี่ยของประชากร (µ)</h2>
    	<?php 
    		$file= fopen("uploads/data.csv", "r");
    		$data = fgetcsv($file);
    		//show data list
    		print_r($data);
    		echo "<br>";
            function sd_square($x, $mean) { return pow($x - $mean,2); }
            function sd($array) { return sqrt(array_sum(array_map("sd_square", $array, array_fill(0,count($array), (array_sum($array) / count($array)) ) ) ) / (count($array)-1) );   }

            $tcsv = file_get_contents("uploads/t-table.csv");
            $lines = explode(PHP_EOL, $tcsv);
            $tArray = array();
            foreach ($lines as $line) {
                $tArray[] = str_getcsv($line);
            }
    	?>
            <table class="table table-bordered">
                <tr class="active">
                    <th>N</th>
                    <th>Mean</th>
                    <th>SD</th>
                    <th>Reliability</th>
                    <th>Sig.</th>
                    <th>t</th>
                    <th>Lower</th>
                    <th>Upper</th>
                </tr>
                <tr>
                    <?php 
                    $rel = array("90%", "95%", "98%", "99%", "99.8%" ,"99.9%");
                    $sig = array(0.1, 0.05, 0.02, 0.01, 0.002 ,0.001);
                    $n = count($data);
                    $mean = array_sum($data)/$n;
                    $sd = sd($data);
                    $t=$tArray[$n-2][$_POST["sig"]];
                    echo "<td>".$n."</td>";
                    echo "<td>".$mean."</td>";
                    echo "<td>".$sd."</td>";
                    echo "<td>".$rel[$_POST["sig"]]."</td>";
                    echo "<td>".$sig[$_POST["sig"]]."</td>";
                    echo "<td>".$t."</td>";
                    echo "<td>".($mean-($t*($sd/sqrt($n))))."</td>";
                    echo "<td>".($mean+($t*($sd/sqrt($n))))."</td>";
                    echo "<br>";
                     ?>
                </tr>
                
            </table>
        <?php
    		fclose($file);
    	?>
        <div style="margin-bottom: 20px;">
            <a class="btn btn-success" href="/dataanalyst">HOME</a>
            <button class="btn btn-success" onclick="goBack()">Other Calculation</button>
        </div>
        <script>
            function goBack(){
                window.history.back();
            }
        </script>
<?php include "footer.php"; ?>