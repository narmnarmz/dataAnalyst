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
    	<h2>ผลการคำนวณการประมาณค่าแบบจุด</h2>
    	<?php 
    		$file= fopen("uploads/data.csv", "r");

    		$data = fgetcsv($file);
    		//show data list
    		print_r($data);
    		echo "<br>";
            echo "<br>";

            function sd_square($x, $mean) { return pow($x - $mean,2); }
            function sd($array) { return sqrt(array_sum(array_map("sd_square", $array, array_fill(0,count($array), (array_sum($array) / count($array)) ) ) ) / (count($array)-1) );   }
    	?>
            <table class="table table-bordered">
                <tr class="active">
                    <th>N</th>
                    <th>Mean</th>
                    <th>SD</th>
                </tr>
                <tr>
                    <?php 
                    $n = count($data);
                    $mean = array_sum($data)/$n;
                    $sd = sd($data);
                    echo "<td>".$n."</td>";
                    echo "<td>".$mean."</td>";
                    echo "<td>".$sd."</td>";
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