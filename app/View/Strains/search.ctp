<div id="portfolio" class="container">
    <h1 class="title" style="margin-bottom: 30px;">Strains</h1>
    <p style="margin-bottom: 30px;">&nbsp;</p>
    <?php
    $j=0;
    if($strain) {
        foreach($strain as $s) {
            $j++;
            ?>
            <div class="column<?php echo $j;?>">
			<div class="box">
            <a href="<?php echo $this->webroot?>strains/<?php echo $s['Strain']['slug'];?>"><div class="iconstrain">
                <h2><?php echo $s['StrainType']['title'];?></h2>
                <strong>
                <?php
                $name_arr = explode(' ',$s['Strain']['name']);
                $i=0;
                foreach($name_arr as $na)
                {
                    $i++;
                    if($i==1){
                        echo ucfirst($na[0]);
                        }
                        else echo strtolower($na[0]);
                        }
                        ?></strong>
                <br />
                <?php echo $s['Strain']['name'];?>
                </div>
                </a>
				<p><?php echo substr($s['Strain']['description'],0,130).'...';?></p>
				<a href="<?php echo $this->webroot?>strains/<?php echo $s['Strain']['slug'];?>" class="button button-small">View Details →</a> </div>
		  </div>
            <?php
        }
    }
    if ($j==0){
        echo "No results found";
    }
    ?>
    <div class="clear"></div>
	</div>