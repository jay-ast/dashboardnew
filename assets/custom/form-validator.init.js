$.validator.setDefaults(
        {
            showErrors: function (map, list)
            {
                this.currentElements.parents('label:first, div:first').find('.has-error').remove();
                this.currentElements.parents('.form-group:first').removeClass('has-error');

                $.each(list, function (index, error)
                {
                    var ee = $(error.element);
                    var eep = ee.parents('label:first').length ? ee.parents('label:first') : ee.parents('div:first');

                    ee.parents('.form-group:first').addClass('has-error');
                    eep.find('.has-error').remove();
                    eep.append('<p class="has-error help-block">' + error.message + '</p>');
                });
                //refreshScrollers();
            }
        });

$(function ()
{
    $(".login-panel").validate({
        rules: {
            email: "required",
            password: {
                required: true,
                minlength: 5
            }
        },
        messages: {
            email: "Please enter a valid Email",
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long"
            }
        }
    });


    $('.patientForm').validate({
        rules: {
            firstname: "required",
            email: {
                required: true,
                email: true
            },
        }, messages: {
            firstname: "First Name should not be blank",
            phone: "Phone number should not be blank",
            email: {
                required: "Email should not be blank",
                email: "Email is not valid."
            },
            password: {
                required: "Password should not blank",
                minlength: "Password must be 6 characters long"
            }
        },
        submitHandler: function(form) {
               if($('.btnsaveclientuser').val()=='')
               {
                  $url= $('.btnsaveuser').attr('formaction');
                    $values=$('.patientForm').serialize();


            $.ajax({
                    url: $url,
                    type: "post",
                    data: $values,
                    dataType  : 'json',
                    success: function (response) {         
                        if(response.success == true)
                        {                            
                            $('#responsiveUserdetails').find('.modal-dialog').css('width','70%');
                            $('#responsiveUserdetails').find('.userdetail').removeClass('col-md-12');
                            $('#responsiveUserdetails').find('.userdetail').addClass('col-md-6');
                            $('.routinelist').removeClass('hidden');
                            $('.patientid').val(response.patient_id);
                            $('.btnsaveuser').addClass('hidden');
                            $('.btnupdateclientuser').removeClass('hidden');
                            $('.btnsaveclientuser').addClass('hidden');
                            $('.btnupdateuser').removeClass('hidden');
                            $('.btnupdateclientuser').attr('href',base_url + 'admin/exercises/addclientexercise/' + response.patient_id)
                            alert("Successfully Added Client.")
                        }else{
	                        $("#"+response.issue).addClass("error")
                            alert(response.message)
                        }
                       // you will get response from your php page (what you echo or print)                 

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
					
                    }


                });
               }else{
                 form.submit();
                  //$('.patientForm').submit(); 
               }
             
       }
    });
    $('.crud_add_video').validate({
        rules: {
            title: "required"
        }, messages: {
            title: "Video Title should not be blank"
        }
    });
});

