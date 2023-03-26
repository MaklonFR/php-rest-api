<?php
require 'config.php';

function error422($message) {
    $data = [
        'status'    => 422,
        'message'   => $message,
    ];
    header ('HTTP/1.0 422 Unprocessbale Entity');
    echo json_encode($data);
    exit();
}

function storeSoal($soalInput) {
    global $conn;
    $id_sekolah = mysqli_real_escape_string($conn, $soalInput['id_sekolah']);
    $nama_soal = mysqli_real_escape_string($conn, $soalInput['nama_soal']);
    $link_soal = mysqli_real_escape_string($conn, $soalInput['link_soal']);
    $kode_soal = mysqli_real_escape_string($conn, $soalInput['kode_soal']);
    $waktu = mysqli_real_escape_string($conn, $soalInput['waktu']);
    $jenis_ujian = mysqli_real_escape_string($conn, $soalInput['jenis_ujian']);
    $status = mysqli_real_escape_string($conn, $soalInput['status']);
    $tahun_ajaran = mysqli_real_escape_string($conn, $soalInput['tahun_ajaran']);

    if(empty(trim($id_sekolah))) {
        return error422('Enter ID Sekolah..');
    } elseif(empty(trim($nama_soal))) {
        return error422('Enter soal name..');
    } elseif(empty(trim($link_soal))) {
        return error422('Enter link soal..');
    } elseif(empty(trim($kode_soal))) {
        return error422('Enter kode soal..');
    } elseif(empty(trim($waktu))) {
        return error422('Enter waktu soal..');
    } elseif(empty(trim($jenis_ujian))) {
        return error422('Enter jenis ujian..');
    } elseif(empty(trim($status))) {
        return error422('Enter status soal..');
    } elseif(empty(trim($tahun_ajaran))) {
        return error422('Enter tahun ajaran..');
    } else {
        $query = "INSERT INTO tb_soal(
            id_sekolah,
            nama_soal,
            link_soal,
            kode_soal,
            waktu,
            jenis_ujian,
            status,
            tahun_ajaran
            )
            VALUES(
            '$id_sekolah',
            '$nama_soal',
            '$link_soal',
            '$kode_soal',
            '$waktu',
            '$jenis_ujian',
            '$status',
            '$tahun_ajaran'        
        )";

        $result = mysqli_query($conn, $query);

        if ($result) {
            $data = [
                'status'    => 201,
                'message'   => 'Soal created Successfully',
                ];
                header("HTTP/1.0 201 Created");
                return json_encode($data);
        } else {
            $data = [
                'status'    => 500,
                'message'   => 'Internal Server Error',
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }
}

function getSoalList() {
    global $conn;

    $sql = "SELECT * FROM tb_soal";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        if (mysqli_num_rows($result) > 0 ) {
            $output = mysqli_fetch_all($result, MYSQLI_ASSOC);
            //return json_encode ($output);
            $data = [
                'status'    => 200,
                'message'   => 'Soal List Fetched Successfully',
                'data'      => $output,
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);
        }   else {
            $data = [
                'status'    => 404,
                'message'   => 'No Soal Found',
            ];
            header("HTTP/1.0 404 No Soal Found");
            return json_encode($data);
        }
    } else {
        $data = [
            'status'    => 500,
            'message'   => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }
}

function getSoal ($soalParams) {
    global $conn;
    if($soalParams['npsn']== null) {
        return error422("Enter your NPSN...");
    }elseif ($soalParams['token']== null) {
        return error422("Enter your Token Soal...");
    }
    $npsn = $soalParams['npsn'];
    $token= $soalParams['token'];
    $sql = "SELECT tb_soal.nama_soal as nama_soal,
                   tb_soal.link_soal as link_soal,
                   tb_soal.waktu as waktu,
                   tb_soal.jenis_ujian as jenis_ujian,
                   tb_soal.tahun_ajaran as tahun_ajaran,
                   tb_sekolah.nama as nama_sekolah
                   FROM tb_soal
                   JOIN tb_sekolah ON tb_soal.id_sekolah = tb_sekolah.id
                   WHERE ((tb_sekolah.npsn ='$npsn') AND (tb_soal.kode_soal ='$token'))
                    ";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        if (mysqli_num_rows($result) == 1 ) {
            $output = mysqli_fetch_assoc($result);
            //return json_encode ($output);
            $data = [
                'status'    => 200,
                'message'   => 'Soal Fetched Successfully',
                'data'      => $output,
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);
        }   else {
            $data = [
                'status'    => 404,
                'message'   => 'No Soal Found',
            ];
            header("HTTP/1.0 404 No Soal Found");
            return json_encode($data);
        }
    } else {
        $data = [
            'status'    => 500,
            'message'   => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }
}

function updateSoal ($soalInput, $soalParams) {
    global $conn;

    if(!isset($soalParams['id'])) {
        return error422("ID Soal not found..");
    } elseif ($soalParams['id'] == null)  {
        return error422("Enter your ID Soal..");
    }

    $idSoal = mysqli_real_escape_string($conn, $soalParams['id']);

    $id_sekolah = mysqli_real_escape_string($conn, $soalInput['id_sekolah']);
    $nama_soal = mysqli_real_escape_string($conn, $soalInput['nama_soal']);
    $link_soal = mysqli_real_escape_string($conn, $soalInput['link_soal']);
    $kode_soal = mysqli_real_escape_string($conn, $soalInput['kode_soal']);
    $waktu = mysqli_real_escape_string($conn, $soalInput['waktu']);
    $jenis_ujian = mysqli_real_escape_string($conn, $soalInput['jenis_ujian']);
    $status = mysqli_real_escape_string($conn, $soalInput['status']);
    $tahun_ajaran = mysqli_real_escape_string($conn, $soalInput['tahun_ajaran']);

    if(empty(trim($id_sekolah))) {
        return error422('Enter ID Sekolah..');
    } elseif(empty(trim($nama_soal))) {
        return error422('Enter soal name..');
    } elseif(empty(trim($link_soal))) {
        return error422('Enter link soal..');
    } elseif(empty(trim($kode_soal))) {
        return error422('Enter kode soal..');
    } elseif(empty(trim($waktu))) {
        return error422('Enter waktu soal..');
    } elseif(empty(trim($jenis_ujian))) {
        return error422('Enter jenis ujian..');
    } elseif(empty(trim($status))) {
        return error422('Enter status soal..');
    } elseif(empty(trim($tahun_ajaran))) {
        return error422('Enter tahun ajaran..');
    } else {
        $query = "UPDATE tb_soal SET
            id_sekolah  = '$id_sekolah',
            nama_soal   = '$nama_soal',
            link_soal   = '$link_soal',
            kode_soal   = '$kode_soal',
            waktu       = '$waktu',
            jenis_ujian = '$jenis_ujian',
            status      = '$status',
            tahun_ajaran= '$tahun_ajaran'
            WHERE id = '$idSoal' LIMIT 1";

        $result = mysqli_query($conn, $query);

        if ($result) {
            $data = [
                'status'    => 201,
                'message'   => 'Soal Update Successfully',
                ];
                header("HTTP/1.0 200 Success");
                return json_encode($data);
        } else {
            $data = [
                'status'    => 500,
                'message'   => 'Internal Server Error',
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }
}

function deleteSoal ($soalParams) {
    global $conn;

    if(!isset($soalParams['id'])) {
        return error422("ID Soal not found..");
    } elseif ($soalParams['id'] == null)  {
        return error422("Enter your ID Soal..");
    }

    $idSoal = mysqli_real_escape_string($conn, $soalParams['id']);
    $sql = "SELECT * FROM tb_soal WHERE id = '$idSoal' LIMIT 1";
    $res = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($res) == 1 ) {
        $query = "DELETE FROM tb_soal WHERE id = '$idSoal' LIMIT 1";
        $result = mysqli_query ($conn, $query);
    
        if($result) {
            $data = [
                'status'    => 200,
                'message'   => 'Soal Deleted Successfully..',
             ];
             header("HTTP/1.0 200 OK");
             return json_encode($data);
        } else {
            $data = [
                'status'    => 500,
                'message'   => 'Internal Server Error',
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }   else {
        $data = [
            'status'    => 404,
            'message'   => 'No Soal Found',
        ];
        header("HTTP/1.0 404 No Soal Found");
        return json_encode($data);
    }

}

?>