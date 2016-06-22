<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-start.php");?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/template/loginwarning.php"); ?>
<?php $PRIVNEEDED = 3; ?>
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
        $(document).ready(function() {
            var table = $('#all-users').DataTable( {
                "columns": [
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    {
                        "data": null,
                        "defaultContent": "<button>Approve</button>"
                    },
                    {
                        "data": null,
                        "defaultContent": "<button>delApprove</button>"
                    }
                ]
            } );

            $('#all-users tbody').on( 'click', 'button', function () {
                var data = table.row( $(this).parents('tr') ).data();
                //alert( data[ 1 ] +"was registered on "+ data[ 2 ] );
                $.post("approveAJAX.php",
                    {
                        userApprove: data[0]
                    },
                    function(data){
                        alert("Data: " + data);
                    });
            });
        } );
    </script>
    <div class="container">
        <h4>Data table of all users:</h4>

        <table id="all-users" class="display">
            <thead>
            <tr>
                <th>uid</th>
                <th>email</th>
                <th>registration datetime</th>
                <th>priv level</th>
                <th>is verified</th>
                <th>approved by uid</th>
                <th>Approve</th>
                <th>delApprove</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($output1 as $row1) : ?>
                <tr>
                    <td><?php echo $row1['uid']; ?></td>
                    <td><?php echo $row1['email']; ?></td>
                    <td><?php echo $row1['regdate']; ?></td>
                    <td><?php echo $row1['privlevel']; ?></td>
                    <td><?php echo $row1['isverified']; ?></td>
                    <td><?php echo $row1['whoapproved']; ?></td>
                    <td><?php echo ""; // echo nothing to create button column ?></td>
                    <td><?php echo ""; // echo nothing to create button column ?></td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
        <hr /> <!-- ##### -->
    </div> <!-- /container -->
</article>
<?php endif; ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-end.php");?>