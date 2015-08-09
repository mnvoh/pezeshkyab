<?php

define('TABLE_PROVINCES', 'province');
define('TABLE_CITIES', 'city');
define('TABLE_FEES', 'fees');

class DbOps {

    public static function getProvinces() {
        $results = DB::table(TABLE_PROVINCES)->get();

        $results_arr = array();
        foreach($results as $p) {
            $results_arr[$p->id] = $p->name;
        }

        return $results_arr;
    }

    public static function getCities($provinceId) {
        $provinceId = (int)$provinceId;
        $results = DB::table(TABLE_CITIES)->where('province_id', $provinceId)->get();

        $cities = array();

        foreach($results as $c) {
            $cities[$c->id] = $c->name;
        }

        return $cities;
    }

	public static function getFees() {
		return array(
			array(
				'title' => 'ویزیت',
				'fee' => '99000',
				'lang' => 'fa',
				'currency' => 'irr',
			),
			array(
				'title' => 'عکس',
				'fee' => '190000',
				'lang' => 'fa',
				'currency' => 'irr',
			),
			array(
				'title' => 'ام آر آی',
				'fee' => '490000',
				'lang' => 'fa',
				'currency' => 'irr',
			),
			array(
				'title' => 'بستری',
				'fee' => '590000',
				'lang' => 'fa',
				'currency' => 'irr',
			),
		);
	}
}