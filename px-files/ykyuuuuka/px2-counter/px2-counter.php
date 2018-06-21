<?php
	namespace ykyuuuuka\px2_counter;
	require_once(__DIR__.'/phpQuery-onefile.php');

	class ext{
		public static function px2_counter($px,$conf) {


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

			if(isset($conf->ignoreClass)) {
				$ignoreClass = $conf ->ignoreClass;
				$array_ignoreClass = explode(',',$ignoreClass);
			}

			//文字数カウントを実施
			$text_box = '';
			$text_box_ignore = '';

			//domをスクレイプ
			foreach( $px->bowl()->get_keys() as $key ){
				$val = $px->bowl()->get($key);

				//取得したコードを変数に格納			
				$text_box = $text_box.$val;

				//phpQuery関数の発火
				$doc = \phpQuery::newDocumentHTML($val);

				//altの値を取得
			    foreach($doc['img'] as $dom) {
					$val_alt = pq($dom) -> attr('alt');
					$text_box = $text_box.$val_alt;
				}

				//カウントから除外したいclassとaltの取得
				if(isset($array_ignoreClass)) {
					foreach ($array_ignoreClass as $id => $rec) {
						foreach($doc[$rec] as $dom) {
							$val_ignore_class = pq($dom) -> text();
							$val_ignore_class_alt = pq($dom)->find('img')->attr('alt');

							$text_box_ignore = $text_box_ignore.$val_ignore_class;
							$text_box_ignore = $text_box_ignore.$val_ignore_class_alt;
						}
					}
				}
			}

			//文字列からHTMLおよびPHPタグを削除・除去する
			$text_box = strip_tags($text_box);
			$text_box_ignore = strip_tags($text_box_ignore);

			//文字列から半角空白と全角空白をすべて削除・除去する
			$text_box = preg_replace("/( |　)/", "", $text_box);
			$text_box_ignore = preg_replace("/( |　)/", "", $text_box_ignore);

			//文字列から改行をすべて削除・除去する
			$text_box = preg_replace('/\r\n|\n|\r/', '', $text_box );
			$text_box_ignore = preg_replace('/\r\n|\n|\r/', '', $text_box_ignore );

			//加工が終わった文字列の文字数を取得
			$string_ignore = mb_strlen($text_box_ignore,'UTF-8');
			$string_all = mb_strlen($text_box,'UTF-8');
			$string_result = $string_all-$string_ignore;


			//最大値・最小値のアラート
			if($minLength == '' && $maxLength == '') {
				$px->error('コンテンツエリアの文字数（altを含む）：'.$string_result.' 文字');
			} else if($minLength !== '') {
				if($string < $minLength) {
					$gap = $minLength-$string_result;
					$px->error('コンテンツエリアの文字数（altを含む）：'.$string_result.' 文字<br>不足文字数：'.$gap.' 文字');
				}
			} else if($maxLength !== '') {
				if($string > $maxLength) {
					$gap = $string_result-$maxLength;
					$px->error('コンテンツエリアの文字数（altを含む）：'.$string_result.' 文字<br>超過文字数：'.$gap.' 文字');
				}
			}

		}
	}














































