<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-start.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/template/loginwarning.php"); ?>
<?php $PRIVNEEDED = 1; ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/template/privwarning.php"); ?>

<?php // Form Submission code for changing auser's details.
$mydb = new ckdb; // create database object
$mydb->connect(); // connect to database server
$output1 = $mydb->getUsersClean(); // get a list of all users
?>

<?php if (!empty($_POST)): ?>
    <?php
    $uid = $_SESSION['uid'];
    $currentemail = $_SESSION['email'];
    $newemail = get_post_var('newemail');
    $currentpassword = get_post_var('currentpassword');
    $newpassword = get_post_var('newpassword');
    $confirmpassword = get_post_var('confirmpassword');


    ?>


    <!-- ########################################################### -->
    <!-- ########################################################### -->
<?php else: ?>
    <!-- ############# Page Content when not submitted ############# -->
    <!-- ########################################################### -->
    <article>
        <script type="text/javascript" language="javascript" class="init">
            $(document).ready(function () {
                $('#all-users').DataTable();
            });
        </script>
        <div class="container">
            <h4>DataTable of all users:</h4>

            <form class="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <table id="all-users" class="display">
                    <thead>
                    <tr>
                        <th>uid</th>
                        <th>email</th>
                        <th>registration datetime</th>
                        <th>priv level</th>
                        <th>is verified</th>
                        <th>approved by uid</th>
                        <th>Edit</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($output1 as $row1) : ?>
                    <tr>
                        <td><?php echo $row1['uid']; ?></td>
                        <td><?php echo $row1['email']; ?></td>
                        <td><?php echo $row1['regdate']; ?></td>
                        <td><?php echo $row1['privlevel']; ?></td>
                        <td><?php echo $row1['isverified']; ?></td>
                        <td><?php echo $row1['whoapproved']; ?></td>
                        <td>

                            <div class="btn-group btn-group-xs" data-toggle="buttons">
                                <label class="btn btn-default active">
                                    <input type="radio" name="rating" value="noaction" autocomplete="off">
                                        <span class="glyphicon glyphicon-ok-sign"></span>
                                </label>
                                <label class="btn btn-success">
                                    <input type="radio" name="rating" value="bad" autocomplete="off">Approve
                                </label>
                                <label class="btn btn-warning">
                                    <input type="radio" name="rating" value="neutral" autocomplete="off">Block
                                </label>
                                <label class="btn btn-danger">
                                    <input type="radio" name="rating" value="good" autocomplete="off">Delete
                                </label>
                            </div>
                                <div class="btn-group btn-group-xs dropup">
                                        <button type="button" name="more" class="btn btn-default dropdown-toggle btn-xs" data-toggle="dropdown">
                                            <span class="glyphicon glyphicon-option-vertical"></span>
                                        </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                        <li><a href="#">Make Admin (1)</a></li>
                                        <li><a href="#">Remove Admin (1)</a></li>
                                        <li><a href="#">Something else here</a></li>
                                        <li role="separator" class="divider"></li>
                                        <li><a href="#">Masquerade</a></li>
                                    </ul>
                                </div>

                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <br />
                <button class="btn btn-primary pull-right" type="submit" id="inputSubmit">Save</button>
            </form>

            <br />
            <hr /> <!-- ##### -->
        </div> <!-- /container -->
    </article>
<?php endif; ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-end.php"); ?>