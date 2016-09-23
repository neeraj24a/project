<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Vip_model extends CI_Model {

    public function getAllSongsGenres() {
        $this->db->where('parent', 0);
        $this->db->where('type', 1);
        $this->db->where('is_djset', 0);
        $query = $this->db->get('genre');
        return $query->result();
    }

    public function getAllVideosGenres() {
        $this->db->where('parent', 0);
        $this->db->where('type', 2);
        $this->db->where('is_djset', 0);
        $query = $this->db->get('genre');
        return $query->result();
    }

    public function getGenreSlug($slug) {
        $this->db->where('slug', $slug);
        $query = $this->db->get('genre');
        return $query->result();
    }

    public function getGenres($parent) {
        if ($parent == "video") {
            $type = 2;
        } else {
            $type = 1;
        }

        $this->db->select('name,slug');
        $this->db->where('parent', 0);
        $this->db->where('is_djset', 0);
        $this->db->where('type', $type);
        $query = $this->db->get('genre');
        return $query->result();
    }

    public function getSubGenres($slug) {
        $genre = $this->getGenreSlug($slug);
        $this->db->select('name,slug');
        $this->db->where('is_djset', 0);
        $this->db->where('parent', $genre[0]->id);
        $this->db->where('type', $genre[0]->type);
        $query = $this->db->get('genre');
        return $query->result();
    }

    public function getListByGenre($slug) {
        $genre = $this->getGenreSlug($slug);
        $gId = $genre[0]->id;
        $query = $this->db->query("SELECT s.`songName`,s.`songType`,s.`slug`,s.`artistName`,s.`bpm`,s.`comment`,s.`thumbnail`,DATE_FORMAT(s.`createdAt`, '%m-%d-%Y') AS createdAt, g.`name` AS gName, sg.`name` AS sGname FROM `song_lists` s LEFT JOIN genre g ON s.`genre` = g.`id`  LEFT JOIN genre sg ON s.`subGenre` = sg.`id` WHERE s.`is_published` = 1 AND s.`genre` = $gId ORDER BY s.`id` DESC");
        //return $query->result();
		$list = array();
        $result = $query->result();
        foreach ($result as $key => $val) {
            $file = $this->getSample($val->slug, null);
            $list[$val->slug] = $this->validateDownload($file[0]->id);
        }
        $data["download"] = $list;
        $data["list"] = $result;
        return $data;
    }

    public function getListByGenrePage($slug, $limit = 20, $offset) {
        $offset = ($offset - 1) * 20;
        $genre = $this->getGenreSlug($slug);
        $gId = $genre[0]->id;
        $query = $this->db->query("SELECT s.`songName`,s.`songType`,s.`slug`,s.`artistName`,s.`bpm`,s.`comment`,s.`thumbnail`,DATE_FORMAT(s.`createdAt`, '%m-%d-%Y') AS createdAt, g.`name` AS gName, sg.`name` AS sGname FROM `song_lists` s LEFT JOIN genre g ON s.`genre` = g.`id`  LEFT JOIN genre sg ON s.`subGenre` = sg.`id` WHERE s.`is_published` = 1 AND s.`genre` = $gId ORDER BY  s.`id` DESC LIMIT $limit OFFSET $offset");
        //return $query->result();
		$list = array();
        $result = $query->result();
        foreach ($result as $key => $val) {
            $file = $this->getSample($val->slug, null);
            $list[$val->slug] = $this->validateDownload($file[0]->id);
        }
        $data["download"] = $list;
        $data["list"] = $result;
        return $data;
    }

    public function getListBySubGenre($slug) {
        $genre = $this->getGenreSlug($slug);
        $gId = $genre[0]->id;
        $query = $this->db->query("SELECT s.`songName`,s.`songType`,s.`slug`,s.`artistName`,s.`bpm`,s.`comment`,s.`thumbnail`,DATE_FORMAT(s.`createdAt`, '%m-%d-%Y') AS createdAt, g.`name` AS gName, sg.`name` AS sGname FROM `song_lists` s LEFT JOIN genre g ON s.`genre` = g.`id`  LEFT JOIN genre sg ON s.`subGenre` = sg.`id` WHERE s.`is_published` = 1 AND s.`subGenre` = $gId ORDER BY  s.`id` DESC");
        //return $query->result();
		$list = array();
        $result = $query->result();
        foreach ($result as $key => $val) {
            $file = $this->getSample($val->slug, null);
            $list[$val->slug] = $this->validateDownload($file[0]->id);
        }
        $data["download"] = $list;
        $data["list"] = $result;
        return $data;
    }

    public function getListBySubGenrePage($slug, $limit = 20, $offset) {
        $offset = ($offset - 1) * 20;
        $genre = $this->getGenreSlug($slug);
        $gId = $genre[0]->id;
        $query = $this->db->query("SELECT s.`songName`,s.`songType`,s.`slug`,s.`artistName`,s.`bpm`,s.`comment`,s.`thumbnail`,DATE_FORMAT(s.`createdAt`, '%m-%d-%Y') AS createdAt, g.`name` AS gName, sg.`name` AS sGname FROM `song_lists` s LEFT JOIN genre g ON s.`genre` = g.`id`  LEFT JOIN genre sg ON s.`subGenre` = sg.`id` WHERE s.`is_published` = 1 AND s.`subGenre` = $gId ORDER BY  s.`id` DESC LIMIT $limit OFFSET $offset");
        //return $query->result();
		$list = array();
        $result = $query->result();
        foreach ($result as $key => $val) {
            $file = $this->getSample($val->slug, null);
            $list[$val->slug] = $this->validateDownload($file[0]->id);
        }
        $data["download"] = $list;
        $data["list"] = $result;
        return $data;
    }

    public function getListBySubSubGenre($slug) {
        $genre = $this->getGenreSlug($slug);
        $gId = $genre[0]->id;
        $query = $this->db->query("SELECT s.`songName`,s.`songType`,s.`slug`,s.`artistName`,s.`bpm`,s.`comment`,s.`thumbnail`,DATE_FORMAT(s.`createdAt`, '%m-%d-%Y') AS createdAt, g.`name` AS gName, sg.`name` AS sGname FROM `song_lists` s LEFT JOIN genre g ON s.`genre` = g.`id`  LEFT JOIN genre sg ON s.`subGenre` = sg.`id` WHERE s.`is_published` = 1 AND s.`subSubGenre` = $gId ORDER BY  s.`id` DESC");
        //return $query->result();
		$list = array();
        $result = $query->result();
        foreach ($result as $key => $val) {
            $file = $this->getSample($val->slug, null);
            $list[$val->slug] = $this->validateDownload($file[0]->id);
        }
        $data["download"] = $list;
        $data["list"] = $result;
        return $data;
    }

    public function getListBySubSubGenrePage($slug, $limit, $offset) {
        $offset = ($offset - 1) * 20;
        $genre = $this->getGenreSlug($slug);
        $gId = $genre[0]->id;
        $query = $this->db->query("SELECT s.`songName`,s.`songType`,s.`slug`,s.`artistName`,s.`bpm`,s.`comment`,s.`thumbnail`,DATE_FORMAT(s.`createdAt`, '%m-%d-%Y') AS createdAt, g.`name` AS gName, sg.`name` AS sGname FROM `song_lists` s LEFT JOIN genre g ON s.`genre` = g.`id`  LEFT JOIN genre sg ON s.`subGenre` = sg.`id` WHERE s.`is_published` = 1 AND s.`subSubGenre` = $gId ORDER BY  s.`id` DESC LIMIT $limit OFFSET $offset");
        //return $query->result();
		$list = array();
        $result = $query->result();
        foreach ($result as $key => $val) {
            $file = $this->getSample($val->slug, null);
            $list[$val->slug] = $this->validateDownload($file[0]->id);
        }
        $data["download"] = $list;
        $data["list"] = $result;
        return $data;
    }

    public function getVideoSubgenres($id) {
        $this->db->where('parent', $id);
        $this->db->where('type', 2);
        $this->db->where('is_djset', 0);
        $query = $this->db->get('genre');
        return $query->result();
    }

    public function getSample($slug, $for) {
        $query = $this->db->query("SELECT `id`, `songType`, `songName`, `thumbnail`, `genre`, `bpm`, `comment`, `artistName`, `filePath`, `fileName`, `total_play`, `total_download`, DATE_FORMAT(`createdAt`, '%m-%d-%Y') AS createdAt FROM (`song_lists`) WHERE is_published = 1 AND `slug` = '$slug'");
        $file = $query->result();
        if (!empty($file)) {
            $song_id = $file[0]->id;
            $type = $file[0]->songType;

            if ($for == "play") {
                $total_play = $file[0]->total_play + 1;
                $data = array('total_play' => $total_play);
                $this->db->where('id', $song_id);
                $this->db->update('song_lists', $data);
            } else if ($for == "download") {
                $total_download = $file[0]->total_download + 1;
                $data = array('total_download' => $total_download);
                $this->db->where('id', $song_id);
                $this->db->update('song_lists', $data);

                $user = $this->myauth->getUserId();
                $this->db->set('songs', $song_id);
                $this->db->set('songType', $type);
                $this->db->set('created_at', date('Y-m-d H:i:s'));
                $this->db->set('updated_at', date('Y-m-d H:i:s'));
                $this->db->set('user_id', $user);
                $this->db->insert('downloads');
            }

            return $file;
        }
        return null;
    }

    public function fromCrate($slug) {
        $this->db->select('id,total_download,songType');
        $this->db->where('slug', $slug);
        $query = $this->db->get("song_lists");
        $file = $query->result();
        if(!empty($file)){
            $song_id = $file[0]->id;
            $type = $file[0]->songType;

            $total_download = $file[0]->total_download + 1;
            $data = array('total_download' => $total_download);
            $this->db->where('id', $song_id);
            $this->db->update('song_lists', $data);

            $user = $this->myauth->getUserId();
            $this->db->set('songs', $song_id);
            $this->db->set('songType', $type);
            $this->db->set('created_at', date('Y-m-d H:i:s'));
            $this->db->set('updated_at', date('Y-m-d H:i:s'));
            $this->db->set('user_id', $user);
            $this->db->insert('downloads');
        }
    }

    public function getParentGenre($id) {
        
    }

    public function validateDownload($song) {

        $user = $this->myauth->getUserId();
        $this->db->where('songs', $song);
        $this->db->where('user_id', $user);
        $query = $this->db->get('downloads');
        $checkSong = $query->num_rows();
        return $checkSong;
    }

    public function getAllDownloadByUser($user) {
        $this->db->where('user_id', $user);
        $query = $this->db->get('downloads');
        return $query->result();
    }

    public function getSongsList($limit = 5, $offset) {
        $offset = $offset * 20;
        $query = $this->db->query("SELECT s.`songName`,s.`songType`,s.`slug`,s.`artistName`,s.`bpm`,s.`comment`,s.`thumbnail`,DATE_FORMAT(s.`createdAt`, '%m-%d-%Y') AS createdAt, g.`name` AS gName, sg.`name` AS sGname FROM `song_lists` s LEFT JOIN genre g ON s.`genre` = g.`id`  LEFT JOIN genre sg ON s.`subGenre` = sg.`id` WHERE s.`is_published` = 1 AND s.`songType` = 1 ORDER BY s.`id` DESC LIMIT $limit OFFSET $offset");
        // return $query->result();
        $list = array();
        $result = $query->result();
        foreach ($result as $key => $val) {
            $file = $this->getSample($val->slug, null);
            $list[$val->slug] = $this->validateDownload($file[0]->id);
        }
        $data["download"] = $list;
        $data["list"] = $result;
        return $data;
    }

    public function getCount($type) {
        $this->db->where('is_published', 1);
        $this->db->where('songType', $type);
        $query = $this->db->get('song_lists');
        if ($query->num_rows() % 20 > 0) {
            return ceil($query->num_rows() / 20) + 1;
        } else {
            return ceil($query->num_rows() / 20);
        }
    }

    public function getVideoList($limit = 5, $offset) {
        $offset = $offset * 20;
        $query = $this->db->query("SELECT s.`songName`,s.`songType`,s.`slug`,s.`artistName`,s.`bpm`,s.`comment`,s.`thumbnail`,DATE_FORMAT(s.`createdAt`, '%m-%d-%Y') AS createdAt, g.`name` AS gName, sg.`name` AS sGname FROM `song_lists` s LEFT JOIN genre g ON s.`genre` = g.`id`  LEFT JOIN genre sg ON s.`subGenre` = sg.`id` WHERE s.`is_published` = 1 AND s.`songType` = 2 ORDER BY s.`id` DESC LIMIT $limit OFFSET $offset");
        // return $query->result();
        $list = array();
        $result = $query->result();
        foreach ($result as $key => $val) {
            $file = $this->getSample($val->slug, null);
            if(!empty($file)){
                $list[$val->slug] = $this->validateDownload($file[0]->id);
            }
        }
        $data["download"] = $list;
        $data["list"] = $result;
        return $data;
    }

    public function searchTotalSong($string, $type, $filter) {
        if ($string) {

            $sql = "SELECT * FROM (`song_lists`) WHERE (`is_published` = 1 AND ";
            $where = '';
            $end_check = false;

            if ($type != 0) {
                $where .= "`songType` = $type) ";
            }

            if ($filter == 'artist') {
                if ($type == 0) {
                    $where .= "`artistName` LIKE '$string%' OR `artistName` LIKE '%$string' OR `artistName` LIKE '%$string%') ";
                } else {
                    $where .= "AND (`artistName` LIKE '$string%' OR `artistName` LIKE '%$string' OR `artistName` LIKE '%$string%') ";
                }

                $end_check = true;
            } else if ($filter == 'song') {
                if ($type == 0) {
                    $where .= "`songName` LIKE '$string%' OR `songName` LIKE '%$string' OR `songName` LIKE '%$string%') ";
                } else {
                    $where .= "AND (`songName` LIKE '$string%' OR `songName` LIKE '%$string' OR `songName` LIKE '%$string%') ";
                }

                $end_check = true;
            } else {
                if ($type == 0) {
                    $where .= "`artistName` LIKE '$string%' OR `artistName` LIKE '%$string' OR `artistName` LIKE '%$string%' OR `songName` LIKE '$string%' OR `songName` LIKE '%$string' OR `songName` LIKE '%$string%' )";
                } else {
                    $where .= "AND (`artistName` LIKE '$string%' OR `artistName` LIKE '%$string' OR `artistName` LIKE '%$string%' OR `songName` LIKE '$string%' OR `songName` LIKE '%$string' OR `songName` LIKE '%$string%' )";
                }

                $end_check = true;
            }

            $query = $this->db->query($sql . $where);
            $result = $query->num_rows();
            return $result;
        } else {
            return 0;
        }
    }

    public function searchSong($string, $type, $filter, $limit = 5, $offset) {
        $offset = ($offset - 1) * 20;
        if ($string) {
            $sql = "SELECT s.`songName`,s.`songType`,s.`slug`,s.`artistName`,s.`bpm`,s.`comment`,s.`thumbnail`,DATE_FORMAT(s.`createdAt`, '%m-%d-%Y') AS createdAt, g.`name` AS gName, sg.`name` AS sGname FROM `song_lists` s LEFT JOIN genre g ON s.`genre` = g.`id`  LEFT JOIN genre sg ON s.`subGenre` = sg.`id` WHERE ( s.`is_published` = 1 AND ";
            $where = '';
            $on_check = false;
            $end_check = false;

            if ($type != 0) {
                $where .= "s.`songType` = $type) ";
            }

            if ($filter == 'artist') {
                if ($type == 0) {
                    $where .= "s.`artistName` LIKE '$string%' OR s.`artistName` LIKE '%$string' OR s.`artistName` LIKE '%$string%') ";
                } else {
                    $where .= "AND (s.`artistName` LIKE '$string%' OR s.`artistName` LIKE '%$string' OR s.`artistName` LIKE '%$string%') ";
                }

                $end_check = true;
            } else if ($filter == 'song') {
                if ($type == 0) {
                    $where .= "s.`songName` LIKE '$string%' OR s.`songName` LIKE '%$string' OR s.`songName` LIKE '%$string%') ";
                } else {
                    $where .= "AND (s.`songName` LIKE '$string%' OR s.`songName` LIKE '%$string' OR s.`songName` LIKE '%$string%') ";
                }

                $end_check = true;
            } else {
                if ($type == 0) {
                    $where .= "s.`artistName` LIKE '$string%' OR s.`artistName` LIKE '%$string' OR s.`artistName` LIKE '%$string%' OR s.`songName` LIKE '$string%' OR s.`songName` LIKE '%$string' OR s.`songName` LIKE '%$string%' )";
                } else {
                    $where .= "AND (s.`artistName` LIKE '%$string%' OR s.`songName` LIKE '$string%' OR s.`songName` LIKE '%$string' OR s.`songName` LIKE '%$string%' )";
                }

                $end_check = true;
            }
            
            $order = " ORDER BY s.`id` DESC";
            $limit = " LIMIT " . $limit;
            $offset = " OFFSET " . $offset;
            // return $sql . $where . $order . $limit . $offset;

            $query = $this->db->query($sql . $where . $order . $limit . $offset);
//            return $query->result();
			$list = array();
			$result = $query->result();
			foreach ($result as $key => $val) {
				$file = $this->getSample($val->slug, null);
				$list[$val->slug] = $this->validateDownload($file[0]->id);
			}
			$data["download"] = $list;
			$data["list"] = $result;
			return $data;
        } else {
            return array();
        }
    }

    public function searchTotalGenreSong($query, $genreSlug, $subgenreSlug) {
        $genre = $this->getGenreSlug($genreSlug);

        $genreId = $genre[0]->id;

        if (!empty($subgenreSlug)) {
            $subgenre = $this->getGenreSlug($subgenreSlug);

            $subgenreId = $subgenre[0]->id;
        }

        $sql = "SELECT * FROM (`song_lists`) WHERE (";
        $where = '';
        if (!empty($query)) {
            if (!empty($subgenreSlug)) {
                $where .= "is_published = 1 AND genre = $genreId AND subGenre = $subgenreId) AND (`artistName` LIKE '%$query%' OR `songName` LIKE '%$query%')";
            } else {
                $where .= "is_published = 1 AND genre = $genreId) AND (`artistName` LIKE '%$query%' OR `songName` LIKE '%$query%')";
            }
        } else {
            if (!empty($subgenreSlug)) {
                $where .= "is_published = 1 AND genre = $genreId AND subGenre = $subgenreId)";
            } else {
                $where .= "is_published = 1 AND genre = $genreId)";
            }
        }

        $query = $this->db->query($sql . $where);
        $result = $query->num_rows();
        return $result;
    }

    public function searchGenreSong($query, $genreSlug, $subgenreSlug, $limit = 5, $offset) {
        $offset = ($offset - 1) * 20;
        $genre = $this->getGenreSlug($genreSlug);

        $genreId = $genre[0]->id;
        if (!empty($subgenreSlug)) {
            $subgenre = $this->getGenreSlug($subgenreSlug);

            $subgenreId = $subgenre[0]->id;
        }


        $sql = "SELECT s.`songName`,s.`songType`,s.`slug`,s.`artistName`,s.`bpm`,s.`comment`,s.`thumbnail`,DATE_FORMAT(s.`createdAt`, '%m-%d-%Y') AS createdAt, g.`name` AS gName, sg.`name` AS sGname FROM `song_lists` s LEFT JOIN genre g ON s.`genre` = g.`id`  LEFT JOIN genre sg ON s.`subGenre` = sg.`id` WHERE ( s.`is_published` = 1 AND ";
        $where = '';
        if (!empty($query)) {
            if (!empty($subgenreSlug)) {
                $where .= "s.genre = $genreId AND s.subGenre = $subgenreId) AND (s.`artistName` LIKE '%$query%' OR s.`songName` LIKE '%$query%')";
            } else {
                $where .= "s.genre = $genreId) AND (s.`artistName` LIKE '%$query%' OR s.`songName` LIKE '%$query%')";
            }
        } else {
            if (!empty($subgenreSlug)) {
                $where .= "s.genre = $genreId AND s.subGenre = $subgenreId)";
            } else {
                $where .= "s.genre = $genreId)";
            }
        }
        
        $order = " ORDER BY s.`id` DESC";
        $limit = " LIMIT " . $limit;
        $offset = " OFFSET " . $offset;
        // return $sql . $where . $order . $limit . $offset;
        $query = $this->db->query($sql . $where . $order . $limit . $offset);
        //return $query->result();
		$list = array();
		$result = $query->result();
		foreach ($result as $key => $val) {
			$file = $this->getSample($val->slug, null);
			$list[$val->slug] = $this->validateDownload($file[0]->id);
		}
		$data["download"] = $list;
		$data["list"] = $result;
		return $data;
    }

    public function searchTotalBpmSong($from, $to) {
        if (!empty($from) || !empty($to)) {

            $sql = "SELECT * FROM (`song_lists`) WHERE `is_published` = 1 AND ";
            $where = '';
            $on_check = false;
            $end_check = false;
            if (!empty($from) && !empty($to)) {
                $where = "`bpm` >= '$from' AND `bpm` <= '$to' ";
            } elseif (!empty($from) && empty($to)) {
                $where = "`bpm` >= '$from' ";
            } elseif (empty($from) && !empty($to)) {
                $where = "`bpm` <= '$to' ";
            } elseif (empty($from) && empty($to)) {
                $where = "`bpm` > '0' ";
            }

            $query = $this->db->query($sql . $where);
            $result = $query->num_rows();
            return $result;
        } else {
            return 0;
        }
    }

    public function searchBpmSong($from, $to, $limit = 5, $offset) {
        $offset = ($offset - 1) * 20;
        if (!empty($from) || !empty($to)) {

            $sql = "SELECT s.`songName`,s.`songType`,s.`slug`,s.`artistName`,s.`bpm`,s.`comment`,s.`thumbnail`,DATE_FORMAT(s.`createdAt`, '%m-%d-%Y') AS createdAt, g.`name` AS gName, sg.`name` AS sGname FROM `song_lists` s LEFT JOIN genre g ON s.`genre` = g.`id`  LEFT JOIN genre sg ON s.`subGenre` = sg.`id` WHERE ( s.`is_published` = 1 AND ";
            $where = '';
            $on_check = false;
            $end_check = false;
            if (!empty($from) && !empty($to)) {
                $where = "s.`bpm` >= '$from' AND s.`bpm` <= '$to' ";
            } elseif (!empty($from) && empty($to)) {
                $where = "s.`bpm` >= '$from' ";
            } elseif (empty($from) && !empty($to)) {
                $where = "s.`bpm` <= '$to' ";
            } elseif (empty($from) && empty($to)) {
                $where = "s.`bpm` > '0' ";
            }
            
            $order = " ORDER BY s.`id` DESC";
            $limit = " LIMIT " . $limit;
            $offset = " OFFSET " . $offset;

            // return $sql . $where . $order . $limit . $offset;

            $query = $this->db->query($sql . $where . $order . $limit . $offset);
            //$result = $query->result();
            $list = array();
			$result = $query->result();
			foreach ($result as $key => $val) {
				$file = $this->getSample($val->slug, null);
				$list[$val->slug] = $this->validateDownload($file[0]->id);
			}
			$data["download"] = $list;
			$data["list"] = $result;
			return $data;
        } else {
            return 0;
        }
    }

    public function getAllCrateSongs($songs) {
        $result = array();
        foreach ($songs as $song) {
            $sql = "SELECT songName,songType,slug,artistName,bpm,comment,thumbnail,DATE_FORMAT(createdAt,'%m-%d-%Y') AS createdAt,songType FROM (`song_lists`) WHERE `is_published` = 1 AND  slug = '$song'";
            $query = $this->db->query($sql);
            $rslt = $query->result();
            array_push($result, $rslt[0]);
        }

        return $result;
    }

    public function getConfigs($key) {
        $sql = "SELECT value FROM configs WHERE name = '$key'";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result[0]->value;
    }

    public function checkTempAccess($email) {
        $sql = "SELECT email FROM temp_access WHERE email = '$email'";
        $query = $this->db->query($sql);
        $result = $query->result();
        if (isset($result[0]->email)) {
            return true;
        } else {
            return false;
        }
        // return $result[0]->email;
    }

    public function getBanners() {
        $sql = "SELECT * FROM banners ORDER BY createdAT DESC";
        $query = $this->db->query($sql);
        $result = $query->result();
	    	$banners = array();
	    	foreach($result as $r){
	    		$id = $r->id;
	    		$banner_sql = "SELECT `image`,`loading_time`,`position`,`from`,`step`,`link` FROM banners_images WHERE banner_id = $id";
	    		$banner_query = $this->db->query($banner_sql);
	    		$banner_result = $banner_query->result();
	    		array_push($banners, $banner_result);
	    	}
        return $banners;
    }

    public function getAllVersions($song,$artist,$genre,$blank,$type){
        // $this->db->select('id');
        // $this->db->where('parent', $genre);
        // $query = $this->db->get('genre');
        // $subgenres = $query->result();

        // pre($subgenres);
        $tracks = array();
        // foreach($subgenres as $subgenre){
            if($blank){
                $sql = "SELECT s.`songType`, s.`songName`,s.`slug`, s.`thumbnail`, s.`bpm`, s.`comment`, s.`artistName`, s.`filePath`, s.`fileName`, DATE_FORMAT(s.`createdAt`, '%m-%d-%Y') AS createdAt, g.`name` AS gName, sg.`name` AS sGname FROM `song_lists` s LEFT JOIN genre g ON s.`genre` = g.`id`  LEFT JOIN genre sg ON s.`subGenre` = sg.`id` WHERE s.`is_published` = 1 AND s.`songType` = ".$type." AND `songName` LIKE '".$song."%' AND `artistName` LIKE '".$artist."%'";
            } else {
                $sql = "SELECT s.`songType`, s.`songName`,s.`slug`, s.`thumbnail`, s.`bpm`, s.`comment`, s.`artistName`, s.`filePath`, s.`fileName`, DATE_FORMAT(s.`createdAt`, '%m-%d-%Y') AS createdAt, g.`name` AS gName, sg.`name` AS sGname FROM `song_lists` s LEFT JOIN genre g ON s.`genre` = g.`id`  LEFT JOIN genre sg ON s.`subGenre` = sg.`id` WHERE s.`is_published` = 1 AND s.`songType` = ".$type." AND `songName` LIKE '".$song."%' AND `artistName` LIKE '".$artist."%'";           
            }
            
            // echo $sql;
            $s_query = $this->db->query($sql);
            $results = $s_query->result();
            // pre($result);
            if(!empty($results)){
                foreach($results as $result){
                    array_push($tracks, $result);
                }
            }
        // }
        return $tracks;
    }

    public function getSongsCountInQueue($user,$type,$for,$offset,$limit) {
        if($for == 'count'){
            $sql = "SELECT song FROM queue_list WHERE type = $type AND user = $user";
            $query = $this->db->query($sql);
            return $query->num_rows();    
        } else {
            $sql = "SELECT s.`songName`,s.`songType`,s.`thumbnail`,s.`slug`,s.`artistName`,s.`bpm`,s.`filePath`,s.`comment` AS songKey,DATE_FORMAT(s.`createdAt`, '%m-%d-%Y') AS createdAt, g.`name` AS gName, sg.`name` AS sGname FROM `queue_list` q LEFT JOIN song_lists s ON q.`song` = s.`id` LEFT JOIN genre g ON s.`genre` = g.`id`  LEFT JOIN genre sg ON s.`subGenre` = sg.`id` WHERE q.`type` = $type AND q.`user` = $user LIMIT $limit OFFSET $offset";
            $query = $this->db->query($sql);
            return $query->result();
        }
    }

    public function getSongsCountInComplete($user,$type,$for,$offset,$limit) {
        if($for == 'count'){
            $sql = "SELECT song FROM complete_list WHERE type = $type AND user = $user";
            $query = $this->db->query($sql);
            return $query->num_rows();    
        } else {
            $sql = "SELECT s.`songName`,s.`songType`,s.`thumbnail`,s.`slug`,s.`artistName`,s.`bpm`,s.`filePath`,s.`comment` AS songKey,DATE_FORMAT(s.`createdAt`, '%m-%d-%Y') AS createdAt, g.`name` AS gName, sg.`name` AS sGname FROM `complete_list` c LEFT JOIN song_lists s ON c.`song` = s.`id` LEFT JOIN genre g ON s.`genre` = g.`id`  LEFT JOIN genre sg ON s.`subGenre` = sg.`id` WHERE c.`type` = $type AND c.`user` = $user LIMIT $limit OFFSET $offset";
            $query = $this->db->query($sql);
            return $query->result();
        }
    }
    

    public function top20OfDay($type){
        $startDate = date('Y-m-d') . ' 00:00:00';
        $endDate = date('Y-m-d') . ' 23:59:59';
        $this->db->select('COUNT(*) AS nos, songs');
        $this->db->where('songType =', $type);
        $this->db->where('created_at >=', $startDate);
        $this->db->where('created_at <=', $endDate);
        $this->db->group_by('songs');
        $this->db->limit(20);
        $this->db->order_by('nos', 'DESC');
        $query = $this->db->get('downloads');
        $result = $query->result();

        $songList = array();
        $result1 = array();

        if ($result) {
            foreach ($result as $q1) {
                $songList[] = $q1->songs;
            }

            // set this to false so that _protect_identifiers skips escaping:
            $this->db->_protect_identifiers = FALSE;

            // $this->db->where_in('id', $songList);

            // your order_by line:
            // $this->db->order_by("FIELD (id, " . implode(',', $songList) . ")");
            // $query1 = $this->db->get('song_lists');
            $song_list = implode(',', $songList);
            $sql = "SELECT s.`songName`,s.`songType`,s.`slug`, s.`bpm`, s.`comment` AS `songKey`, s.`thumbnail`, s.`artistName`, s.`filePath`, s.`fileName`, DATE_FORMAT(s.`createdAt`, '%m-%d-%Y') AS createdAt, g.`name` AS gName, g.`color` AS genreColor, sg.`name` AS sGname, sg.`color` AS subGenreColor FROM `song_lists` s LEFT JOIN genre g ON s.`genre` = g.`id`  LEFT JOIN genre sg ON s.`subGenre` = sg.`id` WHERE s.`id` IN (".$song_list.") ORDER BY FIELD (s.`id`, ".$song_list.")";
            $query1 = $this->db->query($sql);
            // important to set this back to TRUE or ALL of your queries from now on will be non-escaped:
            $this->db->_protect_identifiers = TRUE;

            $result1 = $query1->result();
        }
        return $result1;
    }

    public function top20OfWeek($type){
        $startDate = date('Y-m-d 00:00:00', strtotime('monday this week'));
        $endDate = date('Y-m-d 23:59:59', strtotime('sunday this week'));

        $this->db->select('COUNT(*) AS nos, songs');
        $this->db->where('songType =', $type);
        $this->db->where('created_at >=', $startDate);
        $this->db->where('created_at <=', $endDate);
        $this->db->group_by('songs');
        $this->db->limit(20);
        $this->db->order_by('nos', 'DESC');
        $query = $this->db->get('downloads');
        $result = $query->result();

        $songList = array();
        $result1 = array();

        if ($result) {
            foreach ($result as $q1) {
                $songList[] = $q1->songs;
            }

            // set this to false so that _protect_identifiers skips escaping:
            $this->db->_protect_identifiers = FALSE;

            // $this->db->where_in('id', $songList);

            // your order_by line:
            // $this->db->order_by("FIELD (id, " . implode(',', $songList) . ")");
            // $query1 = $this->db->get('song_lists');
            $song_list = implode(',', $songList);
            $sql = "SELECT s.`songName`,s.`songType`,s.`slug`, s.`bpm`, s.`comment` AS `songKey`, s.`thumbnail`, s.`artistName`, s.`filePath`, s.`fileName`, DATE_FORMAT(s.`createdAt`, '%m-%d-%Y') AS createdAt, g.`name` AS gName, g.`color` AS genreColor, sg.`name` AS sGname, sg.`color` AS subGenreColor FROM `song_lists` s LEFT JOIN genre g ON s.`genre` = g.`id`  LEFT JOIN genre sg ON s.`subGenre` = sg.`id` WHERE s.`id` IN (".$song_list.") ORDER BY FIELD (s.`id`, ".$song_list.")";
            $query1 = $this->db->query($sql);
            // important to set this back to TRUE or ALL of your queries from now on will be non-escaped:
            $this->db->_protect_identifiers = TRUE;

            $result1 = $query1->result();
        }
        return $result1;
    }

    public function top20OfMonth($type){
        $startDate = date('Y-m-d 00:00:00', strtotime('first day of this month'));
        $endDate = date('Y-m-d 23:59:59', strtotime('last day of this month'));

        $this->db->select('COUNT(*) AS nos, songs');
        $this->db->where('songType =', $type);
        $this->db->where('created_at >=', $startDate);
        $this->db->where('created_at <=', $endDate);
        $this->db->group_by('songs');
        $this->db->limit(20);
        $this->db->order_by('nos', 'DESC');
        $query = $this->db->get('downloads');
        $result = $query->result();
    //return $this->db->last_query();
        $songList = array();
        $result1 = array();

        if ($result) {
            foreach ($result as $q1) {
                $songList[] = $q1->songs;
            }

            // set this to false so that _protect_identifiers skips escaping:
            $this->db->_protect_identifiers = FALSE;

            // $this->db->where_in('id', $songList);

            // your order_by line:
            // $this->db->order_by("FIELD (id, " . implode(',', $songList) . ")");
            // $query1 = $this->db->get('song_lists');
            $song_list = implode(',', $songList);
            $sql = "SELECT s.`songName`,s.`songType`,s.`slug`, s.`bpm`, s.`comment` AS `songKey`, s.`thumbnail`, s.`artistName`, s.`filePath`, s.`fileName`, DATE_FORMAT(s.`createdAt`, '%m-%d-%Y') AS createdAt, g.`name` AS gName, g.`color` AS genreColor, sg.`name` AS sGname, sg.`color` AS subGenreColor FROM `song_lists` s LEFT JOIN genre g ON s.`genre` = g.`id`  LEFT JOIN genre sg ON s.`subGenre` = sg.`id` WHERE s.`id` IN (".$song_list.") ORDER BY FIELD (s.`id`, ".$song_list.")";
            $query1 = $this->db->query($sql);
            // important to set this back to TRUE or ALL of your queries from now on will be non-escaped:
            $this->db->_protect_identifiers = TRUE;

            $result1 = $query1->result();
        }
        return $result1;
    }

    public function top20OfYear($type){
        $startDate = date('Y') . '-01-01 00:00:00';
        $endDate = date('Y') . '-12-31 00:00:00';

        $this->db->select('COUNT(*) AS nos, songs');
        $this->db->where('songType =', $type);
        $this->db->where('created_at >=', $startDate);
        $this->db->where('created_at <=', $endDate);
        $this->db->group_by('songs');
        $this->db->limit(20);
        $this->db->order_by('nos', 'DESC');
        $query = $this->db->get('downloads');
        $result = $query->result();

        $songList = array();
        $result1 = array();

        if ($result) {
            foreach ($result as $q1) {
                $songList[] = $q1->songs;
            }

            // set this to false so that _protect_identifiers skips escaping:
            $this->db->_protect_identifiers = FALSE;

            // $this->db->where_in('id', $songList);

            // your order_by line:
            // $this->db->order_by("FIELD (id, " . implode(',', $songList) . ")");
            // $query1 = $this->db->get('song_lists');
            $song_list = implode(',', $songList);
            $sql = "SELECT s.`songName`,s.`songType`,s.`slug`, s.`bpm`, s.`comment` AS `songKey`, s.`thumbnail`, s.`artistName`, s.`filePath`, s.`fileName`, DATE_FORMAT(s.`createdAt`, '%m-%d-%Y') AS createdAt, g.`name` AS gName, g.`color` AS genreColor, sg.`name` AS sGname, sg.`color` AS subGenreColor FROM `song_lists` s LEFT JOIN genre g ON s.`genre` = g.`id`  LEFT JOIN genre sg ON s.`subGenre` = sg.`id` WHERE s.`id` IN (".$song_list.") ORDER BY FIELD (s.`id`, ".$song_list.")";
            $query1 = $this->db->query($sql);
            // important to set this back to TRUE or ALL of your queries from now on will be non-escaped:
            $this->db->_protect_identifiers = TRUE;

            $result1 = $query1->result();
        }
        return $result1;
    }

    public function getResizeVideos($page,$limit){
        $offset = ($page - 1) * $limit;
        $sql = "SELECT * FROM song_lists WHERE songType = 2 ORDER BY id DESC LIMIT $limit OFFSET $offset";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

}

?>