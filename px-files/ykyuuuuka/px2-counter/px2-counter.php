<?php
	namespace ykyuuuuka\px2_counter;
	require_once(__DIR__.'/phpQuery-onefile.php');

	class ext{
		public static function px2_counter($px,$conf) {
			return false;

			$text_box = '';

			foreach( $px->bowl()->get_keys() as $key ){
			    $val = $px->bowl()->get($key);

			    //取得したコードを変数に格納			
				$text_box = $text_box.$val;

			    //phpQuery関数の発火とaltの値を取得
			    $doc = phpQuery::newDocumentHTML($val);
			    foreach($doc['img'] as $dom) {
			    	$val_alt = pq($dom) -> attr('alt');
			    	$text_box = $text_box.$val_alt;
			    }
			}

			//文字列からHTMLおよびPHPタグを削除・除去する
			$text_box = strip_tags($text_box);

			//文字列から半角空白と全角空白をすべて削除・除去する
			$text_box = preg_replace("/( |　)/", "", $text_box);

			//文字列から改行をすべて削除・除去する
			$text_box = preg_replace('/\r\n|\n|\r/', '', $text_box );

			//加工が終わった文字列の文字数を取得
			$string = mb_strlen($text_box,'UTF-8');
			if($string < $conf ->minLength) {
				$px->error($text_box.'<br><br>-->'.$string.'文字です');
			}
			if($string > $conf ->maxLength) {
				$px->error($text_box.'<br><br>-->'.$string.'文字です');
			}

		}
	}



