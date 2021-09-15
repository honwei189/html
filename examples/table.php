<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/fontawesome.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<?php
    $s = microtime(true);

    require __DIR__ . '/../vendor/autoload.php';

    $app = new honwei189\Flayer\Core;
    honwei189\Flayer\Config::load();

    use honwei189\Html\Struct\Col as col;
    use honwei189\Html\Struct\Link as link;
    use honwei189\Html\Struct\Linkgroup_menu as linkgroup_menu;
    use honwei189\Html\Struct\Text_iconlink as icon_textlink;
    use honwei189\Html\Table as table;

    $table = new table;

    $table->dataset([
        (object) [
            "id"    => 1,
            "name"  => "AAA",
            "age"   => 21,
            "email" => "aaa@example",
        ],
        (object) [
            "id"    => 2,
            "name"  => "BBB",
            "age"   => 25,
            "email" => "bbb@example",
        ],
        (object) [
            "id"    => 3,
            "name"  => "Miss. Emilia",
            "age"   => 16,
            "email" => "ccc@example",
        ],
        (object) [
            "id"    => 4,
            "name"  => "DDD",
            "age"   => 11,
            "email" => "ddd@example",
        ],
    ]);

    $table->style();
    $table->auto_typesetting_over_width_col();

    $table->colgroup([
        new class extends col
    {
            var $title        = "No.";
            public $data_name = "seq";
            public $attr      = [
                "width" => "5%",
                "class" => "nosort",
            ];
            public $width = 5;
        },
        new col("Name", new link("/action?id={{ id }}", "name")),
        new col("Age", function ($data) {
            if ($data->age >= 21) {
                return "Adult";
            } else {
                return "Child";
            }
        }, ["width" => "110%"]),
        honwei189\Html\Struct\col("Category", function ($data) {
            if ($data->age >= 21) {
                return "Adult";
            } else if ($data->age >= 12 && $data->age < 21) {
                return "Youngster";
            } else {
                return "Child";
            }
        })->width("10%"),
        (new col("Email", "email"))->width(15),
        new col("Action", new linkgroup_menu(
            new icon_textlink("/add", "Add", "fa fa-plus"),
            new icon_textlink("/edit?id={{ id }}", "Edit", "fa fa-pen"),
            new icon_textlink("/del?id={{ id }}", "Delete", "fa fa-trash")
        ), ["class" => "text-center"]),
    ]);

    $table->print();
    $table = null;

    ################################

    // use honwei189\Html\Struct\Col as col;
    use honwei189\Html\Struct\Iconlink as iconlink;
    // use honwei189\Html\Struct\Link as link;
    use honwei189\Html\Struct\Linkgroup as linkgroup;
    // use honwei189\Html\Table as table;

    $table = new table;

    $table->style();
    $table->allow_overwidth(false);

    $table->colgroup([
        new class extends col
    {
            var $title        = "No.";
            public $data_name = "seq";
            public $attr      = [
                "width" => "5%",
                "class" => "nosort",
            ];
            public $width = 5;
        },
        new col("Name", new link("/action?id={{ id }}", "name")),
        new col("Age", "age", ["width" => "110%"]),
        new col("Category", function ($data) {
            if ($data->age >= 21) {
                return "Adult";
            } else if ($data->age >= 12 && $data->age < 21) {
                return "Youngster";
            } else {
                return "Child";
            }
        }, ["width" => "10%"]),
        new col("Email", "email"),
        new col("Action", new linkgroup(
            [
                new iconlink("/add", "Add", "fa fa-plus"),
                new iconlink("/edit?id={{ id }}", "Edit", "fa fa-pen"),
                new iconlink("/del?id={{ id }}", "Delete", "fa fa-trash"),
            ]
        ), ["class" => "text-center"]),
    ]);

    $table->print();

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
