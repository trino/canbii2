<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();

/**
 * Displays a view
 *
 * @param mixed What page to display
 * @return void
 * @throws NotFoundException When the view file could not be found
 *	or MissingViewException in debug mode.
 */
	public function index(){
     //   $this->loadModel('Strain');
      //  $this->set('strain',$this->Strain->find('all',array('order'=>'Strain.id DESC','limit'=>1)));
        $this->set('homepage','1');
    }



    public function landing(){

    }

    function getGeneric(){
        $arr['title'] = 'Canbii';
        $arr['keyword']='Canbii , Marijuana , Medical marijuana , Strains,Strain Types , Sativa , Hybrid , Indica';
        $arr['description'] = 'Medical marijuana has been used as a form of treatment for thousands of years. This all natural plant contains tetrahydrocannabinol (THC) and cannabidiol (CBD) which helps treat illnesses or alleviate symptoms. What is THC and CBD? Tetrahydrocannabinol (THC) is the main psychoactive ingredient in the cannabis plant. It gives one the feeling of euphoria. It is also known to increase ones appetite. Cannabidiol (CBD) is a cannabinoid that repress neurotransmitter release in the brain. Together THC and CBD offers natural pain relief. ';
        return $arr;
    }

    function get_strain(){
        $this->loadModel('Review');
        return $this->Review->find('all',array('order'=>'Review.id DESC','limit'=>4));
    }

    /* public function view_page($slug){
        $detail = $this->Page->findBySlug($slug);
        $this->set('detail',$detail);
    } */
	
	function contact_us(){
         if(isset($_POST['name'])&&$_POST['name']) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $sub = $_POST['subject'];
            $msg = $_POST['message'];
            $emails = new CakeEmail();
            $emails->from(array('info@canbii.com'=>'Canbii'));
            $emails->emailFormat('html');
            $emails->template('default');
            $emails->subject('New Contact Message');

            $message="You've received a new message from Canbii<br/><br/>
            
            <b>From</b> : ".$name."<br/>
            <b>Email</b> : ".$email."<br/>
            <b>Subject</b> : ".$sub."<br/>
            <b>Message</b> : ".$msg."<br/><br/>Thank you, <br/>The Canbii Team";
            $emails->to('info@canbii.com');
            $emails->send($message);
            $this->Session->setFlash('Message Sent Successfully!', 'default', array('class' => 'good'));
            $this->redirect('contact_us');
        }
    }



    function doctors(){
        if(isset($_POST['name'])&&$_POST['name']){
            $name = $_POST['name'];
            $email = $_POST['email'];
            $sub = $_POST['subject'];
            $msg = $_POST['message'];
            $emails = new CakeEmail();
            $emails->from(array('info@canbii.com'=>'Canbii'));
            $emails->emailFormat('html');
            $emails->template('default');
            $emails->subject('New Contact Message');

            $message="You've received a new message from Canbii<br/><br/>

            <b>From</b> : ".$name."<br/>
            <b>Email</b> : ".$email."<br/>
            <b>Subject</b> : ".$sub."<br/>
            <b>Message</b> : ".$msg."<br/><br/>Thank you, <br/>The Canbii Team";
            $emails->to('info@canbii.com');
            $emails->send($message);
            $this->Session->setFlash('Message Sent Successfully!', 'default', array('class' => 'good'));
            $this->redirect('doctors');
        }
    }

	function about(){
    }
	
    function shop(){
    }

	function privacy(){
    }

    function terms(){
    }

    function cron(){
    }

    function getEff(){
        //this will crash!!!
        $this->loadModel('Effect');
        return $this->Effect->find('all',array('conditions'=>array('Effect.negative'=>0), 'order'=>'Effect.title ASC'));
    }

    function getSym(){
        $this->loadModel('Symptom');
        return $this->Symptom->find('all',array( 'order'=>'Symptom.title ASC'));
    }

    public function pdf($slug = null) {
        $this->autoRender = false;
        $this->layout = 'blank';
        $view = new View($this, true);
        $this->loadModel('OverallFlavorRating');
        $this->loadModel('Review');
        $this->loadModel('FlavorRating');
        $this->loadModel('Strain');
        $q = $this->Strain->find('first',array('conditions'=>array('slug'=>$slug)));
        
        $this->set('title',$q['Strain']['name']);
        $this->set('description',$q['Strain']['description']);
        $this->set('keyword',$q['Strain']['name'].' , Canbii , Medical , Marijuana , Medical Marijuana');
        
                
        $q2 = $this->FlavorRating->find('all',array('conditions'=>array('strain_id'=>$q['Strain']['id']),'order'=>'COUNT(flavor_id) DESC','group'=>'flavor_id','limit'=>3));
        $q3 = $this->Review->find('first',array('conditions'=>array('strain_id'=>$q['Strain']['id']),'order'=>'Review.helpful DESC'));
        $q4 = $this->Review->find('first',array('conditions'=>array('strain_id'=>$q['Strain']['id']),'order'=>'Review.id DESC'));
        $view->set('strain',$q);
        $view->set('flavor',$q2);
        $view->set('helpful',$q3);
        $view->set('recent',$q4);
        $this->Strain->id = $q['Strain']['id'];
        $viewed = $q['Strain']['viewed']+1;
        $this->Strain->saveField('viewed',$viewed);
        
        $ip = $_SERVER['REMOTE_ADDR'];
        $this->loadModel('VoteIp');
        $q5 = $this->VoteIp->find('first',array('conditions'=>array('review_id'=>$q3['Review']['id'],'ip'=>$ip)));
        if($q5){
            $view->set('vote',1);
            $view->set('yes',$q5['VoteIp']['vote_yes']);
        } else {
            $view->set('vote', 0);
        }
            
        $view_output = $view->render('/strains/index');

        // Load from Vendors dir
        App::import('Vendor', 'html2pdf', array('file' => 'html2pdf_v4.03' .DS . 'html2pdf.class.php'));
        $html2pdf = new HTML2PDF('P', 'A4', 'en');
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($view_output);
        $html2pdf->Output('test.pdf', 'D');
     }

     function download($slug = null) {
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
        $Pdf->process(Router::url('/', true) . 'strains/index/'. $slug);
        die();
        $this->render(false);
    }
    
    function send_email() {
        if(isset($_POST['send'])){
            $slug = $_POST['slug'];
            $this->loadModel('OverallFlavorRating');
            $this->loadModel('Review');
            $this->loadModel('FlavorRating');
            $this->loadModel('Strain');
            $view = new View($this, false);
            $view->layout = 'pdf';
            $q = $this->Strain->find('first',array('conditions'=>array('slug'=>$slug)));
            
            $this->set('title',$q['Strain']['name']);
            $this->set('description',$q['Strain']['description']);
            $this->set('keyword',$q['Strain']['name'].' , Canbii , Medical , Marijuana , Medical Marijuana');
                    
            $q2 = $this->FlavorRating->find('all',array('conditions'=>array('strain_id'=>$q['Strain']['id']),'order'=>'COUNT(flavor_id) DESC','group'=>'flavor_id','limit'=>3));
            $q3 = $this->Review->find('first',array('conditions'=>array('strain_id'=>$q['Strain']['id']),'order'=>'Review.helpful DESC'));
            $q4 = $this->Review->find('first',array('conditions'=>array('strain_id'=>$q['Strain']['id']),'order'=>'Review.id DESC'));
            $view->set('strain',$q);
            $view->set('flavor',$q2);
            $view->set('helpful',$q3);
            $view->set('recent',$q4);
            $this->Strain->id = $q['Strain']['id'];
            $viewed = $q['Strain']['viewed']+1;
            $this->Strain->saveField('viewed',$viewed);
            
            $ip = $_SERVER['REMOTE_ADDR'];
            $this->loadModel('VoteIp');
            $q5 = $this->VoteIp->find('first',array('conditions'=>array('review_id'=>$q3['Review']['id'],'ip'=>$ip)));
            if($q5){
                $view->set('vote',1);
                $view->set('yes',$q5['VoteIp']['vote_yes']);
            } else {
                $view->set('vote', 0);
            }
            
            $html = $view->render('/strains/index'); 
            $e = explode(",",$_POST['email']);
            foreach($e as $email){
                $email = trim($email);
                $emails = new CakeEmail();
                $emails->reset();
                $emails->template('default');
                $emails->from(array('info@canbii.com'=>'Canbii'));
            
                $emails->emailFormat('html');
                
                $emails->subject('Strain Review');
                
                
                $message=$html;
                $emails->to($email);
                if($emails->send($message)) {
                    $this->Session->setFlash("Email Successfully Sent.", 'default', array('class' => 'good'));
                }
            }
        }
        $this->redirect("/strains/all");
        die();
    }
}
