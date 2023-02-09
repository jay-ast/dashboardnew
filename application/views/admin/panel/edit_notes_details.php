<div class="modal-dialog">
    <div class="modal-content">
        <!-- dialog body -->
        <?php echo form_open(base_url('admin/patients/updateNotesDetails'), array("class" => "updateNotesForm")); ?>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit Note</h4>
        </div>
        <?php
        foreach ($notes_details as $notes) {
        ?>
            <div class="modal-body noteUpdateform">
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
                                <input type="text" class="form-control objective" id="objective" name="objective" placeholder="Objective" value="<?php echo $notes->objective ?>" />
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
                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="modal-footer">
                    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                        <div class="btn-group mr-2" role="group" aria-label="First group">
                            <button type="submit" class="client-portal-button" data-toggle="modal" target="_top" href="#" id="updateNoteDetails">Update Note</button>
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