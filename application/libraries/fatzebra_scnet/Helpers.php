<?php
/**
* Fat Zebra PHP Gateway Library
*
* The original source for this library, including its tests can be found at
* https://github.com/fatzebra/PHP-Library
*
* Please visit http://docs.fatzebra.com.au for details on the Fat Zebra API
* or https://www.fatzebra.com.au/help for support.
*
* Patches, pull requests, issues, comments and suggestions always welcome.
*
* @package FatZebra
*/
namespace FatZebra;

class Helpers {
	/**
	* Check if int is a timestamp
	* @param int
	* @return boolean
	*/
	static public function isTimestamp($timestamp) {
		return ((int) $timestamp === $timestamp)
        && ($timestamp <= PHP_INT_MAX)
        && ($timestamp >= ~PHP_INT_MAX);

	}

	/**
	 * Convert ISO 3166-1 alpha-2 to corresponding ISO 3166-1 alpha-3 code.
	 * @param  string $alpha2  The 2 letter ISO 3166-1 alpha-2 code
	 * @return string          The 3 letter ISO 3133-1 alpha-3 code, or original input if not found
	 */
	static public function iso3166_alpha3($alpha2) {
		$map = array("AD" => "AND", "AE" => "ARE", "AF" => "AFG", "AG" => "ATG", "AI" => "AIA", "AL" => "ALB", "AM" => "ARM", "AN" => "ANT", "AO" => "AGO", "AQ" => "ATA", "AR" => "ARG", "AS" => "ASM", "AT" => "AUT", "AU" => "AUS", "AW" => "ABW", "AX" => "ALA", "AZ" => "AZE", "BA" => "BIH", "BB" => "BRB", "BD" => "BGD", "BE" => "BEL", "BF" => "BFA", "BG" => "BGR", "BH" => "BHR", "BI" => "BDI", "BJ" => "BEN", "BL" => "BLM", "BM" => "BMU", "BN" => "BRN", "BO" => "BOL", "BQ" => "BES", "BR" => "BRA", "BS" => "BHS", "BT" => "BTN", "BV" => "BVT", "BW" => "BWA", "BY" => "BLR", "BZ" => "BLZ", "CA" => "CAN", "CC" => "CCK", "CD" => "COD", "CF" => "CAF", "CG" => "COG", "CH" => "CHE", "CI" => "CIV", "CK" => "COK", "CL" => "CHL", "CM" => "CMR", "CN" => "CHN", "CO" => "COL", "CR" => "CRI", "CU" => "CUB", "CV" => "CPV", "CW" => "CUW", "CX" => "CXR", "CY" => "CYP", "CZ" => "CZE", "DE" => "DEU", "DJ" => "DJI", "DK" => "DNK", "DM" => "DMA", "DO" => "DOM", "DZ" => "DZA", "EC" => "ECU", "EE" => "EST", "EG" => "EGY", "EH" => "ESH", "ER" => "ERI", "ES" => "ESP", "ET" => "ETH", "FI" => "FIN", "FJ" => "FJI", "FK" => "FLK", "FM" => "FSM", "FO" => "FRO", "FR" => "FRA", "GA" => "GAB", "GB" => "GBR", "GD" => "GRD", "GE" => "GEO", "GF" => "GUF", "GG" => "GGY", "GH" => "GHA", "GI" => "GIB", "GL" => "GRL", "GM" => "GMB", "GN" => "GIN", "GP" => "GLP", "GQ" => "GNQ", "GR" => "GRC", "GS" => "SGS", "GT" => "GTM", "GU" => "GUM", "GW" => "GNB", "GY" => "GUY", "HK" => "HKG", "HM" => "HMD", "HN" => "HND", "HR" => "HRV", "HT" => "HTI", "HU" => "HUN", "ID" => "IDN", "IE" => "IRL", "IL" => "ISR", "IM" => "IMN", "IN" => "IND", "IO" => "IOT", "IQ" => "IRQ", "IR" => "IRN", "IS" => "ISL", "IT" => "ITA", "JE" => "JEY", "JM" => "JAM", "JO" => "JOR", "JP" => "JPN", "KE" => "KEN", "KG" => "KGZ", "KH" => "KHM", "KI" => "KIR", "KM" => "COM", "KN" => "KNA", "KP" => "PRK", "KR" => "KOR", "KW" => "KWT", "KY" => "CYM", "KZ" => "KAZ", "LA" => "LAO", "LB" => "LBN", "LC" => "LCA", "LI" => "LIE", "LK" => "LKA", "LR" => "LBR", "LS" => "LSO", "LT" => "LTU", "LU" => "LUX", "LV" => "LVA", "LY" => "LBY", "MA" => "MAR", "MC" => "MCO", "MD" => "MDA", "ME" => "MNE", "MF" => "MAF", "MG" => "MDG", "MH" => "MHL", "MK" => "MKD", "ML" => "MLI", "MM" => "MMR", "MN" => "MNG", "MO" => "MAC", "MP" => "MNP", "MQ" => "MTQ", "MR" => "MRT", "MS" => "MSR", "MT" => "MLT", "MU" => "MUS", "MV" => "MDV", "MW" => "MWI", "MX" => "MEX", "MY" => "MYS", "MZ" => "MOZ", "NA" => "NAM", "NC" => "NCL", "NE" => "NER", "NF" => "NFK", "NG" => "NGA", "NI" => "NIC", "NL" => "NLD", "NO" => "NOR", "NP" => "NPL", "NR" => "NRU", "NU" => "NIU", "NZ" => "NZL", "OM" => "OMN", "PA" => "PAN", "PE" => "PER", "PF" => "PYF", "PG" => "PNG", "PH" => "PHL", "PK" => "PAK", "PL" => "POL", "PM" => "SPM", "PN" => "PCN", "PR" => "PRI", "PS" => "PSE", "PT" => "PRT", "PW" => "PLW", "PY" => "PRY", "QA" => "QAT", "RE" => "REU", "RO" => "ROU", "RS" => "SRB", "RU" => "RUS", "RW" => "RWA", "SA" => "SAU", "SB" => "SLB", "SC" => "SYC", "SD" => "SDN", "SE" => "SWE", "SG" => "SGP", "SH" => "SHN", "SI" => "SVN", "SJ" => "SJM", "SK" => "SVK", "SL" => "SLE", "SM" => "SMR", "SN" => "SEN", "SO" => "SOM", "SR" => "SUR", "SS" => "SSD", "ST" => "STP", "SV" => "SLV", "SX" => "SXM", "SY" => "SYR", "SZ" => "SWZ", "TC" => "TCA", "TD" => "TCD", "TF" => "ATF", "TG" => "TGO", "TH" => "THA", "TJ" => "TJK", "TK" => "TKL", "TL" => "TLS", "TM" => "TKM", "TN" => "TUN", "TO" => "TON", "TR" => "TUR", "TT" => "TTO", "TV" => "TUV", "TW" => "TWN", "TZ" => "TZA", "UA" => "UKR", "UG" => "UGA", "UM" => "UMI", "US" => "USA", "UY" => "URY", "UZ" => "UZB", "VA" => "VAT", "VC" => "VCT", "VE" => "VEN", "VG" => "VGB", "VI" => "VIR", "VN" => "VNM", "VU" => "VUT", "WF" => "WLF", "WS" => "WSM", "YE" => "YEM", "YT" => "MYT", "ZA" => "ZAF", "ZM" => "ZMB", "ZW" => "ZWE");
		return isset($map[$alpha2]) ? $map[$alpha2] : $alpha2 ;
	}

	/**
	* Convert a float to the integer value, using BCMul if available.
	* If BCMul is not available use the two-line cast method to avoid floating point precision issues
	*
	* @param float $input the input value
	* @return int the integer value of the conversion
	*/
	static public function floatToInt($input) {
		if (function_exists('bcmul')) {
			return intval(bcmul($input, 100));
		} else {
			$multiplied = round($input * 100);
			return (int)$multiplied;
		}

	}
}
