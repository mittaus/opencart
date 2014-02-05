<?php
class User {
	private $user_id;
	private $username;
	private $permission = array();

	public function __construct($registry) {
		$this->db = $registry->get('db');
		$this->request = $registry->get('request');
		$this->session = $registry->get('session');

		if (isset($this->session->data['user_id'])) {
			$user_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "user WHERE user_id = '" . (int)$this->session->data['user_id'] . "' AND status = '1'");

			if ($user_query->num_rows) {
				$this->user_id = $user_query->row['user_id'];
				$this->username = $user_query->row['username'];

				$this->db->query("UPDATE " . DB_PREFIX . "user SET ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE user_id = '" . (int)$this->session->data['user_id'] . "'");

				$user_group_query = $this->db->query("SELECT permission FROM " . DB_PREFIX . "user_group WHERE user_group_id = '" . (int)$user_query->row['user_group_id'] . "'");

                //$this->findSerializeError($user_group_query->row['permission']);
                //$permissions = unserialize('a:2:{s:6:"access";a:137:{i:0;s:17:"catalog/attribute";i:1;s:23:"catalog/attribute_group";i:2;s:16:"catalog/category";i:3;s:16:"catalog/download";i:4;s:14:"catalog/filter";i:5;s:19:"catalog/information";i:6;s:20:"catalog/manufacturer";i:7;s:14:"catalog/option";i:8;s:15:"catalog/product";i:9;s:15:"catalog/profile";i:10;s:14:"catalog/review";i:11;s:18:"common/filemanager";i:12;s:13:"design/banner";i:13;s:13:"design/layout";i:14;s:14:"extension/feed";i:15;s:19:"extension/installer";i:16;s:22:"extension/modification";i:17;s:16:"extension/module";i:18;s:17:"extension/payment";i:19;s:18:"extension/shipping";i:20;s:15:"extension/total";i:21;s:16:"feed/google_base";i:22;s:19:"feed/google_sitemap";i:23;s:20:"localisation/country";i:24;s:21:"localisation/currency";i:25;s:21:"localisation/geo_zone";i:26;s:21:"localisation/language";i:27;s:25:"localisation/length_class";i:28;s:21:"localisation/location";i:29;s:25:"localisation/order_status";i:30;s:26:"localisation/return_action";i:31;s:26:"localisation/return_reason";i:32;s:26:"localisation/return_status";i:33;s:25:"localisation/stock_status";i:34;s:22:"localisation/tax_class";i:35;s:21:"localisation/tax_rate";i:36;s:25:"localisation/weight_class";i:37;s:17:"localisation/zone";i:38;s:19:"marketing/affiliate";i:39;s:17:"marketing/contact";i:40;s:16:"marketing/coupon";i:41;s:19:"marketing/marketing";i:42;s:14:"module/account";i:43;s:16:"module/affiliate";i:44;s:13:"module/banner";i:45;s:17:"module/bestseller";i:46;s:15:"module/carousel";i:47;s:15:"module/category";i:48;s:15:"module/featured";i:49;s:13:"module/filter";i:50;s:18:"module/google_talk";i:51;s:18:"module/information";i:52;s:13:"module/latest";i:53;s:16:"module/slideshow";i:54;s:14:"module/special";i:55;s:12:"module/store";i:56;s:14:"module/welcome";i:57;s:24:"payment/authorizenet_aim";i:58;s:21:"payment/bank_transfer";i:59;s:14:"payment/cheque";i:60;s:11:"payment/cod";i:61;s:21:"payment/free_checkout";i:62;s:22:"payment/klarna_account";i:63;s:22:"payment/klarna_invoice";i:64;s:14:"payment/liqpay";i:65;s:20:"payment/moneybookers";i:66;s:14:"payment/nochex";i:67;s:15:"payment/paymate";i:68;s:16:"payment/paypoint";i:69;s:13:"payment/payza";i:70;s:26:"payment/perpetual_payments";i:71;s:18:"payment/pp_express";i:72;s:25:"payment/pp_payflow_iframe";i:73;s:14:"payment/pp_pro";i:74;s:21:"payment/pp_pro_iframe";i:75;s:17:"payment/pp_payflow";i:76;s:17:"payment/pp_pro_uk";i:77;s:19:"payment/pp_standard";i:78;s:15:"payment/sagepay";i:79;s:22:"payment/sagepay_direct";i:80;s:18:"payment/sagepay_us";i:81;s:19:"payment/twocheckout";i:82;s:28:"payment/web_payment_software";i:83;s:16:"payment/worldpay";i:84;s:16:"report/affiliate";i:85;s:25:"report/affiliate_activity";i:86;s:24:"report/customer_activity";i:87;s:22:"report/customer_credit";i:88;s:22:"report/customer_online";i:89;s:21:"report/customer_order";i:90;s:22:"report/customer_reward";i:91;s:16:"report/marketing";i:92;s:24:"report/product_purchased";i:93;s:21:"report/product_viewed";i:94;s:18:"report/sale_coupon";i:95;s:17:"report/sale_order";i:96;s:18:"report/sale_return";i:97;s:20:"report/sale_shipping";i:98;s:15:"report/sale_tax";i:99;s:17:"sale/custom_field";i:100;s:13:"sale/customer";i:101;s:20:"sale/customer_ban_ip";i:102;s:19:"sale/customer_group";i:103;s:10:"sale/order";i:104;s:14:"sale/recurring";i:105;s:11:"sale/return";i:106;s:12:"sale/voucher";i:107;s:18:"sale/voucher_theme";i:108;s:15:"setting/setting";i:109;s:13:"setting/store";i:110;s:16:"shipping/auspost";i:111;s:17:"shipping/citylink";i:112;s:14:"shipping/fedex";i:113;s:13:"shipping/flat";i:114;s:13:"shipping/free";i:115;s:13:"shipping/item";i:116;s:23:"shipping/parcelforce_48";i:117;s:15:"shipping/pickup";i:118;s:19:"shipping/royal_mail";i:119;s:12:"shipping/ups";i:120;s:13:"shipping/usps";i:121;s:15:"shipping/weight";i:122;s:11:"tool/backup";i:123;s:14:"tool/error_log";i:124;s:12:"total/coupon";i:125;s:12:"total/credit";i:126;s:14:"total/handling";i:127;s:16:"total/klarna_fee";i:128;s:19:"total/low_order_fee";i:129;s:12:"total/reward";i:130;s:14:"total/shipping";i:131;s:15:"total/sub_total";i:132;s:9:"total/tax";i:133;s:11:"total/total";i:134;s:13:"total/voucher";i:135;s:9:"user/user";i:136;s:20:"user/user_permission";}s:6:"modify";a:137:{i:0;s:17:"catalog/attribute";i:1;s:23:"catalog/attribute_group";i:2;s:16:"catalog/category";i:3;s:16:"catalog/download";i:4;s:14:"catalog/filter";i:5;s:19:"catalog/information";i:6;s:20:"catalog/manufacturer";i:7;s:14:"catalog/option";i:8;s:15:"catalog/product";i:9;s:15:"catalog/profile";i:10;s:14:"catalog/review";i:11;s:18:"common/filemanager";i:12;s:13:"design/banner";i:13;s:13:"design/layout";i:14;s:14:"extension/feed";i:15;s:19:"extension/installer";i:16;s:22:"extension/modification";i:17;s:16:"extension/module";i:18;s:17:"extension/payment";i:19;s:18:"extension/shipping";i:20;s:15:"extension/total";i:21;s:16:"feed/google_base";i:22;s:19:"feed/google_sitemap";i:23;s:20:"localisation/country";i:24;s:21:"localisation/currency";i:25;s:21:"localisation/geo_zone";i:26;s:21:"localisation/language";i:27;s:25:"localisation/length_class";i:28;s:21:"localisation/location";i:29;s:25:"localisation/order_status";i:30;s:26:"localisation/return_action";i:31;s:26:"localisation/return_reason";i:32;s:26:"localisation/return_status";i:33;s:25:"localisation/stock_status";i:34;s:22:"localisation/tax_class";i:35;s:21:"localisation/tax_rate";i:36;s:25:"localisation/weight_class";i:37;s:17:"localisation/zone";i:38;s:19:"marketing/affiliate";i:39;s:17:"marketing/contact";i:40;s:16:"marketing/coupon";i:41;s:19:"marketing/marketing";i:42;s:14:"module/account";i:43;s:16:"module/affiliate";i:44;s:13:"module/banner";i:45;s:17:"module/bestseller";i:46;s:15:"module/carousel";i:47;s:15:"module/category";i:48;s:15:"module/featured";i:49;s:13:"module/filter";i:50;s:18:"module/google_talk";i:51;s:18:"module/information";i:52;s:13:"module/latest";i:53;s:16:"module/slideshow";i:54;s:14:"module/special";i:55;s:12:"module/store";i:56;s:14:"module/welcome";i:57;s:24:"payment/authorizenet_aim";i:58;s:21:"payment/bank_transfer";i:59;s:14:"payment/cheque";i:60;s:11:"payment/cod";i:61;s:21:"payment/free_checkout";i:62;s:22:"payment/klarna_account";i:63;s:22:"payment/klarna_invoice";i:64;s:14:"payment/liqpay";i:65;s:20:"payment/moneybookers";i:66;s:14:"payment/nochex";i:67;s:15:"payment/paymate";i:68;s:16:"payment/paypoint";i:69;s:13:"payment/payza";i:70;s:26:"payment/perpetual_payments";i:71;s:18:"payment/pp_express";i:72;s:25:"payment/pp_payflow_iframe";i:73;s:14:"payment/pp_pro";i:74;s:21:"payment/pp_pro_iframe";i:75;s:17:"payment/pp_payflow";i:76;s:17:"payment/pp_pro_uk";i:77;s:19:"payment/pp_standard";i:78;s:15:"payment/sagepay";i:79;s:22:"payment/sagepay_direct";i:80;s:18:"payment/sagepay_us";i:81;s:19:"payment/twocheckout";i:82;s:28:"payment/web_payment_software";i:83;s:16:"payment/worldpay";i:84;s:16:"report/affiliate";i:85;s:25:"report/affiliate_activity";i:86;s:24:"report/customer_activity";i:87;s:22:"report/customer_credit";i:88;s:22:"report/customer_online";i:89;s:21:"report/customer_order";i:90;s:22:"report/customer_reward";i:91;s:16:"report/marketing";i:92;s:24:"report/product_purchased";i:93;s:21:"report/product_viewed";i:94;s:18:"report/sale_coupon";i:95;s:17:"report/sale_order";i:96;s:18:"report/sale_return";i:97;s:20:"report/sale_shipping";i:98;s:15:"report/sale_tax";i:99;s:17:"sale/custom_field";i:100;s:13:"sale/customer";i:101;s:20:"sale/customer_ban_ip";i:102;s:19:"sale/customer_group";i:103;s:10:"sale/order";i:104;s:14:"sale/recurring";i:105;s:11:"sale/return";i:106;s:12:"sale/voucher";i:107;s:18:"sale/voucher_theme";i:108;s:15:"setting/setting";i:109;s:13:"setting/store";i:110;s:16:"shipping/auspost";i:111;s:17:"shipping/citylink";i:112;s:14:"shipping/fedex";i:113;s:13:"shipping/flat";i:114;s:13:"shipping/free";i:115;s:13:"shipping/item";i:116;s:23:"shipping/parcelforce_48";i:117;s:15:"shipping/pickup";i:118;s:19:"shipping/royal_mail";i:119;s:12:"shipping/ups";i:120;s:13:"shipping/usps";i:121;s:15:"shipping/weight";i:122;s:11:"tool/backup";i:123;s:14:"tool/error_log";i:124;s:12:"total/coupon";i:125;s:12:"total/credit";i:126;s:14:"total/handling";i:127;s:16:"total/klarna_fee";i:128;s:19:"total/low_order_fee";i:129;s:12:"total/reward";i:130;s:14:"total/shipping";i:131;s:15:"total/sub_total";i:132;s:9:"total/tax";i:133;s:11:"total/total";i:134;s:13:"total/voucher";i:135;s:9:"user/user";i:136;s:20:"user/user_permission";}}');
				$permissions = unserialize($user_group_query->row['permission']);
                if (is_array($permissions)) {
					foreach ($permissions as $key => $value) {
						$this->permission[$key] = $value;
					}
				}
                
                //if ($user_group_query->num_rows && strlen(trim($user_group_query->row['permission'])) > 0) {
                //    $permissions = unserialize($user_group_query->row['permission']);

                //    if ((html_entity_decode($user_group_query->row['permission'], ENT_QUOTES, 'UTF-8') === 'b:0;' || (bool)$permissions !== false) && is_array($permissions)) {
                //        foreach ($permissions as $key => $value) {
                //            $this->permission[$key] = $value;
                //        }
                //    }
                //}

			} else {
				$this->logout();
			}
		}
	}

    #starttest
    public function findSerializeError($data1) {
        echo "<pre>";
        
        //$source  = preg_replace_callback('!s:(\d+):"(.*?)";!e', function($m)
        //    {
        //    return utf8_encode(chr($m[1]));
        //    }, $source
        //);
        $data2 = preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $data1);
        //$data2 = preg_replace_callback('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $data2 );
        $max = (strlen ( $data1 ) > strlen ( $data2 )) ? strlen ( $data1 ) : strlen ( $data2 );

        echo $data1 . PHP_EOL;
        echo $data2 . PHP_EOL;

        for($i = 0; $i < $max; $i ++) {

            if (@$data1 {$i} !== @$data2 {$i}) {

                echo "Diffrence ", @$data1 {$i}, " != ", @$data2 {$i}, PHP_EOL;
                echo "\t-> ORD number ", ord ( @$data1 {$i} ), " != ", ord ( @$data2 {$i} ), PHP_EOL;
                echo "\t-> Line Number = $i" . PHP_EOL;

                $start = ($i - 20);
                $start = ($start < 0) ? 0 : $start;
                $length = 40;

                $point = $max - $i;
                if ($point < 20) {
                    $rlength = 1;
                    $rpoint = - $point;
                } else {
                    $rpoint = $length - 20;
                    $rlength = 1;
                }

                echo "\t-> Section Data1  = ", substr_replace ( substr ( $data1, $start, $length ), "<b style=\"color:green\">{$data1 {$i}}</b>", $rpoint, $rlength ), PHP_EOL;
                echo "\t-> Section Data2  = ", substr_replace ( substr ( $data2, $start, $length ), "<b style=\"color:red\">{$data2 {$i}}</b>", $rpoint, $rlength ), PHP_EOL;
            }

        }

    }
    #end test
	public function login($username, $password) {
		$user_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "user WHERE username = '" . $this->db->escape($username) . "' AND (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $this->db->escape($password) . "'))))) OR password = '" . $this->db->escape(md5($password)) . "') AND status = '1'");

		if ($user_query->num_rows) {
			$this->session->data['user_id'] = $user_query->row['user_id'];

			$this->user_id = $user_query->row['user_id'];
			$this->username = $user_query->row['username'];			

			$user_group_query = $this->db->query("SELECT permission FROM " . DB_PREFIX . "user_group WHERE user_group_id = '" . (int)$user_query->row['user_group_id'] . "'");

			$permissions = unserialize($user_group_query->row['permission']);

			if (is_array($permissions)) {
				foreach ($permissions as $key => $value) {
					$this->permission[$key] = $value;
				}
			}

			return true;
		} else {
			return false;
		}
	}

	public function logout() {
		unset($this->session->data['user_id']);

		$this->user_id = '';
		$this->username = '';
	}

	public function hasPermission($key, $value) {
		if (isset($this->permission[$key])) {
			return in_array($value, $this->permission[$key]);
		} else {
			return false;
		}
	}

	public function isLogged() {
		return $this->user_id;
	}

	public function getId() {
		return $this->user_id;
	}

	public function getUserName() {
		return $this->username;
	}
}