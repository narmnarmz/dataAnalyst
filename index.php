<?php include "header.php"; ?>
                <nav>
                    <!-- http://codepen.io/himanshu/pen/syLAh -->
                    <div class="progresss pull-right">
                      <div class="circle active">
                        <span class="label">1</span>
                        <span class="title">Import</span>
                      </div>
                      <span class="bar half"></span>
                      <div class="circle">
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
            <div class="jumbotron">
            	<form action="upload.php" method="POST" enctype="multipart/form-data">
                    <div class='row'>
        			     <h2><span class="glyphicon glyphicon-import" aria-hidden="true"></span> Import your data.</h2>
                    </div>
        			<div>
        				<input class="btn btn-default" type="file" accept=".csv" name="userfile" required>
        				<p class='uk-text-danger'>.csv only</p>
        				<input class='btn btn-lg btn-success' type="submit" value="Upload File" name="submit">
        			</div>
        		</form>
            </div>
<?php include "footer.php"; ?>