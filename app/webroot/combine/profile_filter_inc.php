<?php
$arr_filter=array('nationality','gender','age_group','age_group_from','age_group_to','weight','weight_from','weight_to','health','exp','years_of_experience_from','years_of_experience_to','frequency','body_type','card_id','country');
foreach($arr_filter as $af){
    if(isset($_GET[$af])){
        $show = 1;
    } else {
        $_GET[$af] = null;
    }
}
if(isset($_GET['weight_from'])) { $weight_from = $_GET['weight_from']; }
if(isset($_GET['weight_to'])) { $weight_to = $_GET['weight_to']; }
if(isset($_GET['age_from'])) { $age_group_from = $_GET['age_from']; }
if(isset($_GET['age_to'])) { $age_group_to = $_GET['age_to']; }

if(!isset($nationality)){   $nationality = $_GET['nationality']; }
if(!isset($gender)){        $gender = $_GET['gender'];}
if(!isset($age_group)){     $age_group = '';  $age_from=''; $age_to='';} else {
    if (!isset($age_group_from)){ $age_group_from = substr($age_group,0,2); }
    if (!isset($age_group_to)){   $age_group_to =   substr($age_group,-2); }
}
if(!isset($weight)){        $weight = '';} elseif(!isset($_GET['weight_from'])) {
    $pos = strpos($weight, "-");
    $weight_from = substr($weight, 0, $pos);
    $weight_to =substr($weight, $pos+1, strlen($weight)-$pos-1) ;
}
if(!isset($health)){        $health = $_GET['health'];}
if(!isset($exp)){           $exp = '';}
if(!isset($frequency)){     $frequency = $_GET['frequency'];}
if(!isset($body_type)){     $body_type = $_GET['body_type'];}
if(!isset($country)){       $country = $_GET['country'];}

if(!isset($card_id)){
    $card_id = '';
    $card_pass='';
}else {
    $len = strlen($card_id);
    $card_pass = '';
    for($i=0;$i<$len;$i++)
    {
        if($i<=($len-5))
        $card_pass = $card_pass.'*';
        else
        $card_pass = $card_pass.$card_id[$i];
    }
}
?>
<div class="columns clearfix page_margin_top hidden_filter" <?php if($this->params['action']!='dashboard' && (!isset($show) || (isset($show) && $show!=1))){?> style="display:none;width:100%;marging-bottom:15px;"<?php }?>>
<?php
if($this->params['action']!='dashboard' && !$this->Session->read('User')){
    ?>
    <a href="<?php echo $this->webroot;?>users/register" style="position: absolute;top:0;left:0;width:100%;height:100%;background:#82BECE;opacity:0.8;">
        <img src="<?php echo $this->webroot;?>images/trans.png" style="width:100%" />
    </a>
    <?php
}
?>
<ul class="column_left">
   <?php if($this->params['action']!='dashboard'){?><?php if($this->params['action']!='dashboard'){?><div class="bg"><?php }?><?php }?>
   <label>Nationality</label>
   <select name="nationality" style="width: 100%;">
		<option style="padding-top: 20px; padding-bottom:20px" value="">Select Nationality</option>
       <option value="native"<?php if($nationality=='native')echo "selected='selected'";?>>Aboriginal</option>
       <option value="asian" <?php if($nationality=='asian')echo "selected='selected'";?>>Asian</option>
		<option value="indian"<?php if($nationality=='indian')echo "selected='selected'";?>>Indian</option>
		<option value="white"<?php if($nationality=='white')echo "selected='selected'";?>>White</option>
		<option value="black"<?php if($nationality=='black')echo "selected='selected'";?>>Black</option>
		<option value="hispanic"<?php if($nationality=='hispanic')echo "selected='selected'";?>>Hispanic</option>
		<option value="mid_east"<?php if($nationality=='mid_east')echo "selected='selected'";?>>Middle Eastern</option>
   </select><br />
   <?php if($this->params['action']!='dashboard'){?></div><?php }?>
   <?php if($this->params['action']!='dashboard'){?><div class="bg"><?php }?>
   <label>Country</label>
   <select name="country" style="width: 100%;">
		<option style="padding-top: 20px; padding-bottom:20px" value="">Select Country</option>
        <?php
        foreach($countries as $cou){
            ?>
            <option value="<?php echo $cou['Country']['countryName'];?>" <?php if($country==$cou['Country']['countryName'])echo "selected='selected'";?>><?php echo $cou['Country']['countryName'];?></option>
            <?php       }        ?>
		
   </select><br />
   <?php if($this->params['action']!='dashboard'){?></div><?php }?>
   <?php if($this->params['action']!='dashboard'){?><div class="bg"><?php }?>
   <label>Gender</label>
   <select name="gender" style="width: 100%;">
		<option value="">Select Gender</option>
		<option value="male"<?php if($gender=='male')echo "selected='selected'";?>>Male</option>
		<option value="female"<?php if($gender=='female')echo "selected='selected'";?>>Female</option>
   </select><br />
   <?php if($this->params['action']!='dashboard'){?></div><?php }?>
   <?php if($this->params['action']=='dashboard'){?>
   <label>Age Group</label>
   <select name="age_group" style="width: 100%;">
		<option value="">Select Age Group</option>
		<!--<option value="0-21"<?php if($age_group=='0-21')echo "selected='selected'";?>>< 21</option>-->
		<option value="21-30"<?php if($age_group=='21-30')echo "selected='selected'";?>>21-30</option>
		<option value="31-40"<?php if($age_group=='31-40')echo "selected='selected'";?>>31-40</option>
		<option value="41-50"<?php if($age_group=='41-50')echo "selected='selected'";?>>41-50</option>
		<option value="51-60"<?php if($age_group=='51-60')echo "selected='selected'";?>>51-60</option>
		<option value="61-70"<?php if($age_group=='61-70')echo "selected='selected'";?>>61-70</option>
		<option value="71-100"<?php if($age_group=='71-100')echo "selected='selected'";?>>71+</option>
   </select><br />
   <?php }   else   {        ?>

        <?php if($this->params['action']!='dashboard'){?><div class="bg"><?php }?>
        <label style="display: block!important;">Age Group</label><span>
        <select name="age_group_from" style="width: 103px!important;float:left;">
    		<option value="">From</option>
    		<?php
            for($i=21;$i<=100;$i=$i+10)            {
                
                ?>
                <option value="<?php echo $i?>" <?php if($age_group_from==$i){?>selected="selected"<?php }?>><?php echo $i;?></option>
                <?php            }           ?>
        </select>
        <select name="age_group_to" style="width: 103px!important;margin-left:10px;">
    		<option value="">To</option>
    		<?php
            for($i=30;$i<=100;$i=$i+10) {
                
                ?>
                <option value="<?php echo $i?>" <?php if($age_group_to==$i){?>selected="selected"<?php }?>><?php echo $i;?></option>
                <?php         }           ?>
        </select>
        </span>
        <br />
        </div>
        <?php
        
   }
   ?>
   <?php if($this->params['action']!='dashboard'){?><div class="bg"><?php }?>
   <label>Health</label>
   <select name="health" style="width: 100%;">
		<option value="">Select Health</option>
		<option value="poor"<?php if($health=='poor')echo "selected='selected'";?>>Poor</option>
		<option value="average"<?php if($health=='average')echo "selected='selected'";?>>Average</option>
		<option value="good"<?php if($health=='good')echo "selected='selected'";?>>Good</option>
   </select><br />
   <?php if($this->params['action']!='dashboard'){?></div><?php }?>
   
      
<?php if($this->params['action']=='dashboard'){?>   
</ul>
<ul class="column_right">
<?php }?>

   <?php
   if($this->params['action']=='dashboard')
   {
    ?>
   <label>Patient Card (Optional)<?php if($card_pass){?> <a href="javascript:void(0);" style="color: red;" onclick="$('#card_id').toggle();$('#card_pass').toggle();">Change</a><?php }?></label>
   <?php if($card_pass){?><input type="text" name="" style="width: 98%;" disabled id="card_pass" value="<?php echo $card_pass;?>"  /><?php }?>
   <input type="text" name="card_id" id="card_id" style="width: 98%;<?php if($card_pass){echo 'display:none;'; }?>" value="<?php echo $card_id?>" <?php if($card_pass){?>style="display: none; width: 98%;"<?php }?> title="(Optional)"/>
   <?php
   }
   
   /*else
   {
    ?>
    <label>Patient with card</label>
    <input type="checkbox" class="card_id" value="1" />
    <?php
   }*/

   function selectoption($i, $weight){

       echo '<option value="';
       if($i==100) {echo $i.'-'.($i+10);} else {echo ($i+1).'-'.($i+10);}
       echo '" ';
       if($weight==($i+1).'-'.($i+10)){
           echo 'selected="selected"';
       }
       echo '>';
       if($i==100){echo $i.'-'.($i+10);}
       elseif($i==0) {echo "<100";}
       elseif($i==301) {echo ">310";}
       else {echo ($i+1).'-'.($i+10);}
       echo '</option>';
   }

   if($this->params['action']=='dashboard')
   {
   ?>
   <label>Weight (lbs)</label>
   <select name="weight" style="width: 100%;">
        <option value="">Select Weight</option>
    <?php
    selectoption(0,$weight);
    for($i=100;$i<=300;$i=$i+10)
    {
        selectoption($i, $weight);
    }
    selectoption(301,$weight);
    ?>
   </select>
   <br/>
   <?php }
   else
   {
        ?>
        <?php if($this->params['action']!='dashboard'){?><div class="bg"><?php }?>
        <label style="display: block!important;">Weight (lbs)</label><span>
        <select name="weight_from" style="width: 103px!important;float:left;">
    		<option value="">From</option>
    		<?php
            for($i=101;$i<=290;$i=$i+10)
            {
                
                ?>
                <option value="<?php echo $i?>" <?php if($weight_from==$i){?>selected="selected"<?php }?>><?php echo $i;?></option>
                <?php
            }
            ?>
        </select>
        <select name="weight_to" style="width: 103px!important;margin-left:10px;">
    		<option value="">To</option>
    		<?php
            for($i=110;$i<=290;$i=$i+10)
            {
                
                ?>
                <option value="<?php echo $i?>" <?php if($weight_to==$i){?>selected="selected"<?php }?>><?php echo $i;?></option>
                <?php
            }
            ?>
        </select></span>
        
        <br />
        </div>
        <?php
        
   }
   ?>
   
   
   
   <?php
   if($this->params['action']=='dashboard')
   {
   ?>
   <label style="display: block!important;">Years of Experience</label>
   <select  name="years_of_experience"  style="width: 100%;">
        <option value="">Select Years of Experience</option>
   <?php for($i = 0; $i<=50; $i++)
   {
		if($i ==$exp)
		$sel = "selected='selected'";
		else
		$sel = "";
		echo "<option value='".$i."' ".$sel.">".$i."</option>";
   }?>
   </select><br/>
   <?php }
   else
   {
        ?>
        <?php if($this->params['action']!='dashboard'){?><div class="bg"><?php }?>
        <label style="display: block!important;">Years of Experience</label>
        <select name="years_of_experience_from" style="width: 103px!important;float:left;">
    		<option value="">From</option>
    		<?php
            for($i=1;$i<=50;$i++)
            {
                
                ?>
                <option <?php if($_GET['years_of_experience_from']==$i||$i == $exp-2||($i == 1 && $exp-2<1)){?>selected="selected"<?php }?> value="<?php echo $i?>"><?php echo $i;?></option>
                <?php
            }
            ?>
        </select>
        <select name="years_of_experience_to" style="width: 103px!important;margin-left:10px;">
    		<option value="">To</option>
    		<?php
            for($i=2;$i<=50;$i++)
            {
                
                ?>
                <option <?php if($_GET['years_of_experience_to']==$i||$i == $exp+2||($i ==50 && $exp+2>50)){?>selected="selected"<?php }?> value="<?php echo $i?>"><?php echo $i;?></option>
                <?php
            }
            ?>
        </select>
        
        <br />
        </div>
        <?php
        
   }
   ?>
   <?php if($this->params['action']!='dashboard'){?><div class="bg"><?php }?>
   <label>Frequency</label>
   <select name="frequency" style="width: 100%;">
		<option value="">Select Frequency</option>
		<option value="rarely"<?php if($frequency=='rarely')echo "selected='selected'";?>>Rarely</option>
		<option value="occasional"<?php if($frequency=='occasional')echo "selected='selected'";?>>Occasional</option>
		<option value="often"<?php if($frequency=='often')echo "selected='selected'";?>>Often</option>
   </select>
   <br />
   <?php if($this->params['action']!='dashboard'){?></div><?php }?>
   <?php if($this->params['action']!='dashboard'){?><div class="bg"><?php }?>
   <label>Body Type</label>
   <select name="body_type" style="width: 100%;">
		<option value="">Select Body Type</option>
		<option value="Muscular"<?php if($body_type=='Muscular')echo "selected='selected'";?>>Muscular</option>
		<option value="Slim"<?php if($body_type=='Slim')echo "selected='selected'";?>>Slim</option>
		<option value="Heavy"<?php if($body_type=='Heavy')echo "selected='selected'";?>>Heavy</option>
        <option value="Average"<?php if($body_type=='Average')echo "selected='selected'";?>>Average</option>
        <option value="Athletic"<?php if($body_type=='Athletic')echo "selected='selected'";?>>Athletic</option>
   </select>
   <br />
   <?php if($this->params['action']!='dashboard'){?></div><div class="clearfix"></div><?php }?>

   
</ul>
<div class="clearfix"></div>
<?php
if($this->params['controller']=='strains' && $this->params['action']=='index')
{
    ?>
    <br />
    <br />
    <a class="blue more" href="javascript:void(0)" onclick="filternow();" style="margin-right: 15px;margin-top:20px;" id="filternow">Filter Now</a><a style="margin-top: 20px;" class="blue more" href="<?php echo $this->webroot;?>strains/<?php echo $strain['Strain']['slug'];?>" onclick="" id="">Clear Filter</a>
    <?php
}
?>
</div>
<style>
<?php
if($this->params['action']!='dashboard')
{
    ?>
        .filters input[type="checkbox"]{display:none!important;}
        .filters select{margin-bottom:5px;width:216px!important;float:left;}
        .filters ul{width:100%!important;float:none!important;}
        .filters br{display:none;}
        .bg{background:#FFF;float:left;margin-right:5px;padding:10px;margin-bottom:5px;min-height:80px;}
    <?php
}
?>
</style>
<script>
<?php
if($this->params['controller']=='strains' && $this->params['action']=='index')
{
    ?>
    
function filternow(){
    
        var profile = '';
        $('.hidden_filter select').each(function(){
        
        
        var value = $(this).val();
        
        if(value){
        var field = $(this).attr('name');            
        if(!profile)            
        profile = field+'='+value;
        else
        profile = profile+'&'+field+'='+value;
        //alert(profile);
        
        }
        
        });
        
        
        
        var i=0;
        
        
       
    
        
        
        window.location = '<?php echo $this->webroot?>strains/<?php echo $strain['Strain']['slug']?>/?'+profile;
        
        
        
    } 
    <?php
}
?>
</script>