<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">

<title><?php echo $title; ?></title>

<meta name='robots' content='noindex, nofollow' />

<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="apple-touch-icon" href="apple-touch-icon.png">

<!-- Place favicon.ico in the root directory -->
<link rel="stylesheet" href="<?= $theme_url.'assets/css/vendor.css'; ?>">
<!-- Theme initialization -->

<!-- Vendor JS: jquery.js',metisMenu.js',nprogress.js',quill.js',popper.js',bootstrap.js' -->
<script src="<?= $theme_url.'assets/js/vendor.js'; ?>"></script>
<script src="<?= $theme_url.'assets/js/sidebar.js'; ?>"></script>
<script>NProgress.start();</script>

<!-- FIELDTYPE ASSETS -->
<!-- Datepicker -->
<link rel="stylesheet" id="theme-style" href="https://cdnjs.cloudflare.com/ajax/libs/datepicker/0.6.5/datepicker.min.css">

<!-- jquery Choosen -->
<link rel="stylesheet" href="<?= $theme_url.'assets/chosen/chosen.min.css'; ?>">
<link rel="stylesheet" href="<?= $theme_url.'assets/chosen/component-chosen.min.css'; ?>">

<!-- Select2 -->
<link rel="stylesheet" href="<?= $theme_url.'assets/select2/select2.min.css'; ?>">

<!-- Tagsinput -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-tagsinput/1.3.6/jquery.tagsinput.min.css">

<!-- Can be replace with app-blue, green, orange, purple, red, seagreen, pink -->
<link rel="stylesheet" id="theme-style" href="<?= $theme_url.'assets/css/app-'.(setting_item('theme.admin_color') ?? 'blue').'.css'; ?>">
<link rel="stylesheet" id="theme-style" href="<?= $theme_url.'assets/css/custom.css?v2.1'; ?>">

<!-- Toastr for toast notification -->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<!-- Custom -->
<style>
img.avatar.small {
	object-fit: cover;
	border-radius: 50%;
	height: 50px;
	width: 50px;
}

img.avatar.medium {
	object-fit: cover;
	border-radius: 50%;
	height: 60px;
	width: 60px;
}

img.avatar.large {
	object-fit: cover;
	border-radius: 50%;
	height: 80px;
	width: 80px;
}
</style>

<?= embed_entry_style(); ?>
