<?php include 'header.php'; ?>

<link rel="stylesheet" href="/assets/custom/dist/css/BsMultiSelect.css">
<div id="content">
    <h1 class="bg-white content-heading border-bottom">Routines</h1>
    <div data-id="AAAAAAA" class="tabsbar">
        <ul>
            <li class="glyphicons building <?php echo ($isgeneral == true) ? 'active' : '' ?>"><a href="<?php echo base_url('admin/exercisefolders/generalroutinesfolder'); ?>"><i></i> General Routines</a></li>
            <li class="glyphicons parents <?php echo ($isgeneral == false) ? 'active' : '' ?> "><a href="<?php echo base_url('admin/exercisefolders/clientroutinesfolder'); ?>"><i></i> Client Routines </a></li>

        </ul>
    </div>
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
        <div class="widget widget-inverse">
            <div class="widget-body padding-bottom-none">
                <!-- Table -->
                <div id="myapp" class="row">
                    <?php
                    if ($adding)
                        $mytype = "addNewExercise";
                    else
                        $mytype = "UpdateExercise";



                    //echo form_open(base_url('admin/exercises/'.$mytype), array("class" => "exerciseForm","onsubmit"=>"return validateeditexForm()"));
                    echo form_open(base_url('admin/exercises/' . $mytype), array("class" => "exerciseForm")); ?>


                    <input type="hidden" name="isfrom" value="<?php echo $isfrom ?>">
                    <input type="hidden" id="exerciseid" name="exerciseid" value="<?php echo $exercise_id ?>">
                    <input type="hidden" id="originId" name="origin" value="<?php echo $_GET['origin'] ?>">
                    <input type="hidden" id="patientId" name="patient_id" value="<?PHP echo $client_id; ?>">


                    <div class="form-body clearfix col-md-12">
                        {{message}}
                        <div class="col-md-12">
                            <?php if (isset($cleint_folders) && !empty($cleint_folders)) { ?>
                                <div class="form-group col-md-2">
                                    <label>Choose your clients </label>
                                </div>

                                <div class="form-group col-md-10">

                                    <div class="row col-md-12">
                                        <select id="clientSelect" placeholder="Click To Add" multiple class="form-control folders clientfolders myTagSelect" name="clientfolderid[]">
                                            <?php

                                            foreach ($cleint_folders as $clientfolder) {
                                                if ($client_id > 0) {
                                                    // $selected = (in_array($client_id, $clientfolder)) ? 'selected' : '';
                                                    $selected = ($client_id == $clientfolder['client_id']) ? 'selected' : '';
                                                } else {
                                                    $selected = (in_array($clientfolder['id'], $assginedfolder)) ? 'selected' : '';
                                                }

                                                echo '<option data-client ="' . $clientfolder['id'] . '" data-clientid ="' . $clientfolder['client_id'] . '" value="' . $clientfolder['id'] . '" ' . $selected . '>' . $clientfolder['folder_name'] . '</option>';
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                            <?php } ?>

                            <div data-id="111111" class="row margin-top-10">
                                <div class="form-group col-md-2">
                                    <label>Name</label>
                                </div>
                                <div class="form-group col-md-10">
                                    <input id="routineName" v-model="routineName" type="text" class="form-control exercise_name" maxlength="100" name="name" placeholder="Routine Name" />
                                    <small id="routineNameMessage" style="color:red; display:none;">Routine Name must be unique</small>
                                </div>
                            </div>
                            <div data-id="222222" class="row margin-top-10">
                                <div class="form-group col-md-2">
                                    <label>Comments</label>
                                </div>
                                <div class="form-group col-md-10">
                                    <textarea placeholder="Routine Comments" class="form-control exercise_description col-md-12" rows="4" name="description"><?php echo $details['description'] ?></textarea>
                                </div>
                            </div>


                            <div data-id="333333" class="row margin-top-10">
                                <div class="form-group col-md-2">
                                    <label>Selected videos <span class="badge" style="color: white;margin-left: 7px;padding-top: -11px;">{{myvideoids.length}}</span></label>
                                </div>
                                <div class="form-group col-md-10">
                                    <div id="divMain">
                                        <div id="Dragexercise" class="droppable">
                                            <div v-for="(item,index) in assignVideos" :key="item.id" :id="`Exreciseid${item.id}`" :dataid="item.id" class="draggable">
                                                <a class="badge pull-left" style="color:white">{{index + 1}}</a>
                                                <div class="width-100">{{item.name}}</div><a :dataid="item.id" @click="deletevideo(item.id)" class="deleteVideo pull-right"><i class="glyphicon glyphicon-trash "></i></a>
                                            </div>
                                        </div>
                                        <input type="hidden" class="videoids form-control" name="videoids" v-model="myvideoids">
                                    </div>
                                </div>
                            </div>

                            <div class="row pull-right">
                                <button class="btn btn-success btnLoadAddVideo" data-toggle="modal" href="#foldermodal"> <i class="fa fa-plus"></i> Add folder</button>

                            </div> <br>
                            <br>

                            <!-- <div data-id="444444" class="row margin-top-10">
                                <div class="form-group col-md-2">
                                    <label>Selected General Folders</label>
                                </div>
                                <div class="form-group col-md-10">

                                    <div class="row col-md-12">
                                        <select name="generalfolderid[]" id="generalSelect" class="form-control myTagSelect" multiple="multiple">
                                            <?php foreach ($general_folders as $generalFolder) {
                                                $checked = (in_array($generalFolder['id'], $assginedfolder)) ? 'SELECTED' : '';
                                                echo '<option  ' . $checked . ' value="' . $generalFolder['id'] . '"  >' . $generalFolder['folder_name'] . '</option>';
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                            </div> -->

                            <input type="hidden" name="generalfolderid" id="generalFolderId" class="form-control generalFolderId" value="" />
                            <input type="hidden" name="btnSaveGeneralRoutineText" id="btnSaveGeneralRoutineText" value="" />
                            <?php if (isset($cleint_folders) && !empty($cleint_folders)) { ?>
                                <div data-id="555555" class="row margin-top-10">
                                    <!-- <div class="form-group col-md-2">
                                        <label>Choose your clients </label>
                                    </div>

                                    <div class="form-group col-md-10">

                                        <div class="row col-md-12">
                                            <select id="clientSelect" placeholder="Click To Add" multiple class="form-control folders clientfolders myTagSelect" name="clientfolderid[]">
                                                <?php

                                                foreach ($cleint_folders as $clientfolder) {
                                                    if ($client_id > 0) {
                                                        // $selected = (in_array($client_id, $clientfolder)) ? 'selected' : '';
                                                        $selected = ($client_id == $clientfolder['client_id']) ? 'selected' : '';
                                                    } else {
                                                        $selected = (in_array($clientfolder['id'], $assginedfolder)) ? 'selected' : '';
                                                    }

                                                    echo '<option data-client ="' . $clientfolder['id'] . '" data-clientid ="' . $clientfolder['client_id'] . '" value="' . $clientfolder['id'] . '" ' . $selected . '>' . $clientfolder['folder_name'] . '</option>';
                                                } ?>
                                            </select>
                                        </div>
                                    </div> -->


                                <?php } ?>

                                <div class="form-group col-md-12">
                                    <!--<h3>To create the routine select any videos from any of these folders</h3>-->
                                </div>

                                <div id="footer" class="myfloatingbutton">
                                    <?PHP
                                    if ($adding) {
                                    ?>
                                        <div id="checkSaveRoutine" class="pull-right btn btn-success" style="margin: 3px;">Save Client Routine</div>
                                        <button type="submit" id="btnSaveExercise" style="display:none;" class="pull-right btn btn-success btnSaveExercise">Save Client Routine</button>

                                        <button id="btnSaveGeneralRoutine" class="btn btn-success btnSaveGeneralRoutine" data-toggle="modal" href="#generalRoutineModel" style="margin: 3px;">Save General Routine</button>
                                        <button id="btnSaveGeneralAndClientRoutine" class="btn btn-success btnSaveGeneralAndClientRoutine" data-toggle="modal" href="#generalRoutineModel" style="margin: 3px;">Save General and Client Routine</button>
                                    <?PHP
                                    } else {
                                    ?>
                                        <div class=" btn btn-success submit-form saveAsNew" url="<?php echo base_url('admin/exercises/addNewExercise') ?>" data-toggle="modal" href="#saveNewRoutineModel">Save as New</div> &nbsp;&nbsp;&nbsp;
                                        <button id="btnSaveasnew" style="display:none;" type="submit"></button>
                                        <!-- <button id="btnSaveGeneralRoutine" class="btn btn-success btnSaveGeneralRoutine" data-toggle="modal" href="#generalRoutineModel" style="margin: 3px;">Save General Routine</button> -->
                                        
                                        <!--<div id="btnupdateuser" class=" btn submit-form btn-success btnupdateuser" data-toggle="modal" href="#updateRoutineModel" url="<?php echo base_url('admin/exercises/UpdateExercise') ?>">Update</div>-->
                                        <div class=" btn submit-form btn-success btnupdateuser" style="margin: 3px;" url="<?php echo base_url('admin/exercises/UpdateExercise') ?>" id="btnUpdateAsClient">Update As Client</div>
                                        <div class=" btn submit-form btn-success btnupdateuser" style="margin: 3px;" url="<?php echo base_url('admin/exercises/UpdateExercise') ?>" id="btnUpdateAsGeneralRoutine" data-toggle="modal" href="#updateRoutineModel">Update As General Routine</div>
                                        <div class=" btn submit-form btn-success btnupdateuser" style="margin: 3px;" url="<?php echo base_url('admin/exercises/UpdateExercise') ?>" id="btnUpdateAsBoth" data-toggle="modal" href="#updateRoutineModel">Update As Client And General Routine</div>
                                        <div id="btnUp" @click="goUp" class="pull-left"><img src="/assets/custom/images/arrow_up.png" style="height: 45px;position: absolute;right: 7px;bottom: 1px;" /></div>
                                    <?PHP
                                    }

                                    ?>
                                </div>


                                <div class="row">
                                    <div data-id="222222" class="col-md-6">

                                        <img class="<?php echo ($isgeneral == true) ? 'hidden' : '' ?>" onclick="showMe(this)" data-toggle="yes" src="/assets/custom/images/showme.jpg" style="height: 25px;float: left;margin-right: 8px;cursor: pointer;" />
                                        <h4>General Routines Video</h4>
                                        <div id="videos-container">

                                            <div class="generalvideoslist videolist">
                                                <div class="form-group col-md-10">
                                                    <select v-model="mGeneralSelect" class="form-control generalfolderslist">
                                                        <option v-for="(item,index) in generalCategories" :key="index" :value="item.id" data-id="index" :data-foldername="item.foldername">{{item.foldername}}</option>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div data-id="11111111" class="col-md-6">
                                        <div v-if="clientVideos" class=" <?php echo ($isgeneral == true) ? 'hidden' : '' ?>">
                                            <h4>Client Videos</h4>
                                        </div>
                                        <div class="clientvideoslist videolist ">
                                            <div v-if="clientVideos" class="form-group col-md-10">
                                                <select id="clientfolderslist" class="form-control clientfolderslist <?php echo ($isgeneral == true) ? 'hidden' : '' ?>">
                                                    <?php foreach ($client_videos as $k => $evv) {
                                                        $class = '';
                                                        foreach ($evv as $ev) {

                                                            if (in_array($ev['id'], $assginedvideos)) {
                                                                $class = 'selected';
                                                                break;
                                                            }
                                                        }

                                                        echo '<option value="' . $k . '" ' . $class . '>' . $k . '</option>';
                                                    } ?>
                                                </select>
                                            </div>
                                            <div v-else class="form-group col-md-10 <?php echo ($isgeneral == true) ? 'hidden' : '' ?>">
                                                No Client Video Found
                                                <a :href="`/admin/folders/detail/${companyVideoFolderId}?ref=${path}`">
                                                    <div class="btn btn-success">Upload Video</div>
                                                </a>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4"></div>
                                            </div><br><br>
                                        </div>
                                    </div>
                                    <div id="generalvideosfolder" v-if="folderName" class="row">
                                        <div class="col-md-12">
                                            <h3>{{folderName}}<span class="badge" style="color: white;margin-left: 7px;padding-top: -11px;">{{currentRoutineCount}}</span></h3>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12" style="margin-top: 15px; margin-bottom: 15px;">
                                                <input class="form-control videosearch" placeholder="Filter Video Name" v-model="filterVideoName" name="vido_search" type="text">
                                            </div><br />
                                            <div v-for="(item,index) in arrGeneralVideos" :key="index" v-show="filterVideoName == '' || item.title.toLowerCase().indexOf(filterVideoName.toLowerCase()) > -1" class="myroutineselector col-xs-6 col-md-4 col-lg-4">
                                                <div class="widget widget-inverse">
                                                    <div @click="selectRoutineVideo(item)" :class="`widget-head routineselector ${item.selected}`" :id="`video-${item.id}`" :data-videoid="item.id" :data-videoname="item.title">{{item.title}}</div>
                                                    <div data-id="1111111" class="widget-body padding-none text-center">
                                                        <div :id="`mythumb_${item.id}`" data-selected="" class="videoThumb" :style='`background-image: url(/assets/uploads/exercises/thumbnails/${item.thumbnail}`' :data-thumb="`/assets/uploads/exercises/thumbnails/${item.thumbnail}`" :data-title="item.title" @click="playSelectedVideo(item)" :data-id="item.id" :data-source="`/assets/uploads/exercises/${item.name}`">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-if="clientVideos" class="publicvideoslist videolist <?php echo ($isgeneral == true) ? 'hidden' : '' ?>">
                                        <div id="clientvideosfolder" class="row">
                                            <h3>{{clientSelect}} Videos</h3>
                                            <div class="row">
                                                <div class="col-md-12" style="margin-top: 15px; margin-bottom: 15px;">
                                                    <input class="form-control videosearch" placeholder="Filter Client Video Name" v-model="filterClientVideoName" name="vido_search" type="text">
                                                </div><br />
                                                <div v-for="(item,index) in clientVideos" :key="index" v-show="filterClientVideoName == '' || item.title.toLowerCase().indexOf(filterVideoName.toLowerCase()) > -1" class="myroutineselector col-xs-6 col-md-4 col-lg-4">
                                                    <div class="widget widget-inverse">
                                                        <div @click="selectRoutineVideo(item)" :class="`widget-head routineselector ${item.selected}`" :id="`video-${item.id}`" :data-videoid="item.id" :data-videoname="item.title">{{item.title}}</div>
                                                        <div data-id="1111111" class="widget-body padding-none text-center">
                                                            <div :id="`mythumb_${item.id}`" data-selected="" class="videoThumb" :style='`background-image: url(/assets/uploads/exercises/thumbnails/${item.thumbnail}`' :data-thumb="`/assets/uploads/exercises/thumbnails/${item.thumbnail}`" :data-title="item.title" @click="playSelectedVideo(item)" :data-id="item.id" :data-source="`/assets/uploads/exercises/${item.name}`">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <?php echo form_close(); ?>

                                </div>
                        </div>

                    </div>
                    <!--Model user details-->
                    <!-- /.modal-dialog -->
                    <div id="deleteWarning" class="modal fade">
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
                                    <button type="button" class="btn btn-danger modeldeleteyes" data-action="" data-objectid data-dismiss="modal">Yes</button>
                                    <button type="button" class="btn btn-success no" data-dismiss="modal">No</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!--Model user details-->
                    <!-- /.modal-dialog -->
                    <div id="showVideo" v-if="showVideo" class="modal fade">
                        <div class="modal-dialog new-modal-dialog custom-modal">
                            <div class="modal-content">
                                <!-- dialog body -->
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Video Preview: <span id="titleVideo">{{activeItem.title}}</span></h4>
                                </div>
                                <div style="display: flex;">
                                    <video :key="activeItem.name" width="100%" height="100%" controls preload="none" allowfullscreen="false" :poster="`/assets/uploads/exercises/thumbnails/${activeItem.thumbnail}`">
                                        <source id="videoSource" :src="`/assets/uploads/exercises/${activeItem.name}`">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                                <!-- dialog buttons -->
                                <div class="modal-footer">
                                    <button id="insertBtn" @click="selectRoutineVideo(activeItem)" type="button" color="blue" class="btn btn-primary" data-action="" data-dismiss="modal"> {{activeText}}</button>
                                    <button type="button" @click="resetVideo" class="btn btn-danger" data-action="" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="foldermodal">
                        <div class="modal-dialog new-modal-dialog">
                            <div class="modal-content">
                                <?php echo form_open(base_url('admin/folders/addgeneralfolderajax'), array('class' => 'addgeneralfolder')); ?>

                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4>Create new folder</h4>
                                </div>
                                <div class="modal-body">

                                    <div class="form-body clearfix col-md-12">
                                        <div class="col-md-12">

                                            <div data-id="666666" class="row margin-top-10">
                                                <div class="form-group col-md-3">
                                                    <label>Folder Name</label>
                                                </div>
                                                <div class="form-group col-md-9">
                                                    <input class="form-control foldername" name="foldername" placeholder="Folder name" type="text" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="clearfix"></div>

                                </div>
                                <div class="modal-footer">
                                    <div class="form-group col-md-12 text-center">
                                        <button type="button" class="btn btn-success btnAddnewfolder">Add</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="generalRoutineModel">
                        <div class="modal-dialog new-modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4>General Routine Folder</h4>
                                </div>
                                <div data-id="444444" class="row" style="margin: 12px;">
                                    <div class="form-group col-md-2">
                                        <label>Selected General Folders</label>
                                    </div>
                                    <div class="form-group col-md-10">
                                        <div class="row col-md-12">
                                            <select name="generalfolderid[]" id="generalSelect" class="form-control myTagSelect" multiple="multiple">
                                                <?php foreach ($general_folders as $generalFolder) {
                                                    $checked = (in_array($generalFolder['id'], $assginedfolder)) ? 'SELECTED' : '';
                                                    echo '<option  ' . $checked . ' value="' . $generalFolder['id'] . '"  >' . $generalFolder['folder_name'] . '</option>';
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="form-group col-md-12 text-center">
                                        <button type="submit" class="btn btn-success checkSaveGeneralRoutine" id="checkSaveGeneralRoutine">Add</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="updateRoutineModel">
                        <div class="modal-dialog new-modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4>General Routine Folder</h4>
                                </div>
                                <div data-id="444444" class="row" style="margin: 12px;">
                                    <div class="form-group col-md-2">
                                        <label>Selected General Folders</label>
                                    </div>
                                    <div class="form-group col-md-10">
                                        <div class="row col-md-12">
                                            <select name="generalfolderid[]" id="generalSelectRoutine" class="form-control myTagSelect" multiple="multiple">
                                                <?php foreach ($general_folders as $generalFolder) {
                                                    $checked = (in_array($generalFolder['id'], $assginedfolder)) ? 'SELECTED' : '';
                                                    echo '<option  ' . $checked . ' value="' . $generalFolder['id'] . '"  >' . $generalFolder['folder_name'] . '</option>';
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="form-group col-md-12 text-center">
                                        <button type="submit" class="btn btn-success checkUpdateGeneralRoutine" id="checkUpdateGeneralRoutine">Add</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="saveNewRoutineModel">
                        <div class="modal-dialog new-modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4>General Routine Folder</h4>
                                </div>
                                <div data-id="444444" class="row" style="margin: 12px;">
                                    <div class="form-group col-md-2">
                                        <label>Selected General Folders</label>
                                    </div>
                                    <div class="form-group col-md-10">
                                        <div class="row col-md-12">
                                            <select name="generalfolderid[]" id="saveNewSelectRoutine" class="form-control myTagSelect" multiple="multiple">
                                                <?php foreach ($general_folders as $generalFolder) {
                                                    $checked = (in_array($generalFolder['id'], $assginedfolder)) ? 'SELECTED' : '';
                                                    echo '<option  ' . $checked . ' value="' . $generalFolder['id'] . '"  >' . $generalFolder['folder_name'] . '</option>';
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="form-group col-md-12 text-center">
                                        <button type="submit" class="btn btn-success saveNewGeneralRoutine" id="saveNewGeneralRoutine">Add</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <?php include 'footer.php'; ?>

                <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
                <script src="/assets/custom/dist/js/BsMultiSelect.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>

                <script>
                    var videosid = [];
                    var videosname = [];
                    var selectedVideos = [];
                    var generalData = '';
                    var updateGeneralData = '';
                    <?php if (!empty($assginedvideosname)) {
                        foreach ($assginedvideosname as $key => $name) {
                    ?>
                            $vname = "<?php echo $name ?>";
                            $vid = "<?php echo $assginedvideos[$key] ?>";
                            videosname.push($vname);
                            selectedVideos.push({
                                name: $vname,
                                id: $vid
                            })
                        <?php
                        }
                    }
                    if (!empty($assginedvideos)) {
                        foreach ($assginedvideos as $key => $vid) {
                        ?>
                            $vid = <?php echo $vid ?>;
                            videosid.push($vid);
                    <?php
                        }
                    }
                    ?>

                    var app = new Vue({
                        el: '#myapp',
                        data: {
                            message: '',
                            arrGeneralVideos: [],
                            folderName: '',
                            filterVideoName: '',
                            filterClientVideoName: '',
                            assignVideos: [],
                            generalCategories: [],
                            mGeneralSelect: '',
                            companyId: 3,
                            clientVideos: [],
                            clientSelect: '',
                            currentRoutineCount: 0,
                            client_id: '',
                            exercise_id: '',
                            activeItem: {},
                            showVideo: false,
                            activeText: 'Insert',
                            patient_id: '',
                            routineName: '',
                            companyVideoFolderId: '',
                            path: '',
                        },
                        computed: {
                            myvideoids: function() {
                                return this.assignVideos.map(function(item) {
                                    return item.id
                                })
                            }
                        },
                        watch: {
                            mGeneralSelect: function(val) {
                                this.changeGeneral()
                            }
                        },
                        created() {
                            var self = this
                            this.clientSelect = $("#clientfolderslist").val()
                            this.assignVideos = selectedVideos
                            this.companyId = '<?PHP echo $this->session->userdata('companyid'); ?>';
                            this.getGeneralCategories()
                            this.getClientVideos()
                            this.client_id = '<?PHP echo $client_id; ?>'
                            this.exercise_id = '<?PHP echo $exercise_id; ?>'
                            this.patient_id = '<?PHP echo $patient_id; ?>'
                            this.companyVideoFolderId = '<?PHP echo $companyVideoFolderId; ?>'
                            this.path = '<?PHP echo $path; ?>'
                            this.routineName = `<?php echo $details['name']; ?>`
                            if (!this.patient_id) {
                                this.patient_id = "<?PHP echo $assginedfolder[0]; ?>"
                            }

                            self.mGeneralSelect = videosid[0]
                            setTimeout(myFunction, 2000)

                            function myFunction() {
                                self.changeGeneral()
                            }


                        },
                        methods: {
                            goUp: function() {
                                window.scrollTo(0, 0);
                            },
                            resetVideo: function() {
                                //this.activeItem = {};
                            },
                            deletevideo: function(id) {
                                var assignVideo = this.assignVideos;
                                var key = '';
                                for (var f in assignVideo) {
                                    if (assignVideo[f].id == id) {
                                        key = f;
                                    }
                                }
                                if (key != '') {
                                    this.$delete(this.assignVideos, key);
                                }
                            },
                            playSelectedVideo: function(item) {
                                this.activeItem = item
                                if (item.selected == "selected") {
                                    this.activeText = "Remove"
                                } else {
                                    this.activeText = "Insert"
                                }
                                $("#showVideo").modal('show');
                                this.showVideo = true
                                /*
                                				
                                			    var video = document.getElementsByTagName('video')[0];
                                			    video.load();
                                */
                            },
                            selectRoutineVideo: function(item) {
                                var self = this
                                $this = $(this);
                                var videoid = item.id
                                var videoname = item.title;

                                if (item.selected == 'selected') {
                                    item.selected = ''
                                    this.assignVideos = this.assignVideos.filter(function(myitem) {
                                        return item.id != myitem.id
                                    })
                                    self.currentRoutineCount--
                                } else {
                                    self.assignVideos.push({
                                        id: item.id,
                                        name: videoname
                                    })
                                    item.selected = 'selected'
                                    self.currentRoutineCount++
                                }

                                $('.videoids').val(videosid);
                                $('.videonames').val(videosname);

                            },
                            getClientVideos: function() {
                                var self = this
                                var form = new FormData();
                                form.append("companyId", self.companyId);
                                //TODO REPLACE WITH Client ID
                                form.append("client_id", <?PHP echo $client_id; ?>);

                                var settings = {
                                    "url": "api/users/getClientVideos",
                                    "method": "POST",
                                    "timeout": 0,
                                    "headers": {},
                                    "processData": false,
                                    "mimeType": "multipart/form-data",
                                    "contentType": false,
                                    "data": form
                                };

                                $.ajax(settings).done(function(response) {
                                    var arrData = JSON.parse(response)
                                    var mydata = arrData.client_videos;
                                    self.clientVideos = mydata
                                    if (self.clientVideos) {
                                        self.clientVideos.forEach(function(item) {
                                            const found = self.assignVideos.find(element => element.id == item.id)
                                            item.selected = item.id
                                            if (found) {
                                                console.log("SELECTED" + item.id)
                                                item.selected = 'selected'
                                            }
                                        })
                                    }


                                });

                            },
                            getGeneralCategories: function() {
                                var self = this
                                var form = new FormData();
                                form.append("companyId", self.companyId);

                                var settings = {
                                    "url": "api/users/getGeneralCategory",
                                    "method": "POST",
                                    "timeout": 0,
                                    "processData": false,
                                    "contentType": false,
                                    "data": form
                                };

                                $.ajax(settings).done(function(response) {
                                    var arrData = JSON.parse(response)
                                    var mydata = arrData.general_videos;
                                    self.generalCategories = mydata
                                });

                            },
                            changeGeneral: function() {

                                var folderName1 = $('.generalfolderslist option:selected').attr("data-foldername");

                                var self = this
                                var form = new FormData();
                                form.append("companyId", self.companyId);
                                form.append("folderName", folderName1);
                                self.folderName = folderName1
                                if (folderName1) {


                                    var settings = {
                                        "url": "/api/users/getGeneralByFolderName",
                                        "method": "POST",
                                        "timeout": 0,
                                        "headers": {},
                                        "processData": false,
                                        "mimeType": "multipart/form-data",
                                        "contentType": false,
                                        "data": form
                                    };

                                    $.ajax(settings).done(function(response) {
                                        window.scrollTo(0, $(".generalfolderslist").offset().top - 80);

                                        self.currentRoutineCount = 0
                                        var arrData = JSON.parse(response)
                                        var mydata = arrData.general_videos;
                                        self.arrGeneralVideos = mydata[0]
                                        self.arrGeneralVideos.forEach(function(item) {
                                            const found = self.assignVideos.find(element => element.id == item.id)
                                            item.selected = item.id
                                            if (found) {
                                                self.currentRoutineCount++
                                                console.log("SELECTED" + item.id)
                                                item.selected = 'selected'
                                            }
                                        })
                                    });
                                } //End 

                            }
                        }
                    })
                </script>

                <script>
                    var base_url = '<?php echo base_url(); ?>';
                    var base_url_Plimageupload = '<?php echo base_url('admin/exercises/Pluploader'); ?>';
                    <?php
                    $exercise_videos = [];

                    if (!empty($exercise_videos)) {
                        foreach ($exercise_videos as $exc) {
                    ?>
                            $('.ex_list_to').append('<option value="<?php echo $exc['id']; ?>"> <?php echo  str_replace("'", "", $exc['title']); ?></option>');
                            $exercise_videos.push({
                                'id': <?php echo $exc['id']; ?>,
                                'name': '<?php echo  str_replace("'", "", $exc['title']); ?>',
                                'title': '<?php echo $exc['name']; ?>'
                            });
                    <?php
                        }
                    }
                    ?>


                    $('#clientSelect').on('change', function(e) {
                        var selectedClientID = [];
                        $('#clientSelect option:selected').each(function() {
                            selectedClientID.push($(this).data("clientid"));
                        });
                        var result = selectedClientID.toString();
                        console.log(result);
                        $('#patientId').val(result);
                    });

                    $order = 1;
                    showMe = function(me) {
                        var status = $(me).attr("data-toggle")
                        if (status == "yes") {
                            $(me).attr("src", '/assets/custom/images/hideme.png')
                            $(me).attr("data-toggle", 'no')
                            $("#generalvideosfolder").hide();
                        } else {
                            $("#generalvideosfolder").show();
                            $(me).attr("src", '/assets/custom/images/showme.jpg')
                            $(me).attr("data-toggle", 'yes')
                        }
                        console.log(status)

                    }
                    // delete warning model
                    $(document).on('click', '.deleteBtn', function() {
                        var objectid = $(this).attr('data-objectid');
                        var object_name = $(this).attr('data-objectname');
                        var action = $(this).data('action');
                        $(".modeldeleteyes").attr('data-objectid', objectid);
                        $(".modeldeleteyes").attr('data-objectname', object_name);
                        $(".modeldeleteyes").attr('data-action', action);
                        $("#deleteWarning p").html("Do you realy want to delete this Routine <strong>" + object_name + "</strong>?");
                        $("#deleteWarning").modal('show');
                        return false;
                    });

                    var activeDataId = "";
                    var myDataSelected = false;
                    insertBtn = function() {
                        $("#video-" + activeDataId).click()
                    }

                    $("#generalSelect").change(function(item) {
                        console.log($("#generalSelect").val().length)
                    })

                    //if user accept to delete park from model then process request
                    $(document).on('click', '.modeldeleteyes', function() {
                        var objectid = $('.modeldeleteyes').attr('data-objectid');
                        var object_name = $('.modeldeleteyes').attr('data-objectname');
                        var action = $('.modeldeleteyes').attr('data-action');
                        $.ajax({
                            type: 'POST',
                            url: base_url + 'admin/exercises/deleteExercise/' + objectid,
                            success: function(deleteAction) {
                                var deleteuserdata = JSON.parse(deleteAction);
                                var extraMessageHtml = "";
                                if (deleteuserdata['status'] == true) {
                                    extraMessageHtml = '<div class="alert alert-success">Routine <strong>' + object_name + '</strong> deleted successfully<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
                                } else {
                                    extraMessageHtml = '<div class="alert alert-danger">Error while deleting Routine <strong>' + object_name + '</strong> <button type="button" class="close" data-dismiss="alert">&times;</button></div>';
                                }
                                $('.extraCustomMessage').html(extraMessageHtml);
                                $('#exercise-' + objectid).fadeOut(1500);
                                return false;
                            },
                            error: function(data) {
                                console.log(data);
                            }
                        });
                    });
                    $(document).on('click', '.btnAddExercise', function() {
                        $('.btnSaveExercise').removeClass('hidden');

                        $('.btnupdateuser').addClass('hidden');
                        //reset field values
                        $('.exerciseid').val("");
                        $('.exercise_name').val("");
                        $('.exercise_description').val("");
                        $('.uploadedVideosDisplayArea').html('');
                        $('.btnAddNewVideo').removeAttr('data-exerciseid');
                        $('.selectNewVideo').val("");
                        $('.assignes_ex_div').html('');
                        $order = 1;
                        $('#ex_list_to').find('option').remove();
                        for (var key in $exercise_videos) {
                            var id = $exercise_videos[key]['id'];
                            var text = $exercise_videos[key]['name'];
                            $('#ex_list_to').append('<option value="' + id + '">' + text + '</option>');
                        }

                    });
                    $('#videoUploadModal').on('shown.bs.modal', function() {
                        $('.has-error').children('p').remove('p');
                        $('.has-error').removeClass('has-error');
                    });

                    //btn get exercise details
                    $(document).on('click', '.btnExerciseDetails', function() {
                        $('.fullscreendiv').removeClass('hidden');
                        var objectid = $(this).attr('data-objectid');
                        $('.btnSaveExercise').addClass('hidden');
                        $('.btnupdateuser').removeClass('hidden');

                        $('#ex_list_to').find('option').remove();
                        for (var key in $exercise_videos) {
                            var id = $exercise_videos[key]['id'];
                            var text = $exercise_videos[key]['name'];
                            $('#ex_list_to').append('<option value="' + id + '">' + text + '</option>');
                        }
                        $.ajax({
                            type: 'POST',
                            url: base_url + 'admin/exercises/getExerciseDetails/' + objectid,
                            success: function(actionResponse) {
                                var exerciseData = JSON.parse(actionResponse);
                                $('.uploadedVideosDisplayArea').html('');
                                $('.exerciseid').val(objectid);
                                $('.exercise_name').val(exerciseData['data']['details']['name']);
                                $('.exercise_description').val(exerciseData['data']['details']['description']);
                                $('.btnAddNewVideo').attr('data-exerciseid', objectid);
                                var ex_videos = exerciseData['data']['videos'];
                                var ex_videos_len = ex_videos.length;
                                $order = 1;
                                $('.assignes_ex_div').html('');
                                for (var i = 0; i < ex_videos_len; i++) {
                                    var id = ex_videos[i]['id'];
                                    //var name = ex_videos[i]['name'];
                                    var title = ex_videos[i]['title'];
                                    var orderno = ex_videos[i]['order'];

                                    var appen_html = '<label class="label label-info" style=" margin-right:5px">' +
                                        '<button type="button" style="padding-left:5px;" class="close btnRemoveExc" data-id="' + id + '" data-text="' + title + '">&times;</button>' +
                                        '<span style="line-height: 30px;">' + title + '</span>' +
                                        '<input type="hidden" name="assigned_video[]" class="assigned_video" value="' + id + '"/>' +
                                        '<input type="hidden" name="assigned_video_order[]" class="assigned_video_order" value="' + orderno + '"/>' +
                                        '</label></div>';
                                    $('.assignes_ex_div').append(appen_html);

                                    $('#ex_list_to option[value=' + id + ']').remove();
                                    $order = orderno;
                                }
                                $('.fullscreendiv').addClass('hidden');
                                $('#responsiveExercisedetails').modal('show');
                            },
                            error: function(data) {
                                console.log(data);
                            }
                        });
                    });


                    //btn get exercise details
                    $(document).on('click', '.btnAddnewfolder', function(e) {
                        e.preventDefault();
                        $url = $('.addgeneralfolder').attr('action');
                        $.ajax({
                            url: $url,
                            type: "post",
                            data: $('.addgeneralfolder').serialize(),
                            dataType: 'json',
                            success: function(response) {
                                if (response.success == true) {
                                    $('#foldermodal').modal('hide');

                                } else {
                                    $('#foldermodal').modal('hide');
                                }
                                // you will get response from your php page (what you echo or print)                 
                                alert("General Folder Added")
                                $("#generalSelect").bsMultiSelect("Dispose");
                                $("#generalSelect").prepend("<option SELECTED value='" + response.folder_id + "'>" + response.folder_name + "</option>")
                                $("#generalSelect").bsMultiSelect("UpdateData");
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.log(textStatus, errorThrown);
                                $('#foldermodal').modal('hide');
                            }
                        });
                    });


                    $('#responsiveExercisedetails').on('hidden.bs.modal', function() {
                        $('.has-error').children('p').remove('p');
                        $('.has-error').removeClass('has-error')
                    });


                    //perform validation..
                    $(document).on('ready', function() {
                        $(".myTagSelect").bsMultiSelect();


                        $("#clientfolderslist").click(function() {
                            window.scroll(0, $("#clientvideosfolder").offset().top - 50)
                        })
                        $('.exerciseForm').validate({
                            ignore: "not:hidden",
                            rules: {
                                name: "required",
                                videoids: "required",
                            },
                            messages: {
                                name: "Exercise name should not be blank",
                                videoids: "Plese select atleast one video from listed videos"
                            }
                        });
                        $('.crud_add_video').validate({
                            rules: {
                                title: "required",
                                modal_video_name: "required"
                            },
                            messages: {
                                title: "Routine name should not be blank",
                                modal_video_name: "Please select Routine video"
                            }
                        });
                    })

                    $("#routineName").keyup(function() {
                        $("#routineName").attr("style", '');
                        $("#routineNameMessage").hide();

                    })

                    function checkUserExist(clickme) {
                        var form = new FormData();
                        form.append("name", $("#routineName").val());
                        form.append("routineId", $("#exerciseid").val());

                        var settings = {
                            "url": "/api/users/checkExerciseName",
                            "method": "POST",
                            "timeout": 0,
                            "headers": {
                                "accept": "application/json",
                                "Access-Control-Allow-Origin": "*"
                            },
                            "crossDomain": true,
                            "processData": false,
                            "mimeType": "multipart/form-data",
                            "contentType": false,
                            "data": form
                        };

                        $.ajax(settings).done(function(response) {
                            if (parseInt(response) > 1) {
                                $("#routineName").attr("style", 'border : 1px solid red')
                                $("#routineNameMessage").show();
                                window.scrollTo(500, 0);
                                var flashInterval;

                                $('#routineName').hover(
                                    function() {
                                        flashInterval = setInterval(function() {
                                            $('#routineName').toggleClass('red-border');
                                        }, 1000);
                                    },
                                    function() {
                                        clearInterval(flashInterval);
                                        $('#routineName').removeClass('red-border');
                                    });

                            } else {
                                console.log("SUBMIT NOW");
                                $("#" + clickme).click()
                            }
                        });
                    }

                    $("#checkSaveRoutine").click(function() {
                        if($('#clientSelect').val() == null){
                            alert('Please Select Client');
                        }else{
                            checkUserExist("btnSaveExercise");
                        }
                    });

                    $("#btnSaveGeneralRoutine").click(function() {
                        $('#btnSaveGeneralRoutine').show('generalRoutineModel')
                        generalData = '1';
                        // console.log('generalData', generalData);
                    });

                    $("#checkSaveGeneralRoutine").click(function() {
                        var folder_ids = $('#generalSelect').val();
                        $('#btnSaveGeneralRoutineText').val(generalData);
                        $('#generalFolderId').val(folder_ids);
                        if(generalData){
                            if($('#clientSelect').val() == null){
                                alert('Please Select Client');
                                $('#generalRoutineModel').modal('toggle');
                            }else{
                                if($('#generalSelect').val() == null)
                                {
                                    alert('Please Select General Folder');
                                }else{
                                    checkUserExist("btnSaveExercise");
                                }
                            }                             
                        }
                    });

                    $("#btnupdateuser").click(function() {
                        $('#btnSaveGeneralRoutine').show('updateRoutineModel')
                        //checkUserExist("btnSaveasnew");
                        // $("#btnSaveasnew").click()
                    });
                    
                    $("#btnUpdateAsClient").click(function() {                        
                        if($('#clientSelect').val() == null){
                            alert('Please Select Client');
                        }else{
                            $("#btnSaveasnew").click();
                        }
                    });

                    $("#btnUpdateAsGeneralRoutine").click(function() {
                        $('#btnSaveGeneralRoutine').show('updateRoutineModel');                        
                        updateGeneralData = '1';
                    });
                    
                    $("#btnUpdateAsBoth").click(function() {
                        $('#btnSaveGeneralRoutine').show('updateRoutineModel');                        
                        updateGeneralData = '2';                            
                    });
                    
                    $("#checkUpdateGeneralRoutine").click(function() {
                        var folder_ids = $('#generalSelectRoutine').val();                        
                        $('#btnSaveGeneralRoutineText').val(updateGeneralData);
                        $('#generalFolderId').val(folder_ids);
                        if(updateGeneralData){
                            if($('#clientSelect').val() == null){
                                alert('Please Select Client');
                                $('#updateRoutineModel').modal('toggle');
                            }else{
                                if($('#generalSelectRoutine').val() == null)
                                {
                                    alert('Please Select General Folder');
                                }else{
                                    $("#btnSaveasnew").click()
                                }
                            }                             
                        }
                        // if($('#generalSelectRoutine').val() == null && $('#clientSelect').val() == null){
                        //     $('#updateRoutineModel').modal('toggle');
                        //     alert('Please Select Atleast Client Name Of General Folder');
                        // }else{
                        //     $("#btnSaveasnew").click()
                        // }
                        // $("#btnSaveasnew").click()
                    });

                    $("#btnSaveGeneralAndClientRoutine").click(function() {
                        $('#btnSaveGeneralRoutine').show('generalRoutineModel');
                        generalData = '2';
                    });

                    $(".submit-form").click(function() {
                        var form_url = $(this).attr('url');
                        $(".exerciseForm").attr('action', form_url);
                        console.log(form_url);
                        validateeditexForm();
                        $(".exerciseForm").submit();
                        return false;
                    })

                    $(document).on('click', '.saveAsNew', function(event) {
                        $('#btnSaveGeneralRoutine').show('saveNewRoutineModel');                    
                    });
                    
                    $("#saveNewGeneralRoutine").click(function() {                        
                        var folder_ids = $('#saveNewSelectRoutine').val();  
                        console.log('folder_ids', folder_ids);                      
                        $('#btnSaveGeneralRoutineText').val(generalData);
                        $('#generalFolderId').val(folder_ids);
                        var form = new FormData();
                        form.append("name", $("#routineName").val());
                        form.append("routineId", $("#exerciseid").val());

                        var settings = {
                            "url": "api/users/checkExerciseName",
                            "method": "POST",
                            "timeout": 0,
                            "headers": {},
                            "processData": false,
                            "mimeType": "multipart/form-data",
                            "contentType": false,
                            "data": form
                        };

                        $.ajax(settings).done(function(response) {
                            console.log(response);
                            // alert(parseInt(response))
                            if (parseInt(response) > 0) {
                                $("#routineName").attr("style", 'border : 1px solid red')
                                $("#routineNameMessage").show();
                                window.scrollTo(500, 0);
                            } else {
                                console.log("SUBMIT NOW");
                                $(this).parents('form').attr('action', $(this).attr('url'));
                                 if($('#saveNewSelectRoutine').val() == null && $('#clientSelect').val() == null){
                                     $('#saveNewRoutineModel').modal('toggle');
                                    alert('Please Select Atleast Client Name Of General Folder');
                                }else{
                                    $("#btnSaveasnew").click()
                                }
                            }
                        });
                    });


                    $(document).on('click', '.btnaddselectex', function() {
                        $(".ex_list_to option:selected").each(function() {
                            var optionValue = $(this).val();
                            var optionText = $(this).text();
                            console.log("optionText", optionText);
                            // collect all values
                            var appen_html = '<label class="label label-info" style=" margin-right:5px">' +
                                '<button type="button" style="padding-left:5px;" class="close btnRemoveExc" data-id="' + optionValue + '" data-text="' + optionText + '">&times;</button>' +
                                '<span style="line-height: 30px;">' + optionText + '</span>' +
                                '<input type="hidden" name="assigned_video[]" class="assigned_video" value="' + optionValue + '"/>' +
                                '<input type="hidden" name="assigned_video_order[]" class="assigned_video_order" value="' + $order + '"/>' +
                                '</label></div>';
                            $('.assignes_ex_div').append(appen_html);
                            $order++;
                            //remove this option
                            $(this).remove();
                        });

                    });

                    $(document).on('click', '.btnRemoveExc', function() {
                        $(this).parent('label').remove();
                        //append this value and caption to list box
                        var id = $(this).attr('data-id');
                        var text = $(this).attr('data-text');
                        $('.ex_list_to').append('<option value="' + id + '">' + text + '</option>');

                    });


                    $(document).on('click', '.clientvideos', function() {
                        $(this).addClass('active');
                        $('.generalvideos').removeClass('active');
                        $('.publicvideos').removeClass('active');
                        var clientfolderslistlength = $('.clientfolderslist').children('option').length;
                        if (clientfolderslistlength > 0) {
                            $('.clientfolderslist').trigger('change');
                        }
                        $('.clientvideoslist').removeClass('hidden');
                        $('.clientvideoslist').fadeIn(300)
                        $('.generalvideoslist').fadeOut(300)
                        $('.publicvideoslist').fadeOut(300)


                    });
                    $(document).on('click', '.generalvideos', function() {

                        $(this).addClass('active');
                        $('.clientvideos').removeClass('active');
                        $('.publicvideos').removeClass('active');
                        var generalfolderslistlength = $('.generalfolderslist').children('option').length;
                        //  $('.generalfolderslist').trigger('change');
                        if (generalfolderslistlength > 0) {
                            $('.generalfolderslist').trigger('change');
                            console.info("5555555");
                        }
                        $('.generalvideoslist').removeClass('hidden');
                        $('.generalvideoslist').fadeIn(300)
                        $('.clientvideoslist').fadeOut(300)
                        $('.publicvideoslist').fadeOut(300)
                    });

                    $(document).on('click', '.publicvideos', function() {
                        $(this).addClass('active');
                        $('.clientvideos').removeClass('active');
                        $('.generalvideos').removeClass('active');
                        $('.publicvideoslist').removeClass('hidden');
                        $('.generalvideoslist').fadeOut(300)
                        $('.clientvideoslist').fadeOut(300)
                        $('.publicvideoslist').fadeIn(300)

                    });




                    function validateeditexForm() {

                        //$('.exerciseForm').attr('action', '');
                        var checkedfolders = [];
                        $('input.folders:select:selected').each(function() {
                            checkedfolders.push($(this).val());
                        });
                        $('input.folders:checkbox:checked').each(function() {
                            checkedfolders.push($(this).val());
                        });
                        if (checkedfolders.length <= 0) {
                            alert('Select any of the folder to create routine')
                            return false;
                        }

                    }


                    $('.videosearch').on('input', function() {

                        $this = $(this);
                        if ($this.val() == '') {
                            $this.parents('.videolist').find('.routineselector').parent().parent().removeClass('hidden');

                            return false;
                        }


                        $this.parents('.videolist').find('.routineselector').parent().parent().addClass('hidden');
                        $this.parents('.videolist').find('.routineselector').each(function() {
                            if ($(this).attr('data-videoname').toLowerCase().includes($this.val().toLowerCase())) {
                                $(this).parent().parent().removeClass('hidden');
                            }
                        });
                    });




                    $('.clientfolderslist').on('change', function(e) {
                        console.info("22222222");
                        var optionSelected = $("option:selected", this);
                        var valueSelected = this.value;
                        $('.clientvideosfolder').addClass('hidden');
                        $('.' + valueSelected).removeClass('hidden');
                    });


                    $("#generalfoldersearch").on('input', function(e) {
                        var value = this.value.toLowerCase().trim();
                        if (value == '') {
                            $(".generalfolders option").show();
                        }

                        $(".generalfolders option").hide();
                        $(".folders option").each(function() {

                            if ($(this).text().toLowerCase().trim().indexOf(value) >= 0) {
                                $(this).show();
                            }

                        });

                    });


                    $("#clientfoldersearch").on('input', function(e) {
                        var value = this.value.toLowerCase().trim();
                        if (value == '') {
                            $(".clientfolders option").show();
                        }

                        $(".clientfolders option").hide();
                        $(".clientfolders option").each(function() {

                            if ($(this).text().toLowerCase().trim().indexOf(value) >= 0) {
                                $(this).show();
                            }

                        });

                    });




                    $(document).ready(function() {

                        $(".droppable").sortable({
                            update: function(event, ui) {
                                Dropped();
                            }
                        });

                        $(document).on('click', '.draggable .deleteVideo', function() {
                            $this = $(this);
                            $videoname = $this.parent('.draggable').text();
                            $videoid = $this.attr('dataid');
                            $('#video-' + $videoid).removeClass('selected');
                            $('#Exreciseid' + $videoid).remove();
                            videosid.splice($.inArray(parseInt($videoid), videosid), 1);
                            videosname.splice($.inArray($videoname, videosname), 1);
                            $this.removeClass('selected');
                            $('.videoids').val(videosid);
                            $("#videoCount").html(jQuery(".draggable").length)
                        });

                    });



                    function Dropped(event, ui) {
                        videosid = [];
                        $(".draggable").each(function() {
                            videosid.push($(this).attr('dataid'))
                            $('.videoids').val(videosid);
                        });
                        $('.videoids').val(videosid);
                    }
                </script>

                <style>
                    #footer {
                        width: 100% !important;
                        left: 0px !important;
                        z-index: 10000;
                    }

                    .red-border {
                        border: 2px solid red;
                    }

                    .badge {
                        background-color: #0395E2;
                        margin-right: 5px;
                    }

                    .routineselector .widget-head i {
                        visibility: hidden;
                    }

                    .routineselector.selected .widget-head i {
                        visibility: visible;
                    }

                    .glyphicons.publicvideos,
                    .glyphicons.generalvideos,
                    .glyphicons.clientvideos {
                        cursor: pointer;
                    }

                    .videoThumb {
                        background-size: cover;
                        height: auto;
                        background-position: center center;
                        background-repeat: no-repeat;
                        cursor: pointer;
                        /* 				min-height: 140px; */
                        padding-top: 65%;
                    }

                    span {
                        padding-left: 10px;
                        padding-right: 10px;
                    }

                    .caret {
                        padding-left: 0px;
                        padding-right: 0px;
                    }

                    .custom-control-label {
                        margin-left: 5px;
                    }

                    .myfloatingbutton {
                        bottom: 40px !important;
                        height: unset !important;
                        line-height: unset !important;
                        padding: 10px 0px;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                    }

                    .widget .widget-head {
                        /*
	        line-height: 22px;
	        padding-left: 9px;
*/
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        line-height: 1.25;
                        padding: 0px 10px
                    }

                    .draggable {
                        background: #eee none repeat scroll 0 0;
                        border: 1px solid #000;
                        cursor: move;
                        font-weight: bold;
                        margin: 2px;
                        padding: 5px;
                        text-align: center;
                        display: flex;
                        align-items: center;
                        flex-wrap: nowrap;
                        line-height: 1.25;
                    }

                    .width-100 {
                        width: 100%
                    }

                    .deleteVideo {
                        margin-left: 10px
                    }

                    .custom-modal {
                        width: 90% !important;
                        height: 100% !important;
                        margin: auto;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    }

                    #showVideo {
                        z-index: 99999
                    }

                    #showVideo .modal-footer {
                        padding: 10px 20px 20px !important;
                        margin-top: 0px !important;
                    }

                    #showVideo .modal-title {
                        line-height: 1;
                    }
                </style>