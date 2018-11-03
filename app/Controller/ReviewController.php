<?php
    class ReviewController extends AppController
    {

        function beforeFilter(){
            $this->loadModel("Review");
        }
        function checkSess(){
            if(!$this->Session->read('User'))
            {
                $url = $this->here;
                $this->Session->setFlash('Please log in or register to add a review','default',array('class'=>'bad'));
                $this->redirect('/users/register?url='.$url);
            }
        }
        function showAll($offset=0)
        {
            
            $this->set('offset',$offset);
            $limit = 8;
            if(!isset($_GET['filter']))
            $reviews = $this->Review->find('all',array('limit'=>$limit,'offset'=>$offset));
            else
            $reviews = $this->Review->find('all',array('limit'=>$limit,'offset'=>$offset,'order'=>$_GET['filter'].' '.$_GET['sort']));            
            $this->set("reviews",$reviews);
            $this->set('reviewz', $this->Review->find('count')); 
        }
        function show_all_blank($offset)
        {
            
            $this->layout = 'blank';
            $limit = 8;
            if(!isset($_GET['filter']))
            $reviews = $this->Review->find('all',array('limit'=>$limit,'offset'=>$offset));
            else
            $reviews = $this->Review->find('all',array('limit'=>$limit,'offset'=>$offset,'order'=>$_GET['filter'].' '.$_GET['sort']));
            $this->set("reviews",$reviews);
            $this->set('reviewz', $this->Review->find('count')); 
        }

        function all($limit=0){
            $this->set('limit',$limit);
            $this->checkSess();
            
            if($limit){
                $offset = $limit;
                $limit = '8';
            } else{
                $limit = 8;
                $offset = 0;
            }
            
            $id =$this->Session->read('User.id');
            if (isset($_GET["delete"])){
                $reviewid= $_GET["delete"];
                if($this->deletereviews($id,"",$reviewid)) {
                    $this->Session->setFlash('Review deleted', 'default', array('class' => 'good'));
                }else{
                    $this->Session->setFlash('Unable to delete the review', 'default', array('class' => 'bad'));
                }
            }
            if (isset($_GET["update"])){
                $this->updatereviews($_GET["update"]);
            }

            $reviews = $this->Review->find('all',array("conditions"=>array('user_id'=>$id),'limit'=>$limit,'offset'=>$offset));
            $this->set("reviews",$reviews);
            $this->set('reviewz', $this->Review->find('count',array('conditions'=>array('user_id'=>$id))) );
           // debug($reviews);
        }
        
        function all_filter($limit){
            $this->set('limit',$limit);
            if($limit){
                $offset = $limit;
                $limit = '8';
            } else{
                $limit = 8;
                $offset = 0;
            }
            $this->layout = 'blank';
            $id =$this->Session->read('User.id');
            $reviews = $this->Review->find('all',array("conditions"=>array('user_id'=>$id),'limit'=>$limit,'offset'=>$offset));
            $this->set("reviews",$reviews);
            $this->set('reviewz', $this->Review->find('count',array('conditions'=>array('user_id'=>$id))) );
        }
        
        function detail($id){
            $this->loadModel('Effect');
            $this->loadModel("Strain");
            $this->loadModel("Colour");
            $this->loadModel("Flavor");
            $this->loadModel('EffectRating');
            $this->loadModel('SymptomRating');
            $this->loadModel('ColourRating');
            $this->loadModel('FlavorRating');
            $this->loadModel('ReviewColor');
            $this->loadModel('VoteIp');
            $this->set('vip',$this->VoteIp);

            $this->set('effects',$this->Effect->find('all',array('conditions'=>array("negative"=>'0'))));
            $this->set('negative',$this->Effect->find('all',array('conditions'=>array("negative"=>'1'))));
            $this->set("effectz",$this->Effect->find('all'));
            $this->set('colours',$this->Colour->find('all'));
            $rc = $this->ReviewColor->find('all',array('conditions'=>array('review_id'=>$id)));
            $this->set('review_color',$rc);
            $this->set('flavors',$this->Flavor->find('all'));
            $this->loadModel('Symptom');
            $this->set('symptoms',$this->Symptom->find('all'));
            $this->set('review',$this->Review->findById($id));
            
            
            $review = $this->Review->findById($id);

            if (isset($review['Strain'])) {
                $this->set('title','Review: '. $review['Strain']['name']);
                $this->set('description','Review for '.$review['Review']['review'].'. General rating, effects rating, aesthetic rating and other reviews for '.$review['Strain']['name']);
                $this->set('keyword',$review['Strain']['name'].' , review , effect rating, general rating , aesthetic rating , Canbii , Medical , Marijuana , Medical Marijuana');
                $this->render('add');
            } else {
                $this->Session->setFlash('This review does not exist','default',array('class'=>'bad'));
            }
            //debug($review);

        }

        function index(){
            $this->checkSess();
            if(isset($_POST['submit'])) {
                $slug = $_POST['strain'];
                if($slug!="") {
                    $this->redirect("index/" . $slug);
                }
            }
        }

        function add($slug){
            $this->checkSess();
            $this->loadModel('Effect');
            $this->loadModel("Strain");
            $this->loadModel("Colour");
            $this->loadModel("Flavor");
            $this->loadModel('EffectRating');
            $this->loadModel('SymptomRating');
            $this->loadModel('ColourRating');
            $this->loadModel('FlavorRating');
            $this->loadModel('ReviewColor');
            $strain = $this->Strain->findBySlug($slug);
            $this->set("strain",$strain);
            $this->set("strain_id",$strain['Strain']['id']);
            $this->set("strain_name",$strain['Strain']['name']);
            $this->set('effects',$this->Effect->find('all',array('conditions'=>array("negative"=>'0'))));
            $this->set('negative',$this->Effect->find('all',array('conditions'=>array("negative"=>'1'))));
            $this->set('colours',$this->Colour->find('all'));
            $this->set('flavors',$this->Flavor->find('all'));
            $this->loadModel('Symptom');
            $this->set('symptoms',$this->Symptom->find('all'));
            if (isset($_GET["review"])){
                $this->set('editreview', $this->Review->findById($_GET["review"]));
            }

            if(isset($_POST['submit'])) {
                //var_dump($_POST);die();
                $ar['user_id'] = $this->Session->read('User.id');
                $ar['strain_id'] = $strain['Strain']['id'];
                //$this->deletereviews($ar['user_id'],  $ar['strain_id'] );//only needs 1 review per strain

                $ar['on_date'] = date("y-m-d");
               foreach($_POST as $k=>$v){
                    $ar[$k]=$v;
               }
               $this->Review->create();
               if($this->Review->save($ar))               {
                    $r_id = $this->Review->id;
                    //echo $_POST['rate'];
                    $this->change_overall_rating($strain['Strain']['id'],"strain",$_POST['rate']);
                    //die($o_R);
                    $ar['review_id'] = $r_id;
                    if(isset($_POST['effect'])&& count($_POST['effect'])>0)                    {
                        foreach($_POST['effect'] as $k=>$v )                        {
                            $this->change_overall_rating($strain['Strain']['id']."_".$k,"effect",$v);
                            $ar['effect_id'] = $k;
                            $ar['rate'] = $v;
                            $this->EffectRating->create();
                            $this->EffectRating->save($ar);
                        }
                    }
                    if(isset($_POST['medical'])&& count($_POST['medical'])>0)                    {
                        foreach($_POST['medical'] as $k=>$v )                        {
                            $this->change_overall_rating($strain['Strain']['id']."_".$k,"symptom",$v);
                            $ar['symptom_id'] = $k;
                            $ar['rate'] = $v;
                            $this->SymptomRating->create();
                            $this->SymptomRating->save($ar);
                        }
                    }
                    if(isset($_POST['color'])&& count($_POST['color'])>0)                    {
                        foreach($_POST['color'] as $k=>$v )                        {
                            /*$this->change_overall_rating($strain['Strain']['id']."_".$k,"colour",$v);
                            $ar['colour_id'] = $k;
                            $ar['rate'] = $v;
                            $this->ColourRating->create();
                            $this->ColourRating->save($ar);
                            */
                            $ar['color'] =$v;
                            $this->ReviewColor->create();
                            $this->ReviewColor->save($ar);
                        }
                    }
                    if(isset($_POST['flavor'])&& count($_POST['flavor'])>0)                    {
                        foreach($_POST['flavor'] as $k=>$v )                        {
                            $this->change_overall_rating($strain['Strain']['id']."_".$k,"flavor",$v);
                            $ar['flavor_id'] = $k;
                            $ar['rate'] = $v;
                            $this->FlavorRating->create();
                            $this->FlavorRating->save($ar);
                        }
                    }
                    
                    $this->Strain->id = $strain['Strain']['id'];
                    if($strain['Strain']['review'])                    {
                        $review = $strain['Strain']['review'] + 1;
                    } else {
                        $review = 1;
                    }

                    $this->factorreview($r_id);
                    $this->Strain->saveField('review',$review);
                    $this->Session->setFlash('Review Saved, thank you for your support','default',array('class'=>'good'));
                    $this->redirect('all');
               }
            }
        }

        function updatereviews($UpdateAverages = false){
            $this->loadModel("Strains");
            $strains= $this->Strains->find('all');
            foreach($strains as $strain){
                $id= $strain['Strains']['id'];
                $this->Strains->id =$id;
                $count = $this->Review->find('count',array("conditions"=>array('strain_id'=>$id)));
                $this->Strains->saveField("review",$count);
                if($UpdateAverages){
                    $rating=0;
                    $ratingcount=0;
                    $reviews = $this->Review->find('all',array("conditions"=>array('Review.strain_id'=>$id)));
                    foreach($reviews as $review){
                        $ratingcount++;
                        $rating += $review['Review']['rate'];
                    }
                    if($ratingcount>0){ $rating = $rating / $ratingcount;}
                    $this->Strains->saveField("rating",$rating);
                }
            }
            echo "Updated review counts";
        }
        //if $reviewid is specified, $userid must match the user_id of the review, $strainid is ignored
        function deletereviews($userid, $strainid, $reviewid=""){
            $this->loadModel("Strains");
            $delete=true;//disable for testing
            $this->loadModel('EffectRating');
            $this->loadModel('SymptomRating');
            $this->loadModel('ColourRating');
            $this->loadModel('FlavorRating');
            if ($reviewid){
                $review = $this->Review->find('first',array("conditions"=>array('Review.id'=>$reviewid)));
                if(!$review){return false;}
                $rate = $review['Review']['rate'];
                $strainid = $review['Review']['strain_id'];
                $reviewuserid = $review['Review']['user_id'];
                if ($reviewuserid != $userid) { return false;}
                $conditions = array('review_id' => $reviewid);
                if($delete){$this->Review->deleteAll(array('Review.id' => $reviewid), false);}
            } else {
                $conditions = array('user_id'=>$userid, 'strain_id'=>$strainid);
                if($delete){$this->Review->deleteAll($conditions, false);}
            }
            if($delete) {
                $this->EffectRating->deleteAll($conditions, false);
                $this->SymptomRating->deleteAll($conditions, false);
                $this->ColourRating->deleteAll($conditions, false);
                $this->FlavorRating->deleteAll($conditions, false);
            }

            //update review count/average
            $strain= $this->Strains->find('first',array("conditions"=>array('id'=>$strainid)));
            if($strain){
                $this->Strains->id = $strain['Strains']['id'];
                $reviews =$strain['Strains']['review'];//review count
                $this->Strains->saveField("review",$reviews-1);
                if($rate) {
                    $rate = ($strain['Strains']['rating'] * $reviews - $rate) / ($reviews - 1);//*****
                    $this->Strains->saveField("rating",$rate);
                }
            }
            return true;
        }

        function findreview($userid, $strainid){
            if($review = $this->Review->find('first',array("conditions"=>array('user_id'=>$userid, 'strain_id'=>$strainid)))){
                $id = $review['Review']['id'];
                $this->set('reviewid', $id);
                return $id;
            }
            return -1;
        }

        function change_overall_rating($id,$table,$rate)        {//id=strain id
            $this->checkSess();
            $this->loadModel('Strain');
            $this->loadModel('OverallEffectRating');
            $this->loadModel('OverallSymptomRating');
            $this->loadModel('OverallColourRating');
            $this->loadModel('OverallFlavorRating');
            if($table =='strain')            {
                $st = $this->Strain->findById($id);
                $overallrate = ($st['Strain']['rating']+$rate)/2;
                $overallrate = round($overallrate,2);
                //return $overallrate;
                $this->Strain->id = $st['Strain']['id'];
                $this->Strain->saveField('rating',$overallrate);
            }
            if($table == 'effect')            {
                $arr =explode("_",$id);
                $eff['strain_id'] =$arr[0];
                $eff['effect_id'] =$arr[1];
                if($st = $this->OverallEffectRating->find('first',array('conditions'=>array("strain_id"=>$eff['strain_id'],"effect_id"=>$eff['effect_id']))))                {
                    $overallrate = ($st['OverallEffectRating']['rate']+$rate)/2;
                    $overallrate = round($overallrate,2);
                    $this->OverallEffectRating->id = $st['OverallEffectRating']['id'];
                    $this->OverallEffectRating->saveField('rate',$overallrate);
                }                else                {
                    $eff['rate'] =$rate;
                    $this->OverallEffectRating->create();
                    $this->OverallEffectRating->save($eff); 
                }
            }
            if($table == 'symptom')            {
                $arr =explode("_",$id);
                $eff['strain_id'] =$arr[0];
                $eff['symptom_id'] =$arr[1];
                if($st = $this->OverallSymptomRating->find('first',array('conditions'=>array("strain_id"=>$eff['strain_id'],"symptom_id"=>$eff['symptom_id']))))                {
                    $overallrate = ($st['OverallSymptomRating']['rate']+$rate)/2;
                    $this->OverallSymptomRating->id = $st['OverallSymptomRating']['id'];
                    $overallrate = round($overallrate,2);
                    $this->OverallSymptomRating->saveField('rate',$overallrate);
                }                else                {
                    $eff['rate'] =$rate;
                    $this->OverallSymptomRating->create();
                    $this->OverallSymptomRating->save($eff); 
                }
            }
            if($table == 'colour')            {
                $arr =explode("_",$id);
                $eff['strain_id'] =$arr[0];
                $eff['colour_id'] =$arr[1];
                if($st = $this->OverallColourRating->find('first',array('conditions'=>array("strain_id"=>$eff['strain_id'],"colour_id"=>$eff['colour_id']))))                {
                    $overallrate = ($st['OverallColourRating']['rate']+$rate)/2;
                    $this->OverallColourRating->id = $st['OverallColourRating']['id'];
                    $overallrate = round($overallrate,2);
                    $this->OverallColourRating->saveField('rate',$overallrate);
                }                else                {
                    $eff['rate'] =$rate;
                    $this->OverallColourRating->create();
                    $this->OverallColourRating->save($eff); 
                }
            }
            if($table == 'flavor')            {
                $arr =explode("_",$id);
                $eff['strain_id'] =$arr[0];
                $eff['flavor_id'] =$arr[1];
                if($st = $this->OverallFlavorRating->find('first',array('conditions'=>array("strain_id"=>$eff['strain_id'],"flavor_id"=>$eff['flavor_id']))))                {
                    $overallrate = ($st['OverallFlavorRating']['rate']+$rate)/2;
                    $overallrate = round($overallrate,2);
                    $this->OverallFlavorRating->id = $st['OverallFlavorRating']['id'];
                    $this->OverallFlavorRating->saveField('rate',$overallrate);
                }                else                {
                    $eff['rate'] =$rate;
                    $this->OverallFlavorRating->create();
                    $this->OverallFlavorRating->save($eff); 
                }
            }
            
        }
        
        function rating($strain_id,$eff_id,$table)        {
            $this->checkSess();
            $this->loadModel('EffectRating');
            $this->loadModel('SymptomRating');
            $this->layout = "modal";
            $this->set('strain_id',$strain_id);
            $this->set('eff_id',$eff_id);
            $this->set('table',$table);
            if(isset($_POST['submit'])&& $_POST['submit']=='ok')            {
                  $arr['strain_id'] = $strain_id;
                  $arr['user_id'] = $this->Session->read("User.id");
                  $arr['rate'] = $_POST['rate'];
                  if($table =='effect')                  {
                        $arr['effect_id'] = $eff_id;
                        $this->EffectRating->deleteAll(array('user_id'=>$this->Session->read('User.id'),'strain_id'=>$strain_id,'effect_id'=>$eff_id));
                        $this->EffectRating->create();
                        if($this->EffectRating->save($arr))                        {
                            echo "Rating Saved.";die();
                        }                        else                        {
                            echo "Rating Could not be saved. Please try Again.";die();
                        }
                        
                  }                  elseif($table=='symptom')                  {
                        $arr['symptom_id'] = $eff_id;
                        $this->SymptomRating->deleteAll(array('user_id'=>$this->Session->read('User.id'),'strain_id'=>$strain_id,'symptom_id'=>$eff_id));
                        $this->SymptomRating->create();
                        if($this->SymptomRating->save($arr))                        {
                            echo "Rating Saved.";die();
                        }                        else                        {
                            echo "Rating Could not be saved. Please try Again.";die();
                        }

                    
                  }
                //var_dump($arr);    
            }
            
        }


        function factorreview($ReviewID){
            $this->loadModel('SymptomRating');
            $Symptoms = $this->SymptomRating->find('all',array('conditions'=>array("review_id"=>$ReviewID)));
            $SymptomList = array();
            foreach($Symptoms as $Symptom){
                $SymptomList[$Symptom["SymptomRating"]["symptom_id"]]=true;
            }
            $factor = implode(",", array_keys($SymptomList));

            $this->loadModel("Review");
            $this->Review->id = $ReviewID;
            $this->Review->saveField('symptoms', $factor);
            $this->Review->saveField('symptomscount', count($SymptomList));
        }
    }
?>