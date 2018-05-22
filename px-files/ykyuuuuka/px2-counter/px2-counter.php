<?php
	namespace ykyuuuuka\px2_counter;
	require_once(__DIR__.'/phpQuery-onefile.php');

	class ext{
		public static function px2_counter($px,$conf) {

			$text_box = '';

			foreach( $px->bowl()->get_keys() as $key ){
			    $val = $px->bowl()->get($key);

			    //取得したコードを変数に格納			
				$text_box = $text_box.$val;

			    //phpQuery関数の発火とaltの値を取得
			    $doc = \phpQuery::newDocumentHTML($val);
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

			// conposer.jsonで設定された値を取得
			if(isset($conf->minLength)) {
				$minLength = $conf ->minLength;
			} else {
				$minLength = '';
			}

			if(isset($conf->maxLength)) {
				$maxLength = $conf ->maxLength;
			} else {
				$maxLength = '';
			}

			//最大値・最小値のアラート
			if($minLength == '' && $maxLength == '') {
				$px->error('コンテンツエリアの文字数（altを含む）：'.$string.' 文字');
			} else if($minLength !== '') {
				if($string < $minLength) {
					$gap = $minLength-$string;
					$px->error('コンテンツエリアの文字数（altを含む）：'.$string.' 文字<br>不足文字数：'.$gap.' 文字');
				}
			} else if($maxLength !== '') {
				if($string > $maxLength) {
					$gap = $string-$maxLength;
					$px->error('コンテンツエリアの文字数（altを含む）：'.$string.' 文字<br>超過文字数：'.$gap.' 文字');
				}
			}

		}
	}





