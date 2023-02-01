<?php include_once 'header.php'; ?>
<div id="content">
    <h1 class="bg-white content-heading border-bottom">Clients</h1>
    <div class="innerAll spacing-x2">
        <!-- Widget -->
        <div class="extraCustomMessage">
            <?php if ($this->session->flashdata('message') != '') { ?>
                <div class="alert alert-<?php echo $this->session->flashdata('message')['classname']; ?>">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?php echo $this->session->flashdata('message')['data']; ?> 
                </div> 
            <?php } ?>
        </div>
        <div class="alert alert-info displaymessage hidden">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <p></p>
        </div>
        
        <v-data-table
      :headers="headers"
      :items="patientLists"
      item-key="name"
      class="elevation-1"
      :search="search"
      :custom-filter="filterOnlyCapsText"
    >
      <template v-slot:top>
        <v-text-field
          v-model="search"
          label="Search Patient"
          class="mx-4 mysearch"
        ></v-text-field>
<!--          <button  type="submit" class="btn btn-success" name="btnsaveuser" @click="setUpdateForm('admin/patients/addNewPatient')">Add Client</button> -->
         
<a data-toggle="modal" @click="loadUserDetails(null)" href="#responsiveUserdetails"                                               
                                               class="btnPatientDetails btn btn-success">
                                                   Add Client
                                            </a> 


      </template>
      <template v-slot:item.fullname="{ item }">
      
                                           
<a data-toggle="modal" @click="loadUserDetails(item)" href="#responsiveUserdetails"                                               
                                               :data-patientid="item.id"                                                           
                                               class="btnPatientDetails">
                                                   {{item.fullname}}
                                            </a> 
      </template>
    


      <template v-slot:item.action="{ item }">
        <tr>
           <a :href="`mailto:${item.email}?Subject=Your%20Video%20Routine%20From%20Perfect%20Forms&body=To%20view%20your%20videos%3A%0A%0A1-%20Download%20our%20Perfect%20Forms%20app%20from%20App%20Store(IOS)%3A%20<?php echo APP_ITUNES_LINK ?>%20or%0A2-%20Download%20our%20Perfect%20Forms%20app%20from%20Google%20Play%20Store(Android)%3A%20<?php echo APP_PLAYSTORE_LINK ?>%20%0A3-%20Log%20into%20<?php echo APP_WEBAPP_LINK ?>%20from%20any%20device%20or%20computer.%0A%0AYour%20username%20and%20password%20are%3A%0AUsername%3A%20${item.email}%0APassword%3A%20${item.password}`" target="_blank">
                                                <i class="fa fa-envelope fa-2x" data-toggle="tooltip" title="Send Mail" style="margin-left: 20px;"></i></a>  
                                            <a
	                                            @click="setActiveUser(item)" class="deleteBtn" :data-patientid="item.id" 
                                               :data-patientname="item.fullname"
                                               data-action="delete" data-toggle="modal" href="#deleteWarning" style="margin-left: 20px;" >
                                                <i class="glyphicon glyphicon-trash fa-2x" data-toggle="tooltip" title="Delete User"></i></a></td>
        </tr>
      </template>
    </v-data-table>
    
              
    <!--Model user details-->
<div id="responsiveUserdetails" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content ">
	            <form  @submit="checkForm" :action="formAction" method="post" accept-charset="utf-8" class="patientForm" novalidate="novalidate" _lpchecked="1">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                    <h3 v-if="activeItem.fullname" class="modal-title">Client Details</h3>
                    <h3 v-else class="modal-title">Add New Client</h3>
					
                </div>
                <div class="modal-body modelform ">
                    <div class="form-body clearfix col-md-12">
                        <div class="row margin-top-10">
                            <div class="form-group col-md-6">
                                <input type="hidden" class="form-control patientid" name="patientid" value="">
                            </div>
                        </div>
                        <div class="col-md-6 userdetail">
                            <div class="row margin-top-10 ">
                                <div class="form-group col-md-3">
                                    <label>First Name</label>
                                </div>
                                <div class="form-group col-md-9">                                            
                                    <input type="text" class="firstname form-control firstname" name="firstname" placeholder="First Name"/>
                                </div>
                            </div>
                            <div class="row margin-top-10">
                                <div class="form-group col-md-3">
                                    <label>Last Name</label>
                                </div>
                                <div class="form-group col-md-9">                                          
                                    <input type="text" class="lastname form-control lastname" name="lastname" placeholder="Last Name"/>
                                </div>
                            </div>
                            <div class="row margin-top-10">
                                <div class="form-group col-md-3">
                                    <label>Email</label>
                                </div>
                                <div class="form-group col-md-9">                                            
                                    <input type="text" class="form-control email" name="email" placeholder="Email"/>
                                </div>
                            </div>
                            <div class="row margin-top-10 hidden">
                                <div class="form-group col-md-3">
                                    <label>Password</label>
                                </div>
                                <div class="form-group col-md-9">                                            
                                    <input type="password" id="patientpassword" class="form-control  password" name="password" placeholder="Password"/>
                                </div>
                            </div>
                            
                            <div class="row margin-top-10 hidden">
                                <div class="form-group col-md-3">
                                    <label>Password</label>
                                </div>
                                <div class="form-group col-md-9">                                            
                                    <input type="password" class="form-control confirmpassword " name="confirmpassword" placeholder="Confirm Password"/>
                                </div>
                            </div>
                            
                            <div class="row margin-top-10">
                                <div class="form-group col-md-3">
                                    <label>Phone</label>
                                </div>
                                <div class="form-group col-md-9">                                            
                                    <input type="text" class="form-control phone" name="phone" placeholder="Phone"/>
                                </div>
                            </div>
                        </div>
                       
                    
                        <div v-if="activeItem.fullname" class="routinelist">
                        <div class="col-md-3">
                            <div class="row margin-top-10">
                                <div class="form-group col-md-12">
                                    <label>Saved General Routines({{generalexercies.length}})</label> 
                                    <input type="text" v-model="generalvideosearch" placeholder="Search Routines" autocomplete="off" maxlength="100" class="form-control">
                                    <select multiple class="form-control" v-model="generalLists" >                                      
<!-- 	                                    id="exgeneral_list_to" -->
<option v-for="(item,index) in generalexercies" :key="index" :value="item" :data-folderid="item.folderid" :title="item.name"
v-show="generalvideosearch == '' || item.name.toLowerCase().indexOf(generalvideosearch.toLowerCase()) > -1"

 >{{item.name}}</option>

                                    </select>

                                </div>
                                 <p v-if="clientLists">Selected[{{generalLists.length}}]</p>

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="row margin-top-10">
                                <div class="form-group col-md-12">
                                    <label>Saved Client Routines({{clientExerc.length}})</label> 
                                    <input type="text" v-model="clientvideosearch" placeholder="Search Routines" autocomplete="off" maxlength="100" class="form-control">
                                    <select multiple class="form-control" v-model="clientLists" id="">                                      
<option v-for="(item,index) in clientExerc" :key="index" :value="item" :data-folderid="item.folderid" :title="item.name"
v-show="clientvideosearch == '' || item.name.toLowerCase().indexOf(clientvideosearch.toLowerCase()) > -1"
 >{{item.name}}</option>
                                    </select>

                                </div>
                                <p v-if="clientLists">Selected[{{clientLists.length}}]</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row margin-top-10">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-success" @click="addSelectedRoutine" data-toggle="tooltip" data-title="Assign selected Exercise"><i class="fa fa-arrow-circle-o-down"></i></button>                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-12">
                                <label>Assigned Routines: ({{assignedexec.length}})</label>
                                <div class="assignes_ex_div">
<label v-for="(item,index) in assignedexec" :key="index" class="label label-info" style=" margin-right:5px">
         <button type="button" style="padding-left:5px;" class="close btnRemoveExc" @click="removeAssinged(item)" :data-id="item.id" :data-folderid="item.folderid" :data-text="item.name" :data-type="item.type">&times;</button>
                            <span style="line-height: 30px;">{{item.name}}</span><input type="hidden" name="exercises[]" class="exercises" :value="item.id"/>
                            
</label>
                            
                                </div>

                            </div>
                        </div>   
                        </div>
                    </div>
                    <div v-if="!activeItem.fullname" class="modal-footer">                    
                        <button  type="submit" class="btn btn-success" name="btnsaveuser" @click="setUpdateForm('/admin/patients/addNewPatient')">Submit</button>
                         <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancel</button>
                    </div>
                    <div v-else >
	                     <a class="pull-right" id="mailto" href="#" target="_top"><i class="fa fa-envelope" data-toggle="tooltip" title="" data-original-title="Send Mail"></i></a>
                   
	                    <div class="modal-footer">                    
	                        <a  type="submit" class="btn btn-success " href="">Create New Routines</a>
	                    </div>
	                    <div class="clearfix"></div>
	                    <div class="modal-footer">                    
	                        <button  type="submit" class="btn btn-success" name="" @click="setUpdateForm('/admin/patients/addNewPatient2')">
	                        Add and create new routine</button>
	                        <button  type="submit" class="btn btn-success" @click="setUpdateForm('/admin/patients/updatePatient')" >Update..</button>                                                            
	                        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancel</button>
	                    </div>
                    
                    </div>
					</form>
                </div>
                <!-- /.modal-content --> 
            </div>                   

        </div>
    </div>
    <!-- /.modal-dialog --> 
    <div id="deleteWarning"  class="modal fade">
        <div class="modal-dialog new-modal-dialog">
            <div class="modal-content">
                <!-- dialog body -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Alert!!</h4>
                </div>
                <div class="modal-body alert-message">
                    <p>Do you really want to remove this user? This will remove all videos, exercise attached to this user.</p>
                    <ul>
	                    <li>{{activeItem.fullname}}</li>
	                    <li>{{activeItem.email}}</li>
	                    <li>{{activeItem.phone}}</li>
                    </ul>
                </div>
                <!-- dialog buttons -->
                <div class="modal-footer"> 
                    <button @click="deleteUser" type="button" class="btn btn-danger" data-action="" data-patientid data-dismiss="modal">Yes</button>
                    <button type="button" class="btn btn-success no" data-dismiss="modal">No</button>
                </div>                  
            </div>
        </div>
    </div>
    
    
    <div id="ExerciseWarning"  class="modal fade">
        <div class="modal-dialog new-modal-dialog">
            <div class="modal-content">
                <!-- dialog body -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Alert!!</h4>
                </div>
                <div class="modal-body alert-message">
                    <p></p>
                </div>
                <!-- dialog buttons -->
                <div class="modal-footer"> 
                    
                    
                    <button type="button" class="btn btn-danger deleteroutine" data-action="" data-patientid>Delete?</button>
                    
                    <a href="#" class="btn btn-success no editroutine" role="button">Edit</a>
                   
                </div>                  
            </div>
        </div>
    </div>
</div>
<?php include_once 'footer.php'; ?>
<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
 

<script type="text/javascript">
/*
import {ServerTable, ClientTable, Event} from 'vue-tables-2';
Vue.use(ClientTable, [options = {}], [useVuex = false], [theme = 'bootstrap3'], [swappables = {}]);
*/
// Vue.use(VueTables.ClientTable);


	var app = new Vue({
		el: '#content',
		 vuetify: new Vuetify(),
		data: {
			mytimer: 'Name',
			patientData: [],
			 search: '',
        calories: '',
        patientLists: [
		          
		  ],
		  base_url: '',
		  clientExerc: [],
		  generalexercies: [],
		  generalLists: [],
		  clientLists: [],
		  assignedexec: [],
		  generalvideosearch: '',
		  clientvideosearch: '',
		  formAction: '/admin/patients/updatePatient',
		  activeItem: {},
		  activeUserId: ''
		},
		computed: {
      headers () {
        return [
          {
            text: 'Name',
            align: 'start',
            sortable: true,
            value: 'fullname',
          },
          {
            text: 'Login Information',
            value: 'email',
            sortable: true,
          },
          { text: 'Phone', value: 'phone' },
          { text: 'Action', value: 'action' },
          
        ]
      },
    },
		created(){
			console.log("Created")
/*
			this.activeUserId = <?PHP echo $userid; ?>
			alert(this.activeUserId)
*/
			this.loadTable()
			this.base_url = '<?php echo base_url(); ?>';
		},
		methods: {
			deleteUser() {
//         var action = $('.modeldeleteyes').attr('data-action');
		var patientid = this.activeItem.id
		var patient_name = this.activeItem.fullname
		var self = this
        $.ajax({
            type: 'POST',
            url: '/admin/patients/deletePatient/' + patientid,
            success: function (deleteAction) {
                var deleteuserdata = JSON.parse(deleteAction);
                var extraMessageHtml = "";
                if (deleteuserdata['status'] == true) {
                    extraMessageHtml = '<div class="alert alert-success">User <strong>' + patient_name + '</strong> deleted successfully<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
                } else {
                    extraMessageHtml = '<div class="alert alert-danger">Error while deleting Client <strong>' + patient_name + '</strong> <button type="button" class="close" data-dismiss="alert">&times;</button></div>';
                }
                $('.extraCustomMessage').html(extraMessageHtml);
				
	var myindex = self.patientLists.map(function(e) { return e.id; }).indexOf(self.activeItem.id);
	
	if (myindex > -1) {
	    self.patientLists.splice(myindex,1)
	}
                return false;
            },
	            error: function (data) {
	                console.log(data);
	            }
	        });

			},
			setActiveUser(item){
				this.activeItem = item	
			},
			checkForm (e) {
//				e.preventDefault()
			},
			setUpdateForm (newpath) {
				this.formAction = newpath
			},
			removeAssinged (item) {
				var self = this
				console.info(item)
				if(item.type == 'general'){
					self.generalexercies.push(item)
					 var myindex = self.assignedexec.indexOf(item);
if (myindex > -1) {
    self.assignedexec.splice(myindex,1)
}

				}
				if(item.type == 'client'){
					self.clientExerc.push(item)
					 var myindex = self.assignedexec.indexOf(item);
if (myindex > -1) {
    self.assignedexec.splice(myindex,1)
}

				}

			},
			addSelectedRoutine () {
				var self = this

				this.assignedexec = [...this.generalLists, ...this.assignedexec];
				this.assignedexec = [...this.clientLists, ...this.assignedexec];
				
				this.generalLists.map(function(item,index) {
				 var myindex = self.generalexercies.indexOf(item);
if (myindex > -1) {
    self.generalexercies.splice(myindex,1)
}

				})
				
				this.clientLists.map(function(item,index) {
				 var myindex = self.clientExerc.indexOf(item);
if (myindex > -1) {
    self.clientExerc.splice(myindex,1)
}

				})
								
			},
			loadUserDetails (item) {
				var self = this
				var patientid = item.id
				this.activeItem = item
$('#responsiveUserdetails').find('.modal-dialog').css('width','70%');        
        $('#responsiveUserdetails').find('.userdetail').removeClass('col-md-12');
        $('#responsiveUserdetails').find('.userdetail').addClass('col-md-6');
        
        $('.btnsaveuser').addClass('hidden');
        $('.btnsaveclientuser').addClass('hidden');
        $('.btnupdateuser').removeClass('hidden');
        $('.btnupdateclientuser').removeClass('hidden');
       
        $('.btnupdateclientuser').attr('href',self.base_url + 'admin/exercises/addclientexercise/' + patientid)
        //reset assigned exercise
        $('.assignes_ex_div').html("");
       // $('#ex_list_to').find('option').remove();
        
        if(item){
	        $.ajax({
	            type: 'POST',
	            url: '/admin/patients/getPatientDetails/' + patientid,
	            success: function (actionResponse) {
	                var patientData = JSON.parse(actionResponse);
	                $('.patientid').val(patientid);
	                $('.firstname').val(patientData['data']['firstname']);
	                $('.lastname').val(patientData['data']['lastname']);
	                $('.email').val(patientData['data']['email']);
	                $('.phone').val(patientData['data']['phone']);
	                $('.password').val(patientData['data']['password']);
	                $('.confirmpassword').val(patientData['data']['password']);
	                $('#mailto').attr('href','mailto:'+patientData['data']['email']+'?'+encodeURI('Subject=Your Video Routine From Perfect Forms')+'&body='+'To%20view%20your%20videos%3A%0D%0A%0D%0A1-%20Download%20our%20Perfect%20Forms%20app%20from%20App%20Store(IOS)%3A%20'+encodeURI('<?php echo APP_ITUNES_LINK ?>')+'%0A2-%20Download%20our%20Perfect%20Forms%20app%20from%20Google%20Play%20Store(Android)%3A%20' + encodeURI('<?PHP echo APP_PLAYSTORE_LINK ?>')+'%20-%20or%20%0D%0A3-%20Log%20into%20'+encodeURI('<?php echo APP_WEBAPP_LINK ?>')+'%20from%20any%20device%20or%20computer.%0D%0A%0D%0AYour%20username%20and%20password%20are%3A%0D%0AUsername%3A%20'+patientData['data']['email']+'%0D%0APassword%3A%20'+patientData['data']['password']);
	                $('#exclient_list_to').html('')
	                $('.routinelist').removeClass('hidden');
	                //append exercies and remove from list
	                self.clientExerc = patientData['data']['clientexercies'];
	                self.generalexercies = patientData['data']['generalexercies'];
	                
	                 self.assignedexec = patientData['data']['assingedexercies'];                
	                
	            },
	            error: function (data) {
	                console.log(data);
	            }
	            
	        });
	        }else{
		        //Add New User
	        }
				//END loadUserDetails 
				},
				 filterOnlyCapsText (value, search, item) {
	        return value != null &&
	          search != null &&
	          typeof value === 'string' &&
	          value.toString().toLocaleUpperCase().indexOf(search.toLocaleUpperCase()) !== -1
	      },
				loadTable() {
					var self = this
						let form_data = new FormData;
					form_data.append('therapist_id', 1);
					axios.post("/admin/patients/getTherapistClients", form_data).then(function(response){
							self.patientLists = response.data.result
					})
				}
			}
		
	})
</script>

<script>
    var base_url = '<?php echo base_url(); ?>';
  var clientexercies=[];
//  var generalexercies=[];
//  $('#exgeneral_list_to').html('')   

/*
 <?php foreach($generalexercies as $exdata)
 { ?>
     var id = <?php echo $exdata['id']; ?>;
     var text = "<?php echo $exdata['name']; ?>";
     var folderid = "<?php echo $exdata['folderid']; ?>";
     generalexercies.push({'id':id, 'name': text,'folderid':folderid});
   $('#exgeneral_list_to').append("<option value='" + id + "' title='" + text + "' data-folderid=" + folderid + "'>" + text +"</option>");
 <?php } ?>
*/
         

$(document).on('click', '.btnsaveclientuser', function () {
$(this).val('save');
$('.patientForm').attr('action',$(this).attr('formaction'))
});
/*
$(document).on('click', '.btnsaveuser', function (e) {
$(this).val('save');
//return false;
})
*/

$(document).on('click', '.btnupdateuser', function (e) {
$('.btnsaveclientuser').val('save');
$('.patientForm').attr('action',$(this).attr('formaction'))
//return false;
})

    $('#responsiveUserdetails').on('hidden.bs.modal', function () {
        $('.has-error').children('p').remove('p');
        $('.has-error').removeClass('has-error');
    });
   
  $(document).on('click', '.deleteroutine', function () {
      
    $this=$(this);
    var objectid = $this.attr('data-exerciseid');
    var folderid = $this.attr('data-folderid');
    var optionText = $this.attr('data-text');
     $.ajax({
            type: 'POST',
            url: base_url + 'admin/patients/deleteassignedExrecise/' + objectid,
            data:{'clientid':folderid},
            success: function (deleteAction) {
                $('.btnRemoveExc').each(function () {
                if($(this).attr('data-id')==objectid)
                    $(this).parent('.label').remove()
              });
              
             
             if($this.attr('data-type')=='client')
             {
                 $('#exclient_list_to').append('<option value="'+objectid+'" data-folderid="'+folderid+'" title="' + optionText + '" >'+optionText+'</option>');
             }else{$('#exgeneral_list_to').append('<option value="'+objectid+'" data-folderid="'+folderid+'"  title="' + optionText + '" >'+optionText+'</option>');}
           
              $('#ExerciseWarning').modal('hide');
            },
            error: function (data) {
                console.log(data);
            }
        });

    }); 
    
    
$('#myModal').on('hidden.bs.modal', function (e) {
  // do something...
})


<?php
  if($userid!='')
  { ?>
    $userid='#<?php echo "patient-".$userid ?>';
    $($userid).find('.btnPatientDetails').trigger('click');
  <?php
    }
  ?> 

</script>
<style type="text/css" scoped>

	
    .modal-dialog{
        overflow-y: initial !important
    }
    .imagestyle{
        width: 100px; 
        height: 100px; 
        margin-right: 20px;
    }
    .ml10{
        margin-left: 10px;
    }
    #mailto {
    font-size: 250%;
    }

</style>