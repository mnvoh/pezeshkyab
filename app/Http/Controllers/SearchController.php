<?php

namespace App\Http\Controllers;

use Elasticsearch\Common\Exceptions\NoNodesAvailableException;
use Illuminate\Http\Request;
use Elasticsearch\ClientBuilder;

use App\Http\Requests;
use PhpSpec\Exception\Example\ErrorException;

class SearchController extends Controller
{


    public function find(Request $request)
    {
		$advanced = ($request->get("s_rating", 0) > 0) ||
			$request->has("schedule") ||
			($request->get("s_distance", 0) > 0);

        if(!$request->has('s_q') && !$advanced) {
			$year = jdate("Y", '', '', 'Asia/Tehran', 'en');
			$month = jdate("m", '', '', 'Asia/Tehran', 'en');
			$date = jdate("d", '', '', 'Asia/Tehran', 'en');
			$hour = jdate("H", '', '', 'Asia/Tehran', 'en');
			$min = jdate("i", '', '', 'Asia/Tehran', 'en');

			$year2 = jdate("Y", strtotime("+7 days"), '', 'Asia/Tehran', 'en');
			$month2 = jdate("m", strtotime("+7 days"), '', 'Asia/Tehran', 'en');
			$date2 = jdate("d", strtotime("+7 days"), '', 'Asia/Tehran', 'en');
			$hour2 = jdate("H", strtotime("+7 days"), '', 'Asia/Tehran', 'en');
			$min2 = jdate("i", strtotime("+7 days"), '', 'Asia/Tehran', 'en');
            return view('search.find', array(
                'error' => false,
                'no_query' => true,
				'include_maps' => true,
				"today_year"=> $year,
				"today_month"=> $month,
				"today_date"=> $date,
				"today_hour"=> $hour,
				"today_minute"=> $min,
				"twoday_year"=> $year2,
				"twoday_month"=> $month2,
				"twoday_date"=> $date2,
				"twoday_hour"=> $hour2,
				"twoday_minute"=> $min2,
            ));
        }

        $query = $request->get("s_q");
        $rating = $request->get("rating", 0);

        $temp_date = jalali_to_gregorian(
            $request->get("s_date_from_y"),
            $request->get("s_date_from_m"),
            $request->get("s_date_from_d")
        );

        $start_date = date("o-m-d H:i:s", mktime(
            $request->get("s_date_from_h"),
            $request->get("s_date_from_min"),
            0,
            $temp_date[1],
            $temp_date[2],
            $temp_date[0]
        ));

        $temp_date = jalali_to_gregorian(
            $request->get("s_date_to_y"),
            $request->get("s_date_to_m"),
            $request->get("s_date_to_d")
        );

        $end_date = date("Y-m-d H:i:s", mktime(
            $request->get("s_date_to_h"),
            $request->get("s_date_to_min"),
            0,
            $temp_date[1],
            $temp_date[2],
            $temp_date[0]
        ));

        $distance = $request->get("s_distance");
        $locationLat = $request->get("locationLat");
        $locationLon = $request->get("locationLon");

        $from = ($request->get("page", 1) - 1) * 10;

        $q_f_query = array();
        $q_f_query['match']['_all']['query'] = $query;
        $q_f_query['match']['_all']['operator'] = 'AND';
        $q_f_query['match']['_all']['fuzziness'] = "AUTO";

        $q_f_filter = array();
		if($request->has('schedule')) {
			$schedule_filter = array(
				'range' => array(
					'open_schedules' => array(
						'from' => $start_date,
						'to' => $end_date
					)
				)
			);
		}
		else {
			$schedule_filter = (object)array();
		}

		if($locationLat && strlen($locationLat)) {
			$locationFilter = array(
				'geo_distance' => array(
					'distance' => $distance . "m",
					'location' => array(
						'lat' => $locationLat,
						'lon' => $locationLon
					)
				)
			);
		}
		else {
			$locationFilter = (object)array();
		}
        $q_f_filter['bool']['must'] = array(
            array(
                'range' => array(
                    'rating' => array(
                        'gt' => (int)$rating,
                        'lte' => 5.0
                    )
                )
            ),
			$locationFilter,
			$schedule_filter
        );



        $params['index'] = 'pezeshkyab';
        $params['type'] = 'doctor';
        $params['from'] = $from;
		if(strlen($query) > 0) {
			$params['body']['query']['filtered']['query'] = $q_f_query;
		}
        if($advanced) {
            $params['body']['query']['filtered']['filter'] = $q_f_filter;
        }

        try {
            $client = ClientBuilder::create()->build();
            $results = $client->search($params);
        }
        catch(NoNodesAvailableException $ex) {
            return view('search.find', array(
                'error' => true,
                'no_query' => false,
            ));
        }

        $pagelessUrl = route('search.find') . '?';

        foreach($_GET as $key => $value) {
            if($key != 'page') {
                $pagelessUrl .= "$key=$value&";
            }
        }

		return view('search.find', array(
            'error' => false,
            'no_query' => false,
            'time_took' => $results['took'] / 1000,
            'count' => $results['hits']['total'],
            'results' => $results['hits']['hits'],
            'suggestion' => $this->getTermSuggestion($request),
            'pagelessUrl' => $pagelessUrl,
            'currentPage' => $request->get('page', 1),
            'pageCount' => ceil($results['hits']['total'] / 10.0),
        ));
	}

    private function getTermSuggestion(Request $request)
    {
        $query = $request->get('s_q');
        if(strlen($query) < 2) {
            return null;
        }

        $params['index'] = 'pezeshkyab';
        $params['type'] = 'doctor';
        $params['body'] = array();
        $params['body']['suggest']['text'] = $query;
        $params['body']['suggest']['simple_phrase']['phrase'] = array(
            'analyzer' => 'persian',
            'field' => '_all',
            'size' => 1,
            "real_word_error_likelihood" => 0.65,
            "max_errors" => 0.5,
            "gram_size" => 2,
            "direct_generator" => array(
                array(
                    "field" => "_all",
                    "suggest_mode" => "always",
                    "min_word_length" => 1,
                ),
            )
        );

        try {
            $client = ClientBuilder::create()->build();
            $results = $client->search($params);
            if(isset($results['suggest']['simple_phrase']) && count($results['suggest']['simple_phrase'])) {
                if(count($results['suggest']['simple_phrase'][0]['options'])) {
                    return $results['suggest']['simple_phrase'][0]['options'][0]['text'];
                }
            }

        }
        catch(Exception $ex) {
            return null;
        }
        catch(ErrorException $ex) {
            return null;
        }
        return null;
    }
}
