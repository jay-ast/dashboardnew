$(function () {

    var currentDate; // Holds the day clicked when adding a new event
    var currentEvent; // Holds the event object when editing an event
    // var base_url = 'http://dashboardnew.perfect-forms.net/'; // Here i define the base_url
    var base_url = 'https://synergy-plus.com/dashboardnew/'; // Here i define the base_url
    var selectedDateTime;
    var setModel;
    var modelEvent;
    var appoint_id;

    var today = new Date();                
    var todayDate = moment(today).format('YYYY-MM-DD');
    
    if(window.location.href.indexOf("id") != -1){
        var appoint_id = window.location.href.split('?')[1];
        appoint_id = appoint_id.split('=')[1];        
    }
    if(appoint_id){
        modal({            
            buttons: {
                add: {
                    id: 'add-event', // Buttons id
                    css: 'btn-success', // Buttons class
                    label: 'Add' // Buttons label
                }
            },
            title: 'Add Event' // Modal title
        }, 'event-modal', appoint_id, todayDate);
    }
    // Fullcalendar
    
    fullCalendar($apiUrl = 'admin/home/getEvents');
    function fullCalendar($apiUrl) {
        $('#calendar').fullCalendar({
            theme: false,
            // slotDuration: '00:30', // 2 hours
            slotDuration: "00:30:00",
            eventLimit: true,
            customButtons: {
                myCustomButton: {
                    text: 'schedule',
                    class: 'btn-schedule btn btn-primary',
                    click: function () {
                        modal({
                            // Available buttons when adding                
                            buttons: {
                                add: {
                                    id: 'add-event', // Buttons id
                                    css: 'btn-success', // Buttons class
                                    label: 'Add' // Buttons label
                                }
                            },
                            title: 'Add Event' // Modal title
                        }, 'event-modal', '', true);
                    }
                },
            },

            header: {
                left: 'prev, next, today, myCustomButton',
                center: 'title',
                right: 'month, agendaWeek, agendaDay, list'
            },
            // Get all events stored in database
            eventLimit: true, // allow "more" link when too many events
            events: base_url + $apiUrl,
            titleFormat: 'dddd, MMMM D, YYYY',
            selectable: true,
            defaultView: 'agendaDay',
            selectHelper: true,
            // editable: true, // Make the event resizable true          
            select: function (start, end) {
                currentDate = start;
                var today = new Date();
                selectedDate = moment(currentDate).format('YYYY-MM-DD');
                todayDate = moment(today).format('YYYY-MM-DD');

                selectedDateTime = moment(currentDate).format('YYYY-MM-DD HH:mm');
                todayDateTime = moment(today).format('YYYY-MM-DD HH:mm');
                // Open modal to add event    
                                
                if (selectedDate >= todayDate) {
                    modal({
                        // Available buttons when adding
                        buttons: {
                            add: {
                                id: 'add-event', // Buttons id
                                css: 'btn-success', // Buttons class
                                label: 'Add' // Buttons label
                            }
                        },
                        title: 'Add Event' // Modal title
                    }, 'event-modal');
                } else {
                    $('#past_appointment-confirmation-modal').find('.modal-title').html('You can not add an appointment for past time.');
                    $('#past_appointment-confirmation-modal').modal('show');
                    return false;
                }

                // if ($('.fc-corner-left.fc-state-active').html() == 'month') {
                //     if (selectedDate >= todayDate) {
                //         modal({
                //             // Available buttons when adding
                //             buttons: {
                //                 add: {
                //                     id: 'add-event', // Buttons id
                //                     css: 'btn-success', // Buttons class
                //                     label: 'Add' // Buttons label
                //                 }
                //             },
                //             title: 'Add Event' // Modal title
                //         }, 'event-modal');
                //     } else {
                //         $('#past_appointment-confirmation-modal').find('.modal-title').html('You can not add an appointment for past time.');
                //         $('#past_appointment-confirmation-modal').modal('show');
                //         return false;
                //     }
                // } else {
                //     if (selectedDateTime >= todayDateTime) {
                //         modal({
                //             // Available buttons when adding
                //             buttons: {
                //                 add: {
                //                     id: 'add-event', // Buttons id
                //                     css: 'btn-success', // Buttons class
                //                     label: 'Add' // Buttons label
                //                 }
                //             },
                //             title: 'Add Event' // Modal title
                //         }, 'event-modal');
                //     } else {
                //         $('#past_appointment-confirmation-modal').find('.modal-title').html('You can not add an appointment for past time.');
                //         $('#past_appointment-confirmation-modal').modal('show');
                //         return false;
                //     }
                // }
            },
            
            dayClick: function(date, jsEvent, view) {
                if(view.name == 'month'){
                    $('#calendar').fullCalendar('gotoDate',date);
                    $('#calendar').fullCalendar('changeView','agendaDay');
                }                
            },

            eventRender: function (event, element) {
                if (event.brief_note) {
                    element.find(".fc-content").append("<i class='brief-info fa fa-info-circle'></i>");
                }
            },

            eventDrop: function (event, delta, revertFunc, start, end) {
                start = event.start.format('YYYY-MM-DD hh:mm A');
                if (event.end) {
                    end = event.end.format('YYYY-MM-DD hh:mm A');
                } else {
                    end = start;
                }
                $.post(base_url + 'admin/home/dragUpdateEvent', {
                    id: event.id,
                    start: start,
                    end: end
                }, function (result) {
                    $('.alert').addClass('alert-success').text('Event updated successfuly');
                    hide_notify();
                });
            },
            eventResize: function (event, dayDelta, minuteDelta, revertFunc) {
                start = event.start.format('YYYY-MM-DD hh:mm A');
                if (event.end) {
                    end = event.end.format('YYYY-MM-DD hh:mm A');
                } else {
                    end = start;
                }
                $.post(base_url + 'admin/home/dragUpdateEvent', {
                    id: event.id,
                    start: start,
                    end: end
                }, function (result) {
                    $('.alert').addClass('alert-success').text('Event updated successfuly');
                    hide_notify();
                });
            },
            // Event Mouseover
            eventMouseover: function (calEvent, jsEvent, view) {
                if (calEvent.brief_note) {
                    var tooltip = '<div class="event-tooltip">' + calEvent.brief_note + '</div>'
                    $("body").append(tooltip);
                }
                $(this).mouseover(function (e) {
                    $(this).css('z-index', 10000);
                    $('.event-tooltip').fadeIn('500');
                    $('.event-tooltip').fadeTo('10', 1.9);
                }).mousemove(function (e) {
                    $('.event-tooltip').css('top', e.pageY + 10);
                    $('.event-tooltip').css('left', e.pageX + 20);
                });
            },
            eventMouseout: function (calEvent, jsEvent) {
                $(this).css('z-index', 8);
                $('.event-tooltip').remove();
            },
            // Handle Existing Event Click
            eventClick: function (calEvent, jsEvent, view) {
                // Set currentEvent variable according to the event clicked in the calendar
                currentEvent = calEvent;
                // Open modal to edit or delete event
                $('#appointment-confirmation-modal').find('.modal-title').html('Please Confirm');
                $('#appointment-confirmation-modal').modal('show');
                if(currentEvent.payment_status == 'paid'){
                    $('#appointment-confirmation-modal').find('#btnCheckout').hide();
                    $('#appointment-confirmation-modal').find('#btnCheckPaid').show();
                }else{
                    $('#appointment-confirmation-modal').find('#btnCheckout').show();
                    $('#appointment-confirmation-modal').find('#btnCheckPaid').hide();
                }
            }
        });
    }

    // Prepares the modal window according to data passed
    function modal(data, id = '', client_id = '', eventDate, is_schedule) {
        if (data.event) {
            setModel = 'edit';
            modelEvent = data.event;
        } else {
            setModel = 'add'
        }
        setTimeout(function () {
            let default_recurrence = 'no_fixed_time';
            $("#recurrence").val(default_recurrence).trigger('change');
        }, 500);
        $('#notify_mail').prop('checked', true);
        $('#btnUpdateClient').addClass('hide');
        getClientData();
        if (data.event) {
            $duration_data = data.event.meeting_duration.split(":");
            $meeting_duration_hours = $duration_data[0];
            $meeting_duration_minutes = $duration_data[1];
        }

        $('.modal-title').html(data.title);
        $('.modal-footer button:not(".btn-default")').remove();
        if (client_id) {
            setTimeout(function () {
                $('#client_id').val(client_id).trigger("change");
                getClientDetails(client_id);
            }, 2000);

        } else {
            setTimeout(function () {
                $('#client_id').val(data.event ? data.event.client_id : '').trigger("change");
            }, 1000);
        }
        var today = new Date();
        if (data.event) {
            if (currentDate != undefined || data.event != null) {
                $('#schedule_date').val(data.event ? moment(data.event.start).format('DD-MM-YYYY') : moment(currentDate).format('DD-MM-YYYY'));
                $('#schedule_date').prop('readonly', true);
            } else {
                $('#schedule_date').val(selectedDate ? moment(selectedDate).format('DD-MM-YYYY') : moment(today).format('DD-MM-YYYY'));
            }
        } else {
            if (eventDate) {
                $('#schedule_date').prop('readonly', false);
                $('#schedule_date').val(eventDate ? eventDate : '');
            } else {
                $('#schedule_date').prop('readonly', false);
                if(selectedDate){
                    $('#schedule_date').val(selectedDate ? moment(selectedDate).format('DD-MM-YYYY') : moment(today).format('DD-MM-YYYY'));    
                }else{
                    $('#schedule_date').val(moment(today).format('DD-MM-YYYY'));
                }                
                // $('#schedule_date').val(selectedDate ? moment(selectedDate).format('YYYY-MM-DD') : moment(today).format('YYYY-MM-DD'));
            }
        }

        var start_time = data.event ? data.event.start_time : '';
        var end_time = data.event ? data.event.end_time : '';
        $('#appointment_type').val(data.event && data.event.appointment_type ? data.event.appointment_type : '');
        $('#repeating_weeks').val(data.event ? data.event.repeating_weeks : '');
        $('#brief_note').val(data.event ? data.event.brief_note : '');
        $('#meeting_duration_hours').val(data.event ? $meeting_duration_hours : '');
        $('#meeting_duration_minutes').val(data.event ? $meeting_duration_minutes : '');
        $('#recurrence').val(data.event ? data.event.recurrence : '');
        $.each(data.buttons, function (index, button) {
            $('.modal-footer').prepend('<button type="button" id="' + button.id + '" class="btn ' + button.css + '">' + button.label + '</button>')
        })
        if (id != '') {
            $('#' + id).modal('show');
        } else {
            $('.modal').modal('show');
        }
        if (data.event && data.event.appointment_type) {
            $('#repeating_weeks').prop('disabled', true);
            $('.repeating_weeks_group').hide();
        } else {
            $('#repeating_weeks').prop('disabled', false);
            $('.repeating_weeks_group').show();
        }

        if (data.event && data.event.appointment_type) {
            $('#recurrence').prop('disabled', true);
            $('.recurrence_group').hide();
        } else {
            $('#recurrence').prop('disabled', false);
            $('.recurrence_group').show();
        }

        if ($('.fc-corner-left.fc-state-active').html() == 'month' || is_schedule == true) {
            if (start_time != '') {
                var start_time = moment(start_time, ["HH.mm"]).format("hh:mm A");
                $('#start_time').val(start_time);
            } else {
                const date = new Date();
                $('#start_time').val(date ? moment(date).format('hh:mm A') : '');
            }

            if (end_time != '') {
                var end_time = moment(end_time, ["HH.mm"]).format("hh:mm A");
                $('#end_time').val(end_time);
            } else {
                if ($('.meeting_duration').val()) {
                    const date = new Date();
                    var end_time = addMinutes(5, date);
                    $('#end_time').val(end_time ? moment(end_time).format('hh:mm A') : '');
                } else {
                    $('#end_time').val('');
                }
            }
        } else {
            if (start_time != '') {
                var start_time = moment(start_time, ["HH.mm"]).format("hh:mm A");
                $('#start_time').val(start_time);
            } else {
                if (selectedDateTime != '') {
                    var selected_time = moment(selectedDateTime).format("hh:mm A");
                    $('#start_time').val(selected_time);
                }
            }

            if (end_time != '') {
                var end_time = moment(end_time, ["HH.mm"]).format("hh:mm A");
                $('#end_time').val(end_time);
            } else {
                var duration_time = $('.meeting_duration').val();
                if (duration_time) {
                    var start_time_value = moment(selected_time, "hh:mm A").format("HH:mm");
                    var end_time_value = moment(start_time_value, "hh:mm").add(duration_time, 'minutes').format("HH:mm A");
                    $('.end_time').val(moment(end_time_value, "HH:mm").format("hh:mm A"));
                } else {
                    $('.end_time').val('');
                }

            }
        }

        setTimeout(function () {
            if ($('#client_id').val()) {
                $('#btnUpdateClient').removeClass('hide');
            } else {
                $('#btnUpdateClient').addClass('hide');
            }
        }, 1000);
    }

    // Handle Click on Add Button
    $('.modal').on('click', '#add-event', function (e) {

        var today = new Date();
        var todayDateTime = moment(today).format('YYYY-MM-DD hh:mm A');
        var selectedDateData = moment($('#schedule_date').val(), "DD-MM-YYYY").format("YYYY-MM-DD");     
        if ($('#client_id').val()) {
            if ($('#appointment_type').val()) {
                if ($('#recurrence').val()) {
                    if (Date.parse(selectedDateData + ' ' + $('#start_time').val()) >= Date.parse(todayDateTime)) {
                        // if (Date.parse($('#start_time').val()) < Date.parse($('#end_time').val())) {
                            $.post(base_url + 'admin/home/addEvent', {
                                client_id: $('#client_id').val(),
                                schedule_date: $('#schedule_date').val(),
                                start_time: $('#start_time').val(),
                                end_time: $('#end_time').val(),
                                appointment_type: $('#appointment_type').val(),
                                repeating_weeks: $('#repeating_weeks').val(),
                                brief_note: $('#brief_note').val(),
                                notify_mail: $('#notify_mail').prop('checked'),
                                meeting_duration: $('#meeting_duration_hours').val() + ':' + $('#meeting_duration_minutes').val(),
                                recurrence: $('#recurrence').val(),
                                price: $('#appointment_price').val(),
                            }, function (result) {
                                $('.alert').addClass('alert-success').text('Event added successfuly');
                                $('.modal').modal('hide');
                                $('#calendar').fullCalendar("refetchEvents");
                                hide_notify();
                            });
                        // } else {
                        //     $('.error').html('End time must be greater than the start time.');
                        //     return false;
                        // }
                    } else {
                        $('.error').html('Date or time must be greater than the current date or time.');
                        return false;
                    }
                } else {
                    $('.error').html('Please select Recurrence for Meeting.');
                    return false;
                }
            } else {
                $('.error').html('Please select Appointment type.');
                return false;
            }
        } else {
            $('.error').html('Please select Client Name.');
            return false;
        }
    });

    // Handle click on Update Button
    $('.modal').on('click', '#update-event', function (e) {
        if ($('#client_id').val()) {
            if ($('#appointment_type').val()) {
                // if ($('#start_time').val() < $('#end_time').val()) {
                    $.post(base_url + 'admin/home/updateEvent', {
                        id: currentEvent._id,
                        client_id: $('#client_id').val(),
                        schedule_date: $('#schedule_date').val(),
                        start_time: $('#start_time').val(),
                        end_time: $('#end_time').val(),
                        appointment_type: $('#appointment_type').val(),
                        repeating_weeks: $('#repeating_weeks').val(),
                        brief_note: $('#brief_note').val(),
                        notify_mail: $('#notify_mail').prop('checked'),
                        meeting_duration: $('#meeting_duration_hours').val() + ':' + $('#meeting_duration_minutes').val(),
                        recurrence: $('#recurrence').val(),
                        price: $('#appointment_price').val(),
                    }, function (result) {
                        $('.alert').addClass('alert-success').text('Event updated successfuly');
                        $('.modal').modal('hide');
                        $('#calendar').fullCalendar("refetchEvents");
                        hide_notify();
                    });
                // } else {
                //     $('.error').html('End time must be greater than the start time.');
                //     return false;
                // }
            } else {
                $('.error').html('Please select Appointment type.');
                return false;
            }
        } else {
            $('.error').html('Please select Client Name.');
            return false;
        }
    });

    // Handle Click on Delete Button
    $(document).on('click', '#delete-event', function() {        
        $('#eventDelete').find('.modal-title').html('Alert!!');
        $("#eventDelete p").html("Do you realy want to delete this Event?");                   
        $("#eventDelete").modal('show');        
        return false; 
    });

    $(document).on('click', '.modeldeleteyes', function() {
        $.get(base_url + 'admin/home/deleteEvent?id=' + currentEvent._id, function (result) {
            $('.alert').addClass('alert-success').text('Event deleted successfully !');
            $('.modal').modal('hide');
            $('#calendar').fullCalendar("refetchEvents");
            hide_notify();
        });
    });

    $(".btn-default").on('click', function () {
        $('.error').html('');
        $('.client_name').val('');
        $('.client_email').val('');
        $('.client_phone').val('');
        $('#firstname').val('');
        $('#lastname').val('');
        $('#email').val('');
        $('#phone').val('');
        $('#dateofbirth').val('');
        $('#physicaladdress').val('');
        $('.street').val("");
        $('.city').val("");
        $('.postal_code').val("");
        $('.country').val("");
        $('.emergencycontactname').val("");
        $('#emergencycontact').val('');
    });

    $("#calendar").on('click', function () {
        $('.error').html('');
        $('.client_name').val('');
        $('.client_email').val('');
        $('.client_phone').val('');
        $('#firstname').val('');
        $('#lastname').val('');
        $('#email').val('');
        $('#phone').val('');
        $('#dateofbirth').val('');
        $('#physicaladdress').val('');
        $('.street').val("");
        $('.city').val("");
        $('.postal_code').val("");
        $('.country').val("");
        $('.emergencycontactname').val("");
        $('#emergencycontact').val('');
    });

    function hide_notify() {
        setTimeout(function () {
            $('.alert').removeClass('alert-success').text('');
        }, 2000);
    }

    // Dead Basic Validation For Inputs
    function validator(elements) {
        var errors = 0;
        $.each(elements, function (index, element) {
            if ($.trim($('#' + element).val()) == '') errors++;
        });
        if (errors) {
            $('.error').html('Please Select Client Name, Appointment type');
            return false;
        }
        $('.error').html('');
        // $('.client_name').val('');
        // $('.client_email').val('');
        // $('.client_phone').val('');
        $('#firstname').val('');
        $('#lastname').val('');
        $('#email').val('');
        $('#phone').val('');
        $('#dateofbirth').val('');
        $('#physicaladdress').val('');
        $('#emergencycontact').val('');
        $('.street').val("");
        $('.city').val("");
        $('.postal_code').val("");
        $('.country').val("");
        $('.emergencycontactname').val("");
        // $('.client-details').attr('hidden', true);
        return true;
    }

    function addMinutes(numOfMinutes, date = new Date()) {
        date.setMinutes(date.getMinutes() + numOfMinutes);
        return date;
    }

    $(document).on('click', '.btnsaveuser', function (e) {
        if ($('#firstname').val() && $('#lastname').val() && $('#email').val() && $('#phone').val()) {
            $.ajax({
                type: 'POST',
                url: base_url + 'admin/patients/addNewPatient',
                beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                    $('#loader').removeClass('hidden')
                },
                data: {
                    firstname: $('#firstname').val(),
                    lastname: $('#lastname').val(),
                    email: $('#email').val(),
                    phone: $('#phone').val(),
                    date_of_birth: $('#dateofbirth').val(),
                    physical_address: $('#physicaladdress').val(),
                    emergency_contact: $('#emergencycontact').val(),
                    street: $('.street').val(),
                    city: $('.city').val(),
                    postal_code: $('.postal_code').val(),
                    country: $('.country').val(),
                    emergency_contact_name: $('.emergencycontactname').val(),
                },
                success: function (result) {
                    var data = JSON.parse(result);
                    client_id = data.patient_id;

                    modal({
                        buttons: {
                            add: {
                                id: 'add-event', // Buttons id
                                css: 'btn-success', // Buttons class
                                label: 'Add' // Buttons label
                            }
                        },
                        title: 'Add Event' // Modal title
                    }, 'event-modal', client_id);


                    $('.alert').addClass('alert-success').text('Client added successfuly');
                    $('#client-modal').modal('hide');
                    hide_notify();

                }, complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                    setTimeout(function () {
                        // $('#client_id').val(client_id).trigger("change");
                        $('#loader').addClass('hidden')
                    }, 1000);
                },
                error: function (data) {
                    console.log(data);
                }
            });
        } else {
            $('.error').html('Firstname, lastname, email and phone fields are require');
            return false;
        }
    });

    function getClientData() {
        $('#client_id').html('');
        $.ajax({
            type: 'POST',
            url: base_url + 'admin/home/getClientName',
            success: function (actionResponse) {
                var clientData = JSON.parse(actionResponse);
                // $('#client_id').append("<option value=''>Select Client</option>");
                $.each(clientData, function (key, value) {
                    $.each(value, function (k, v) {
                        $('#client_id').append("<option value='" + v.id + "'>" + v.firstname + ' ' + v.lastname + "</option>");
                    });
                });
            },
            error: function (data) {
                console.log(data);
            }
        });
    }

    $(document).on('click', '.fc-myCustomButton-button', function (e) {
        $('#schedule_date').val('');
        // $('#schedule_date').prop('readonly', false);
    });

    // $(".meeting_duration").click(function(item) {
    //     var duration_hours = moment($(this).val(),"hh:mm").format("HH") * 60; 
    //     var duration_minutes = moment($(this).val(),"hh:mm").format("m"); 
    //     // var hours_into_minutes = duration_hours * 60;        
    //     var duration_time = parseInt(duration_hours) + parseInt(duration_minutes);

    //     if(duration_time){
    //         var start_time_value = moment($('.start_time').val(), "hh:mm A").format("HH:mm");            
    //         var end_time_value = moment(start_time_value, "hh:mm").add(duration_time,'minutes').format("HH:mm A");            
    //         $('.end_time').val(moment(end_time_value, "HH:mm").format("hh:mm A"));   
    //     }else{
    //         $('.end_time').val('');
    //     }        
    // });

    $(".modal-content").click(function (item) {
        var duration_hours = $('.meeting_duration_hours').val() * 60;
        var duration_minutes = $('.meeting_duration_minutes').val() ?? 0;
        // var hours_into_minutes = duration_hours * 60;        
        var duration_time = parseInt(duration_hours) + parseInt(duration_minutes);

        if (duration_time) {
            var start_time_value = moment($('.start_time').val(), "hh:mm A").format("HH:mm");
            var end_time_value = moment(start_time_value, "hh:mm").add(duration_time, 'minutes').format("HH:mm A");
            $('.end_time').val(moment(end_time_value, "HH:mm").format("hh:mm A"));
        } else {
            $('.end_time').val('');
        }
    });

    $(".start_time").click(function (item) {
        $('.meeting_duration').val('');
        $('.end_time').val('');
    });

    $("#recurrence").change(function (item) {
        // alert('Here');
        if ($(this).val() == "no_fixed_time") {
            $('#repeating_weeks').prop('disabled', true);
            $('.repeating_weeks_group').hide();
        } else {
            $('#repeating_weeks').prop('disabled', false);
            $('.repeating_weeks_group').show();
        }
    });

    $(document).on('click', '.btnSaveClient', function (e) {
        var selectedClientId = $('.client_id').val();
        if ($('#firstname').val() && $('#lastname').val() && $('#email').val() && $('#phone').val()) {
            $.ajax({
                type: 'POST',
                url: base_url + 'admin/patients/updateClient',
                beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                    $('#loader').removeClass('hidden')
                },
                data: {
                    patientid: selectedClientId,
                    firstname: $('#firstname').val(),
                    lastname: $('#lastname').val(),
                    email: $('#email').val(),
                    phone: $('#phone').val(),
                    date_of_birth: $('#dateofbirth').val(),
                    physical_address: $('#physicaladdress').val(),
                    emergency_contact: $('#emergencycontact').val(),
                    street: $('.street').val(),
                    city: $('.city').val(),
                    postal_code: $('.postal_code').val(),
                    country: $('.country').val(),
                    emergency_contact_name: $('.emergencycontactname').val(),
                    street: $('.street').val(),
                    city: $('.city').val(),
                    postal_code: $('.postal_code').val(),
                    country: $('.country').val(),
                    emergencycontactname: $('.emergencycontactname').val(),
                },
                success: function (result) {
                    var data = JSON.parse(result);
                    client_id = data.patient_id;
                    if (setModel == 'edit') {
                        modal({
                            // Available buttons when editing
                            buttons: {
                                delete: {
                                    id: 'delete-event',
                                    css: 'btn-danger',
                                    label: 'Delete'
                                },
                                update: {
                                    id: 'update-event',
                                    css: 'btn-success',
                                    label: 'Update'
                                }
                            },
                            title: 'Edit Event "' + modelEvent.title + '"',
                            event: modelEvent
                        }, 'event-modal', client_id);
                    } else {
                        modal({
                            buttons: {
                                add: {
                                    id: 'add-event', // Buttons id
                                    css: 'btn-success', // Buttons class
                                    label: 'Add' // Buttons label
                                }
                            },
                            title: 'Add Event' // Modal title
                        }, 'event-modal', client_id);
                    }
                    // modal({
                    //     buttons: {
                    //         add: {
                    //             id: 'add-event', // Buttons id
                    //             css: 'btn-success', // Buttons class
                    //             label: 'Add' // Buttons label
                    //         }
                    //     },
                    //     title: 'Add Event' // Modal title
                    // }, 'event-modal', client_id);

                    $('.alert').addClass('alert-success').text('Client added successfuly');
                    $('#client-modal').modal('hide');
                    hide_notify();

                }, complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                    setTimeout(function () {
                        // $('#client_id').val(client_id).trigger("change");
                        $('#loader').addClass('hidden')
                    }, 1000);
                },
                error: function (data) {
                    console.log(data);
                }
            });
        } else {
            $('.error').html('Firstname, lastname, email and phone fields are require');
            return false;
        }
    });

    $("#btnEditAppointment").click(function (item) {
        $('#appointment-confirmation-modal').modal('hide');
        var clientId = currentEvent.client_id;
        modal({
            // Available buttons when editing
            buttons: {
                delete: {
                    id: 'delete-event',
                    css: 'btn-danger',
                    label: 'Delete'
                },
                update: {
                    id: 'update-event',
                    css: 'btn-success',
                    label: 'Update'
                }
            },
            title: 'Edit Event "' + currentEvent.title + '"',
            event: currentEvent
        }, 'event-modal', clientId);
    });

    $("#btnCheckout").click(function (item) {
        $('#appointment-confirmation-modal').modal('hide');
        var event_id = currentEvent.id;        
        $.ajax({
            type: 'POST',
            url: base_url + 'admin/appointment/checkOutAppointment',
            data: {
                    event_id: event_id,                        
                },
            success: function(actionResponse) {    
                $('#calendar').fullCalendar('destroy');
                fullCalendar($apiUrl = 'admin/home/getEvents');         
            },
            error: function(data) {
                console.log(data);
            }
        });
    });    

    $("#btnCreateAppointment").click(function (item) {
        $('#appointment-confirmation-modal').modal('hide');
        let client_id = currentEvent.client_id;
        let eventDate = moment(currentEvent.start).format('DD-MM-YYYY');
        var today = new Date();
        let todayDate = moment(today).format('DD-MM-YYYY');

        if (eventDate <= todayDate) {
            eventDate = moment(today).format('DD-MM-YYYY');
        } else {
            eventDate = moment(currentEvent.start).format('DD-MM-YYYY');
        }
        modal({
            // Available buttons when adding
            buttons: {
                add: {
                    id: 'add-event', // Buttons id
                    css: 'btn-success', // Buttons class
                    label: 'Add' // Buttons label
                }
            },
            title: 'Add Event', // Modal title            
        }, 'event-modal', client_id, eventDate);
    });

    initClientOnChange();
    function initClientOnChange() {
        $(".client_id").change(function (item) {
            var client_id = $('#client_id').val();
            if (client_id) {
                $('#btnUpdateClient').removeClass('hide');
            } else {
                $('#btnUpdateClient').addClass('hide');
            }
            // $('.client-details').removeAttr('hidden');	
            getClientDetails(client_id);
        });
    }


    function getClientDetails(client_id) {
        $.ajax({
            type: 'POST',
            url: base_url + 'admin/patients/getPatientDetails/' + client_id,
            success: function (actionResponse) {
                var clientData = JSON.parse(actionResponse);
                if (clientData.status == true) {
                    $('.error').html('');
                    $('.client_name').val(clientData ? clientData['data']['firstname'] + ' ' + clientData['data']['lastname'] : ' ');
                    $('.client_email').val(clientData ? clientData['data']['email'] : ' ');
                    $('.client_phone').val(clientData ? clientData['data']['phone'] : ' ');                    
                } else {                    
                    return false;
                }                
            },
            error: function (data) {
                console.log(data);
            }
        });
    }

    $(".provider_data").change(function (item) {
        var provider_id = $('#provider_data').val();
        var provider_name = $('#provider_data').find(':selected').data('name');
        if(provider_name){
            $('.provider_name').text(provider_name);
        }else{
            $('.provider_name').text("All Staff");
        }
        $('#calendar').fullCalendar('destroy');
        fullCalendar($apiUrl = 'admin/home/getEvents/' + provider_id);
    });
    
    $(document).on('click', '#createNoteForm', function() {     
        var client_id_notes = $('#event-modal').find('#client_id').val();  
        console.log('client_id_notes', client_id_notes);
        $("#createNote").attr('data-clientid', client_id_notes);            
 
        if(client_id_notes){
            $('#event-modal').modal('hide');
            $.ajax({
            type: 'POST',
            url: base_url + 'admin/patients/loadCreateNoteView',                
            success: function(result) {                                        
                $('#createNote').html(result);                    
            },
            complete: function() {},
            error: function(data) {
                console.log(data);
            }
            })
        }else{                
            $('.error').html('Need to select client for create Note.');
            return false;
        }                                     
    });

    $(document).on('click', '#addNoteDetails', function() {        
        if($('#subjective').val() && $('#objective').val() && $('#assessment').val() && $('#plan').val()){
            $.ajax({
                type: 'POST',
                url: base_url + 'admin/patients/addNewNotes',
                data: {
                    subjective: $('#subjective').val(),
                    objective: $('#objective').val(),
                    assessment: $('#assessment').val(),
                    plan: $('#plan').val(),
                    client_id: $('#event-modal').find('#client_id').val(),
                },
                success: function(result) {
                    var notesdata = JSON.parse(result);                    
                    $('#createNote').modal('toggle');
                    modal({
                        // Available buttons when adding
                        buttons: {
                            add: {
                                id: 'add-event', // Buttons id
                                css: 'btn-success', // Buttons class
                                label: 'Add' // Buttons label
                            }
                        },
                        title: 'Add Event' // Modal title
                    }, 'event-modal', $('#event-modal').find('#client_id').val());                    
                },
                complete: function() {},
                error: function(data) {
                    console.log(data);
                }
            })
        }else{
            $('.error').html('Please provide all data for Notes.');
            return false;
        }           
    });

    $(document).on('click', '.btnsaveclientuser', function (e) {
        $('.btnsaveclientuser').val('save');        
    });

    $(document).on('click', '#group_client', function() {
        $('.client_id').off('change');
        $('.selectpicker').select2('destroy');
        $('.email_div').prop('hidden', true);
        $('.phone_div').prop('hidden', true);
        $('#client_id').removeClass('client_id');
        $('.selectpicker').select2({
            multiple: true
        });
        $('#btnUpdateClient').addClass('hide');
    });

    $(document).on('click', '#single_client', function() {
        $('#client_id').addClass('client_id');
        $('.selectpicker').select2({
            multiple: false
        });
        $('.email_div').prop('hidden', false);
        $('.phone_div').prop('hidden', false);            
        if($('#client_id').val()){
            $('#btnUpdateClient').removeClass('hide');    
        }else{
            $('#btnUpdateClient').addClass('hide');
        }
        initClientOnChange();
    });

    $(document).on('change', '.appointment_type', function() {
        var appointment_type_id = $(this).val();
        console.log('appointment_type_id', appointment_type_id);
        $.ajax({
            type: 'POST',
            url: base_url + 'admin/patients/getAppointmentPrice/' + appointment_type_id,
            success: function (actionResponse) {
                var appointmentData = JSON.parse(actionResponse);                
                if (appointmentData.status == true) {                    
                    $.each(appointmentData['data'], function (index, val) {                        
                        $('.appointment_price').val(val.appointment_price);
                    })
                } else {                    
                    return false;
                }                
            },
            error: function (data) {
                console.log(data);
            }
        });        
    });    

});
