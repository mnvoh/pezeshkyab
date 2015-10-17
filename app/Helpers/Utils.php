<?php
namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

require_once(dirname(__FILE__) . '/jdf.php');

class Utils {
    /**
     * Truncates text.
     *
     * Cuts a string to the length of $length and replaces the last characters
     * with the ending if the text is longer than length.
     *
     * @param string $text String to truncate.
     * @param integer $length Length of returned string, including ellipsis.
     * @param string $ending Ending to be appended to the trimmed string.
     * @param boolean $exact If false, $text will not be cut mid-word
     * @param boolean $considerHtml If true, HTML tags would be handled correctly
     * @return string Trimmed string.
     */
    public static function truncate($text, $length = 100, $ending = '...', $exact = true, $considerHtml = false) {
        if ($considerHtml) {
            // if the plain text is shorter than the maximum length, return the whole text
            if (strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
                return $text;
            }

            // splits all html-tags to scanable lines
            preg_match_all('/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);

            $total_length = strlen($ending);
            $open_tags = array();
            $truncate = '';

            foreach ($lines as $line_matchings) {
                // if there is any html-tag in this line, handle it and add it (uncounted) to the output
                if (!empty($line_matchings[1])) {
                    // if it�s an �empty element� with or without xhtml-conform closing slash (f.e.)
                    if (preg_match('/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings[1])) {
                        // do nothing
                        // if tag is a closing tag (f.e.)
                    } else if (preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1], $tag_matchings)) {
                        // delete tag from $open_tags list
                        $pos = array_search($tag_matchings[1], $open_tags);
                        if ($pos !== false) {
                            unset($open_tags[$pos]);
                        }
                        // if tag is an opening tag (f.e. )
                    } else if (preg_match('/^<\s*([^\s>!]+).*?>$/s', $line_matchings[1], $tag_matchings)) {
                        // add tag to the beginning of $open_tags list
                        array_unshift($open_tags, strtolower($tag_matchings[1]));
                    }
                    // add html-tag to $truncate�d text
                    $truncate .= $line_matchings[1];
                }

                // calculate the length of the plain text part of the line; handle entities as one character
                $content_length = strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', ' ', $line_matchings[2]));
                if ($total_length+$content_length > $length) {
                    // the number of characters which are left
                    $left = $length - $total_length;
                    $entities_length = 0;
                    // search for html entities
                    if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', $line_matchings[2], $entities, PREG_OFFSET_CAPTURE)) {
                        // calculate the real length of all entities in the legal range
                        foreach ($entities[0] as $entity) {
                            if ($entity[1]+1-$entities_length <= $left) {
                                $left--;
                                $entities_length += strlen($entity[0]);
                            } else {
                                // no more characters left
                                break;
                            }
                        }
                    }
                    $truncate .= mb_substr($line_matchings[2], 0, $left+$entities_length);
                    // maximum lenght is reached, so get off the loop
                    break;
                } else {
                    $truncate .= $line_matchings[2];
                    $total_length += $content_length;
                }

                // if the maximum length is reached, get off the loop
                if($total_length >= $length) {
                    break;
                }
            }
        } else {
            if (strlen($text) <= $length) {
                return $text;
            } else {
                $truncate = mb_substr($text, 0, $length - strlen($ending));
            }
        }

        // if the words shouldn't be cut in the middle...
        if (!$exact) {
            // ...search the last occurance of a space...
            $spacepos = strrpos($truncate, ' ');
            if (isset($spacepos)) {
                // ...and cut the text in this position
                $truncate = mb_substr($truncate, 0, $spacepos);
            }
        }

        // add the defined ending to the text
        $truncate .= $ending;

        if($considerHtml) {
            // close all unclosed html-tags
            foreach ($open_tags as $tag) {
                $truncate .= '';
            }
        }

        return $truncate;

    }

	public static function shamsiDateFromGreg($timestamp)
    {
		return jdate('Y/m/d H:i:s', $timestamp);
	}

    public static function shamsiDateToGreg($year, $month, $date, $hour, $minute)
    {

    }

	public static function sendEmail(Request $request, $to, $from_name, $from_addr, $subject, $content, $template)
	{
		$lang = $request->segment(1);
		if(!isset(config('app.locales_dir')[$lang])) {
			$lang = config('app.fallback_locale');
		}
		$dir = config('app.locales_dir')[$lang];
		if($dir == 'ltr') {
			$float = 'left';
		}
		else {
			$float = 'right';
		}

		$params = array(
			'dir' => $dir,
			'float' => $float,
			'title' => $subject,
		);

		if(is_array($content)) {
			$params = array_merge($params, $content);
		}
		else {
			$params['content'] = $content;
		}

		Mail::send('email.' . $template, $params, function($m) use ($to, $from_addr, $from_name, $subject) {
			if($from_addr != null) {
				$m->from($from_addr, $from_name);
				$m->replyTo($from_addr);
			}
			else {
				$m->from('no-reply@' . config('app.domain'), $from_name);
			}
			$m->to($to);
			$m->subject($subject);
		});
	}

	public static function makeThumbnail($filename, $size)
	{
		$ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

		$path = Config::get('constants.UPLOAD_PATH') . 'thumbs/' . $size . '/';
		if(!file_exists($path)) {
			mkdir($path, 0777, true);
		}
		$path = $path . '/' . pathinfo($filename, PATHINFO_FILENAME) . ".jpg";

		//return the cached version if it exists
		if(file_exists($path)) {
			return $path;
		}

		if($ext == 'png') {
			$img = imagecreatefrompng("{$filename}");
		}
		else if($ext == 'jpg' || $ext == "jpeg") {
			$img = imagecreatefromjpeg("{$filename}");
		}
		else if($ext == 'gif') {
			$img = imagecreatefromgif("{$filename}");
		}
		else {
			return null;
		}
		$width = imagesx($img);
		$height = imagesy($img);

		$tmp_image = imagecreatetruecolor($size, $size);
		$white_color = imagecolorallocate($tmp_image, 255, 255, 255);
		imagefill($tmp_image, 0, 0, $white_color);

		if($width > $height) {
			$x = ($width - $height) / 2;
			$y = 0;
			imagecopyresampled($tmp_image, $img, 0, 0, $x, $y, $size, $size, $height, $height);
		}
		else {
			$x = 0;
			$y = ($height - $width) / 2;
			imagecopyresampled($tmp_image, $img, 0, 0, $x, $y, $size, $size, $width, $width);
		}

		imagejpeg($tmp_image, $path);
		imagedestroy($img);
		imagedestroy($tmp_image);
		return $path;
	}
}