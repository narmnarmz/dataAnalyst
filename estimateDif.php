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
    	<h2>ผลการประมาณผลต่างระหว่างค่าเฉลี่ยของประชากรสองชุด (µ1-µ2)</h2>
    	<?php 

            //$data = array_map('str_getcsv', file('uploads/data.csv'));
            $tTable = array_map('str_getcsv', file('uploads/t-table.csv'));
            $file= fopen("uploads/data.csv", "r");
            $data = fgetcsv($file);

            $row = 1;
            $group = array();
            if (($handle = fopen("uploads/data.csv", "r")) !== FALSE) {
                //$data = fgetcsv($handle, 1000, ",");
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $num = count($data);
                    $row++;
                    for ($c=0; $c < $num; $c++) {
                        if ($c==0) {
                            $group[$data[0]][] = $data[1];
                        }
                    }
                }
                fclose($handle);
            }
            //print_r($group);

            function sd_square($x, $mean) { return pow($x - $mean,2); }
            function sd($array) { return sqrt(array_sum(array_map("sd_square", $array, array_fill(0,count($array), (array_sum($array) / count($array)) ) ) ) / (count($array)-1) );   }
    	?>
            <table class="table table-bordered">
                <tr class="active">
                    <th></th>
                    <th>N</th>
                    <th>SD</th>
                    <th>V</th>
                    <th>MEAN</th>
                </tr>
                <tr>
                    <td>µ1 ( <?php echo $_POST['groupName1']; ?> )</td>
                    <?php 
                    $key = array_keys($group);
                    $v1=sd($group[$key[0]])*sd($group[$key[0]]);
                    $mean1=array_sum($group[$key[0]])/count($group[$key[0]]);
                    echo "<td>".count($group[$key[0]])."</td>";
                    echo "<td>".number_format(sd($group[$key[0]]),4,'.',',')."</td>";
                    echo "<td>".number_format($v1,4,'.',',')."</td>";
                    echo "<td>".number_format($mean1,4,'.',',')."</td>";
                     ?>
                </tr>
                <tr>
                    <td>µ2 ( <?php echo $_POST['groupName2']; ?> )</td>
                    <?php 
                    $v2=sd($group[$key[1]])*sd($group[$key[1]]);
                    $mean2=array_sum($group[$key[1]])/count($group[$key[1]]);
                    echo "<td>".count($group[$key[1]])."</td>";
                    echo "<td>".number_format(sd($group[$key[1]]),4,'.',',')."</td>";
                    echo "<td>".number_format($v2,4,'.',',')."</td>";
                    echo "<td>".number_format($mean2,4,'.',',')."</td>";
                     ?>
                </tr>
                <tr>
                    <td>µ1-µ2</td>
                    <?php 
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "<td></td>";

                    if ($mean1-$mean2 > 0) {
                        $mean=$mean1-$mean2;
                    }
                    else{
                        $mean=$mean2-$mean1;
                    }

                    echo "<td>".number_format($mean,4,'.',',')."</td>";
                     ?>
                </tr>
            </table>

            <table class="table table-bordered">
                <tr class="active">
                    <th>Reliability</th>
                    <th>Sig.</th>
                    <th>t</th>
                    <th>Sp</th>
                    <th>Lower</th>
                    <th>Upper</th>
                </tr>
                <tr>
                    <?php 
                    $rel = array("90%", "95%", "98%", "99%", "99.8%" ,"99.9%");
                    $sig = array(0.1, 0.05, 0.02, 0.01, 0.002 ,0.001);
                    $n1 = count($group[$key[0]]);
                    $n2 = count($group[$key[1]]);
                    $df = $n1+$n2-3;
                    if ($df >= 200) {
                        $df=200;
                    }
                    $t = $tTable[$df][$_POST["sig"]];
                    $sp = (((($n1-1)*$v1)+(($n2-1)*$v2))/($n1+$n2-2));
                    $lower = $mean-($t*(sqrt($sp*((1/$n1)+(1/$n2)))));
                    $upper = $mean+($t*(sqrt($sp*((1/$n1)+(1/$n2)))));

                    echo "<td>".$rel[$_POST["sig"]]."</td>";
                    echo "<td>".$sig[$_POST["sig"]]."</td>";
                    echo "<td>".$t."</td>";
                    echo "<td>".number_format($sp,4,'.',',')."</td>";
                    echo "<td>".number_format($lower,4,'.',',')."</td>";
                    echo "<td>".number_format($upper,4,'.',',')."</td>";
                    ?>

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