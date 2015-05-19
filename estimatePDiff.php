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
    	<h2>ผลการประมาณค่าสัดส่วนของประชากร (P1-P2)</h2>
    	<?php 
            $row = 1;
            $pn = array();
            $case = array();
            if (($handle = fopen("uploads/data.csv", "r")) !== FALSE) {
                //$data = fgetcsv($handle, 1000, ",");
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $num = count($data);
                    $row++;
                    if (array_key_exists($data[0], $pn)) {
                        $pn[$data[0]]++;
                    }
                    else
                    {
                        $pn[$data[0]] = 1;
                    }
                    if ($data[1]==$_POST['case']) {
                        if (array_key_exists($data[0], $case)) {
                            $case[$data[0]]++;
                        }
                        else
                        {
                            $case[$data[0]]=1;
                        }
                    }

                }
                fclose($handle);
            }
            // print_r($pn);
            // print_r($case);
            // var_dump($_POST);
            $rel= array('90%','95%', '99%');
            $zscore = array(1.6449, 1.96, 2.5758);
            $p1 = $case[1]/$pn[1];
            $p2 = $case[2]/$pn[2];
            $p = abs($p1-$p2);
            $z=$zscore[$_POST['sig']]* sqrt((($p1*(1-$p1))/$pn[1])+(($p2*(1-$p2))/$pn[2]));
    	?>
        <table class="table table-bordered">
            <tr class="active">
                <th>Case</th>
                <th>Group</th>
                <th>N</th>
                <th>กรณีที่สนใจ</th>
                <th>Mean</th>
            </tr>
            <tr>
                <?php 
                echo "<td rowspan='3'>".$_POST['caseLabel']."</td>";
                echo "<td>".$_POST['groupName1']."</td>";
                echo "<td>".$pn['1']."</td>";
                echo "<td>".$case[1]."</td>";
                echo "<td>".number_format($p1,4,'.',',')."</td>";
                 ?>
            </tr>
            <tr>
                <?php 
                echo "<td>".$_POST['groupName2']."</td>";
                echo "<td>".$pn['2']."</td>";
                echo "<td>".$case[2]."</td>";
                echo "<td>".number_format($p2,4,'.',',')."</td>";
                 ?>
            </tr>
            <tr>
                <td>Total</td>
                <td colspan="3"><?php echo $row-1 ?></td>
            </tr>
        </table>

        <table class="table table-bordered">
            <tr class="active">
                <th>Reliability</th>
                <th>P1-P2</th>
                <th>Lower Bound</th>
                <th>Upper Bound</th>
            </tr>
            <tr>
                <?php 

                echo "<td>".$rel[$_POST['sig']]."</td>";
                echo "<td>".number_format($p,4,'.',',')."</td>";                
                echo "<td>".number_format(($p-$z),4,'.',',')."</td>";
                echo "<td>".number_format(($p+$z),4,'.',',')."</td>";
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

        <?php //var_dump($a); ?>
<?php include "footer.php"; ?>