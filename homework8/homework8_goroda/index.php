<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
require_once 'db.php';

$query = "SELECT id, name FROM regions";
$regionsResult = $conn->query($query);
$regions = $regionsResult->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Зависимые списки</title>
    <script src="jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Выберите регион и город</h1>
    <form>
        <label for="region-select">Регион:</label>
        <select id="region-select">
            <option value="0">- выберите регион -</option>
            <?php foreach ($regions as $region): ?>
                <option value="<?= $region['id'] ?>"><?= htmlspecialchars($region['name']) ?></option>
            <?php endforeach; ?>
        </select>
        <label for="city-select" style="display: none;">Город:</label>
        <select id="city-select" style="display: none;"></select>
    </form>

    <script>
        $(function () {
            $('#region-select').change(function () {
                const regionId = $(this).val();

                if (regionId === "0") {
                    $('#city-select').hide().empty();
                    $('label[for="city-select"]').hide();
                    return;
                }

                $.ajax({
                    url: 'zabratizbazi.php',
                    method: 'GET',
                    data: { region_id: regionId },
                    dataType: 'json',
                    success: function (cities) {
                        const options = cities.map(city => `<option value="${city.id}">${city.name}</option>`);
                        options.unshift('<option value="0">- выберите город -</option>');
                        $('#city-select').html(options).show();
                        $('label[for="city-select"]').show();
                    }
                });
            });
        });
    </script>
</body>
</html>

