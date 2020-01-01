<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/fontawesome.min.css">

<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script> -->
<!-- <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous"> -->

<?php
    $s = microtime(true);

    require __DIR__ . '/../vendor/autoload.php';

    $app = new honwei189\flayer;
    honwei189\config::load();


    $html = new html;
    $html->bootstrap_style("vertical");
    $html->class("form-group");
    $html->attr(["required", "autofocus"]);
    $html->preset("textbox", ["class" => "chars_remind"]);
    $html->preset(["checkbox", "radio"], ["class" => "i-checks"]);

    $html->dataset([]);
    $html->map([
        "test" => "Testing only",
    ]);
    $html->param(["class" => "form-control"]);
    $html->preset("textbox", ["attr" => "dontknow", "attr" => "dontknow1"]);

    $html->build(
        function () use (&$html) {
            $html->use($html)->size(30)->textbox("test");
            $html->use($html)->title("sdf")->param(["class" => "i-checks"])->data(["1" => 2])->checkbox("aaa");
            $html->use($html)->size(20)->textbox("test1");
        }
    );

    $e = microtime(true);

    $sec     = $e - $s;
    $ms      = round((double) $sec * 1000, 2);
    $secPer  = round((double) (1 / $sec), 2);
    $sec     = round($sec, 4);
    $memPeak = round(memory_get_peak_usage() / 1024 / 1024, 4);
    $mem     = round(memory_get_usage() / 1024 / 1024, 4);

    if (php_sapi_name() == "cli") {
        echo PHP_EOL . "Generated Time : $ms ms , $sec sec " . PHP_EOL . "Memory Usage   : {$mem} mb (current), {$memPeak} mb (peak)" . PHP_EOL . PHP_EOL;
}
