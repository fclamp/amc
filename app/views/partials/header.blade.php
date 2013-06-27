<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{ HTML::style('css/normalize.css'); }}
    {{ HTML::style('css/base.css'); }}
    {{ HTML::style('css/layout.css'); }}
    {{ HTML::style('css/modular.css'); }}
    <!--[if lt IE 9]>
	{{ HTML::script('js/respond.min.js'); }}
	<link rel="stylesheet" href="/stylesheets/am05.css" media="screen">
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	{{ HTML::style('css/ie.css'); }}
    <![endif]-->

    {{ HTML::script('js/jquery-latest.js'); }}
    <script type="text/javascript">
        $(document).ready(function() {
        	@if ($dealForm)
        	$(".form-wrap").fadeIn(200);
        	$('.explore-wrap').hide();
			@else
				$('.form-wrap').hide();
			@endif
            
            $("#search, #footer-search").click(function () {
                $(".form-wrap").fadeIn(200);
                $('.explore-wrap').hide();
            });
            $("#search2").click(function () {
                $(".form-wrap").fadeIn(200);
                $('.explore-wrap').hide();
            });
            $("#explore, #footer-explore").click(function () {
                $(".explore-wrap").fadeIn(200);
                $('.form-wrap').hide();
            });
            $("#explore2").click(function () {
                $(".explore-wrap").fadeIn(200);
                $('.form-wrap').hide();
            });

        });
    </script>
</head>