<?php

class SettingSeeder extends App\libraries\Seeder
{
	public $table = 'mein_options';

    public function run()
    {
        $this->db->truncate($this->table);

        $this->db->query(
        "INSERT INTO `mein_options` (`id`, `option_group`, `option_name`, `option_value`) VALUES
        (609,	'emailer',	'use_mailcatcher',	'yes'),
        (610,	'emailer',	'smtp_host',	'in-v3.mailjet.com'),
        (611,	'emailer',	'smtp_port',	'587'),
        (612,	'emailer',	'smtp_username',	'8443024b25c98692c6e2647372c7be5f'),
        (613,	'emailer',	'smtp_password',	'16ff075e5918803087bd3eb1d1f21b02'),
        (614,	'emailer',	'email_from',	'contact@viralbisnis.id'),
        (615,	'emailer',	'sender_name',	'ViralBisnis Indonesia'),
        (616,	'site',	'site_title',	'VISSI Platform'),
        (617,	'site',	'site_logo',	'https://viralbisnis.vissi.id/sites/viralbisnis/themes/default/assets/images/logo.png'),
        (618,	'site',	'theme',	'frontend'),
        (619,	'site',	'phone',	'087813277822'),
        (620,	'site',	'address',	''),
        (621,	'wallet',	'minimum_withdrawal',	'50000'),
        (622,	'dashboard',	'maintenance_mode',	'off'),
        (623,	'affiliate',	'commision_percentage',	'15'),
        (624,	'affiliate',	'enable_affiliate_membership',	'no'),
        (625,	'user',	'confirmation_type',	'link'),
        (626,	'user',	'use_single_login',	'yes'),
        (627,	'lessonlog',	'record_all_user_log',	'0'),
        (628,	'post',	'posttype_config',	'page:\r\n    label: Pages\r\n    entry: mein_post_page\r\nevent:\r\n    label: Events\r\n    entry: mein_post_event\r\n'),
        (629,	'download',	'sample_module_setting',	''),
        (630,	'membership',	'author_percentage_membership',	'60'),
        (631,	'product',	'remind_expired',	'3'),
        (632,	'payment',	'before_order_expired',	'30'),
        (633,	'payment',	'order_expired',	'120'),
        (634,	'payment',	'transfer_fee_operator',	'neg'),
        (635,	'payment',	'transfer_destinations',	'BCA|6765406777|PT. VIRAL BISNIS INDONESIA'),
        (636,	'payment',	'last_unique_number',	'158'),
        (637,	'payment',	'active_payment_gateway',	'transfer'),
        (638,	'here_course_submission',	'form_status',	'open');");
    }
}