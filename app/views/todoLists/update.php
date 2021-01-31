<?php 
    require APPROOT . '/views/layouts/header.php'; 
    require APPROOT . '/views/layouts/sidebar.php'; 
?>

<div class="content-wrapper" style="min-height: 365px;">
    <section class="content">
		<div class="container-fluid">
			<div class="row">
                <div class="box box-primary col-sm-12">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit Todo</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="<?php echo URLROOT; ?>/todoLists/update/<?php echo $data[0]->id ?>" method="post">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Name Work</label>
                                <input name="name_work" value="<?php echo $data[0]->name_work ?? '' ?>" type="input" class="form-control" id="exampleInputEmail1" placeholder="Enter name work">
                                <span class="invalidFeedback">
                                    <?php 
                                        if (isset($data['nameWorkError'])) {
                                            echo $data['nameWorkError']; 
                                        }
                                    ?>
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Start date</label>
                                <input class="form-control"  type="datetime-local" value="<?php echo strftime('%Y-%m-%dT%H:%M:%S', strtotime($data[0]->start_date)) ?>" name="start_date">
                                <span class="invalidFeedback">
                                    <?php 
                                        if (isset($data['startDateError'])) {
                                            echo $data['startDateError'];
                                        }
                                    ?>
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">End date</label>
                                <input class="form-control" value="<?php echo strftime('%Y-%m-%dT%H:%M:%S', strtotime($data[0]->end_date)) ?? '' ?>" name="end_date" type="datetime-local">
                                <span class="invalidFeedback">
                                    <?php 
                                        if (isset($data['endDateError'])) {
                                            echo $data['endDateError']; 
                                        }
                                    ?>
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Start date</label>
                                <select class="form-control" name="status" >
                                    <?php foreach(Status as $key => $value): ?>
                                        <option value="<?php echo $value ?>" <?php echo $data[0]->status == $value ? 'selected' : '' ?> > <?php echo $key ?> </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="<?php echo URLROOT . '/todoLists/delete/' ?><?php echo $data[0]->id ?>" id="deleteTodo" class="btn btn-danger">Delete</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<?php require APPROOT . '/views/layouts/footer.php' ?>
