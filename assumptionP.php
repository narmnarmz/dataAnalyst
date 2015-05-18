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
        <h2>ผลการทดสอบสมมติฐานเกี่ยวกับค่าเฉลี่ยประชากรชุดเดียว (P)</h2>
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
                <th rowspan="2">Case</th>
                <th rowspan="2">Category</th>
                <th rowspan="2">N</th>
                <th rowspan="2">Observe Prop.</th>
                <th rowspan="2">Z</th>
                <th colspan="3">Siginificance</th>
            </tr>
                <tr class="active">
                <th>1-tail</th>
                <th>Lower Bound</th>
                <th>Upper Bound</th>
            </tr>
                <?php 
                $loop=0;
                $zscore = array(1.645, 1.96, 2.575);
                $onetail = array(1.282, 1.645, 2.326);
                foreach (array_keys($group) as $paramName) {
                    $loop++;
                    $n=$row-1;
                    $ptest = $_POST['testValue'];
                    $p = $group[$paramName]/($row-1);
                    $a = $group[$paramName];
                    $upper = $p+($zscore[$_POST['sig']]*(sqrt(($p*(1-$p))/($row-1))));
                    $lower = $p-($zscore[$_POST['sig']]*(sqrt(($p*(1-$p))/($row-1))));
                    echo "<tr>";
                    echo "<td>".$paramName."</td>";
                    echo "<td>".$_POST["groupName".$paramName]."</td>";                
                    echo "<td>".$a."</td>";
                    echo "<td>".$p."</td>";
                    echo "<td>".number_format(($p-$ptest)/sqrt(($ptest*(1-$ptest))/$n),3,'.',',')."</td>";
                    echo "<td>".$onetail[$_POST['sig']]."</td>";
                    echo "<td>".'-'.$zscore[$_POST['sig']]."</td>";
                    echo "<td>".$zscore[$_POST['sig']]."</td>";
                    echo "</tr>";
                }
                 ?>
            <tr>
                <td colspan="2">Total</td>
                <td><?php echo $row-1 ?></td>
                <td>1</td>
                <td colspan='4'></td>
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