	<div class="page_layout page_margin_top clearfix">
		<div class="page_header clearfix">
			<div class="page_header_left">
				<h1 class="page_title">For Doctors / Cannabis Practitioners</h1>
				<ul class="bread_crumb">
					<li>
						<a href="<?php echo $this->webroot?>" title="Home">
							Home
						</a>
					</li>
					<li class="separator icon_small_arrow right_gray">
						&nbsp;
					</li>
					<li>
						For Doctors
					</li>
				</ul>
			</div>
			<div class="page_header_right">
				<!--form class="search">
					<input class="search_input hint" type="text" value="To search type and hit enter..." placeholder="To search type and hit enter...">
				</form-->
			</div>
		</div>
		<div class="clearfix page_margin_top">


            <div style="margin-bottom: 30px;padding-bottom: 20px;border-bottom: 1px solid #dadada;">
                <h3 class="sentence " style="">
                    Canbii is an organization serving patients who benefit from the medicinal use of cannabis. Canbii is offered to medical practitioners; helping patients find the best strain for their ailments. Contact us to see how we can help with your everyday practice. We're a non-profit looking to provide the safest and most accurate data possible.
                </h3>

            </div>
		<form method="post" action="" class="contact_form" validate>	
		<div class="columns_3 clearfix">
        <div class="column">
        <h2  class="no-margin"><span class="box_header  page_margin_top slide">Canbii</span></h2><br/>


            <h3 class="sentence animated_element animation-slideLeft50 slideLeft50" style="margin-top:0px;animation-duration: 600ms; -webkit-animation-duration: 600ms; animation-delay: 0ms; -webkit-animation-delay: 0ms; transition-delay: 0ms; -webkit-transition-delay: 0ms;">
                Your Personalized Medical Cannabis Database.
            </h3>

            <span class="sentence_author animated_element animation-slideLeft50 delay-600 slideLeft50" style="animation-duration: 600ms; -webkit-animation-duration: 600ms; animation-delay: 600ms; -webkit-animation-delay: 600ms; transition-delay: 600ms; -webkit-transition-delay: 600ms;">—&nbsp;&nbsp;canbii</span>
            <!--p>Fields marked with <span class="bluecolor">*</span> are required</p-->

        </div>
            <?php
             $username = $this->Session->read('User.username');
             $email = $this->Session->read('User.email');
            ?>

            
              <div class="column">
                <div class="form-group">
                  <label class="text-dark" for="name">Name <span class="bluecolor">*</span></label>
                  <input name="name" type="text" id="name" class="form-control  form-control--contact" required value="<?php echo $username; ?>">
                </div>
                <div class="form-group">
                  <label class="text-dark" for="email">E-mail <span class="bluecolor">*</span></label>
                  <input name="email" type="email" required="required" id="email" class="form-control  form-control--contact" value="<?php echo $email; ?>" >
                </div>
                <div class="form-group">
                  <label class="text-dark" for="subject">Subject <span class="bluecolor">*</span></label>
                  <input name="subject" type="text" id="subject" class="form-control  form-control--contact" required>
                </div>
              </div>
              <div class="column" style="margin-left: 0;">
                <div class="form-group">
                  <label class="text-dark" for="message">Message <span class="bluecolor">*</span></label>
                  <textarea name="message" class="form-control  form-control--contact  form-control--big" id="message" rows="12"style= "height:100%; width:100%;" required></textarea>
                </div>
                <div class="right" style="margin-left: 0; margin-top:10px;">
                  <button type="submit" class="eff3 btn" style=" cursor:pointer;">Send Now</button>
                </div>
              </div>
            
          
        
      </div>
        </form>
		</div>
	</div>
