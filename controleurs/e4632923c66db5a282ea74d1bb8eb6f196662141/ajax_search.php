<?php 
if(isset($_GET['search']) && !empty($_GET['search'])){   													

	$search = $_GET['search'];
	include_once('recup_json_search.php');
	$json_decode = search_snap();	
	$data =$json_decode[1];
	$error = $json_decode[0]->error;

	/*$var = array( 'json_obj' , 'reussi');*/
	if( $error != 0 ){
		echo "Il n'existe aucun Pseudo Snapchat avec se nom !";
	}
	else{
		foreach ($data as $key ) {
			$data1 = $key;
			foreach ($data1 as $key => $value) {
			$score = (empty($value) ? "0" : $value);
	?>

	<div class="search">
		<div class="snap_search" >
			<?php echo "Pseudo Snapchat :  ".$key ?>
		</div>
		</br></br>
		<div class="score_search">
			<?php echo "Score joueur :  ". $score ?>
		</div>
		</br></br>
		<?php if($score > 0 ){?>
		<a class="btn full"  href="changeSnapScore.php?add=-100&search=<?php echo $_GET['search']?>&score_actuel=<?php echo urlencode($score);?>&snapchat=<?php echo urlencode($key)?>">
		    <div class="actu_inscription">
		        <i class="fa fa-minus"></i>100
		    </div>
		</a>
		<a class="btn full"  href="changeSnapScore.php?add=-80&search=<?php echo $_GET['search']?>&score_actuel=<?php echo urlencode($score);?>&snapchat=<?php echo urlencode($key)?>">
		    <div class="actu_inscription">
		        <i class="fa fa-minus"></i>80
		    </div>
		</a>
		<a class="btn full"  href="changeSnapScore.php?add=-50&search=<?php echo $_GET['search']?>&score_actuel=<?php echo urlencode($score);?>&snapchat=<?php echo urlencode($key)?>">
		    <div class="actu_inscription">
		        <i class="fa fa-minus"></i>50
		    </div>
		</a>

		<?php }?>
         <a class="btn full"  href="changeSnapScore.php?add=50&search=<?php echo $_GET['search']?>&score_actuel=<?php echo urlencode($score);?>&snapchat=<?php echo urlencode($key)?>">
            <div class="actu_inscription">
               <i class="fa fa-plus"></i>50
            </div>
        </a>
        <a class="btn full"  href="changeSnapScore.php?add=80&search=<?php echo $_GET['search']?>&score_actuel=<?php echo urlencode($score);?>&snapchat=<?php echo urlencode($key)?>">
            <div class="actu_inscription">
               <i class="fa fa-plus"></i>80
            </div>
        </a>
        <a class="btn full"  href="changeSnapScore.php?add=100&search=<?php echo $_GET['search']?>&score_actuel=<?php echo urlencode($score);?>&snapchat=<?php echo urlencode($key)?>">
            <div class="actu_inscription">
               <i class="fa fa-plus"></i>100
            </div>
        </a>
	</div>
		
	<?php
			}
		}
	}

}


