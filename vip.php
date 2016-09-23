<?php
	
	
	if (!defined('BASEPATH'))
    	exit('No direct script access allowed');
    session_start();
    
	class Vip extends CI_Controller {

		private $songs_in_cart = array();
    	private $videos_in_cart = array();
    
	    public function __construct() {
	        parent::__construct();
	        $this->load->helper(array('form', 'url'));
	        $this->load->model('Vip_model');
	        $this->load->helper('text');
	        $this->load->helper('download');
	        $this->load->library('session');
	    }

	    public function access(){
	    	if(isset($_SESSION['access'])){
		        header("Location: http://www.videotoolz20.com/");
		    } else {
		        $this->load->view('access');
		    }
		}

	    public function getAccess(){
	    	if(!empty($_POST['email'])){
	    		$email = $_POST['email'];
	    		$check = $this->Vip_model->checkTempAccess($email);
	    		if($check){
	    			$_SESSION['access'] = $check;
	    			header("Location: http://www.videotoolz20.com/");
	    		} else {
	    			header("Location: http://www.videotoolz20.com/access");	
	    		}
	    	} else {
	    		header("Location: http://www.videotoolz20.com/access");
	    	}
	    }

	    /*public function index() {
	    	// checkAccess();
	    	$user = $this->myauth->getUserId();
	    	$data['queue'] = false;
	    	if ($user == 1) {
	            $data['isPaid'] = true;
	            $sCount = $this->Vip_model->getSongsCountInQueue($user,1,'count',0,0);
				$vCount = $this->Vip_model->getSongsCountInQueue($user,2,'count',0,0);
				if($sCount > 0 || $vCount > 0){
					$data['queue'] = true;
				}
	        } else {
	            // $data['isPaid'] = Am_Lite::getInstance()->checkPaid();
	            if($user){
			    	$paid = Am_Lite::getInstance()->verifyUserAccess($user);
			    	if($paid['status'] == 1){
			    		$data['isPaid'] = true;
			    		$sCount = $this->Vip_model->getSongsCountInQueue($user,1,'count',0,0);
						$vCount = $this->Vip_model->getSongsCountInQueue($user,2,'count',0,0);
						if($sCount > 0 || $vCount > 0){
							$data['queue'] = true;
						}
			    	} else {
			    		$data['isPaid'] = false;
			    	}
			    } else {
			    	$data['isPaid'] = false;
			    }
	        }
	        $slugs = array();
	        $crateVideo = array();
	        $crateMusic = array();
	        if(isset($_SESSION['crate']['video'])){
	        	foreach($_SESSION['crate']['video'] as $key => $val){
		    		foreach($val as $k => $v){
		    			array_push($slugs,$k);
		    			array_push($crateVideo,$k);
		    		}
		    	}	
	        }
	        if(isset($_SESSION['crate']['song'])){
	        	foreach($_SESSION['crate']['song'] as $key => $val){
		    		foreach($val as $k => $v){
		    			array_push($slugs,$k);
		    			array_push($crateMusic,$k);
		    		}
		    	}	
	        }
	        $data['banners'] = $this->Vip_model->getBanners();
	        $data['title'] = $this->Vip_model->getConfigs("title");
            
            $data['song'] = $this->Vip_model->getConfigs("song");
            $data['video'] = $this->Vip_model->getConfigs("video");
            
            if($data['video'] == "active"){
            	$data['videos'] = $this->Vip_model->getVideoList(20,0);
	        }

	        if($data['song'] == "active"){
	        	$data['songs'] = $this->Vip_model->getSongsList(20,0);	
	        }
	        $data['facebook'] = $this->Vip_model->getConfigs("facebook");
	        $data['youtube'] = $this->Vip_model->getConfigs("youtube");
	        $data['soundcloud'] = $this->Vip_model->getConfigs("soundcloud");
	        $data['vimeo'] = $this->Vip_model->getConfigs("vimeo");
	        $data['instagram'] = $this->Vip_model->getConfigs("instagram");
	        $data['about'] = $this->Vip_model->getConfigs("about-us");
	        $data['videoCount'] = $this->Vip_model->getCount(2);
	        $data['songCount'] = $this->Vip_model->getCount(1);
	        $data['videoGenres'] = $this->Vip_model->getAllVideosGenres();
	        $data['songGenres'] = $this->Vip_model->getAllSongsGenres();
	        $data['crates'] = $slugs;
	        if(!empty($crateVideo)){
	        	$data['crateVideo'] = $this->Vip_model->getAllCrateSongs($crateVideo);
	        } else {
	        	$data['crateVideo'] = null;
	        }
	        if(!empty($crateMusic)){
	        	$data['crateMusic'] = $this->Vip_model->getAllCrateSongs($crateMusic);
	        } else {
	        	$data['crateMusic'] = null;
	        }
	        // pre($data,true);
            if($data['video'] == "active"){
            	$data['pageVideos'] = json_encode($data['videos'],true);
        	} else {
	        	$data['pageVideos'] = 0;
	        }
            if($data['song'] == "active"){
	        	$data['pageSongs'] = json_encode($data['songs'],true);
	        } else {
	        	$data['pageSongs'] = 0;
	        }
	        $this->load->view('index',$data);
	    }*/

	    public function index() {
	    	$data['queue'] = false;
	    	$user = $this->myauth->getUserId();
	    	if ($this->myauth->getUserId() == 1) {
	            $data['isPaid'] = true;
	            $sCount = $this->Vip_model->getSongsCountInQueue($user,1,'count',0,0);
				$vCount = $this->Vip_model->getSongsCountInQueue($user,2,'count',0,0);
				if($sCount > 0 || $vCount > 0){
					$data['queue'] = true;
				}
	        } else {
	            $data['isPaid'] = Am_Lite::getInstance()->checkPaid();
	            if($data['isPaid']){
		    		$sCount = $this->Vip_model->getSongsCountInQueue($user,1,'count',0,0);
					$vCount = $this->Vip_model->getSongsCountInQueue($user,2,'count',0,0);
					if($sCount > 0 || $vCount > 0){
						$data['queue'] = true;
					}
		    	}
	        }
	        $data['title'] = $this->Vip_model->getConfigs("title");
	        $data['banners'] = $this->Vip_model->getBanners();
	        $data['songs'] = $this->Vip_model->top20OfDay(1);
    		$data['trend'] = "Today's";
    		$data['videos'] = $this->Vip_model->top20OfDay(2);
    		
    		$data['isLogin'] = $this->myauth->isLogin();
    		$data['facebook'] = $this->Vip_model->getConfigs("facebook");
	        $data['youtube'] = $this->Vip_model->getConfigs("youtube");
	        $data['soundcloud'] = $this->Vip_model->getConfigs("soundcloud");
	        $data['vimeo'] = $this->Vip_model->getConfigs("vimeo");
	        $data['instagram'] = $this->Vip_model->getConfigs("instagram");
	        $data['about'] = $this->Vip_model->getConfigs("about-us");
	    	$this->load->view('index-new',$data);

	    }

	    public function weekTrending() {
	    	if ($this->myauth->getUserId() == 1) {
	            $data['isPaid'] = true;
	        } else {
	            $data['isPaid'] = Am_Lite::getInstance()->checkPaid();
	        }
	        $data['title'] = $this->Vip_model->getConfigs("title");
	        $data['songs'] = $this->Vip_model->top20OfWeek(1);
    		
    		$data['videos'] = $this->Vip_model->top20OfWeek(2);
    		$data['trend'] = "Week's";
    		$data['isLogin'] = $this->myauth->isLogin();
    		$data['facebook'] = $this->Vip_model->getConfigs("facebook");
	        $data['youtube'] = $this->Vip_model->getConfigs("youtube");
	        $data['soundcloud'] = $this->Vip_model->getConfigs("soundcloud");
	        $data['vimeo'] = $this->Vip_model->getConfigs("vimeo");
	        $data['instagram'] = $this->Vip_model->getConfigs("instagram");
    		
	    	$this->load->view('index-trending',$data);

	    }

	    public function monthTrending() {
	    	if ($this->myauth->getUserId() == 1) {
	            $data['isPaid'] = true;
	        } else {
	            $data['isPaid'] = Am_Lite::getInstance()->checkPaid();
	        }
	        $data['title'] = $this->Vip_model->getConfigs("title");
	        $data['songs'] = $this->Vip_model->top20OfMonth(1);
    		
    		$data['videos'] = $this->Vip_model->top20OfMonth(2);
    		$data['trend'] = "Month's";
    		$data['isLogin'] = $this->myauth->isLogin();
    		$data['facebook'] = $this->Vip_model->getConfigs("facebook");
	        $data['youtube'] = $this->Vip_model->getConfigs("youtube");
	        $data['soundcloud'] = $this->Vip_model->getConfigs("soundcloud");
	        $data['vimeo'] = $this->Vip_model->getConfigs("vimeo");
	        $data['instagram'] = $this->Vip_model->getConfigs("instagram");
    		
	    	$this->load->view('index-trending',$data);

	    }

	    public function yearTrending() {
	    	if ($this->myauth->getUserId() == 1) {
	            $data['isPaid'] = true;
	        } else {
	            $data['isPaid'] = Am_Lite::getInstance()->checkPaid();
	        }
	        $data['title'] = $this->Vip_model->getConfigs("title");
	        $data['songs'] = $this->Vip_model->top20OfYear(1);

    		$data['videos'] = $this->Vip_model->top20OfYear(2);
    		$data['trend'] = "Year's";
    		$data['isLogin'] = $this->myauth->isLogin();
    		$data['facebook'] = $this->Vip_model->getConfigs("facebook");
	        $data['youtube'] = $this->Vip_model->getConfigs("youtube");
	        $data['soundcloud'] = $this->Vip_model->getConfigs("soundcloud");
	        $data['vimeo'] = $this->Vip_model->getConfigs("vimeo");
	        $data['instagram'] = $this->Vip_model->getConfigs("instagram");
    		
	    	$this->load->view('index-trending',$data);

	    }

	    public function videos(){
	    	$user = $this->myauth->getUserId();
	    	$data['queue'] = false;
	    	if ($user == 1) {
	            $data['isPaid'] = true;
	            $vCount = $this->Vip_model->getSongsCountInQueue($user,2,'count',0,0);
				if($vCount > 0){
					$data['queue'] = true;
				}
	        } else {
	            if($user){
			    	$paid = Am_Lite::getInstance()->verifyUserAccess($user);
			    	if($paid['status'] == 1){
			    		$data['isPaid'] = true;
			    		$vCount = $this->Vip_model->getSongsCountInQueue($user,2,'count',0,0);
						if($vCount > 0){
							$data['queue'] = true;
						}
			    	} else {
			    		$data['isPaid'] = false;
			    	}
			    } else {
			    	$data['isPaid'] = false;
			    }
	        }
	        $slugs = array();
	        $crateVideo = array();
	        if(isset($_SESSION['crate']['video'])){
	        	foreach($_SESSION['crate']['video'] as $key => $val){
		    		foreach($val as $k => $v){
		    			array_push($slugs,$k);
		    			array_push($crateVideo,$k);
		    		}
		    	}	
	        }
	        $data['title'] = $this->Vip_model->getConfigs("title");
            $data['isLogin'] = $this->myauth->isLogin();
            $data['video'] = "active";
            $data['song'] = null;
            $data['videos'] = $this->Vip_model->getVideoList(20,0);
	        $data['facebook'] = $this->Vip_model->getConfigs("facebook");
	        $data['youtube'] = $this->Vip_model->getConfigs("youtube");
	        $data['soundcloud'] = $this->Vip_model->getConfigs("soundcloud");
	        $data['vimeo'] = $this->Vip_model->getConfigs("vimeo");
	        $data['instagram'] = $this->Vip_model->getConfigs("instagram");
	        $data['about'] = $this->Vip_model->getConfigs("about-us");
	        $data['videoCount'] = $this->Vip_model->getCount(2);
	        $data['videoGenres'] = $this->Vip_model->getAllVideosGenres();
	        $data['crates'] = $slugs;
	        if(!empty($crateVideo)){
	        	$data['crateVideo'] = $this->Vip_model->getAllCrateSongs($crateVideo);
	        } else {
	        	$data['crateVideo'] = null;
	        }
	        $data['pageVideos'] = json_encode($data['videos'],true);
	        // echo "<pre>";
	        // print_r($data);
	        // die();
        	$this->load->view('video',$data);
	    }

	    public function songs(){
	    	$user = $this->myauth->getUserId();
	    	$data['queue'] = false;
	    	if ($user == 1) {
	            $data['isPaid'] = true;
	            $sCount = $this->Vip_model->getSongsCountInQueue($user,1,'count',0,0);
				if($sCount > 0){
					$data['queue'] = true;
				}
	        } else {
	            // $data['isPaid'] = Am_Lite::getInstance()->checkPaid();
	            if($user){
			    	$paid = Am_Lite::getInstance()->verifyUserAccess($user);
			    	if($paid['status'] == 1){
			    		$data['isPaid'] = true;
			    		$vCount = $this->Vip_model->getSongsCountInQueue($user,2,'count',0,0);
						if($sCount > 0){
							$data['queue'] = true;
						}
			    	} else {
			    		$data['isPaid'] = false;
			    	}
			    } else {
			    	$data['isPaid'] = false;
			    }
	        }
	        $slugs = array();
	        $crateMusic = array();
	        if(isset($_SESSION['crate']['song'])){
	        	foreach($_SESSION['crate']['song'] as $key => $val){
		    		foreach($val as $k => $v){
		    			array_push($slugs,$k);
		    			array_push($crateMusic,$k);
		    		}
		    	}	
	        }
	        $data['title'] = $this->Vip_model->getConfigs("title");
            $data['songs'] = $this->Vip_model->getSongsList(20,0);	
            $data['isLogin'] = $this->myauth->isLogin();
            $data['facebook'] = $this->Vip_model->getConfigs("facebook");
	        $data['youtube'] = $this->Vip_model->getConfigs("youtube");
	        $data['soundcloud'] = $this->Vip_model->getConfigs("soundcloud");
	        $data['vimeo'] = $this->Vip_model->getConfigs("vimeo");
	        $data['instagram'] = $this->Vip_model->getConfigs("instagram");
	        $data['about'] = $this->Vip_model->getConfigs("about-us");
	        $data['songCount'] = $this->Vip_model->getCount(1);
	        $data['songGenres'] = $this->Vip_model->getAllSongsGenres();
	        $data['crates'] = $slugs;
	        $data['song'] = "active";
	        $data['video'] = null;
	        if(!empty($crateMusic)){
	        	$data['crateMusic'] = $this->Vip_model->getAllCrateSongs($crateMusic);
	        } else {
	        	$data['crateMusic'] = null;
	        }
	        // pre($data,true);
            $data['pageSongs'] = json_encode($data['songs'],true);
	        $this->load->view('video',$data);
	    }

	    public function search(){
	    	$user = $this->myauth->getUserId();
	    	$data['queue'] = false;
	    	if ($user == 1) {
	            $data['isPaid'] = true;
	            $sCount = $this->Vip_model->getSongsCountInQueue($user,1,'count',0,0);
	            $vCount = $this->Vip_model->getSongsCountInQueue($user,2,'count',0,0);
				if($sCount > 0 || $vCount > 0){
					$data['queue'] = true;
				}
	        } else {
	            // $data['isPaid'] = Am_Lite::getInstance()->checkPaid();
	            if($user){
			    	$paid = Am_Lite::getInstance()->verifyUserAccess($user);
			    	if($paid['status'] == 1){
			    		$data['isPaid'] = true;
			    		$vCount = $this->Vip_model->getSongsCountInQueue($user,2,'count',0,0);
			    		$vCount = $this->Vip_model->getSongsCountInQueue($user,2,'count',0,0);
						if($sCount > 0 || $vCount > 0){
							$data['queue'] = true;
						}
			    	} else {
			    		$data['isPaid'] = false;
			    	}
			    } else {
			    	$data['isPaid'] = false;
			    }
	        }
	        $data['title'] = $this->Vip_model->getConfigs("title");
            $data['songs'] = $this->Vip_model->getSongsList(20,0);	
            $data['isLogin'] = $this->myauth->isLogin();
            $data['facebook'] = $this->Vip_model->getConfigs("facebook");
	        $data['youtube'] = $this->Vip_model->getConfigs("youtube");
	        $data['soundcloud'] = $this->Vip_model->getConfigs("soundcloud");
	        $data['vimeo'] = $this->Vip_model->getConfigs("vimeo");
	        $data['instagram'] = $this->Vip_model->getConfigs("instagram");
	        $data['about'] = $this->Vip_model->getConfigs("about-us");
	        $data['songCount'] = $this->Vip_model->getCount(1);
	        $data['songGenres'] = $this->Vip_model->getAllSongsGenres();
	        $data['videoCount'] = $this->Vip_model->getCount(2);
	        $data['songCount'] = $this->Vip_model->getCount(1);
	        $data['videoGenres'] = $this->Vip_model->getAllVideosGenres();
	        $data['songGenres'] = $this->Vip_model->getAllSongsGenres();
	        
	        	        
	        $this->load->view('search',$data);
	    }

	    public function crate(){
	    	$user = $this->myauth->getUserId();
	    	$data['queue'] = false;
	    	if ($user == 1) {
	            $data['isPaid'] = true;
	            $sCount = $this->Vip_model->getSongsCountInQueue($user,1,'count',0,0);
	            $vCount = $this->Vip_model->getSongsCountInQueue($user,2,'count',0,0);
				if($sCount > 0 || $vCount > 0){
					$data['queue'] = true;
				}
	        } else {
	            // $data['isPaid'] = Am_Lite::getInstance()->checkPaid();
	            if($user){
			    	$paid = Am_Lite::getInstance()->verifyUserAccess($user);
			    	if($paid['status'] == 1){
			    		$data['isPaid'] = true;
			    		$vCount = $this->Vip_model->getSongsCountInQueue($user,2,'count',0,0);
			    		$vCount = $this->Vip_model->getSongsCountInQueue($user,2,'count',0,0);
						if($sCount > 0 || $vCount > 0){
							$data['queue'] = true;
						}
			    	} else {
			    		$data['isPaid'] = false;
			    	}
			    } else {
			    	$data['isPaid'] = false;
			    }
	        }

	        $slugs = array();
	        $crateVideo = array();
	        $crateMusic = array();
	        if(isset($_SESSION['crate']['video'])){
	        	foreach($_SESSION['crate']['video'] as $key => $val){
		    		foreach($val as $k => $v){
		    			array_push($slugs,$k);
		    			array_push($crateVideo,$k);
		    		}
		    	}	
	        }
	        if(isset($_SESSION['crate']['song'])){
	        	foreach($_SESSION['crate']['song'] as $key => $val){
		    		foreach($val as $k => $v){
		    			array_push($slugs,$k);
		    			array_push($crateMusic,$k);
		    		}
		    	}	
	        }

	        $data['title'] = $this->Vip_model->getConfigs("title");
            $data['songs'] = $this->Vip_model->getSongsList(20,0);	
            $data['isLogin'] = $this->myauth->isLogin();
            $data['facebook'] = $this->Vip_model->getConfigs("facebook");
	        $data['youtube'] = $this->Vip_model->getConfigs("youtube");
	        $data['soundcloud'] = $this->Vip_model->getConfigs("soundcloud");
	        $data['vimeo'] = $this->Vip_model->getConfigs("vimeo");
	        $data['instagram'] = $this->Vip_model->getConfigs("instagram");
	        $data['about'] = $this->Vip_model->getConfigs("about-us");
	        $data['songCount'] = $this->Vip_model->getCount(1);
	        $data['songGenres'] = $this->Vip_model->getAllSongsGenres();
	        $data['videoCount'] = $this->Vip_model->getCount(2);
	        $data['songCount'] = $this->Vip_model->getCount(1);
	        $data['videoGenres'] = $this->Vip_model->getAllVideosGenres();
	        $data['songGenres'] = $this->Vip_model->getAllSongsGenres();
	        $data['crates'] = $slugs;
	        if(!empty($crateVideo)){
	        	$data['crateVideo'] = $this->Vip_model->getAllCrateSongs($crateVideo);
	        } else {
	        	$data['crateVideo'] = null;
	        }
	        if(!empty($crateMusic)){
	        	$data['crateMusic'] = $this->Vip_model->getAllCrateSongs($crateMusic);
	        } else {
	        	$data['crateMusic'] = null;
	        }
	        	        
	        $this->load->view('crate',$data);
	    }

	    public function genreFilter(){
	    	$parent = $_POST['parent'];
	    	$genres = $this->Vip_model->getGenres($parent);
	    	echo json_encode($genres,true);
	    }

	    public function subGenreFilter(){

	    	$genreSlug = $_POST['genre'];
	    	$subGenres = $this->Vip_model->getSubGenres($genreSlug);
	    	echo json_encode($subGenres,true);

	    }

	    public function getTrackInfo(){
	    	// if ($this->myauth->getUserId() == 1) {
	     //        $data['isPaid'] = true;
	     //    } else {
	     //        $data['isPaid'] = Am_Lite::getInstance()->checkPaid();
	     //    }
	     //    if(!$data['isPaid']){
	     //    	return false;
	     //    }
	    	$slug = $_POST['track'];
	    	$song = $this->Vip_model->getSample($slug,null);

	    	// $songArr = explode(" ", $song[0]->songName);
	    	$artistArr = explode(" ", $song[0]->artistName);
	    	$songText = "";
	    	$blank = false;
	    	$type = $song[0]->songType;
	    	// if(empty($songArr[0])){
	    	// 	$blank = true;
	    	// 	if(!empty($songArr[2])){
	    	// 		if(strpos($songArr[2],"(") > 0){
		    // 			$songText = $songArr[1];	
		    // 		} else {
		    // 			$songText = $songArr[0]." ".$songArr[1]." ".$songArr[2];
		    // 		}
	    	// 	} else {
	    	// 		if(strpos($songArr[1],"(") > 0){
		    // 			$songText = $songArr[0];	
		    // 		} else {
		    // 			$songText = $songArr[0]." ".$songArr[1];
		    // 		}
	    	// 	}
	    	// } else {
	    	// 	$songText = $songArr[0]." ". $songArr[1];
	    	// }
	    	$songArr = explode(" (", $song[0]->songName);
            $songText = $songArr[0];

	    	$data['songsList'] = $this->Vip_model->getAllVersions($songText,$artistArr[0],$song[0]->genre,$blank,$type);
	    	echo json_encode($data);

	    }

	    public function filterSongByGenre(){
	    	$genreSlug = $_POST['genre'];
	    	$songsList = $this->Vip_model->getListByGenre($genreSlug);
	    	$data['count'] = ceil(sizeof($songsList['list'])/20);
	    	$data['songsList']['list'] = get20FromList($songsList['list']);
			$data['songsList']['download'] = get20FromList($songsList['download']);
	    	echo json_encode($data);
	    }

	    public function filterSongBySubGenre(){
	    	$genreSlug = $_POST['genre'];
	    	$songsList = $this->Vip_model->getListBySubGenre($genreSlug);
	    	$data['count'] = ceil(sizeof($songsList['list'])/20);
	    	$data['songsList']['list'] = get20FromList($songsList['list']);
			$data['songsList']['download'] = get20FromList($songsList['download']);
	    	echo json_encode($data);
	    }

	    public function filterSongBySubSubGenre(){
	    	$genreSlug = $_POST['genre'];
	    	$songsList = $this->Vip_model->getListBySubSubGenre($genreSlug);
	    	$data['count'] = ceil(sizeof($songsList['list'])/20);
	    	$data['songsList']['list'] = get20FromList($songsList['list']);
			$data['songsList']['download'] = get20FromList($songsList['download']);
	    	echo json_encode($data);
	    }

	    public function pagination(){
	    	if ($this->myauth->getUserId() == 1) {
	            $data['isPaid'] = true;
	        } else {
	            $data['isPaid'] = Am_Lite::getInstance()->checkPaid();
	        }
	        // if(!$data['isPaid']){
	        // 	return false;
	        // }
	    	$genreSlug = $_POST['genre'];
	    	$subGenreSlug = $_POST['subGenre'];
	    	$subSubGenreSlug = $_POST['subSubGenre'];
	    	$offset = $_POST['page'];
	    	$type = $_POST['type'];
	    	$data['songList'] = "";
	    	if($genreSlug == "" && $subGenreSlug == ""){
	    		if($type == "music"){
		    		$data['songsList'] = $this->Vip_model->getSongsList(20,($offset - 1));
		    	} else {
		    		$data['songsList'] = $this->Vip_model->getVideoList(20,($offset - 1));
		    	}
	    	} elseif($genreSlug != "" && $subGenreSlug == "") {
 				$data['songsList'] = $this->Vip_model->getListByGenrePage($genreSlug,20,$offset);
		    } else if($subSubGenreSlug == ""){
	    		$data['songsList'] = $this->Vip_model->getListBySubGenrePage($subGenreSlug,20,$offset);
	    	} else {
	    		$data['songsList'] = $this->Vip_model->getListBySubSubGenrePage($subSubGenreSlug,20,$offset);
	    	}
	    	echo json_encode($data);
	    }

	    public function videoGenreFilter(){
	    	
	    }

	    public function songVideoSearch(){
	    	$query = $_POST['query'];
        	$type = $_POST['type'];
        	if(isset($_POST['page'])){
	    		$offset = $_POST['page'];
	    	} else {
	    		$offset = 1;
	    	}
        	$data['count'] = ceil($this->Vip_model->searchTotalSong($query, $type, null)/20);
        	$data['songList'] = $this->Vip_model->searchSong($query, $type, null, 20, $offset);
        	echo json_encode($data);
	    }

	    public function artistSongSearch(){
	    	$query = $_POST['query'];
        	$filter = $_POST['filter'];
        	if(isset($_POST['page'])){
	    		$offset = $_POST['page'];
	    	} else {
	    		$offset = 1;
	    	}

        	$data['count'] = ceil($this->Vip_model->searchTotalSong($query, 0, $filter)/20);
        	$data['songList'] = $this->Vip_model->searchSong($query, 0, $filter, 20, $offset);
        	echo json_encode($data);
	    }

	    public function genreSearch(){
	    	$query = $_POST['query'];
        	$parent = $_POST['parent'];
        	$genre = $_POST['genre'];
        	$subgenre = $_POST['subgenre'];

        	if(isset($_POST['page'])){
	    		$offset = $_POST['page'];
	    	} else {
	    		$offset = 1;
	    	}

	    	$data['count'] = ceil($this->Vip_model->searchTotalGenreSong($query, $genre, $subgenre)/20);
        	$data['songList'] = $this->Vip_model->searchGenreSong($query, $genre, $subgenre, 20, $offset);
        	echo json_encode($data);
	    }

	    public function searchPagination(){
			$query = $_POST['query'];
        	$type = $_POST['type'];
        	$filter = $_POST['filter'];
        	$offset = $_POST['page'];

        	$data['count'] = ceil($this->Vip_model->searchTotalSong($query, $type, $filter)/20);
        	$data['songList'] = $this->Vip_model->searchSong($query, $type, $filter, 20, $offset);
        	echo json_encode($data);	
	    }

	    public function bpmSearch(){
	    	$from = $_POST['from'];
	    	$to = $_POST['to'];
	    	if(isset($_POST['page'])){
	    		$offset = $_POST['page'];
	    	} else {
	    		$offset = 1;
	    	}
	    	

	    	$data['count'] = ceil($this->Vip_model->searchTotalBpmSong($from, $to)/20);
        	$data['songList'] = $this->Vip_model->searchBpmSong($from, $to, 20, $offset);
        	echo json_encode($data);
	    }

	    public function bpmSearchPagination(){
	    	$from = $_POST['from'];
	    	$to = $_POST['to'];
	    	$page = $_POST['page'];
	    	
	    	$data['count'] = ceil($this->Vip_model->searchTotalBpmSong($from, $to)/20);
        	$data['songList'] = $this->Vip_model->searchBpmSong($from, $to, 20, $page);
        	echo json_encode($data);
	    }

	    public function getSampleUrl(){
	    	if ($this->myauth->getUserId() == 1) {
	            $data['isPaid'] = true;
	        } else {
	            $data['isPaid'] = Am_Lite::getInstance()->checkPaid();
	        }
	    	$slug = $_POST['slug'];
	    	$filePath = $this->Vip_model->getSample($slug,"play");
	    	// if($filePath[0]->songType == 1){
	    	// 	$path = "/assets/sample/songs/".$filePath[0]->fileName;
	    	// } else {
	    	// 	$path = "/assets/sample/videos/".$filePath[0]->fileName;
	    	// }
	    	$path = explode("../", $filePath[0]->filePath);
	    	$data['file'] = '/v3/'.$path[1];
	    	$data['type'] = $filePath[0]->songType;
	    	$data['songName'] = $filePath[0]->songName;
	    	// if(!headers_sent()){
		    	header('Content-Type: video/mp4');
		    	header('Content-Type: audio/mpeg');
				header('Accept-Ranges: bytes');
				header('Content-Encoding: none');
			// }
	    	echo json_encode($data);
	    }
/*
	    public function list(){
	    	$user = $this->myauth->getUserId();
	    	$data['queue'] = false;
	    	if ($user == 1) {
	            $data['isPaid'] = true;
	            $sCount = $this->Vip_model->getSongsCountInQueue($user,1,'count',0,0);
				$vCount = $this->Vip_model->getSongsCountInQueue($user,2,'count',0,0);
				if($sCount > 0 || $vCount > 0){
					$data['queue'] = true;
				}
	        } else {
	            // $data['isPaid'] = Am_Lite::getInstance()->checkPaid();
	            if($user){
			    	$paid = Am_Lite::getInstance()->verifyUserAccess($user);
			    	if($paid['status'] == 1){
			    		$data['isPaid'] = true;
			    		$sCount = $this->Vip_model->getSongsCountInQueue($user,1,'count',0,0);
						$vCount = $this->Vip_model->getSongsCountInQueue($user,2,'count',0,0);
						if($sCount > 0 || $vCount > 0){
							$data['queue'] = true;
						}
			    	} else {
			    		$data['isPaid'] = false;
			    	}
			    } else {
			    	$data['isPaid'] = false;
			    }
	        }
	        $slugs = array();
	        
	        $data['title'] = "Videos/Songs List";
            
            $data['song'] = $this->Vip_model->getConfigs("song");
            $data['video'] = $this->Vip_model->getConfigs("video");
            
            if($data['video'] == "active"){
            	$data['videos'] = $this->Vip_model->getVideoList(20,0);
	        }

	        if($data['song'] == "active"){
	        	$data['songs'] = $this->Vip_model->getSongsList(20,0);	
	        }
	        $data['facebook'] = $this->Vip_model->getConfigs("facebook");
	        $data['youtube'] = $this->Vip_model->getConfigs("youtube");
	        $data['soundcloud'] = $this->Vip_model->getConfigs("soundcloud");
	        $data['vimeo'] = $this->Vip_model->getConfigs("vimeo");
	        $data['instagram'] = $this->Vip_model->getConfigs("instagram");
	        $data['about'] = $this->Vip_model->getConfigs("about-us");
	        $data['videoCount'] = $this->Vip_model->getCount(2);
	        $data['songCount'] = $this->Vip_model->getCount(1);
	        $data['videoGenres'] = $this->Vip_model->getAllVideosGenres();
	        $data['songGenres'] = $this->Vip_model->getAllSongsGenres();
	        $data['crates'] = $slugs;
	        // pre($data,true);
            if($data['video'] == "active"){
            	$data['pageVideos'] = json_encode($data['videos'],true);
        	} else {
	        	$data['pageVideos'] = 0;
	        }
            if($data['song'] == "active"){
	        	$data['pageSongs'] = json_encode($data['songs'],true);
	        } else {
	        	$data['pageSongs'] = 0;
	        }
	        $this->load->view('index-new',$data);
	    }*/

	    public function validateDownload(){
	    	if ($this->myauth->getUserId() == 1) {
	            $data['isPaid'] = true;
	        } else {
	            $data['isPaid'] = Am_Lite::getInstance()->checkPaid();
	        }
	    	$slug = $_POST['slug'];
	    	$song = $this->Vip_model->getSample($slug,null);
	    	$validate = $this->Vip_model->validateDownload($song[0]->id);
	    	$data['validate'] = $validate;
	    	echo json_encode($data);
	    }

	    public function download(){
	    	if ($this->myauth->getUserId() == 1) {
	            $data['isPaid'] = true;
	        } else {
	            $data['isPaid'] = Am_Lite::getInstance()->checkPaid();
	        }
	        if(!$data['isPaid']){
	        	return false;
	        }
	    	$slug = $_POST['slug'];
	    	$song = $this->Vip_model->getSample($slug,null);
	    	$validate = $this->Vip_model->validateDownload($song[0]->id);
	    	if($validate < 3){
	    		$filePath = $this->Vip_model->getSample($slug,"download");
		    	//$path = explode("../", $filePath[0]->filePath);
		    	session_write_close();
	            $data = file_get_contents($filePath[0]->filePath);
	            force_download($filePath[0]->fileName, $data);
	            exit;
	    	} else {
	    		echo json_encode(array("msg" => "Maximum limit to download this Song is reached."));
	    		exit();
	    	}
	    }

	    public function addToCrate(){
	    	$slug = $_POST['slug'];
	    	$type = $_POST['type'];
	    	$song = $this->Vip_model->getSample($slug,null);
	    	$validate = $this->Vip_model->validateDownload($song[0]->id);
	    	
	    	$path = $song[0]->filePath;

	    	$data['songName'] = $song[0]->songName;
	    	$data['thumbnail'] = $song[0]->thumbnail;
	    	$data['artistName'] = $song[0]->artistName;
	    	$data['comment'] = $song[0]->comment;
	    	$data['songType'] = $song[0]->songType;
	    	$data['slug'] = $slug;
	    	$data['bpm'] = $song[0]->bpm;
	    	$data['createdAt'] = $song[0]->createdAt;

	    	if($validate >= 3){
	    		$data['isFull'] = false;
	    		$data['notify'] = "exist";
	    	} else {
	    		if (!isset($_SESSION['crate'])) {
		    		$_SESSION['crate'] = array();
		            $_SESSION['crate']['video'] = array();
		            $_SESSION['crate']['song'] = array();
	        	}
	        
		        $videoInCrate = count($_SESSION['crate']['video']);
		        $songInCrate = count($_SESSION['crate']['song']);
		        $crate[$slug] = $path;

		        if ($videoInCrate == 10 || $songInCrate == 40) {
		            $data['isFull'] = true;
		        } else {
		        	$data['isFull'] = false;
		        	if($type == "video"){
		        		if($videoInCrate == 0){
		        			$_SESSION['crate']['video'][] = $crate;
			        		$data['notify'] = null;
			        	} else {
			        		foreach ($_SESSION['crate']['video'] as $key => $val) {
			        			foreach($val as $k => $v){
					    			if($k == $slug){
					    				$data['notify'] = "Already in Crate";
					    				break;
					    			} else {
					    				$_SESSION['crate']['video'][] = $crate;	
					    				$data['notify'] = null;
					    				break;
					    			}
					    		}
			        		}
			        	}
			        } else {
			        	if($songInCrate == 0){
			        		$_SESSION['crate']['song'][] = $crate;
	        				// array_push($_SESSION['crate']['song'], $crate);
	        				$data['notify'] = null;
			        	} else {
			        		foreach ($_SESSION['crate']['song'] as $key => $val) {
			        			foreach($val as $k => $v){
					    			if($k == $slug){
					    				$data['notify'] = "Already in Crate";
					    				break;
					    			} else {
					    				$_SESSION['crate']['song'][] = $crate;	
					    				$data['notify'] = null;
					    				break;
					    			}
					    		}
			        		}
			        	}
			        }
		        }
	        }
	        echo json_encode($data);
	    }

	    public function removeFromCrate(){
	        $slug = $_POST['slug'];
	    	$type = $_POST['type'];
	    	
	    	foreach($_SESSION['crate'][$type] as $key => $val){
	    		foreach($val as $k => $v){
	    			if($k == $slug){
	    				unset($_SESSION['crate'][$type][$key]);
	    			}
	    		}
	    	}
	    	$data['msg'] = "removed";
	        echo json_encode($data);
	    }

	    public function downloadCrate(){
	    	if ($this->myauth->getUserId() == 1) {
	            $data['isPaid'] = true;
	        } else {
	            $data['isPaid'] = Am_Lite::getInstance()->checkPaid();
	        }
	        if(!$data['isPaid']){
	        	return false;
	        }
	    	$this->load->helper('string');
	        $files = array();
	        $slugs = array();
	        foreach($_SESSION['crate']['video'] as $key => $val){
	    		foreach($val as $k => $v){
	    			array_push($files,$v);
	    			array_push($slugs,$k);
	    		}
	    	}

	    	foreach($_SESSION['crate']['song'] as $key => $val){
	    		foreach($val as $k => $v){
	    			array_push($files,$v);
	    			array_push($slugs,$k);
	    		}
	    	}

	        function createZip($files, $zip_file) {
	            $zip = new ZipArchive;
	            if ($zip->open($zip_file, ZipArchive::OVERWRITE) === TRUE) {
	                foreach ($files as $file) {
	                	$file = str_replace("../assets",$_SERVER['DOCUMENT_ROOT']."/assets",$file);
	                    if (!file_exists($file)) {
                            die($file . ' does not exist');
                        }
                        if (!is_readable($file)) {
                            die($file . ' not readable');
                        }
                        $path = explode("/",$file);
                        $fileName = $path[sizeof($path)-1];
                        $zip->addFile($file, $fileName);
	                }
	                $zip->close();

	                $_SESSION['cart'] = array();
	                $_SESSION['cart']['video'] = array();
	                $_SESSION['cart']['song'] = array();
	                return true;
	            } else
	                return false;
	        }

	        $temp = time() . '.zip';
	        $zip_name = $temp;

	        if (createZip($files, $zip_name)) {
	            session_write_close();
	            if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/'. $zip_name)) {
	                header('Location: '.base_url() . $zip_name);
	            } else {
	                $dir = $_SERVER['DOCUMENT_ROOT'].'/';
	                $name = explode(".", $zip_name);
	                $name_of_zip = $name[0];
	                $root = scandir($dir);
	                foreach ($root as $value) {
	                    if ($value === '.' || $value === '..') {
	                        continue;
	                    }
	                    if (is_file($dir.$value)) {
	                        $extension = explode(".", $dir.$value);
	                        $ext = end($extension);
	                        if ($ext == 'zip' || $ext == 'php' || $ext == 'htaccess') {
	                            continue;
	                        } else {
	                            $created_zip_name = $extension[0];
	                            if ($created_zip_name == $name_of_zip) {
	                                rename($dir.$value, $dir.$zip_name);
	                                header('Location: '.base_url() . $zip_name);
	                            }
	                        }
	                    }
	                }
	            }
	            exit();
	        } else {
	            exit();
	        }

	    }

	    function test(){
	    	$str = "assets/videos/v Hip-Hop/v Original/Lorem Centre-Neeraj Kumar.mp4";

	    	$path = explode("/",$str);
	    	echo $path[sizeof($path)-1];
	    }

	    function contact(){
	    	$data['title'] = $this->Vip_model->getConfigs("title");
			$data['song'] = $this->Vip_model->getConfigs("song");
	    	$this->load->view('contact',$data);
	    }

	    function processContact(){
	    	$name = $_POST['name'];
	    	$subject = $_POST['subject'];
	    	$message = $_POST['message'];
	    	$email = $_POST['email'];
	    	if (isset($name) && isset($subject) && isset($message) && isset($email)) {
	            $name = $_POST['name'];
	            $subject = "Videotoolz Contact Us:" . $_POST['subject'];
	            $desc = $_POST['message'];
	            $email = $_POST['email'];
	           	//$to = 'neeraj24a@gmail.com';
	            $to = 'videotoolz.20@gmail.com';

	            $headers = "From: " . strip_tags($email) . "\r\n";
	            $headers .= "Reply-To: " . strip_tags($email) . "\r\n";
	            $headers .= "MIME-Version: 1.0\r\n";
	            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

	            $message = '<html><body>';
	            $message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
	            $message .= "<tr style='background: #eee;'><td><strong>Name:</strong> </td><td>" . strip_tags($name) . "</td></tr>";
	            $message .= "<tr><td><strong>Email:</strong> </td><td>" . strip_tags($email) . "</td></tr>";
	            $message .= "<tr><td><strong>Description:</strong> </td><td>" . strip_tags($desc) . "</td></tr>";
	            $message .= "</table>";
	            $message .= "</body></html>";

	            mail($to, $subject, $message, $headers);
				$data['msg'] = true;
	            //echo "true";
	        } else {
	        	//echo "false";
				$data['msg'] = false;
	        }
			echo json_encode($data, true);
	    }

	    public function getQueueList(){
	    	
	    	if($this->myauth->isLogin()){
	    		if ($this->myauth->getUserId() == 1) {
		            $data['isPaid'] = true;
		        } else {
		            $data['isPaid'] = Am_Lite::getInstance()->checkPaid();
		        }
				$user = $this->myauth->getUserId();
				$sCount = $this->Vip_model->getSongsCountInQueue($user,1,'count',0,0);
				$vCount = $this->Vip_model->getSongsCountInQueue($user,2,'count',0,0);
				
				$comSongCount = $this->Vip_model->getSongsCountInComplete($user,1,'count',0,0);
				$comVideoCount = $this->Vip_model->getSongsCountInComplete($user,2,'count',0,0);

				$data['title'] = $this->Vip_model->getConfigs("title");
		        $data['facebook'] = $this->Vip_model->getConfigs("facebook");
		        $data['youtube'] = $this->Vip_model->getConfigs("youtube");
		        $data['soundcloud'] = $this->Vip_model->getConfigs("soundcloud");
		        $data['vimeo'] = $this->Vip_model->getConfigs("vimeo");
		        $data['instagram'] = $this->Vip_model->getConfigs("instagram");
		        $data['about'] = $this->Vip_model->getConfigs("about-us");
				if($sCount > 0){
					$data['songs'] = $this->Vip_model->getSongsCountInQueue($user,1,'list',0,20);
	                $data['sCount'] = ceil($sCount/20);
	            } else {
	                $data['sCount'] = $sCount;
	                $data['songs'] = "";
	            }

	            if($vCount > 0){
					$data['videos'] = $this->Vip_model->getSongsCountInQueue($user,2,'list',0,20);
	                $data['vCount'] = ceil($vCount/20);
	            } else {
	                $data['vCount'] = $sCount;
	                $data['videos'] = "";
	            }

	            if($comSongCount > 0){
					$data['comSongs'] = $this->Vip_model->getSongsCountInComplete($user,1,'list',0,20);
	                $data['comSongCount'] = ceil($comSongCount/20);
	            } else {
	                $data['comSongCount'] = $comSongCount;
	                $data['comSongs'] = "";
	            }

	            if($comVideoCount > 0){
					$data['comVideos'] = $this->Vip_model->getSongsCountInComplete($user,2,'list',0,20);
	                $data['comVideoCount'] = ceil($comVideoCount/20);
	            } else {
	                $data['comVideoCount'] = $comVideoCount;
	                $data['comVideos'] = "";
	            }

	            $data['pageVideos'] = json_encode($data['videos'],true);
	            $data['pageSongs'] = json_encode($data['songs'],true);
	            // $data['pageVideos'] = json_encode($data['comVideos'],true);
	            // $data['pageSongs'] = json_encode($data['songs'],true);
	            

	            // echo "<pre>";
	            //     print_r($data);
	            //     die;
	            $this->load->view('index-queue',$data);

	    	} else {
	    		header("Location: ".base_url('member/login'));
	    	}
	    }

	    public function trending(){
	    	if ($this->myauth->getUserId() == 1) {
	            $data['isPaid'] = true;
	        } else {
	            $data['isPaid'] = Am_Lite::getInstance()->checkPaid();
	        }
	        $data['title'] = $this->Vip_model->getConfigs("title");
	        $data['dsongs'] = $this->Vip_model->top20OfDay(1);
    		$data['wsongs'] = $this->Vip_model->top20OfWeek(1);
    		$data['msongs'] = $this->Vip_model->top20OfMonth(1);
    		$data['ysongs'] = $this->Vip_model->top20OfYear(1);

    		$data['dvideos'] = $this->Vip_model->top20OfDay(2);
    		$data['wvideos'] = $this->Vip_model->top20OfWeek(2);
    		$data['mvideos'] = $this->Vip_model->top20OfMonth(2);
    		$data['yvideos'] = $this->Vip_model->top20OfYear(2);

    		$data['facebook'] = $this->Vip_model->getConfigs("facebook");
	        $data['youtube'] = $this->Vip_model->getConfigs("youtube");
	        $data['soundcloud'] = $this->Vip_model->getConfigs("soundcloud");
	        $data['vimeo'] = $this->Vip_model->getConfigs("vimeo");
	        $data['instagram'] = $this->Vip_model->getConfigs("instagram");
    		
	    	$this->load->view('index-trending',$data);
	    }

	    public function resize(){
	    	$page = $_GET['page'];
	    	$limit = $_GET['limit'];
	    	$videos = $this->Vip_model->getResizeVideos($page,$limit);
	    	// pre($videos,true);
	    	foreach($videos as $video){
	    		$file = str_replace('../', '', $video->thumbnail);
	    		if(file_exists ( $file )){
	    			$new_thumb = str_replace('../','',str_replace('videos', 'app', $video->thumbnail));

		    		$thumb = new Imagick($file);
					$thumb->resizeImage(53,53,Imagick::FILTER_LANCZOS,1);
					$thumb->writeImage($new_thumb);
					$thumb->destroy();
					pre($file);
	    		}
	    	}
	    }
	}

?>