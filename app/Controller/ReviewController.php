<?php
    class ReviewController extends AppController {
        function beforeFilter(){
            $this->loadModel("Review");
        }
        
        function checkSess(){
            if(!$this->Session->read('User')) {
                $url = $this->here;
                $this->Session->setFlash('Please log in or register to add a review','default',array('class'=>'bad'));
                $this->redirect('/users/register?url='.$url);
            }
        }
        
        function showAll($offset=0) {
            $this->set('offset',$offset);
            $limit = $GLOBALS["settings"]["reviewlimit"];
            if(!isset($_GET['filter'])) {
                $reviews = $this->Review->find('all', array('limit' => $limit, 'offset' => $offset));
            } else {
                $reviews = $this->Review->find('all', array('limit' => $limit, 'offset' => $offset, 'order' => $_GET['filter'] . ' ' . $_GET['sort']));
            }
            $this->set("reviews",$reviews);
            $this->set('reviewz', $this->Review->find('count')); 
        }
        
        function show_all_blank($offset) {
            $this->layout = 'blank';
            $limit = $GLOBALS["settings"]["reviewlimit"];
            if(!isset($_GET['filter'])) {
                $reviews = $this->Review->find('all', array('limit' => $limit, 'offset' => $offset));
            } else {
                $reviews = $this->Review->find('all', array('limit' => $limit, 'offset' => $offset, 'order' => $_GET['filter'] . ' ' . $_GET['sort']));
            }
            $this->set("reviews",$reviews);
            $this->set('reviewz', $this->Review->find('count')); 
        }

        function all($limit=0){
            $this->set('limit',$limit);
            $this->checkSess();
            
            if($limit){
                $offset = $limit;
            } else {
                $offset = 0;
            }
            $limit = $GLOBALS["settings"]["reviewlimit"];
            
            $id =$this->Session->read('User.id');
            if (isset($_GET["delete"])){
                $reviewid= $_GET["delete"];
                if($this->deletereviews($id,"",$reviewid)) {
                    $this->Session->setFlash('Review deleted', 'default', array('class' => 'good'));
                } else {
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
            } else {
                $offset = 0;
            }
            $limit = $GLOBALS["settings"]["reviewlimit"];
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
            //die("GOT HERE");
            /*
            $this->set('effects',$this->Effect->find('all',array('conditions'=>array("negative"=>'0'))));
            $this->set('negative',$this->Effect->find('all',array('conditions'=>array("negative"=>'1'))));
            $this->set('colours',$this->Colour->find('all'));
            $this->set('flavors',$this->Flavor->find('all'));
            */

            //$this->loadModel('Symptom');
            //$this->set('symptoms',$this->Symptom->find('all'));
            if (isset($_GET["review"])){
                $this->set('editreview', $this->Review->findById($_GET["review"]));
            }

            if(isset($_POST['submit'])) {
                $ar['user_id'] = $this->Session->read('User.id');
                $ar['strain_id'] = $strain['Strain']['id'];

                //vardump($_POST);die();

                //$this->deletereviews($ar['user_id'],  $ar['strain_id'] );//only needs 1 review per strain

               $ar['on_date'] = date("y-m-d");
               foreach($_POST as $k=>$v){
                    $ar[$k]=$v;
               }
               $this->Review->create();
               if($this->Review->save($ar))  {
                    $r_id = $this->Review->id;
                    $ar['review_id'] = $this->addrating($ar['strain_id'], "strains", $_POST['rate'], false, $r_id);
                    foreach(["effect", "medical" => "symptom", "color" => "colour", "flavor", "activity"] as $POSTKEY => $TABLE){
                        if(is_numeric($POSTKEY)){
                            $POSTKEY = $TABLE;
                        }
                        if(isset($_POST[$POSTKEY]) && count($_POST[$POSTKEY])>0){
                            $lastkey = array_key_last($_POST[$POSTKEY]);
                            foreach($_POST[$POSTKEY] as $k=>$v ){
                                $this->addrating($strain['Strain']['id'], $TABLE, $v, $k, $r_id, $ar['user_id'], $k == $lastkey);
                            }
                        }
                    }

                    $this->Strain->id = $strain['Strain']['id'];
                    $review = 1;
                    if($strain['Strain']['review']){
                        $review += $strain['Strain']['review'];
                    }

                    $this->factorreview($r_id);
                    $this->Strain->saveField('review',$review);
                    $this->Session->setFlash('Review Saved, thank you for your support','default',array('class'=>'good'));
                    $this->redirect('all');
               }
            }
        }

        function addrating($strainID, $table, $rating, $itemID = false, $reviewID = false, $userID = false, $islast = false){
            //$table = strain (no $itemID), effect, symptom, color, flavor, activity
            if($table == "strains"){//review already made, recalculate the average for the strain
                $data = first("SELECT AVG(rate) as rating, COUNT(*) as review FROM reviews WHERE strain_id = " . $strainID);
                $data["id"] = $strainID;
                insertdb("strains", $data);
            } else {
                $data = [
                    "user_id"       => $userID,
                    "review_id"     => $reviewID,
                    $table . "_id"  => $itemID,
                    "strain_id"     => $strainID,
                    "rate"          => $rating
                ];
                insertdb($table . "_ratings", $data);//add the rating for the item to the table
                $data = first("SELECT AVG(rate) as rate FROM " . $table . "_ratings WHERE strain_id = " . $strainID . " AND " . $table . "_id = " . $itemID);
                $ID = first("SELECT id FROM overall_" . $table . "_ratings WHERE strain_id = " . $strainID . " AND " . $table . "_id = " . $itemID);
                if($ID){$data["id"] = $ID["id"];}
                insertdb("overall_" . $table . "_ratings", $data);//recalculate the average for the item
                if($islast && ($table == "activity" || $table == "symptom")){//only update when all the items have been added to the activities and symptoms review tables
                    $data = first("SELECT GROUP_CONCAT(" . $table . "_id) as rate, COUNT(*) as count FROM " . $table . "_ratings WHERE strain_id = " . $strainID . " AND review_id = " . $reviewID);
                    if($table == "activity"){$table = "activitie";}//special pluralization
                    insertdb("reviews", [
                       "id"                 =>  $reviewID,
                        $table . "s"        => $data["rate"],
                        $table . "scount"   => $data["count"]
                    ]);//add all the items to the review itself
                }
            }
            return $reviewID;
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

        function rating($strain_id,$eff_id,$table){
            $this->checkSess();
            $this->loadModel('EffectRating');
            $this->loadModel('SymptomRating');
            $this->layout = "modal";
            $this->set('strain_id',$strain_id);
            $this->set('eff_id',$eff_id);
            $this->set('table',$table);
            if(isset($_POST['submit'])&& $_POST['submit']=='ok'){
                  $arr['strain_id'] = $strain_id;
                  $arr['user_id'] = $this->Session->read("User.id");
                  $arr['rate'] = $_POST['rate'];
                  if($table =='effect') {
                        $arr['effect_id'] = $eff_id;
                        $this->EffectRating->deleteAll(array('user_id'=>$this->Session->read('User.id'),'strain_id'=>$strain_id,'effect_id'=>$eff_id));
                        $this->EffectRating->create();
                        if($this->EffectRating->save($arr)){
                            echo "Rating Saved.";die();
                        } else {
                            echo "Rating Could not be saved. Please try Again.";die();
                        }
                  } else if($table=='symptom') {
                        $arr['symptom_id'] = $eff_id;
                        $this->SymptomRating->deleteAll(array('user_id'=>$this->Session->read('User.id'),'strain_id'=>$strain_id,'symptom_id'=>$eff_id));
                        $this->SymptomRating->create();
                        if($this->SymptomRating->save($arr)){
                            echo "Rating Saved.";die();
                        } else {
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