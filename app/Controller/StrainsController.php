<?php
//include(APP.'webroot/html2pdf.class.php');
class StrainsController extends AppController {

    public $components = array('Paginator', 'RequestHandler');
    public $helpers = array('Js');

    function call($name){
        echo "<BR>Calling: " . $name . " at " . time() . "<BR>";
    }

    function getucond($small = false){
        $u_cond = '';
        if (isset($_GET['nationality'])) {
            $u_cond = 'nationality = "' . $_GET['nationality'] . '"';
        }

        if (isset($_GET['country'])) {
            $u_cond = $this->queryappend($u_cond, 'country = "' . $_GET['country'] . '"');
        }

        if (isset($_GET['gender'])) {
            $u_cond = $this->queryappend($u_cond, 'gender = "' . $_GET['gender'] . '"');
        }

        if (isset($_GET['age_group'])) {
            $u_cond = $this->queryappend($u_cond, 'age_group = "' . $_GET['age_group'] . '"');
        }
        if (isset($_GET['age_group_from'])) {
            if (isset($_GET['age_group_from'])){
                $to = $_GET['age_group_to'];
            }else {
                $to = 100;
            }
            if (!$to) {
                $to = 100;
            }
            $from = $_GET['age_group_from'];
            if ($from < 20) {
                $from = 20;
            }
            $from++;
            $counter = 0;
            for ($i = $from; $i <= $to; $i++) {
                $counter++;
                $j = $i + 9;
                $group = $i . '-' . $j;
                $i = $j;
                if ($counter == 1) {
                    $u_cond = $this->queryappend($u_cond, '(age_group = "' . $group . '"');
                } else {
                    $u_cond = $this->queryappend($u_cond, 'age_group = "' . $group . '"', "OR");
                }
            }
            $u_cond .= ')';
        }

        if (isset($_GET['health'])) {
            $u_cond = $this->queryappend($u_cond, 'health = "' . $_GET['health'] . '"');
        }

        if (isset($_GET['weight'])) {
            $u_cond = $this->queryappend($u_cond, 'weight = "' . $_GET['weight'] . '"');
        }
        if (isset($_GET['weight_from'])) {
            if (isset($_GET['weight_from'])) {
                $to = $_GET['weight_to'];
            } else {
                $to = 280;
            }
            if (!$to) {
                $to = 280;
            }

            $from = $_GET['weight_from'];
            if ($from > 100) {
                $from++;
            }
            $counter = 0;
            for ($i = $from; $i <= $to; $i++) {
                $counter++;
                if ($i > 100) {
                    $j = $i + 9;
                }else {
                    $j = $i + 10;
                }
                $group = $i . '-' . $j;
                $i = $j;
                if ($counter == 1) {
                    $u_cond = $this->queryappend($u_cond, '(weight = "' . $group . '"');
                } else {
                    $u_cond = $this->queryappend($u_cond, 'weight = "' . $group . '"', "OR");
                }
            }
            $u_cond = $u_cond . ')';
        }

        if (isset($_GET['years_of_experience'])) {
            $u_cond = $this->queryappend($u_cond, 'years_of_experience = "' . $_GET['years_of_experience'] . '"');
        }
        if (isset($_GET['years_of_experience_from'])) {
            if (isset($_GET['years_of_experience_from'])) {
                $to = $_GET['years_of_experience_to'];
            }else {
                $to = 50;
            }
            if (!$to) {
                $to = 50;
            }
            $from = $_GET['years_of_experience_from'];
            $u_cond = $this->queryappend($u_cond, 'years_of_experience >= ' . $from . ' AND years_of_experience <= ' . $to);
        }

        if (isset($_GET['frequency'])) {
            $u_cond = $this->queryappend($u_cond, 'frequency = "' . $_GET['frequency'] . '"');
        }

        if (isset($_GET['body_type'])) {
            $u_cond = $this->queryappend($u_cond, 'body_type = "' . $_GET['body_type'] . '"');
        }

        if ($u_cond) {
            return 'SELECT id FROM users WHERE ' . $u_cond;
        }
        return '';
    }

    function index($slug) {
        //$this->call(__METHOD__);
        //if($this->Session->read('User')){  $this->set('user',$this->User->findById($this->Session->read('User.id'))); }

        $this->loadModel('Country');
        $this->set('countries', $this->Country->find('all'));
        $this->loadModel('OverallFlavorRating');
        $this->loadModel('Review');
        $this->loadModel('FlavorRating');
        $this->loadModel('SymptomVote');

        $q = $this->Strain->find('first', array('conditions' => array('slug' => $slug)));
        //debug($q );
        $this->set('title', $q['Strain']['name']);
        $this->set('description', $q['Strain']['description']);
        $this->set('keyword', $q['Strain']['name'] . ' , Canbii , Medical , Marijuana , Medical Marijuana');
        
        $params_vote_sum = array(
            "conditions"=>array("SymptomVote.strain_id"=>$q['Strain']['id']),
            "group"=>array("SymptomVote.symptom_id"),  
            'fields' => array('SymptomVote.symptom_id','SUM(SymptomVote.vote_yes) as sum'),
        );
        
        $votes_sum = $this->SymptomVote->find("all",$params_vote_sum);
        $votes_sum = Set::combine($votes_sum, '{n}.SymptomVote.symptom_id', '{n}.0.sum');
        
        $this->set("symptom_votes",$votes_sum);
        
        $params_vote_user = array(
                 "conditions"=>array("SymptomVote.strain_id"=>$q['Strain']['id'], "SymptomVote.client_http"=>md5($_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']))
        );
        
        $vote_user = $this->SymptomVote->find("all",$params_vote_user);
        $vote_user = Set::combine($vote_user, '{n}.SymptomVote.symptom_id', '{n}.SymptomVote.vote_yes');
        
        //die(var_dump($vote_user));
        
        $this->set("symptom_vote_user",$vote_user);

        $profile_filter = $this->getucond();

        if ($profile_filter) {
            $q2 = $this->FlavorRating->find('all', array('conditions' => array('strain_id' => $q['Strain']['id'], 'user_id IN (' . $profile_filter . ')'), 'order' => 'COUNT(flavor_id) DESC', 'group' => 'flavor_id', 'limit' => 3));
        }else {
            $q2 = $this->FlavorRating->find('all', array('conditions' => array('strain_id' => $q['Strain']['id']), 'order' => 'COUNT(flavor_id) DESC', 'group' => 'flavor_id', 'limit' => 3));
        }

        if ($profile_filter) {
            $q3 = $this->Review->find('first', array('conditions' => array('strain_id' => $q['Strain']['id'], 'user_id IN (' . $profile_filter . ')'), 'order' => 'Review.helpful DESC'));
        }else {
            $q3 = $this->Review->find('first', array('conditions' => array('strain_id' => $q['Strain']['id']), 'order' => 'Review.helpful DESC'));
        }
        if ($profile_filter) {
            $q4 = $this->Review->find('first', array('conditions' => array('strain_id' => $q['Strain']['id'], 'user_id IN (' . $profile_filter . ')'), 'order' => 'Review.id DESC'));
        }else {
            $q4 = $this->Review->find('first', array('conditions' => array('strain_id' => $q['Strain']['id']), 'order' => 'Review.id DESC'));
        }
        $this->set('strain', $q);
        $this->set('flavor', $q2);
        $this->set('helpful', $q3);
        $this->set('recent', $q4);
        if ($q['Strain']['id']) {
            $this->Strain->id = $q['Strain']['id'];
            $viewed = $q['Strain']['viewed'] + 1;
            $this->Strain->saveField('viewed', $viewed);
        }

        $ip = $_SERVER['REMOTE_ADDR'];
        $this->loadModel('VoteIp');
        $q5 = false;
        if (isset($q3['Review'])) {
            $q5 = $this->VoteIp->find('first', array('conditions' => array('review_id' => $q3['Review']['id'], 'ip' => $ip)));
        }
        if ($q5) {
            $this->set('vote', 1);
            $this->set('yes', $q5['VoteIp']['vote_yes']);
        } else {
            $this->set('vote', 0);
        }
        $this->set('profile_filter', $profile_filter);
    }

    function download($slug = null) {
        //$this->call(__METHOD__);
        // Include Component
        App::import('Component', 'Pdf');
        // Make instance
        $Pdf = new PdfComponent();
        // Invoice name (output name)
        $Pdf->filename = 'your_invoice'; // Without .pdf
        // You can use download or browser here
        $Pdf->output = 'download';
        $Pdf->init();
        // Render the view
        $Pdf->process(Router::url('/', true) . 'strains/index/' . $slug);
        die();
        $this->render(false);
    }

    function getFlavor($id) {
        //$this->call(__METHOD__);
        $this->loadModel('Flavor');
        $q = $this->Flavor->findById($id);
        return $q['Flavor']['title'];
        die();
    }

    function getEffect($id) {
        //$this->call(__METHOD__);
        $this->loadModel('Effect');
        $q = $this->Effect->findById($id);
        return $q['Effect']['title'];
        die();
    }

    function getSymptom($id) {
        //$this->call(__METHOD__);
        $this->loadModel('Symptom');
        $q = $this->Symptom->findById($id);
        return $q['Symptom']['title'];
        die();
    }

    function getPosEff($id) {
        //$this->call(__METHOD__);
        $this->loadModel('Effect');
        $q = $this->Effect->findById($id);
        return $q['Effect']['negative'] == 0;
    }
    
    function symptomVote($strain_id,$symp){
       die($this->request->data('symp'));
       die(var_dump($this->params));
    }

    function getUserName($id) {
        //$this->call(__METHOD__);
        $user = first("SELECT username FROM users WHERE id=" . $id);
        if($user){
            return $user["username"];
        }
        return "Unknown";
    }

    function helpful($id, $yes) {
        //$this->call(__METHOD__);
        $this->loadModel('Review');
        $q = $this->Review->findById($id);
        if ($yes == 'yes') {
            $helpful = $q['Review']['helpful'] + 1;
            $not_helpful = $q['Review']['not_helpful'];
        } else {
            $not_helpful = $q['Review']['not_helpful'] + 1;
            $helpful = $q['Review']['helpful'];
        }
        $this->loadModel('VoteIp');
        $ip = $_SERVER['REMOTE_ADDR'];
        if (!$this->VoteIp->find('first', array('conditions' => array('review_id' => $id, 'ip' => $ip)))) {
            $this->Review->id = $id;
            $this->Review->saveField('helpful', $helpful);
            $this->Review->saveField('not_helpful', $not_helpful);
            $this->VoteIp->create();
            $arr['review_id'] = $id;
            $arr['ip'] = $ip;
            $arr['vote_yes'] = 0;
            if ($yes == 'yes') {
                $arr['vote_yes'] = 1;
            }
            $this->VoteIp->save($arr);
        }
        die();
    }

    function all($type = '', $limit = 0) {
        //$this->call(__METHOD__);
        if($this->Session->read('User')){
            $this->loadModel('User');
            $this->set('user',$this->User->findById($this->Session->read('User.id')));
        }
        $this->filter($limit, $type, $this->layout, "all");
        /*
        $this->loadModel('Country');
        $this->set('countries', $this->Country->find('all'));
        $this->set('type', $type);
        $limit = $GLOBALS["settings"]["limit"];
        $this->set('limit', $limit);
        $arr = array('indica' => 1, 'sativa' => 2, 'hybrid' => 3);
        $conditions = array("hasocs" => 1);
        if ($type && isset($arr[$type])) {$conditions['type_id'] = $arr[$type];}//warning: does not handle strains properly
        if(isset($_GET["key"]) && $_GET["key"]){
            $conditions['name LIKE'] = '%' . $_GET["key"] . '%';
        }
        $this->set('strain',  $this->Strain->find('all', array('conditions' => $conditions, 'order' => 'Strain.viewed DESC ,Strain.id DESC', 'limit' => $GLOBALS["settings"]["limit"], 'offset' => $limit)));
        $this->set('strains', $this->Strain->find('count', array('conditions' => $conditions)));
        $this->set('offset', 0);
        */
    }

    function showAll($type = '', $limit = 0) {
        $this->loadModel('Country');
        $this->set('countries', $this->Country->find('all'));
        $this->set('type', $type);
        $this->set('limit', $limit);
        
        $this->Strain->unbindModel(array('hasMany'=>array('OverallEffectRating','OverallSymptomRating','Flavorstrain','Review','StrainImage')));
        $this->set('strain', $this->Strain->find('all', array('order' => 'Strain.id')));
        //$this->set('strains', $this->Strain->find('count'));
    }

    function search($type = '', $limit = 0) {
        //$this->call(__METHOD__);
        $this->filter($limit, $type, "search");
        return;
    }

    function getEffectRate($profile_filter, $strain) {
        //$this->call(__METHOD__);
        //echo urlencode("SELECT id FROM users WHERE nationality='asian'");die();
        //echo $profile_filter;die();
        $this->loadModel('Effect_rating');
        $q = $this->Effect_rating->find('all', array('conditions' => array('user_id IN (' . $profile_filter . ') AND rate <> 0 AND strain_id = ' . $strain), 'order' => 'effect_id'));
        return $q;
    }

    function getSymptomRate($profile_filter, $strain) {
        //$this->call(__METHOD__);
        //echo urlencode("SELECT id FROM users WHERE nationality='asian'");die();
        //echo $profile_filter;die();
        $this->loadModel('SymptomRating');
        $q = $this->SymptomRating->find('all', array('conditions' => array('user_id IN (' . $profile_filter . ') AND rate <> 0 AND strain_id = ' . $strain), 'order' => 'symptom_id'));
        return $q;
    }

    function getEffectReview($profile_filter, $strain) {
        //$this->call(__METHOD__);
        $this->loadModel('Review');
        $q = $this->Review->find('all', array('conditions' => array('user_id IN (' . $profile_filter . ') AND strain_id = ' . $strain)));
        return $q;
    }

    function getcolors($strain) {
        //$this->call(__METHOD__);
        $this->loadModel('Review');
        $q = $this->Review->find('all', array('conditions' => array('strain_id'=>$strain)));
        return $q;
    }

    function rectime($lasttime, $text = ""){
        //$this->call(__METHOD__);
        $method = "console.log";//"alert";
        $now = time();
        $diff = $now - $lasttime;
        echo "<SCRIPT>" . $method . "('" . $now . " " . $diff . " " . $text . "');</SCRIPT>";
        return $now;
    }

    function filter($offset = 0, $type = '', $layout = "blank", $tag = "unknown") {
        //$this->call(__METHOD__);
        $this->loadModel('Country');
        $this->loadModel('Strainslim');
        $this->set('countries', $this->Country->find('all'));
        $limit = $GLOBALS["settings"]["limit"];
        $this->set('limit', $limit);
        $this->set('type', $type);
        $this->layout = $layout;
        $key = '';
        $_GET = array_merge($_GET, $_POST);

        if (isset($_GET['key'])) {
            $key = $_GET['key'];
            if (substr($key,0,3)=="CMD"){
                echo $this->commmandline($key);
            }
        }

        $condition = '';
        $effects = array();
        if (isset($_GET['effects'])) {
            $effects = $_GET['effects'];
        }

        $test_sort = '';
        if (isset($_GET['sort'])) {
            $test_sort = $_GET['sort'];
        }

        $profile_filter = $this->getucond();

        if (isset($_GET['sort']) && ($_GET['sort'] == 'indica' || $_GET['sort'] == 'sativa' || $_GET['sort'] == 'hybrid')) {
            $s_arr = array('indica' => 1, 'sativa' => 2, 'hybrid' => 3);
            $condition = 'Strain.type_id = ' . $s_arr[$_GET['sort']];
            $_GET['sort'] = 'alpha';
        }

        if ($effects && is_array($effects)) {
            if (isset($_GET['sort']) && ($test_sort == 'indica' || $test_sort == 'sativa' || $test_sort == 'hybrid')) {
                $condition .= ' AND ';
            }
            $i = 0;
            foreach ($effects as $e) {//this loop will no longer function, as it's no longer an array
                $i++;
                if ($i == 1) {
                    $condition .= 'Strain.id IN (SELECT strain_id FROM reviews WHERE id IN (SELECT review_id
                                        FROM effect_ratings
                                        WHERE effect_id
                                        IN (' . $e;
                }else {
                    $condition .= ',' . $e;
                }
            }
            $condition .= ') GROUP BY review_id HAVING COUNT( effect_id ) =' . count($effects) . ')';
            if ($profile_filter) {
                $condition .= ' AND user_id IN (' . $profile_filter . ')';
            }
            $condition .= ')';
        }

        foreach(["symptoms" => "symptom", "activities" => "activity"] as $plural => $singular) {
            if (isset($_GET[$plural])) {
                $symptoms = $_GET[$plural];
                if (is_array($symptoms)) {
                    $symptomscount = count($symptoms);
                    $symptoms = implode(",", $symptoms);
                } else {
                    $symptomscount = count(explode(",", $symptoms));
                }
                if ($_SERVER["SERVER_NAME"] != "localhost" && $symptomscount > 1 && false) {
                    $symptomscount = 1;
                    $symptoms = explode(",", $symptoms)[0];
                    echo "You can only search by 1 " . $singular . " at a time";
                }
                if ($condition) {
                    $condition .= ' AND ';
                }

                //super query
                $condition .= 'Strain.id IN (SELECT strain_id FROM (SELECT strain_id,
                                        COUNT(DISTINCT ' . $singular . '_id) AS matched_' . $plural . '
                                        FROM ' . $singular . '_ratings
                                        WHERE ' . $singular . '_id IN (' . $symptoms . ')
                                        GROUP BY strain_id
                                        HAVING matched_' . $plural . ' = ' . $symptomscount . ') as IDs)';

                $this->makesymptomslist($symptoms, $symptomscount, $plural, "filter: " . $tag);
            }
        }

        if (isset($_GET['sort']) && ($test_sort != 'indica' && $test_sort != 'sativa' && $test_sort != 'hybrid')) {
            $sort = $_GET['sort'];
            if ($sort == 'recent') {
                $order = 'Strain.id ' . $_GET['order'];
            } else if ($sort == 'rated') {
                $order = 'Strain.rating ' . $_GET['order'];
            } else if ($sort == 'reviewed') {
                $order = 'Strain.review ' . $_GET['order'];
            } else if ($sort == 'viewed') {
                $order = 'Strain.viewed ' . $_GET['order'];
            } else {
                $order = 'Strain.name ' . $_GET['order'];
            }
        } else {
            $order = "";
        }

        $model=$this->Strainslim;
        $parameters = array();
        $conditions = array();
        if($key){$conditions['name LIKE'] = '%' . $key . '%';}
        if($profile_filter){$conditions[] = 'Strain.id IN (SELECT strain_id FROM reviews WHERE user_id IN (' . $profile_filter . '))';}
        if($condition){$conditions[] = $condition;}
        if ($type) {
            $arr = array('indica' => 1, 'sativa' => 2, 'hybrid' => 3);//warning: does not handle strains properly
            if(isset($arr[$type])) {
                $conditions['type_id'] = $arr[$type];
            }
        }
        $conditions['hasocs'] = 1;
        $parameters['conditions'] = $conditions;
        if ($order) {
            $parameters['order'] = $order;
        } else {
            $parameters['order'] = 'Strain.viewed DESC, Strain.id DESC';
        }

        $count = $model->find('count', $parameters);
        $this->set('strains', $count);
        $this->set('limit', $limit);
        $this->set('offset', $offset);
        $parameters['limit'] = $limit;
        $parameters['offset'] = $offset;
        $this->set('conditions', $parameters);
        $this->set('strain', $model->find('all', $parameters));
    }

    function makesymptomslist($symptoms, $symptomscount, $table = "symptoms", $tag){
        $needsHTML = $tag != "filter: all";
        if($symptoms && $needsHTML) {
            if (is_array($symptoms)){ $symptoms = implode(",", $symptoms);}
            $symptoms = Query("SELECT * FROM " . $table . " WHERE id IN (" . $symptoms . ")", true);
            //$this->loadModel('Symptom');$symptoms = $this->Symptom->find('all',array('conditions' => array('id IN (' . $symptoms . ')')));
            $delimeter = "";
            $index = 0;
            echo '<SPAN ID="' . $table . '_list" TAG="' . $tag . '">';
            if ($table == "symptoms") {
                echo "These strains have been known to help with: ";
            } else {
                echo "These strains are known to be enjoyable with: ";
            }
            foreach ($symptoms as $symptom) {
                echo $delimeter . $symptom['title'];
                $index++;
                if (!$delimeter) {$delimeter = ", ";}
                if ($index == $symptomscount - 1) {$delimeter = " and ";}
            }
            echo "<BR><BR></SPAN>";
        }
    }

    //$u_cond = $this->queryappend($u_cond,
    function queryappend($currentquery, $append, $operation = "AND"){
        if($currentquery){
            return $currentquery . " " . $operation . " " . $append;
        }
        return $append;
    }

    function review($slug, $sort = null, $limit = 0) {
        //$this->call(__METHOD__);
        $this->loadModel('Review');
        $this->loadModel('Country');
        $this->set('countries', $this->Country->find('all'));
        $this->set('limit', $limit);
        $this->set('slug', $slug);

        $profile_filter = $this->getucond(true);
        $offset = 0;
        if(isset($_POST["limit"])){
            $offset = $_POST["limit"];
        } else if ($limit) {
            $offset = $limit;
        }
        $limit = $GLOBALS["settings"]["limit"];
        $q = $this->Strain->findBySlug($slug);
        if (!$sort || $sort == 'recent') {//do not use nested redundant if statements, generate the array cell by cell
            if (!isset($_GET['user'])) {
                if (!$profile_filter) {
                    $q2 = $this->Review->find('all', array('conditions' => array('Review.strain_id' => $q['Strain']['id']), 'order' => 'Review.id DESC', 'limit' => $limit, 'offset' => $offset));
                }else {
                    $q2 = $this->Review->find('all', array('conditions' => array('Review.strain_id' => $q['Strain']['id'], 'Review.user_id IN (' . $profile_filter . ')'), 'order' => 'Review.id DESC', 'limit' => $limit, 'offset' => $offset));
                }
                $this->set('reviewz', $this->Review->find('count', array('conditions' => array('Review.strain_id' => $q['Strain']['id']))));
            } else {
                $q2 = $this->Review->find('all', array('conditions' => array('Review.user_id' => $_GET['user']), 'order' => 'Review.id DESC', 'limit' => $limit, 'offset' => $offset));
                $this->set('reviewz', $this->Review->find('count', array('conditions' => array('Review.user_id' => $_GET['user']))));
            }
        } else {
            if (!isset($_GET['user'])) {
                $q2 = $this->Review->find('all', array('conditions' => array('Review.strain_id' => $q['Strain']['id']), 'order' => 'Review.helpful DESC', 'limit' => $limit, 'offset' => $offset));
                $this->set('reviewz', $this->Review->find('count', array('conditions' => array('Review.strain_id' => $q['Strain']['id']))));
            } else {
                $q2 = $this->Review->find('all', array('conditions' => array('Review.user_id' => $_GET['user']), 'order' => 'Review.helpful DESC', 'limit' => $limit, 'offset' => $offset));
                $this->set('reviewz', $this->Review->find('count', array('conditions' => array('Review.user_id' => $_GET['user']))));
            }
        }
        $this->loadModel('VoteIp');
        $this->set('vip', $this->VoteIp);
        if (isset($_GET['user'])) {
            $this->set('reviews', $q2);
            $this->render('/review/all');
        } else {
            $this->set('strain', $q);
            $this->set('review', $q2);
        }
    }

    function review_filter($slug, $sort, $limit) {
        //$this->call(__METHOD__);
        $this->set('limit', $limit);
        $this->set('slug', $slug);
        $this->set('sort', $sort);

        $profile_filter = $this->getucond();
        $offset = 0;
        if(isset($_POST["limit"])){
            $offset = $_POST["limit"];
        } else if ($limit) {
            $offset = $limit;
        }
        $limit = $GLOBALS["settings"]["limit"];
        $this->layout = 'blank';

        $this->loadModel('Review');
        $q = $this->Strain->findBySlug($slug);
        if (!$sort || $sort == 'recent') {//do not use nested redundant if statements, generate the array cell by cell
            if (!isset($_GET['user'])) {
                if (!$profile_filter) {
                    $q2 = $this->Review->find('all', array('conditions' => array('Review.strain_id' => $q['Strain']['id']), 'order' => 'Review.id DESC', 'limit' => $limit, 'offset' => $offset));
                }else {
                    $q2 = $this->Review->find('all', array('conditions' => array('Review.strain_id' => $q['Strain']['id'], 'Review.user_id IN (' . $profile_filter . ')'), 'order' => 'Review.id DESC', 'limit' => $limit, 'offset' => $offset));
                }
                if (!$profile_filter) {
                    $this->set('reviewz', $this->Review->find('count', array('conditions' => array('Review.strain_id' => $q['Strain']['id']))));
                }else {
                    $this->set('reviewz', $this->Review->find('count', array('conditions' => array('Review.strain_id' => $q['Strain']['id'], 'Review.user_id IN (' . $profile_filter . ')'))));
                }
                //var_dump($q2);die();
            } else {
                $q2 = $this->Review->find('all', array('conditions' => array('Review.user_id' => $_GET['user']), 'order' => 'Review.id DESC', 'limit' => $limit, 'offset' => $offset));
                $this->set('reviewz', $this->Review->find('count', array('conditions' => array('Review.user_id' => $_GET['user']))));
            }
        } else {
            if (!isset($_GET['user'])) {
                if (!$profile_filter) {
                    $q2 = $this->Review->find('all', array('conditions' => array('Review.strain_id' => $q['Strain']['id']), 'order' => 'Review.helpful DESC', 'limit' => $limit, 'offset' => $offset));
                }else {
                    $q2 = $this->Review->find('all', array('conditions' => array('Review.strain_id' => $q['Strain']['id'], 'Review.user_id IN (' . $profile_filter . ')'), 'order' => 'Review.helpful DESC', 'limit' => $limit, 'offset' => $offset));
                }
                if (!$profile_filter) {
                    $this->set('reviewz', $this->Review->find('count', array('conditions' => array('Review.strain_id' => $q['Strain']['id']))));
                }else {
                    $this->set('reviewz', $this->Review->find('count', array('conditions' => array('Review.strain_id' => $q['Strain']['id'], 'Review.user_id IN (' . $profile_filter . ')'))));
                }
            } else {
                $q2 = $this->Review->find('all', array('conditions' => array('Review.user_id' => $_GET['user']), 'order' => 'Review.helpful DESC', 'limit' => $limit, 'offset' => $offset));
                $this->set('reviewz', $this->Review->find('count', array('conditions' => array('Review.user_id' => $_GET['user']))));
            }
        }

        $this->loadModel('VoteIp');
        $this->set('vip', $this->VoteIp);
        if (isset($_GET['user'])) {
            $this->set('reviews', $q2);
            $this->render('/review/all');
        } else {
            $this->set('strain', $q);
            $this->set('review', $q2);
        }

    }

    function ajax_search(){
        //$this->call(__METHOD__);
        $str = $_POST['str'];
        if (substr($str,0,3) == "CMD"){
            echo $this->commmandline($str);
        } else {
            $search = $this->Strain->find("all", array('conditions' => array('name LIKE' => "%" . $str . "%")));
            if (count($search) == 0) {
                echo "No results found for '" . $str . "'";
            }
            foreach ($search as $s) {
                echo "<a href='" . $this->webroot . "review/add/" . $s['Strain']['slug'] . "' class='more blue icon_small_arrow margin_right_white page_margin_top' style='margin-right:10px;' title='" . $s['Strain']['slug'] . "'>" . $s['Strain']['name'] . "</a>";
            }
        }
        die();
    }

    function commmandline($Text){
        //$this->call(__METHOD__);
        if (substr($Text,0,3) == "CMD") {
            substr($Text, 3, strlen($Text) - 3);
        }
        switch(strtolower(trim($Text))){
            case "factor":
                return "TEST: " . $this->factorstrains();
                break;
        }
        return "No command run (" . $Text . ")";
    }

    function factorstrains($ForceRefresh=false){
        //ALTER TABLE `reviews` ADD `symptomscount` INT NOT NULL ;
        $this->loadModel("Review");
        $Reviews = $this->Review->find('all');
        $Index=0;
        foreach($Reviews as $Review){
            if(!$Review['Review']['symptoms'] || $ForceRefresh) {
                $id = $Review['Review']['id'];
                $factor=$this->factorreview($id);
                if($factor) {
                    $Index++;
                    $this->Review->id = $id;
                    $this->Review->saveField('symptoms', $factor);
                    $this->Review->saveField('symptomscount', count(explode(",", $factor)));
                }
            }
        }
        return $Index . " reviews factored";
    }

    function factorreview($ReviewID){
        $this->loadModel('SymptomRating');
        $Symptoms = $this->SymptomRating->find('all',array('conditions'=>array("review_id"=>$ReviewID)));
        $SymptomList = array();
        foreach($Symptoms as $Symptom){
            $SymptomList[$Symptom["SymptomRating"]["symptom_id"]]=true;
        }
        return implode(",", array_keys($SymptomList));
    }

    /*function generateImage($slug){
        if($_SERVER['SERVER_NAME']=='localhost'){
            $html_content = file_get_contents('http://127.0.0.1'.$this->webroot.'strains/'.$slug);
        }else{
            $html_content = file_get_contents('http://www.charlieschopsticks.com/strains/'.$slug);
        }
        $html2pdf = new HTML2PDF('P', 'A4');
        $html2pdf->writeHTML($html_content);
        $rand = rand(1000000000,9999999999).'.pdf';
        $file = $html2pdf->Output(APP.'webroot/pdfs/'.$rand,'F');
         
        $im = new imagick(APP.'webroot/pdfs/'.$rand);
        $im->setImageFormat( "jpg" );
        $img_name = str_replace('.pdf','',$rand).'.jpg';
        $im->setSize(800,600);
        $im->writeImage($img_name);
        $im->clear();
        $im->destroy();
        die();
    }*/
}

?>