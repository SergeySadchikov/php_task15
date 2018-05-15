<?php 
session_start();
require_once 'config.php';
require_once 'autoloader.php';

$db = NEW DB();
$db->connect();

if (isset($_POST['create'])) {
	if (empty($_POST['table_name'])) {
        echo "Введите имя таблицы!";
    } else {
		$db->createTable();          
    }
}
?>

</!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<form method="POST">
		<label >Создать таблицу</label>
		<input type="text" name="table_name" placeholder="Введите имя таблицы">
		<button type="submit" name="create">создать</button>
	</form>

	<!-- список таблиц -->
	
	<form method="POST">
        <label>Выберите таблицу:</label>
        <select name="select_table">
            <?php $tables = $db->getList(); foreach ($tables as $table) : foreach ($table as $name) : ?>
            <option value="<?php echo $name ?>"><?php echo $name ?></option>
            <?php endforeach; endforeach; ?>
        </select>
        <button type="submit">Показать данные</button>
    </form>

     <?php if (isset($_POST['select_table'])) : ?>
    <h4><?php echo "Выбрана таблица ".$_POST['select_table'];?></h4>
    <table>
        <tr>
            <th>Поле</th>
            <th>Тип</th>
            <th>NULL</th>
            <th>Ключ</th>
            <th>Значение по умолчанию</th>
            <th>Дополнительно</th>
        </tr>
        <tr>
         <?php $info = $db->getInfo($_POST['select_table']);
		       foreach ($info as $fields): ?>
        <tr>
            <?php foreach ($fields as $field): ?>
            <td>
            <?php echo $field; ?>
            </td>
            <?php endforeach; ?>
        </tr>
            <?php endforeach; ?>
    </table>
    <?php endif; ?>

<?php if (isset($_POST['select_table'])) : $_SESSION['table'] = $_POST['select_table']; ?>
	<h4>Редактор</h4>

<!-- Изменить имя поля -->

	<form method="POST">
        <label>Изменить имя поля:</label>
        <select name="select_rename">
            <?php foreach ($info as $fields) : ?>
            <option value="<?php echo $fields['Field'] ?>"><?php echo $fields['Field'] ?></option>
            <?php endforeach; ?>
        </select>
        <select name="select_type">
            <?php foreach ($info as $fields) : ?>
            <option value="<?php echo $fields['Type'] ?>"><?php echo $fields['Type'] ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Выбрать</button>
    </form>
 <?php endif; ?>

<?php if (isset($_POST['select_rename'])): $_SESSION['type'] = $_POST['select_type']; $_SESSION['old_name'] = $_POST['select_rename']; ?>
	<form method="POST">
		<input type="text" name="new_name_field" placeholder="новое имя">
        <button name="ch_name"  type="submit">Выполнить</button>
   	</form>
<?php endif; ?>

<?php 
	if (isset($_POST['new_name_field'])) {
		if (isset($_POST['ch_name'])) {
			$db->renameField();
			echo "Таблица ".$_SESSION['table']." отредактирована! <a href='index.php'>Вернуться в начало</a>";
		}
	}
?>

<!-- удалить поле -->

<?php if (isset($_POST['select_table'])) : $_SESSION['table'] = $_POST['select_table']; ?>
	<form method="POST">
        <label>Удалить поле:</label>
        <select name="select_del">
            <?php foreach ($info as $fields) : ?>
            <option value="<?php echo $fields['Field'] ?>"><?php echo $fields['Field'] ?></option>
            <?php endforeach; ?>
        </select>
        <button name="delete" type="submit">Выбрать</button>
    </form>
<?php endif; ?>
<?php 
	if (isset($_POST['select_del'])) {
		if (isset($_POST['delete'])) {
			$db->deleteField();
			echo "Поле ".$_POST['select_del']." успешно удалено! <a href='index.php'>Вернуться в начало</a>";
		}
	}
?>

</body>
</html>