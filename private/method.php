<?php
// require_once "../config.php";
include '../config.php';

class User
{
    public  function get_users()
    {
        global $conn;
        $query = "SELECT * FROM users us join tb_pelanggan pg WHERE us.id=pg.id_user";
        $data = array();
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_object($result)) {
            $data[] = $row;
        }
        $response = array(
            'status' => 1,
            'message' => 'Get List Users Successfully.',
            'data' => $data
        );
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function get_user($id = '')
    {
        global $conn;
        $query = "SELECT * FROM users us join tb_pelanggan pg WHERE us.id=pg.id_user";
        if ($id != '') {
            $query = "$query AND id_pelanggan='$id' LIMIT 1";
        }
        $data = array();
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_object($result)) {
            $data[] = $row;
        }
        $response = array(
            'status' => 1,
            'id_motor_get' => $id,
            'message' => 'Get User Successfully.',
            'data' => $data
        );
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
















// class Motor
// {

//     public  function get_motors()
//     {
//         global $mysqli;
//         $query = "SELECT * FROM tb_motor";
//         $data = array();
//         $result = $mysqli->query($query);
//         while ($row = mysqli_fetch_object($result)) {
//             $data[] = $row;
//         }
//         $response = array(
//             'status' => 1,
//             'message' => 'Get List Motors Successfully.',
//             'data' => $data
//         );
//         header('Content-Type: application/json');
//         echo json_encode($response);
//     }

//     public function get_motor($id = 0)
//     {
//         global $mysqli;
//         $query = "SELECT * FROM tb_motor";
//         if ($id != 0) {
//             $query .= " WHERE id_motor=" . $id . " LIMIT 1";
//         }
//         $data = array();
//         $result = $mysqli->query($query);
//         while ($row = mysqli_fetch_object($result)) {
//             $data[] = $row;
//         }
//         $response = array(
//             'status' => 1,
//             'message' => 'Get Motor Successfully.',
//             'data' => $data
//         );
//         header('Content-Type: application/json');
//         echo json_encode($response);
//     }

//     public function insert_motor()
//     {
//         global $mysqli;
//         $arrcheckpost = array('nim' => '', 'nama' => '', 'jk' => '', 'alamat' => '', 'jurusan'   => '');
//         $hitung = count(array_intersect_key($_POST, $arrcheckpost));
//         if ($hitung == count($arrcheckpost)) {

//             $result = mysqli_query($mysqli, "INSERT INTO tbl_mahasiswa SET
//                nim = '$_POST[nim]',
//                nama = '$_POST[nama]',
//                jk = '$_POST[jk]',
//                alamat = '$_POST[alamat]',
//                jurusan = '$_POST[jurusan]'");

//             if ($result) {
//                 $response = array(
//                     'status' => 1,
//                     'message' => 'Mahasiswa Added Successfully.'
//                 );
//             } else {
//                 $response = array(
//                     'status' => 0,
//                     'message' => 'Mahasiswa Addition Failed.'
//                 );
//             }
//         } else {
//             $response = array(
//                 'status' => 0,
//                 'message' => 'Parameter Do Not Match'
//             );
//         }
//         header('Content-Type: application/json');
//         echo json_encode($response);
//     }

//     function update_motor($id)
//     {
//         global $mysqli;
//         $arrcheckpost = array('nim' => '', 'nama' => '', 'jk' => '', 'alamat' => '', 'jurusan'   => '');
//         $hitung = count(array_intersect_key($_POST, $arrcheckpost));
//         if ($hitung == count($arrcheckpost)) {

//             $result = mysqli_query($mysqli, "UPDATE tbl_mahasiswa SET
//               nim = '$_POST[nim]',
//               nama = '$_POST[nama]',
//               jk = '$_POST[jk]',
//               alamat = '$_POST[alamat]',
//               jurusan = '$_POST[jurusan]'
//               WHERE id='$id'");

//             if ($result) {
//                 $response = array(
//                     'status' => 1,
//                     'message' => 'Mahasiswa Updated Successfully.'
//                 );
//             } else {
//                 $response = array(
//                     'status' => 0,
//                     'message' => 'Mahasiswa Updation Failed.'
//                 );
//             }
//         } else {
//             $response = array(
//                 'status' => 0,
//                 'message' => 'Parameter Do Not Match'
//             );
//         }
//         header('Content-Type: application/json');
//         echo json_encode($response);
//     }

//     function delete_motor($id)
//     {
//         global $mysqli;
//         $query = "DELETE FROM tbl_mahasiswa WHERE id=" . $id;
//         if (mysqli_query($mysqli, $query)) {
//             $response = array(
//                 'status' => 1,
//                 'message' => 'Mahasiswa Deleted Successfully.'
//             );
//         } else {
//             $response = array(
//                 'status' => 0,
//                 'message' => 'Mahasiswa Deletion Failed.'
//             );
//         }
//         header('Content-Type: application/json');
//         echo json_encode($response);
//     }
// }
