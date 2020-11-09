    var S_sql = "Select ()"
        
        // count를 가져온다고 가정합시다 
        S_sql += "(select count(*) as cnt from 테이블 이름 where pk_id != '' ";
				if(조건문) 
        $S_sql += " ) AS (닉네임을 정해주세요)";

		$S_sql += "(select sum(금액) as total from 테이블 이름 where pk_id != '' ";
		$S_sql += " ) AS (닉네임) ";
				
        //limit를 사용해서 1나의 값만 가지고 옵니다
		$S_sql += " from 테이블 이름 limit 1";




