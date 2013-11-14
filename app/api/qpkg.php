<?php
  $a = strval($_GET['a']);
  switch ($a) {
    case 'download':
      $qpkg_id = $_GET['qpkg_id'];
      $qpkg_name = $_GET['qpkg_name'] ? $_GET['qpkg_name'] : $qpkg_id;
      header('Content-type:application/force-download');
      header('Content-Transfer-Encoding: Binary');
      header('Content-Disposition:attachment;filename='.$qpkg_name.'.qpkg');
      @readfile('../../qpkg/'.$qpkg_id.'.qpkg');
      break;
    case 'check':
      $qpkg_id = $_GET['qpkg_id'];
      if (file_exists('../qpkg/'.$qpkg_id.'.qpkg')) {
        echo json_encode(array(
          'code' => 200,
          'progress' => 100,
          'message' => 'Completed'
        ));
      }else{
        echo json_encode(array(
          'code' => 200,
          'progress' => 50,
          'message' => 'Progress...'
        ));
      }
    default:
      header("HTTP/1.0 404 Not Found");
      break;
  }