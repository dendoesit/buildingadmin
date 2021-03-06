<?php
session_start();

require_once 'idiorm.php';

ORM::configure('mysql:host=localhost;dbname=user');
ORM::configure('username', 'root');
ORM::configure('password', '');
ORM::configure('id_column_overrides', array(
    'facturi' => array('id_locatar', 'luna', 'an') // a compound primary key
));

if ($_POST['action'] == 'addFactura') {
    $id_locatar = $_POST['id_locatar'];
    $suma = $_POST['suma'];
    $luna = $_POST['luna'];
    $an = $_POST['an'];
    $addFactura = ORM::for_table('facturi')->create();
    $addFactura->id_locatar = $id_locatar;
    $addFactura->luna = $luna;
    $addFactura->an = $an;
    $addFactura->suma = $suma;
    $addFactura -> save();

    if ($addFactura) {
        echo "gg";
    } else {
        echo "fail";
    }
    exit();

} else if ($_POST['action'] == 'getFacturiLuna') {
    $luna = $_POST['luna'];
    $an = $_POST['an'];
    $facturiLuna = ORM::forTable('facturi')->where(array('luna' => $luna, 'an' => $an))->order_by_asc('id_locatar')->find_array();
    $data['data'] = $facturiLuna;
    $data['total'] = count($facturiLuna);
    echo json_encode($data);
    exit();

} else if ($_POST['action'] == 'updateFactura') {

    $id_locatar = $_POST['id_locatar'];
    $suma = $_POST['suma'];
    $luna = $_POST['luna'];
    $an = $_POST['an'];

    $factura = ORM::forTable('facturi')->where(array('id_locatar' => $id_locatar, 'luna' => $luna, 'an' => $an))->find_one()->set(array('suma' => $suma))->save();
    echo "gg";
    exit();

} else if ($_POST['action'] == 'getFacturi') {
    $facturiTotal = ORM::for_table('facturi')->order_by_asc('id_locatar')->find_array();
    $data['data'] = $facturiTotal;
    $data['total'] = count($facturiTotal);
    echo json_encode($data);
    exit();

} else if ($_POST['action'] == 'deleteFact') {
    $id_locatar = $_POST['id_locatar'];
    $an = $_POST['an'];
    $luna = $_POST['luna'];
    ORM::forTable('facturi')->where(array('id_locatar' => $id_locatar, 'luna' => $luna, 'an' => $an))->find_one()->delete();
    exit();
} else if ($_POST['action'] == 'factUser') {
    if (isset($_SESSION['locatar_id'])) {
        $id_locatar = $_SESSION['locatar_id'];
        $facturiLuna = ORM::forTable('facturi')->where('id_locatar', $id_locatar)->find_array();
        echo json_encode($facturiLuna);
        exit();
    }
}
?>