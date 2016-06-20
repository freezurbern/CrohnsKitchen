<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-start.php");?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/template/loginwarning.php"); ?>

    <article>
        <script type="text/javascript" language="javascript" class="init">
            $(document).ready(function() {
                $('#all-ratings').DataTable();
                $('#all-foods').DataTable();
            } );
        </script>
        <div class="container">
            <h4>Data table of all user ratings:</h4>
            <?php
            $mydb = new ckdb;
            $mydb->connect();
            $output1 = $mydb->getUsersClean(); // get a list of all users
            //$output1 = $mydb->getRatings('0'); // get ratings for uID (rateby)
            //echo print_r($output);
            ?>
            <table id="all-ratings" class="display">
                <thead>
                <tr>
                    <th>uid</th>
                    <th>email</th>
                    <th>registration datetime</th>
                    <th>is verified</th>
                    <th>approved by uid</th>
                </tr>
                </thead>
                <?php foreach($output1 as $row1) : ?>
                    <tr>
                        <td><?php echo $row1['uid']; ?></td>
                        <td><?php echo $row1['email']; ?></td>
                        <td><?php echo $row1['regdate']; ?></td>
                        <td><?php echo $row1['isverified']; ?></td>
                        <td><?php echo $row1['whoapproved']; ?></td>
                    </tr>
                <?php endforeach;?>
            </table>

            <hr /> <!-- ##### -->
        </div> <!-- /container -->
    </article>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/template/page-end.php");?>