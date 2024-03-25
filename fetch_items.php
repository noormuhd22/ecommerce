<?php
// Include the PHP file to establish database connection
include 'connection.php';

// Define the table name
$table = 'categories';

// Define primary key column
$primaryKey = 'id';

// Define columns which will be fetched from database
$columns = array(
    array( 'db' => 'id', 'dt' => 'DT_RowId' ), // Add DT_RowId for proper handling of delete action
    array( 'db' => 'id', 'dt' => 'sl_no' ), // ID column for serial number
    array( 'db' => 'image', 'dt' => 'image' ),
    array( 'db' => 'categoryname', 'dt' => 'categoryname' ),
    array(
        'db' => 'id',
        'dt' => 'edit',
        'formatter' => function( $d, $row ) {
            return '<a href="editcategory.php?id='.$d.'"><button type="button" class="btn btn-primary">Edit</button></a>';
        }
    ),
    array(
        'db' => 'id',
        'dt' => 'delete',
        'formatter' => function( $d, $row ) {
            return '<button type="button" class="btn btn-danger" onclick="askconfirm('.$d.')">Delete</button>';
        }
    )
);

// Define database connection parameters
$sql_details = array(
    'user' => $db_user,
    'pass' => $db_pass,
    'db'   => $db_name,
    'host' => $db_host
);

// Include the DataTables server-side script
require( 'vendor/datatables.net-editor/server-side/scripts/ssp.class.php' );

// Output data as JSON
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns )
);
?>
