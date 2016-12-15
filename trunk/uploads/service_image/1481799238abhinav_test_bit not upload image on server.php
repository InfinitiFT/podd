
    <!-- BEGIN BODY -->
    <body class=" ">
            <!-- START TOPBAR -->
        <div class='page-topbar '>
            <div class='logo-area'>

            </div>
            <div class='quick-area'>
                <div class='pull-left'>
                    <ul class="info-menu left-links list-inline list-unstyled">
                        <li class="sidebar-toggle-wrap">
                            <a href="#" data-toggle="sidebar" class="sidebar_toggle">
                                <i class="fa fa-bars"></i>
                            </a>
                        </li>
                     </ul>
                </div>      
               <div class='pull-right'>
                    <ul class="info-menu right-links list-inline list-unstyled">
                        <li class="profile">
                            <a href="#" data-toggle="dropdown" class="toggle">
                                <span>Welcome</span>
                                <span><?php echo $this->session->userdata('ausername');?> <i class="fa fa-angle-down"></i></span>
                            </a>
                            <ul class="dropdown-menu profile animated fadeIn">
                                <li>
                                    <a href="<?php echo base_url()?>admin/change_password">
                                        <i class="fa fa-info"></i>
                                        Change Password
                                    </a>
                                </li>
                                <li class="last">
                                    <a href="<?php echo base_url()?>admin/logout">
                                        <i class="fa fa-lock"></i>
                                        Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                        
                    </ul>           
                </div>      
            </div>

        </div>
        <!-- END TOPBAR -->
        <!-- START CONTAINER -->
        <div class="page-container row-fluid">            
            <!-- START CONTENT -->
            <section id="main-content" class=" ">
                <section class="wrapper" style='margin-top:60px;display:inline-block;width:100%;padding:15px 0 0 15px;'>

                    <div class="col-lg-12">
                        <section class="box ">



<!-- <?php if($this->session->flashdata('flashSuccess')) { ?>
<div class='alert alert-success'> <?php echo $this->session->flashdata('flashSuccess');?> 
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> </div>
<?php } ?>

<?php if($this->session->flashdata('flashError')) { ?>
<div class='alert alert-danger' > <?php echo $this->session->flashdata('flashError'); ?> 

<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> </div> </div>
<?php } ?> -->


    <header class="panel_header">
    <h2 class="title pull-left">Add General Store</h2>
    </header>
    <div class="content-body">
    <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <?php
    $attributes = array('class' => 'add_general', 'id' =>'add_general');
      echo form_open_multipart('Neighborhood_Services/save_general_store/'.$categoryId.'/'.$parentId, $attributes);?> 
    


<div class="row form-group">
     <label class="col-sm-4 col-md-4 col-lg-3 ">Business Name <span class="error ">*</span></label>
        <div class="col-sm-8 col-md-7 col-lg-6" >
          <input type="text" name = "business_name" class = "form-control" value="" placeholder = "Enter Business Name">
             <span class = "error"></span>
        </div>
       <div class="clearfix"></div>
   </div>


<div class="row form-group">
        <label  for = "teaching_medium" class="col-sm-4 col-md-4 col-lg-3 ">Year of Establishment <span class="error ">*</span></label>
            <div class="col-sm-8 col-md-7 col-lg-6" >
                <input type="text" name = "year_of_establishment" class = "form-control" value="" placeholder = "Enter Year of Establishment">
                    <span class = "text-danger"></span>
            </div>
        <div class="clearfix"></div>
    </div>


     <div class="row form-group">
        <label  for = "teaching_medium" class="col-sm-4 col-md-4 col-lg-3 ">About the Business <span class="error ">*</span></label>
            <div class="col-sm-8 col-md-7 col-lg-6" >
              
                <textarea class="form-control" cols="6" rows="8" name = "about_the_business"  style="height: 60px;" placeholder = "Enter About the business"></textarea> 
                    <span class = "text-danger"></span>
                </div>
            <div class="clearfix"></div>
        </div>


              <div class="row form-group">
        <label  for = "teaching_medium" class="col-sm-4 col-md-4 col-lg-3 ">Address<span class="error ">*</span></label>
            <div class="col-sm-8 col-md-7 col-lg-6" >
                <input type="text" name = "address" id = "address" class = "form-control" value="" placeholder = "Enter Address">
                    <span class = "text-danger"></span>
                </div>
            <div class="clearfix"></div>
        </div>


    <div class="row form-group">
        <label for = "students" class="col-sm-4 col-md-4 col-lg-3 ">Sector/Pocket/Phase Number</label>
            <div class="col-sm-8 col-md-7 col-lg-6" >
               <input type = "text" name = "sector_pocket_phase_number" id = "sector" class = "form-control" value="" placeholder = "Enter Sector/Pocket/Phase Number">    
                  <span class = "text-danger"></span>
            </div>
        <div class="clearfix"></div>
    </div>


      <div class="row form-group">
        <label for = "teachers" class="col-sm-4 col-md-4 col-lg-3 ">City<span class="error ">*</span></label>
            <div class="col-sm-8 col-md-7 col-lg-6" >
                 <input type = "text" name = "city" id = "city" class = "form-control" value="" placeholder = "Please Enter City"  >         
                    <span class = "text-danger"></span>
            </div>
       
    </div>
    
    
    <div class="row form-group">
        
        <label for = "teachers" class="col-sm-4 col-md-4 col-lg-3 ">Pincode<span class="error ">*</span></label>
        <div class="col-sm-8 col-md-7 col-lg-6" >
                <input type = "text" name = "pincode" class = "form-control" value="" placeholder = "Enter Pincode">         
                    <span class = "text-danger"></span>
            </div>
    </div>




    <div class="row form-group">
        <label for = "sections" class="col-sm-4 col-md-4 col-lg-3 ">Landmark</label>
            <div class="col-sm-8 col-md-7 col-lg-6" >
                <input type = "text" name = "landmark" class = "form-control" value="" placeholder = "Enter Landmark" >          
                    <span class = "text-danger"></span>
                </div>
            <div class="clearfix"></div>
        </div>
        
    <div class="row form-group">
             <label class="col-sm-4 col-md-4 col-lg-3 ">Contact Number(s)<span class="error">*</span></label>
                <div class="col-sm-8 col-md-7 col-lg-6 add_number">
                     <div class="form-group">
                         <input id="contact_numbers" type="text" name = "contact_number[]" class = "form-control" placeholder="Enter contact number">
                     </div>
                </div>
                    <div class="col-md-1 col-sm-1 col-xs-1" >
                         <button type="button" id="add-contact-number" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add other</a>
                </div>
             <div class="clearfix"></div>
         </div>


    <div class="row form-group">
        <label for = "classrooms" class="col-sm-4 col-md-4 col-lg-3 ">Website</label>
            <div class="col-sm-8 col-md-7 col-lg-6 " >
                <input type = "text" name = "website" class = "form-control" value="" placeholder = "Enter Website Url" >       
                    <span class = "text-danger"></span>
                </div>
            <div class="clearfix"></div>
    </div>


    <div class="row form-group">
        <label for = "subjects_offered" class="col-sm-4 col-md-4 col-lg-3 ">Email</label>
            <div class="col-sm-8 col-md-7 col-lg-6 " >
                <input type = "email" name = "email" class = "form-control" value="" placeholder = "Enter Email">        
                    <span class = "text-danger"></span>
                </div>
            <div class="clearfix"></div>
        </div>



   <div class="row form-group">
        <label for = "transport" class="col-sm-4 col-md-4 col-lg-3 ">Facebook</label>
            <div class="col-sm-8 col-md-7 col-lg-6 " >
                <input type = "text" name = "facebook" class = "form-control" value="" placeholder = "Enter Facebook Url">          
                    <span class = "text-danger"></span>
            </div>
        <div class="clearfix"></div>
    </div>
                                        
        

  <div class="row form-group">
     <label for="status" class="col-sm-4 col-md-4 col-lg-3 " >Twitter</label>
        <div class="col-sm-8 col-md-7 col-lg-6 " >
            <input type = "text" name = "twitter" class = "form-control" value="" placeholder = "Enter Twitter Url" >          
                <span class = "text-danger"></span>
            </div>
        <div class="clearfix"></div>
     </div>
                

    <div class="row form-group">
        <label for = "sports_facilities" class="col-sm-4 col-md-4 col-lg-3 ">Pinterest</label>
            <div class="col-sm-8 col-md-7 col-lg-6 " >
                <input type = "text" name = "pinterest" class = "form-control" value="" placeholder = "Enter Pinterest Url" >         
                    <span class = "text-danger"></span>
            </div>
        <div class="clearfix"></div>
    </div>

    <div class="row form-group">
        <label for = "other_facilities" class="col-sm-4 col-md-4 col-lg-3 ">LinkedIn</label>
            <div class="col-sm-8 col-md-7 col-lg-6 " >
                <input type = "text" name = "linkedIn" class = "form-control" value="" placeholder = "Enter Linkedin Url">       
                    <span class = "text-danger"></span>
                </div>
            <div class="clearfix"></div>
        </div>


    <div class="row form-group">
        <label for = "yearly_activities" class="col-sm-4 col-md-4 col-lg-3 ">Instagram</label>
            <div class="col-sm-8 col-md-7 col-lg-6 " >
                <input type = "text" name = "instagram" class = "form-control" value="" placeholder = "Enter Instagram Url" >         
                    <span class = "text-danger"></span>
                </div>
            <div class="clearfix"></div>
        </div>


    <div class="row form-group">
        <label for = "achievements_awards" class="col-sm-4 col-md-4 col-lg-3 ">Google+</label>
            <div class="col-sm-8 col-md-7 col-lg-6 " >
                <input type = "text" name = "google_plus" class = "form-control" value="" placeholder = "Enter Google+ Url">        
                    <span class = "text-danger"></span>
                </div>
            <div class="clearfix"></div>
        </div>


    <div class="row form-group">
        <label for = "famous_alumnus" class="col-sm-4 col-md-4 col-lg-3 ">Blogspot</label>
            <div class="col-sm-8 col-md-7 col-lg-6 " >
                <input type = "text" name = "blogspot" class = "form-control" value="" placeholder = "Enter Blogspot Url" >         
                    <span class = "text-danger"></span>
                </div>
            <div class="clearfix"></div>
        </div>

<div class="row form-group">
        <label for = "famous_alumnus" class="col-sm-4 col-md-4 col-lg-3 ">Owner's Name</label>
            <div class="col-sm-8 col-md-7 col-lg-6 " >
                <input type = "text" name = "owner_name" class = "form-control" value="" placeholder = "Enter Owner Name">         
                    <span class = "text-danger"></span>
                </div>
            <div class="clearfix"></div>
        </div>

    <div class="row form-group">
         <label for = "sections" class="col-sm-4 col-md-4 col-lg-3 ">Owner Mobile Number</label>
            <div class="col-sm-8 col-md-7 col-lg-6 " >
                <input type = "text" name = "owner_number" class = "form-control" value="" placeholder = "Enter Owner Mobile No." >          
                     <span class = "text-danger"></span>
            </div>
         <div class="clearfix"></div>
    </div>


    <div class="row form-group">
        <label for = "famous_alumnus" class="col-sm-4 col-md-4 col-lg-3 ">Manager's Name</label>
            <div class="col-sm-8 col-md-7 col-lg-6 " >
                <input type = "text" name = "manager_name" class = "form-control" value="" placeholder = "Enter Manager Name">         
                    <span class = "text-danger"></span>
                </div>
            <div class="clearfix"></div>
        </div>


    <div class="row form-group">
         <label for = "sections" class="col-sm-4 col-md-4 col-lg-3 ">Manager Mobile Number</label>
            <div class="col-sm-8 col-md-7 col-lg-6 " >
                <input type = "text" name = "manager_number" class = "form-control" value="" placeholder = "Enter Manager Mobile No.">          
                     <span class = "text-danger"></span>
            </div>
         <div class="clearfix"></div>
    </div>




       <div class="row form-group">
        <label class="col-md-3 col-sm-2 col-xs-3 control-label">Type of Sold Product</label>
        <div class="col-sm-8 col-md-7 col-lg-6 control-label general_store_product_sold">
            <select data-placeholder="Choose Sold Product" class="form-group" id="s2example-2" name="sold_product[]" multiple>
                    <option></option>
                    <?php
                        foreach ($sold_products as $product){
                            echo '<option value="' . $product->sold_product_name . '">'.$product->sold_product_name.'</option>';
                        }
                    ?>

            </select>
         </div>
         <div class="col-sm-2" >
                    <button class="add_general_store_sold_product btn btn-primary"><i class="fa fa-plus-circle"></i> Add Other</button>
                </div>
              <div class = "">
            </div>
            </div>
          


    <div class="row form-group">
        <label for = "famous_alumnus" class="col-sm-3 control-label">Min Order Value Free Home Delivery<span class="error ">*</span> </label>
        <div class="col-sm-8 col-md-7 col-lg-6" >
            <input type = "text" name = "min_order" class = "form-control" value="" placeholder = "Enter min order value for free home delivery">         
                 <span class = "text-danger"></span>
            </div>
           
    </div>


    <div class="row form-group">

         <label for = "famous_alumnus" class="col-sm-3 control-label">Discount Details<span class="error ">*</span></label>
        <div class="col-sm-8 col-md-7 col-lg-6" >
           <textarea class="form-control" cols="6" rows="8" name = "discount_details"  style="width: 400px; height: 90px;" placeholder = "Enter Discount Details"></textarea>         
            </div>
        <div class="clearfix"></div>
    </div>


    <div class="row form-group">
        <label class="col-md-3 col-sm-2 col-xs-3 control-label">Other Items and Services Available</label>
        <div class="col-sm-8 col-md-7 col-lg-6 other_neighbourhood_general_store_services">
            <select data-placeholder="Enter others items and service available" class="general_store_select form-group" id="" name="other_items[]" multiple>
                    <option></option>
                    <?php
                        foreach ($other_services as $services){
                            echo '<option value="' . $services->service_name . '">'.$services->service_name.'</option>';
                        }
                    ?>

            </select>
         </div>
         <div class="col-sm-2" >
                    <button class="add_other_general_store_neighbourhood_services btn btn-primary"><i class="fa fa-plus-circle"></i> Add Other</button>
                </div>
              
            </div>

<div class="row form-group">
             <label class="col-md-3 col-sm-3 col-xs-3 control-label">Tags</label>
                <div class="col-sm-8 col-md-7 col-lg-6 tagss">
                     <div class="form-group">
                         <input id="contact_numbers" type="text" name = "tags[]" class = "form-control" placeholder="Enter tags">
                     </div>
                </div>
                    <div class="col-md-1 col-sm-1 col-xs-1" >
                         <button type="button" id="" class="btn btn-primary add_tagss"><i class="fa fa-plus-circle"></i> Add other</a>
                </div>
             <div class="clearfix"></div>
         </div>



<div class="form-group ">
        <label>Opening Hours<span class="error ">*</span></label>
      </div>

         <div class="form-group row">
           <label for = "monday-time" class="col-sm-4 col-md-4 col-lg-3 ">Monday</label>
           <div class="col-sm-4 col-md-5 col-lg-4">
              <div class="row">
                 <label class="col-sm-6 col-md-5 col-lg-5 form-label">Open From</label>
                 <div class="col-sm-6 col-md-7 col-lg-7">
                    <input type="text" name="from_monday" id = "from_monday" class="form-control timepicker" data-minute-step="5" data-show-meridian="true" data-default-time="00:00 AM" data-template="dropdown" value=""> 
                    <span class="text-danger"></span>
                 </div>
              </div>
           </div>
           <div class="col-sm-4 col-md-5 col-lg-4" >
              <div class="row">
                 <label for = "famous_alumnus" class="col-sm-6 col-md-5 col-lg-5 form-label">Open To</label>
                 <div class="col-sm-6 col-md-7 col-lg-7" >
                    <input type = "text" name = "to_monday" id = "to_monday" class = "form-control timepicker" data-minute-step="5" data-show-meridian="true" data-default-time="00:00 AM" data-template="dropdown"  value="">          
                    <span class = "text-danger"></span>
                 </div>
              </div>
           </div>
           <div class="clearfix"></div>
        </div>

          <div class="form-group row">
           <label for = "famous_alumnus" class="col-sm-4 col-md-4 col-lg-3 ">Tuesday</label>
           <div class="col-sm-4 col-md-5 col-lg-4">
              <div class="row">
                 <label for="famous_alumnus" class="col-sm-6 col-md-5 col-lg-5 form-label">Open From</label>
                 <div class="col-sm-6 col-md-7 col-lg-7">
                    <input type="text" name="from_tuesday" class="form-control timepicker" id="from_tuesday" data-minute-step="5" data-show-meridian="true" data-default-time="00:00 AM" data-template="dropdown" value=""> 
                    <span class="text-danger"></span>
                 </div>
              </div>
           </div>
           <div class="col-sm-4 col-md-5 col-lg-4" >
              <div class="row">
                 <label for = "famous_alumnus" class="col-sm-6 col-md-5 col-sm-5 form-label">Open To</label>
                 <div class="col-sm-6 col-md-7 col-lg-7" >
                    <input type = "text" name = "to_tuesday" class = "form-control timepicker" data-minute-step="5" id="to_tuesday" data-show-meridian="true" data-default-time="00:00 AM" data-template="dropdown"  value="">          
                    <span class = "text-danger"></span>
                 </div>
              </div>
           </div>
           <div class="clearfix"></div>
        </div>

         <div class="form-group row">
           <label for = "famous_alumnus" class="col-sm-4 col-md-4 col-lg-3 ">Wednesday</label>
           <div class="col-sm-4 col-md-5 col-lg-4">
              <div class="row">
                 <label for="famous_alumnus" class="col-sm-6 col-md-5 col-lg-5 form-label">Open From</label>
                 <div class="col-sm-6 col-md-7 col-lg-7">
                    <input type="text" name="from_wednesday" class="form-control timepicker" data-minute-step="5" id="from_wednesday" data-show-meridian="true" data-default-time="00:00 AM" data-template="dropdown" value=""> 
                    <span class="text-danger"></span>
                 </div>
              </div>
           </div>
           <div class="col-sm-4 col-md-5 col-lg-4" >
              <div class="row">
                 <label for = "famous_alumnus" class="col-sm-6 col-md-5 col-lg-5 form-label">Open To</label>
                 <div class="col-sm-6 col-md-7 col-lg-7" >
                    <input type = "text" name = "to_wednesday" class = "form-control timepicker" data-minute-step="5" id="to_wednesday" data-show-meridian="true" data-default-time="00:00 AM" data-template="dropdown"  value="">          
                    <span class = "text-danger"></span>
                 </div>
              </div>
           </div>
           <div class="clearfix"></div>
        </div>

      <div class="form-group row">
       <label for = "famous_alumnus" class="col-sm-4 col-md-4 col-lg-3 ">Thrusday</label>
       <div class="col-sm-4 col-md-5 col-lg-4">
          <div class="row">
             <label for="famous_alumnus" class="col-sm-6 col-md-5 col-lg-5 form-label">Open From</label>
             <div class="col-sm-6 col-md-7 col-lg-7">
                <input type="text" name="from_thursday" class="form-control timepicker" data-minute-step="5" data-show-meridian="true" id="from_thursday" data-default-time="00:00 AM" data-template="dropdown" value=""> 
                <span class="text-danger"></span>
             </div>
          </div>
       </div>
       <div class="col-sm-4 col-md-5 col-lg-4" >
          <div class="row">
             <label for = "famous_alumnus" class="col-sm-6 col-md-5 col-lg-5 form-label">Open To</label>
             <div class="col-sm-6 col-md-7 col-lg-7" >
                <input type = "text" name = "to_thursday" class = "form-control timepicker" data-minute-step="5" id="to_thursday" data-show-meridian="true" data-default-time="00:00 AM" data-template="dropdown"  value="">          
                <span class = "text-danger"></span>
             </div>
          </div>
       </div>
       <div class="clearfix"></div>
    </div>

     <div class="form-group row">
       <label for = "famous_alumnus" class="col-sm-4 col-md-4 col-lg-3 ">Friday</label>
       <div class="col-sm-4 col-md-5 col-lg-4">
          <div class="row">
             <label for="famous_alumnus" class="col-sm-6 col-md-5 col-lg-5 form-label">Open From</label>
             <div class="col-sm-6 col-md-7 col-lg-7">
                <input type="text" name="from_friday" class="form-control timepicker" data-minute-step="5" data-show-meridian="true" data-default-time="00:00 AM" id="from_friday" data-template="dropdown" value=""> 
                <span class="text-danger"></span>
             </div>
          </div>
       </div>
       <div class="col-sm-4 col-md-5 col-lg-4" >
          <div class="row">
             <label for = "famous_alumnus" class="col-sm-6 col-md-5 col-lg-5 form-label">Open To</label>
             <div class="col-sm-6 col-md-7 col-lg-7" >
                <input type = "text" name = "to_friday" class = "form-control timepicker" data-minute-step="5" data-show-meridian="true" id="to_friday" data-default-time="00:00 AM" data-template="dropdown"  value="">          
                <span class = "text-danger"></span>
             </div>
          </div>
       </div>
       <div class="clearfix"></div>
    </div>

        <div class="form-group row">
           <label for = "famous_alumnus" class="col-sm-4 col-md-4 col-lg-3 ">Saturday</label>
           <div class="col-sm-4 col-md-5 col-lg-4">
              <div class="row">
                 <label for="famous_alumnus" class="col-sm-6 col-md-5 col-lg-5 form-label">Open From</label>
                 <div class="col-sm-6 col-md-7 col-lg-7">
                    <input type="text" name="from_saturday" class="form-control timepicker" data-minute-step="5" data-show-meridian="true" data-default-time="00:00 AM" data-template="dropdown" id="from_saturday" value=""> 
                    <span class="text-danger"></span>
                 </div>
              </div>
           </div>
           <div class="col-sm-4 col-md-5 col-lg-4" >
              <div class="row">
                 <label for = "famous_alumnus" class="col-sm-6 col-md-5 col-lg-5 form-label">Open To</label>
                 <div class="col-sm-6 col-md-7 col-lg-7" >
                    <input type = "text" name = "to_saturday" class = "form-control timepicker" data-minute-step="5" data-show-meridian="true" data-default-time="00:00 AM" data-template="dropdown"  value="" id="to_saturday">          
                    <span class = "text-danger"></span>
                 </div>
              </div>
           </div>
           <div class="clearfix"></div>
        </div>

    <div class="form-group row">
       <label for = "famous_alumnus" class="col-sm-4 col-md-4 col-lg-3 ">Sunday</label>
       <div class="col-sm-4 col-md-5 col-lg-4">
          <div class="row">
             <label for="famous_alumnus" class="col-sm-6 col-md-5 col-lg-5 form-label">Open From</label>
             <div class="col-sm-6 col-md-7 col-lg-7">
                <input type="text" name="from_sunday" class="form-control timepicker" data-minute-step="5" data-show-meridian="true" data-default-time="00:00 AM" data-template="dropdown" value="" id= "from_sunday"> 
                <span class="text-danger"></span>
             </div>
          </div>
       </div>
       <div class="col-sm-4 col-md-5 col-lg-4" >
          <div class="row">
             <label for = "famous_alumnus" class="col-sm-6 col-md-5 col-lg-5 form-label">Open To</label>
             <div class="col-sm-6 col-md-7 col-lg-7" >
                <input type = "text" name = "to_sunday" class = "form-control timepicker" data-minute-step="5" data-show-meridian="true" data-default-time="00:00 AM" data-template="dropdown"  value="" id= "to_sunday">          
                <span class = "text-danger"></span>
             </div>
          </div>
       </div>
       <div class="clearfix"></div>
    </div>



    <div class="row form-group custom-error-block">
       <label for = "famous_alumnus" class="col-sm-4 col-md-4 col-lg-3 ">Parking Availability<span class="error ">*</span></label>
       <div class="col-sm-8 col-md-8 col-lg-9" >
          <label class="iradio-label form-label"><input type="radio" name="status" value="1" >Unavailable</label>&nbsp;
          <label class="iradio-label form-label"><input type="radio" name="status" value="2" >Low</label>&nbsp;
          <label class="iradio-label form-label"><input type="radio" name="status" value="3" >Medium</label>&nbsp;
          <label class="iradio-label form-label"><input type="radio" name="status" value="4" >High</label>&nbsp;
       </div>
       <div class="clearfix"></div>
    </div>


    <div class="row form-group custom-error-block">
        <label for = "famous_alumnus" class="col-sm-4 col-md-4 col-lg-3 ">Payment Modes<span class="error">*</span></label>
         <div class="col-sm-8 col-md-8 col-lg-9 payment-modes">     
            <label class="checkbox-inline"><input type="checkbox" name="pay[]" value="Credit Card" >Credit Card</label>
            <label class="checkbox-inline"><input type="checkbox" name="pay[]" value="Debit Card" >Debit Card</label>
            <label class="checkbox-inline"><input type="checkbox" name="pay[]" value="Cash" >Cash</label>
            <label class="checkbox-inline"><input type="checkbox" name="pay[]" value="Cheque" >Cheque</label>
            <label class="checkbox-inline"><input type="checkbox" name="pay[]" value="eWallets">eWallets</label>
            <label class="checkbox-inline"><input type="checkbox" name="pay[]" value="Online Bank Transfer" >Online Bank Transfer</label>
            <label class="checkbox-inline"><input type="checkbox" name="pay[]" value="Demand Draft" >Demand Draft</label>
            <label for="pay" class="error" style="display:none;">* Please pick an option above</label>
         </div>
        <div class="col-sm-4" ><span class = "text-danger"></span> </div>
        <div class="clearfix"></div>
    </div>

    <div class="row form-group">
        <label for = "famous_alumnus" class="col-sm-4 col-md-4 col-lg-3 ">Additional Information</label>
        <div class="col-sm-8 col-md-7 col-lg-6" >
            <textarea class="form-control" cols="4" rows="3" name = "additional_information"  style="width: 400px; height: 90px;" placeholder = "Enter Addtional Information"></textarea>         
                <span class = "text-danger"></span>
       </div>
      <div class="clearfix"></div>
    </div>

    <div class="row form-group">
        <label for = "famous_alumnus" class="col-sm-4 col-md-4 col-lg-3">Business Images</label>
        <div class="col-sm-6 col-md-7 col-lg-7" >
            <input  type="file" name ="businessImages[]" id="businessImages"  multiple >

            <div id="preview-image">
             
            </div>
        </div>
        <div class="clearfix"></div>
    </div>

<div class="field" align="left">
  <h3>Upload your images</h3>
  <input type="file" id="files" name="files[]" multiple />
</div>


           <div class="form-group">
                <button type="submit"  class="btn btn-success" name="submit">Save</button>
                    <div class="clearfix"></div>
            </div>
        <?php echo form_close();?>


                                </div>
                              </div>
                            </div>
                        </section>
                       </div>

            </section>
            <!-- END CONTENT -->
            
          </div>

    <script>
       
    </script>


   

    <style>
input[type="file"] {
  display: block;
}
.imageThumb {
  max-height: 75px;
  border: 2px solid;
  padding: 1px;
  cursor: pointer;
}
.pip {
  display: inline-block;
  margin: 10px 10px 0 0;
}
.remove {
  display: block;
  background: #444;
  border: 1px solid black;
  color: white;
  text-align: center;
  cursor: pointer;
}
.remove:hover {
  background: white;
  color: black;
}
</style>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>


<script>

 $(document).ready(function() {
  if (window.File && window.FileList && window.FileReader) {
    $("#files").on("change", function(e) {
      var files = e.target.files,
        filesLength = files.length;
      for (var i = 0; i < filesLength; i++) {
        var f = files[i]
        var fileReader = new FileReader();
        fileReader.onload = (function(e) {
          var file = e.target;
          $("<span class=\"pip\">" +
            "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
            "<br/><span class=\"remove\">Remove image</span>" +
            "</span>").insertAfter("#files");
          $(".remove").click(function(){
            $(this).parent(".pip").remove();
          });
          
          // Old code here
          /*$("<img></img>", {
            class: "imageThumb",
            src: e.target.result,
            title: file.name + " | Click to remove"
          }).insertAfter("#files").click(function(){$(this).remove();});*/
          
        });
        fileReader.readAsDataURL(f);
      }
    });
  } else {
    alert("Your browser doesn't support to File API")
  }
});
 </script>