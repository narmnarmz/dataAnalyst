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
    	<h2>ผลการประมาณค่าสัดส่วนของประชากร (P)</h2>
    	<?php 
            $row = 1;
            $group = array();
            if (($handle = fopen("uploads/data.csv", "r")) !== FALSE) {
                //$data = fgetcsv($handle, 1000, ",");
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $num = count($data);
                    $row++;
                    for ($c=0; $c < $num; $c++) {
                        if (array_key_exists($data[$c], $group)) {
                            $group[$data[$c]] = $group[$data[$c]]+1;
                        } 
                        else
                        {
                            $group[$data[$c]] = 1;
                        }
                    }
                }
                fclose($handle);
            }
    	?>
        <table class="table table-bordered">
            <tr class="active">
                <th>Case</th>
                <th>Category</th>
                <th>N</th>
                <th>Point</th>
                <th>Upper Bound</th>
                <th>Lower Bound</th>
                <th>Asymp. Sig. (2-tailed)</th>
            </tr>
                <?php 
                $loop=0;
                $zscore = array(1.6449, 1.96, 2.5758);
                foreach (array_keys($group) as $paramName) {
                    $loop++;
                    $p = $group[$paramName]/($row-1);
                    $a = $group[$paramName];
                    $upper = $p+($zscore[$_POST['sig']]*(sqrt(($p*(1-$p))/($row-1))));
                    $lower = $p-($zscore[$_POST['sig']]*(sqrt(($p*(1-$p))/($row-1))));
                    echo "<tr>";
                    echo "<td>".$paramName."</td>";
                    echo "<td>".$_POST["groupName".$paramName]."</td>";                
                    echo "<td>".$a."</td>";
                    echo "<td>".$p."</td>";
                    echo "<td>".$upper."</td>";
                    echo "<td>".$lower."</td>";
                    if ($loop<=1) {
                        echo "<td rowspan='3'>".$zscore[$_POST['sig']]."</td>";
                    }
                    echo "</tr>";
                }
                 ?>
            <tr>
                <td colspan="2">Total</td>
                <td colspan="4"><?php echo $row-1 ?></td>
            </tr>
            
        </table>
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