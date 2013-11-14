<?php
  $qpkg_name = 'qpkg.'.getmypid();
  $qpkg_path = './'.$qpkg_name;
  exec('qpm -c '.$qpkg_name);

  $zip_path = $argv[1];
  $temp_path = $qpkg_path.'/temp';
  $zip = new ZipArchive();
  $zip->open($zip_path);
  $zip->extractTo($temp_path.'/');
  $zip->close();

  $index = glob($temp_path.'/index.*');
  $home_path = $temp_path;
  $cfg_name = $argv[3];//pathinfo($zip_path, PATHINFO_FILENAME);
  if(count($index)<1){
    if ($dh = opendir($temp_path)) {
      while (($dir = readdir($dh)) !== false) {
        if(is_dir($temp_path.'/'.$dir) && $dir!='.' && $dir!='..'){
          if(count(glob($temp_path.'/'.$dir.'/'.'index.*'))>0){
            $home_path = $temp_path.'/'.$dir;
            break;
          }
        }
      }
      closedir($dh);
    }
  }

  $web_path = $qpkg_path.'/share/web';
  rename($home_path, $web_path);

  if(file_exists($web_path.'/qpkg.cfg')){
    rename($web_path.'/qpkg.cfg', $qpkg_path.'/qpkg.cfg');
  }else if(file_exists($web_path.'/package.json')){
    $package = json_decode(file_get_contents($web_path.'/package.json'));

    if($package->name) $cfg_name = $package->name;
    if($package->version){
      list($cfg_ver_major, $cfg_ver_minor, $cfg_ver_build) = explode(".", $package->version);
    }else{
      $cfg_ver_major = 0;
      $cfg_ver_minor = 1;
      $cfg_ver_build = 0;
    }

    $cfg = '';
    $cfg .= 'QPKG_NAME="'.$cfg_name.'"'.PHP_EOL;
    $cfg .= 'QPKG_DISPLAY_NAME="'.($package->display_name ? $package->display_name : $cfg_name).'"'.PHP_EOL;
    $cfg .= 'QPKG_VER_MAJOR="'.$cfg_ver_major.'"'.PHP_EOL;
    $cfg .= 'QPKG_VER_MINOR="'.$cfg_ver_minor.'"'.PHP_EOL;
    $cfg .= 'QPKG_VER_BUILD="'.$cfg_ver_build.'"'.PHP_EOL;
    $cfg .= 'QPKG_AUTHOR="'.($package->author ? $package->author : 'QPM').'"'.PHP_EOL;
    $cfg .= 'QPKG_LICENSE="'.($package->license ? $package->license : 'GPL v2').'"'.PHP_EOL;
    $cfg .= 'QPKG_WEB_PATH="/'.$cfg_name.'"'.PHP_EOL;
    $cfg .= 'QPKG_DIR_WEB="web"'.PHP_EOL;

    file_put_contents($qpkg_path.'/qpkg.cfg', $cfg);
  }else{

    $cfg = '';
    $cfg .= 'QPKG_NAME="'.$cfg_name.'"'.PHP_EOL;
    $cfg .= 'QPKG_DISPLAY_NAME="'.$cfg_name.'"'.PHP_EOL;
    $cfg .= 'QPKG_VER_MAJOR="0"'.PHP_EOL;
    $cfg .= 'QPKG_VER_MINOR="1"'.PHP_EOL;
    $cfg .= 'QPKG_VER_BUILD="0"'.PHP_EOL;
    $cfg .= 'QPKG_AUTHOR="QPM"'.PHP_EOL;
    $cfg .= 'QPKG_LICENSE="GPL v2"'.PHP_EOL;
    $cfg .= 'QPKG_WEB_PATH="/'.$cfg_name.'"'.PHP_EOL;
    $cfg .= 'QPKG_DIR_WEB="web"'.PHP_EOL;

    file_put_contents($qpkg_path.'/qpkg.cfg', $cfg);
  }

  exec('cd '.$qpkg_path.' && qpm');
  rename($qpkg_path.'/build/'.$cfg_name."_${cfg_ver_major}.${cfg_ver_minor}.${cfg_ver_build}.qpkg", $argv[2]);
  exec('rm -rf '.$qpkg_path);