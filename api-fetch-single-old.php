<?php
    
    header ('Content-Type: application/json');
    header ('Access-Control-Allow-Origin: *');
    $data = json_decode (file_get_contents("php://input"), true);
    $npsn   = $data['npsn'];
    $token  = $data['token'];
    include "config.php";
    
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
    $result = mysqli_query($conn, $sql) or die ("SQL query filed.");

    if (mysqli_num_rows($result) > 0 ) {
        $output = mysqli_fetch_all ($result, MYSQLI_ASSOC);
        echo json_encode (array (
            'data'       => $output,
            'status'     => true
        ));
    } else {
        echo json_encode (array(
            'message'   => 'No record found',
            'status'    => false 
        ));
    }
?>