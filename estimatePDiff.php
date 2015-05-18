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
            $group1 = array();
            $group2 = array();
            if (($handle = fopen("uploads/data.csv", "r")) !== FALSE) {
                //$data = fgetcsv($handle, 1000, ",");
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $num = count($data);
                    $row++;
                    $loop=0;
                    for ($c=0; $c < $num; $c++) {
                        $loop++;
                        switch ($loop) {
                            case '1':
                                if (array_key_exists($data[$c], $group1)) {
                                    $group1[$data[$c]] = $group1[$data[$c]]+1;
                                } 
                                else
                                {
                                    $group1[$data[$c]] = 1;
                                }
                                break;
                            
                            case '2':
                                if (array_key_exists($data[$c], $group2)) {
                                    $group2[$data[$c]] = $group2[$data[$c]]+1;
                                } 
                                else
                                {
                                    $group2[$data[$c]] = 1;
                                }
                                break;

                            default :
                            break;
                        }
                    }
                }
                fclose($handle);
            }
            print_r($group1);
            print_r($group2)
    	?>
        <table class="table table-bordered">
            <tr class="active">
                <th>Group</th>
                <th>Case</th>
                <th>N</th>
                <th>Point</th>
            </tr>
            <tr>
                <?php 
                echo "<td rowspan='3'>".$_POST['groupName1']."</td>";
                echo "<td>".$_POST['colName1']."</td>";
                echo "<td></td>";
                echo "<td></td>";
                 ?>
            </tr>
            <tr>
                <?php 
                echo "<td>".$_POST['colName1']."</td>";
                echo "<td></td>";
                echo "<td></td>";
                 ?>
            </tr>
            <tr>
                <td>Total</td>
                <td colspan="2"><?php echo $row-1 ?></td>
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

        <?php var_dump($a); ?>
<?php include "footer.php"; ?>