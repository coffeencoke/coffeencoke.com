<?php


// refresh periods in seconds
$tb_refresh_periods = array(
	'Manual' => 0,
	'Every 20 seconds' => 20,
	'Every 30 seconds' => 30,
	'Every minute' => 60,
	'Every 2 minutes' => 120,
	'Every 5 minutes' => 300,
	'Every 10 minutes' => 600
);

$tb_languages = array(
' ' => 'any language',
'ab' => 'Abkhazian',
'ae' => 'Avestan',
'af' => 'Afrikaans',
'ak' => 'Akan',
'am' => 'Amharic',
'an' => 'Aragonese',
'ar' => 'Arabic',
'as' => 'Assamese',
'av' => 'Avaric',
'ay' => 'Aymara',
'az' => 'Azerbaijani',
'ba' => 'Bashkir',
'be' => 'Belarusian',
'bg' => 'Bulgarian',
'bh' => 'Bihari',
'bi' => 'Bislama',
'bm' => 'Bambara',
'bn' => 'Bengali',
'bo' => 'Tibetan',
'br' => 'Breton',
'bs' => 'Bosnian',
'ca' => 'Catalan; Valencian',
'ce' => 'Chechen',
'ch' => 'Chamorro',
'co' => 'Corsican',
'cr' => 'Cree',
'cs' => 'Czech',
'cv' => 'Chuvash',
'cy' => 'Welsh',
'da' => 'Danish',
'de' => 'German',
'en' => 'English',
'eo' => 'Esperanto',
'es' => 'Spanish; Castilian',
'et' => 'Estonian',
'eu' => 'Basque',
'fa' => 'Persian',
'ff' => 'Fulah',
'fi' => 'Finnish',
'fj' => 'Fijian',
'fo' => 'Faroese',
'fr' => 'French',
'fy' => 'Western Frisian',
'ga' => 'Irish',
'gl' => 'Galician',
'gn' => 'Guarani',
'gu' => 'Gujarati',
'gv' => 'Manx',
'ha' => 'Hausa',
'he' => 'Hebrew',
'hi' => 'Hindi',
'ho' => 'Hiri Motu',
'hr' => 'Croatian',
'ht' => 'Haitian; Haitian Creole',
'hu' => 'Hungarian',
'hy' => 'Armenian',
'hz' => 'Herero',
'id' => 'Indonesian',
'ie' => 'Interlingue; Occidental',
'ig' => 'Igbo',
'ii' => 'Sichuan Yi; Nuosu',
'ik' => 'Inupiaq',
'io' => 'Ido',
'is' => 'Icelandic',
'it' => 'Italian',
'iu' => 'Inuktitut',
'ja' => 'Japanese',
'jv' => 'Javanese',
'ka' => 'Georgian',
'kg' => 'Kongo',
'ki' => 'Kikuyu; Gikuyu',
'kj' => 'Kuanyama; Kwanyama',
'kk' => 'Kazakh',
'kl' => 'Kalaallisut; Greenlandic',
'km' => 'Central Khmer',
'kn' => 'Kannada',
'ko' => 'Korean',
'kr' => 'Kanuri',
'ks' => 'Kashmiri',
'ku' => 'Kurdish',
'kv' => 'Komi',
'kw' => 'Cornish',
'ky' => 'Kirghiz; Kyrgyz',
'la' => 'Latin',
'lb' => 'Luxembourgish; Letzeburgesch',
'lg' => 'Ganda',
'li' => 'Limburgan; Limburger; Limburgish',
'ln' => 'Lingala',
'lo' => 'Lao',
'lt' => 'Lithuanian',
'lu' => 'Luba-Katanga',
'lv' => 'Latvian',
'mg' => 'Malagasy',
'mh' => 'Marshallese',
'mi' => 'Maori',
'mk' => 'Macedonian',
'ml' => 'Malayalam',
'mn' => 'Mongolian',
'mr' => 'Marathi',
'ms' => 'Malay',
'mt' => 'Maltese',
'my' => 'Burmese',
'na' => 'Nauru',
'ne' => 'Nepali',
'ng' => 'Ndonga',
'nl' => 'Dutch; Flemish',
'no' => 'Norwegian',
'oj' => 'Ojibwa',
'om' => 'Oromo',
'or' => 'Oriya',
'os' => 'Ossetian; Ossetic',
'pa' => 'Panjabi; Punjabi',
'pi' => 'Pali',
'pl' => 'Polish',
'ps' => 'Pushto; Pashto',
'pt' => 'Portuguese',
'qu' => 'Quechua',
'rm' => 'Romansh',
'rn' => 'Rundi',
'ro' => 'Romanian; Moldavian; Moldovan',
'ru' => 'Russian',
'rw' => 'Kinyarwanda',
'sa' => 'Sanskrit',
'sc' => 'Sardinian',
'sd' => 'Sindhi',
'se' => 'Northern Sami',
'sg' => 'Sango',
'si' => 'Sinhala; Sinhalese',
'sk' => 'Slovak',
'sl' => 'Slovenian',
'sm' => 'Samoan',
'sn' => 'Shona',
'so' => 'Somali',
'sq' => 'Albanian',
'sr' => 'Serbian',
'ss' => 'Swati',
'su' => 'Sundanese',
'sv' => 'Swedish',
'sw' => 'Swahili',
'ta' => 'Tamil',
'te' => 'Telugu',
'tg' => 'Tajik',
'th' => 'Thai',
'ti' => 'Tigrinya',
'tk' => 'Turkmen',
'tl' => 'Tagalog',
'tn' => 'Tswana',
'to' => 'Tonga (Tonga Islands)',
'tr' => 'Turkish',
'ts' => 'Tsonga',
'tt' => 'Tatar',
'tw' => 'Twi',
'ty' => 'Tahitian',
'ug' => 'Uighur; Uyghur',
'uk' => 'Ukrainian',
'ur' => 'Urdu',
'uz' => 'Uzbek',
've' => 'Venda',
'vi' => 'Vietnamese',
'yi' => 'Yiddish',
'yo' => 'Yoruba',
'za' => 'Zhuang; Chuang',
'zh' => 'Chinese',
'zu' => 'Zulu'
);

function tb_get_url_content($url)
{
  $string = '';
  
  # preferred way is to use curl
  if (function_exists('curl_init')){
    $ch = curl_init();
  
      curl_setopt ($ch, CURLOPT_URL, $url);
      curl_setopt ($ch, CURLOPT_HEADER, 0);
  
      ob_start();
  
      curl_exec ($ch);
      curl_close ($ch);
      $string = ob_get_contents();
  
      ob_end_clean();
  }
  # plan B is to use file_get_contents
  elseif (function_exists('file_get_contents')) {
    $string = @file_get_contents($url);   
  }
  # fallback is to use fopen
  else {
    if ($fh = fopen($url, 'rb')) {
      clearstatcache();
      if ($fsize = @filesize($url)) {
        $string = fread($fh, $fsize);
      }
      else {
          while (!feof($fh)) {
            $string .= fread($fh, 8192);
          }
      }
      fclose($fh);
    }
  }
    return $string;    
}

?>