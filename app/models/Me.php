<?php
 
class Me extends Eloquent {

	public static function get_not_processing_keyword()
	{
		$user = Auth::user();
		return Tag::where("owner_id", $user['id'])->where("status", 0)->count();
	}

	public static function get_total_keyword()
	{
		$user = Auth::user();
		return Keyword::where("owner_id", $user['id'])->count();
	}
 
	public static function get_total_post(){
		$user = Auth::user();
		$user_id = $user['id'];
		return UserPost::where("owner_id",$user_id)->count();
	}

	public static function get_total_connected_user(){
		$user = Auth::user();
		$user_id = $user['id'];
		return user::where("owner_id",$user_id)->count();
	}

	public static function get_not_processing_post(){
		$user = Auth::user();
		$user_id = $user['id'];

		return UserPost::where("owner_id",$user_id)->where("status",0)->count();
	}

	public static function get_total_tag(){
		$user = Auth::user();
		$user_id = $user['id'];
		$minimum_support = Configs::get("minimum_support");

		$tag_list = DB::table('tag')
							->select(DB::raw('count(name) as total , name'))
							->groupBy('name')
							->where("owner_id",$user_id)
							->orderBy('total','desc')
							->having('total', '>', $minimum_support)
							->get();
        return count($tag_list);
	}

	public static function generate_keyword($post_id = -1){
		$user = Auth::user();
		

		if($post_id !== -1){
			$post = UserPost::where("post_id",$post_id)->first();
			
			$segment = new Segment();
			$result  = $segment->get_segment_array($post->message);
			
			foreach($result as $each)
			{
				if(self::is_valid_tag($each)){
					$tag           = new Tag;
					$tag->post_id  = $post->post_id ;
					$tag->user_id  = $post->user_id ;
					$tag->name     = $each ;
					$tag->status   = 0 ;
					$tag->remove   = 0 ;
					$tag->owner_id = $user['id'];
					$tag->save();
				}
			}

			UserPost::where("post_id",$post_id)->update(array("status"=>1));
		}else{
			$posts = UserPost::where("owner_id",$user['id'])->where("status",0)->get();
			$segment = new Segment();

			foreach($posts as $post){
				$result  = $segment->get_segment_array($post->message);
				
				foreach($result as $each)
				{
					if(self::is_valid_tag($each)){
						$tag           = new Tag;
						$tag->post_id  = $post->post_id ;
						$tag->name     = $each ;
						$tag->status   = 0 ;
						$tag->remove   = 0 ;
						$tag->owner_id = $user['id'];
						$tag->save();
					}
				}

				UserPost::where("post_id",$post->post_id)->update(array("status"=>1));
			}
		}

		
	}



	public static function is_valid_tag($str)
	{
		$str = strtolower($str);
		$stopwords = array('a', 'about', 'above', 'above', 'across', 'after', 'afterwards', 'again', 'against', 'all', 'almost', 'alone', 'along', 'already', 'also','although','always','am','among', 'amongst', 'amoungst', 'amount',  'an', 'and', 'another', 'any','anyhow','anyone','anything','anyway', 'anywhere', 'are', 'around', 'as',  'at', 'back','be','became', 'because','become','becomes', 'becoming', 'been', 'before', 'beforehand', 'behind', 'being', 'below', 'beside', 'besides', 'between', 'beyond', 'bill', 'both', 'bottom','but', 'by', 'call', 'can', 'cannot', 'cant', 'co', 'con', 'could', 'couldnt', 'cry', 'de', 'describe', 'detail', 'do', 'done', 'down', 'due', 'during', 'each', 'eg', 'eight', 'either', 'eleven','else', 'elsewhere', 'empty', 'enough', 'etc', 'even', 'ever', 'every', 'everyone', 'everything', 'everywhere', 'except', 'few', 'fifteen', 'fify', 'fill', 'find', 'fire', 'first', 'five', 'for', 'former', 'formerly', 'forty', 'found', 'four', 'from', 'front', 'full', 'further', 'get', 'give', 'go', 'had', 'has', 'hasnt', 'have', 'he', 'hence', 'her', 'here', 'hereafter', 'hereby', 'herein', 'hereupon', 'hers', 'herself', 'him', 'himself', 'his', 'how', 'however', 'hundred', 'ie', 'if', 'in', 'inc', 'indeed', 'interest', 'into', 'is', 'it', 'its', 'itself', 'keep', 'last', 'latter', 'latterly', 'least', 'less', 'ltd', 'made', 'many', 'may', 'me', 'meanwhile', 'might', 'mill', 'mine', 'more', 'moreover', 'most', 'mostly', 'move', 'much', 'must', 'my', 'myself', 'name', 'namely', 'neither', 'never', 'nevertheless', 'next', 'nine', 'no', 'nobody', 'none', 'noone', 'nor', 'not', 'nothing', 'now', 'nowhere', 'of', 'off', 'often', 'on', 'once', 'one', 'only', 'onto', 'or', 'other', 'others', 'otherwise', 'our', 'ours', 'ourselves', 'out', 'over', 'own','part', 'per', 'perhaps', 'please', 'put', 'rather', 're', 'same', 'see', 'seem', 'seemed', 'seeming', 'seems', 'serious', 'several', 'she', 'should', 'show', 'side', 'since', 'sincere', 'six', 'sixty', 'so', 'some', 'somehow', 'someone', 'something', 'sometime', 'sometimes', 'somewhere', 'still', 'such', 'system', 'take', 'ten', 'than', 'that', 'the', 'their', 'them', 'themselves', 'then', 'thence', 'there', 'thereafter', 'thereby', 'therefore', 'therein', 'thereupon', 'these', 'they', 'thickv', 'thin', 'third', 'this', 'those', 'though', 'three', 'through', 'throughout', 'thru', 'thus', 'to', 'together', 'too', 'top', 'toward', 'towards', 'twelve', 'twenty', 'two', 'un', 'under', 'until', 'up', 'upon', 'us', 'very', 'via', 'was', 'we', 'well', 'were', 'what', 'whatever', 'when', 'whence', 'whenever', 'where', 'whereafter', 'whereas', 'whereby', 'wherein', 'whereupon', 'wherever', 'whether', 'which', 'while', 'whither', 'who', 'whoever', 'whole', 'whom', 'whose', 'why', 'will', 'with', 'within', 'without', 'would', 'yet', 'you', 'your', 'yours', 'yourself', 'yourselves', 'the');

		$thai = array('ไว้','ไม่','ไป','ได้','ให้','ใน','โดย','แห่ง','แล้ว','และ','แรก','แบบ','แต่','เอง','เห็น','เลย','เริ่ม','เรา','เมื่อ','เพื่อ','เพราะ','เป็นการ','เป็น','เปิดเผย','เปิด','เนื่องจาก','เดียวกัน','เดียว','เช่น','เฉพาะ','เคย','เข้า','เขา','อีก','อาจ','อะไร','ออก','อย่าง','อยู่','อยาก','หาก','หลาย','หลังจาก','หลัง','หรือ','หนึ่ง','ส่วน','ส่ง','สุด','สําหรับ','ว่า','วัน','ลง','ร่วม','ราย','รับ','ระหว่าง','รวม','ยัง','มี','มาก','มา','พร้อม','พบ','ผ่าน','ผล','บาง','น่า','นี้','นํา','นั้น','นัก','นอกจาก','ทุก','ที่สุด','ที่','ทําให้','ทํา','ทาง','ทั้งนี้','ทั้ง','ถ้า','ถูก','ถึง','ต้อง','ต่างๆ','ต่าง','ต่อ','ตาม','ตั้งแต่','ตั้ง','ด้าน','ด้วย','ดัง','ซึ่ง','ช่วง','จึง','จาก','จัด','จะ','คือ','ความ','ครั้ง','คง','ขึ้น','ของ','ขอ','ขณะ','ก่อน','ก็','การ','กับ','กัน','กว่า','กล่าว');
	
		if(is_numeric($str)) return false ;
		if(self::utf8_strlen($str) <= 5) return false ;
		if(self::utf8_strlen($str) > 30) return false ;	
		if(array_search($str, $stopwords)) return false;
		if(array_search($str, $thai)) return false;
		return true ;
	}

	public static function utf8_strlen($s) {
		$c = strlen($s); $l = 0;
		for ($i = 0; $i < $c; ++$i) if ((ord($s[$i]) & 0xC0) != 0x80) ++$l;
		return $l;
	}
}


?>