<?php
/**
 * ownCloud - ocsms
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Loic Blot <loic.blot@unix-experience.fr>
 * @copyright Loic Blot 2014
 */
namespace OCA\OcSms\AppInfo;

class FormatPhoneNumber {

	public static function formatPhoneNumber($pn) {
		$ipnrxp = array(					// match international numbers with 1,2,3 digits
			'#^(00|\+)(1\d\d\d)#',				// NANP
			'#^(00|\+)(2[1|2|3|4|5|6|8|9]\d)#',		// +2(1|2|3|4|5|6|8|9)x
			'#^(00|\+)(2[0|7])#',				// +2x
			'#^(00|\+)(3[5|7|8]\d)#',			// +3(5|7|8)x
			'#^(00|\+)(3[0|1|2|3|4|6|9])#',			// +3x
			'#^(00|\+)(4[2]\d)#',				// +4(2)x
			'#^(00|\+)(4[0|1|3|4|5|6|7|8|9])#',		// +4x
			'#^(00|\+)(5[0|9]\d)#',				// +5(0|9)x
			'#^(00|\+)(5[1|2|3|4|5|6|7|8])#',		// +5x
			'#^(00|\+)(6[7|8|9]\d)#',			// +6(7|8|9)x
			'#^(00|\+)(6[0|1|2|3|4|5|6])#',			// +6x
			'#^(00|\+)(7)#',				// +7
			'#^(00|\+)(8[5|7|8|9]\d)#',			// +8(5|7|8|9)x
			'#^(00|\+)(8[1|2|3|4|6])#',			// +8x
			'#^(00|\+)(9[6|7|9]\d)#',			// +9(6|7|9)x
			'#^(00|\+)(9[0|1|2|3|4|5|8])#'			// +9x
		);

		$ignrxp = array(					// match non digits and +
			'#\(\d*\)|[^\d\+]#',
		);

		/*
			ToDo : make local settings in web-page
		*/
		$lpnrxp = array(						// match local numbers
			'#(^0)([^0])#',						// in germany : 0-xx[x[x]]-123456
		);								//
		$lpnrpl = '+49$2';						// replace with +49 -xx[x[x]]-123456

		$tpn = trim($pn);
		if( preg_match('#^[\d\+].*#',$tpn)) {				// start with digit or +
			$fpn = preg_replace($ignrxp, '', $tpn);			// replace everything but digits/+ with ''
			$xpn = preg_replace($lpnrxp, $lpnrpl, $fpn);		// replace local prenumbers
			$ypn = preg_replace($ipnrxp, '+$2', $xpn);		// format to international coding +x[x[x]].....
		} else {
			$ypn = $tpn;						// some SMS_adresses are strings
		}
		return $ypn;
    }
}