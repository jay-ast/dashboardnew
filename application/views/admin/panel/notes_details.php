<div class="modal-dialog">
    <div class="modal-content">
        <?php echo form_open(base_url('admin/patients/addNewNotes')); ?>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <a style="float: right; margin-right: 20px;" data-toggle="modal" href="#clientPortal" class="formNotesDetails">Return to client portal</a>
            <?php
            foreach ($notes_data['client_name'] as $name) {
                $client_id = $name->id;
            ?>
                <h4 class="modal-title"><b>Client Name: <?php echo $name->firstname . ' ' . $name->lastname ?></b></h4>
            <?php
            }
            ?>
        </div>

        <div class="modal-body">
            <div class="row">
                <div class="col-md-12 notesDetail">
                    <table class="dynamicTable tableTools table table-striped checkboxs">
                        <thead>
                            <tr class=" text-center">
                                <th>Date</th>
                                <th>Notes Type</th>
                                <th>Provider</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            <?php
                                if(!empty($notes_data['notes_details'])){                                 
                                    foreach($notes_data['notes_details'] as $notes){                                            
                            ?>
                                    <tr class="gradeX" id="">
                                        <td><?php echo $notes->created_date ?></td>
                                        <td><?php echo $notes->note_title ?></td>
                                        <td> <?php echo $notes->firstname . ' ' . $notes->lastname ?></td>
                                        <td>                                    
                                            <a class="editNotesData" id="editNotesData" data-clientid="<?php echo $client_id ?>" data-noteid="<?php echo $notes->note_id; ?>" data-action="edit" data-toggle="modal" href="#editNotesDetails">
                                            <i class="glyphicon glyphicon-edit" data-toggle="tooltip" title="Edit Note"></i></a>

                                            <a class="deleteNotesWarning" data-noteid="<?php echo $notes->note_id; ?>" data-action="delete" data-toggle="modal" href="#deleteNote">
                                            <i class="glyphicon glyphicon-trash " data-toggle="tooltip" title="Delete Note"></i></a>
                                        </td>
                                    </tr>
                                <?php                                 
                                    }
                                }else{
                                    echo "<td>No Record Found</td>";    
                                }
                            ?>                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="client-portal-button" data-toggle="modal" target="_top" data-clientid="<?php echo $client_id ?>" href="#createNote" id="newNotes">Create new note</button>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>