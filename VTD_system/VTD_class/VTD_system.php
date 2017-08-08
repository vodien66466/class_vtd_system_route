<?php
class system
{
	public function path () {
        $path_full=dirname(dirname(__FILE__));
        $path=str_replace("\VTD_system","",$path_full);
        return $path;
    }
    public function base_url() {
        if ($GLOBALS['vtd_config']['basePath']!="") {
            return "".$_SERVER['REQUEST_SCHEME']."://".$_SERVER['SERVER_NAME']."/".$GLOBALS['vtd_config']['basePath'];
        } else {
            return "".$_SERVER['REQUEST_SCHEME']."://".$_SERVER['SERVER_NAME']."";
        }
    }
    public function show ($text,$html=null) {
        if (isset($html)) {
            return $text;
        } else {
            return $text;
        }
    }
    public function get($url=null) {
        if (isset($url)) {
            $url=$url;
        } else {
            $url=system::get_view();
        }
        if ($url!=null) {
            $array=explode("/",$url);
            if (count($array) > 0) {
                $array_route=explode("-",$array['0']);
                if (count($array_route)==1) {
                    return $array_route['0'];
                } else if (count($array_route)==2) {

                    if ($array_route['0']!=null && $array_route['1']!=null) {
                        return $array_route['0']."-".$array_route['1'];
                    } else if ($array_route['0']!="" && $array_route['1']==null) {
                        return $array_route['0'];
                    } else {
                        return "error";
                    }

                } else {
                    return "error";
                }
            } else {
                return "index";
            }
        } else {
            return "index";
        }
    }
    public function action($url=null) {
        $view=system::get($url);
        $array=explode("-",$view);
        if (count($array)==1) {
            return $array['0'];
        } else {
            return $array['0'];
        }
    }
    public function method($url=null) {
        $view=system::get($url);
        $array=explode("-",$view);
        if (count($array)==1) {
            return "index";
        } else {
            return $array['1'];
        }
    } 


    public function path_route($theme,$type,$folder,$url = null) {
        // nếu $view tồn tại thì set_route và ngược lại tự get_route
        // theme là home hoặc admin
        // folder là truyền tới bắt đầu từ thư mục theme
        // type là action hoặc method
        if ($type=="action") {
            $path=system::path_theme($theme)."/".$folder."/".system::action($url).".php";
        } else {
            $path=system::path_theme($theme)."/".$folder."/".system::action($url)."/".system::method($url).".php";
        }
        if (file_exists($path)) {
            return $path;
        } else {
            if ($GLOBALS['vtd_config']['basePath']==true) {
                return system::path()."/VTD_ERROR/404.php";
            } else {
                throw new Exception("VTD_System Báo Lỗi: không nhận dạng được file xử lý");
            }
        }
    }
    public function path_incl ($theme,$path) {
    	$file=system::path_theme($theme)."/".$path.".php";
    	if (file_exists($file)) {
    		return $file;
    	} else {
            if ($GLOBALS['vtd_config']['basePath']==true) {
                return system::path()."/VTD_ERROR/404.php";
            } else {
                throw new Exception("VTD_System Báo Lỗi: không nhận dạng được file xử lý");
            }
    	}
    }
    public function url_paging($theme,$url = null) {
        // nếu tồn tại $url thì set_url còn ngược lại thì get_url
        $route=system::get($url);
        return system::base_url()."/".system::url_rewrite($theme)."".$route;
    }
    public function url($theme,$url = null) {
        // nếu tồn tại $url thì set_url còn ngược lại thì get_url
        if (isset($url)) {
            $view=$url;
        } else {
            $view=system::get_view();
        }
        $route=system::get($url);
        $array=explode("/",$view);
        if (count($array)==1) {
            return system::base_url()."/".system::url_rewrite($theme)."".$route;
        } else if (count($array)==2) {
            return system::base_url()."/".system::url_rewrite($theme)."".$route."/".system::param_paging($url)."";
        } else if (count($array)>=3) {
            return system::base_url()."/".system::url_rewrite($theme)."".$route."/".system::param_paging($url)."/".system::all_param($url)."";
        } else {
            return system::base_url()."/".system::url_rewrite($theme);
        }
    }
    public function url_rewrite($theme) {
        if ($theme=="admin") {
            $file="admin";
        } else {
            if ($GLOBALS['vtd_config']['url_rewrite']==true) {
                $file="home";
            } else {
                $file="index";
            }
        }
        if ($GLOBALS['vtd_config']['url_rewrite']==true) {
            return $file."/";
        } else {
            return $file.".php?view=";
        }
    }
    
    public function get_view () {
        if (isset($GLOBALS['_GET']['VTD_view'])) {
            return $GLOBALS['_GET']['VTD_view'];
        } else {
            return "";
        }
    }
    
    public function path_folder ($path) {
        if (is_dir(system::path()."".$path)) {
            return system::path()."".$path;
        } else {
            throw new Exception("VTD_System Báo Lỗi: không nhận dạng được thư mục xử lý");
        }
    }
    public function path_file ($path) {
        if (file_exists(system::path()."".$path)) {
            return system::path()."".$path;
        } else {
            throw new Exception("VTD_System Báo Lỗi: không nhận dạng được file xử lý");
        }
    }

    public function theme ($theme) {
        $string=$GLOBALS['vtd_config']['theme'];
        if ($string!="") {
            $array=explode("/",$string);
            if (count($array)==2) {
                if ($theme=="admin") {
                    if (is_dir(system::path()."/VTD_admin/".$array['0'])) {
                        return $array['0'];
                    } else {
                        throw new Exception("VTD_System Báo Lỗi: Không tìm thấy thư mục giao diện cho trang admin");
                    }
                } else {
                    if (is_dir(system::path()."/VTD_home/".$array['0']."/".$array['1'])) {
                        return $array['0']."/".$array['1'];
                    } else {
                        throw new Exception("VTD_System Báo Lỗi: Không tìm thấy thư mục giao diện cho trang home");
                    }
                }
            } else {
                throw new Exception("VTD_System Báo Lỗi: Cấu hình giao diện bị lỗi");
            }
        } else {
            throw new Exception("VTD_System Báo Lỗi: Cấu hình giao diện bị lỗi");
        }
    }
    public function path_theme ($theme) {
        if ($theme=="admin") {
            return system::path()."/VTD_admin/".system::theme($theme);
        } else {
            return system::path()."/VTD_home/".system::theme($theme);
        }
    }
    public function param ($key,$url = null) {
        $keys=$key+2;
        if (isset($url)) {
            $route=$url;
        } else {
            $route=system::get_view();
        }
        $array=explode("/",$route);
        if (count($array) > 2) {
            $c_data=count($array)-3;
            if ($key<=$c_data) {
                return system::security($array[$keys],"string");
            } else {
                return null;
            }
        } else {
            return null;
        }
    }
    public function param_paging ($url = null) {
        if (isset($url)) {
            $route=$url;
        } else {
            $route=system::get_view();
        }
        $array=explode("/",$route);
        if (count($array) > 1) {
            if (is_numeric($array['1'])) {
                if ($array['1'] > 1) {
                    return $array['1'];
                } else {
                    return 1;
                }
            } else {
                return 1;
            }  
        } else {
            return 1;
        }
    }
    public function all_param ($view=null) {
        if (isset($view)) {
            $string=$view;
        } else {
            $string=system::get_view();
        }
        $array=explode("/",$string);
        if (count($array) > 2) {
            unset($array['0']);
            unset($array['1']);
            $fields = '';
            $values = '';
            foreach ($array as $keys => $value) {
                $values.=system::security($value,"string")."/";
            }
            $values = trim($values,'/');
            $link="{$values}";
            return $link;
        } else {
            return null;
        }
        
    }
    public function is_paging ($url = null) {
        if (isset($url)) {
            $route=$url;
        } else {
            $route=system::get_view();
        }
        $array=explode("/",$route);
        if (count($array) > 1) {
            if (is_numeric($array['1'])) {
                return true;
            } else {
                return null;
            }  
        } else {
            return null;
        }
    }
    public function get_paging ($kmess,$view = null) {
        if (isset($view)) {
            $page=system::param_paging($view);
        } else {
            $page=intval(system::param_paging());
        }
        if (system::is_paging($view)) {
            if ($page==0) {
                return 0;
            } else {
                return ($page*$kmess)-$kmess;
            }
        } else {
            return 0;
        }
    }
    public function paging($theme,$total,$kmess,$view=null)
    {
        $url=system::url_paging($theme,$view);
        $start=system::get_paging($kmess,$view);
        $neighbors = 2;
        if ($start >= $total)
            $start = max(0, $total - (($total % $kmess) == 0 ? $kmess : ($total % $kmess)));
        else
            $start = max(0, (int)$start - ((int)$start % (int)$kmess));
        $base_link = '<li class="paginate_button page-item"><a href="' . strtr($url, array('%' => '%%')) . '/%d/'.system::all_param($view).'' . '" class="page-link">%s</a></li>';
        $out[] = $start == 0 ? '' : sprintf($base_link, $start / $kmess, 'Trang trước');
        if ($start > $kmess * $neighbors)
            $out[] = sprintf($base_link, 1, '1');
        if ($start > $kmess * ($neighbors + 1))
            $out[] = '<li class="paginate_button page-item previous disabled"><a href="#" class="page-link">...</a></li>';
        for ($nCont = $neighbors; $nCont >= 1; $nCont--)
            if ($start >= $kmess * $nCont) {
                $tmpStart = $start - $kmess * $nCont;
                $out[] = sprintf($base_link, $tmpStart / $kmess + 1, $tmpStart / $kmess + 1);
            }
        $out[] = '<li class="paginate_button page-item active"><a href="#" aria-label="Previous"><span aria-hidden="true" class="page-link">' . ($start / $kmess + 1) . '</span></a></li>';
        $tmpMaxPages = (int)(($total - 1) / $kmess) * $kmess;
        for ($nCont = 1; $nCont <= $neighbors; $nCont++)
            if ($start + $kmess * $nCont <= $tmpMaxPages) {
                $tmpStart = $start + $kmess * $nCont;
                $out[] = sprintf($base_link, $tmpStart / $kmess + 1, $tmpStart / $kmess + 1);
            }
        if ($start + $kmess * ($neighbors + 1) < $tmpMaxPages)
            $out[] = '<li class="paginate_button page-item previous disabled"><a href="#" class="page-link">...</a></li>';
        if ($start + $kmess * $neighbors < $tmpMaxPages)
            $out[] = sprintf($base_link, $tmpMaxPages / $kmess + 1, $tmpMaxPages / $kmess + 1);
        if ($start + $kmess < $total) {
            $display_page = ($start + $kmess) > $total ? $total : ($start / $kmess + 2);
            $out[] = ''.sprintf($base_link, $display_page, 'Trang sau').'';
        }

        return implode(' ', $out);
    }

    
    
    public function asset ($theme=null,$path) {
        if (isset($theme)) {
            $path_theme=system::path_theme($theme)."/".$path;
            if (file_exists($path_theme)) {
                if ($theme=="admin") {
                    return system::base_url()."/VTD_admin/".system::theme($theme)."/".$path;
                } else {
                    return system::base_url()."/VTD_home/".system::theme($theme)."/".$path;
                }
            } else {
                return "VTD_System Báo Lỗi: File : ".$path." không tồn tại";
            }
        } else {
            $path_asset=system::path()."/".$path;
            if (file_exists($path_asset)) {
                return system::base_url()."/".$path;
            } else {
                return "VTD_System Báo Lỗi: File : ".$path." không tồn tại";
            }
        }
    }

    public function is_link ($url,$image=null) {
        $headers = @get_headers($url);
        if(strpos($headers[0],'404') === true) {
          return $url;
        } else {
            if (isset($image)) {
                if ($GLOBALS['vtd_config']['image_error']!="") {
                    return system::asset(null,$GLOBALS['vtd_config']['image_error']);
                } else {
                    return "VTD_System Báo Lỗi: Cần phải cấu hình cho : image_error";
                }
            } else {
                return "VTD_System Báo Lỗi: Link : ".$url." không tồn tại";
            } 
        }
    }

    // $_REQUEST
    public function rq ($name,$type=null) {
        return $GLOBALS['_REQUEST'][$name];
    }

    
    //hàm thêm dấu chấm vào chuổi string số : vd : 15000000 =1.50000
    public function adddotstring($strNum) {
 
        $len = strlen($strNum);
        $counter = 3;
        $result = "";
        while ($len - $counter >= 0)
        {
            $con = substr($strNum, $len - $counter , 3);
            $result = '.'.$con.$result;
            $counter+= 3;
        }
        $con = substr($strNum, 0 , 3 - ($counter - $len) );
        $result = $con.$result;
        if(substr($result,0,1)=='.'){
            $result=substr($result,1,$len+1);   
        }
        return $result;
    }
    public function security($str,$type) {
        /*
        if ($type=="int") {
            $str = mysql_real_escape_string(intval(abs($str)));
        } else {
             $str = htmlentities(trim($str), ENT_QUOTES, 'utf-8');
            $str = mysql_real_escape_string($str);
        }
        */
        return $str;
    }
    public function rand_string($length) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*-+";
        $size = strlen($chars);
        for($i=0; $i<$length; $i++) {
            $str .= $chars[rand(0,$size-1)];
        }
        return $str;
    }
    public function rw($text) {
        $text = html_entity_decode(trim($text), ENT_QUOTES, 'UTF-8');
        $text=str_replace(urldecode('%CC%A3'),"", $text);
        $text=str_replace(urldecode('%CC%83'),"", $text);
        $text=str_replace(urldecode('%CC%89'),"", $text);
        $text=str_replace(urldecode('%CC%80'),"", $text);
        $text=str_replace(urldecode('%CC%81'),"", $text);
        $text=str_replace("--","-", $text);
        $text=str_replace(" ","-", $text);
        $text=str_replace("@","-",$text);
        $text=str_replace("/","-",$text);
        $text=str_replace("\\","-",$text);
        $text=str_replace(":","-",$text);
        $text=str_replace("\"","-",$text);
        $text=str_replace("'","-",$text);
        $text=str_replace("<","-",$text);
        $text=str_replace(">","-",$text);
        $text=str_replace(",","-",$text);
        $text=str_replace("?","-",$text);
        $text=str_replace("%20","",$text);
        $text=str_replace(";","-",$text);
        $text=str_replace("[","-",$text);
        $text=str_replace("]","-",$text);
        $text=str_replace("(","-",$text);
        $text=str_replace(")","-",$text);
        $text=str_replace("́","-", $text);
        $text=str_replace("̀","-", $text);
        $text=str_replace("̃","-", $text);
        $text=str_replace("̣","-", $text);
        $text=str_replace("̉","-", $text);
        $text=str_replace("*","-",$text);
        $text=str_replace("!","-",$text);
        $text=str_replace("$","-",$text);
        $text=str_replace("&","-and-",$text);
        $text=str_replace("%","-",$text);
        $text=str_replace("#","-",$text);
        $text=str_replace("^","-",$text);
        $text=str_replace("=","-",$text);
        $text=str_replace("+","-",$text);
        $text=str_replace("~","-",$text);
        $text=str_replace("`","-",$text);
        $text=str_replace("--","-",$text);
        $text=str_replace(".","-",$text);
        $text = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $text);
        $text = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $text);
        $text = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $text);
        $text = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $text);
        $text = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $text);
        $text = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $text);
        $text = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $text);
        $text = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $text);
        $text = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $text);
        $text = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $text);
        $text = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $text);
        $text = preg_replace("/(đ)/", 'd', $text);
        $text = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $text);
        $text = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $text);
        $text = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $text);
        $text = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $text);
        $text = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $text);
        $text = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $text);
        $text = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $text);
        $text = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $text);
        $text = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $text);
        $text = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $text);
        $text = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $text);
        $text = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $text);
        $text = preg_replace("/(Đ)/", 'D', $text);
        $text = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $text);
        $text = preg_replace("/(Đ)/", 'D', $text);
        return strtolower($text);
    }
    public function times ($var) {
        return date("H:i - d.m.Y", $var );
    }

}
?>