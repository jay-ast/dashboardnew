<?php include_once 'header.php'; ?>
<div id="content">
    <h1 class="bg-white content-heading border-bottom">Edit Notes</h1>
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
        <div class="widget widget-inverse">
            <div class="widget-body padding-bottom-none">
                <div class="row">
                    <?php echo form_open(base_url('admin/patients/updateNotesDetails'), array("class" => "updateNotesForm")); ?>                    
                    <?php
                    foreach ($notes_data['notes_data'] as $notes) {
                        $exercies_id = explode(",", $notes->exercies_id);
                    ?>
                        <div class="noteUpdateform">
                            <div class="error"></div>
                            <div class="form-body clearfix col-md-12">
                                <div class="row margin-top-10">
                                    <div class="form-group col-md-6">
                                        <input type="hidden" class="form-control noteid" id="noteid" name="noteid" value="<?php echo $notes->id ?>">
                                    </div>
                                </div>
                                <div class="col-md-12 userdetail">
                                    <div class="row margin-top-10 userdetails col-md-12">
                                        <div class="form-group col-md-4">
                                            <label>Note Title</label>
                                        </div>
                                        <div class="form-group col-md-8">
                                            <input type="text" class="form-control note_title" id="note_title" name="note_title" placeholder="Notes Title" value="<?php echo $notes->note_title ?>" />
                                        </div>
                                    </div>
                                    <div class="row margin-top-10 userdetails col-md-12">
                                        <div class="form-group col-md-4">
                                            <label>Subjective</label>
                                        </div>
                                        <div class="form-group col-md-8">
                                            <textarea type="text" class="form-control subjective" rows="6" id="subjective" name="subjective" placeholder="Subjective"><?php echo $notes->subjective ?></textarea>
                                        </div>
                                    </div>

                                    <div class="row margin-top-10 userdetails col-md-12">
                                        <div class="form-group col-md-4">
                                            <label>Objective</label>
                                        </div>
                                        <div class="form-group col-md-8">
                                            <textarea type="text" class="form-control objective" rows="6" id="objective" name="objective" placeholder="Objective"><?php echo $notes->objective ?></textarea>
                                        </div>
                                    </div>

                                    <div class="row margin-top-10 userdetails col-md-12">
                                        <div class="form-group col-md-4">
                                            <label>Assessment</label>
                                        </div>
                                        <div class="form-group col-md-8">
                                            <textarea type="text" class="form-control assessment" rows="6" id="assessment" name="assessment" placeholder="Assessment"><?php echo $notes->assessment ?></textarea>
                                        </div>
                                    </div>

                                    <div class="row margin-top-10 userdetails col-md-12">
                                        <div class="form-group col-md-4">
                                            <label>Plan</label>
                                        </div>
                                        <div class="form-group col-md-8">
                                            <textarea type="text" class="form-control plan" id="plan" rows="6" name="plan" placeholder="Plan"><?php echo $notes->plan ?></textarea>
                                        </div>
                                    </div>

                                    <div class="row margin-top-10 userdetails col-md-12">
                                        <label class="col-md-4 control-label" for="exercise">Select Exercise</label>
                                        <div class="col-md-4 clientSelect">
                                            <select class="form-control exercise_data" id="exercise_data" name="exercise_data[]" multiple>
                                                <?php
                                                foreach ($notes_data['generalexercies'] as $generalex) {
                                                    $selected = in_array($generalex->id, $exercies_id) ? 'selected' : '';
                                                    echo '<option value="' . $generalex->id . '" ' . $selected . '>' . $generalex->name  . '</option>';
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>
                            <div class="modal-footer">
                                <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                    <div class="btn-group mr-2" role="group" aria-label="First group">
                                        <button type="submit" class="client-portal-button" target="_top" href="#" id="updateNoteDetails">Update Note</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once 'footer.php'; ?>
<script>
    $(document).ready(function() {
        var base_url = '<?php echo base_url(); ?>';

        $(document).on('click', '#updateNoteDetails', function(e) {            
            if ($('#note_title').val() && $('#subjective').val() && $('#objective').val() && $('#assessment').val() && $('#plan').val()) {
                $.ajax({
                    type: 'POST',
                    url: base_url + 'admin/patients/updateNotesDetails',
                    data: {
                        note_id: $('.noteUpdateform').find('#noteid').val(),
                        note_title: $('.noteUpdateform').find('#note_title').val(),
                        subjective: $('.noteUpdateform').find('#subjective').val(),
                        objective: $('.noteUpdateform').find('#objective').val(),
                        assessment: $('.noteUpdateform').find('#assessment').val(),
                        plan: $('.noteUpdateform').find('#plan').val(),
                        exercies_id: $('.noteUpdateform').find('#exercise_data').val(),
                    },
                    success: function(result) {
                        var notesdata = JSON.parse(result);
                        // var extraMessageHtml = "";
                        // $('#editNotesDetails').modal('toggle');
                        // if (notesdata['success'] == true) {
                        //     extraMessageHtml = '<div class="alert alert-success">' + notesdata['message'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
                        // } else {
                        //     extraMessageHtml = '<div class="alert alert-danger">' + notesdata['message'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
                        // }
                        window.location.href = base_url + 'admin/patients';
                        // $('.extraCustomMessage').html(extraMessageHtml);
                    },
                    complete: function() {},
                    error: function(data) {
                        console.log(data);
                    }
                })
            } else {
                $('.error').html('Please provide all data for Notes.');
                return false;
            }
        });
    }); 
</script>