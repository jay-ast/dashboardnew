<div class="modal-dialog">
    <div class="modal-content">
        <!-- dialog body -->
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Create New Note</h4>
        </div>

        <div class="modal-body modelform">
            <div class="error"></div>
            <div class="form-body clearfix col-md-12">
                <div class="row margin-top-10">
                    <div class="form-group col-md-6">
                        <input type="hidden" class="form-control client_id" name="client_id" data-clientid value="" readonly>
                    </div>
                </div>
                <div class="col-md-12 userdetail">
                    <div class="row margin-top-10 userdetails col-md-12">
                        <div class="form-group col-md-4">
                            <label>Subjective</label>
                        </div>
                        <div class="form-group col-md-8">
                            <textarea type="text" class="form-control subjective" rows="6" id="subjective" name="subjective" placeholder="Subjective"></textarea>
                        </div>
                    </div>

                    <div class="row margin-top-10 userdetails col-md-12">
                        <div class="form-group col-md-4">
                            <label>Objective</label>
                        </div>
                        <div class="form-group col-md-8">
                            <textarea type="text" class="form-control objective" rows="6" id="objective" name="objective" placeholder="Objective"></textarea>
                        </div>
                    </div>

                    <div class="row margin-top-10 userdetails col-md-12">
                        <div class="form-group col-md-4">
                            <label>Assessment</label>
                        </div>
                        <div class="form-group col-md-8">
                            <textarea type="text" class="form-control assessment" rows="6" id="assessment" name="assessment" placeholder="Assessment"></textarea>
                        </div>
                    </div>

                    <div class="row margin-top-10 userdetails col-md-12">
                        <div class="form-group col-md-4">
                            <label>Plan</label>
                        </div>
                        <div class="form-group col-md-8">
                            <textarea type="text" class="form-control plan" id="plan" rows="6" name="plan" placeholder="Plan"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>
            <div class="modal-footer">
                <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                    <div class="btn-group mr-2" role="group" aria-label="First group">
                        <button type="button" class="client-portal-button" data-toggle="modal" target="_top" href="#" id="addNoteDetails">Add Note</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>