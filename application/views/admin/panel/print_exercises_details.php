<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/admin/module.admin.page.index.min.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/custom/custom.css'); ?>" />
<script src="<?php echo base_url('assets/components/library/jquery/jquery.min.js?v=v1.2.3'); ?>"></script>
<script src="<?php echo base_url('assets/components/library/modernizr/modernizr.js?v=v1.2.3'); ?>"></script>
<script src="<?php echo base_url('assets/components/library/jquery-ui/js/jquery-ui.min.js?v=v1.2.3'); ?>"></script>
<script src="<?php echo base_url('assets/components/plugins/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js?v=v1.2.3'); ?>"></script>
<script src="<?php echo base_url('assets/components/plugins/browser/ie/ie.prototype.polyfill.js?v=v1.2.3'); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.12"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
<div id="content">
    <h1 class="bg-white content-heading border-bottom"><?php echo $folderdetails['folder_name']; ?></h1>
    <div class="innerAll spacing-x2">
        <table class="dynamicTable tableTools table table-striped checkboxs">
            <thead>
                <tr class="text-center">
                    <th>Name</th>
                    <th>Name of videos</th>
                    <th>Image</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($exercise_name)) {
                    foreach ($exercise_name as $exercisedata) {
                ?>
                        <tr class="gradeX " id="folder-<?php echo $exercisedata['id']; ?>">
                            <td><?php echo $exercisedata['name']; ?> (<?php echo $exercisedata['insertdate']; ?>)</td>
                            <td>
                            <?php
                            if ($exercisedata['nameofvideo']) {
                                foreach ($exercisedata['nameofvideo'] as $videoname) {
                            ?>
                                    <?php echo $videoname['name']. '<br/>'; ?>
                            <?php
                                }
                            } else {
                                echo "-----";
                            }
                            ?>
                            </td>
                            <td>
                            <?php
                            if ($exercisedata['nameofvideo']) {
                                foreach ($exercisedata['nameofvideo'] as $videoname) {
                            ?>
                                    <img src="<?php echo base_url('/assets/custom/images/images.png') ?>" height="30px" width="30px" />
                            <?php
                                }
                            } else {
                                echo "-----";
                            }
                            ?>
                                
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo '<tr class="gradeX"><td colspan="5" class="text-center">No Folders available.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
    <script>
        var base_url = '<?php echo base_url(); ?>';
        window.print();
    </script>