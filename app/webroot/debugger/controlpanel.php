<?php
	date_default_timezone_set('America/Toronto');
	$bugs = array();
	
	$isadmin = true;
	
	if(!empty($_POST['uID'])){
		// Change this connection with your credentials (server,db,user,password)
		$conn = new mysqli("localhost","root","root","canbii") or die("Error " . mysqli_error($conn)); 
		
		$queryDateGrp = "SELECT COUNT(*) as cnt, DATE(dateModified) as dateMod FROM bug_list";
		
		$rsDateGrp = $conn->query($queryDateGrp);
		
		$querySel = "SELECT bl.*, u.username FROM bug_list bl JOIN users u ON bl.userID = u.ID";
		
		
			
			
		// Check if admin (Change username to admin user name or use user type column)
		if($_POST['uID'] != 1){
			$querySel .= " WHERE userID = ". $_POST['uID'];
			$queryDateGrp =" WHERE userID = '". $_POST['uID'] ."'";
			$isadmin = false;
		}
		$queryDateGrp .=  " GROUP BY DATE(dateModified) DESC";
		$querySel .= " ORDER BY dateCreated DESC";
		
		$rsBugs = $conn->query($querySel);
		
		while($bug = $rsBugs->fetch_array()){
			$bug_date = date("Y-m-d",strtotime($bug['dateModified']));
			$bugs[$bug_date][$bug['id']] = $bug;
			$bugs[$bug_date][$bug['id']]['bugDate'] = $bug['dateModified'];


		}
		//die(var_dump($bugs));
	
	}

$webroot = "";
if ($_SERVER["SERVER_NAME"] == "localhost") {
    $webroot = $_SERVER["PHP_SELF"];
    $webroot = substr($webroot, 1, strpos($webroot, "/", 1));
}

?>
<html>
	<head>
		
		<link rel="stylesheet" type="text/css" href="/<?= $webroot; ?>debugger/debug.css" />
	</head>
	<body>
		<div class="cpanel_container">
			<h1>Bug Control Panel</h1>
			<?php 
				if(!empty($_POST['uID'])){ 
					if($rsDateGrp != false){
						if(count($bugs) == 0){
						?>							
							<h2>There are no bugs listed for this user.</h2>
						<?php
						}
						else{
							while($dt = $rsDateGrp->fetch_array()){
                                ?>
							<div class='datebuggroup'>
								<h2><?php echo $dt['dateMod']?>:</h2> <h3><?php echo $dt['cnt']; ?> bug<?php if($dt['cnt'] != 1) {echo "s";} ?></h3><br />
                                <?php
                                //print_r($bugs);
                                //die();

                                foreach($bugs as $b){
                                    print_r( $b[6]);
                                    echo "<P>" .  $b[6]['comment'];
/*
foreach($b as $key => $value){
    print_r($key);
    echo "<P>";
    //echo "<BR>" . $key . " (" . ($key=="comment") . ") =" . $value . "</BR>";
} */


                                    if (false) {?>

                                    <div class='commentbox' style='position:relative;display:inline-block;height:100px'>
                                        <div class='commenttext'><?php echo substr($b['comment'], 0, 20).'...'; ?></div>
                                        <?php if($isadmin): ?>
                                            <div class='buguserlbl'>
                                                <?php echo $b['username']; ?>
                                            </div>
                                        <?php endif; ?>
                                        <span class='bugtime'><?php echo date("m-d-Y g:i a",strtotime($b['bugDate'])); ?></span>
                                        <a class='seebug' target='_blank' href='<?php echo $b['url'];
                                        if(!strpos($b['url'], "?debug")) { echo "?debug"; } ?>'>(See Bug)</a>
                                    </div>
                                <?php }} ?>
							</div>
							<?
							}
						}
					}
			?>
				
			<?php }else{ ?>
				<h2>You must be logged in to view the Control Panel.</h2>
			<?php } ?>
		</div>
	</body>

</html>